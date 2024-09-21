<?php
    
function page_button($element_class, $page, $is_disabled, $content)
{
    ?>
        <button 
            class='<?=$element_class?> page-button' 
            onclick='window.location.href="?page=<?=$page?>"' 
            <?=$is_disabled ? "disabled" : ""?>
        >
            <?=$content?>
        </button>
    <?php
}