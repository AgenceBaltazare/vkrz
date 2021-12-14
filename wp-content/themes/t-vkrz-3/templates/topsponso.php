<?php
    /*
        Template Name: Tops sponso
    */
?>
<?php
    get_header();
    global $user_tops;
    $list_user_tops     = $user_tops['list_user_tops'];
    $current_cat        = get_queried_object();
    $tops_in_cat        = new WP_Query(array(
        'post_type'                 => 'tournoi',
        'orderby'                   => 'date',
        'order'                     => 'DESC',
        'posts_per_page'            => -1,
        'ignore_sticky_posts'       => true,
        'update_post_meta_cache'    => false,
        'no_found_rows'             => true,
        'tax_query'                 => array(
            'relation' => 'AND',
            array(
                'taxonomy' => 'type',
                'field'    => 'slug',
                'terms'    => array('sponso'),
                'operator' => 'IN'
            ),
            array(
                'taxonomy' => 'type',
                'field'    => 'slug',
                'terms'    => array('private'),
                'operator' => 'NOT IN'
            ),
        ),
    ));
    $list_tags        = array();
    $list_concepts    = array();
    $list_sujets      = array();
    ?>
<div class="app-content content ecommerce-application">
    <div class="content-overlay"></div>
    <div class="content-wrapper">
        <div class="content-body">

            <div class="intro-mobile">
                <div class="tournament-heading text-center">
                    <h3 class="mb-0 t-titre-tournoi">
                        <span class="ico va va-wrapped-gift va-lg"></span> Tops sponso
                    </h3>
                    <h4 class="mb-0">
                        Ici on ne gagne pas à tous les coups - certes - mais on se donne une chance 🤞
                    </h4>
                </div>
            </div>

            <section class="grid-to-filtre row match-height mt-2">

                <?php $i = 1;
                while ($tops_in_cat->have_posts()) : $tops_in_cat->the_post(); ?>

                    <?php
                    $id_top    = get_the_ID();
                    $illu             = get_the_post_thumbnail_url($id_top, 'medium');
                    $user_sinle_top_data = array_search($id_top, array_column($list_user_tops, 'id_top'));
                    if ($user_sinle_top_data !== false) {
                        $state = $list_user_tops[$user_sinle_top_data]['state'];
                    } else {
                        $state = "todo";
                    }
                    $tag_slug         = "";
                    $concept_slug     = "";
                    $sujet_slug       = "";
                    $term_to_search   = "";

                    if (get_the_terms($id_top, 'sous-cat')) {
                        foreach (get_the_terms($id_top, 'sous-cat') as $sujet) {
                            $sujet_slug     .= $sujet->slug . " ";
                        }
                    }
                    if (get_the_terms($id_top, 'tag')) {
                        foreach (get_the_terms($id_top, 'tag') as $tag) {
                            $tag_slug     .= $tag->slug . " ";
                        }
                    }
                    if (get_the_terms($id_top, 'concept')) {
                        foreach (get_the_terms($id_top, 'concept') as $concept) {
                            $concept_slug   .= $concept->slug . " ";
                        }
                    }
                    $top_question   = get_field('question_t', $id_top);
                    $top_title      = get_the_title($id_top);
                    $term_to_search = $sujet_slug . " " . $concept_slug . " " . $top_question . " " . $top_title;
                    $get_top_type = get_the_terms($id_top, 'type');
                    foreach ($get_top_type as $type_top) {
                        $type_top = $type_top->slug;
                    }
                    ?>
                    <div data-filter-item data-filter-name="<?php echo $term_to_search; ?>" class="same-h grid-item col-md-3 col-6 <?php echo $sujet_slug; ?> <?php echo $state; ?> <?php echo $concept_slug; ?> <?php echo $tag_slug; ?>">
                        <div class="min-tournoi card scaler">
                            <div class="cov-illu cover" style="background: url(<?php echo $illu; ?>) center center no-repeat">
                                <?php if ($type_top == "sponso") : ?>
                                    <span class="badge badge-light-rose ml-0">Top sponsorisé</span>
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
                                        <div class="spoun">
                                            <span class="ico">🏆</span>
                                            <h5>Voir mon TOP</h5>
                                        </div>
                                    <?php elseif ($state == "begin") : ?>
                                        <div class="spoun">
                                            <span class="ico">⚡</span>
                                            <h5>Terminer le Top</h5>
                                        </div>
                                    <?php else : ?>
                                        <div class="spoun">
                                            <span class="ico">⚡</span>
                                            <h5>Faire mon Top</h5>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="card-body">
                                <p class="card-text text-primary">
                                    TOP <?php echo get_field('count_contenders_t', $id_top); ?> : <span class="namecontenders"><?php echo $top_title; ?></span>
                                </p>
                                <h4 class="card-title">
                                    <?php echo $top_question; ?>
                                </h4>
                            </div>
                            <a href="<?php the_permalink($id_top); ?>" class="stretched-link"></a>
                        </div>
                    </div>
                <?php $i++;
                endwhile; ?>
            </section>

        </div>
    </div>
</div>
<?php get_footer(); ?>