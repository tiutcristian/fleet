<?php

require_once '../includes/db-setup.php';
require_once 'model.php';
$pdo = connect_db();

try 
{
    delete_insurance($pdo, $_POST["insurance-id"]);
    header("Location: index.php?id=" . $_POST["car-id"]);
    die();
}
catch (PDOException $e) 
{
    die("Query failed: " . $e->getMessage());
}