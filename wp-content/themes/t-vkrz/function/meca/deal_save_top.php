<?php 

function deal_save_top($id_top, $id_vainkeur) {
  $id_top     = intval($id_top);
  $saved_tops = array();

  if (get_field('saved_tops', $id_vainkeur)) {
    $saved_tops = json_decode(get_field('saved_tops', $id_vainkeur));
  }
  
  if (!in_array($id_top, $saved_tops)) {
    array_push($saved_tops, $id_top);
    update_field('saved_tops', json_encode($saved_tops), $id_vainkeur);
  } else {
    $saved_tops = array_diff($saved_tops, array($id_top));
    $saved_tops = '[' . implode(',', $saved_tops) . "]";
    update_field('saved_tops', $saved_tops, $id_vainkeur);
  }
}