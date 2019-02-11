<?php get_header(); ?>
<?php
$id_battle = get_the_ID();
$contenders = new WP_Query(array('post_type' => 'contender', 'posts_per_page' => '2', 'orderby' => 'rand', 'meta_query' => array(
    array(
        'key' => 'list_of_battles_id',
        'value' => $id_battle,
        'compare' => 'LIKE',
    )
)));
?>
<div class="main">
    <div class="container-fluid">
        <div class="row">
            <div class="col-1 header">
                <header>
                    <div class="bl">
                        <div class="logo">
                            <a href="<?php bloginfo('url'); ?>/">
                                <img src="<?php bloginfo('template_directory'); ?>/assets/img/logo-vainkeurz-min.png" alt="" class="img-fluid">
                            </a>
                        </div>
                    </div>
                </header>
            </div>
            <div class="col-10">
                <div class="row">
                    <div class="col-12">
                        <h1 class="title-battle">
                            <b>
                                <?php the_title(); ?>
                            </b>
                            <span>
                        <?php the_field('slug_battle'); ?>
                    </span>
                        </h1>
                    </div>
                </div>
                <div class="row">
                    <?php while ($contenders->have_posts()) : $contenders->the_post(); ?>
                        <div class="col-6 link-contender">
                            <a href="<?php the_permalink($id_battle); ?>" class="" rel="<?php get_the_ID(); ?>">
                                <?php if (has_post_thumbnail()) : ?>
                                    <?php the_post_thumbnail('full', array('class'=>'rounded img-fluid')); ?>
                                <?php endif; ?>
                                <h2 class="title-contender">
                                    <?php the_title(); ?>
                                </h2>
                            </a>
                        </div>
                    <?php endwhile; ?>
                </div>
            </div>
            <div class="col-1">
                1200 votes
            </div>
        </div>
    </div>
</div>

<?php get_footer(); ?>
