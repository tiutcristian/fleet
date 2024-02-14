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
    <title>Document</title>
</head>
<body>

    <?php 
        if (!isset($_SESSION["user_id"])) 
        { 
            ?>
                <h3>Login</h3>
                <br>
                <form action="login-handler.php" method="post">
                    <input type="text" name="username" placeholder="Username">
                    <br>
                    <input type="password" name="pwd" placeholder="Password">
                    <br>
                    <input type="submit" value="Login">
                </form>
            <?php 
        } 
        else 
        { 
            ?>
                <h3>Logout</h3>
                <br>
                <form action="logout-handler.php" method="post">
                    <input type="submit" value="Logout">
                </form>
            <?php 
        } 
    
        show_login_errors();
    ?>

    <br><br><br>

    <form action="../index.php">
        <button>Go to homepage</button>
    </form>
    
</body>
</html>