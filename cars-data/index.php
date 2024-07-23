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

    <?php 
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

</body>
</html>