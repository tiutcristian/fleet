<?php

declare(strict_types=1);

function display_image($car)
{
    $path_to_image = "../" . $car["path_to_image"];
    ?> <img src="<?=$path_to_image?>" alt="Image not found"> <?php
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
        <h3>ITP</h3> 
        <div class="flex-center-container">
            <?php 
                display_itp_date($car);
                display_itp_form($car);
            ?>
        </div>
    <?php
}

function display_itp_date($car)
{
    ?>
        <table>
            <tr>
                <th>Expiration date</th>
                <td>
                    <?php
                        if (isset($car["itp_exp_date"]))
                        {
                            $exp_date = strtotime($car["itp_exp_date"]);
                            if ($exp_date < time())
                            {
                                ?> <span style="color: red;">[Expired]</span> <?php
                            }
                            ?> <?= date('d.m.Y', $exp_date) ?> <?php
                        }
                        else
                        {
                            ?> Unset <?php
                        }
                    ?>
                </td>
            </tr>
        </table>
    <?php
}

function display_itp_form($car)
{
    ?>
        <div class="form-container">
            <form action="itp-handler.php" method="post" class="itp-update-form"> 
                <label for="itp-expiration-date">Change expiration date: </label>
                <input type="date" id="itp-expiration-date" name="itp-expiration-date">
                <input type="hidden" id="car-id" name="car-id" value="<?= $car["id"] ?>" />
                <input type="submit" value="Submit">
            </form>
            <?php display_errors_itp(); ?>
        </div>
    <?php
}

function display_errors_itp()
{
    if (isset($_SESSION['errors_itp']))
    {
        $errors = $_SESSION['errors_itp'];
        foreach($errors as $error)
        {
            ?> <p class="form-error"><?= $error ?></p> <?php
        }
        unset($_SESSION['errors_itp']);
    }
    else if (isset($_GET["itp"]) && $_GET["itp"] === "success")
    {
        ?> <p class="form-success">ITP updated successfully!</p> <?php
    }
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
    ?> 
        <h3>Vignettes</h3>
        <?php display_vignettes_table(get_vignettes_by_car_id($pdo, $car_id)); ?>
        <br>
        <?php display_vignettes_form($car_id); ?>
    <?php
}

function display_vignettes_table($vignettes)
{
    if (count($vignettes) == 0)
    {
        ?> <p> No vignettes added. </p> <?php
    }
    else
    {
        ?>
            <table>
                <tr>
                    <th>Country</th>
                    <th>Expiration Date</th>
                    <th>Details</th>
                    <th></th>
                </tr>
                <?php
                    for ($i = 0; $i < count($vignettes); $i++)
                    {
                        ?> 
                            <tr> 
                                <td><?= $vignettes[$i]["country"] ?></td>
                                <td>
                                    <?php
                                        $exp_date = strtotime($vignettes[$i]["expiration_date"]);
                                        if ($exp_date < time())
                                        {
                                            ?> <span style="color: red;">[Expired]</span> <?php
                                        }
                                        echo date('d.m.Y', $exp_date);
                                    ?>
                                </td>
                                <td><?= $vignettes[$i]["details"] ?></td>
                                <td class="button-cell">
                                    <form action="delete-vignette.php", method="post" class="delete-vignette-form">
                                        <input type="hidden" id="vignette-id" name="vignette-id" value="<?= $vignettes[$i]["id"] ?>" />
                                        <input type="hidden" id="car-id" name="car-id" value="<?= $vignettes[$i]["car_id"] ?>" />
                                        <button class="btn-small" type="submit">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        <?php
                    }
                ?>
            </table>
        <?php
    }
}

function display_vignettes_form($car_id)
{
    ?>
        <h5>Add Vignette:</h5>
        <form action="vignette-handler.php" method="post" class="add-vignette-form"> 
            <label for="country">Country: </label>
            <input type="text" id="country" name="country" placeholder="Country">
            <label for="vignette-expiration-date">Expiration date: </label>
            <input type="date" id="vignette-expiration-date" name="vignette-expiration-date">
            <label for="details">Details: </label>
            <textarea id="details" name="details" placeholder="Details"></textarea>
            <input type="hidden" id="car-id" name="car-id" value="<?= $car_id ?>" />
            <input type="submit" value="Submit">
        </form>
        <?php display_vignettes_errors(); ?>
    <?php
}

function display_vignettes_errors()
{
    if (isset($_SESSION['errors_vignette']))
    {
        $errors = $_SESSION['errors_vignette'];
        foreach($errors as $error)
        {
            ?> <p class="form-error"><?= $error ?></p> <?php
        }
        unset($_SESSION['errors_vignette']);
    }
    else if (isset($_GET["vignette"]) && $_GET["vignette"] === "success")
    {
        ?> <p class="form-success">Vignette added successfully!</p> <?php
    }
}

