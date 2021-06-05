<?php extract( $user_votes_vars ) ?>
<h6>
	<?php if ( $nb_user_votes == 0 ) : ?>
        Aucun vote encore
	<?php elseif ( $nb_user_votes == 1 ) : ?>
        Bravo pour ton 1er vote
	<?php else : ?>
        Vos votes : <?php echo $nb_user_votes; ?>
	<?php endif; ?>
</h6>

