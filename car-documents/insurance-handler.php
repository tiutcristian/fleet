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
        if (in_array($_POST["insurance-type"], ["RCA", "CASCO", "CMR", "Road Assistance"]) == false)
        {
            die("Invalid insurance type");
        }
        $curr_insurances = get_insurances_by_car_id($pdo, $_POST["car-id"]);
        if (isset($curr_insurances[$_POST["insurance-type"]]))
        {
            die("Insurance type already exists");
        }
        add_insurance($pdo, $_POST["car-id"], $_POST["insurance-type"], $_POST["details"], $_POST["insurance-expiration-date"]);
        header("Location: index.php?id=" . $_POST["car-id"]);
        die();
    }
    catch (PDOException $e)
    {
        die("Query failed: " . $e->getMessage());
    }
}