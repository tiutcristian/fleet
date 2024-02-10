<?php

declare(strict_types=1);

/**
    ITP 
        *expiration date
        if isset(itp)
            display date
        else
            display date input


    vignettes
        if isset(vignettes)
            display list of vignettes
        display add vignette form
            *country
            *expiration_date
            *details (optional)
        

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

function display_car_documents($pdo, int $car_id)
{
    $car = get_car_by_id($pdo, $car_id);
    $vignettes = get_vignettes_by_car_id($pdo, $car_id);

    ?>
        <ul>
            <li><h3>VIN Number: <?= $car["vin"] ?> </h3></li>
            <li><h3>License Plate: <?= $car["plate_number"] ?> </h3></li>

            <br><br><br>
    <?php
            /*<li><h3>Vignettes: <?= $car["id"] ?> </h3></li>*/
            for ($i = 0; $i < count($vignettes); $i++)
            {
                ?>
                    <li><h3>Vignette <?= $i + 1 ?>: <?= $vignettes[$i]["country"] ?> </h3></li>
                    <li><h3>Expiration Date: <?= $vignettes[$i]["expiration_date"] ?> </h3></li>
                    <li><h3>Details: <?= $vignettes[$i]["details"] ?> </h3></li>
                    <br><br><br>
                <?php
            }
            /*<li><h3>ITP: <?= $car["id"] ?> </h3></li>
            <li><h3>Insurances: <?= $car["id"] ?> </h3></li>*/
    ?>
            <br><br><br>

            
        </ul>
    <?php

    $pdo = null;
}