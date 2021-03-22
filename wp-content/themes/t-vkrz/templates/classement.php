<?php
/*
    Template Name: Classement
*/
?>
<?php
if(isset($_GET['id_tournoi'])){
    $id_tournament  = $_GET['id_tournoi'];
    $illu           = wp_get_attachment_image_src(get_field('cover_t', $id_tournament), 'full');
    $illu_url       = $illu[0];
}
else{
    header('Location: ' . get_bloginfo('url'));
}
$display_titre = get_field('ne_pas_afficher_les_titres_t', $id_tournament);
get_header();
$illu       = wp_get_attachment_image_src(get_field('cover_t', $id_tournament), 'full');
$illu_url   = $illu[0];
?>
<!-- BEGIN: Content-->
<div class="app-content content cover" style="background: url(<?php echo $illu_url; ?>) center center no-repeat">
    <div class="content-overlay"></div>
    <div class="content-wrapper">
        <div class="content-header row"></div>
        <div class="content-body">
            <div class="classement">
                <div class="container">
                    <div class="row">
                        <div class="col">
                            <div class="titre-classement text-center">
                                <h2>Classement ELO</h2>
                                <h3>Après <?php echo all_votes_in_tournament($id_tournament); ?> votes</h3>
                            </div>
                        </div>
                    </div>
                    <div class="list-classement">
                        <div class="row align-items-center jsa">
                            <?php $contenders_tournament = new WP_Query(array('post_type' => 'contender', 'meta_key' => 'ELO_c', 'orderby' => 'meta_value', 'posts_per_page' => '-1', 'meta_query' => array(
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
                                            <div class="contenders_min <?php if(get_field('c_rounded_t', $id_tournament)){ echo 'rounded'; } ?>">

                                                <div class="illu">
                                                    <?php if(get_field('visuel_cover_t', $id_tournament)): ?>
                                                        <?php $illu = get_the_post_thumbnail_url(get_the_ID(), 'full'); ?>
                                                        <div class="cov-illu" style="background: url(<?php echo $illu; ?>) center center no-repeat"></div>
                                                    <?php else: ?>
                                                        <?php echo get_the_post_thumbnail(get_the_ID(), 'full', array( 'class' => 'img-fluid')); ?>
                                                    <?php endif; ?>
                                                </div>
                                                <div class="name">
                                                    <h5 class="mt-2">
                                                        <span><?php echo $i; ?></span>
                                                        <?php if(!$display_titre): ?>
                                                            - <?php the_title(); ?>
                                                        <?php endif; ?>
                                                    </h5>
                                                </div>

                                            </div>

                                        </div>

                                        <?php $i++; endwhile; ?>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="share_rank">
                            <div class="container-fluid">
                                <div class="row align-items-center">
                                    <div class="col-sm-12 col-md">
                                        <a href="<?php bloginfo('url'); ?>/" class="cta-2 cta_btn">
                                            <i class="fad fa-arrow-alt-to-left"></i> Retourner à la liste des tournois
                                        </a>
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
