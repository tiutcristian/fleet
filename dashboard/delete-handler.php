<?php
require_once '../includes/db-setup.php';
require_once '../includes/config-session.php';
require_once 'model.php';
$pdo = connect_db();

try 
{
    $path_to_image = "../" . get_image_by_car_id($pdo, $_POST["car-id"]);
    if($path_to_image != "../add-car/uploads/placeholder.png")
    {
        unlink($path_to_image);
    }
    delete_car($pdo, $_POST["car-id"], $_SESSION["user_id"], $_SESSION["user_role"]);
    header("Location: index.php");
    die();
}
catch (PDOException $e) 
{
    die("Query failed: " . $e->getMessage());
}