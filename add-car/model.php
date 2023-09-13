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

function create_car(object $pdo, string $make, string $model, string $plate_number, string $vin)
{
    $query = "INSERT INTO cars (make, model, plate_number, vin, user_id) VALUES 
            (:make, :model, :plate_number, :vin, :user_id);";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":make", $make);
    $stmt->bindParam(":model", $model);
    $stmt->bindParam(":plate_number", $plate_number);
    $stmt->bindParam(":vin", $vin);
    $stmt->bindParam(":user_id", $_SESSION['user_id']);
    $stmt->execute();
}