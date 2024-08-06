<?php
    require_once '../includes/config-session.php';
    require_once 'view.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php require_once '../includes/common-head-content.php'; ?>
    <title>Add car</title>
</head>
<body>
    <?php require_once '../includes/navbar.php'; ?>
    <main class="container">
        <div class="form-container">
            <?php display_add_car_form(); ?>
        </div>
    </main>
</body>
</html>