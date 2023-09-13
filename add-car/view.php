<?php

declare(strict_types=1);

function display_car_inputs ()
{

    echo '<input type="text" name="make" id="make" placeholder="Make">
          <input type="text" name="model" id="model" placeholder="Model">
          <input type="text" name="plate_number" id="plate_number" placeholder="License plate">
          <input type="text" name="vin" id="vin" placeholder="VIN number">';
    

/*
    if (isset($_SESSION["signup_data"]["username"]) && !isset($_SESSION["errors_signup"]["username_taken"]))
    {
        echo '<input type="text" name="username" placeholder="Username" value="' . $_SESSION["signup_data"]["username"] . '">';
    }
    else
    {
        echo '<input type="text" name="username" placeholder="Username">';
    }

    if (isset($_SESSION["signup_data"]["email"]) && !isset($_SESSION["errors_signup"]["email_used"]) && !isset($_SESSION["errors_signup"]["invalid_email"]))
    {
        echo '<input type="text" name="email" placeholder="Email" value="' . $_SESSION["signup_data"]["email"] . '">';
    }
    else
    {
        echo '<input type="text" name="email" placeholder="Email">';
    }

    echo '<input type="password" name="pwd" placeholder="Password">';*/
}

function display_errors ()
{
    if (isset($_SESSION['errors_add_car']))
    {
        $errors = $_SESSION['errors_add_car'];

        echo "<br>";
        foreach($errors as $error)
            echo '<p class="form-error">' . $error . '</p>';

        unset($_SESSION['errors_add_car']);
    }
    else if (isset($_GET["addcar"]) && $_GET["addcar"] === "success")
        echo '<br>
              <p class="form-success">Car added successfully!</p>';
}

function homepage_redirect_button()
{
    echo '<form action="../index.php"><button>Go to homepage</button></form>';
}

function cars_data_redirect_button()
{
    echo '<form action="../cars-data/index.php"><button>Go to cars data</button></form>';
}

function login_redirect_button()
{
    echo '<form action="../login/index.php" method="post"><input type="submit" value="Login"></form>';
}

function error_message()
{
    echo '<p class="error">You cannot add a car while being logged out.</p>
          <p class="error">Login first!</p>';
    login_redirect_button();
}

function display_add_car_form()
{
    echo '<h3>Add a car</h3>
          <br>
          <form action="handler.php" method="post">';
            display_car_inputs();
    echo    '<input type="submit" value="Add">
          </form>';
}