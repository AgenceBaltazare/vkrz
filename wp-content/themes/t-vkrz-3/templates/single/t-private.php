<?php
global $user_id;
global $uuiduser;
global $id_vainkeur;
global $id_ranking;
global $id_top;
global $is_next_duel;
global $top_infos;
global $utm;
global $user_infos;
global $user_tops;
$user_id       = get_user_logged_id();
$utm           = deal_utm();
$id_top        = get_the_ID();
$user_tops     = get_user_tops();
$uuiduser      = deal_uuiduser();
$user_infos    = deal_vainkeur_entry();
$id_vainkeur   = $user_infos['id_vainkeur'];
if ($id_vainkeur) {
    $current_id_vainkeur = $id_vainkeur;
}
$id_ranking    = get_user_ranking_id($id_top, $uuiduser);
if ($id_ranking) {
    extract(get_next_duel($id_ranking, $id_top, $current_id_vainkeur));
    if (!$is_next_duel) {
        wp_redirect(get_the_permalink($id_ranking));
    }
}
get_header();
$top_datas          = get_top_data($id_top);
$creator_id         = get_post_field('post_author', $id_top);
$creator_uuiduser   = get_field('uuiduser_user', 'user_' . $creator_id);
$creator_data       = get_user_infos($creator_uuiduser);
?>
<div class="app-content content cover" style="background: url(<?php echo $top_infos['top_cover']; ?>) center center no-repeat">
    <div class="content-overlay"></div>
    <div class="content-wrapper">
        <div class="content-body tournoi-content">

            <?php if (!$id_ranking) : ?>

                <div class="content-intro">

                    <div class="intro">

                        <div class="card animate__animated animate__flipInX card-developer-meetup">
                            <div class="meetup-img-wrapper rounded-top text-left" style="background-image: url(<?php echo $top_infos['top_img']; ?>);">
                                <span class="badge badge-light-primary">Créé le <?php echo $top_infos['top_date']; ?></span>
                                <div class="voile_contenders"></div>
                                <div class="avatar-group list-contenders">
                                    <?php $contenders_t = new WP_Query(array(
                                        'post_type' => 'contender', 'orderby' => 'date', 'posts_per_page' => '-1',
                                        'meta_query'     => array(
                                            array(
                                                'key'     => 'id_tournoi_c',
                                                'value'   => $id_top,
                                                'compare' => '=',
                                            )
                                        )
                                    )); ?>
                                    <?php while ($contenders_t->have_posts()) : $contenders_t->the_post(); ?>
                                        <div data-toggle="tooltip" data-popup="tooltip-custom" data-placement="top" data-original-title="<?php echo get_the_title(get_the_id()); ?>" class="avatar pull-up">
                                            <?php $illu = get_the_post_thumbnail_url(get_the_id(), 'medium'); ?>
                                            <img src="<?php echo $illu; ?>" alt="Avatar" height="32" width="32">
                                        </div>
                                    <?php endwhile; ?>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="meetup-header d-flex align-items-center justify-content-center">
                                    <div class="my-auto">
                                        <h4 class="card-title mb-25">
                                            Top privé ⚡ <?php echo $top_infos['top_title']; ?>
                                        </h4>
                                        <p class="card-text mb-0 t-rose animate__animated animate__flash">
                                            <?php echo $top_infos['top_question']; ?>
                                        </p>
                                    </div>
                                </div>
                                <?php if (get_field('precision_t', $id_top)) : ?>
                                    <div class="card-precision">
                                        <p class="card-text mb-1">
                                            <?php the_field('precision_t', $id_top); ?>
                                        </p>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <div class="card-cta">
                                <div class="choosecta">
                                    <div class="cta-begin cta-complet">
                                        <a href="#" id="begin_t" data-typetop="complet" data-top="<?php echo $id_top; ?>" data-uuiduser="<?php echo $uuiduser; ?>" class="w-100 animate__jello animate__animated animate__delay-1s btn btn-max btn-primary waves-effect waves-float waves-light laucher_t">
                                            Top Complet
                                        </a>
                                        <small class="text-muted">
                                            <?php
                                            $min = ($top_infos['top_number'] - 5) * 2 + 6;
                                            $max = $min * 2;
                                            ?>
                                            <?php if ($top_infos['top_number'] < 3) : ?>
                                                Un seul vote suffira pour finir ce Top
                                            <?php else : ?>
                                                Prévoir entre <?php echo $min; ?> et <?php echo $max; ?> votes pour finir ton Top du 1er au dernier
                                            <?php endif; ?>
                                        </small>
                                    </div>
                                    <?php if ($top_infos['top_number'] > 10) : ?>
                                        <div class="cta-begin cta-top3">
                                            <a href="#" id="begin_top3" data-typetop="top3" data-top="<?php echo $id_top; ?>" data-uuiduser="<?php echo $uuiduser; ?>" class="w-100 animate__jello animate__animated animate__delay-1s btn btn-max btn-primary waves-effect waves-float waves-light laucher_t">
                                                Top 3
                                            </a>
                                            <small class="text-muted">
                                                <?php
                                                $max = (floor($top_infos['top_number'] / 2)) + (3 * ((round($top_infos['top_number'] / 2)) - 1));
                                                $min = (floor($top_infos['top_number'] / 2)) + ((round($top_infos['top_number'] / 2)) - 1) + 3;
                                                $moy = ($max + $min) / 2;
                                                ?>
                                                Prévoir environ <?php echo round($moy); ?> votes pour juste faire ton podium
                                            </small>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="card-footer">
                                <div class="row meetings align-items-center">
                                    <div class="col">
                                        <div class="infos-card-t info-card-t-v d-flex align-items-center">
                                            <div class="mr-1">
                                                <span class="ico">💎</span>
                                            </div>
                                            <div class="content-body text-left">
                                                <h4 class="mb-0">
                                                    <?php echo $top_datas['nb_votes']; ?>
                                                </h4>
                                                <small class="text-muted">votes réalisés</small>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="infos-card-t d-flex align-items-center">
                                            <div class="mr-1">
                                                <span class="ico">🏆</span>
                                            </div>
                                            <div class="content-body text-left">
                                                <h4 class="mb-0">
                                                    <?php echo $top_datas['nb_tops']; ?>
                                                </h4>
                                                <small class="text-muted">Tops terminés</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            <?php else : ?>

                <div class="intro-mobile">
                    <div class="tournament-heading text-center">
                        <h3 class="mb-0 t-titre-tournoi">Top privé <span class="ico">⚔️</span> <?php echo $top_infos['top_title']; ?></h3>
                        <h4 class="text-center t-question">
                            <?php echo $top_infos['top_question']; ?> <br>
                        </h4>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <?php if ($top_infos['top_type'] != "top3") : ?>
                            <div class="container-fluid d-none d-sm-block">
                                <div class="tournoi-infos mb-2">
                                    <div class="display_current_user_rank">
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="current_rank">
                                                    <?php
                                                    set_query_var('current_user_ranking_var', compact('id_ranking', 'id_top'));
                                                    get_template_part('templates/parts/content', 'user-ranking');
                                                    ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>

                        <div class="container <?php echo (get_field('c_rounded_t', $id_top)) ? 'rounded' : ''; ?>">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="display_battle">
                                        <?php
                                        set_query_var('battle_vars', compact('contender_1', 'contender_2', 'id_top', 'id_ranking', 'id_vainkeur'));
                                        get_template_part('templates/parts/content', 'battle');
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <?php
                set_query_var('steps_var', compact('current_step'));
                get_template_part('templates/parts/content', 'step-bar');
                ?>

            <?php endif; ?>
        </div>
    </div>
</div>

<?php if ($id_ranking) : ?>
    <nav class="navbar mobile-navbar">
        <div class="icons-navbar">
            <div class="ico-nav-mobile">
                <a href="<?php echo get_the_permalink(get_page_by_path('discuz')) . '?id_top=' . $id_top; ?>">
                    <span class="ico">💬</span> <span class="hide-spot">Commenter</span>
                </a>
            </div>
            <div class="ico-nav-mobile">
                <a data-phrase1="Es-tu sûr de vouloir recommencer ?" data-phrase2="Tous les votes de ce Top seront remis à 0" data-id_ranking="<?php echo $id_ranking; ?>" data-id_vainkeur="<?php echo $id_vainkeur; ?>" href="#" class="confirm_delete">
                    <span class="ico">🆕</span> <span class="hide-spot">Recommencer</span>
                </a>
            </div>
        </div>
    </nav>
<?php endif; ?>

<?php get_footer(); ?>