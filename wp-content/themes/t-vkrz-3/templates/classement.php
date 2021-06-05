<?php
/*
    Template Name: Classement
*/
?>
<?php
global $id_tournament;
global $cat_id;
global $cat_name;
if(isset($_GET['id_tournoi'])){
    $id_tournament  = $_GET['id_tournoi'];
}
else{
    header('Location: ' . get_bloginfo('url'));
}
$display_titre                   = get_field('ne_pas_afficher_les_titres_t', $id_tournament);
$rounded                         = get_field('c_rounded_t', $id_tournament);
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

                                    <?php $contenders_tournament = new WP_Query(array('post_type' => 'contender', 'meta_key' => 'ELO_c', 'orderby' => 'meta_value_num', 'posts_per_page' => '-1', 'meta_query' => array(
                                        array(
                                            'key'     => 'id_tournoi_c',
                                            'value'   => $id_tournament,
                                            'compare' => '=',
                                        )
                                    )));?>
                                    <?php $i=1; while ($contenders_tournament->have_posts()) : $contenders_tournament->the_post();?>

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
                                                            <?php $illu = get_the_post_thumbnail_url(get_the_ID(), 'full'); ?>
                                                            <div class="cov-illu" style="background: url(<?php echo $illu; ?>) center center no-repeat"></div>
                                                        <?php else: ?>
                                                            <?php echo get_the_post_thumbnail(get_the_ID(), 'full', array('class' => 'img-fluid')); ?>
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
                                                                <?php the_title(); ?>
                                                            <?php endif; ?>
                                                        </h5>
                                                    </div>
                                                </div>
                                            </div>
                                    <?php $i++; endwhile; ?>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-2 col-md-3 offset-md-1">

                            <div class="related">

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