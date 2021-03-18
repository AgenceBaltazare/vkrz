<?php
/*
    Template Name: Classement
*/
?>
<?php
if(isset($_GET['id_tournoi'])){
    $id_tournoi = $_GET['id_tournoi'];
}
else{
    header('Location: ' . get_bloginfo('url'));
}
$uuiduser                        = get_field('uuid_user_r');
$display_titre                   = get_field('ne_pas_afficher_les_titres_t', $id_tournoi);
if(get_field('cover_t', $id_tournoi)){
    $illu       = wp_get_attachment_image_src(get_field('cover_t', $id_tournoi), 'full');
    $illu_url   = $illu[0];
}
?>
<?php get_header(); ?>
<body <?php body_class(array('cover', $body_class)); ?> style="background: url(<?php echo $illu_url; ?>) center center no-repeat">

<header class="header">
    <div class="container-fluid">
        <div class="row align-items-center">
            <div class="col-sm-4">
                <div class="logo">
                    <a href="<?php bloginfo('url'); ?>/">
                        <img src="<?php bloginfo('template_directory'); ?>/assets/img/logo-vainkeurz.png" alt="" class="img-fluid">
                    </a>
                </div>
            </div>
            <div class="col-sm-8 text-right">
                <div class="display_users_votes">
                    <a href="https://baltazare1.typeform.com/to/j9n8JU" target="_blank" class="cta_2">
                        ☝️ Donnez nous votre avis !
                    </a>
                </div>
            </div>
        </div>
    </div>
</header>

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
            <div class="col-sm-12 col-md">
                <a href="<?php the_permalink($id_tournoi); ?>" class="cta-2 cta_btn">
                    <i class="fad fa-arrow-alt-to-left"></i> Retourner au tournoi
                </a>
            </div>
        </div>
    </div>
</div>

<?php get_footer(); ?>
