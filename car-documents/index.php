<?php
require_once '../includes/db-setup.php';
require_once 'model.php';
require_once 'view.php';
$pdo = connect_db();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- <link rel="stylesheet" href="../css/reset.css">
    <link rel="stylesheet" href="../css/main.css"> -->
    <title>Document</title>
</head>
<body>

    <?php
        $car_id = $_GET["id"];
    ?> 
        <h3> Car id: <?= $car_id ?> </h3>
    <?php    
        display_car_documents($pdo, $car_id);
    ?>

    <a href="../cars-data/index.php">
        <button>Go back to cars list</button>
    </a>

</body>
</html>






