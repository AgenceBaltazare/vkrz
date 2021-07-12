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
$list_tags      = array();
$list_concepts  = array();
?>
<div class="app-content content ecommerce-application">
    <div class="content-overlay"></div>
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

                <div class="body-content-overlay"></div>

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

                <section id="ecommerce-products" class="grid-view">


                    <?php while ($tournois_in_cat->have_posts()) : $tournois_in_cat->the_post(); ?>

                        <?php
                        $state            = "";
                        $id_tournament    = get_the_ID();
                        $illu             = get_the_post_thumbnail_url($id_tournament, 'medium');
                        $nb_top           = get_numbers_of_contenders($id_tournament);

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
                        <div class="grid-item <?php echo $concept_slug; ?> <?php echo $tag_slug; ?>">
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
                </section>
            </div>
        </div>
        <div class="sidebar-detached sidebar-left">
            <div class="sidebar">
                <!-- Ecommerce Sidebar Starts -->
                <div class="sidebar-shop">
                    <div class="row">
                        <div class="col-sm-12">
                            <h6 class="filter-heading d-none d-lg-block">Filters</h6>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <!-- Price Filter starts -->
                            <div class="multi-range-price">
                                <h6 class="filter-title mt-0">Multi Range</h6>
                                <ul class="list-unstyled price-range" id="price-range">
                                    <li>
                                        <div class="custom-control custom-radio">
                                            <input type="radio" id="priceAll" name="price-range" class="custom-control-input" checked />
                                            <label class="custom-control-label" for="priceAll">All</label>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="custom-control custom-radio">
                                            <input type="radio" id="priceRange1" name="price-range" class="custom-control-input" />
                                            <label class="custom-control-label" for="priceRange1">&lt;=$10</label>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="custom-control custom-radio">
                                            <input type="radio" id="priceRange2" name="price-range" class="custom-control-input" />
                                            <label class="custom-control-label" for="priceRange2">$10 - $100</label>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="custom-control custom-radio">
                                            <input type="radio" id="priceARange3" name="price-range" class="custom-control-input" />
                                            <label class="custom-control-label" for="priceARange3">$100 - $500</label>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="custom-control custom-radio">
                                            <input type="radio" id="priceRange4" name="price-range" class="custom-control-input" />
                                            <label class="custom-control-label" for="priceRange4">&gt;= $500</label>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                            <!-- Price Filter ends -->

                            <!-- Price Slider starts -->
                            <div class="price-slider">
                                <h6 class="filter-title">Price Range</h6>
                                <div class="price-slider">
                                    <div class="range-slider mt-2" id="price-slider"></div>
                                </div>
                            </div>
                            <!-- Price Range ends -->

                            <!-- Categories Starts -->
                            <div id="product-categories">
                                <h6 class="filter-title">Categories</h6>
                                <ul class="list-unstyled categories-list">
                                    <li>
                                        <div class="custom-control custom-radio">
                                            <input type="radio" id="category1" name="category-filter" class="custom-control-input" checked />
                                            <label class="custom-control-label" for="category1">Appliances</label>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="custom-control custom-radio">
                                            <input type="radio" id="category2" name="category-filter" class="custom-control-input" />
                                            <label class="custom-control-label" for="category2">Audio</label>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="custom-control custom-radio">
                                            <input type="radio" id="category3" name="category-filter" class="custom-control-input" />
                                            <label class="custom-control-label" for="category3">Cameras & Camcorders</label>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="custom-control custom-radio">
                                            <input type="radio" id="category4" name="category-filter" class="custom-control-input" />
                                            <label class="custom-control-label" for="category4">Car Electronics & GPS</label>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="custom-control custom-radio">
                                            <input type="radio" id="category5" name="category-filter" class="custom-control-input" />
                                            <label class="custom-control-label" for="category5">Cell Phones</label>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="custom-control custom-radio">
                                            <input type="radio" id="category6" name="category-filter" class="custom-control-input" />
                                            <label class="custom-control-label" for="category6">Computers & Tablets</label>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="custom-control custom-radio">
                                            <input type="radio" id="category7" name="category-filter" class="custom-control-input" />
                                            <label class="custom-control-label" for="category7">Health, Fitness & Beauty</label>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="custom-control custom-radio">
                                            <input type="radio" id="category8" name="category-filter" class="custom-control-input" />
                                            <label class="custom-control-label" for="category8">Office & School Supplies</label>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="custom-control custom-radio">
                                            <input type="radio" id="category9" name="category-filter" class="custom-control-input" />
                                            <label class="custom-control-label" for="category9">TV & Home Theater</label>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="custom-control custom-radio">
                                            <input type="radio" id="category10" name="category-filter" class="custom-control-input" />
                                            <label class="custom-control-label" for="category10">Video Games</label>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                            <!-- Categories Ends -->

                            <!-- Brands starts -->
                            <div class="brands">
                                <h6 class="filter-title">Brands</h6>
                                <ul class="list-unstyled brand-list">
                                    <li>
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="productBrand1" />
                                            <label class="custom-control-label" for="productBrand1">Insignia™</label>
                                        </div>
                                        <span>746</span>
                                    </li>
                                    <li>
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="productBrand2" checked />
                                            <label class="custom-control-label" for="productBrand2">Samsung</label>
                                        </div>
                                        <span>633</span>
                                    </li>
                                    <li>
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="productBrand3" />
                                            <label class="custom-control-label" for="productBrand3">Metra</label>
                                        </div>
                                        <span>591</span>
                                    </li>
                                    <li>
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="productBrand4" />
                                            <label class="custom-control-label" for="productBrand4">HP</label>
                                        </div>
                                        <span>530</span>
                                    </li>
                                    <li>
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="productBrand5" checked />
                                            <label class="custom-control-label" for="productBrand5">Apple</label>
                                        </div>
                                        <span>442</span>
                                    </li>
                                    <li>
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="productBrand6" />
                                            <label class="custom-control-label" for="productBrand6">GE</label>
                                        </div>
                                        <span>394</span>
                                    </li>
                                    <li>
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="productBrand7" />
                                            <label class="custom-control-label" for="productBrand7">Sony</label>
                                        </div>
                                        <span>350</span>
                                    </li>
                                    <li>
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="productBrand8" />
                                            <label class="custom-control-label" for="productBrand8">Incipio</label>
                                        </div>
                                        <span>320</span>
                                    </li>
                                    <li>
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="productBrand9" />
                                            <label class="custom-control-label" for="productBrand9">KitchenAid</label>
                                        </div>
                                        <span>318</span>
                                    </li>
                                    <li>
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="productBrand10" />
                                            <label class="custom-control-label" for="productBrand10">Whirlpool</label>
                                        </div>
                                        <span>298</span>
                                    </li>
                                </ul>
                            </div>
                            <!-- Brand ends -->

                            <!-- Rating starts -->
                            <div id="ratings">
                                <h6 class="filter-title">Ratings</h6>
                                <div class="ratings-list">
                                    <a href="javascript:void(0)">
                                        <ul class="unstyled-list list-inline">
                                            <li class="ratings-list-item"><i data-feather="star" class="filled-star"></i></li>
                                            <li class="ratings-list-item"><i data-feather="star" class="filled-star"></i></li>
                                            <li class="ratings-list-item"><i data-feather="star" class="filled-star"></i></li>
                                            <li class="ratings-list-item"><i data-feather="star" class="filled-star"></i></li>
                                            <li class="ratings-list-item"><i data-feather="star" class="unfilled-star"></i></li>
                                            <li>& up</li>
                                        </ul>
                                    </a>
                                    <div class="stars-received">160</div>
                                </div>
                                <div class="ratings-list">
                                    <a href="javascript:void(0)">
                                        <ul class="unstyled-list list-inline">
                                            <li class="ratings-list-item"><i data-feather="star" class="filled-star"></i></li>
                                            <li class="ratings-list-item"><i data-feather="star" class="filled-star"></i></li>
                                            <li class="ratings-list-item"><i data-feather="star" class="filled-star"></i></li>
                                            <li class="ratings-list-item"><i data-feather="star" class="unfilled-star"></i></li>
                                            <li class="ratings-list-item"><i data-feather="star" class="unfilled-star"></i></li>
                                            <li>& up</li>
                                        </ul>
                                    </a>
                                    <div class="stars-received">176</div>
                                </div>
                                <div class="ratings-list">
                                    <a href="javascript:void(0)">
                                        <ul class="unstyled-list list-inline">
                                            <li class="ratings-list-item"><i data-feather="star" class="filled-star"></i></li>
                                            <li class="ratings-list-item"><i data-feather="star" class="filled-star"></i></li>
                                            <li class="ratings-list-item"><i data-feather="star" class="unfilled-star"></i></li>
                                            <li class="ratings-list-item"><i data-feather="star" class="unfilled-star"></i></li>
                                            <li class="ratings-list-item"><i data-feather="star" class="unfilled-star"></i></li>
                                            <li>& up</li>
                                        </ul>
                                    </a>
                                    <div class="stars-received">291</div>
                                </div>
                                <div class="ratings-list">
                                    <a href="javascript:void(0)">
                                        <ul class="unstyled-list list-inline">
                                            <li class="ratings-list-item"><i data-feather="star" class="filled-star"></i></li>
                                            <li class="ratings-list-item"><i data-feather="star" class="unfilled-star"></i></li>
                                            <li class="ratings-list-item"><i data-feather="star" class="unfilled-star"></i></li>
                                            <li class="ratings-list-item"><i data-feather="star" class="unfilled-star"></i></li>
                                            <li class="ratings-list-item"><i data-feather="star" class="unfilled-star"></i></li>
                                            <li>& up</li>
                                        </ul>
                                    </a>
                                    <div class="stars-received">190</div>
                                </div>
                            </div>
                            <!-- Rating ends -->

                            <!-- Clear Filters Starts -->
                            <div id="clear-filters">
                                <button type="button" class="btn btn-block btn-primary">Clear All Filters</button>
                            </div>
                            <!-- Clear Filters Ends -->
                        </div>
                    </div>
                </div>
                <!-- Ecommerce Sidebar Ends -->

            </div>
        </div>
    </div>
