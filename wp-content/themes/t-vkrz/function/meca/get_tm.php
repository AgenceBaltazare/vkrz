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

function get_liste_toplist($id_top)
{

  $liste_toplist = new WP_Query(array(
    'ignore_sticky_posts'        => true,
    'update_post_meta_cache'    => false,
    'fields'                    => 'ids',
    'post_status'               => 'publish',
    'no_found_rows'              => true,
    'post_type'                  => 'liste-toplist',
    'posts_per_page'            => 1,
    'meta_query' => array(
      array(
        'key'     => 'id_du_top_tl',
        'value'   => $id_top,
        'compare' => '=',
      ),
    ),
  ));

  foreach ($liste_toplist->posts as $id_liste_toplist) {

    return $id_liste_toplist;
  }
}