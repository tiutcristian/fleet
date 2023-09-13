<?php
    require_once '../includes/config-session.php';
    require_once 'view.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/reset.css">  
    <link rel="stylesheet" href="../css/main.css">
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