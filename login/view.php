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
            <br>
            <form action="login-handler.php" method="post">
                <input type="text" name="username" placeholder="Username">
                <br>
                <input type="password" name="pwd" placeholder="Password">
                <br>
                <input type="submit" value="Login">
            </form>
            <?php show_login_errors(); ?>
            <br><br><br>
            <form action="../index.php">
                <button class="outline">Go to homepage</button>
            </form>
        <?php 
    }
    else 
    { 
        ?>
            <p class="error">You cannot access login page while being logged in.</p>
            <form action="../login/logout-handler.php" method="post">
                <input type="submit" value="Logout">
            </form>
        <?php 
    } 
}
