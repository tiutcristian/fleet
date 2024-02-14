<?php
require_once '../includes/db-setup.php';
require_once 'model.php';
$pdo = connect_db();

try 
{
    update_itp($pdo, $_POST["car-id"], $_POST["itp-expiration-date"]);
    header("Location: index.php?id=" . $_POST["car-id"]);
    die();
}
catch (PDOException $e) 
{
    die("Query failed: " . $e->getMessage());
}