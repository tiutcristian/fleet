<?php

declare(strict_types=1);

function get_car_by_id(object $pdo, int $id)
{
    $query = "SELECT * FROM cars WHERE id = :id";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $id);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $stmt = null;
    return $result;
}

function get_vignettes_by_car_id(object $pdo, int $car_id)
{
    $query = "SELECT * FROM vignettes WHERE car_id = :car_id";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":car_id", $car_id);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $stmt = null;
    return $result;
}