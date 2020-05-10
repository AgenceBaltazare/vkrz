<?php

add_action( 'wp_ajax_vocajob_loadmore', 'vocajob_loadmore' );
add_action( 'wp_ajax_nopriv_vocajob_loadmore', 'vocajob_loadmore' );

function vocajob_loadmore() {
	$posts_already_on_page = $_POST['posts_on_page'];

	$random_fiches = new WP_Query(
		array(
			'post_type'      => 'post',
			'orderby'        => 'rand',
			'posts_per_page' => 40,
			'post__not_in'   => $posts_already_on_page
		) );

	ob_start();
	?>
	<?php while ( $random_fiches->have_posts() ) : $random_fiches->the_post(); ?>

        <div class="section__col col-12 col-md-4 col-lg-3">

			<?php get_template_part( 'partial/min_metier' ); ?>

        </div><!-- /.section__col col-12 col-md-6 col-lg-3 -->

	<?php endwhile;

	return die( json_encode( [
		'content'              => ob_get_clean(),
		'hide_loadmore_button' => (int) $random_fiches->found_posts === (int) $random_fiches->post_count
	] ) );
}


add_action( 'wp_ajax_vocajob_do_search', 'vocajob_search' );
add_action( 'wp_ajax_nopriv_vocajob_do_search', 'vocajob_search' );
function vocajob_search() {
	$searchQuery = new WP_Query( array(
		's' => sanitize_text_field( $_POST['s'] ),
		//'post_type' => ['metier'] Mettre dans le tableau ce qui doit ressortir de la recherche
	) );

	ob_start();
	?>
    <div class="popup__row row">
		<?php if ( $searchQuery->have_posts() ) : ?>
			<?php while ( $searchQuery->have_posts() ) : $searchQuery->the_post(); ?>
                <div class="popup__col col-12 col-md-6 col-lg-4">

					<?php get_template_part( 'partial/min_metier' ); ?>

                </div>
			<?php endwhile; ?>
		<?php else: ?>
            <h2 style="color: #ffffff"><?= __( 'Pas de résultat pour votre recherche', 'vocajob' ) ?></h2>
		<?php endif; ?>
    </div>
	<?php
	wp_reset_postdata();

	return die( json_encode( [
			'content' => ob_get_clean()
		]
	) );

}
