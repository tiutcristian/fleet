<?php
require_once 'config.php';
require_once 'config-session.php';
require_once 'button-link.php';
?>

<script>
    function fetch_notifications() {
        var new_notifications = false;
        fetch("<?= $config["base_url"] ?>/notifications-handler.php", {method: "POST"})
            .then(response => response.json())
            .then(data => {
                var notifications_panel_body = document.querySelector(".notifications-panel-body");
                notifications_panel_body.innerHTML = "";
                data.notifications.forEach(notification => {
                    var notification_div = document.createElement("div");
                    notification_div.classList.add("notification");
                    notification_div.innerHTML = notification.message;
                    if (notification.seen == 0) {
                        new_notifications = true;
                        notification_div.classList.add("unseen");
                        notification_div.setAttribute("data-notification-id", notification.id);
                        notification_div.addEventListener("click", function() {
                            mark_notification_seen(notification.id);
                            this.classList.remove("unseen");
                        });
                    }
                    notifications_panel_body.appendChild(notification_div);
                });
            });
        return new_notifications; // Return true if there are new notifications --> show the red dot
    }

    function notifications_button_pressed() {
        fetch_notifications();
        show_notifications_panel();
    }

    function mark_notification_seen(notification_id) {
        console.log("Marking notification as seen");
        const data = { mark_seen: notification_id };
        fetch("<?= $config["base_url"] ?>/notifications-handler.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/x-www-form-urlencoded"
            },
            body: new URLSearchParams(data)
        })
        .then(response => response.text())
        .then(data => { console.log(data); })
        .catch(error => console.error(error));
        console.log("Marked notification as seen");
    }

    function hide_notifications_panel() {
        var notifications_panel = document.querySelector(".notifications-panel-container");
        notifications_panel.style.transform = "translateX(100%)";
        notifications_panel.style.transition = "transform 0.5s";
    }

    function show_notifications_panel() {
        var notifications_panel = document.querySelector(".notifications-panel-container");
        notifications_panel.style.transform = "translateX(0)";
        notifications_panel.style.transition = "transform 0.5s";
    }

    function delete_all_notifications() {
        console.log("Deleting all notifications");
        const data = { delete_all: 1 };
        fetch("<?= $config["base_url"] ?>/notifications-handler.php", {
            method: "POST", 
            headers: {
                "Content-Type": "application/x-www-form-urlencoded"
            },
            body: new URLSearchParams(data)
        })
            .then(response => response.text())
            .then(data => { console.log(data); })
            .catch(error => console.error(error));
        console.log("Deleted all notifications");

        fetch_notifications();
    }
</script>

<nav class="container-fluid navbar">
    <ul>
        <li><a href="<?= $config["base_url"] ?>" class="nav-bar-title">Car Fleet Management</a></li>
    </ul>
    <ul>
        <?php
        if (isset($_SESSION["user_id"])) {
        ?>
            <li>Hello, <?= $_SESSION["user_username"] ?></li>
            <li><button class="notif-button" onclick="notifications_button_pressed()"><i class="fa fa-bell"></i></button></li>
            <li><?php button_link("Logout", $config["base_url"] . "login/logout-handler.php", "outline"); ?></li>
        <?php
        } else {
        ?>
            <li><?php button_link("Login", $config["base_url"] . "login", "outline"); ?></li>
            <li><?php button_link("Signup", $config["base_url"] . "signup", "outline"); ?></li>
        <?php
        }
        ?>
    </ul>
</nav>

<div class="notifications-panel-container">
    <div class="notifications-panel">
        <div class="notifications-panel-header">
            <span class="close-notifications-panel-button" onclick="hide_notifications_panel()">Close panel <i class="fa fa-angle-double-right"></i></span>
            <h3>Notifications</h3>
            <div class="delete-all-notifications-button"><button onclick="delete_all_notifications()">Delete all</button></div>
        </div>
        <div class="notifications-panel-body">
            <!-- Notifications are added here by AJAX -->
        </div>
    </div>
</div>