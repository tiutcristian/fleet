<?php
require_once 'includes/config_session-inc.php';
require_once 'includes/login_view-inc.php';
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

    <h3>
        <?php
        output_username();
        ?>
    </h3>
        
    <br><br><br>

    <?php
    if (!isset($_SESSION["user_id"]))
    {
    ?>
        <form action="login.php">
            <button>Login</button>
        </form>

        <br><br><br>

        <form action="signup.php">
            <button>Signup</button>
        </form>
    <?php
    }
    else
    {
    ?>
        <form action="cars.php">
            <button>Go to cars</button>
        </form>

        <br><br><br>
        
        <form action="includes/logout-inc.php" method="post">
            <input type="submit" value="Logout">
        </form>
    <?php
    }
    ?>
    
</body>
</html>