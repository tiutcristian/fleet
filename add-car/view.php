<?php

declare(strict_types=1);

function display_car_inputs ()
{
    // "Make" input
    if(isset($_SESSION["car_data"]["make"]))
    {
        ?>
            <input type="text" name="make" id="make" placeholder="Make" 
            value="<?=$_SESSION["car_data"]["make"]?>"> <br>
        <?php
    }
    else
    {
        ?>
            <input type="text" name="make" id="make" placeholder="Make"> <br>
        <?php
    }

    // "Model" input
    if(isset($_SESSION["car_data"]["model"]))
    {
        ?>
            <input type="text" name="model" id="model" placeholder="Model" 
            value="<?=$_SESSION["car_data"]["model"]?>"> <br>
        <?php
    }
    else
    {
        ?>
            <input type="text" name="model" id="model" placeholder="Model"> <br>
        <?php
    }

    // "License plate" input
    if(isset($_SESSION["car_data"]["plate_number"])
        && !isset($_SESSION["errors_add_car"]["invalid_plate"])
        && !isset($_SESSION["errors_add_car"]["taken_plate"]))
    {
        ?>
            <input type="text" name="plate_number" id="plate_number" placeholder="License plate" 
            value="<?=$_SESSION["car_data"]["plate_number"]?>"> <br>
        <?php
    }
    else
    {
        ?>
            <input type="text" name="plate_number" id="plate_number" placeholder="License plate"> <br>
        <?php
    }
    
    // "VIN number" input
    if(isset($_SESSION["car_data"]["vin"])
        && !isset($_SESSION["errors_add_car"]["invalid_vin"])
        && !isset($_SESSION["errors_add_car"]["taken_vin"]))
    {
        ?>
            <input type="text" name="vin" id="vin" placeholder="VIN number" 
            value="<?=$_SESSION["car_data"]["vin"]?>"> <br>
        <?php
    }
    else
    {
        ?> 
            <input type="text" name="vin" id="vin" placeholder="VIN number"> <br>
        <?php
    }

    ?>
        Select image to upload:
        <input type="file" name="fileToUpload" id="fileToUpload"> <br>
    <?php
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
    ?>
        <form action="../index.php">
            <button>Go to homepage</button>
        </form>
    <?php
}

function cars_data_redirect_button()
{
    ?>
        <form action="../cars-data/index.php">
            <button>Go to cars data</button>
        </form>
    <?php
}

function error_message()
{
    unset($_SESSION["errors_add_car"]);
    ?>
        <p class="error">You are not logged in. Log in to add a car.</p>
        <p class="error">Login first!</p>
        <form action="../login/index.php" method="post">
            <input type="submit" value="Login">
        </form>
    <?php
}

function display_add_car_form()
{
    ?>
    <h3>Add a car</h3> <br>
        <form action="handler.php" method="post" enctype="multipart/form-data">
            <?php display_car_inputs(); ?>
            <input type="submit" value="Add">
        </form>
    <?php
}