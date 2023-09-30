<?php
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

    <h3>
        Car id: <?php echo $_GET["id"]; ?>
    </h3>

    <ul>
        <li><h3>VIN Number:</h3></li>
        <li><h3>License Plate:</h3></li>
        <li><h3>ITP</h3></li>
        <li><h3>Insurances:</h3></li>
        <li><h3>Vignettes:</h3></li>
    </ul>

</body>
</html>






