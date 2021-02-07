<?php get_header(); ?>
<?php
$id_tournoi      = get_the_ID();
$list_contenders = array();
$i               = 0;
$contenders      = new WP_Query(array(
    'post_type'      => 'contender',
    'posts_per_page' => -1,
    'orderby'        => 'date',
    'meta_query'     => array(
        array(
            'key'     => 'id_tournoi_c',
            'value'   => $id_tournoi,
            'compare' => '=',
        )
    )
));
while ($contenders->have_posts()) : $contenders->the_post();

    array_push($list_contenders, get_the_ID());

endwhile;

$rand_c = array_rand($list_contenders, 2);
$id_c_1 = $list_contenders[$rand_c[0]];
$id_c_2 = $list_contenders[$rand_c[1]];

wp_reset_query();
?>
<div class="main">
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
                    <div class="row align-items-center contenders-containers">
                        <div class="col-5 link-contender contender_1">
                            <a data-contender-tournament="<?= $id_tournoi ?>" data-contender-chosen="<?= $id_c_1 ?>" data-contender-notchosen="<?= $id_c_2 ?>" id="c_1">
                                <?php
                                echo get_the_post_thumbnail( $id_c_1, 'full', array( 'class' => 'img-fluid' ) );
                                ?>
                                <h2 class="title-contender">
                                    <?php echo get_the_title( $id_c_1 ); ?>
                                </h2>
                            </a>
                        </div>
                        <div class="col-2">
                            <h4 class="text-center versus">
                                VS
                            </h4>
                        </div>
                        <div class="col-5 link-contender contender_2">
                            <a data-contender-tournament="<?= $id_tournoi ?>" data-contender-chosen="<?= $id_c_2 ?>" data-contender-notchosen="<?= $id_c_1 ?>" id="c_2">
                                <?php
                                echo get_the_post_thumbnail( $id_c_2, 'full', array( 'class' => 'img-fluid' ) );
                                ?>
                                <h2 class="title-contender">
                                    <?php echo get_the_title( $id_c_2 ); ?>
                                </h2>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php get_footer(); ?>