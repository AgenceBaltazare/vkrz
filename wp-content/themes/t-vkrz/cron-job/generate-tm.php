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

  $i = 1;
  $r = 1;
  foreach ($tops->posts as $id_top) {

    $top_infos     = get_top_infos($id_top);
    $top_title     = "Top " . $top_infos['top_title']. " " . $top_infos['top_question'];

    $new_tm_entry = array(
      'post_type'   => 'toplist-mondiale',
      'post_title'  => $top_title,
      'post_status' => 'publish',
    );
    $new_tl_entry = array(
      'post_type'   => 'liste-toplist',
      'post_title'  => $top_title,
      'post_status' => 'publish',
    );

    if ($id_top) {

      $id_tm  = wp_insert_post($new_tm_entry);
      $id_tl  = wp_insert_post($new_tl_entry);

      update_field('id_du_top_tm', $id_top, $id_tm);
      update_field('id_du_top_tl', $id_top, $id_tl);

    }

  }
}
