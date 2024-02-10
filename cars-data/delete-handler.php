<?php
require_once '../includes/db-setup.php';
require_once '../includes/config-session.php';
require_once 'model.php';
$pdo = connect_db();

try 
{
    delete_car($pdo, $_POST["car-id"], $_SESSION["user_id"]);
    header("Location: index.php");
    die();
}
catch (PDOException $e) 
{
    die("Query failed: " . $e->getMessage());
}