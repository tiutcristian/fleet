<?php

function display_user_cars (object $pdo, string $username)
{
    $result = get_user_cars($pdo, $username);
?>   

    <table>
        <tr>
            <th>Nr. Crt.</th>
            <th>Make</th>
            <th>Model</th>
            <th>VIN Number</th>
            <th>License plate</th>
        </tr>
<?php
    $count = 0;
    foreach ($result as $car) 
    {
        $count++;
?>
        <tr>
            <td><?php echo $count; ?></td>
            <td><?php echo $car["make"]; ?></td>
            <td><?php echo $car["model"]; ?></td>
            <td><?php echo $car["vin"]; ?></td>
            <td><?php echo $car["plate_number"]; ?></td>
        </tr>
<?php
    }
?>
    </table>

<?php
}

function display_error_message()
{
?>
    <p class="error">You cannot access cars page while being logged out.</p>
    <p class="error">Login first!</p>
    <br><br><br>
    <form action="../login/index.php" method="post">
        <input type="submit" value="Login">
    </form>
<?php
}
