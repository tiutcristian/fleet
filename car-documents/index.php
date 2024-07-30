<?php
require_once '../includes/db-setup.php';
require_once 'model.php';
require_once 'view.php';
require_once '../includes/config-session.php';
$pdo = connect_db();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- <link rel="stylesheet" href="../css/reset.css">
    <link rel="stylesheet" href="../css/main.css"> -->

    <link href="https://cdn.jsdelivr.net/npm/@picocss/pico@1/css/pico.min.css" rel="stylesheet">
    
    <title>Document</title>
</head>
<body>

<main class="container">
    <?php display_car_documents($pdo, $_GET["id"]); ?>
</main>

</body>
</html>






