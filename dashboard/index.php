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
            var table = document.getElementById("cars-table");
            var filtersRow = document.getElementById("filters-row");
            var filtersToggleButton = document.getElementById("filters-toggle-button");
            if (filtersRow.style.opacity != "1") {
                filtersRow.style.visibility = "visible";
                filtersRow.style.opacity = "1";
                filtersRow.style.transform = "translateY(0)";
                filtersRow.style.transition = "opacity 0.5s, transform 0.5s";
                filtersToggleButton.innerText = "Hide filters";
            } else {
                filtersRow.style.opacity = "0";
                filtersRow.style.transform = "translateY(-100%)";
                filtersRow.style.transition = "opacity 0.5s transform 0.5s";
                setTimeout(() => {
                    filtersRow.style.visibility = "hidden";
                }, 500);
                filtersToggleButton.innerText = "Show filters";
            }
        }

        function apply_filters() {
            var myForm = document.getElementById('apply-filters-form');
    
            var allInputs = myForm.elements;

            for (var i = 0; i < allInputs.length; i++) {
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