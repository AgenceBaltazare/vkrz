<?php /* Template Name: Selection de Top */ ?>
<?php
get_header();
global $user_tops;
$list_user_tops     = $user_tops['list_user_tops_done_ids'];
$top_selected       = get_field('liste_des_tops_selectionnes_special', false, false);
?>
<div class="app-content content ecommerce-application">
    <div class="content-overlay"></div>
    <div class="content-wrapper">
        <div class="content-body">
            <div class="intro-mobile">
                <div class="tournament-heading text-center">
                    <h3 class="mb-0 t-titre-tournoi">
                        <span class="ico va va-wrapped-gift va-lg"></span> <?php the_field('intro_1_special'); ?>
                    </h3>
                    <h4 class="mb-0">
                        <?php the_field('intro_2_special'); ?>
                    </h4>
                </div>
            </div>

            <section class="grid-to-filtre row match-height mt-2 justify-content-center">

                <?php
                $top_selected_query = new WP_Query(array('post_type' => 'tournoi', 'orderby' => 'post__in', 'post__in' => $top_selected, 'posts_per_page' => '1'));
                while ($top_selected_query->have_posts()) : $top_selected_query->the_post(); ?>
                    <?php
                    $id_top             = get_the_ID();
                    $top_datas          = get_top_data($id_top);
                    $creator_id         = get_post_field('post_author', $id_top);
                    $creator_uuiduser   = get_field('uuiduser_user', 'user_' . $creator_id);
                    $creator_data       = get_user_infos($creator_uuiduser);
                    $user_sinle_top_data = array_search($id_top, array_column($list_user_tops, 'id_top'));
                    if ($user_sinle_top_data !== false) {
                        $state = $list_user_tops[$user_sinle_top_data]['state'];
                    } else {
                        $state = "todo";
                    }
                    $top_info       = get_top_infos($id_top);
                    $get_top_type   = get_the_terms($id_top, 'type');
                    foreach ($get_top_type as $type_top) {
                        $type_top = $type_top->slug;
                    }
                    ?>
                    <div class="same-h grid-item col-12 col-md-4">
                        <div class="min-tournoi card scaler">
                            <div class="cov-illu cover" style="background: url(<?php echo $top_info['top_img']; ?>) center center no-repeat; height: 200px;">
                                <?php if ($type_top == "sponso") : ?>
                                    <span class="badge badge-light-rose ml-0">Top sponso</span>
                                <?php endif; ?>
                                <?php if ($state == "done") : ?>
                                    <div class="badge badge-success">Terminé</div>
                                <?php elseif ($state == "begin") : ?>
                                    <div class="badge badge-warning">En cours</div>
                                <?php else : ?>
                                    <div class="badge badge-primary">A faire</div>
                                <?php endif; ?>
                                <div class="voile">
                                    <?php if ($state == "done") : ?>
                                        <div class="spoun topsponso">
                                            <h5>Participer</h5>
                                        </div>
                                    <?php elseif ($state == "begin") : ?>
                                        <div class="spoun topsponso">
                                            <h5>Terminer</h5>
                                        </div>
                                    <?php else : ?>
                                        <div class="spoun topsponso">
                                            <h5>Participer</h5>
                                        </div>
                                    <?php endif; ?>
                                </div>

                                <div class="info-top row align-items-center justify-content-center">
                                    <div class="info-top-col">
                                        <div class="infos-card-t info-card-t-v d-flex align-items-center">
                                            <div class="d-flex align-items-center mr-10px">
                                                <span class="ico va-high-voltage va va-md"></span>
                                            </div>
                                            <div class="content-body mt-01">
                                                <h4 class="mb-0">
                                                    <?php echo $top_datas['nb_votes']; ?>
                                                </h4>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="info-top-col">
                                        <div class="infos-card-t d-flex align-items-center">
                                            <div class="d-flex align-items-center mr-10px">
                                                <span class="ico va va-trophy va-md"></span>
                                            </div>
                                            <div class="content-body mt-01">
                                                <h4 class="mb-0">
                                                    <?php echo $top_datas['nb_tops']; ?>
                                                </h4>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card-body mb-3-hover text-center">
                                <p class="card-text text-primary font-weight-bold">

                                    <?php
                                    foreach (get_the_terms($id_top, 'categorie') as $cat) {
                                        $cat_id     = $cat->term_id;
                                        $cat_name   = $cat->name;
                                    }
                                    ?>
                                    TOP <?= $top_info['top_number']; ?> <?php the_field('icone_cat', 'term_' . $cat_id); ?> <span class="namecontenders"><?= $top_info['top_title']; ?></span>
                                </p>

                                <h3 class="card-title t-rose">
                                    <?= $top_info['top_question']; ?>
                                </h3>

                                <div class="card-footer a-gagner mt-1 p-1 d-flex flex-column align-items-left justify-content-between">

                                    <span class="text-muted mb-1 d-block">
                                        À gagner
                                    </span>

                                    <div style="background: url(<?= wp_get_attachment_image_url(get_field('cadeau_t_sponso', $id_top), 'large', false); ?>) no-repeat center center / contain; height: 150px;"></div>

                                    <h2 class="mt-2">
                                        <?= the_field('titre_de_la_sponso_t_sponso', $id_top); ?>
                                    </h2>

                                    <small class="text-primary" style="margin-top: -3px;">
                                        <?= the_field('fin_de_la_sponso_t_sponso', $id_top); ?>
                                    </small>
                                </div>
                            </div>
                            <a href="<?= $top_info['top_url']; ?>" class="stretched-link"></a>
                        </div>
                    </div>
                <?php endwhile;
                wp_reset_query(); ?>

            </section>

            <div class="row mt-5 match-height">

                <div class="col-12">

                    <div class="bloc-result">
                        <h3>
                            <?php the_field('phrase_follow_special'); ?>
                        </h3>
                        <div class="mt-10p">
                            <?php if (have_rows('liste_des_liens_special')) : ?>

                                <?php while (have_rows('liste_des_liens_special')) : the_row(); ?>

                                    <a href="<?php the_sub_field('lien_du_reseau_special'); ?>" class="sociallink btn btn-outline-primary waves-effect mr-10p mt-10p" target="_blank">
                                        <?php the_sub_field('nom_du_reseau_special'); ?>
                                    </a>

                                <?php endwhile; ?>

                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php get_footer(); ?>