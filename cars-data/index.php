<?php
require_once '../includes/config-session.php';
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
    <link href="https://cdn.jsdelivr.net/npm/@picocss/pico@1/css/pico.min.css" rel="stylesheet">
    <style>
        #pop-up-container {
            position: fixed;
            left: 0;
            top: 0;
            background-color: rgba(0, 0, 0, 0.4);
            width: 100%;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            visibility: hidden;
        }

        .pop-up {
            border-radius: 15px;
            padding: 10px 10px 10px 10px;
            background-color: lightgray;
            width: min(600px, 90vw);
            /*height: 150px;*/
        }

        .center-container {
            display: flex;
            justify-content: center;
        }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>Document</title>
    <script>
        function onDelete (license_plate, id) {
            document.getElementById("pop-up-container").style.visibility = "visible";
            document.getElementById("plate-number-container").innerText = license_plate;
            document.getElementById("yes-button").onclick = function () {
                document.getElementById("car-id").value = id;
                document.getElementById("delete-car-form").submit();
            }
        }

        function hidePopUp () {
            document.getElementById("pop-up-container").style.visibility = "hidden";
        }
    </script>
</head>
<body>

    <?php display_cars_data($pdo); ?> 

</body>
</html>