<section class="list-tournois">
    <div class="big-cat">
        <div class="heading-cat">
            <div class="row">
                <div class="col">
                    <h2 class="text-primary text-uppercase">
                        <span class="va va-smiling-face-with-hearts va-lg"></span> Tops les plus populaires
                        <small class="text-muted">Des 7 derniers jours</small>
                    </h2>
                </div>
            </div>
        </div>
    </div>
    <div id="component-swiper-responsive-breakpoints">
        <div class="swiper-responsive-breakpoints swiper-container swiper-0">
            <div class="swiper-wrapper">
                <?php
                $latest_rankings = new WP_Query(
                    array(
                        'post_type'              => 'classement',
                        'posts_per_page'         => '-1',
                        'fields'                 => 'ids',
                        'post_status'            => 'publish',
                        'ignore_sticky_posts'    => true,
                        'update_post_meta_cache' => false,
                        'no_found_rows'          => false,
                        'date_query' => array(
                            array(
                                'column' => 'post_date_gmt',
                                'after' => '1 week ago',
                            ),
                        ),
                        'meta_query' => array(
                            array(
                                'key' => 'done_r',
                                'value' => 'done',
                                'compare' => '=',
                            )
                        )
                    )
                );
                $best_tops = best_tops($latest_rankings);
                foreach (array_slice($best_tops, 0, 20, true) as $top_id => $completed_top_number) :
                    $type_top = array();
                    $type_top = get_the_terms($top_id, 'type');
                    $slug_type_top = array();
                    if ($type_top) {
                        foreach ($type_top as $type) {
                            array_push($slug_type_top, $type->slug);
                        }
                    }
                    if (get_post_status($top_id) == "publish" && !in_array('private', $slug_type_top)) :
                        global $user_tops;
                        $id_top           = $top_id;
                        $top_datas        = get_top_data($id_top);
                        $creator_id       = get_post_field('post_author', $id_top);
                        $creator_info     = get_userdata($creator_id);
                        $creator_pseudo   = $creator_info->nickname;
                        $creator_avatar   = get_avatar_url($creator_id, ['size' => '80', 'force_default' => false]);
                        $state            = "";
                        $illu             = get_the_post_thumbnail_url($id_top, 'medium');
                        if (is_home()) {
                            $class        = "swiper-slide";
                        } elseif (is_single()) {
                            $class        = "col-md-12 col-6";
                        } else {
                            $class        = "col-12";
                        }
                        if (in_array($id_top, $list_user_tops_done)) {
                            $state = "done";
                        } elseif (in_array($id_top, $list_user_tops_begin)) {
                            $state = "begin";
                        } else {
                            $state = "todo";
                        }
                        $get_top_type = get_the_terms($id_top, 'type');
                        if ($get_top_type) {
                            foreach ($get_top_type as $type_top) {
                                $type_top = $type_top->slug;
                            }
                        }
                ?>
                        <div class="<?php echo $class; ?>">
                            <div class="min-tournoi card scaler">
                                <div class="cov-illu cover" style="background: url(<?php echo $illu; ?>) center center no-repeat">
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
                                            <div class="spoun">
                                                <h5>Voir mon 🏆</h5>
                                            </div>
                                        <?php elseif ($state == "begin") : ?>
                                            <div class="spoun">
                                                <h5>Terminer</h5>
                                            </div>
                                        <?php else : ?>
                                            <div class="spoun">
                                                <h5>Faire mon 🏆</h5>
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
                                        <div class="info-top-col hide-xs">
                                            <div class="infos-card-t d-flex align-items-center infos-card-t-c">
                                                <div class="avatar-infomore">
                                                    <a href="<?php the_permalink(218587); ?>?creator_id=<?php echo $creator_id; ?>" target="_blank">
                                                        <div class="avatar me-2">
                                                            <img src="<?php echo $creator_avatar; ?>" alt="<?php echo $creator_pseudo; ?>" width="38" height="38">
                                                        </div>
                                                    </a>
                                                </div>
                                                <div class="content-body mt-01">
                                                    <h4 class="mb-0 link-creator d-flex flex-column text-left">
                                                        <span class="text-muted">Créé par</span>
                                                        <a href="<?php the_permalink(218587); ?>?creator_id=<?php echo $creator_id; ?>" target="_blank" class="link-to-creator">
                                                            <?php echo $creator_pseudo; ?>
                                                        </a>
                                                    </h4>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body eh mb-3-hover">
                                    <p class="card-text text-primary">
                                        <?php
                                        foreach (get_the_terms($id_top, 'categorie') as $cat) {
                                            $cat_id     = $cat->term_id;
                                            $cat_name   = $cat->name;
                                        }
                                        ?>
                                        TOP <?php echo get_field('count_contenders_t', $id_top); ?> <?php the_field('icone_cat', 'term_' . $cat_id); ?> <?php echo get_the_title($id_top); ?>
                                    </p>
                                    <h4 class="card-title">
                                        <?php the_field('question_t', $id_top); ?>
                                    </h4>
                                </div>
                                <a href="<?php the_permalink($id_top); ?>" class="stretched-link"></a>
                            </div>
                        </div>
                    <?php endif; ?>

                <?php endforeach;
                wp_reset_query(); ?>
            </div>
            <div class="swiper-button-next swiper-button-next-0"></div>
            <div class="swiper-button-prev swiper-button-prev-0"></div>
        </div>
    </div>
</section>