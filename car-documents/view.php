<?php

declare(strict_types=1);

function display_VIN($car)
{
    ?>
        <h3>VIN Number: <?= $car["vin"] ?> </h3>
        <br><br><br>
    <?php
}

function display_license_plate($car)
{
    ?>
        <h3>License Plate: <?= $car["plate_number"] ?> </h3>
        <br><br><br>
    <?php
}

/**
    ITP 
        *expiration date
        if isset(itp)
            display date
        else
            display date input
*/
function display_itp($car)
{
    ?>
        <h3>ITP expiration date:</h3>
    <?php
    if (isset($car["itp_exp_date"]))
    {
        // handle isset:
        $exp_date = strtotime($car["itp_exp_date"]);
        if ($exp_date < time())
        {
            ?>
                <h3 style="color: red;">[Expired]</h3>
            <?php
        }
        ?>
            <h3>Expiration Date: <?= date('d.m.Y', $exp_date) ?> </h3>
            <br>
            <h3> Change expiration date below: </h3>
        <?php
    }
    else
    {
        // handle not isset:
        ?>
            <h3> No expiration date set. Set one below: </h3>
        <?php
    }

    ?>
        <form action="itp-handler.php" method="post"> 
            <input type="date" id="expiration_date" name="expiration_date">
            <input type="hidden" id="car-id" name="car-id" value="<?= $car["id"] ?>" />
            <input type="submit" value="Submit">
        </form>
        <br><br><br>
    <?php
}


/**
    vignettes
        if isset(vignettes)
            display list of vignettes
        display add vignette form
            *country
            *expiration_date
            *details (optional)
*/
function display_vignettes($pdo, $car_id)
{
    $vignettes = get_vignettes_by_car_id($pdo, $car_id);

    echo '<h3>Vignettes:</h3> <br>';
    if (count($vignettes) == 0)
    {
        echo '<h3> No vignettes found. Add one below: </h3>';
    }
    else
    {
        for ($i = 0; $i < count($vignettes); $i++)
        {
            ?>
                <h3>Vignette <?= $i + 1 ?>: <?= $vignettes[$i]["country"] ?> </h3>
                <h3>Expiration Date: <?= $vignettes[$i]["expiration_date"] ?> </h3>
            <?php
            if ($vignettes[$i]["details"] != "")
            {
                ?>
                    <h3>Details: <?= $vignettes[$i]["details"] ?> </h3>
                <?php
            }
            echo '<br>';
        }
        
        echo '<br><br><br>';
    }

    ?>
        <form action="vignette-handler.php" method="post"> 
            <input type="text" id="country" name="country" placeholder="Country">
            <br>
            <label for="expiration-date">Expiration date</label>
            <br>
            <input type="date" id="expiration-date" name="expiration-date">
            <input type="text" id="details" name="details" placeholder="Details">
            <input type="hidden" id="car-id" name="car-id" value="<?= $car_id ?>" />
            <input type="submit" value="Submit">
        </form>
        <br><br><br>
    <?php
}

/**
    insurances
        * RCA
        if isset(RCA)
            display RCA
        else
            display RCA input
                *expiration_date
                *details (optional)

        * CASCO
        if isset(CASCO)
            display CASCO
        else
            display CASCO input
                *expiration_date
                *details (optional)

        * CMR
        if isset(CMR)
            display CMR
        else
            display CMR input
                *expiration_date
                *details (optional)

        * Road Assistance
        if isset(Road Assistance)
            display Road Assistance
        else
            display Road Assistance input
                *expiration_date
                *details (optional)
*/

function display_car_documents(object $pdo, int $car_id)
{
    $car = get_car_by_id($pdo, $car_id);
    
    display_VIN($car);
    display_license_plate($car);
    display_itp($car);
    display_vignettes($pdo, $car_id);
    
    $pdo = null;
}