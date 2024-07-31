<?php

declare(strict_types=1);

function signup_inputs ()
{
    if (isset($_SESSION["signup_data"]["username"]) && !isset($_SESSION["errors_signup"]["username_taken"]))
    {
        ?> <input type="text" name="username" placeholder="Username" value="<?= $_SESSION["signup_data"]["username"] ?>"> <br> <?php
    }
    else
    {
        ?> <input type="text" name="username" placeholder="Username"> <br> <?php
    }

    if (isset($_SESSION["signup_data"]["email"]) && !isset($_SESSION["errors_signup"]["email_used"]) && !isset($_SESSION["errors_signup"]["invalid_email"]))
    {
        ?> <input type="email" name="email" placeholder="Email" value="<?= $_SESSION["signup_data"]["email"] ?>"> <br> <?php
    }
    else
    {
        ?> <input type="email" name="email" placeholder="Email"> <br> <?php
    }
    ?> <input type="password" name="pwd" placeholder="Password"> <br> <?php
}

function display_signup_errors ()
{
    if (isset($_SESSION['errors_signup']))
    {
        $errors = $_SESSION['errors_signup'];
        ?> <br> <?php
        foreach($errors as $error)
        {
            ?> <p class="form-error"><?= $error ?></p> <?php
        }
        unset($_SESSION['errors_signup']);
    }
    else if (isset($_GET["signup"]) && $_GET["signup"] === "success")
    {
        ?> <br> <p class="form-succes">Signup success!</p> <?php
    }
}

function display_singup_form()
{
    if ($_SERVER["REQUEST_METHOD"] == "POST" || !isset($_SESSION["user_id"]))
    {
        ?>
            <h3>Signup</h3>
            <br>
            <form action="handler.php" method="post">
                <?php signup_inputs(); ?>
                <input type="submit" value="Signup">
            </form>
            <?php display_signup_errors(); ?>
            <br><br><br>
            <form action="../index.php">
                <button class="outline">Go to homepage</button>
            </form>
        <?php
    }
    else
    {
        ?>
            <p class="error">You cannot access signup page while being logged in.</p>
            <form action="../login/logout-handler.php" method="post">
                <input type="submit" value="Logout">
            </form>
        <?php
    }
}

