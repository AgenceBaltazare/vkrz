<?php
/*
    Template Name: Classement
*/
?>
<?php
if(isset($_GET['id_tournoi'])){
    $id_tournoi = $_GET['id_tournoi'];
    $illu       = wp_get_attachment_image_src(get_field('cover_t', $id_tournoi), 'full');
    $illu_url   = $illu[0];
}
else{
    header('Location: ' . get_bloginfo('url'));
}
$display_titre = get_field('ne_pas_afficher_les_titres_t', $id_tournoi);
?>
<?php get_header(); ?>
<body <?php body_class('cover'); ?> style="background: url(<?php echo $illu_url; ?>) center center no-repeat">

<?php get_template_part('templates/partials/header'); ?>

<div class="classement">
    <div class="container-fluid">
        <div class="row">
            <div class="col">
                <div class="titre-classement text-center">
                    <h2>Classement ELO</h2>
                    <h3>Après <?php echo all_votes_in_tournament($id_tournoi); ?> votes</h3>
                </div>
            </div>
        </div>
        <div class="list-classement">
            <div class="row">
                <?php $contenders_tournoi = new WP_Query(array('post_type' => 'contender', 'meta_key' => 'ELO_c', 'orderby' => 'meta_value', 'posts_per_page' => '-1', 'meta_query' => array(
                    array(
                        'key'     => 'id_tournoi_c',
                        'value'   => $id_tournoi,
                        'compare' => '=',
                    )
                )));?>
                <?php $i=1; while ($contenders_tournoi->have_posts()) : $contenders_tournoi->the_post();?>
                    <div class="col-md-3">

                        <div class="contenders_min">

                            <div class="illu">
                                <?php
                                echo get_the_post_thumbnail(get_the_ID(), 'full', array('class' => 'img-fluid'));
                                ?>
                            </div>
                            <div class="name">
                                <h5>
                                    <span><?php echo $i; ?></span>
                                    <?php if(!$display_titre): ?>
                                        <br>
                                        <?php the_title(); ?>
                                    <?php endif; ?>
                                    <br><small><?php the_field('ELO_c'); ?></small>
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

<?php get_footer(); ?>
