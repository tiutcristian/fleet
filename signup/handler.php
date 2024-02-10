<?php
require_once '../includes/config-session.php';
require_once '../includes/db-setup.php';
require_once 'model.php';


if ($_SERVER["REQUEST_METHOD"] == "POST") 
{
    $pdo = connect_db();

    $username = $_POST["username"];
    $pwd = $_POST["pwd"];
    $email = $_POST["email"];

    try 
    {
        // ERROR HANDLERS
        $errors = [];

        if (is_input_empty($username, $pwd, $email))
        {
            $errors["empty_input"] = "Fill in all fields!";
        }
        if (is_email_invalid ($email))
        {
            $errors["invalid_email"] = "Invalid email used!";
        }
        if (is_username_taken ($pdo, $username))
        {
            $errors["username_taken"] = "Username already taken!";
        }
        if (is_email_registered ($pdo, $email))
        {
            $errors["email_used"] = "Email already registered!";
        }

        if ($errors)
        {
            $_SESSION["errors_signup"] = $errors;

            $signupData = [
                "username" => $username,
                "email" => $email
            ];
            $_SESSION["signup_data"] = $signupData;

            header("Location: index.php");
            die();
        }

        create_user($pdo, $username, $pwd, $email);

        unset($_SESSION["signup_data"]);
        header("Location: index.php?signup=success");
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
    header("Location: ../index.php");
    die();
}

function is_input_empty(string $username, string $pwd, string $email)
{
    return empty($username) || empty($pwd) || empty($email);
}

function is_email_invalid(string $email)
{
    return !filter_var($email, FILTER_VALIDATE_EMAIL, FILTER_FLAG_EMAIL_UNICODE);
}

function is_username_taken(object $pdo, string $username)
{
    return get_username($pdo, $username);
}

function is_email_registered(object $pdo, string $email)
{
    return get_email($pdo, $email);
}