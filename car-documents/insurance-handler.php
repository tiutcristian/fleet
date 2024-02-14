<?php

//add_insurance($pdo, $car_id, $insurance_type, $details, $expiration_date)

require_once '../includes/db-setup.php';
require_once 'model.php';
$pdo = connect_db();

try 
{
    add_insurance($pdo, $_POST["car-id"], $_POST["insurance-type"], $_POST["details"], $_POST["insurance-expiration-date"]);
    header("Location: index.php?id=" . $_POST["car-id"]);
    die();
}
catch (PDOException $e)
{
    die("Query failed: " . $e->getMessage());
}