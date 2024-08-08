<?php

declare(strict_types=1);

function signup_inputs ()
{
    if (isset($_SESSION["signup_data"]["username"]) && !isset($_SESSION["errors_signup"]["username_taken"]))
    {
        ?> <input type="text" name="username" placeholder="Username" value="<?= $_SESSION["signup_data"]["username"] ?>"> <?php
    }
    else
    {
        ?> <input type="text" name="username" placeholder="Username"> <?php
    }

    if (isset($_SESSION["signup_data"]["email"]) && !isset($_SESSION["errors_signup"]["email_used"]) && !isset($_SESSION["errors_signup"]["invalid_email"]))
    {
        ?> <input type="email" name="email" placeholder="Email" value="<?= $_SESSION["signup_data"]["email"] ?>"> <?php
    }
    else
    {
        ?> <input type="email" name="email" placeholder="Email"> <?php
    }
    ?> <input type="password" name="pwd" placeholder="Password"> <?php
}

function display_signup_errors ()
{
    if (isset($_SESSION['errors_signup']))
    {
        $errors = $_SESSION['errors_signup'];
        foreach($errors as $error)
        {
            ?> <p class="form-error"><?= $error ?></p> <?php
        }
        unset($_SESSION['errors_signup']);
    }
    else if (isset($_GET["signup"]) && $_GET["signup"] === "success")
    {
        ?> <p class="form-succes">Signup success!</p> <?php
    }
}

function display_singup_form()
{
    if ($_SERVER["REQUEST_METHOD"] == "POST" || !isset($_SESSION["user_id"]))
    {
        ?>
            <h3>Signup</h3>
            <form action="handler.php" method="post">
                <?php signup_inputs(); ?>
                <input type="submit" value="Signup">
            </form>
        <?php 
        display_signup_errors(); 
        button_link("Go to homepage", "../", "outline"); 
    }
    else
    {
        ?>
            <p class="error">You cannot access signup page while being logged in.</p>
            <?php button_link("Logout", "../login/logout-handler.php", ""); ?>
        <?php
    }
}

