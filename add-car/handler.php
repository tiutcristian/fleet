<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") 
{
    $make = $_POST["make"];
    $model = $_POST["model"];
    $plate_number = $_POST["plate_number"];
    $vin = $_POST["vin"];

    try 
    {
        require_once '../includes/db-setup.php';
        require_once 'model.php';
        require_once 'controller.php';

        // ERROR HANDLERS
        $errors = [];

        if (is_input_empty($make, $model, $plate_number, $vin))
        {
            $errors["empty_input"] = "Fill in all fields!";
        }
        if (is_vin_invalid(strtoupper($vin)))
        {
            $errors["invalid_vin"] = "VIN number is not valid!";
        }
        if (is_vin_taken($pdo, strtoupper($vin)))
        {
            $errors["taken_vin"] = "VIN number is taken!";
        }
        if (is_plate_invalid(strtoupper($plate_number)))
        {
            $errors["invalid_plate"] = "Plate number is not valid!";
        }
        if (is_plate_taken($pdo, strtoupper($plate_number)))
        {
            $errors["taken_plate"] = "Plate number is taken!";
        }

        require_once '../includes/config-session.php';

        if ($errors)
        {
            $_SESSION["errors_add_car"] = $errors;

            $car_data = [
                "make" => $make,
                "model" => $model,
                "plate_number" => $plate_number,
                "vin" => $vin
            ];
            $_SESSION["car_data"] = $car_data;

            header("Location: index.php");
            die();
        }

        add_car($pdo, strtoupper($make), strtoupper($model), strtoupper($plate_number), strtoupper($vin));

        unset($_SESSION["car_data"]);
        header("Location: index.php?addcar=success");
        $pdo = null;
        $stmt = null;
        die();
    } 
    catch (PDOException $e) 
    {
        die("Query failed: " . $e->getMessage());
    }
}
else
{
    header("Location: ../index.php");
    die();
}