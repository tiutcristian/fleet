<?php

declare(strict_types=1);

function get_filteringContraints(): array
{
    $constraints = array();
    $fields = array("make", "model", "vin", "plate_number");
    foreach ($fields as $field)
    {
        if (isset($_GET[$field]) && $_GET[$field] != "")
        {
            $constraints[$field] = "$field LIKE :$field";
        }
    }
    if (isset($_GET["owner_username"]) && $_GET["owner_username"] != "")
    {
        $constraints["owner_username"] = "username LIKE :owner_username";
    }
    return $constraints;
}

function execute_query($stmt, $constraints)
{
    foreach ($constraints as $key => $value)
    {
        $stmt->bindParam(":$key", $_GET[$key]);
    }

    $stmt->execute();

    $result_array = array();
    while($tmp = $stmt->fetch(PDO::FETCH_ASSOC))
    {
        array_push($result_array, $tmp);
    }

    return $result_array;
}

function get_user_cars_filtered (object $pdo, string $username)
{
    $query = "SELECT c.* FROM cars c JOIN users u ON c.user_id = u.id WHERE u.username = :username";

    $constraints = get_filteringContraints();

    if (count($constraints) > 0)
    {
        $query .= " AND ";
        $query .= implode(" AND ", $constraints);
    }

    $stmt = $pdo->prepare($query);

    $stmt->bindParam(":username", $username);

    return execute_query($stmt, $constraints);
}

function get_all_cars_filtered (object $pdo)
{
    $query = "SELECT cars.*, username FROM cars JOIN users ON cars.user_id = users.id";

    $constraints = get_filteringContraints();

    if (count($constraints) > 0)
    {
        $query .= " WHERE ";
        $query .= implode(" AND ", $constraints);
    }

    $stmt = $pdo->prepare($query);

    return execute_query($stmt, $constraints);
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