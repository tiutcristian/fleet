<?php
require_once '../includes/config-session.php';
require_once 'view.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/reset.css">
    <link rel="stylesheet" href="../css/main.css">
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

    <?php require_once 'handler.php'; ?> 

    <div id="pop-up-container">
        <div class="pop-up">
            <div>Are you sure you want to delete <span id="plate-number-container"></span></div>
            <button id="yes-button">Yes</button>
            <form action="delete-car.php" method="post" id="delete-car-form" style="display:none;">
                <input type="text" name="car-id" id="car-id">
            </form>
            <button onclick="hidePopUp()">No</button>
        </div>
    </div>

</body>
</html>