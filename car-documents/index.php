<?php
require_once '../includes/db-setup.php';
require_once 'model.php';
require_once 'view.php';
require_once 'controller.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/reset.css">
    <link rel="stylesheet" href="../css/main.css">
    <title>Document</title>
</head>
<body>

    <?php
        $id = $_GET["id"];
        $car = get_car_by_id($pdo, $id);        
    ?>

    <h3>
        Car id: <?= $id ?>
    </h3>

    <ul>
        <li><h3>VIN Number: <?= $car["vin"] ?> </h3></li>
        <li><h3>License Plate: <?= $car["plate_number"] ?> </h3></li>
        <li><h3>ITP: <?= $car["id"] ?> </h3></li>
        <li><h3>Insurances: <?= $car["id"] ?> </h3></li>
        <li><h3>Vignettes: <?= $car["id"] ?> </h3></li>
    </ul>

</body>
</html>






