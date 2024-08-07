<?php
require_once '../includes/db-setup.php';
require_once 'model.php';
require_once '../includes/config-session.php';
$pdo = connect_db();

if ($_SERVER["REQUEST_METHOD"] != "POST")
{
    header("Location: ../"); 
    die();
}
elseif (!isset($_SESSION["user_id"]))
{
    ?>
        <h3> You are not logged in. Log in to update ITP. </h3>
    <?php
}
else
{
    try 
    {
        // ERROR HANDLERS
        $errors = [];
        if (empty($_POST["itp-expiration-date"]))
        {
            $errors["date_empty"] = "Fill in expiration date!";
        }

        if ($errors)
        {
            $_SESSION["errors_itp"] = $errors;
            header("Location: index.php?id=" . $_POST["car-id"]);
            die();
        }

        update_itp($pdo, $_POST["car-id"], $_POST["itp-expiration-date"]);
        header("Location: index.php?id=" . $_POST["car-id"] . "&itp=success");
        die();
    }
    catch (PDOException $e)
    {
        die("Query failed: " . $e->getMessage());
    }
}