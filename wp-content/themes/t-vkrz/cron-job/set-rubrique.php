<?php
include __DIR__ . '/../../../../wp-load.php';

$tops = new WP_Query(array(
  'post_type'              => 'tournoi',
  'posts_per_page'         => -1,
  'fields'                 => 'ids',
  'post_status'            => 'publish',
  'ignore_sticky_posts'    => true,
  'update_post_meta_cache' => false,
  'no_found_rows'          => false,
));
if ($tops->have_posts()) {
  
  foreach ($tops->posts as $id_top) {

    $top_title     = get_the_title($id_top);

    wp_set_object_terms($id_top, $top_title, 'rubrique');

  }
}
