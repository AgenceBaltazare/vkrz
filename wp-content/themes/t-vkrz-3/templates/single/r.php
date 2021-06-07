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
foreach(get_the_terms($id_tournament, 'categorie' ) as $cat ) {
    $cat_id     = $cat->term_id;
    $cat_name   = $cat->name;
}
?>
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

    <div class="classement mt-2">
        <div class="container-fluid">
            <div class="row">
                <div class="col-xl-8 col-md-7 offset-md-1">
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
                                            <div class="contenders_min <?php if(get_field('c_rounded_t', $id_tournament)){ echo 'rounded'; } ?> mb-3">
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

                                </div>
                            </div>

                            <div class="col-xl-2 col-md-3 offset-md-1">

                                <div class="related">

                                    <?php if(get_field('uuid_user_r') == $uuiduser): ?>
                                        <div class="card">
                                            <div class="card-body">
                                                <h4 class="card-title">
                                                    <span class="ico">😎</span> Partage ton classement
                                                </h4>
                                                <h6 class="card-subtitle text-muted mb-1">
                                                    Il est temps de revendiquer et assumer ses choix !
                                                </h6>
                                                <div class="btn-group justify-content-center share-t" role="group">
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
                                            <div class="btn-group justify-content-center share-t" role="group">
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
                                                <a data-phrase1="Es-tu sûr de toi ?" data-phrase2="Tous les votes de ce Top seront remis à 0" data-idranking="<?php echo $id_ranking; ?>" id="confirm_delete" href="#" class="btn btn-outline-primary waves-effect">
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

                                    <div class="card text-center">
                                        <div class="card-body">
                                            <h2 class="font-weight-bolder">
                                                <?php echo get_user_percent($uuiduser, $id_tournament); ?>% <small>des</small> <span class="ico4">🥷</span>
                                            </h2>
                                            <p class="card-text legende">
                                                ont le même classement que toi !
                                            </p>
                                        </div>
                                        <div class="card-footer">
                                            <a href="<?php the_permalink(get_page_by_path('elo')); ?>?id_top=<?php echo $id_tournament; ?>" class="btn btn-outline-primary waves-effect mb-1">
                                                Voir le classement mondial
                                            </a>
                                        </div>
                                    </div>

                                    <?php
                                        $list_t_already_done = $user_full_data[0]['user_tops_done_ids'];
                                        $related_tournoi = new WP_Query(array(
                                            'post_type' => 'tournoi',
                                            'post__not_in' => $list_t_already_done,
                                            'orderby' => 'rand',
                                            'order' => 'ASC',
                                            'posts_per_page' => 3,
                                            'ignore_sticky_posts'    => true,
                                            'update_post_meta_cache' => false,
                                            'no_found_rows'          => true,
                                            'tax_query' => array(
                                                array(
                                                    'taxonomy' => 'categorie',
                                                    'field'    => 'term_id',
                                                    'terms'    => $cat_id,
                                                ),
                                            )
                                        ));
                                    ?>
                                    <?php if($related_tournoi->have_posts()): ?>
                                        <div class="card">
                                            <div class="card-body">
                                                <h4 class="card-title">
                                                    <span class="ico">🤩</span> D'autres Tops
                                                </h4>
                                                <h6 class="card-subtitle text-muted mb-1">
                                                    C'est dans la même catégorie donc logiquement ça devrait t'intéresser !
                                                </h6>
                                                <div class="row">
                                                    <?php while ($related_tournoi->have_posts()) : $related_tournoi->the_post(); ?>

                                                        <?php get_template_part('partials/min-t'); ?>

                                                    <?php endwhile; ?>
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
    </div>
<!-- END: Content-->
<?php get_footer(); ?>