<?php get_header(); ?>

    <!-- BEGIN: Content-->
    <div class="app-content content ">
        <div class="content-overlay"></div>
        <div class="content-wrapper">
            <div class="content-header row"></div>
            <div class="content-body">

                <div class="pk">
                    <h1>Créer & partage tes propres Tops ! 🖖</h1>
                    <p>
                        Voici quelques tournois pour tester le concept de VAINKEURZ.
                        <br>
                        Nous sommes curieux de savoir <b>ce que tu penses de tout ça</b>, si tu es motivé tu peux nous donner ton avis ici 👉
                        <a href="https://baltazare1.typeform.com/to/j9n8JU" target="_blank">petit formulaire easy 😗</a>
                    </p>
                </div>

                <div class="list-tournois">
                    <div class="row">
                        <?php $list_tournois = new WP_Query(array('post_type' => 'tournoi', 'orderby' => 'date', 'posts_per_page' => '-1')); ?>
                        <?php while ($list_tournois->have_posts()) : $list_tournois->the_post(); ?>
                            <?php
                            $uuiduser         = $_COOKIE["vainkeurz_user_id"];
                            $state            = "";
                            $id_tournament    = get_the_ID();
                            $id_user_ranking  = 0;
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
                                endwhile;
                                $list_tournois->reset_postdata();
                                if(get_field('done_r', $id_user_ranking)){
                                    $state  = "done";
                                }
                                else{
                                    $state = "begin";
                                }
                            }
                            ?>
                            <div class="col-12 col-md-4 ">
                                <div class="min-tournoi">
                                    <div class="card card-profile">
                                        <?php
                                        if (has_post_thumbnail()){
                                            $illu = get_the_post_thumbnail_url(get_the_ID(), 'full');
                                        }
                                        ?>
                                        <div class="cov-illu cover" style="background: url(<?php echo $illu; ?>) center center no-repeat"></div>
                                        <div class="card-body">
                                            <?php if($state == "done"): ?>
                                                <div class="profile-image-wrapper">
                                                    <div class="profile-image">
                                                        <div class="avatar">
                                                            <?php
                                                            $id_vainkeur  = get_user_vainkeur($id_user_ranking);
                                                            $illu_vainkeur = get_the_post_thumbnail_url($id_vainkeur, 'full');
                                                            ?>
                                                            <img src="<?php echo $illu_vainkeur; ?>">
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php endif; ?>

                                            <div class="eh">
                                                <?php if($state == "done"): ?>
                                                    <div class="badge badge-light-success profile-badge">Terminé</div>
                                                <?php elseif($state == "begin"): ?>
                                                    <div class="badge badge-light-warning profile-badge">En cours</div>
                                                <?php else: ?>
                                                    <div class="badge badge-light-primary profile-badge">A faire</div>
                                                <?php endif; ?>

                                                <h6 class="text-muted">
                                                    <?php the_title(); ?>
                                                </h6>

                                                <h3>
                                                    <?php the_field('question_t'); ?>
                                                </h3>

                                                <p>
                                                    <?php the_field('precision_t'); ?>
                                                </p>
                                            </div>

                                            <hr class="mb-2">

                                            <div class="d-flex justify-content-between align-items-center">
                                                <div>
                                                    <h6 class="text-muted font-weight-bolder">Contenders</h6>
                                                    <h3 class="mb-0">
                                                        <?php echo get_numbers_of_contenders($id_tournament); ?>
                                                    </h3>
                                                </div>
                                                <div>
                                                    <h6 class="text-muted font-weight-bolder">Total des votes</h6>
                                                    <h3 class="mb-0">
                                                        <?php echo all_votes_in_tournament($id_tournament); ?>
                                                    </h3>
                                                </div>
                                                <div>
                                                    <h6 class="text-muted font-weight-bolder">Mes votes</h6>
                                                    <h3 class="mb-0">
                                                        <?php echo all_user_votes_in_tournament($id_user_ranking); ?>
                                                    </h3>
                                                </div>
                                            </div>
                                        </div>
                                        <?php if($state == "done"): ?>
                                            <a href="<?php the_permalink($id_user_ranking); ?>" class="stretched-link"></a>
                                        <?php else: ?>
                                            <a href="<?php the_permalink(); ?>" class="stretched-link"></a>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        <?php endwhile;?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END: Content-->

<?php get_footer(); ?>