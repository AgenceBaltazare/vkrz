<?php
/*
    Template Name: Ranking
*/
$id_tournoi = $_GET['tournoi_id'];
$ranking = new WP_Query(
    array(
        'post_type'      => 'contender',
        'posts_per_page' => -1,
        'meta_key'       => 'ELO_c',
        'orderby'        => 'meta_value',
        'order'          => 'DESC',
        'meta_query'     => array(
            array(
                'key'     => 'id_tournoi_c',
                'value'   => $id_tournoi,
                'compare' => 'LIKE',
            )
        )
    )
);
?>
<html>
<head>
    <meta http-equiv="refresh" content="1;url=<?php the_permalink(); ?>" />
</head>
<body>
<ol>
<?php while ($ranking->have_posts()) : $ranking->the_post(); ?>
    <li>
        <?php the_title(); ?> - <?php the_field('ELO_c'); ?>
    </li>
<?php endwhile; ?>
</ol>
</body>
</html>

