<?php

declare(strict_types=1);

function display_car_inputs ()
{
    // "Make" input
    echo '<input type="text" name="make" id="make" placeholder="Make" 
        value="'.$_SESSION["car_data"]["make"].'">';

    // "Model" input
    echo '<input type="text" name="model" id="model" placeholder="Model" 
        value="'.$_SESSION["car_data"]["model"].'">';

    // "License plate" input
    if(isset($_SESSION["car_data"]["plate_number"]) 
        && !isset($_SESSION["errors_add_car"]["invalid_plate"])
        && !isset($_SESSION["errors_add_car"]["taken_plate"]))
    {
        echo '<input type="text" name="plate_number" id="plate_number" placeholder="License plate" 
            value="'.$_SESSION["car_data"]["plate_number"].'">';
    }
    else
        echo '<input type="text" name="plate_number" id="plate_number" placeholder="License plate">';
    
    // "VIN number" input
    if(isset($_SESSION["car_data"]["vin"]) 
        && !isset($_SESSION["errors_add_car"]["invalid_vin"])
        && !isset($_SESSION["errors_add_car"]["taken_vin"]))
    {
        echo '<input type="text" name="vin" id="vin" placeholder="VIN number" 
            value="'.$_SESSION["car_data"]["vin"].'">';
    }
    else
        echo '<input type="text" name="vin" id="vin" placeholder="VIN number">';
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