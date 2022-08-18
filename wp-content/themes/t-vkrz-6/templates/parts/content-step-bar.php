<?php
    $current_step = 0;
	extract($steps_var);
?>
<div class="stepbar" style="width: <?php echo $current_step; ?>%;">
    <div class="stepbar-content">
        <span>
            <?php echo round($current_step, 2); ?> %
        </span>
    </div>
</div>
