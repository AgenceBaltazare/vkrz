<?php get_header(); ?>
<?php
    $id_tournoi              = get_the_ID();
    $list_initial            = array();
    $round_inital            = new WP_Query(array('post_type' => 'contender', 'orderby' => 'rand', 'posts_per_page' => '2'));
    while ($round_inital->have_posts()) : $round_inital->the_post();

        array_push($list_initial, get_the_ID());

    endwhile; wp_reset_query();
?>
<body>
<div class="main">

    <div class="container">
        <div class="text-center">
            <h1><?php the_title(); ?> : <?php the_field('question_t', $id_tournoi); ?></h1>
        </div>
    </div>

    <div class="container mt-5">

        <div class="row">

            <?php foreach($list_initial as $c_ID) : ?>

                <div class="col-6 text-center">

                    <?php echo get_the_post_thumbnail($c_ID, 'large', array( 'class' => 'img-fluid')); ?>

                    <h4>
                        <?php echo get_the_title($c_ID); ?>
                    </h4>

                </div>

            <?php endforeach; ?>

        </div>

    </div>
    
</div>
<?php get_footer(); ?>
