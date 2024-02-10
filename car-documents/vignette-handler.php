<?php

//add_vignette(object $pdo, $car_id, $country, $details, $expiration_date)

require_once '../includes/db-setup.php';
require_once 'model.php';
$pdo = connect_db();

try 
{
    add_vignette($pdo, $_POST["car-id"], $_POST["country"], $_POST["details"], $_POST["expiration-date"]);
    header("Location: index.php?id=" . $_POST["car-id"]);
    die();
}
catch (PDOException $e) 
{
    die("Query failed: " . $e->getMessage());
}