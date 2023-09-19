<?php
require_once '../includes/db-setup.php';
require_once '../includes/config-session.php';
require_once 'view.php';
require_once 'model.php';

try 
{
    delete_car($pdo, $_POST["car-id"]);
    header("Location: index.php");
    die();
}
catch (PDOException $e) 
{
    die("Query failed: " . $e->getMessage());
}