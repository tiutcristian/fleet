<?php

try 
{
    require_once '../includes/db-setup.php';
    require_once '../includes/config-session.php';
    require_once 'model.php';
    require_once 'view.php';
    require_once 'controller.php';

    if(isset($_SESSION["user_id"]))
    {
        cars_data_table($pdo, $_SESSION["user_username"]);
        add_car_button();
    }
    else
    {
        error_message();
    }
    homepage_redirect_button();
} 
catch (PDOException $e) 
{
    die("Query failed: " . $e->getMessage());
}