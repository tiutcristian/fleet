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
        <h3> You are not logged in. Log in to update vignette. </h3>
    <?php
}
else
{
    try 
    {
        add_vignette($pdo, $_POST["car-id"], $_POST["country"], $_POST["details"], $_POST["vignette-expiration-date"]);
        header("Location: index.php?id=" . $_POST["car-id"]);
        die();
    }
    catch (PDOException $e) 
    {
        die("Query failed: " . $e->getMessage());
    }
}