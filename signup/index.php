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

    <h3>Signup</h3>
    <br>
    <form action="handler.php" method="post">
        <?php
        signup_inputs();
        ?>
        <input type="submit" value="Signup">
    </form>

    <?php
    check_signup_errors();
    ?>

    <br><br><br>

    <form action="../index.php">
        <button>Go to homepage</button>
    </form>
    
</body>
</html>