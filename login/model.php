<?php

declare(strict_types=1);

function get_user (object $pdo, string $username)
{
    $query = "SELECT * FROM users WHERE username = :username";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":username", $username);
    $stmt->execute();

    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result;
}

function update_notifications(object $pdo, int $user_id, bool $is_admin)
{   
    // ITP
    $query = "INSERT INTO notifications (user_id, car_id, message)
                SELECT user_id, id, CONCAT('Your ITP is about to expire for car with license plate ', plate_number)
                FROM cars
                WHERE itp_exp_date < DATE_ADD(NOW(), INTERVAL 1 WEEK) AND itp_notification_sent = 0";
    $query .= " AND user_id = :user_id"; 
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":user_id", $user_id);
    $stmt->execute();

    $query = "UPDATE cars SET itp_notification_sent = 1 WHERE itp_exp_date < DATE_ADD(NOW(), INTERVAL 1 WEEK) AND itp_notification_sent = 0";
    $query .= " AND user_id = :user_id";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":user_id", $user_id);
    $stmt->execute();


    // Insurance
    $query = "INSERT INTO notifications (user_id, car_id, message)
                SELECT user_id, cars.id, CONCAT('One of your insurance is about to expire for car with license plate ', plate_number)
                FROM cars JOIN insurances ON cars.id = insurances.car_id
                WHERE expiration_date < DATE_ADD(NOW(), INTERVAL 1 WEEK) AND notification_sent = 0";
    $query .= " AND user_id = :user_id";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":user_id", $user_id);
    $stmt->execute();

    $query = "UPDATE insurances JOIN cars ON cars.id = insurances.car_id SET notification_sent = 1
                WHERE expiration_date < DATE_ADD(NOW(), INTERVAL 1 WEEK) AND notification_sent = 0";
    $query .= " AND user_id = :user_id";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":user_id", $user_id);
    $stmt->execute();


    // Vignette
    $query = "INSERT INTO notifications (user_id, car_id, message)
                SELECT user_id, cars.id, CONCAT('Your vignette is about to expire for car with license plate ', plate_number)
                FROM cars JOIN vignettes ON cars.id = vignettes.car_id
                WHERE expiration_date < DATE_ADD(NOW(), INTERVAL 1 WEEK) AND notification_sent = 0";
    $query .= " AND user_id = :user_id"; 
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":user_id", $user_id);
    $stmt->execute();

    $query = "UPDATE vignettes JOIN cars ON cars.id = vignettes.car_id SET notification_sent = 1
                WHERE expiration_date < DATE_ADD(NOW(), INTERVAL 1 WEEK) AND notification_sent = 0";
    $query .= " AND user_id = :user_id";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":user_id", $user_id);
    $stmt->execute();
}

function has_unseen_notifications(object $pdo, int $user_id): bool
{
    $query = "SELECT COUNT(*) FROM notifications WHERE user_id = :user_id AND seen = 0";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":user_id", $user_id);
    $stmt->execute();

    $result = $stmt->fetchColumn();
    return ($result > 0) ? true : false;
}