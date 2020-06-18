<?php extract( $battle_vars ); ?>
<div class="row align-items-center contenders-containers">
	<?php if ( get_field( 'visuel_cover_t' ) ): ?>
        <div class="col-5 bloc-contenders link-contender_1 contender_1 cover_contenders link-contender"

        >
            <a href="<?php the_permalink( $id_tournoi ); ?>?v=<?php echo $contender_1; ?>&l=<?php echo $contender_2; ?>"
               data-id-winner="<?= $contender_1 ?>"
               data-id-looser="<?= $contender_2?>"
               data-id-tournament="<?= $id_tournoi ?>"
               id="c_1"
            >
				<?php
				if ( has_post_thumbnail() ) {
					$illu = get_the_post_thumbnail_url( $contender_1, 'full' );
				}
				?>
                <div class="cov-illu" style="background: url(<?php echo $illu; ?>) center center no-repeat"></div>
				<?php if ( ! get_field( 'ne_pas_afficher_les_titres_t' ) ): ?>
                    <h2 class="title-contender">
						<?php echo get_the_title( $contender_1 ); ?>
                    </h2>
				<?php endif; ?>
            </a>
        </div>
	<?php else: ?>
        <div class="col-5 bloc-contenders link-contender_1 contender_1 link-contender">
            <a href="<?php the_permalink( $id_tournoi ); ?>?v=<?php echo $contender_1; ?>&l=<?php echo $contender_2; ?>"
               data-id-winner="<?= $contender_1 ?>"
               data-id-looser="<?= $contender_2?>"
               data-id-tournament="<?= $id_tournoi ?>"
               id="c_1"
            >
				<?php
				echo get_the_post_thumbnail( $contender_1, 'full', array( 'class' => 'img-fluid' ) );
				?>
				<?php if ( ! get_field( 'ne_pas_afficher_les_titres_t' ) ): ?>
                    <h2 class="title-contender">
						<?php echo get_the_title( $contender_1 ); ?>
                    </h2>
				<?php endif; ?>
            </a>
        </div>
	<?php endif; ?>

    <div class="col-2">
        <div class="display_votes">
            <h6>
				<?php echo $all_votes_counts; ?> votes
            </h6>
        </div>
        <h4 class="text-center versus">
            VS
        </h4>
    </div>

    <?php if ( get_field( 'visuel_cover_t' ) ): ?>
        <div class="col-5 bloc-contenders link-contender_2 contender_2 cover_contenders link-contender">
            <a href="<?php the_permalink( $id_tournoi ); ?>?v=<?php echo $contender_2; ?>&l=<?php echo $contender_1; ?>"
               data-id-winner="<?= $contender_2 ?>"
               data-id-looser="<?= $contender_1 ?>"
               data-id-tournament="<?= $id_tournoi ?>"
               id="c_2"
            >
				<?php
				if ( has_post_thumbnail() ) {
					$illu = get_the_post_thumbnail_url( $contender_2, 'full' );
				}
				?>
                <div class="cov-illu" style="background: url(<?php echo $illu; ?>) center center no-repeat"></div>
				<?php if ( ! get_field( 'ne_pas_afficher_les_titres_t' ) ): ?>
                    <h2 class="title-contender">
						<?php echo get_the_title( $contender_2 ); ?>
                    </h2>
				<?php endif; ?>
            </a>
        </div>
	<?php else: ?>
        <div class="col-5 bloc-contenders link-contender_2 contender_2 link-contender">
            <a href="<?php the_permalink( $id_tournoi ); ?>?v=<?php echo $contender_2; ?>&l=<?php echo $contender_1; ?>"
               data-id-winner="<?= $contender_2 ?>"
               data-id-looser="<?= $contender_1 ?>"
               data-id-tournament="<?= $id_tournoi ?>"
               id="c_2"

            >
				<?php
				echo get_the_post_thumbnail( $contender_2, 'full', array( 'class' => 'img-fluid' ) );
				?>
				<?php if ( ! get_field( 'ne_pas_afficher_les_titres_t' ) ): ?>
                    <h2 class="title-contender">
						<?php echo get_the_title( $contender_2 ); ?>
                    </h2>
				<?php endif; ?>
            </a>
        </div>
	<?php endif; ?>
</div>
