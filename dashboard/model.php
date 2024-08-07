<?php

declare(strict_types=1);

function get_user_cars (object $pdo, string $username)
{
    $query = "SELECT * FROM users WHERE username = :username";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":username", $username);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    $current_id = $result["id"];

    $query2 = "SELECT * FROM cars WHERE user_id = :id";
    $stmt2 = $pdo->prepare($query2);
    $stmt2->bindParam(":id", $current_id);
    $stmt2->execute();

    $result_array = array();
    while($tmp = $stmt2->fetch(PDO::FETCH_ASSOC))
    {
        array_push($result_array, $tmp);
    }

    return $result_array;
}

function get_all_cars (object $pdo)
{
    $query = "SELECT cars.*, username FROM cars JOIN users ON cars.user_id = users.id";
    $stmt = $pdo->prepare($query);
    $stmt->execute();

    $result_array = array();
    while($tmp = $stmt->fetch(PDO::FETCH_ASSOC))
    {
        array_push($result_array, $tmp);
    }

    return $result_array;
}

function delete_car(object $pdo, int $id, int $user_id, string $role)
{
    if ($role == "admin")
    {
        $query = "DELETE FROM cars WHERE id=:id";
        $stmt = $pdo->prepare($query);
    }
    else
    {
        $query = "DELETE FROM cars WHERE id=:id AND user_id=:user_id";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":user_id", $user_id);
    }
    $stmt->bindParam(":id", $id);
    $stmt->execute();
}

function get_image_by_car_id($pdo, $car_id)
{
    $query = "SELECT * FROM cars WHERE id=:id";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $car_id);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result["path_to_image"];
}