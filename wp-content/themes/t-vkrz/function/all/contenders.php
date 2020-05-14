<?php
function formatContenderHtml( $tournament, $v_id, $index ) {
	ob_start();
	?>
    <a data-contender-tournament="<?= $tournament ?>"
       data-contender-chosen="<?= $v_id ?>"
       id="c_<?= $index ?>"
    >
		<?php
		echo get_the_post_thumbnail( $v_id, 'full', array( 'class' => 'img-fluid' ) );
		?>
        <h2 class="title-contender">
			<?php echo get_the_title( $v_id ); ?>
        </h2>
    </a>
	<?php
	return ob_get_clean();
}

function getClassementHtml( $tournament_id ) {
	$contenders = new WP_Query(
		array(
			'post_type'      => 'contender',
			'posts_per_page' => - 1,
			'meta_key'       => 'ELO_c',
			'orderby'        => 'meta_value',
			'order'          => 'DESC',
			'meta_query'     => array(
				array(
					'key'     => 'id_tournoi_c',
					'value'   => $tournament_id,
					'compare' => 'LIKE',
				)
			)
		)
	);
	$i          = 1;
	ob_start();
	while ( $contenders->have_posts() ) : $contenders->the_post(); ?>

        <div class="contenders_min col">

            <div class="rank">
                <h3>
					<?php echo $i; ?>
                </h3>
            </div>

            <div class="illu">
				<?php if ( has_post_thumbnail() ) : ?>
					<?php the_post_thumbnail( 'full', array( 'class' => 'img-fluid' ) ); ?>
				<?php endif; ?>
            </div>
            <div class="name">
                <h5>
					<?php the_title(); ?>
                </h5>
                <h6>
					<?php the_field( 'ELO_c' ); ?>
                </h6>
            </div>

        </div>

		<?php $i ++; endwhile;
	wp_reset_query();

	return ob_get_clean();
}
