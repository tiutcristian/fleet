<?php

declare(strict_types=1);

function display_car_inputs (string $role)
{
    if ($role === "admin")
    {
        if(isset($_SESSION["car_data"]["username"]))
        {
            ?>
                <input type="text" name="username" id="username" placeholder="Username" 
                value="<?=$_SESSION["car_data"]["username"]?>">
            <?php
        }
        else
        {
            ?>
                <input type="text" name="username" id="username" placeholder="Username">
            <?php
        }
    }
    // "Make" input
    if(isset($_SESSION["car_data"]["make"]))
    {
        ?>
            <input type="text" name="make" id="make" placeholder="Make" 
            value="<?=$_SESSION["car_data"]["make"]?>">
        <?php
    }
    else
    {
        ?>
            <input type="text" name="make" id="make" placeholder="Make">
        <?php
    }

    // "Model" input
    if(isset($_SESSION["car_data"]["model"]))
    {
        ?>
            <input type="text" name="model" id="model" placeholder="Model" 
            value="<?=$_SESSION["car_data"]["model"]?>">
        <?php
    }
    else
    {
        ?>
            <input type="text" name="model" id="model" placeholder="Model">
        <?php
    }

    // "License plate" input
    if(isset($_SESSION["car_data"]["plate_number"])
        && !isset($_SESSION["errors_add_car"]["invalid_plate"])
        && !isset($_SESSION["errors_add_car"]["taken_plate"]))
    {
        ?>
            <input type="text" name="plate_number" id="plate_number" placeholder="License plate" 
            value="<?=$_SESSION["car_data"]["plate_number"]?>">
        <?php
    }
    else
    {
        ?>
            <input type="text" name="plate_number" id="plate_number" placeholder="License plate">
        <?php
    }
    
    // "VIN number" input
    if(isset($_SESSION["car_data"]["vin"])
        && !isset($_SESSION["errors_add_car"]["invalid_vin"])
        && !isset($_SESSION["errors_add_car"]["taken_vin"]))
    {
        ?>
            <input type="text" name="vin" id="vin" placeholder="VIN number" 
            value="<?=$_SESSION["car_data"]["vin"]?>">
        <?php
    }
    else
    {
        ?> 
            <input type="text" name="vin" id="vin" placeholder="VIN number">
        <?php
    }

    // "Image" input
    ?> 
        <label for="fileToUpload" class="custom-file-upload">Choose image to upload</label>
        <input type="file" name="fileToUpload" id="fileToUpload">
    <?php
}

function display_errors ()
{
    ?> <br> <?php
    if (isset($_SESSION['errors_add_car']))
    {
        $errors = $_SESSION['errors_add_car'];
        foreach($errors as $error) 
        {
            ?> <p class="form-error"><?=$error?></p> <?php
        }
        unset($_SESSION['errors_add_car']);
    }
    else if (isset($_GET["addcar"]) && $_GET["addcar"] === "success")
    {
        ?> <p class="form-success">Car added successfully!</p> <?php
    }
}

function display_add_car_form()
{
    if (isset($_SESSION["user_id"]))
    {
        ?>
            <h3>Add a car</h3>
            <form action="handler.php" method="post" enctype="multipart/form-data">
                <?php display_car_inputs($_SESSION["user_role"]); ?>
                <input type="submit" value="Add">
            </form>
            <?php display_errors(); ?>
            <form action="../dashboard/index.php">
                <button class="outline">Back to dashboard</button>
            </form>
        <?php
    }
    else
    {
        unset($_SESSION["errors_add_car"]);
        ?>
            <p class="error">You are not logged in. <br> Login first.</p>         
            <form action="../login/index.php" method="post">
                <input type="submit" value="Login">
            </form>
        <?php
    }
    
}