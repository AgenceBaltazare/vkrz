<?php
get_header();
global $uuiduser;
global $user_id;;
global $user_full_data;
global $list_t_done;
$list_t_begin     = $user_full_data[0]['list_user_ranking_begin'];
$tournois_in_cat  = new WP_Query(array(
    'post_type'                 => 'tournoi',
    'orderby'                   => 'date',
    'order'                     => 'DESC',
    'posts_per_page'            => 1000,
    'ignore_sticky_posts'       => true,
    'update_post_meta_cache'    => false,
    'no_found_rows'             => true,
    'tax_query'                 => array(
        array(
            'taxonomy' => 'categorie',
            'field'    => 'term_id',
            'terms'    => $current_cat->term_id,
        ),
    )
));
$list_tags        = array();
$list_concepts    = array();
$list_sujets      = array();
?>
<div class="app-content content ecommerce-application">
    <div class="content-overlay"></div>
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

                <section id="ecommerce-header" class="mb-2">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="ecommerce-header-items">
                                <div class="result-toggler">
                                    <button class="navbar-toggler shop-sidebar-toggler d-flex align-items-center" type="button" data-bs-toggle="collapse">
                                        <i class="far fa-bars"></i>
                                        <span class="text-uppercase">Afficher les filtres</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                <div class="body-content-overlay"></div>

                <!--
                <section id="ecommerce-searchbar" class="ecommerce-searchbar">
                    <div class="row mt-1">
                        <div class="col-sm-12">
                            <div class="input-group input-group-merge">
                                <input type="text" class="form-control search-product" id="shop-search" placeholder="Search Product" aria-label="Search..." aria-describedby="shop-search" />
                                <div class="input-group-append">
                                    <span class="input-group-text"><i data-feather="search" class="text-muted"></i></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                -->

                <section class="grid-to-filtre row">

                    <?php $i=1; while ($tournois_in_cat->have_posts()) : $tournois_in_cat->the_post(); ?>

                        <?php
                        $state            = "";
                        $id_tournament    = get_the_ID();
                        $illu             = get_the_post_thumbnail_url($id_tournament, 'medium');
                        $nb_top           = get_numbers_of_contenders($id_tournament);
                        $tag_name         = "";
                        $tag_slug         = "";
                        $concept_name     = "";
                        $concept_slug     = "";
                        $sujet_name       = "";
                        $sujet_slug       = "";

                        if(get_the_terms($id_tournament, 'sous-cat')){
                            foreach(get_the_terms($id_tournament, 'sous-cat') as $sujet ) {
                                $sujet_name     .= $sujet->name." ";
                                $sujet_slug     .= $sujet->slug." ";
                                array_push($list_sujets, $sujet->term_id);
                            }
                        }
                        if(get_the_terms($id_tournament, 'tag')){
                            foreach(get_the_terms($id_tournament, 'tag') as $tag ) {
                                $tag_name     .= $tag->name." ";
                                $tag_slug     .= $tag->slug." ";
                                array_push($list_tags, $tag->term_id);
                            }
                        }
                        if(get_the_terms($id_tournament, 'concept')){
                            foreach(get_the_terms($id_tournament, 'concept') as $concept ) {
                                $concept_name   .= $concept->name." ";
                                $concept_slug   .= $concept->slug." ";
                                array_push($list_concepts, $concept->term_id);
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
                        <div class="grid-item col-md-3 col-6 <?php echo $sujet_slug; ?> <?php echo $state; ?> <?php echo $concept_slug; ?> <?php echo $tag_slug; ?>">
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
                                                <span class="ico">🏆</span>
                                                <h5>Voir mon TOP</h5>
                                            </div>
                                        <?php elseif($state == "begin"): ?>
                                            <div class="spoun">
                                                <span class="ico">⚡</span>
                                                <h5>Terminer le Top</h5>
                                            </div>
                                        <?php else: ?>
                                            <div class="spoun">
                                                <span class="ico">⚡</span>
                                                <h5>Créer mon Top</h5>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="card-body">
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
                    <?php $i++; endwhile; ?>
                </section>
            </div>
        </div>
        <div class="sidebar-detached sidebar-left">
            <div class="sidebar">
                <div class="sidebar-shop">
                    <div class="card">
                        <div class="card-body">
                            <?php if($list_sujets): ?>
                                <div class="ui-group">
                                    <h5 class="mb-2 text-uppercase text-muted">
                                        Sous-catégorie
                                    </h5>
                                    <div class="grid-filtre button-group" data-filter-group="souscat">
                                        <button class="grid-filtre-item btn-to-filtre button btn btn-outline-primary waves-effect is-checked" data-filter="">Tout</button>
                                        <?php
                                        $list_sujets  = array_unique($list_sujets);
                                        $concepts = get_terms(array(
                                            'taxonomy'      => 'sous-cat',
                                            'include'       => $list_sujets,
                                            'orderby'       => 'count',
                                            'order'         => 'DESC',
                                            'hide_empty'    => true,
                                        ));
                                        foreach($concepts as $concept) : ?>
                                            <button class="grid-filtre-item btn-to-filtre btn btn-outline-primary waves-effect" data-filter=".<?php echo $concept->slug; ?>"><?php echo $concept->name; ?></button>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            <?php endif; ?>

                            <?php if($list_concepts): ?>
                                <div class="ui-group mt-3">
                                    <h5 class="mb-2 text-uppercase text-muted">
                                        Sujet
                                    </h5>
                                    <div class="grid-filtre button-group" data-filter-group="sujet">
                                        <button class="grid-filtre-item btn-to-filtre button btn btn-outline-primary waves-effect is-checked" data-filter="">Tout</button>
                                        <?php
                                        $list_concepts  = array_unique($list_concepts);
                                        $sujets = get_terms(array(
                                            'taxonomy'      => 'concept',
                                            'include'       => $list_concepts,
                                            'orderby'       => 'count',
                                            'order'         => 'DESC',
                                            'hide_empty'    => true,
                                        ));
                                        foreach($sujets as $sujet) : ?>
                                            <button class="grid-filtre-item btn-to-filtre btn btn-outline-primary waves-effect" data-filter=".<?php echo $sujet->slug; ?>"><?php echo $sujet->name; ?></button>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            <?php endif; ?>

                            <div class="ui-group mt-3">
                                <h5 class="mb-2 text-uppercase text-muted">
                                    Statut
                                </h5>
                                <div class="grid-filtre button-group" data-filter-group="statut">
                                    <button class="grid-filtre-item btn-to-filtre btn btn-outline-primary waves-effect is-checked" data-filter="">
                                        Tout
                                    </button>
                                    <button class="grid-filtre-item btn-to-filtre btn btn-outline-primary waves-effect" data-filter=".todo">
                                        À faire
                                    </button>
                                    <button class="grid-filtre-item btn-to-filtre btn btn-outline-primary waves-effect" data-filter=".begin">
                                        En cours
                                    </button>
                                    <button class="grid-filtre-item btn-to-filtre btn btn-outline-primary waves-effect" data-filter=".done">
                                        Terminé
                                    </button>
                                </div>
                            </div>

                            <?php if($list_tags): ?>
                                <div class="ui-group mt-3">
                                    <h5 class="mb-2 text-uppercase text-muted">
                                        Concept
                                    </h5>
                                    <ul class="list-unstyled categories-list button-group" data-filter-group="concepts">
                                        <li>
                                            <div class="custom-control custom-radio">
                                                <input type="radio" id="all-concepts" name="concept-filter" data-filter="" class="btn-to-filtre custom-control-input" checked/>
                                                <label class="custom-control-label" for="all-concepts">
                                                    Tous les concepts
                                                </label>
                                            </div>
                                        </li>
                                        <?php
                                        $list_tags  = array_unique($list_tags);
                                        $tags = get_terms(array(
                                            'taxonomy'      => 'tag',
                                            'include'       => $list_tags,
                                            'orderby'       => 'count',
                                            'order'         => 'DESC',
                                            'hide_empty'    => true,
                                        ));
                                        foreach($tags as $tag) : ?>
                                            <li>
                                                <div class="custom-control custom-radio">
                                                    <input type="radio" id="<?php echo $tag->slug; ?>" name="concept-filter" data-filter=".<?php echo $tag->slug; ?>" class="btn-to-filtre custom-control-input"/>
                                                    <label class="custom-control-label" for="<?php echo $tag->slug; ?>">
                                                        <?php
                                                        if($tag->name == "QTP"){
                                                            echo "Quel est ton préféré ?";
                                                        }
                                                        elseif($tag->name == "QPS"){
                                                            echo "Qui est le plus stylé ?";
                                                        }
                                                        elseif($tag->name == "QPB"){
                                                            echo "Qui est le plus badass ?";
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
                                                        elseif($tag->name == "QLP"){
                                                            echo "Quel est le pire ?";
                                                        }
                                                        else{
                                                            echo $tag->name;
                                                        }
                                                        ?>
                                                    </label>
                                                </div>
                                            </li>
                                        <?php endforeach; ?>
                                    </ul>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php get_footer(); ?>