</div>
<!-- END: Content-->


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

                    <div class="grid">


                    </div>
                </section>
            </div>
        </div>
        <div class="sidebar-detached sidebar-left">
            <div class="sidebar">
                <div class="sidebar-shop">
                    <div class="card">
                        <div class="card-body">
                            <div class="filters">

                                <div class="ui-group">
                                    <h4 class="mb-2">
                                        <span class="ico">🤟</span> Sous-cat
                                    </h4>
                                    <div class="button-group js-radio-button-group filter-button-group">
                                        <button class="button btn btn-outline-primary waves-effect is-checked" data-filter="*">Tout</button>
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
                                            <button class="btn-to-filtre btn btn-outline-primary waves-effect" data-filter=".<?php echo $concept->slug; ?>"><?php echo $concept->name; ?></button>
                                        <?php endforeach; ?>
                                    </div>
                                </div>



                                <div class="ui-group">
                                    <h4 class="mb-2">
                                        <span class="ico">🤟</span> Concepts
                                    </h4>
                                    <div class="button-group js-radio-button-group filter-button-group">
                                        <ul class="list-unstyled categories-list">
                                            <?php
                                            $list_tags  = array_unique($list_tags);
                                            $tags = get_terms( array(
                                                'taxonomy'      => 'tag',
                                                'include'       => $list_tags,
                                                'orderby'       => 'count',
                                                'order'         => 'DESC',
                                                'hide_empty'    => true,
                                            ));
                                            foreach($tags as $tag) : ?>
                                                <li>
                                                    <div class="form-check">
                                                        <input type="radio" class="btn-to-filtre form-check-input" id="<?php echo $tag->slug; ?>" data-filter=".<?php echo $tag->slug; ?>">
                                                        <label class="form-check-label" for="<?php echo $tag->slug; ?>">
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
                                                    <span><?php echo $tag->count; ?></span>
                                                </li>
                                            <?php endforeach; ?>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php get_footer(); ?>
