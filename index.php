<?php
require_once 'includes/config-session.php';
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
            if (isset($_SESSION["user_id"]))
            {
                echo "You are logged in as " . $_SESSION["user_username"];
            }
            else
            {
                echo "You are not logged in";
            }
        ?>
    </h3>
        
    <br><br><br>

    <?php
    if (!isset($_SESSION["user_id"]))
    {
    ?>

        <form action="login/index.php">
            <button>Login</button>
        </form>

        <br><br><br>

        <form action="signup/index.php">
            <button>Signup</button>
        </form>
        
    <?php
    }
    else
    {
    ?>

        <a href="cars-data/index.php">
            <button>Go to cars</button>
        </a>

        <br><br><br>
        
        <form action="login/logout-handler.php" method="post">
            <input type="submit" value="Logout">
        </form>

    <?php
    }
    ?>
    
</body>
</html>