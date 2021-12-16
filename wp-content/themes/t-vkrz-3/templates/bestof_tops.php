<?php
/*
    Template Name: Best of - Tops
*/
get_header();
?>
<div class="app-content content cover">
    <div class="content-overlay"></div>
    <div class="content-wrapper">
        <div class="content-body mt-2">
            <div class="intro-mobile">
                <div class="tournament-heading text-center">
                    <h3 class="mb-0 t-titre-tournoi">
                        Top 20 des Tops les plus populaires <span class="va va-dizzy va-lg"></span>
                    </h3>
                </div>
            </div>
            <div class="classement">
                <div class="container-fluid">
                    <section id="profile-info">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="row" id="table-bordered">
                                    <div class="col-12">
                                        <div class="card">
                                            <div class="card-header">
                                                <h4 class="card-title pt-1 pb-1">
                                                    <span class="t-rose">TOP 20</span> des Tops les plus populaires <span class="va va-dizzy va-lg"></span>
                                                </h4>
                                            </div>
                                            <div class="table-responsive">
                                                <table class="table">
                                                    <thead>
                                                        <tr>
                                                            <th>
                                                                <span class="va va-chequered-flag va-lg"></span>
                                                            </th>
                                                            <th>
                                                                <span class="va va-prince va-lg"></span>
                                                            </th>
                                                            <th class="text-right">
                                                                <span class="va va-trophy va-lg"></span>
                                                            </th>
                                                            <th class="text-right"><small class="text-muted">Conçu par</small></th>
                                                            <th>
                                                                <span class="va va-high-voltage va va-lg"></span>
                                                            </th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        $r = 1;
                                                        $best_tops = new WP_Query(array(
                                                            'ignore_sticky_posts'	    => true,
                                                            'update_post_meta_cache'    => false,
                                                            'no_found_rows'		        => true,
                                                            'post_type'			        => 'resume',
                                                            'orderby'				    => 'meta_value_num',
                                                            'meta_key'                  => 'nb_top_complet_resume',
                                                            'order'				        => 'DESC',
                                                            'posts_per_page'		    => 20
                                                        ));
                                                        while ($best_tops->have_posts()) : $best_tops->the_post(); ?>
                                                        <?php
                                                            $top_id   = get_field('id_top_resume');
                                                            $type_top = array();
                                                            $type_top = get_the_terms($top_id, 'type');
                                                            $slug_type_top = array();
                                                            foreach ($type_top as $type) {
                                                                array_push($slug_type_top, $type->slug);
                                                            }
                                                            if (get_post_status($top_id) == "publish" && !in_array('private', $slug_type_top)) : ?>
                                                                <tr>
                                                                    <td>
                                                                        <?php if ($r == 1) : ?>
                                                                            <span class="ico va va-medal-1 va-lg"></span>
                                                                        <?php elseif ($r == 2) : ?>
                                                                            <span class="ico va va-medal-2 va-lg"></span>
                                                                        <?php elseif ($r == 3) : ?>
                                                                            <span class="ico va va-medal-3 va-lg"></span>
                                                                        <?php else : ?>
                                                                            #<?php echo $r; ?>
                                                                        <?php endif; ?>
                                                                    </td>
                                                                    <td>
                                                                        <div class="d-flex align-items-center">
                                                                            <div class="avatar">
                                                                                <?php
                                                                                $minia = get_the_post_thumbnail_url($top_id, 'large')
                                                                                ?>
                                                                                <span class="avatar-picture avatar-top" style="background-image: url(<?php echo $minia; ?>);"></span>
                                                                                <?php
                                                                                foreach (get_the_terms($top_id, 'categorie') as $cat) {
                                                                                    $cat_id     = $cat->term_id;
                                                                                    $cat_name   = $cat->name;
                                                                                }
                                                                                ?>
                                                                                <span class="user-niveau">
                                                                                    <?php the_field('icone_cat', 'term_' . $cat_id); ?>
                                                                                </span>
                                                                            </div>
                                                                            <div class="font-weight-bold topnamebestof">
                                                                                <div class="media-body">
                                                                                    <div class="media-heading">
                                                                                        <h6 class="cart-item-title mb-0">
                                                                                            <a class="text-body" href="<?php the_permalink($top_id); ?>">
                                                                                                Top <?php the_field('count_contenders_t', $top_id); ?> <span class="ico">⚡</span> <?php echo get_the_title($top_id); ?>
                                                                                            </a>
                                                                                        </h6>
                                                                                        <small class="cart-item-by legende">
                                                                                            <?php the_field('question_t', $top_id); ?>
                                                                                        </small>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </td>

                                                                    <td class="text-right">
                                                                        <?php the_field('nb_done_resume'); ?> <span class="ico">🏆</span>
                                                                    </td>

                                                                    <td class="text-right">
                                                                        <?php
                                                                        $creator_id         = get_post_field('post_author', $top_id);
                                                                        $creator_uuiduser   = get_field('uuiduser_user', 'user_' . $creator_id);
                                                                        $creator_data       = get_user_infos($creator_uuiduser);
                                                                        ?>
                                                                        <h4 class="mb-0 link-creator creator-listing-bestof">
                                                                            <a href="<?php the_permalink(218587); ?>?creator_id=<?php echo $creator_id; ?>" target="_blank" class="link-to-creator">
                                                                                <?php echo $creator_data['pseudo']; ?>
                                                                                <span class="ico" data-toggle="tooltip" data-placement="top" title="" data-original-title="Niveau actuel">
                                                                                    <?php echo $creator_data['level']; ?>
                                                                                </span>
                                                                                <?php if ($creator_data['user_role']  == "administrator") : ?>
                                                                                    <span class="ico va va-llama va-lg" data-toggle="tooltip" data-placement="top" title="" data-original-title="TeamVKRZ">
                                                                                    </span>
                                                                                <?php endif; ?>
                                                                            </a>
                                                                        </h4>
                                                                    </td>

                                                                    <td>
                                                                        <a href="<?php the_permalink($top_id); ?>" class="mr-1 btn btn-outline-primary waves-effect">
                                                                            Faire le Top
                                                                        </a>
                                                                    </td>
                                                                </tr>
                                                            <?php endif;
                                                            $r++;
                                                        endwhile; ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
            </div>

        </div>
    </div>
</div>
<?php get_footer(); ?>