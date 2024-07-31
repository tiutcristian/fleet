<?php
require_once 'includes/config-session.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Picocss -->
    <link href="https://cdn.jsdelivr.net/npm/@picocss/pico@1/css/pico.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="css/main.css">
    
    <title>Fleet homepage</title>
</head>
<body>
    <main class="container">
        <hgroup>
            <h1>Welcome to the car fleet management service</h1>
            <h3>
                <?php 
                    if (isset($_SESSION["user_id"]))
                    {
                        echo "You are logged in as " . $_SESSION["user_username"];
                        if ($_SESSION["user_role"] == "admin")
                        {
                            echo " (admin)";
                        }
                    }
                    else
                    {
                        echo "You are not logged in";
                    }
                ?>
            </h3>
        </hgroup>
            
        <br><br><br>

        <div class="form-container">
            <?php
                if (!isset($_SESSION["user_id"]))
                {
                    ?>
                        <h3>Login or Signup</h3>
                        <div class="divider">
                            <form action="login/index.php">
                                <button class="outline">Login</button>
                            </form>
                            <form action="signup/index.php">
                                <button class="outline secondary">Signup</button>
                            </form>
                        </div>
                    <?php
                }
                else
                {
                    ?>
                        <a href="cars-data/index.php">
                            <button>Go to dashboard</button>
                        </a>                    
                        <form action="login/logout-handler.php" method="post">
                            <button class="outline">Logout</button>
                        </a>
                    <?php
                }
            ?>
        </div>
    </main>
</body>
</html>