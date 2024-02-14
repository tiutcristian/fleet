<?php

declare(strict_types=1);

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
            <h3> Expiration Date: <?= date('d.m.Y', $exp_date) ?> </h3>
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
            <label for="itp-expiration-date">Expiration date: </label>
            <br>
            <input type="date" id="itp-expiration-date" name="itp-expiration-date">
            <br>
            <input type="hidden" id="car-id" name="car-id" value="<?= $car["id"] ?>" />
            <input type="submit" value="Submit">
        </form>
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

    echo '<h3>Vignettes:</h3>';
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
    }

    ?>
        <form action="vignette-handler.php" method="post"> 
            <input type="text" id="country" name="country" placeholder="Country">
            <br>
            <label for="vignette-expiration-date">Expiration date: </label>
            <br>
            <input type="date" id="vignette-expiration-date" name="vignette-expiration-date">
            <br>
            <input type="text" id="details" name="details" placeholder="Details">
            <br>
            <input type="hidden" id="car-id" name="car-id" value="<?= $car_id ?>" />
            <input type="submit" value="Submit">
        </form>
    <?php
}

/**
    insurances
        * RCA
        if isset(RCA)
            display RCA

        * CASCO
        if isset(CASCO)
            display CASCO

        * CMR
        if isset(CMR)
            display CMR

        * Road Assistance
        if isset(Road Assistance)
            display Road Assistance
        
        *expiration_date
        *details (optional)
*/
function display_insurances($pdo, $car_id)
{
    $insurances = get_insurances_by_car_id($pdo, $car_id);
    if (count($insurances) == 0)
    {
        echo '<h3> No insurances found. Add one below: </h3>';
    }
    else
    {
        if (isset($insurances["RCA"]))
        {
            ?>
                <h3>RCA:</h3>
                <br>
                <h3>Expiration Date: <?= $insurances["RCA"]["expiration_date"] ?> </h3>
                <br>
            <?php
        }

        if (isset($insurances["CASCO"]))
        {
            ?>
                <h3>CASCO:</h3>
                <br>
                <h3>Expiration Date: <?= $insurances["CASCO"]["expiration_date"] ?> </h3>
                <br>
            <?php
        }

        if (isset($insurances["CMR"]))
        {
            ?>
                <h3>CMR:</h3>
                <br>
                <h3>Expiration Date: <?= $insurances["CMR"]["expiration_date"] ?> </h3>
                <br>
            <?php
        }

        if (isset($insurances["Road Assistance"]))
        {
            ?>
                <h3>Road Assistance:</h3>
                <br>
                <h3>Expiration Date: <?= $insurances["Road Assistance"]["expiration_date"] ?> </h3>
                <br>
            <?php
        }
    }
    ?>
        <form action="insurance-handler.php" method="post">
            <label for="insurance-type">Insurance type: </label>
            <br>
            <select name="insurance-type" id="insurance-type">
                <option value="">-</option>
                <option value="RCA">RCA</option>
                <option value="CASCO">CASCO</option>
                <option value="CMR">CMR</option>
                <option value="Road Assistance">Road Assistance</option>
            </select>
            <br>
            <label for="insurance-expiration-date">Expiration date: </label>
            <br>
            <input type="date" id="insurance-expiration-date" name="insurance-expiration-date">
            <br>
            <input type="text" id="details" name="details" placeholder="Details">
            <br>
            <input type="hidden" id="car-id" name="car-id" value="<?= $car_id ?>" />
            <input type="submit" value="Submit">
        </form>
    <?php
}

function display_car_documents(object $pdo, int $car_id)
{
    $car = get_car_by_id($pdo, $car_id);
    ?>
        <h3>VIN Number: <?= $car["vin"] ?> </h3>
        <h3>License Plate: <?= $car["plate_number"] ?> </h3>
    <?php
    echo '<br><br><br>';
    display_itp($car);
    echo '<br><br><br>';
    display_vignettes($pdo, $car_id);
    echo '<br><br><br>';
    display_insurances($pdo, $car_id);
    echo '<br><br><br>';
    $pdo = null;
}