function display_insurances($pdo, $car_id)
{
    ?> 
        <h3>Insurances</h3>
        <?php display_insurances_table(get_insurances_by_car_id($pdo, $car_id)); ?>
        <br>
        <?php display_insurances_form($car_id); ?>
    <?php
}

function display_insurances_table($insurances)
{
    if (count($insurances) == 0)
    {
        ?> <p> No insurances added. </p> <?php
    }
    else
    {
        ?>
            <table>
                <tr>
                    <th>Insurance Type</th>
                    <th>Expiration Date</th>
                    <th>Details</th>
                    <th></th>
                </tr>
                <?php
                    foreach ($insurances as $insurance)
                    {
                        ?> 
                            <tr> 
                                <td><?= $insurance["insurance_type"] ?></td>
                                <td>
                                    <?php
                                        $exp_date = strtotime($insurance["expiration_date"]);
                                        if ($exp_date < time())
                                        {
                                            ?> <span style="color: red;">[Expired]</span> <?php
                                        }
                                        echo date('d.m.Y', $exp_date);
                                    ?>
                                </td>
                                <td><?= $insurance["details"] ?></td>
                                <td class="button-cell">
                                    <form action="delete-insurance.php", method="post" class="delete-insurance-form">
                                        <input type="hidden" id="insurance-id" name="insurance-id" value="<?= $insurance["id"] ?>" />
                                        <input type="hidden" id="car-id" name="car-id" value="<?= $insurance["car_id"] ?>" />
                                        <button class="btn-small" type="submit">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        <?php
                    }
                ?>
            </table>
        <?php
    }
}

function display_insurances_form($car_id)
{
    ?>
        <h5>Add Insurance:</h5>
        <form action="insurance-handler.php" method="post" class="add-insurance-form">
            <label for="insurance-type">Insurance type: </label>
            <select name="insurance-type" id="insurance-type">
                <option value="">-</option>
                <option value="RCA">RCA</option>
                <option value="CASCO">CASCO</option>
                <option value="CMR">CMR</option>
                <option value="Road Assistance">Road Assistance</option>
            </select>
            <label for="insurance-expiration-date">Expiration date: </label>
            <input type="date" id="insurance-expiration-date" name="insurance-expiration-date">
            <label for="details">Details: </label>
            <textarea id="details" name="details" placeholder="Details"></textarea>
            <input type="hidden" id="car-id" name="car-id" value="<?= $car_id ?>" />
            <input type="submit" value="Submit">
        </form>
        <?php display_insurances_errors(); ?>
    <?php
}

function display_insurances_errors()
{
    if (isset($_SESSION['errors_insurance']))
    {
        $errors = $_SESSION['errors_insurance'];
        ?><br><?php
        foreach($errors as $error)
        {
            ?> <p class="form-error"><?= $error ?></p> <?php
        }
        unset($_SESSION['errors_insurance']);
    }
    else if (isset($_GET["insurance"]) && $_GET["insurance"] === "success")
    {
        ?> <br> <p class="form-success">Insurance added successfully!</p> <?php
    }
}

function display_car_info(object $pdo, int $car_id, string $user_role)
{

    $car = get_car_by_id($pdo, $car_id);
    if ($user_role === "user" && $_SESSION["user_id"] != $car["user_id"]) 
    {
        ?> <h3> You are not the owner of this car. </h3> <?php
    }
    else
    {
        ?>
            <div class="center-container">
                <div class="car_info_upper_part">
                    <?php display_image($car); ?>
                    <?php display_car_details($car); ?>
                </div>
                <br><br><br>
                <div class="car_info_itp_part">
                    <?php display_itp($car); ?>
                </div>
                <br><br><br><br><br>
                <div class="car_info_vignettes_part">
                    <?php display_vignettes($pdo, $car_id); ?>
                </div>
                <br><br><br><br><br>
                <div class="car_info_insurances_part">
                    <?php display_insurances($pdo, $car_id); ?>
                </div>
            </div>
        <?php 
        $pdo = null;
    }   
}

function display_car_details($car)
{
    ?>
        <table>
            <tr>
                <th>License Plate</th>
                <td><?=$car["plate_number"]?></td>
            </tr>
            <tr>
                <th>Make</th>
                <td><?=$car["make"]?></td>
            </tr>
            <tr>
                <th>Model</th>
                <td><?=$car["model"]?></td>
            </tr>
            <tr>
                <th>VIN</th>
                <td><?=$car["vin"]?></td>
            </tr>
        </table>
    <?php
}

function display_not_logged_in()
{
    ?>
        <div class="form-container">
            <p class="error">You are not logged in. <br> Login first.</p>         
            <form action="../login/index.php" method="post">
                <input type="submit" value="Login">
            </form>
        </div>
    <?php
}