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
    <?php require_once '../includes/common-head-content.php'; ?>
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
            window.location.href = `../car-info/?id=${id}`;
        }

        function toggle_filters() {
            if (document.getElementById("filters-row").style.display != "table-row") {
                document.getElementById("filters-row").style.display = "table-row";
                document.getElementById("filters-toggle-button").innerText = "Hide filters";
            } else {
                document.getElementById("filters-row").style.display = "none";
                document.getElementById("filters-toggle-button").innerText = "Show filters";
            }
        }

        function apply_filters() {
            var myForm = document.getElementById('apply-filters-form');
    
            var allInputs = myForm.elements;

            console.log(allInputs);

            for (var i = 0; i < allInputs.length; i++) {
                console.log("a intrat");
                var input = allInputs[i];

                if (input.name && !input.value) {
                    input.name = '';
                }
            }
        
            myForm.submit();
        }
    </script>
</head>
<body>
    <?php require_once '../includes/navbar.php'; ?>
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