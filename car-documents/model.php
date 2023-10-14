<?php

declare(strict_types=1);

function get_car_by_id(object $pdo, int $id)
{
    $query = "SELECT * FROM cars WHERE id = :id";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $id);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result;
}