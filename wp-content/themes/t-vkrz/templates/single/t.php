<?php
$id_tournament           = get_the_ID();
$uuiduser                = $_COOKIE["vainkeurz_user_id"];
$id_ranking              = get_or_create_ranking_if_not_exists($id_tournament);
extract(get_next_duel($id_ranking, $id_tournament));
get_header();
$illu       = wp_get_attachment_image_src(get_field('cover_t', $id_tournament), 'full');
$illu_url   = $illu[0];
?>
<body <?php body_class('cover'); ?> style="background: url(<?php echo $illu_url; ?>) center center no-repeat">

<?php get_template_part('templates/partials/header'); ?>

<?php if ($is_next_duel): ?>
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
                        </h2>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="<?php if(get_field('c_rounded_t', $id_tournament)){ echo 'rounded'; } ?> <?php if(get_field('full_w_t', $id_tournament)){ echo 'container-fluid'; } else { echo 'container'; } ?>">
        <div class="row">
            <div class="col-md-12">
                <div class="display_battle">
                    <?php
                        set_query_var('battle_vars', compact('contender_1', 'contender_2', 'id_tournament', 'all_votes_counts'));
                        get_template_part('templates/parts/content', 'battle');
                    ?>
                </div>
            </div>
        </div>
    </div>
    <?php
    set_query_var('steps_var', compact('current_step'));
    get_template_part('templates/parts/content', 'step-bar');
    ?>

<?php else: ?>

    <div class="finish_tournoi">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="text-center">
                        <i class="fal fa-badge-check"></i>
                        <br>
                        Bravo,
                        <br>vous avez terminé ce tournoi
                    </h2>
                    <div class="more_links text-center">
                        <ul class="list-unstyled">
                            <li>
                                <a href="<?php the_permalink($id_ranking); ?>" class="cta_2">
                                    Voir votre classement
                                </a>
                            </li>
                            <li>
                                <a href="<?php the_permalink(get_page_by_path('elo')); ?>?id_tournoi=<?php echo $id_tournament; ?>" class="cta_2 cta-1">
                                    Voir le classement général
                                </a>
                            </li>
                        </ul>
                        <div>
                            <a href="<?php bloginfo( 'url' ); ?>/" class="cta-2 cta_btn aaa">
                                <i class="fad fa-arrow-alt-to-left"></i> Retourner à la liste des tournois
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>

<?php get_footer(); ?>
