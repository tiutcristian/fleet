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
    <?php require_once '../includes/common-head-content.php'; ?>
    <title>Car documents</title>
</head>
<body>

<?php require_once '../includes/navbar.php'; ?>

<main class="container">
    <?php
        if (isset($_SESSION["user_role"])) {
            display_car_info($pdo, $_GET["id"], $_SESSION["user_role"]);
        } else {
            display_not_logged_in();
        }
    ?>
</main>
    

</body>
</html>






