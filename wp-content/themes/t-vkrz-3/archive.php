<?php
get_header();
global $uuiduser;
global $user_id;;
global $user_full_data;
global $list_t_done;
$list_t_begin     = $user_full_data[0]['list_user_ranking_begin'];
?>
<div class="app-content content ecommerce-application">
    <div class="header-navbar-shadow"></div>
    <div class="content-wrapper">
        <div class="content-detached content-right">
            <div class="content-body">
                <div class="intro-mobile">
                    <?php $current_cat = get_queried_object(); ?>
                    <div class="tournament-heading text-center">
                        <h3 class="mb-0 t-titre-tournoi">
                            <span class="ico"><?php the_field('icone_cat', 'term_'.$current_cat->term_id); ?></span> <?php echo $current_cat->name; ?>
                        </h3>
                        <h4 class="mb-0">
                            <?php echo $current_cat->description; ?> - <?php echo $uuiduser; ?>
                        </h4>
                    </div>
                </div>

                <!--
                <section id="ecommerce-searchbar" class="ecommerce-searchbar">
                    <div class="row mt-1">
                        <div class="col-sm-12">
                            <div class="input-group input-group-merge">
                                <input type="text" class="form-control search-product" id="shop-search" placeholder="Recherche parmi les <?php echo $current_cat->count; ?> Tops..." aria-label="Rechercher..." aria-describedby="shop-search" />
                                <div class="input-group-append">
                                    <span class="input-group-text">
                                        <i data-feather="search" class="text-muted"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                -->

                <section class="list-tops mt-1">
                    <div class="row">
                        <?php
                        $tournois_in_cat = new WP_Query(array(
                            'post_type' => 'tournoi',
                            'orderby' => 'date',
                            'order' => 'DESC',
                            'posts_per_page' => 1000,
                            'ignore_sticky_posts'    => true,
                            'update_post_meta_cache' => false,
                            'no_found_rows'          => true,
                            'tax_query' => array(
                                array(
                                    'taxonomy' => 'categorie',
                                    'field'    => 'term_id',
                                    'terms'    => $current_cat->term_id,
                                ),
                            )
                        ));

                        $list_tags      = array();
                        $list_concepts  = array();

                        while ($tournois_in_cat->have_posts()) : $tournois_in_cat->the_post(); ?>

                            <?php
                            $state            = "";
                            $id_tournament    = get_the_ID();
                            $illu             = get_the_post_thumbnail_url($id_tournament, 'medium');
                            $nb_top           = get_numbers_of_contenders($id_tournament);

                            if(get_the_terms($id_tournament, 'tag')){
                                foreach(get_the_terms($id_tournament, 'tag') as $tag ) {
                                    $tag_id       = $tag->term_id;
                                    $tag_target   = 'tag-'.$tag->term_id;
                                    array_push($list_tags, $tag_id);
                                }
                            }
                            if(get_the_terms($id_tournament, 'concept')){
                                foreach(get_the_terms($id_tournament, 'concept') as $concept ) {
                                    $concept_id       = $concept->term_id;
                                    $concept_target   = 'concept-'.$concept->term_id;
                                    array_push($list_concepts, $concept_id);
                                }
                            }
                            if(array_search($id_tournament, array_column($list_t_done, 'id_tournoi')) !== false) {
                                $state = "done";
                            }
                            elseif(array_search($id_tournament, array_column($list_t_begin, 'id_tournoi')) !== false) {
                                $state = "begin";
                            }
                            else{
                                $state = "todo";
                            }
                            ?>
                            <div class="t-filtrable col-md-4 col-lg-3" data-tags="<?php echo $tag_target; ?>" data-concept="<?php echo $concept_target; ?>" data-nbcontenders="<?php echo $nb_top; ?>">
                                <div class="min-tournoi card scaler">
                                    <div class="cov-illu cover" style="background: url(<?php echo $illu; ?>) center center no-repeat">
                                        <?php if($state == "done"): ?>
                                            <div class="badge badge-success">Terminé</div>
                                        <?php elseif($state == "begin"): ?>
                                            <div class="badge badge-warning">En cours</div>
                                        <?php else: ?>
                                            <div class="badge badge-primary">A faire</div>
                                        <?php endif; ?>
                                        <div class="voile">
                                            <?php if($state == "done"): ?>
                                                <div class="spoun">
                                                    🏆
                                                    <h5>Voir mon TOP</h5>
                                                </div>
                                            <?php elseif($state == "begin"): ?>
                                                <div class="spoun">
                                                    ⚡
                                                    <h5>Terminer</h5>
                                                </div>
                                            <?php else: ?>
                                                <div class="spoun">
                                                    ⚡
                                                    <h5>Créer mon Top</h5>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <div class="card-body eh">
                                        <p class="card-text text-primary">
                                            TOP <?php echo $nb_top; ?>  : <span class="namecontenders"><?php echo get_the_title($id_tournament); ?></span>
                                        </p>
                                        <h4 class="card-title">
                                            <?php the_field('question_t', $id_tournament); ?>
                                        </h4>
                                    </div>
                                    <a href="<?php the_permalink($id_tournament); ?>" class="stretched-link"></a>
                                </div>
                            </div>

                        <?php endwhile; ?>
                    </div>
                </section>
            </div>
        </div>
        <div class="sidebar-detached sidebar-left">
            <div class="sidebar">
                <div class="sidebar-shop">
                    <div class="card">
                        <div class="card-body">
                            <div class="filters-btn">
                                <h4 class="mb-2">
                                    <span class="ico">🤟</span> Sous-catégories
                                </h4>
                                <ul class="list-unstyled tags-list">
                                    <?php
                                    $list_concepts  = array_unique($list_concepts);
                                    $concepts = get_terms( array(
                                        'taxonomy'      => 'concept',
                                        'include'       => $list_concepts,
                                        'orderby'       => 'count',
                                        'order'         => 'DESC',
                                        'hide_empty'    => true,
                                    ));
                                    foreach($concepts as $concept) : ?>
                                        <button type="button" class="btn btn-outline-primary waves-effect" data-tag="concept-<?php echo $concept->term_id; ?>">
                                            <span><?php echo $concept->name; ?></span>
                                        </button>
                                    <?php endforeach; ?>
                                </ul>
                            </div>

                            <!--
                            <div class="filters-btn mt-4">
                                <h4 class="mb-2">
                                    <span class="ico">🤟</span> Liste des concepts
                                </h4>
                                <ul class="list-unstyled categories-list">
                                    <?php
                                    $list_tags      = array_unique($list_tags);
                                    $tags = get_terms( array(
                                        'taxonomy'      => 'tag',
                                        'include'       => $list_tags,
                                        'orderby'       => 'count',
                                        'order'         => 'DESC',
                                        'hide_empty'    => true,
                                    ));
                                    foreach($tags as $tag) : ?>
                                        <li>
                                            <div class="custom-control custom-radio">
                                                <input type="radio" id="concept-<?php echo $tag->term_id; ?>" name="concept-filter" class="custom-control-input" />
                                                <label class="custom-control-label" for="concept-<?php echo $tag->term_id; ?>">
                                                    <?php
                                                        if($tag->name == "QTP"){
                                                            echo "Quel est ton préféré ?";
                                                        }
                                                        elseif($tag->name == "QPS"){
                                                            echo "Qui est le plus stylé ?";
                                                        }
                                                        elseif($tag->name == "QPF"){
                                                            echo "Qui est le plus fort ?";
                                                        }
                                                        elseif($tag->name == "QLM"){
                                                            echo "Quel est le meilleur ?";
                                                        }
                                                        elseif($tag->name == "DUEL"){
                                                            echo "1 vs 1";
                                                        }
                                                    ?>
                                                </label>
                                            </div>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                            -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php get_footer(); ?>
