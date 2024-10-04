<?php
    require_once 'includes/db-setup.php';
    require_once 'includes/config-session.php';

    $pdo = connect_db();

    if (isset($_GET["mark_seen"])) {
        $query = "UPDATE notifications SET seen = 1 WHERE id = :id";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":id", $_GET["mark_seen"]);
        $stmt->execute();
        
        echo json_encode(array("success" => true));
        exit();
    }

    $query = "SELECT * FROM notifications WHERE user_id = :user_id";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":user_id", $_SESSION["user_id"]);
    $stmt->execute();
    $notifications_array = $stmt->fetchAll();
    
    $arr = array("notifications" => array_reverse($notifications_array));
    
    echo json_encode($arr);