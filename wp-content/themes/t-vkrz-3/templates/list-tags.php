<?php
/*
        Template Name: Tous les sujets
    */
get_header();
?>
<div class="app-content content ">
    <div class="content-wrapper">
        <div class="content-body">
            <section class="list-tournois">
                <?php
                $cat_t = get_terms(array(
                    'taxonomy'      => 'categorie',
                    'orderby'       => 'count',
                    'order'         => 'DESC',
                    'hide_empty'    => true,
                ));
                foreach ($cat_t as $cat) : ?>
                    <?php
                    $tournois_in_cat = new WP_Query(array(
                        'post_type' => 'tournoi',
                        'order' => 'ASC',
                        'posts_per_page' => -1,
                        'ignore_sticky_posts'    => true,
                        'update_post_meta_cache' => false,
                        'no_found_rows'          => true,
                        'tax_query' => array(
                            'relation' => 'AND',
                            array(
                                'taxonomy' => 'categorie',
                                'field'    => 'term_id',
                                'terms'    => $cat->term_id,
                            ),
                            array(
                                'taxonomy' => 'type',
                                'field'    => 'slug',
                                'terms'    => array('private', 'whitelabel', 'onboarding'),
                                'operator' => 'NOT IN'
                            ),
                        ),
                    ));
                    if ($tournois_in_cat->have_posts()) : ?>
                        <div class="big-cat">
                            <div class="heading-cat">
                                <div class="row">
                                    <div class="col">
                                        <h2 class="text-primary text-uppercase">
                                            <a href="<?php echo get_category_link($cat->term_id); ?>">
                                                <?php the_field('icone_cat', 'term_' . $cat->term_id); ?> <?php echo $cat->name; ?>
                                                <small class="text-muted"><?php echo $cat->description; ?></small>
                                            </a>
                                        </h2>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="list-tags mb-3 mt-2">

                            <?php
                            $list_tags = array();
                            while ($tournois_in_cat->have_posts()) : $tournois_in_cat->the_post();

                                $id_top = get_the_ID();

                                if (get_the_terms($id_top, 'concept')) {
                                    foreach (get_the_terms($id_top, 'concept') as $concept) {
                                        array_push($list_tags, $concept->term_id);
                                    }
                                }

                            endwhile;
                            $list_tags_unique = array_unique($list_tags);
                            $get_tags = get_terms(array(
                                'taxonomy'      => 'concept',
                                'include'       => $list_tags_unique,
                                'orderby'       => 'count',
                                'order'         => 'DESC',
                                'hide_empty'    => true,
                            ));
                            ?>

                            <div class="row">

                                <?php foreach ($get_tags as $tag) : ?>
                                    <div class="col-md-2 col-sm-4 col-6">
                                        <a href="<?php echo get_category_link($tag->term_id); ?>" class="w-100">
                                            <?php echo $tag->name; ?> <span class="badge rounded-pill badge-light-primary float-right"><?php echo $tag->count; ?></span>
                                        </a>
                                    </div>
                                <?php endforeach; ?>

                            </div>


                        </div>

                <?php endif;
                endforeach; ?>
            </section>
        </div>
    </div>
</div>

<?php get_footer(); ?>