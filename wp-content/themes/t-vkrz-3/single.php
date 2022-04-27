<?php
$type_top     = "";
switch (get_post_type()) {
  case "tournoi":
    $get_top_type = get_the_terms(get_the_ID(), 'type');
    if ($get_top_type) {
      foreach ($get_top_type as $type_top) {
        $type_top = $type_top->slug;
      }
    }
    if ($type_top == "onboarding") {
      get_template_part("templates/single/t-welcome");
    } elseif ($type_top == "whitelabel") {
      get_template_part("templates/single/t-marqueblanche");
    } elseif ($type_top == "sponso") {
      get_template_part("templates/single/t-sponso");
    } elseif ($type_top == "participatif") {
      get_template_part("templates/single/t-participatif");
    } elseif ($type_top == "private") {
      get_template_part("templates/single/t-private");
    } else {
      get_template_part("templates/single/t");
    }
    break;

  case "classement":
    global $id_top;
    $id_top       = get_field('id_tournoi_r', get_the_id());
    $get_top_type = get_the_terms($id_top, 'type');
    if ($get_top_type) {
      foreach ($get_top_type as $type_top) {
        $type_top = $type_top->slug;
      }
    }
    if ($type_top == "whitelabel") {
      get_template_part("templates/single/r-marqueblanche");
    } elseif ($type_top == "sponso") {
      get_template_part("templates/single/r-sponso");
    } else {
      get_template_part("templates/single/r");
    }

    break;

  case "post":
    get_template_part("templates/single/post");
    break;
}
