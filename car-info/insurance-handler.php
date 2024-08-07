<?php

require_once '../includes/db-setup.php';
require_once 'model.php';
require_once '../includes/config-session.php';
$pdo = connect_db();

if ($_SERVER["REQUEST_METHOD"] != "POST")
{
    header("Location: ../index.php"); 
    die();
}
elseif (!isset($_SESSION["user_id"]))
{
    ?>
        <h3> You are not logged in. Log in to update insurance. </h3>
    <?php
}
else
{
    try
    {
        // Error handlers
        $errors = [];

        if (in_array($_POST["insurance-type"], ["RCA", "CASCO", "CMR", "Road Assistance"]) == false)
        {
            $errors["invalid_insurance_type"] = "Invalid insurance type!";
        }
        if (is_input_empty($_POST["insurance-type"], $_POST["insurance-expiration-date"]))
        {
            $errors["empty_input"] = "Fill in all fields!";
        }

        if ($errors)
        {
            $_SESSION["errors_insurance"] = $errors;
            header("Location: index.php?id=" . $_POST["car-id"]);
            die();
        }

        if (insurance_type_exists($_POST["insurance-type"], $pdo, $_POST["car-id"]))
        {
            $insurance = get_insurance_by_car_id_and_type($pdo, $_POST["car-id"], $_POST["insurance-type"]);
            delete_insurance($pdo, $insurance["id"]);
        }
        
        add_insurance($pdo, $_POST["car-id"], $_POST["insurance-type"], $_POST["details"], $_POST["insurance-expiration-date"]);
        header("Location: index.php?id=" . $_POST["car-id"] . "&insurance=success");
        die();
    }
    catch (PDOException $e)
    {
        die("Query failed: " . $e->getMessage());
    }
}

function is_input_empty($ins_type, $exp_date)
{
    return empty($ins_type) || empty($exp_date);
}

function insurance_type_exists($ins_type, $pdo, $car_id)
{
    $insurances = get_insurances_by_car_id($pdo, $car_id);
    return isset($insurances[$ins_type]);
}