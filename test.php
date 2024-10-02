<?php
    require_once 'includes/db-setup.php';
    require_once 'includes/config-session.php';

    $pdo = connect_db();

    $arr = array(
        "a" => $_SESSION["user_id"],
        "b" => 2, 
        "c" => 3
    );
    echo json_encode($arr);


    // Plan:
    // 1. Search for expiring documents
    // 2. Insert into notifications table
    // 3. Get all notifications by userid