<?php

declare(strict_types=1);

function show_login_errors()
{
    if (isset($_SESSION["errors_login"]))
    {
        $errors = $_SESSION["errors_login"];

        echo "<br>";

        foreach ($errors as $error) 
        {
            echo '<p class="form-error">' . $error . '</p>';
        }

        unset($_SESSION["errors_login"]);
    }
    else if(isset($_GET['login']) && $_GET['login'] === "success")
    {
        echo '<br>';
        echo '<p class="form-success">Login success!</p>';
    }
}

function display_login_form()
{
    if (!isset($_SESSION["user_id"])) 
    { 
        ?>
            <h3>Login</h3>
            <form action="login-handler.php" method="post">
                <input type="text" name="username" placeholder="Username">
                <input type="password" name="pwd" placeholder="Password">
                <input type="submit" value="Login">
            </form>
            <?php show_login_errors(); ?>
            <?php button_link("Go to homepage", "../", "outline"); ?>
        <?php 
    }
    else 
    { 
        ?>
            <p class="error">You cannot access login page while being logged in.</p>
            <?php button_link("Logout", "../login/logout-handler.php", ""); ?>
        <?php 
    } 
}
