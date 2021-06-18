<?php
get_header();
global $uuiduser;
global $id_tournament;
global $top_number;
global $id_ranking;
global $top_url;
global $top_title;
global $top_question;
global $top_img;
global $top_number;
global $user_full_data;
$display_titre                   = get_field('ne_pas_afficher_les_titres_t', $id_tournament);
$rounded                         = get_field('c_rounded_t', $id_tournament);
$user_ranking                    = get_user_ranking($id_ranking);
$url_ranking                     = get_the_permalink($id_ranking);
$title_post                      = $top_title." : ".$top_question;
$illu                            = wp_get_attachment_image_src(get_field('cover_t', $id_tournament), 'full');
$illu_url                        = $illu[0];
$list_cat                        = get_the_terms($id_tournament, 'categorie');
$list_concepts                   = get_the_terms($id_tournament, 'concept');
foreach($list_cat as $cat ) {
    $cat_id     = $cat->term_id;
    $cat_name   = $cat->name;
}
?>
<!-- Vertical modal -->
<div class="vertical-modal-ex">
    <div class="modal fade" id="commentModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterTitle">Qu'as-tu pensé de ce Top ?</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form class="form form-vertical form-note" data-id-tournament="<?php echo $id_tournament; ?>" data-uuiduser="<?php echo $uuiduser; ?>">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <textarea class="form-control" id="commentairezone" rows="4" placeholder="Ton commenaire..."></textarea>
                                    <p class="merci">
                                        Un grand Merci pour ce retour <span class="ico">🙏</span>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer text-center">
                        <button type="submit" class="btn btn-primary mr-1 waves-effect waves-float waves-light">Valider</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Vertical modal end-->
