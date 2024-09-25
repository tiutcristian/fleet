<?php
    require_once 'config.php';
    require_once 'config-session.php';
    require_once 'button-link.php';
?>

<script>
    function test_fetch()
    {
        fetch("<?=$config["base_url"]?>/test.php")
            .then(response => response.json())
            .then(data => console.log(data));
    }
</script>

<nav class="container-fluid">
    <ul>
        <li><a href="<?=$config["base_url"]?>" class="nav-bar-title">Car Fleet Management</a></li>
    </ul>
    <ul>
        <?php
            if (isset($_SESSION["user_id"]))
            {
                ?>
                    <li>Hello, <?=$_SESSION["user_username"]?></li>
                    <li><button onclick="test_fetch()">Ceva</button></li>
                    <li><?php button_link("Logout", $config["base_url"]."login/logout-handler.php", "outline");?></li>
                <?php
            }
            else
            {
                ?>
                    <li><?php button_link("Login", $config["base_url"]."login", "outline"); ?></li>
                    <li><?php button_link("Signup", $config["base_url"]."signup", "outline");?></li>
                <?php
            }
        ?>
    </ul>
</nav>