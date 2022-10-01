<?php
$type_top     = "";
global $id_top;
$get_top_type = get_the_terms(get_the_ID(), 'type');
if ($get_top_type) {
  foreach ($get_top_type as $type_top) {
    $type_top = $type_top->slug;
  }
}
switch (get_post_type()) {
  case "tournoi":
    $get_top_type = get_the_terms(get_the_ID(), 'type');
    $list_types   = array();
    if ($get_top_type) {
      foreach ($get_top_type as $type_top) {
        array_push($list_types, $type_top->slug);
      }
    }
    if (in_array("sponso", $list_types)) {
      get_template_part("templates/single/t-sponso");
    }  
    else {
      get_template_part("templates/single/t");
    }
    break;

  case "classement":
    global $id_top;
    $id_top       = get_field('id_tournoi_r', get_the_id());
    get_template_part("templates/single/r");
    break;

  case "post":
    get_template_part("templates/single/post");
    break;

  case "room":
    get_template_part("templates/single/room");
    break;
}
