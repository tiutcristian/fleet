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

    <!-- main stylesheet -->
    <link href="https://cdn.jsdelivr.net/npm/@picocss/pico@1/css/pico.min.css" rel="stylesheet">
    
    <!-- stylesheet that contains the icons for the buttons in the car table -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
        #pop-up-container {
            position: fixed;
            left: 0;
            top: 0;
            background-color: rgba(255, 255, 255, 0.15);
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
            background-color: #11191F;
            color: lightblue;
            width: min(600px, 90vw);
        }

        .center-container {
            display: flex;
            justify-content: center;
        }

        .tools-buttons {
            display: flex;
            gap: 2%;
        }
 
        table .car-img-cell{
            min-width: 200px;
        }

        table td {
            max-width: 200px;
            font-size: medium;
        }

        .btn-small {
            padding: 5px 5px;
            font-size: 15px;
        }
/*
        .table-buttons {
            display: flex;
            gap: 10px;
        } */
    </style>
    <title>Fleet</title>
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

        function redirectToCarDocuments (id) {
            window.location.href = `../car-documents/index.php?id=${id}`;
        }
    </script>
</head>
<body>

    <!-- Main section -->
    <main class="container">
        <div class="grid">
            <section>
                <h2>Dashboard</h2>
                <?php display_page_content($pdo); ?> 
            </section>
        </div>
    </main>

</body>
</html>