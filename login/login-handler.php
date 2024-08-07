<?php

require_once '../includes/db-setup.php';
require_once 'model.php';
require_once '../includes/config-session.php';

if ($_SERVER["REQUEST_METHOD"] == "POST")
{
    $pdo = connect_db();
    $username = $_POST["username"];
    $pwd = $_POST["pwd"];

    try 
    {
        // ERROR HANDLERS
        $errors = [];

        if (is_input_empty($username, $pwd))
        {
            $errors["empty_input"] = "Fill in all fields!";
        }

        $result = get_user($pdo, $username);

        if (is_username_wrong($result) || is_password_wrong($pwd, $result["pwd"]))
        {
            $errors["login_incorrect"] = "Incorrect login info!";
        }

        if ($errors)
        {
            $_SESSION["errors_login"] = $errors;

            header("Location: .");
            die();
        }

        $newSessionId = session_create_id();
        $sessionId = $newSessionId . "_" . $result["id"];
        session_id($sessionId);

        $_SESSION["user_id"] = $result["id"];
        $_SESSION["user_username"] = htmlspecialchars($result["username"]);
        $_SESSION["user_role"] = htmlspecialchars($result["role"]);

        $_SESSION["last_regeneration"] = time();
        
        header("Location: ../");
        $pdo = null;
        $stmt = null;
        die();
    } 
    catch (PDOException $e) 
    {
        die("Query failed: " . $e->getMessage());
    }
}
else
{
    header("Location: .");
    die();
}

function is_input_empty (string $username, string $pwd)
{
    return (empty($username) || empty($pwd));
}

function is_username_wrong (bool|array $result)
{
    return !$result;
}

function is_password_wrong (string $pwd, string $hashedPwd)
{
    return !password_verify($pwd, $hashedPwd);
}