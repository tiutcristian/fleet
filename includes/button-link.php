<?php
    function button_link($text, $url, $class)
    {
        ?>
            <form action="<?=$url?>" method="GET" class="button-link">
                <button class="<?=$class?>"><?=$text?></button>
            </form>
        <?php
    }