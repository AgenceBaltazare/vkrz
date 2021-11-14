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
<script>
    const link_to_ranking = "<?= get_the_permalink($id_ranking) ?>";
</script>
<div class="app-content-marqueblanche content cover" style="background: url(<?php echo $top_infos['top_cover']; ?>) center center no-repeat">
    <div class="content-wrapper">
        <div class="content-body tournoi-content">

            <?php if (!$id_ranking) : ?>

                <div class="container intro-sponso">

                    <div class="row match-height">
                        <div class="col-md-8 offset-md-2">
                            <div class="intro">
                                <div class="animate__animated animate__flipInX card-developer-meetup">
                                    <div class="card-body">
                                        <div class="logomarque">
                                            <img src="<?php echo $top_infos['top_img']; ?>" class="img-fluid" alt="">
                                        </div>
                                        <div class="meetup-header d-flex align-items-center justify-content-center">
                                            <div class="my-auto">
                                                <h4 class="card-title mb-25">
                                                    Tirage au sort
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
                                            <div class="cta-begin cta-top3">
                                                <a href="#" id="begin_top3" data-typetop="top3" data-top="<?php echo $id_top; ?>" data-uuiduser="<?php echo $uuiduser; ?>" class="w-100 animate__jello animate__animated animate__delay-1s btn btn-max btn-primary waves-effect waves-float waves-light laucher_t">
                                                    Faire mon classement
                                                </a>
                                                <small class="text-muted">
                                                    <?php
                                                    $max = (floor($top_infos['top_number'] / 2)) + (3 * ((round($top_infos['top_number'] / 2)) - 1));
                                                    $min = (floor($top_infos['top_number'] / 2)) + ((round($top_infos['top_number'] / 2)) - 1) + 3;
                                                    $moy = ($max + $min) / 2;
                                                    ?>
                                                    Prévoir environ <?php echo round($moy); ?> votes pour faire ton podium
                                                </small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            <?php else : ?>

                <div class="intro-marqueblanche">
                    <div class="logo_marqueblanche">
                        <?php echo wp_get_attachment_image(get_field('logo_marque_blanche_t', $id_top), 'full', '', array('class' => 'img-fluid')); ?>
                    </div>
                    <div class="w-100">
                        <h3 class="t-objectif-marqueblanche">
                            <?php echo $top_infos['top_question']; ?>
                        </h3>
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

                <div class="footer-battle">
                    <div class="social-media-marqueblanche">
                        <?php if (have_rows('reseaux_sociaux_marque_blanche_t', $id_top)) :
                            while (have_rows('reseaux_sociaux_marque_blanche_t', $id_top)) : the_row(); ?>
                                <a href=<?php the_sub_field('lien_reseaux_sociaux_marque_blanche_t', $id_top); ?> target="_blank">
                                    <?php if (get_sub_field('image_reseaux_sociaux_marque_blanche_t', $id_top)) : ?>
                                        <?php echo wp_get_attachment_image(get_sub_field('image_reseaux_sociaux_marque_blanche_t', $id_top), 'full', '', array('class' => 'img-fluid')); ?>
                                    <?php endif; ?>
                                </a>
                            <?php endwhile; ?>
                        <?php endif; ?>
                    </div>
                    <div class="w-100">
                        <a ata-phrase1="Es-tu sûr de vouloir recommencer ?" data-phrase2="Tous les votes de ce Top seront remis à 0" data-id_ranking="<?php echo $id_ranking; ?>" data-id_vainkeur="<?php echo $id_vainkeur; ?>" href="#" class="confirm_delete" class="btn">
                            <h3 class="restart-marqueblanche">
                                Recommencer le top
                            </h3>
                        </a>
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

<?php get_footer(); ?>