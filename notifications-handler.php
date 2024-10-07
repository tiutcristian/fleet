<?php
    require_once 'includes/db-setup.php'; // includes config.php where $config is defined (and so, the base_url)
    require_once 'includes/config-session.php'; // includes config file as well

    $pdo = connect_db();

    if (isset($_GET["mark_seen"])) {
        $query = "UPDATE notifications SET seen = 1 WHERE id = :id";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":id", $_GET["mark_seen"]);
        $stmt->execute();
        
        echo json_encode(array("success" => true));
        exit();
    }

    if (!isset($_SESSION["user_id"])) {
        echo json_encode(array("success" => false));
        header("Location: " . $config["base_url"]);
        die();
    }

    $is_admin = $_SESSION["user_role"] == "admin";

    $query = "SELECT * FROM notifications";
    if (!$is_admin) { $query .= " WHERE user_id = :user_id"; }

    $stmt = $pdo->prepare($query);
    if (!$is_admin) { $stmt->bindParam(":user_id", $_SESSION["user_id"]);}

    $stmt->execute();
    $notifications_array = $stmt->fetchAll();
    
    $arr = array("notifications" => array_reverse($notifications_array));
    echo json_encode($arr);

    