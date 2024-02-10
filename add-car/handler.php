<?php

require_once 'model.php';
require_once '../includes/config-session.php';
require_once '../includes/db-setup.php';
$pdo = connect_db();

if ($_SERVER["REQUEST_METHOD"] == "POST") 
{
    $make = $_POST["make"];
    $model = $_POST["model"];
    $plate_number = $_POST["plate_number"];
    $vin = $_POST["vin"];

    try 
    {
        // ERROR HANDLERS
        $errors = get_errors($make, $model, $plate_number, $vin, $pdo);

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

        create_car($pdo, strtoupper($make), strtoupper($model), strtoupper($plate_number), strtoupper($vin));

        unset($_SESSION["car_data"]);
        header("Location: ../cars-data/index.php");
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

function get_errors($make, $model, $plate_number, $vin, $pdo)
{
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
    return $errors;
}

function is_input_empty(string $make, string $model, string $plate, string $vin)
{
    if(empty($make) ||
       empty($model) ||
       empty($plate) ||
       empty($vin))
    {
        return true;
    }
    else
    {
        return false;
    }
}

function is_vin_invalid(string $vin)
{
    if(strlen($vin) === 17)
    {
        return false;
    }
    else
    {
        return true;
    }
}

function is_vin_taken(object $pdo, string $vin)
{
    if(get_entry_by_vin($pdo, $vin))
    {
        return true;
    }
    else
    {
        return false;
    }
}

function is_plate_invalid(string $plate)
{
    if (strlen($plate) < 6 || strlen($plate) > 7)
    {
        return true;
    }
    else if (strlen($plate) === 6)
    {
        //cazul B17ABC
        if($plate[0] != "B")
        {
            return true;
        }
        else if(!ctype_digit( substr($plate, 1, 2) ))
        {
            return true;
        }
        else if($plate[1] == "0" && $plate[2] == "0")
        {
            return true;
        }
        else if(!ctype_alpha( substr($plate, 3) ))
        {
            return true;
        }
        else
        {
            return false;
        }
    }
    else
    {
        
        $jud = array("AB","AG","AR","BC","BH","BN","BR","BT","BV","BZ","CJ","CL",
                     "CS","CT","CV","DB","DJ","GJ","GL","GR","HD","HR","IF","IL",
                     "IS","MH","MM","MS","NT","OT","PH","SB","SJ","SM","SV","TL",
                     "TM","TR","VL","VN","VS");
        if(!in_array( substr($plate,0,2), $jud ))
        {
            if($plate[0] == "B" && ctype_digit($plate[1]))
            {
                //cazul B777DXP
                if(!ctype_digit( substr($plate,1,3) ))
                {
                    return true;
                }
                else if($plate[1] == "0" && $plate[2] == "0" && $plate[3] == "0")
                {
                    return true;
                }
                else if(!ctype_alpha( substr($plate,4) ))
                {
                    return true;
                }
                else
                {
                    return false;
                }
            }
            else
                return true;
        }
        //cazul MM53CRI
        else if(!ctype_digit( substr($plate,2,2) ))
        {
            return true;
        }
        else if($plate[2] == "0" && $plate[3] == "0")
        {
            return true;
        }
        else if(!ctype_alpha( substr($plate,4) ))
        {
            return true;
        }
        else
        {
            return false;
        }
    }
}

function is_plate_taken(object $pdo, string $plate_number)
{
    if(get_entry_by_plate($pdo, $plate_number))
    {
        return true;
    }
    else
    {
        return false;
    }
}