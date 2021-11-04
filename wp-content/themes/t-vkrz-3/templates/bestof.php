<?php
/*
    Template Name: Best Of
*/
get_header();
?>
<div class="app-content content evolution">
    <div class="content-wrapper">
        <div class="content-body">
            <section id="pricing-plan">
                <div class="text-center">
                    <h1 class="mt-5">
                        Tout ce qui cartonne le plus est ici !
                    </h1>
                    <p class="mb-4 mt-3">

                    </p>
                </div>

                <div class="row pricing-card">
                    <div class="col-12">
                        <div class="row match-height">

                            <div class="col-12 col-md-4">
                                <div class="card basic-pricing text-center">
                                    <div class="card-body">
                                        <h3>Tops les plus populaires</h3>
                                        <p class="card-text eh2">
                                            Il faut bien commencer quelque part. On t'invite à nous rejoindre pour briser la coquille 🤗
                                        </p>
                                        <?php
                                        $rankings = new WP_Query(
                                            array(
                                                'post_type' => 'classement',
                                                'posts_per_page' => '-1',
                                                'fields' => 'ids',
                                                'post_status' => 'publish',
                                                'ignore_sticky_posts' => true,
                                                'update_post_meta_cache' => false,
                                                'no_found_rows' => false,
                                                'meta_query' => array(
                                                    array(
                                                    'key' => 'done_r',
                                                    'value' => 'done',
                                                    'compare' => '=',
                                                    )
                                                )
                                            )
                                        );

                                        $best_tops = best_tops($rankings);

                                        ?>
                                        <div class="app-content content cover">
                                            <div class="content-wrapper">
                                                <?php
                                                if (!empty($best_tops)) {
                                                    echo "<ol>";
                                                    foreach (array_slice($best_tops, 0, 20, true) as $top_id => $completed_top_number) {
                                                        echo "<li>";
                                                        echo "Top n°" . $top_id . " avec " . $completed_top_number . " tops complets.";
                                                        echo "</li>";
                                                    }
                                                    echo "</ol>";
                                                }
                                                ?>
                                            </div>
                                        </div>
                                        <a href="<?php the_permalink(get_page_by_path('creer-mon-compte')); ?>" class="btn btn-primary mt-1">
                                            Créer mon compte <span class="ico">🎉</span>
                                        </a>
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
<!-- END: Content-->
<?php get_footer(); ?>