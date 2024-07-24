<?php

function cars_data_table (object $pdo, string $username)
{
    $result = get_user_cars($pdo, $username);
    if($result)
    {
        ?>
        <div>
            <table>
                <tr>
                    <th>Nr. Crt.</th>
                    <th>Make</th>
                    <th>Model</th>
                    <th>VIN Number</th>
                    <th>License plate</th>
                    <th></th>
                </tr>
        <?php
        $count = 0;
        foreach ($result as $car) 
        {
            $count++;
            ?>
                <tr>
                    <td><?= $count ?></td>
                    <td><?= $car["make"] ?></td>
                    <td><?= $car["model"] ?></td>
                    <td><?= $car["vin"] ?></td>
                    <td><?= $car["plate_number"] ?></td>
                    <td class="btn-column">
                        <button class="icon-btn" onclick="onDelete('<?= $car["plate_number"] ?>', <?= $car["id"] ?>)">
                            <i class="fa fa-trash"></i>
                        </button>
                        <a href="../car-documents/index.php?id=<?= $car["id"] ?>">
                            <button class="icon-btn">
                                <i class="fa fa-eye"></i>
                            </button>
                        </a>                        
                    </td>
                </tr>
            <?php
        }
        ?>
            </table>
        </div>
        <?php
    }
    else
    {
        ?>
            <h3>No cars added</h3>
        <?php
    }   
}

function display_login_redirect_button()
{
    ?>
        <form action="../login/index.php" method="post">
            <input type="submit" value="Login">
        </form>
    <?php
}

function error_message()
{
    ?>
        <p class="error">You cannot access cars page while being logged out.</p>
        <p class="error">Login first!</p>
    <?php
    display_login_redirect_button();
}

function add_car_button()
{
    ?>
        <div class="center-container">
            <form action="../add-car/index.php">
                <button>Add a car</button>
            </form>
        </div>
    <?php
}

function homepage_redirect_button()
{
    ?>
        <div class="center-container">
            <form action="../index.php">
                <button>Go to homepage</button>
            </form>
        </div>
    <?php
}

function display_delete_pop_up()
{
    ?>
        <div id="pop-up-container">
            <div class="pop-up">
                <div>Are you sure you want to delete <span id="plate-number-container"></span></div>
                <button id="yes-button">Yes</button>
                <form action="delete-handler.php" method="post" id="delete-car-form" style="display:none;">
                    <input type="text" name="car-id" id="car-id">
                </form>
                <button onclick="hidePopUp()">No</button>
            </div>
        </div> 
    <?php
}

function display_cars_data($pdo)
{
    try 
        {
            if(isset($_SESSION["user_id"]))
            {
                cars_data_table($pdo, $_SESSION["user_username"]);
                add_car_button();
                homepage_redirect_button();
            }
            else
            {
                error_message();
            }
        } 
        catch (PDOException $e) 
        {
            die("Query failed: " . $e->getMessage());
        }
        display_delete_pop_up(); 
}