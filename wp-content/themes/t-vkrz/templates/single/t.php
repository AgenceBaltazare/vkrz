<?php get_header(); ?>
<?php
$id_tournoi      = get_the_ID();
$list_contenders = array();
$all_votes       = new WP_Query( array(
	'post_type'      => 'vote',
	'posts_per_page' => - 1,
	'meta_query'     => array(
		array(
			'key'     => 'id_t_v',
			'value'   => $id_tournoi,
			'compare' => '=',
		)
	)
) );
$contenders      = new WP_Query( array(
	'post_type'      => 'contender',
	'posts_per_page' => - 1,
	'orderby'        => 'date',
	'meta_query'     => array(
		array(
			'key'     => 'id_tournoi_c',
			'value'   => $id_tournoi,
			'compare' => '=',
		)
	)
) );
$i               = 0;
while ( $contenders->have_posts() ) : $contenders->the_post();

	array_push( $list_contenders, get_the_ID() );

	$rand_c = array_rand( $list_contenders, 2 );
	$id_c_1 = $list_contenders[ $rand_c[0] ];
	$id_c_2 = $list_contenders[ $rand_c[1] ];

	$i ++; endwhile;

$nums_pairs = "";
$nb_battle  = 0;
for ( $i = 0; $i <= count( $list_contenders ); $i ++ ) {
	for ( $j = $i + 1; $j < count( $list_contenders ); $j ++ ) {
		$nums_pairs .= $list_contenders[ $i ] . "," . $list_contenders[ $j ] . "<br>";
		$nb_battle ++;
	}
}

wp_reset_query();
?>
<div class="main">
    <header class="header">
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="col-6">
                    <div class="logo">
                        <a href="<?php bloginfo( 'url' ); ?>/">
                            <img src="<?php bloginfo( 'template_directory' ); ?>/assets/img/logo-vainkeurz-min.png"
                                 alt="" class="img-fluid">
                        </a>
                    </div>
                </div>
                <div class="col-6">
                    <div class="display_votes">
                        <h6>
							<?php echo $all_votes->post_count; ?> votes
                        </h6>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <div class="container">
        <div class="tournoi_infos">
            <div class="row align-items-center">
                <div class="col-12">
                    <div class="bloc-titre">
                        <h1 class="title-battle">
                            <b>
								<?php the_title(); ?>
                            </b>
                            <span>
                                <?php the_field( 'question_t' ); ?>
                                <em><?php echo $nb_battle; ?> duels possibles</em>
                            </span>
                        </h1>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="display_battle">
                    <div class="row align-items-center">
                        <div class="col-5 link-contender">
	                        <?= formatContenderHtml($id_tournoi, $id_c_1, 1)?>
                        </div>
                        <div class="col-2">
                            <h4 class="text-center versus">
                                VS
                            </h4>
                        </div>
                        <div class="col-5 link-contender">
                            <?= formatContenderHtml($id_tournoi, $id_c_2, 2)?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="classement_t row">
                    <?= getClassementHtml($id_tournoi) ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php get_footer(); ?>
