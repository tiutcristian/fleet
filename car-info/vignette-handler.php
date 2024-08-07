<?php

require_once '../includes/db-setup.php';
require_once 'model.php';
require_once '../includes/config-session.php';
$pdo = connect_db();

if ($_SERVER["REQUEST_METHOD"] != "POST")
{
    header("Location: ../"); 
    die();
}
elseif (!isset($_SESSION["user_id"]))
{
    ?>
        <h3> You are not logged in. Log in to update vignette. </h3>
    <?php
}
else
{
    try 
    {
        // Error handlers
        $errors = [];

        if (is_input_empty($_POST["country"], $_POST["vignette-expiration-date"]))
        {
            $errors["empty_input"] = "Fill in all fields!";
        }   

        if ($errors)
        {
            $_SESSION["errors_vignette"] = $errors;
            header("Location: .?id=" . $_POST["car-id"]);
            die();
        }

        add_vignette($pdo, $_POST["car-id"], $_POST["country"], $_POST["details"], $_POST["vignette-expiration-date"]);
        header("Location: .?id=" . $_POST["car-id"] . "&vignette=success");
        die();
    }
    catch (PDOException $e) 
    {
        die("Query failed: " . $e->getMessage());
    }
}

function is_input_empty($country, $exp_date)
{
    return empty($country) || empty($exp_date);
}