<!-- BEGIN: Content-->
<div class="app-content content cover" style="background: url(<?php echo $illu_url; ?>) center center no-repeat">
    <div class="content-overlay"></div>
    <div class="content-wrapper">
    <div class="content-body">

    <div class="intro-mobile">
        <div class="tournament-heading text-center">
            <h3 class="mb-0 t-titre-tournoi">
                Top <?php echo $top_number; ?> <span class="ico text-center">🏆</span> <?php echo $top_title; ?>
            </h3>
            <h4 class="mb-0">
                <?php echo $top_question; ?>
            </h4>
        </div>
    </div>

    <div class="classement mt-1">
        <div class="row">
            <div class="col-md-8">
                <div class="list-classement">
                    <div class="row align-items-end justify-content-center">
                        <?php
                        $i=1; foreach($user_ranking as $c => $p) : ?>
                            <?php if($i == 1): ?>
                            <div class="col-12 col-md-5">
                            <?php elseif($i == 2): ?>
                            <div class="col-7 col-md-4">
                            <?php elseif($i == 3): ?>
                            <div class="col-5 col-md-3">
                            <?php else: ?>
                            <div class="col-md-2 col-4">
                            <?php endif; ?>
                                <?php
                                if($i >= 4){
                                    $d = 3;
                                }
                                else{
                                    $d = $i-1;
                                }
                                ?>
                                <div class="animate__jackInTheBox animate__animated animate__delay-<?php echo $d; ?>s contenders_min <?php if(get_field('c_rounded_t', $id_tournament)){ echo 'rounded'; } ?> mb-3">
                                    <div class="illu">
                                        <?php if(get_field('visuel_cover_t', $id_tournament)): ?>
                                            <?php $illu = get_the_post_thumbnail_url( $c, 'full' ); ?>
                                            <div class="cov-illu" style="background: url(<?php echo $illu; ?>) center center no-repeat"></div>
                                        <?php else: ?>
                                            <?php echo get_the_post_thumbnail($c, 'full', array('class' => 'img-fluid')); ?>
                                        <?php endif; ?>
                                    </div>
                                    <div class="name eh2">
                                        <h5 class="mt-2">
                                            <?php if($i == 1): ?>
                                                <span class="ico">🥇</span>
                                            <?php elseif($i == 2): ?>
                                                <span class="ico">🥈</span>
                                            <?php elseif($i == 3): ?>
                                                <span class="ico">🥉</span>
                                            <?php else: ?>
                                                <span><?php echo $i; ?><br></span>
                                            <?php endif; ?>
                                            <?php if(!$display_titre): ?>
                                                <?php echo get_the_title($c); ?>
                                            <?php endif; ?>
                                        </h5>
                                    </div>
                                </div>
                            </div>
                        <?php $i++; endforeach; ?>
                    </div>

                    <?php
                    global $user_full_data;
                    $list_t_already_done = $user_full_data[0]['user_tops_done_ids'];

                    if (empty($list_concepts)) $term_list = array();
                    $list_concepts = wp_list_pluck($list_concepts, 'slug');

                    $tournois_in_cat     = new WP_Query(array(
                        'ignore_sticky_posts'    => true,
                        'update_post_meta_cache' => false,
                        'no_found_rows'          => true,
                        'post_type'              => 'tournoi',
                        'post__not_in'           => $list_t_already_done,
                        'orderby'                => 'rand',
                        'order'                  => 'ASC',
                        'posts_per_page'         => 10,
                        'tax_query' => array(
                            'relation' => 'OR',
                            array(
                                'taxonomy' => 'categorie',
                                'field'    => 'term_id',
                                'terms'    => array($cat_id)
                            ),
                            array(
                                'taxonomy' => 'concept',
                                'field' => 'slug',
                                'terms' => $list_concepts
                            )
                        )
                    ));
                    ?>
                    <?php if($tournois_in_cat->have_posts()): ?>
                        <section class="list-tournois mb-3 animate__fadeInUp animate__animated animate__delay-2s">
                            <div class="big-cat">
                                <div class="heading-cat">
                                    <div class="row">
                                        <div class="col">
                                            <h2 class="text-primary text-uppercase">
                                                <span class="ico">🥰</span> Tops similaires
                                                <small class="text-muted">Ça devrait te plaidre</small>
                                            </h2>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div id="component-swiper-responsive-breakpoints">
                                <div class="swiper-responsive-breakpoints swiper-container swiper-1">
                                    <div class="swiper-wrapper">
                                        <?php
                                        while ($tournois_in_cat->have_posts()) : $tournois_in_cat->the_post(); ?>

                                            <?php get_template_part('partials/min-t'); ?>

                                        <?php endwhile;?>
                                    </div>
                                    <div class="swiper-button-next swiper-button-next-0"></div>
                                    <div class="swiper-button-prev swiper-button-prev-0"></div>
                                </div>
                            </div>
                        </section>
                    <?php endif; ?>
                </div>
            </div>

            <div class="col-md-3 offset-md-1">

                <div class="related animate__backInDown animate__animated animate__delay-3s">
                    <div class="dorating">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">
                                    <span class="ico">🙏</span> As-tu apprécier ce Top ?
                                </h4>
                                <h6 class="card-subtitle text-muted mb-1">
                                    Vos retours nous aident beaucoup à améliorer VAINKEURZ !
                                </h6>
                                <div class=card-stars">
                                    <?php
                                    $note = get_note($id_tournament, $uuiduser);
                                    if($note[0]["note"] > 0): ?>
                                        <div class="startchoicedone" style="display: block; !important">
                                            <span class="star_number">
                                                <?php echo $note[0]["note"]; ?>
                                            </span>
                                            <span class="ico">⭐️</span>
                                        </div>
                                    <?php else: ?>
                                        <div class="starchoice" data-id-tournament="<?php echo $id_tournament; ?>" data-uuiduser="<?php echo $uuiduser; ?>">
                                            <span class="star star-1" data-star="1">⭐️</span>
                                            <span class="star star-2" data-star="2">⭐️</span>
                                            <span class="star star-3" data-star="3">⭐️</span>
                                            <span class="star star-4" data-star="4">⭐️</span>
                                            <span class="star star-5" data-star="5">⭐️</span>
                                        </div>
                                        <div class="startchoicedone">
                                            <span class="star_number"></span>
                                            <span class="ico">⭐️</span>
                                        </div>
                                    <?php endif; ?>
                                    <div class="commentbox mt-1">
                                        <a href="#" class="btn btn-outline-primary waves-effect" data-toggle="modal" data-target="#commentModal">
                                            Ajouter un commentaire
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="related animate__fadeInRight animate__animated animate__delay-4s">

                    <div class="card">
                        <div class="card-body">
                            <h2 class="font-weight-bolder mb-0">
                                <?php echo get_user_percent(get_field('uuid_user_r'), $id_tournament); ?>% <small>des Tops identiques à celui-ci !</small>
                            </h2>
                        </div>
                        <div class="card-footer" id="clt">
                            <a href="<?php the_permalink(get_page_by_path('elo')); ?>?id_top=<?php echo $id_tournament; ?>" class="btn btn-outline-primary waves-effect mb-1">
                                Classement mondial
                            </a>
                            <a href="<?php the_permalink(get_page_by_path('liste-des-tops')); ?>?id_top=<?php echo $id_tournament; ?>" class="btn btn-outline-primary waves-effect mb-1">
                                Tous les Tops
                            </a>
                        </div>
                    </div>

                    <?php if(get_field('uuid_user_r') == $uuiduser): ?>
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">
                                    <span class="ico">😎</span> Partage ton classement
                                </h4>
                                <h6 class="card-subtitle text-muted mb-1">
                                    Il est temps de revendiquer et assumer ses choix !
                                </h6>
                                <div class="btn-group justify-content-center share-t w-100" role="group">
                                    <?php
                                    $url_ranking = get_permalink($id_ranking);
                                    ?>
                                    <a href="https://twitter.com/intent/tweet?text=Voici mon TOP <?php echo $top_number; ?> <?php echo $top_title; ?>&via=vainkeurz&hashtags=VKRZ&url=<?php echo $url_ranking; ?>" target="_blank" title="Tweet" class="btn btn-icon btn-outline-primary">
                                        <i class="fab fa-twitter"></i>
                                    </a>
                                    <a href="whatsapp://send?text=<?php echo $url_ranking; ?>" data-action="share/whatsapp/share" class="btn btn-icon btn-outline-primary">
                                        <i class="fab fa-whatsapp"></i>
                                    </a>
                                    <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo $url_ranking; ?>" title="Partager sur Facebook" target="_blank" class="btn btn-icon btn-outline-primary">
                                        <i class="fab fa-facebook-f"></i>
                                    </a>
                                </div>
                            </div>
                        </div>

                    <?php endif; ?>

                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">
                                <span class="ico">🤪</span> Fais tourner le Top
                            </h4>
                            <h6 class="card-subtitle text-muted mb-1">
                                Plus on est de fou plus on .. TOP !
                            </h6>
                            <div class="btn-group justify-content-center share-t w-100" role="group">
                                <a href="https://twitter.com/intent/tweet?text=J'ai fait mon TOP <?php echo $top_number; ?> <?php echo $top_title; ?> maintenant c'est à vous 🤪🤪 &via=vainkeurz&hashtags=VKRZ&url=<?php echo $top_url; ?>" target="_blank" title="Tweet" class="btn btn-icon btn-outline-primary">
                                    <i class="fab fa-twitter"></i>
                                </a>
                                <a href="whatsapp://send?text=<?php echo $top_url; ?>" data-action="share/whatsapp/share" class="btn btn-icon btn-outline-primary">
                                    <i class="fab fa-whatsapp"></i>
                                </a>
                                <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo $top_url; ?>" title="Partager sur Facebook" target="_blank" class="btn btn-icon btn-outline-primary">
                                    <i class="fab fa-facebook-f"></i>
                                </a>
                            </div>
                        </div>
                    </div>

                    <?php if(get_field('uuid_user_r') == $uuiduser): ?>

                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">
                                    <span class="ico">🙃</span> Tu t'attendais pas à ça ?
                                </h4>
                                <h6 class="card-subtitle text-muted mb-1">
                                    T'inquiète on te laisse refaire le Top
                                </h6>
                                <a data-phrase1="Es-tu sûr de toi ?" data-phrase2="Tous les votes de ce Top seront remis à 0" data-idranking="<?php echo $id_ranking; ?>" id="confirm_delete" href="#" class="btn btn-outline-primary waves-effect mb-1">
                                    Recommencer
                                </a>
                            </div>
                        </div>

                    <?php else: ?>

                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">
                                    <span class="ico">🤬</span> D'accord ou pas d'accord avec ce Podium ?
                                </h4>
                                <h6 class="card-subtitle text-muted mb-1">
                                    Il est temps d'exprimer et de revendiquer ton propre avis !
                                </h6>
                                <a href="<?php echo $top_url; ?>" class="btn btn-outline-primary waves-effect">
                                    Faire mon propre Top
                                </a>
                            </div>
                        </div>

                    <?php endif; ?>

                    <?php if(get_field('uuid_user_r') == $uuiduser): ?>
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">
                                    <span class="ico">🔮</span> Rejoins l'élite
                                </h4>
                                <h6 class="card-subtitle text-muted mb-1">
                                    Propose-nous tes idées de tops et de fonctionnalités !
                                </h6>
                                <div class="btn-group justify-content-center share-t w-100" role="group">
                                    <a href="https://discord.gg/w882sUnrhE" title="Rejoinds notre discord" target="_blank" class="btn btn-icon btn-outline-primary">
                                        <i class="fab fa-discord fa-lg mr-1"></i> Discord de VAINKEURZ
                                    </a>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
</div>
<!-- END: Content-->
<?php get_footer(); ?>