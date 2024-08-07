<?php
require_once 'includes/config-session.php';

if (isset($_SESSION["user_id"]))
{
    header("Location: dashboard/");
    die();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php require_once 'includes/common-head-content.php'; ?>
    <title>Fleet homepage</title>
</head>
<body>
    <?php require_once 'includes/navbar.php'; ?>
    <main class="container">
        <hgroup>
            <h1>Welcome to the car fleet management service</h1>
            <h3>You are not logged in. Please log in or sign up to continue.</h3>
        </hgroup>
            
        <br><br><br>

        <div>
            <h1>Lorem Ipsum</h1>
            <p>Lorem ipsum odor amet, consectetuer adipiscing elit. Tincidunt dis sapien hendrerit class dictum et. 
                At semper ante velit; adipiscing a fringilla vitae porta. Neque velit platea suspendisse, ut montes porttitor maximus consectetur. 
                Bibendum magna vestibulum; in rutrum nullam per leo. Primis luctus mattis, in laoreet eget risus.</p>
            <p>Vulputate torquent gravida at neque etiam. Ullamcorper viverra ad lobortis vulputate sociosqu maecenas facilisi. 
                Senectus ex nisi libero primis vel purus. Tristique suscipit eleifend amet tempor molestie nisi bibendum elit finibus. 
                Scelerisque arcu varius tempor vulputate penatibus vitae lobortis tellus. Netus orci auctor augue libero ornare mattis conubia?
                 Magna natoque tincidunt nunc dis rhoncus. Interdum consectetur blandit condimentum venenatis cubilia nullam nisi molestie facilisis.</p>
            <p>Montes praesent phasellus efficitur congue nullam tincidunt netus. Porttitor felis enim adipiscing euismod tempus eros. 
                Commodo mattis praesent pellentesque ut leo curabitur augue. Purus bibendum tristique sodales vivamus fermentum. 
                Cursus suscipit tincidunt accumsan tellus ullamcorper nascetur tempor per. Natoque proin aptent in etiam cras lorem. 
                Volutpat blandit sapien pharetra, dui id inceptos facilisis? Feugiat curabitur class felis ad scelerisque ipsum et. 
                Enim tristique eros sapien; senectus nisl convallis.</p>
            <p>Lorem ipsum odor amet, consectetuer adipiscing elit. Viverra scelerisque nibh aliquam tempor tortor commodo laoreet maximus. 
                Habitant et nascetur nulla sollicitudin vehicula in. Mi maximus nisi lectus ex donec blandit rhoncus accumsan. 
                Posuere libero velit commodo natoque tincidunt rutrum duis posuere. Ligula dignissim auctor laoreet aptent integer integer cras pulvinar. 
                Suscipit urna class nisl himenaeos faucibus suspendisse.</p>
            <p>Curabitur posuere rhoncus vestibulum ante ad scelerisque. Duis gravida nulla placerat class ullamcorper ligula congue. 
                Velit est potenti risus tellus nisi vitae platea elit. Massa erat himenaeos himenaeos; praesent ac venenatis justo. 
                Netus per accumsan ligula litora nisl nam. Morbi volutpat posuere feugiat egestas class cubilia nisl convallis pulvinar.</p>
            <p>Ante cras diam duis non blandit et. Ligula urna phasellus turpis sagittis, tortor proin. Volutpat diam tortor, hac fusce consectetur quisque potenti. 
                Pretium eget cubilia curae lobortis hac libero. Varius lectus pellentesque mollis laoreet ex. Sit rutrum venenatis vivamus; 
                diam porta ultrices himenaeos primis phasellus. Primis commodo quis taciti massa nunc donec.</p>
            <p>Vehicula integer iaculis imperdiet aliquam dui ut. Suspendisse velit ipsum hac nullam ornare pretium; blandit nisi nullam. 
                Ipsum phasellus a justo conubia mi; per imperdiet curae libero. Eget proin primis dui cras lectus aenean fringilla mauris ut. 
                Himenaeos malesuada enim quam nibh aenean penatibus adipiscing velit parturient. Pharetra pellentesque laoreet nibh tempor facilisi curae? 
                Elit at nibh ornare; non egestas molestie. Est iaculis at purus gravida elit iaculis ad egestas.</p>
            <p>Himenaeos risus litora maximus est rutrum scelerisque id. In vivamus litora faucibus nisi inceptos pulvinar egestas finibus. 
                Cubilia velit finibus laoreet suspendisse hac scelerisque dis urna id. Risus duis parturient aliquam primis facilisis, 
                scelerisque vivamus metus malesuada. Sapien nibh etiam dolor leo ultricies vestibulum elementum dui. Urna parturient malesuada diam nisl 
                vestibulum nullam natoque integer. Primis aenean nisl eleifend nam ligula, odio massa aptent. Sodales nullam adipiscing etiam in et sagittis enim torquent.
                 Massa eget varius sagittis vivamus natoque dui.</p>
        </div>
    </main>
</body>
</html>