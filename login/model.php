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

function update_notifications(object $pdo, int $user_id)
{
    $query = "INSERT INTO notifications (user_id, message, car_id) VALUES (:user_id, 'Welcome to our website!', NULL)";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":user_id", $user_id);
    $stmt->execute();
}