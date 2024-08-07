<?php
    require_once 'model.php';
    require_once '../includes/config-session.php';
    require_once '../includes/db-setup.php';

    $pdo = connect_db();

    $carid = $_POST["car-id"];
    $old_image = get_car_by_id($pdo, $carid)["path_to_image"];
    $newfile = handle_image_upload($carid);
    if ($newfile != NULL) {
        update_image($pdo, $carid, $newfile);
    }   
    if ($old_image != "add-car/uploads/placeholder.png") {
        unlink("../" . $old_image);
    }
    header("Location: .?id=" . $_POST["car-id"]);
    die();

function handle_image_upload($carid)
{
    $target_file = get_target_file();

    if ($target_file == NULL) {
        return NULL;
    }

    $uploadOk = 1;

    // Check if image file is an actual image or fake image
    if (!getimagesize($_FILES["image"]["tmp_name"])) {
        $uploadOk = 0;
    }

    // Check if file already exists
    if (file_exists($target_file)) {
        $uploadOk = 0;
    }

    // Check file size
    if ($_FILES["image"]["size"] > 128 * 1024 * 1024) {
        $uploadOk = 0;
    }

    // Allow certain file formats
    $imageFileType = strtolower(pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION));
    if (
        $imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
        && $imageFileType != "gif"
    ) {
        $uploadOk = 0;
    }

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk) {
        move_uploaded_file($_FILES["image"]["tmp_name"], "../" . $target_file);
    } else {
        return NULL;
    }
    
    return $target_file;
}

function get_target_file()
{
    if (isset($_FILES["image"]) && $_FILES["image"]["name"] != "") {
        $temp = explode(".", $_FILES["image"]["name"]);
        $newfilename = round(microtime(true)) . '.' . end($temp);
        $target_dir = "add-car/uploads/";
        return $target_dir . $newfilename;
    }
    return NULL;
}