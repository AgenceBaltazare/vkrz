<?php
$id_tournoi                      = get_field('id_tournoi_r');
$uuiduser                        = get_field('uuid_user_r');
$list_contenders_tournoi         = get_field('ranking_r');

function array_sort_by_column(&$arr, $col, $dir = SORT_DESC) {
    $sort_col = array();
    foreach ($arr as $key=> $row) {
        $sort_col[$key] = $row[$col];
    }
    array_multisort($sort_col, $dir, $arr);
}
array_sort_by_column($list_contenders_tournoi, 'place');

$user_contenders_classement      = array_column($list_contenders_tournoi, 'place', 'id_global');

$all_user_votes       = new WP_Query(array(
    'post_type'      => 'vote',
    'posts_per_page' => -1,
    'meta_query'     => array(
        'relation'   => 'AND',
        array(
            'key'     => 'id_t_v',
            'value'   => $id_tournoi,
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
?>

<?php get_header(); ?>

<?php
if(get_field('cover_t', $id_tournoi)){
    $illu       = wp_get_attachment_image_src(get_field('cover_t', $id_tournoi), 'full');
    $illu_url   = $illu[0];
}
?>
<body <?php body_class(array('cover', $body_class)); ?> style="background: url(<?php echo $illu_url; ?>) center center no-repeat">

<?php if(get_field('done_r')): ?>
    <div class="classement">
        <div class="container-fluid">
            <div class="row">
                <div class="col">
                    <div class="titre-classement text-center">
                        <h2>Votre classement</h2>
                        <h3>Après <?php echo $all_user_votes->post_count; ?> votes</h3>
                    </div>
                </div>
            </div>
            <div class="list-classement">
                <div class="row">
                    <?php

                    $i=1; foreach($user_contenders_classement as $c => $p) : ?>
                        <br>
                        <div class="col-md-3">

                            <div class="contenders_min">

                                <div class="illu">
                                    <?php
                                    echo get_the_post_thumbnail($c, 'full', array('class' => 'img-fluid'));
                                    ?>
                                </div>
                                <div class="name">
                                    <h5>
                                        <span><?php echo $i; ?></span>
                                        <br>
                                        <?php echo get_the_title($c); ?>
                                    </h5>
                                </div>

                            </div>

                        </div>

                    <?php $i++; endforeach; ?>
                </div>
            </div>
        </div>
    </div>
<?php else: ?>
    <div class="classement">
        <div class="container-fluid">
            <div class="row">
                <div class="col">
                    <div class="titre-classement text-center">
                        <h2>Classement en cours de finalisation</h2>
                        <h3>
                            <a href="<?php the_permalink($id_tournoi); ?>">
                                Cliquez ici pour revenir au tournoi
                            </a>
                        </h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>
<?php get_footer(); ?>