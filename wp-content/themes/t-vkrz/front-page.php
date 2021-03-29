<?php get_header(); ?>
    <!-- BEGIN: Content-->
    <div class="app-content content ">
    <div class="content-overlay"></div>
    <div class="content-wrapper">
    <div class="content-header row"></div>
    <div class="content-body">
<div class="pk">
    <div class="row">
        <div class="col-12">
            <div class="card card-nude">
                <div class="card-body text-center">
                    <div class="text-center">
                        <div id="t-listing"></div>
                        <h1 class="mb-1 text-white">🖖 Créer & partage tes propres Tops !</h1>
                        <p class="card-text mb-2">
                            😗 Enchaîne les votes à chaque duel pour générer ton 🥇🥈🥉
                            <br>
                            <!--
                            Si tu es motivé tu peux nous donner ton avis ici 👉
                            <a href="https://baltazare1.typeform.com/to/j9n8JU" target="_blank">petit formulaire easy </a>
                            -->
                        </p>
                        <p class="card-text m-auto w-75">
                            <a href="#t-listing" class="btn btn-xl btn-primary">Choisi ton TOP dans ces catégories👇</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="list-tournois">

    <div class="big-cat">
        <div class="heading-cat">
            <div class="row">
                <div class="col">
                    <h2 class="text-primary text-uppercase">
                        <i class="fal fa-history"></i> Tops récents
                        <small class="text-muted">Toutes catégories confondues</small>
                    </h2>
                </div>
            </div>
        </div>
        <div class="row">
            <?php
            $tournois_in_cat = new WP_Query(array('post_type' => 'tournoi', 'orderby' => 'date', 'order' => 'ASC', 'posts_per_page' => 4));
            while ($tournois_in_cat->have_posts()) : $tournois_in_cat->the_post(); ?>

                <?php
                $state            = "";
                $id_tournament    = get_the_ID();
                $id_user_ranking  = 0;
                $uuiduser         = $_COOKIE["vainkeurz_user_id"];
                $user_ranking     = new WP_Query(array('post_type' => 'classement', 'orderby' => 'date', 'posts_per_page' => '1', 'meta_query' =>
                    array(
                        'relation'  => 'AND',
                        array(
                            'key'     => 'id_tournoi_r',
                            'value'   => $id_tournament,
                            'compare' => '=',
                        ),
                        array(
                            'key' => 'uuid_user_r',
                            'value' => $uuiduser,
                            'compare' => '=',
                        )
                    )
                ));
                if($user_ranking->have_posts()){
                    while ($user_ranking->have_posts()) : $user_ranking->the_post();
                        $id_user_ranking = get_the_ID();
                    endwhile; $tournois_in_cat->reset_postdata();
                    if(get_field('done_r', $id_user_ranking)){
                        $state  = "done";
                    }
                    else{
                        $state = "begin";
                    }
                }
                ?>
                <div class="col-md-3">
                    <div class="min-tournoi card eh">
                        <?php
                        if (has_post_thumbnail()){
                            $illu = get_the_post_thumbnail_url(get_the_ID(), 'full');
                        }
                        ?>
                        <div class="cov-illu cover" style="background: url(<?php echo $illu; ?>) center center no-repeat">
                            <?php if($state == "done"): ?>
                                <div class="badge badge-success">Terminé</div>
                            <?php elseif($state == "begin"): ?>
                                <div class="badge badge-warning">En cours</div>
                            <?php else: ?>
                                <div class="badge badge-primary">A faire</div>
                            <?php endif; ?>
                            <div class="voile">
                                <div class="spoun">
                                    <?php if($state == "done"): ?>
                                        🥇🥈🥉
                                        <h5>Voir le TOP</h5>
                                    <?php elseif($state == "begin"): ?>
                                        <i class="fal fa-swords"></i>
                                        <h5>Reprendre</h5>
                                    <?php else: ?>
                                        🏆
                                        <h5>Créer mon TOP</h5>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <p class="card-text text-primary">
                                TOP <?php echo get_numbers_of_contenders($id_tournament); ?> : <?php the_title(); ?>
                            </p>
                            <h4 class="card-title">
                                <?php the_field('question_t'); ?>
                            </h4>
                        </div>
                        <?php if($state == "done"): ?>
                            <a href="<?php the_permalink($id_user_ranking); ?>" class="stretched-link"></a>
                        <?php else: ?>
                            <a href="<?php the_permalink(); ?>" class="stretched-link"></a>
                        <?php endif; ?>
                    </div>
                </div>

            <?php endwhile;?>
        </div>
    </div>

    <?php
    $tournoi_cats = get_terms(array(
        'taxonomy'      => 'categorie',
        'orderby'       => 'term_id',
        'order'         => 'ASC',
        'show_empty'    => false
    ) );
    foreach($tournoi_cats as $tournoi_cat) :
        $cat_url    = get_category_link($tournoi_cat->term_id);
        $cat_id     = $tournoi_cat->term_id;
        $cat_count  = $tournoi_cat->count;
        
        $tournois_in_cat = new WP_Query(array('post_type' => 'tournoi', 'orderby' => 'date', 'order' => 'ASC', 'posts_per_page' => -1,
        'tax_query' => array(
            array(
                'taxonomy' => 'categorie',
                'field'    => 'term_id',
                'terms'    => $cat_id,
            ),
        )));
        ?>
        <div class="big-cat">
            <div class="heading-cat">
                <div class="row">
                    <div class="col">
                        <h2 class="text-<?php the_field('couleur_cat', 'term_'.$cat_id); ?> text-uppercase">
                            <i class="<?php the_field('icone_cat', 'term_'.$cat_id); ?>"></i>
                            <?php echo $tournoi_cat->name; ?>
                            <small class="text-muted"><?php echo $tournoi_cat->description; ?></small>
                        </h2>
                    </div>
                </div>
            </div>
            <div class="row">
                <?php while ($tournois_in_cat->have_posts()) : $tournois_in_cat->the_post(); ?>

                    <?php
                    $state            = "";
                    $id_tournament    = get_the_ID();
                    $id_user_ranking  = 0;
                    $uuiduser         = $_COOKIE["vainkeurz_user_id"];
                    $user_ranking     = new WP_Query(array('post_type' => 'classement', 'orderby' => 'date', 'posts_per_page' => '1', 'meta_query' =>
                        array(
                            'relation'  => 'AND',
                            array(
                                'key'     => 'id_tournoi_r',
                                'value'   => $id_tournament,
                                'compare' => '=',
                            ),
                            array(
                                'key' => 'uuid_user_r',
                                'value' => $uuiduser,
                                'compare' => '=',
                            )
                        )
                    ));
                    if($user_ranking->have_posts()){
                        while ($user_ranking->have_posts()) : $user_ranking->the_post();
                            $id_user_ranking = get_the_ID();
                        endwhile; $tournois_in_cat->reset_postdata();
                        if(get_field('done_r', $id_user_ranking)){
                            $state  = "done";
                        }
                        else{
                            $state = "begin";
                        }
                    }
                    ?>
                    <div class="col-md-3">
                        <div class="min-tournoi card eh">
                            <?php
                            if (has_post_thumbnail()){
                                $illu = get_the_post_thumbnail_url(get_the_ID(), 'full');
                            }
                            ?>
                            <div class="cov-illu cover" style="background: url(<?php echo $illu; ?>) center center no-repeat">
                                <?php if($state == "done"): ?>
                                    <div class="badge badge-success">Terminé</div>
                                <?php elseif($state == "begin"): ?>
                                    <div class="badge badge-warning">En cours</div>
                                <?php else: ?>
                                    <div class="badge badge-primary">A faire</div>
                                <?php endif; ?>
                                <div class="voile">
                                    <div class="spoun">
                                        <?php if($state == "done"): ?>
                                            🥇🥈🥉
                                            <h5>Voir le TOP</h5>
                                        <?php elseif($state == "begin"): ?>
                                            <i class="fal fa-swords"></i>
                                            <h5>Reprendre</h5>
                                        <?php else: ?>
                                            🏆
                                            <h5>Créer mon TOP</h5>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <p class="card-text text-primary">
                                    TOP <?php echo get_numbers_of_contenders($id_tournament); ?> : <?php the_title(); ?>
                                </p>
                                <h4 class="card-title">
                                    <?php the_field('question_t'); ?>
                                </h4>
                            </div>
                            <?php if($state == "done"): ?>
                                <a href="<?php the_permalink($id_user_ranking); ?>" class="stretched-link"></a>
                            <?php else: ?>
                                <a href="<?php the_permalink(); ?>" class="stretched-link"></a>
                            <?php endif; ?>
                        </div>
                    </div>

                <?php endwhile;?>
            </div>
        </div>
    <?php endforeach; ?>
</div>
    </div>
    </div>
    </div>
    <!-- END: Content-->
<?php get_footer(); ?>