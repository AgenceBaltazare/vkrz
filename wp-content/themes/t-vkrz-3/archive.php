<?php
global $user_full_data;
get_header();
$current_cat = get_queried_object();
$tournois_in_cat  = new WP_Query(array(
    'post_type'                 => 'tournoi',
    'orderby'                   => 'date',
    'order'                     => 'DESC',
    'posts_per_page'            => 10,
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
$list_t_done      = $user_full_data[0]['list_user_ranking_done'];
$list_t_begin     = $user_full_data[0]['list_user_ranking_begin'];
?>
<div class="app-content content ecommerce-application">
    <div class="content-overlay"></div>
    <div class="content-wrapper">
        <div class="content-body">

            <div class="intro-mobile">
                <div class="tournament-heading text-center">
                    <h3 class="mb-0 t-titre-tournoi">
                        <span class="ico"><?php the_field('icone_cat', 'term_'.$current_cat->term_id); ?></span> <?php echo $current_cat->name; ?>
                    </h3>
                    <h4 class="mb-0">
                        <?php echo $current_cat->description; ?>
                    </h4>
                </div>
            </div>

            <section id="ecommerce-header" class="mb-2 mt-2">
                <div class="row align-items-center">
                    <div class="col-sm-5">
                        <div class="ecommerce-header-items">
                            <div class="result-toggler">
                                <button class="navbar-toggler shop-sidebar-toggler d-flex align-items-center" type="button" data-bs-toggle="collapse">
                                    <i class="far fa-bars"></i>
                                    <span class="text-uppercase">Afficher les filtres</span>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-7">
                        <div id="ecommerce-searchbar" class="ecommerce-searchbar">
                            <div class="input-group input-group-merge">
                                <input type="text" class="form-control search-product" id="shop-search" placeholder="Rechercher dans les <?php echo $tournois_in_cat->post_count; ?> Tops" aria-label="Rechercher..." aria-describedby="shop-search" />
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <div class="filtres-bloc">
                <?php
                while ($tournois_in_cat->have_posts()) : $tournois_in_cat->the_post();

                    $id_tournament    = get_the_ID();

                    if(get_the_terms($id_tournament, 'sous-cat')){
                        foreach(get_the_terms($id_tournament, 'sous-cat') as $sujet ) {
                            array_push($list_sujets, $sujet->term_id);
                        }
                    }
                    if(get_the_terms($id_tournament, 'tag')){
                        foreach(get_the_terms($id_tournament, 'tag') as $tag ) {
                            array_push($list_tags, $tag->term_id);
                        }
                    }
                    if(get_the_terms($id_tournament, 'concept')){
                        foreach(get_the_terms($id_tournament, 'concept') as $concept ) {
                            array_push($list_concepts, $concept->term_id);
                        }
                    }
                endwhile;
                ?>
                <div class="card">
                    <div class="card-body">
                        <div class="row align-items-start">
                            <div class="col">
                                <?php if($list_sujets): ?>
                                    <div class="ui-group">
                                        <h5 class="mb-2 text-uppercase text-muted">
                                            Sous-catégorie
                                        </h5>
                                        <div class="btn-group dropdown-sort">
                                            <button type="button" class="btn btn-outline-primary dropdown-toggle mr-1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <span class="active-sorting select1">Tout</span>
                                            </button>
                                            <div class="dropdown-menu button-group" data-filter-group="souscat">
                                                <a class="grid-filtre-item btn-to-filtre dropdown-item" data-select="select1" data-filter="" href="javascript:void(0);">Tout</a>
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
                                                    <a class="dropdown-item grid-filtre-item btn-to-filtre" data-select="select1" data-filter=".<?php echo $concept->slug; ?>">
                                                        <?php echo $concept->name; ?>
                                                    </a>
                                                <?php endforeach; ?>
                                            </div>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <div class="col">
                                <?php if($list_concepts): ?>
                                    <div class="ui-group">
                                        <h5 class="mb-2 text-uppercase text-muted">
                                            Sujet
                                        </h5>
                                        <div class="btn-group dropdown-sort">
                                            <button type="button" class="btn btn-outline-primary dropdown-toggle mr-1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <span class="active-sorting select2">Tout</span>
                                            </button>
                                            <div class="dropdown-menu button-group" data-filter-group="sujet">
                                                <a class="grid-filtre-item btn-to-filtre dropdown-item" data-select="select2" data-filter="" href="javascript:void(0);">Tout</a>
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
                                                    <a class="dropdown-item grid-filtre-item btn-to-filtre" data-select="select2" data-filter=".<?php echo $sujet->slug; ?>">
                                                        <?php echo $sujet->name; ?>
                                                    </a>
                                                <?php endforeach; ?>
                                            </div>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <div class="col">
                                <div class="ui-group">
                                    <h5 class="mb-2 text-uppercase text-muted">
                                        Statut
                                    </h5>
                                    <div class="btn-group dropdown-sort">
                                        <button type="button" class="btn btn-outline-primary dropdown-toggle mr-1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <span class="active-sorting select3">Tout</span>
                                        </button>
                                        <div class="dropdown-menu button-group" data-filter-group="statut">
                                            <a class="grid-filtre-item btn-to-filtre dropdown-item" data-select="select3" data-filter="" href="javascript:void(0);">Tout</a>
                                            <a class="dropdown-item grid-filtre-item btn-to-filtre" data-select="select3" data-filter=".todo">
                                                À faire
                                            </a>
                                            <a class="dropdown-item grid-filtre-item btn-to-filtre" data-select="select3" data-filter=".begin">
                                                En cours
                                            </a>
                                            <a class="dropdown-item grid-filtre-item btn-to-filtre" data-select="select3" data-filter=".done">
                                                Terminé
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col">
                                <?php if($list_tags): ?>
                                    <div class="ui-group">
                                        <h5 class="mb-2 text-uppercase text-muted">
                                            Concept
                                        </h5>
                                        <div class="btn-group dropdown-sort">
                                            <button type="button" class="btn btn-outline-primary dropdown-toggle mr-1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <span class="active-sorting select4">Tout</span>
                                            </button>
                                            <div class="dropdown-menu button-group" data-filter-group="concepts">
                                                <a class="grid-filtre-item btn-to-filtre dropdown-item" data-select="select4" data-filter="" href="javascript:void(0);">Tout</a>
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
                                                    <a class="dropdown-item grid-filtre-item btn-to-filtre" data-select="select4" data-filter=".<?php echo $tag->slug; ?>">
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
                                                    </a>
                                                <?php endforeach; ?>
                                            </div>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <section class="grid-to-filtre row match-height mt-2">

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
        </section>
    </div>
</div>
<?php get_footer(); ?>
