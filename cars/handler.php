<?php

try 
{
    require_once '../includes/db-setup.php';
    require_once '../includes/config-session.php';
    require_once 'model.php';
    require_once 'view.php';
    require_once 'controller.php';

    if(isset($_SESSION["user_id"]))
        display_user_cars($pdo, $_SESSION["user_username"]);
    else
    {
        display_error_message();
    }
} 
catch (PDOException $e) 
{
    die("Query failed: " . $e->getMessage());
}