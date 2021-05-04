<?php
$id_tournament           = get_the_ID();
$id_ranking              = get_or_create_ranking_if_not_exists($id_tournament);
extract(get_next_duel($id_ranking, $id_tournament));
get_header();
$illu       = wp_get_attachment_image_src(get_field('cover_t', $id_tournament), 'full');
$illu_url   = $illu[0];
?>
<div class="app-content content cover" style="background: url(<?php echo $illu_url; ?>) center center no-repeat">
    <div class="content-overlay"></div>
    <div class="content-wrapper">
        <div class="content-header row"></div>
        <div class="content-body tournoi-content">

            <?php if ($is_next_duel): ?>

                <div class="container-fluid">
                    <div class="tournoi-infos">
                        <div class="display_current_user_rank d-none d-sm-block">
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

                <?php wp_redirect(get_the_permalink($id_ranking)); ?>

            <?php endif; ?>

        </div>
    </div>
</div>
<!-- END: Content-->

<?php get_footer(); ?>
