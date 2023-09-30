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