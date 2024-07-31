<?php

function display_page_content($pdo)
{
    try 
    {
        if(isset($_SESSION["user_id"]))
        {
            ?>
                <div class="tools-buttons">
                    <form action="../add-car/index.php" method="post">
                        <button>Add a car</button>
                    </form>
                    <form action="../index.php" method="post">
                        <button class="outline">Go to homepage</button>
                    </form>
                </div>
            <?php
            display_cars_table($pdo, $_SESSION["user_username"], $_SESSION["user_role"]);
        }
        else
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
    } 
    catch (PDOException $e) 
    {
        die("Query failed: " . $e->getMessage());
    }
    display_delete_pop_up(); 
}

function display_cars_table (object $pdo, string $username, string $role)
{
    if($role == "admin")
    {
        $result = get_all_cars($pdo);
    }
    else
    {
        $result = get_user_cars($pdo, $username);
    }

    if($result)
    {
        ?>
            <table role="grid">
                <?php display_table_data($role, $result); ?>
            </table>
        <?php
    }
    else
    {
        ?> <h3>No cars added</h3> <?php
    }   
}

function display_table_data($role, $result)
{
    display_table_header($role);
        
    ?> <tbody> <?php
    foreach ($result as $car) 
    {
        display_car_row($car, $role);
    }
    ?> </tbody> <?php
}

function display_table_header($role)
{
    ?>
        <thead>
            <tr>
                <th>Car image</th>
                <?php if($role == "admin") { ?> <th>Owner</th> <?php } ?>
                <th>Make</th>
                <th>Model</th>
                <th>VIN Number</th>
                <th>License plate</th>
                <th></th>
            </tr>
        </thead>
    <?php
}

function display_car_row($car, $role)
{
    ?>
        <tr>
            <!-- <td>image of the car</td> -->
            <td class="car-img-cell"><img src="../<?=$car["path_to_image"]?>" alt="car"></td>
            <?php if($role == "admin") { ?> <td><?= $car["username"] ?></td> <?php } ?>
            <td><?= $car["make"] ?></td>
            <td><?= $car["model"] ?></td>
            <td><?= $car["vin"] ?></td>
            <td><?= $car["plate_number"] ?></td>
            <td class="table-buttons">
                <button class="btn-small" onclick="onDelete('<?= $car["plate_number"] ?>', <?= $car["id"] ?>)">
                    <i class="fa fa-trash"></i>
                </button>
                <button class="btn-small" onclick="redirectToCarDocuments(<?= $car["id"] ?>)">
                    <i class="fa fa-eye"></i>
                </button>             
            </td>
        </tr>
    <?php
}

function display_delete_pop_up()
{
    ?>
        <div id="pop-up-container">
            <div class="pop-up">
                <div>Are you sure you want to delete <span id="plate-number-container"></span></div>
                <br>
                <div class="center-container">
                    <button id="yes-button">Yes</button>
                    <form action="delete-handler.php" method="post" id="delete-car-form" style="display:none;">
                        <input type="text" name="car-id" id="car-id">
                    </form>
                    <button onclick="hidePopUp()">No</button>
                </div>
            </div>
        </div> 
    <?php
}