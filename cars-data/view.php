<?php

function cars_data_table (object $pdo, string $username)
{
    $result = get_user_cars($pdo, $username);
    echo '<table>
            <tr>
                <th>Nr. Crt.</th>
                <th>Make</th>
                <th>Model</th>
                <th>VIN Number</th>
                <th>License plate</th>
            </tr>';
    $count = 0;
    foreach ($result as $car) 
    {
        $count++;
        echo '<tr>
                <td>'.$count.'</td>
                <td>'.$car["make"].'</td>
                <td>'.$car["model"].'</td>
                <td>'.$car["vin"].'</td>
                <td>'.$car["plate_number"].'</td>
            </tr>';
    }
    echo "</table>";
}

function display_login_redirect_button()
{
    echo '<form action="../login/index.php" method="post"><input type="submit" value="Login"></form>';
}

function error_message()
{
    echo '<p class="error">You cannot access cars page while being logged out.</p>
        <p class="error">Login first!</p>';
    display_login_redirect_button();
}

function add_car_button()
{
    echo '<form action="../add-car/index.php"><button>Add a car</button></form>';
}

function homepage_redirect_button()
{
    echo '<form action="../index.php"><button>Go to homepage</button></form>';
}