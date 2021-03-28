<?php
$id_tournament           = get_the_ID();
$id_ranking              = get_or_create_ranking_if_not_exists($id_tournament);
extract(get_next_duel($id_ranking, $id_tournament));
get_header();
$illu       = wp_get_attachment_image_src(get_field('cover_t', $id_tournament), 'full');
$illu_url   = $illu[0];
?>

<!-- BEGIN: Content-->
<div class="app-content content cover" style="background: url(<?php echo $illu_url; ?>) center center no-repeat">
    <div class="content-overlay"></div>
    <div class="content-wrapper">
        <div class="content-header row"></div>
        <div class="content-body tournoi-content">

            <?php if ($is_next_duel): ?>
                <div class="container">
                    <div class="tournoi-infos">
                        <div class="row align-items-center">
                            <div class="col-12">
                                <div class="bloc-titre">
                                    <h1>
                                        <b>
                                            <?php the_title(); ?> : Génère ton Top <?php echo get_numbers_of_contenders($id_tournament); ?> 👇
                                        </b>
                                    </h1>
                                    <h2>
                                        <?php the_field( 'question_t' ); ?>
                                    </h2>
                                </div>
                            </div>
                        </div>
                        <div class="display_current_user_rank d-none d-sm-block">
                            <div class="row">
                                <div class="col-12">
                                    <div class="current_rank">
                                        <?php
                                        set_query_var('current_user_ranking_var', compact('id_ranking'));
                                        get_template_part('templates/parts/content', 'user-ranking');
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="<?php if(get_field('c_rounded_t', $id_tournament)){ echo 'rounded'; } ?> <?php if(get_field('full_w_t', $id_tournament)){ echo 'container container-cc'; } else { echo 'container'; } ?>">
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
                        <div class="row justify-content-center aaa">
                            <div class="col-md-6">
                                <div class="card card-congratulations">
                                    <div class="card-body text-center">
                                        <img src="<?php bloginfo('template_directory'); ?>/app-assets/images/elements/decore-left.png" class="congratulations-img-left" alt="card-img-left">
                                        <img src="<?php bloginfo('template_directory'); ?>/app-assets/images/elements/decore-right.png" class="congratulations-img-right" alt="card-img-right">
                                        <div class="avatar avatar-xl bg-primary shadow">
                                            <div class="avatar-content">
                                                <?php
                                                $id_vainkeur = get_user_vainkeur($id_ranking);
                                                $illu_vainkeur = get_the_post_thumbnail_url($id_vainkeur, 'full');
                                                ?>
                                                <img src="<?php echo $illu_vainkeur; ?>">
                                            </div>
                                        </div>
                                        <div class="text-center">
                                            <h1 class="mb-1 text-white">
                                                Bravo,
                                                <br>vous avez terminé ce tournoi
                                            </h1>
                                        </div>
                                        <div class="card-footer text-muted">
                                            <a href="<?php the_permalink($id_ranking); ?>" class="btn btn-primary btn-block waves-effect waves-float waves-light mb-2">Voir mon classement</a>
                                            <a href="<?php the_permalink(get_page_by_path('elo')); ?>?id_tournoi=<?php echo $id_tournament; ?>" class="btn-block btn btn-outline-primary waves-effect">Découvrir le classement mondial</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

        </div>
    </div>
</div>
<!-- END: Content-->

<?php get_footer(); ?>
