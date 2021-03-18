<?php
$id_tournament           = get_the_ID();
$uuiduser                = $_COOKIE["vainkeurz_user_id"];
$list_contenders         = array();
$list_votes              = array();
$next_duel               = array();
$is_next_duel            = true;

$nb_user_votes  = all_user_votes_in_tournament($id_tournament);

$id_ranking = get_or_create_ranking_if_not_exists($id_tournament);

extract(get_next_duel($id_ranking, $id_tournament));

wp_reset_query();

get_header();

if ( get_field( 'cover_t' ) ) {
    $illu     = wp_get_attachment_image_src( get_field( 'cover_t' ), 'full' );
    $illu_url = $illu[0];
}
?>
<body style="background: url(<?php echo $illu_url; ?>) center center no-repeat">

<div class="main">

    <header class="header">
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="col-sm-4">
                    <div class="logo">
                        <a href="<?php bloginfo('url'); ?>/">
                            <img src="<?php bloginfo( 'template_directory' ); ?>/assets/img/logo-vainkeurz.png" alt="" class="img-fluid">
                        </a>
                    </div>
                </div>
                <div class="col-sm-8 text-right">
                    <div class="display_users_votes">
                        <?php
                        set_query_var( 'user_votes_vars', compact( 'nb_user_votes' ) );
                        get_template_part( 'templates/parts/content', 'user-votes' );
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </header>
	<?php if ( $is_next_duel ): ?>
        <div class="container">
            <div class="tournoi_infos">
                <div class="row align-items-center">
                    <div class="col-12">
                        <div class="bloc-titre">
                            <h1>
                                <b>
									<?php the_title(); ?>
                                </b>
                            </h1>
                            <h2>
								<?php the_field( 'question_t' ); ?>
                                <span class="toshowpopover moreinfo" data-container="body" data-toggle="popover" data-placement="top" data-content="<?php the_field( 'precision_t' ); ?>">
                                    <i class="fal fa-info-circle"></i>
                                </span>
                            </h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="display_battle">
						<?php
						    set_query_var( 'battle_vars', compact( 'contender_1', 'contender_2', 'id_tournament', 'all_votes_counts' ) );
						    get_template_part( 'templates/parts/content', 'battle' );
						?>
                    </div>
                </div>
            </div>
        </div>
	<?php else: ?>
        <div class="finish_tournoi">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <h2 class="text-center">
                            <i class="fal fa-badge-check"></i>
                            <br>
                            Félicitations,
                            <br>vous avez terminé ce tournoi
                        </h2>
                        <div class="more_links text-center">
                            <ul class="list-unstyled list-inline">
                                <li>
                                    <a href="<?php the_permalink( $id_ranking ); ?>" class="cta_2">
                                        Voir votre classement
                                    </a>
                                </li>
                                <br>
                                <li>
                                    <a href="<?php the_permalink(get_page_by_path('classement-elo')); ?>?id_tournoi=<?php echo $id_tournament; ?>" target="_blank" class="cta-1 cta_btn">
                                        Voir le classement global
                                    </a>
                                </li>
                            </ul>
                            <div>
                                <a href="<?php bloginfo( 'url' ); ?>/" class="cta-2 cta_btn">
                                    Retourner aux tournois
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
	<?php endif; ?>
</div>

<?php get_footer(); ?>
