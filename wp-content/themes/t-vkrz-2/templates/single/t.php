<?php
global $id_tournament;
$id_tournament           = get_the_ID();
$id_ranking              = get_or_create_ranking_if_not_exists($id_tournament);
extract(get_next_duel($id_ranking, $id_tournament));
if(!$is_next_duel){
    wp_redirect(get_the_permalink($id_ranking));
}
$illu       = wp_get_attachment_image_src(get_field('cover_t', $id_tournament), 'full');
$illu_url   = $illu[0];
foreach(get_the_terms($id_tournament, 'categorie' ) as $cat ) {
    $cat_id     = $cat->term_id;
    $cat_name   = $cat->name;
}
get_header();
?>
<div class="app-content content cover" style="background: url(<?php echo $illu_url; ?>) center center no-repeat">
    <div class="content-overlay"></div>
    <div class="content-wrapper">
        <div class="content-body tournoi-content">

            <div class="intro-mobile">
                <div class="tournament-heading text-center">
                    <h3 class="mb-0 t-titre-tournoi">Top <?php echo get_numbers_of_contenders(get_the_ID()); ?> <span class="ico">⚔️</span> <?php the_title(); ?></h3>
                    <h4 class="text-center t-question">
                        <?php the_field( 'question_t', $id_tournament ); ?> <br>
                    </h4>
                </div>
            </div>

            <?php if ($is_next_duel): ?>

                <div class="container-fluid">
                    <div class="tournoi-infos mb-2">
                        <div class="display_current_user_rank">
                            <div class="row">
                                <div class="col-12">
                                    <div class="current_rank">
                                        <?php
                                        set_query_var('current_user_ranking_var', compact('id_ranking', 'id_tournament'));
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
                                set_query_var('battle_vars', compact('contender_1', 'contender_2', 'id_tournament', 'all_votes_counts', 'id_ranking'));
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

            <?php endif; ?>

            <div class="nav-tournament d-flex justify-content-center align-items-center">
                <div class="btng">
                    <a data-phrase1="Es-tu sûr de toi ?" data-phrase2="Tous les votes de ce Top seront remis à 0" data-idranking="<?php echo $id_ranking; ?>" id="confirm_delete" href="#" class="btn btn-outline-primary waves-effect">
                        <span class="ico text-center">🙃</span> Recommencer
                    </a>
                </div>

                <div class="btng mr-5 ml-5">
                    <span class="share-label">
                        Partager <span class="ico text-center">👉</span>
                    </span>
                    <div class="btn-group justify-content-center share-t" role="group">
                        <?php
                        $url_tournament   = get_permalink($id_tournament);
                        $title_tournament = get_the_title($id_tournament);
                        ?>
                        <a href="https://twitter.com/intent/tweet?source=<?php echo $url_tournament; ?>&text=Viens faire ton TOP <?php echo get_numbers_of_contenders($id_tournament); ?> <?php echo $title_tournament; ?> - <?php the_field('question_t', $id_tournament); ?> 👉 <?php echo $url_tournament; ?>" target="_blank" title="Tweet" class="btn btn-icon btn-outline-primary">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a href="whatsapp://send?text=<?php echo $url_tournament; ?>" data-action="share/whatsapp/share" class="btn btn-icon btn-outline-primary">
                            <i class="fab fa-whatsapp"></i>
                        </a>
                        <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo $url_tournament; ?>&text=Viens faire ton TOP <?php echo get_numbers_of_contenders($id_tournament); ?> <?php echo $title_tournament; ?> - <?php the_field('question_t', $id_tournament); ?> 👉" title="Partager sur Facebook" target="_blank" class="btn btn-icon btn-outline-primary">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                    </div>
                </div>

                <div class="btng hide-xs">
                    <a href="<?php the_permalink(get_page_by_path('elo')); ?>?id_tournoi=<?php echo $id_tournament; ?>" class="btn btn-outline-primary waves-effect" target="_blank" >
                        <span class="ico ico-reverse text-center">👀</span> Classement mondial
                    </a>
                </div>
            </div>

        </div>
    </div>
</div>
<!-- END: Content-->

<?php get_footer(); ?>
