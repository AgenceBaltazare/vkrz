<?php
/*
    Template Name: Delete
*/
?>
<?php
$ID_to_delete       = $_GET['delete'];
$ID_to_classement   = $_GET['allrank'];

if(isset($ID_to_delete)){

    wp_delete_post($ID_to_delete, true);

}
elseif(isset($ID_to_classement)){

    $all_classement = new WP_Query(array('post_type' => 'classement', 'orderby' => 'date', 'posts_per_page' => '-1'));
    while ($all_classement->have_posts()) : $all_classement->the_post();

        wp_delete_post(get_the_ID(), true);

    endwhile;

    $all_votes = new WP_Query(array('post_type' => 'vote', 'orderby' => 'date', 'posts_per_page' => '-1'));
    while ($all_votes->have_posts()) : $all_votes->the_post();

        wp_delete_post(get_the_ID(), true);

    endwhile;

}

?>
