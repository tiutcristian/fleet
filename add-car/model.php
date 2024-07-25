<?php

declare(strict_types=1);

function get_entry_by_vin(object $pdo, string $vin)
{
    $query = "SELECT * FROM cars WHERE vin = :vin";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":vin", $vin);
    $stmt->execute();

    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result;
}

function get_entry_by_plate(object $pdo, string $plate_number)
{
    $query = "SELECT * FROM cars WHERE plate_number = :plate_number";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":plate_number", $plate_number);
    $stmt->execute();

    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result;
}

function create_car(object $pdo, $user_id, string $make, string $model, string $plate_number, string $vin, string $path_to_image)
{
    $query = "INSERT INTO cars (make, model, plate_number, vin, path_to_image, user_id) VALUES 
            (:make, :model, :plate_number, :vin, :path_to_image, :user_id);";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":make", $make);
    $stmt->bindParam(":model", $model);
    $stmt->bindParam(":plate_number", $plate_number);
    $stmt->bindParam(":vin", $vin);
    $stmt->bindParam(":path_to_image", $path_to_image);
    $stmt->bindParam(":user_id", $user_id);
    $stmt->execute();
}

function get_user (object $pdo, string $username)
{
    $query = "SELECT id FROM users WHERE username = :username";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":username", $username);
    $stmt->execute();

    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result;
}