<?php
global $id_tournament;
global $cat_id;
global $cat_name;
global $banner;
global $id_ranking;
$id_ranking                      = get_the_ID();
$id_tournament                   = get_field('id_tournoi_r');
$uuiduser                        = get_field('uuid_user_r');
$display_titre                   = get_field('ne_pas_afficher_les_titres_t', $id_tournament);
$rounded                         = get_field('c_rounded_t', $id_tournament);
$user_ranking                    = get_user_ranking($id_ranking);
$url_ranking                     = get_the_permalink();
$title_post                      = get_the_title($id_tournament)." : ".get_field('question_t', $id_tournament);
$illu                            = wp_get_attachment_image_src(get_field('cover_t', $id_tournament), 'full');
$illu_url                        = $illu[0];
foreach(get_the_terms($id_tournament, 'categorie' ) as $cat ) {
    $cat_id     = $cat->term_id;
    $cat_name   = $cat->name;
}
get_header();
?>
<!-- BEGIN: Content-->
<div class="app-content content cover">
    <div class="content-overlay"></div>
    <div class="content-wrapper">
        <div class="content-body mt-2">
            <div class="classement">
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

                                <div class="card">
                                    <img src="<?php echo $banner; ?>" alt="" class="img-fluid">
                                </div>

                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="card-title">
                                            <span class="ico">😎</span> Partage ton Top
                                        </h4>
                                        <h6 class="card-subtitle text-muted mb-1">
                                            Il est temps de revendiquer et assumer ses choix !
                                        </h6>
                                        <div class="btn-group justify-content-center share-t" role="group">
                                            <?php
                                            $url_tournament   = get_permalink($id_tournament);
                                            $title_tournament = get_the_title($id_tournament);
                                            ?>
                                            <a href="https://twitter.com/intent/tweet?source=<?php echo $url_tournament; ?>&text=Voici mon TOP <?php echo get_numbers_of_contenders($id_tournament); ?> <?php echo $title_tournament; ?> - <?php the_field('question_t', $id_tournament); ?> 👉 <?php echo $url_tournament; ?>" target="_blank" title="Tweet" class="btn btn-icon btn-outline-primary">
                                                <i class="fab fa-twitter"></i>
                                            </a>
                                            <a href="whatsapp://send?text=<?php echo $url_tournament; ?>" data-action="share/whatsapp/share" class="btn btn-icon btn-outline-primary">
                                                <i class="fab fa-whatsapp"></i>
                                            </a>
                                            <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo $url_tournament; ?>&text=Voici mon TOP <?php echo get_numbers_of_contenders($id_tournament); ?> <?php echo $title_tournament; ?> - <?php the_field('question_t', $id_tournament); ?> 👉" title="Partager sur Facebook" target="_blank" class="btn btn-icon btn-outline-primary">
                                                <i class="fab fa-facebook-f"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>

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

                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="card-title">
                                            <span class="ico">🧐</span> Classement mondial
                                        </h4>
                                        <h6 class="card-subtitle text-muted mb-1">
                                            Tu peux comparer tes choix à ceux des autres humains.
                                        </h6>
                                        <a href="<?php the_permalink(get_page_by_path('elo')); ?>?id_tournoi=<?php echo $id_tournament; ?>" class="btn btn-outline-primary waves-effect">
                                            Voir le classement
                                        </a>
                                    </div>
                                </div>

                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="card-title">
                                            <span class="ico">🤩</span> D'autres Tops
                                        </h4>
                                        <h6 class="card-subtitle text-muted mb-1">
                                            C'est dans la même catégorie donc logiquement ça devrait t'intéresser !
                                        </h6>
                                        <?php
                                        global $list_t_already_done;
                                        $related_tournoi = new WP_Query(array('post_type' => 'tournoi', 'post__not_in' => $list_t_already_done, 'orderby' => 'rand', 'order' => 'ASC', 'posts_per_page' => 3,
                                            'tax_query' => array(
                                                array(
                                                    'taxonomy' => 'categorie',
                                                    'field'    => 'term_id',
                                                    'terms'    => $cat_id,
                                                ),
                                            )
                                        ));
                                        while ($related_tournoi->have_posts()) : $related_tournoi->the_post(); ?>

                                            <?php get_template_part('partials/min-t'); ?>

                                        <?php endwhile; ?>
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
<!-- END: Content-->

<?php get_footer(); ?>