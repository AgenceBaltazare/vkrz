<?php get_header(); ?>
<?php
$id_tournoi         = get_the_ID();
$list_contenders    = array();
$all_votes = new WP_Query(array('post_type' => 'vote', 'posts_per_page' => -1, 'meta_query' => array(
    array(
        'key' => 'id_t_v',
        'value' => $id_tournoi,
        'compare' => '=',
    )
)));
$contenders = new WP_Query(array('post_type' => 'contender', 'posts_per_page' => -1, 'orderby' => 'date', 'meta_query' => array(
    array(
        'key' => 'id_tournoi_c',
        'value' => $id_tournoi,
        'compare' => '=',
    )
)));
$i=0; while ($contenders->have_posts()) : $contenders->the_post();

    array_push($list_contenders, get_the_ID());

    $rand_c = array_rand($list_contenders, 2);
    $id_c_1 = $list_contenders[$rand_c[0]];
    $id_c_2 = $list_contenders[$rand_c[1]];

$i++; endwhile;

$nums_pairs = "";
$nb_battle  = 0;
for ($i = 0; $i <= count($list_contenders); $i++) {
    for ($j = $i + 1; $j < count($list_contenders); $j++) {
        $nums_pairs .= $list_contenders[$i] . "," . $list_contenders[$j] . "<br>";
        $nb_battle++;
    }
}

wp_reset_query();
?>
<div class="main">
    <header class="header">
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="col-6">
                    <div class="logo">
                        <a href="<?php bloginfo('url'); ?>/">
                            <img src="<?php bloginfo('template_directory'); ?>/assets/img/logo-vainkeurz-min.png" alt="" class="img-fluid">
                        </a>
                    </div>
                </div>
                <div class="col-6">
                    <div class="display_votes">
                        <h6>
                            <?php echo $all_votes->post_count; ?> votes
                        </h6>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <div class="container">
        <div class="tournoi_infos">
            <div class="row align-items-center">
                <div class="col-12">
                    <div class="bloc-titre">
                        <h1 class="title-battle">
                            <b>
                                <?php the_title(); ?>
                            </b>
                            <span>
                                <?php the_field('question_t'); ?>
                                <em><?php echo $nb_battle; ?> duels possibles</em>
                            </span>
                        </h1>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="display_battle">
                    <div class="row align-items-center">

                        <div class="col-5 link-contender">
                            <a href="<?php bloginfo('template_directory'); ?>/function/meca/do_elo.php/?t=<?php echo $id_tournoi; ?>&v=<?php echo $id_c_1; ?>&l=<?php echo $id_c_2; ?>">
                                <?php
                                echo get_the_post_thumbnail($id_c_1, 'full', array('class' => 'img-fluid'));
                                ?>
                                <h2 class="title-contender">
                                    <?php echo get_the_title($id_c_1); ?>
                                </h2>
                            </a>
                        </div>
                        <div class="col-2">
                            <h4 class="text-center versus">
                                VS
                            </h4>
                        </div>
                        <div class="col-5 link-contender">
                            <a href="<?php bloginfo('template_directory'); ?>/function/meca/do_elo.php/?t=<?php echo $id_tournoi; ?>&v=<?php echo $id_c_2; ?>&l=<?php echo $id_c_1; ?>">
                                <?php
                                echo get_the_post_thumbnail($id_c_2, 'full', array('class' => 'img-fluid'));
                                ?>
                                <h2 class="title-contender">
                                    <?php echo get_the_title($id_c_2); ?>
                                </h2>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="classement_t row">
                    <?php
                    $contenders = new WP_Query(
                        array(
                            'post_type'             => 'contender',
                            'posts_per_page'        => -1,
                            'meta_key'              => 'ELO_c',
                            'orderby'			    => 'meta_value',
                            'order'				    => 'DESC',
                            'meta_query'            => array(
                                array(
                                    'key' => 'id_tournoi_c',
                                    'value' => $id_tournoi,
                                    'compare' => 'LIKE',
                                )
                            )
                        )
                    );
                    $i=1; while ($contenders->have_posts()) : $contenders->the_post(); ?>

                        <div class="contenders_min col">

                            <div class="rank">
                                <h3>
                                    <?php echo $i; ?>
                                </h3>
                            </div>

                            <div class="illu">
                                <?php if (has_post_thumbnail()) : ?>
                                    <?php the_post_thumbnail('full', array('class'=>'img-fluid')); ?>
                                <?php endif; ?>
                            </div>
                            <div class="name">
                                <h5>
                                    <?php the_title(); ?>
                                </h5>
                                <h6>
                                    <?php the_field('ELO_c'); ?>
                                </h6>
                            </div>

                        </div>

                        <?php $i++; endwhile; wp_reset_query(); ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php get_footer(); ?>
