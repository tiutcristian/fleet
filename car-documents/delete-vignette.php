<?php

require_once '../includes/db-setup.php';
require_once 'model.php';
require_once '../includes/config-session.php';
$pdo = connect_db();

if ($_SERVER["REQUEST_METHOD"] != "POST")
{
    header("Location: ../index.php"); 
    die();
}
elseif (!isset($_SESSION["user_id"]))
{
    ?>
        <h3> You are not logged in. Log in to delete vignette. </h3>
    <?php
}
else
{
    try 
    {
        delete_vignette($pdo, $_POST["vignette-id"]);
        header("Location: index.php?id=" . $_POST["car-id"]);
        die();
    }
    catch (PDOException $e) 
    {
        die("Query failed: " . $e->getMessage());
    }
}
