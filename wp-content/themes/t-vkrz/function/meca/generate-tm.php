<?php
function generate_toplist_mondiale($id_top){
  $top_infos     = get_top_infos($id_top);
  $top_title     = "Top " . $top_infos['top_title'] . " " . $top_infos['top_question'];

  $new_tm_entry = array(
    'post_type'   => 'toplist-mondiale',
    'post_title'  => $top_title,
    'post_status' => 'publish',
  );

  if ($id_top) {
    $id_tm  = wp_insert_post($new_tm_entry);
    update_field('id_du_top_tm', $id_top, $id_tm);
  }
}

function generate_liste_toplist($id_top)
{
  $top_infos     = get_top_infos($id_top);
  $top_title     = "Top " . $top_infos['top_title'] . " " . $top_infos['top_question'];

  $new_tl_entry = array(
    'post_type'   => 'liste-toplist',
    'post_title'  => $top_title,
    'post_status' => 'publish',
  );

  if ($id_top) {
    $id_tl  = wp_insert_post($new_tl_entry);
    update_field('id_du_top_tm', $id_top, $id_tl);
  }
}