<?php
	extract($steps_var);
?>
<div class="stepbar <?php echo $bar_step; ?>">
	<h5>
		<?php
		if ( $bar_step == "step_bar_1" ) {
			$step_name = "On prend son mal en patience le temps d'évacuer les plus faibles !";
		} elseif ( $bar_step == "step_bar_2" ) {
			$step_name = "Bon il y a encore du monde à évacuer mais ça chauffe de plus en plus";
		} elseif ( $bar_step == "step_bar_3" ) {
			$step_name = "Ça commence à être du sérieux.";
		} elseif ( $bar_step == "step_bar_4" ) {
			$step_name = "Là ça devient chaud non ?";
		} elseif ( $bar_step == "step_bar_5" ) {
			$step_name = "Que des chocs de titans !!!";
		} elseif ( $bar_step == "fin_tournoi_bar" ) {
			$step_name = "Aie Aie Aie - nous y sommes - c'est le duel final !!!";
		}
		?>
		<?php echo $current_step; ?> - <span><?php echo $step_name; ?></span>
	</h5>
</div>
