<?php
$id_tournament                   = get_field('id_tournoi_r');
$uuiduser                        = get_field('uuid_user_r');
$list_contenders_tournoi         = get_field('ranking_r');
$display_titre                   = get_field('ne_pas_afficher_les_titres_t', $id_tournament);
$rounded                         = get_field('c_rounded_t', $id_tournament);

function array_sort_by_column(&$arr, $col, $dir = SORT_DESC) {
    $sort_col = array();
    foreach ($arr as $key=> $row) {
        $sort_col[$key] = $row[$col];
    }
    array_multisort($sort_col, $dir, $arr);
}
array_sort_by_column($list_contenders_tournoi, 'place');

$user_contenders_classement      = array_column($list_contenders_tournoi, 'place', 'id_wp');

$all_user_votes       = new WP_Query(array(
    'post_type'      => 'vote',
    'posts_per_page' => -1,
    'meta_query'     => array(
        'relation'   => 'AND',
        array(
            'key'     => 'id_t_v',
            'value'   => $id_tournament,
            'compare' => '=',
        ),
        array(
            'key'     => 'id_user_v',
            'value'   => $uuiduser,
            'compare' => '=',
        )
    )
));
$nb_user_votes = $all_user_votes->post_count;
get_header();
$illu       = wp_get_attachment_image_src(get_field('cover_t', $id_tournament), 'full');
$illu_url   = $illu[0];
?>
<body <?php body_class('cover'); ?> style="background: url(<?php echo $illu_url; ?>) center center no-repeat">

<?php get_template_part('templates/partials/header'); ?>

<div class="classement">
    <div class="container">
        <div class="row">
            <div class="col">
                <div class="titre-classement text-center">
                    <h2>Votre classement</h2>
                    <h3>Après <?php echo $all_user_votes->post_count; ?> votes</h3>
                </div>
            </div>
        </div>
        <div class="list-classement">
            <div class="row align-items-center jsa">
                <?php
                $i=1; foreach($user_contenders_classement as $c => $p) : ?>
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
                                    <?php $illu = get_the_post_thumbnail_url( $c, 'full' ); ?>
                                    <div class="cov-illu" style="background: url(<?php echo $illu; ?>) center center no-repeat"></div>
                                <?php else: ?>
                                    <?php echo get_the_post_thumbnail( $c, 'full', array( 'class' => 'img-fluid' ) ); ?>
                                <?php endif; ?>
                            </div>
                            <div class="name">
                                <h5 class="mt-2">
                                    <span><?php echo $i; ?></span>
                                    <?php if(!$display_titre): ?>
                                        - <?php echo get_the_title($c); ?>
                                    <?php endif; ?>
                                </h5>
                            </div>

                        </div>

                    </div>

                <?php $i++; endforeach; ?>
            </div>
        </div>
        <div class="row mt-5">
            <div class="col-12">
                <a href="<?php the_permalink(get_page_by_path('elo')); ?>?id_tournoi=<?php echo $id_tournament; ?>" class="cta_2 cta-1">
                    Voir le classement général
                </a>
            </div>
        </div>
    </div>
</div>

<div class="share_rank">
    <div class="container-fluid">
        <div class="row align-items-center">
            <div class="col-sm-12 col-md hide-mobile">
                <a href="<?php bloginfo('url'); ?>/" class="cta-2 cta_btn">
                    <i class="fad fa-arrow-alt-to-left"></i> Retourner à la liste des tournois
                </a>
            </div>
            <div class="col-sm-12 col-md">
                <div class="sharebox">
                    <?php
                    $id_post        = get_the_ID();
                    $url_post       = get_the_permalink();
                    $title_post     = get_the_title($id_tournament)." : ".get_field('question_t', $id_tournament);
                    $img_post       = $illu_url;
                    ?>
                    <ul>
                        <li class="starter_liste">
                            Partager votre classement :
                        </li>
                        <li>
                            <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo $url_post; ?>&quote=<?php echo $title_post; ?>" title="Share on Facebook" target="_blank">
                              <span>
                                <i class="fab fa-facebook-f"></i>
                              </span>
                            </a>
                        </li>

                        <li>
                            <a href="https://twitter.com/intent/tweet?source=<?php echo $url_post; ?>&text=<?php echo $title_post; ?>:%20<?php echo $url_post; ?>" target="_blank" title="Tweet">
                              <span>
                                <i class="fab fa-twitter"></i>
                              </span>
                            </a>
                        </li>

                        <li>
                            <a href="https://www.linkedin.com/shareArticle?mini=true&url=<?php echo $url_post; ?>&title=<?php echo $title_post; ?>" target="_blank" >
                              <span>
                                <i class="fab fa-linkedin-in"></i>
                              </span>
                            </a>
                        </li>

                        <li>
                            <a href="mailto:?subject=<?php echo $title_post; ?>&body=<?php echo $title_post; ?>:<?php echo $url_post; ?>" target="_blank">
                              <span>
                                <i class="fas fa-envelope"></i>
                              </span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<?php get_footer(); ?>