<?php

declare(strict_types=1);

function signup_inputs ()
{
    if (isset($_SESSION["signup_data"]["username"]) && !isset($_SESSION["errors_signup"]["username_taken"]))
    {
        ?>
            <input type="text" name="username" placeholder="Username" value="<?= $_SESSION["signup_data"]["username"] ?>">
            <br>
        <?php
    }
    else
    {
        ?>
            <input type="text" name="username" placeholder="Username">
            <br>
        <?php
    }

    if (isset($_SESSION["signup_data"]["email"]) && !isset($_SESSION["errors_signup"]["email_used"]) && !isset($_SESSION["errors_signup"]["invalid_email"]))
    {
        ?>
            <input type="text" name="email" placeholder="Email" value="<?= $_SESSION["signup_data"]["email"] ?>">
            <br>
        <?php
    }
    else
    {
        ?>
            <input type="text" name="email" placeholder="Email">
            <br>
        <?php
    }

    ?>
        <input type="password" name="pwd" placeholder="Password">
        <br>
    <?php
}

function display_signup_errors ()
{
    if (isset($_SESSION['errors_signup']))
    {
        $errors = $_SESSION['errors_signup'];

        echo '<br>';

        foreach($errors as $error)
        {
            ?>
                <p class="form-error"><?= $error ?></p>
            <?php
        }

        unset($_SESSION['errors_signup']);
    }
    else if (isset($_GET["signup"]) && $_GET["signup"] === "success")
    {
        ?>
            <br>
            <p class="form-succes">Signup success!</p>
        <?php
    }
}

