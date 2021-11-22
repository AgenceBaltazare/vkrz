<?php
/*
        Template Name: Provisoir player
    */
?>
<?php
$players = new WP_Query(array(
    'ignore_sticky_posts'    => true,
    'update_post_meta_cache' => false,
    'no_found_rows'          => true,
    'post_type'              => 'player',
    'orderby'                => 'date',
    'order'                  => 'DESC',
    'posts_per_page'         => -1
));
while ($players->have_posts()) : $players->the_post();

    $list_ranking = "";
    $id_ranking   = get_field('id_r_p');
    $user_ranking = get_user_ranking($id_ranking);

    foreach ($user_ranking as $c) :

        $list_ranking .= get_the_title($c) . " ";

    $i++;
    endforeach;

    update_field('classement_p', $list_ranking, get_the_ID());

endwhile; ?>