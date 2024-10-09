<?php
    require_once 'includes/db-setup.php'; // includes config.php where $config is defined (and so, the base_url)
    require_once 'includes/config-session.php'; // includes config file as well
    require_once 'login/model.php';

    $pdo = connect_db();

    // No direct access allowed
    if ($_SERVER["REQUEST_METHOD"] == "GET") {
        header("Location: " . $config["base_url"]);
        die();
    }
    // =========================================

    // Mark notification as seen
    if (isset($_POST["mark_seen"])) {
        $id = $_POST["mark_seen"];

        $query = "UPDATE notifications SET seen = 1 WHERE id = :id AND user_id = :user_id";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":id", $id);
        $stmt->bindParam(":user_id", $_SESSION["user_id"]);
        $stmt->execute();

        $_SESSION["has_unseen_notifications"] = has_unseen_notifications($pdo, $_SESSION["user_id"]);

        echo json_encode(array("success" => true));
        die();
    }
    // =========================================

    // Delete notification
    if (isset($_POST["delete"])) {
        $id = $_POST["delete"];

        $query = "DELETE FROM notifications WHERE id = :id AND user_id = :user_id";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":id", $id);
        $stmt->bindParam(":user_id", $_SESSION["user_id"]);
        $stmt->execute();

        $_SESSION["has_unseen_notifications"] = has_unseen_notifications($pdo, $_SESSION["user_id"]);

        echo json_encode(array("success" => true));
        die();
    }
    // =========================================

    // Delete all notifications
    if (isset($_POST["delete_all"])) {
        $query = "DELETE FROM notifications WHERE user_id = :user_id";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":user_id", $_SESSION["user_id"]);
        $stmt->execute();

        $_SESSION["has_unseen_notifications"] = false;

        echo json_encode(array("success" => true));
        die();
    }
    // =========================================

    // Fetch notifications
    if (!isset($_SESSION["user_id"])) {
        header("Location: " . $config["base_url"]);
        die();
    }

    $query = "SELECT * FROM notifications WHERE user_id = :user_id";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":user_id", $_SESSION["user_id"]);
    $stmt->execute();

    $notifications_array = $stmt->fetchAll();
    
    $arr = array("notifications" => array_reverse($notifications_array));
    echo json_encode($arr);
    die();
    // ========================================