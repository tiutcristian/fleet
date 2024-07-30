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

    <!-- main stylesheet -->
    <link href="https://cdn.jsdelivr.net/npm/@picocss/pico@1/css/pico.min.css" rel="stylesheet">
    
    <!-- stylesheet that contains the icons for the buttons in the car table -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    
    <!-- custom stylesheet -->
    <link rel="stylesheet" href="../css/main.css">
    
    <title>Dashboard</title>
    
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