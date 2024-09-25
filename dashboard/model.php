<?php
require_once '../includes/config-session.php';

function get_filtering_contraints(): array
{
    $constraints = array();
    $fields = array("make", "model", "vin", "plate_number");
    foreach ($fields as $field)
    {
        if (isset($_GET[$field]) && $_GET[$field] != "")
        {
            $constraints[$field] = "$field LIKE CONCAT('%', :$field, '%')";
        }
    }
    if (isset($_GET["owner_username"]) && $_GET["owner_username"] != "")
    {
        $constraints["owner_username"] = "username LIKE CONCAT('%', :owner_username, '%')";
    }
    return $constraints;
}

function add_constraints_to_base_query($query, $constraints, $linking_word)
{
    if (count($constraints) > 0)
    {
        $query .= " " . $linking_word . " ";
        $query .= implode(" AND ", $constraints);
    }
    return $query;
}

function bind_params($stmt, $constraints)
{
    foreach ($constraints as $key => $value)
    {
        $stmt->bindParam(":$key", $_GET[$key]);
    }
}

function execute_query($stmt, $constraints)
{
    bind_params($stmt, $constraints);

    $stmt->execute();

    $result_array = array();
    while($tmp = $stmt->fetch(PDO::FETCH_ASSOC))
    {
        array_push($result_array, $tmp);
    }
    
    return $result_array;
}

function get_user_cars_filtered (object $pdo, string $username, int $number_of_rows, int $offset_value)
{
    $query = "SELECT c.* 
                FROM cars c JOIN users u ON c.user_id = u.id 
                WHERE u.username = :username";
    $constraints = get_filtering_contraints();
    $query = add_constraints_to_base_query($query, $constraints, "AND");
    $query .= " LIMIT :number_of_rows OFFSET :offset_value";

    $stmt = $pdo->prepare($query);

    $stmt->bindParam(":username", $username);
    $stmt->bindParam(":number_of_rows", $number_of_rows, PDO::PARAM_INT);
    $stmt->bindParam(":offset_value", $offset_value, PDO::PARAM_INT);

    return execute_query($stmt, $constraints);
}

function get_all_cars_filtered (object $pdo, int $number_of_rows, int $offset_value)
{
    $query = "SELECT cars.*, username 
                FROM cars JOIN users ON cars.user_id = users.id";
    $constraints = get_filtering_contraints();
    $query = add_constraints_to_base_query($query, $constraints, "WHERE");
    $query .= " LIMIT :number_of_rows OFFSET :offset_value";

    $stmt = $pdo->prepare($query);

    $stmt->bindParam(":number_of_rows", $number_of_rows, PDO::PARAM_INT);
    $stmt->bindParam(":offset_value", $offset_value, PDO::PARAM_INT);

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

function get_total_number_of_cars_user($pdo)
{
    $query = "SELECT COUNT(*) FROM cars";
    $query .= " WHERE user_id=:user_id";
    $constraints = get_filtering_contraints();
    $query = add_constraints_to_base_query($query, $constraints, "AND");

    $stmt = $pdo->prepare($query);

    $stmt->bindParam(":user_id", $_SESSION["user_id"]);
    bind_params($stmt, $constraints);
    
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result["COUNT(*)"];
}

function get_total_number_of_cars_admin($pdo)
{
    $query = "SELECT COUNT(*), username FROM cars JOIN users ON cars.user_id = users.id";
    $constraints = get_filtering_contraints();
    $query = add_constraints_to_base_query($query, $constraints, "WHERE");

    $stmt = $pdo->prepare($query);

    bind_params($stmt, $constraints);

    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result["COUNT(*)"];
}