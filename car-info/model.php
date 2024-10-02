<?php

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

function update_itp(object $pdo, int $car_id, $expiration_date)
{
    $query = "UPDATE cars SET itp_exp_date = :expiration_date, itp_notification_sent = 0 WHERE id = :car_id";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":expiration_date", $expiration_date);
    $stmt->bindParam(":car_id", $car_id);
    $stmt->execute();
    $stmt = null;
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

function add_vignette(object $pdo, $car_id, $country, $details, $expiration_date)
{
    $query = "INSERT INTO vignettes (car_id, country, details, expiration_date) VALUES 
            (:car_id, :country, :details, :expiration_date);";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":car_id", $car_id);
    $stmt->bindParam(":country", $country);
    $stmt->bindParam(":details", $details);
    $stmt->bindParam(":expiration_date", $expiration_date);
    $stmt->execute();
    $stmt = null;
}

function delete_vignette(object $pdo, int $vignette_id)
{
    $query = "DELETE FROM vignettes WHERE id = :vignette_id";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":vignette_id", $vignette_id);
    $stmt->execute();
    $stmt = null;
}

function get_insurances_by_car_id(object $pdo, int $car_id)
{
    $query = "SELECT * FROM insurances WHERE car_id = :car_id";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":car_id", $car_id);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $stmt = null;
    $insurances = [];
    foreach ($result as $insurance) 
    {
        $insurances[$insurance['insurance_type']] = $insurance;
    }
    return $insurances;
}

function get_insurance_by_car_id_and_type(object $pdo, int $car_id, $type)
{
    $insurances = get_insurances_by_car_id($pdo, $car_id);
    return $insurances[$type];
}

function add_insurance(object $pdo, $car_id, $insurance_type, $details, $expiration_date)
{
    $query = "INSERT INTO insurances (car_id, insurance_type, details, expiration_date) VALUES 
            (:car_id, :insurance_type, :details, :expiration_date);";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":car_id", $car_id);
    $stmt->bindParam(":insurance_type", $insurance_type);
    $stmt->bindParam(":details", $details);
    $stmt->bindParam(":expiration_date", $expiration_date);
    $stmt->execute();
    $stmt = null;
}

function delete_insurance(object $pdo, int $insurance_id)
{
    $query = "DELETE FROM insurances WHERE id = :insurance_id";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":insurance_id", $insurance_id);
    $stmt->execute();
    $stmt = null;
}

function update_image(object $pdo, int $car_id, $image_path)
{
    $query = "UPDATE cars SET path_to_image = :image_path WHERE id = :car_id";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":image_path", $image_path);
    $stmt->bindParam(":car_id", $car_id);
    $stmt->execute();
    $stmt = null;
}