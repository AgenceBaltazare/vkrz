<?php
/*
    Template Name: Log votes
*/
?>
<html>
<head>
    <meta http-equiv="refresh" content="1;url=<?php the_permalink(); ?>" />
</head>
<body>
    <?php
    if(isset($_GET['nb']) && $_GET['nb'] != ""){
        $nb = $_GET['nb'];
    }
    else{
        $nb = 50;
    }
    $all_votes = new WP_Query(array('post_type' => 'vote', 'order' => 'ASC', 'orderby' => 'date', 'posts_per_page' => $nb)); ?>
    <h3>
        <?php echo $all_votes->post_count; ?> votes
    </h3>
    <ul>
    <?php $i=1; while ($all_votes->have_posts()) : $all_votes->the_post(); ?>
        <?php
            $id_v = get_field('id_v_v');
            $id_l = get_field('id_l_v');
        ?>
        <li>
            <?php echo $i; ?> -- <b><?php echo get_the_title($id_v); ?></b> vs <b><?php echo get_the_title($id_l); ?></b>
        </li>
    <?php $i++; endwhile; ?>
    </ul>
</body>
</html>
