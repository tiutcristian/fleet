<?php
    require_once '../includes/config-session.php';
    require_once 'view.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- <link rel="stylesheet" href="../css/reset.css">  
    <link rel="stylesheet" href="../css/main.css"> -->

    <link href="https://cdn.jsdelivr.net/npm/@picocss/pico@1/css/pico.min.css" rel="stylesheet">
    
    <style>
        .form-error {
            margin-left: 40%;
            color: red;
            text-decoration: solid;
        }

        .form-success {
            margin-left: 40%;
            color: rgb(0, 190, 0);
            text-decoration: solid;
        }
    </style>
    <title>Document</title>
</head>
<body>
    
<main class="container">
    <?php display_add_car_form(); ?>
</main>

</body>
</html>