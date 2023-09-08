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

    <form action="login.php">
        <button>Login</button>
    </form>

    <br><br><br>

    <form action="signup.php">
        <button>Signup</button>
    </form>
    
</body>
</html>