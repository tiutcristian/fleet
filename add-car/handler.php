<?php

require_once 'model.php';
require_once '../includes/config-session.php';
require_once '../includes/db-setup.php';
$pdo = connect_db();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if ($_SESSION["user_role"] === "admin") $username = $_POST["username"];
    $make = $_POST["make"];
    $model = $_POST["model"];
    $plate_number = $_POST["plate_number"];
    $vin = $_POST["vin"];

    try {
        // ERROR HANDLERS
        $errors = get_errors($make, $model, $plate_number, $vin, $pdo);

        if ($errors) {
            $_SESSION["errors_add_car"] = $errors;

            $car_data = [
                "make" => $make,
                "model" => $model,
                "plate_number" => $plate_number,
                "vin" => $vin
            ];
            $_SESSION["car_data"] = $car_data;
            // Redirect to the same page to display errors
            header("Location: index.php");
            die();
        }

        if($_SESSION["user_role"] === "admin")
        {
            $user = get_user($pdo, $username);
            if (!$user) {
                $_SESSION["errors_add_car"]["no_user"] = "User does not exist!";
                $_SESSION["car_data"]["username"] = $username;
                header("Location: index.php");
                die();
            }
            else
            {
                $user_id = $user["id"];
            }
        }
        else
        {
            $user_id = $_SESSION["user_id"];
        }

        $target_file = handle_image_upload();
        create_car($pdo, $user_id, strtoupper($make), strtoupper($model), strtoupper($plate_number), strtoupper($vin), $target_file);
        // Car created successfully
        unset($_SESSION["car_data"]);
        header("Location: ../dashboard");
        $pdo = null;
        $stmt = null;
        die();
    } catch (PDOException $e) {
        die("Query failed: " . $e->getMessage());
    }
} 
else 
{
    // Redirect to the homepage if request method is not POST
    header("Location: ../");
    die();
}

function handle_image_upload()
{
    $target_file = get_target_file();

    if ($target_file != "uploads/placeholder.png")
    {
        $uploadOk = 1;

        // Check if image file is an actual image or fake image
        if (isset($_POST["submit"])) {
            $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
            if (!$check) {
                $_SESSION["errors_add_car"]["not_an_image"] = "File is not an image.";
                $uploadOk = 0;
            }
        }

        // Check if file already exists
        if (file_exists($target_file)) {
            $_SESSION["errors_add_car"]["file_exists"] = "Sorry, file already exists.";
            $uploadOk = 0;
        }

        // Check file size
        if ($_FILES["fileToUpload"]["size"] > 128 * 1024 * 1024) {
            $_SESSION["errors_add_car"]["file_too_large"] = "Sorry, your file is too large.";
            $uploadOk = 0;
        }

        // Allow certain file formats
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        if (
            $imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
            && $imageFileType != "gif"
        ) {
            $_SESSION["errors_add_car"]["invalid_format"] = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
            $uploadOk = 0;
        }

        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk) {
            move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file);
        } else {
            header("Location: index.php");
            die();
        }
    }
    return "add-car/" . $target_file;
}

function get_target_file()
{
    if(isset($_FILES["fileToUpload"]["name"]) && $_FILES["fileToUpload"]["name"] != "")
    {
        $temp = explode(".", $_FILES["fileToUpload"]["name"]);
        $newfilename = round(microtime(true)) . '.' . end($temp);
        $target_dir = "uploads/";
        return $target_dir . $newfilename;
    }
    return "uploads/placeholder.png";
}

function get_errors($make, $model, $plate_number, $vin, $pdo)
{
    $errors = [];
    if (is_input_empty($make, $model, $plate_number, $vin)) {
        $errors["empty_input"] = "Fill in all fields!";
    }
    if (is_vin_invalid(strtoupper($vin))) {
        $errors["invalid_vin"] = "VIN number is not valid!";
    }
    if (is_vin_taken($pdo, strtoupper($vin))) {
        $errors["taken_vin"] = "VIN number is taken!";
    }
    if (is_plate_invalid(strtoupper($plate_number))) {
        $errors["invalid_plate"] = "Plate number is not valid!";
    }
    if (is_plate_taken($pdo, strtoupper($plate_number))) {
        $errors["taken_plate"] = "Plate number is taken!";
    }
    return $errors;
}

function is_input_empty(string $make, string $model, string $plate, string $vin)
{
    if (
        empty($make) ||
        empty($model) ||
        empty($plate) ||
        empty($vin)
    ) {
        return true;
    } else {
        return false;
    }
}

function is_vin_invalid(string $vin)
{
    if (strlen($vin) === 17) {
        return false;
    } else {
        return true;
    }
}

function is_vin_taken(object $pdo, string $vin)
{
    if (get_entry_by_vin($pdo, $vin)) {
        return true;
    } else {
        return false;
    }
}

function is_plate_invalid(string $plate)
{
    if (strlen($plate) < 6 || strlen($plate) > 7) {
        return true;
    } else if (strlen($plate) === 6) {
        //cazul B17ABC
        if ($plate[0] != "B") {
            return true;
        } else if (!ctype_digit(substr($plate, 1, 2))) {
            return true;
        } else if ($plate[1] == "0" && $plate[2] == "0") {
            return true;
        } else if (!ctype_alpha(substr($plate, 3))) {
            return true;
        } else {
            return false;
        }
    } else {

        $jud = array(
            "AB", "AG", "AR", "BC", "BH", "BN", "BR", "BT", "BV", "BZ", "CJ", "CL",
            "CS", "CT", "CV", "DB", "DJ", "GJ", "GL", "GR", "HD", "HR", "IF", "IL",
            "IS", "MH", "MM", "MS", "NT", "OT", "PH", "SB", "SJ", "SM", "SV", "TL",
            "TM", "TR", "VL", "VN", "VS"
        );
        if (!in_array(substr($plate, 0, 2), $jud)) {
            if ($plate[0] == "B" && ctype_digit($plate[1])) {
                //cazul B777DXP
                if (!ctype_digit(substr($plate, 1, 3))) {
                    return true;
                } else if ($plate[1] == "0" && $plate[2] == "0" && $plate[3] == "0") {
                    return true;
                } else if (!ctype_alpha(substr($plate, 4))) {
                    return true;
                } else {
                    return false;
                }
            } else
                return true;
        }
        //cazul MM53CRI
        else if (!ctype_digit(substr($plate, 2, 2))) {
            return true;
        } else if ($plate[2] == "0" && $plate[3] == "0") {
            return true;
        } else if (!ctype_alpha(substr($plate, 4))) {
            return true;
        } else {
            return false;
        }
    }
}

function is_plate_taken(object $pdo, string $plate_number)
{
    if (get_entry_by_plate($pdo, $plate_number)) {
        return true;
    } else {
        return false;
    }
}
