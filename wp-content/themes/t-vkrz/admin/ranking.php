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
        'orderby'        => 'meta_value_num',
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
    <!--<meta http-equiv="refresh" content="1;url=<?php the_permalink(); ?>" />-->
</head>
<body>
<ul>
<?php $i=0; while ($ranking->have_posts()) : $ranking->the_post(); ?>
    <li>
        <?php echo $i; ?> -- <?php the_title(); ?> <b><?php the_ID(); ?></b> - <?php the_field('ELO_c'); ?> - (<?php the_field('difference_c'); ?>)
    </li>
<?php $i++; endwhile; ?>
</ul>
</body>
</html>

