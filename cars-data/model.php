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

function delete_car(object $pdo, int $id)
{
    $query = "DELETE FROM cars WHERE id=:id AND user_id=:user_id";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $id);
    $stmt->bindParam(":user_id", $_SESSION["user_id"]);
    $stmt->execute();
}