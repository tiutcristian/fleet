<?php

//add_insurance($pdo, $car_id, $insurance_type, $details, $expiration_date)

require_once '../includes/db-setup.php';
require_once 'model.php';
$pdo = connect_db();

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