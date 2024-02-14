<?php
    require_once '../includes/config-session.php';
    require_once 'view.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- <link rel="stylesheet" href="../css/reset.css">  
    <link rel="stylesheet" href="../css/main.css"> -->
    <style>
        .form-error {
            margin-left: 40%;
            color: red;
            text-decoration: solid;
        }

        .form-success {
            margin-left: 40%;
            color: rgb(0, 190, 0);
            text-decoration: solid;
        }
    </style>
    <title>Document</title>
</head>
<body>
    
<?php
    if (isset($_SESSION["user_id"]))
    {
        display_add_car_form();
        display_errors();
        cars_data_redirect_button();
    }
    else
        error_message();
?>

</body>
</html>