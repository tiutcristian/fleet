<?php
    require_once 'includes/config_session-inc.php';
    require_once 'includes/signup_view-inc.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/reset.css">  
    <link rel="stylesheet" href="css/main.css">  
    <title>Document</title>
</head>
<body>

    <h3>Signup</h3>
    <br>
    <form action="includes/signup-inc.php" method="post">
        <?php
        signup_inputs();
        ?>
        <input type="submit" value="Signup">
    </form>

    <?php
    check_signup_errors();
    ?>

    <br><br><br>

    <form action="index.php">
        <button>Go to homepage</button>
    </form>
    
</body>
</html>