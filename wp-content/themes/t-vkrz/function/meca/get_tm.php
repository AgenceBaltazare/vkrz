<?php
function get_toplist_mondiale($id_top){

  $toplismondiale = new WP_Query(array(
    'ignore_sticky_posts'	      => true,
    'update_post_meta_cache'    => false,
    'fields'                    => 'ids',
    'post_status'               => 'publish',
    'no_found_rows'		          => true,
    'post_type'			            => 'toplist-mondiale',
    'posts_per_page'		        => 1,
    'meta_query' => array(
      array(
        'key'     => 'id_du_top_tm',
        'value'   => $id_top,
        'compare' => '=',
    ),
  ),
  ));
  
  foreach ($toplismondiale->posts as $id_toplismondiale){

      return $id_toplismondiale;

  }

}