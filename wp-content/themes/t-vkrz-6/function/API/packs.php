<?php

function get_user_infos_from_api($data)
{

  $uuid_vainkeur = $data['uuiduser'];
  return get_user_infos($uuid_vainkeur, "complete");
}

function get_contender($data)
{
  $id_contender = $data['id_contender'];

  $the_query = new WP_Query(array(
    'p'         => $id_contender,
    'post_type' => 'contender'
  ));

  if ($the_query->have_posts()) {
    while ($the_query->have_posts()) : $the_query->the_post();
      return array(
        'Title'     => get_the_title(),
        'Thumbnail' => get_the_post_thumbnail_url()
      );
    endwhile;
  } else {
    echo 'No posts found.';
  }
  wp_reset_postdata();
}

function get_single_ranking($data)
{

  $list_ranking      = "";
  $id_ranking        = $data['id_ranking'];
  $user_ranking      = get_user_ranking($id_ranking);
  $total_rank        = array();

  $i = 1;
  foreach ($user_ranking as $c) :

    $list_ranking .= get_the_title($c) . " ";

    $i++;
  endforeach;

  array_push($total_rank, array(
    "classement" => $list_ranking,
  ));

  return $list_ranking;
}

function get_top_info($data)
{
  $id_top        = $data['id_top'];
  $top_datas     = get_top_infos($id_top);
  return $top_datas;
}

function add_contender_from_api()
{

  $id_visual   = $_GET['idphoto'];
  $url_visual  = $_GET['url_visual'];
  $pseudo      = $_GET['pseudo'];
  $id_top      = $_GET['id_top'];

  if ($id_visual) {

    $new_contender = array(
      'post_type'   => 'contender',
      'post_title'  => $pseudo,
      'post_status' => 'publish',
    );
    $id_new_contender  = wp_insert_post($new_contender);

    update_field('visuel_instagram_contender', $url_visual, $id_new_contender);
    update_field('id_tournoi_c', $id_top, $id_new_contender);
    update_field('ELO_c', '1200', $id_new_contender);

    if ($id_new_contender) {
      return "Nouveau contender dans le Top " . get_the_title($id_top);
    }
  }
}

function get_stats($data)
{
  $date = $data['date'];

  // TODAY'S DATE
  $today = date('d-m-Y');
  $todayFormatted = strtotime($today);
  global $whereTo, $quand;

  switch ($date) {
    case 'journalier':
      $whereTo = date("d-m-Y", strtotime("-1 day", $todayFormatted));
      $quand = 'Hier';
      break;
    case 'hebdo':
      $whereTo = date("d-m-Y", strtotime("-1 week", $todayFormatted));
      $quand = 'Une semaine avant';
      break;
    case 'mensu':
      $whereTo = date("d-m-Y", strtotime("-1 month", $todayFormatted));
      $quand = 'Un mois avant';
      break;
  }

  // COMPTE ENREGISTRE
  $args = array(
    'date_query' => array(
      array(
        'after'     => "$whereTo",
        'before'    => "$today",
        'inclusive' => true
      )
    )
  );
  $user_query = new WP_User_Query($args);
  $comptes = $user_query->get_total();

  // CLASSEMENT PUBLIE
  $args2 = array(
    'post_type' => 'classement',
    'date_query' => array(
      array(
        'after'     => "$whereTo",
        'before'    => "$today",
        'inclusive' => true
      )
    )
  );
  $query2 = new WP_Query($args2);
  $classements = $query2->found_posts;

  // CLASSEMENT NB VOTES
  $nb_classement_votes = 0;
  while ($query2->have_posts()) : $query2->the_post();
    $nb_classement_votes =  $nb_classement_votes + get_field('nb_votes_r');
  endwhile;

  // PLAYER PUBLIE
  $args3 = array(
    'post_type' => 'player',
    'date_query' => array(
      array(
        'after'     => "$whereTo",
        'before'    => "$today",
        'inclusive' => true
      )
    )
  );
  $query3 = new WP_Query($args3);
  $players = $query3->found_posts;

  // TOPS CREES
  $args4 = array(
    'post_type' => 'tournoi',
    'date_query' => array(
      array(
        'after'     => "$whereTo",
        'before'    => "$today",
        'inclusive' => true
      )
    ),
    'tax_query' => array(
      array(
        'taxonomy' => 'type',
        'field'    => 'slug',
        'terms'    => array('private', 'whitelabel', 'onboarding'),
        'operator' => 'NOT IN'
      ),
    ),
  );
  $query4 = new WP_Query($args4);
  $newTops = $query4->found_posts;

  $administrators = new WP_User_Query(
    array(
        "fields" => "ID",
        "number" => -1,
        "role__in" => array("administrator"),
    ),
  );
  $administrators = $administrators->get_results();

  // TOPS CREES BY SIMPLE USERS (NO ADMINS)
  $args5 = array(
    'post_type' => 'tournoi',
    "author__not_in"         => $administrators, // TO EXCLUDE ADMINS
    'tax_query' => array(
      array(
        'taxonomy' => 'type',
        'field'    => 'slug',
        'terms'    => array('private', 'whitelabel', 'onboarding'),
        'operator' => 'NOT IN',
      )
    ),
  );
  $query5 = new WP_Query($args5);
  $TopsBySimpleUsers = $query5->found_posts;

  // TOTAL NUMBER TOPS
  $args6 = array(
    'post_type' => 'tournoi',
    'tax_query' => array(
      array(
        'taxonomy' => 'type',
        'field'    => 'slug',
        'terms'    => array('private', 'whitelabel', 'onboarding'),
        'operator' => 'NOT IN',
      )
    ),
  );
  $query6 = new WP_Query($args6);
  $numberTotalTops = $query6->found_posts;

  // BEST CREATOR… (GUILLAUME PART)

  // DODO…
  $dodo = get_user_infos(get_field('uuid_dodo', 'options'));

  // NOMBRE CREATEURS…
  $nb_creators = new WP_User_Query(array('role' => 'Author'));
  $nb_creators = (int) $nb_creators->get_total();

  // TOPLIST BY LAMA2LOMBRE
  $rankings = new WP_Query(array(
    "post_type"              => "classement",
    "post_status"            => "publish",
    "update_post_meta_cache" => false,
    "no_found_rows"          => false,
    'date_query' => array(
      array(
        'after'     => "$whereTo",
        'before'    => "$today",
        'inclusive' => true
      )
    ),
  ));
  $rankingsPosts = $rankings->posts;
  $rankingsLama = 0;

  $toplistsLamaArr = array();
  foreach($rankingsPosts as $post) {
    $postSolo = (array) $post;
    $post_id = $postSolo["ID"];

    $original_post_author_uuid = get_field('uuid_user_r', (int) $post_id);
    $wp_post_author_uuid = get_field('uuiduser_user', 'user_' . $postSolo["post_author"]);

    if($original_post_author_uuid !== $wp_post_author_uuid) {
      array_push($toplistsLamaArr, $original_post_author_uuid);
    }
  }
  $toplistsLamaArr = array_unique($toplistsLamaArr);
  $toplistsLamaArr = count($toplistsLamaArr);

  $results = array(
    "Aujourd'hui"             => date("d-m-Y", strtotime($today)),
    "$quand"                  => date("d-m-Y", strtotime($whereTo)),
    "Compte enregistre"       => $comptes,
    "Classement publie"       => $classements,
    "Player publie"           => $players,
    "Classement NB votes"     => $nb_classement_votes,
    "Tops crees"              => $newTops,
    "Dodo"                    => $dodo["pseudo"],
    "Dodo Image"              => $dodo["avatar"],
    "NB Creators"             => $nb_creators,
    "TopList Lama2Lombre"     => $toplistsLamaArr,
    "Total Nombre Tops"       => $numberTotalTops,
    "NB Tops createur "       => $TopsBySimpleUsers,
  );

  return $results;
}

function get_numberpage($data)
{

  $id_top               = $data['id_top'];
  $nb_items             = 100;

  $rankings = new WP_Query(array(
    'ignore_sticky_posts'      => true,
    'update_post_meta_cache'  => false,
    'post_type'                => 'classement',
    "author__not_in"          => array(0, 1),
    'meta_query' => array(
      'relation' => 'AND',
      array(
        'key'     => 'id_tournoi_r',
        'value'   => $id_top,
        'compare' => '=',
      ),
      array(
        'key'     => 'done_r',
        'value'   => 'done',
        'compare' => '=',
      )
    )
  ));

  $total_items  = $rankings->found_posts;

  return array(
    'total_items' => $total_items,
    'nb_pages'    => ceil($total_items / $nb_items),
  );
}

function get_all_toplist_by_id_top($data)
{

  $results              = array();
  $id_top               = $data['id_top'];
  $page                 = $data['page'];
  $nb_items             = 100;

  $rankings = new WP_Query(array(
    'ignore_sticky_posts'      => true,
    'update_post_meta_cache'  => false,
    'post_type'                => 'classement',
    'orderby'                  => 'date',
    'order'                    => 'DESC',
    'posts_per_page'          => $nb_items,
    'paged'                   => $page,
    "author__not_in"          => array(0, 1),
    'meta_query' => array(
      'relation' => 'AND',
      array(
        'key'     => 'id_tournoi_r',
        'value'   => $id_top,
        'compare' => '=',
      ),
      array(
        'key'     => 'done_r',
        'value'   => 'done',
        'compare' => '=',
      )
    )
  ));
  while ($rankings->have_posts()) : $rankings->the_post();

    $id_ranking              = get_the_ID();
    $uuiduser                = get_field('uuid_user_r', $id_ranking);
    $vainkeur_infos          = get_user_infos($uuiduser);

    $user_top3    = get_user_ranking($id_ranking, 3);
    $list_podium  = array();

    foreach ($user_top3 as $contender) {
      $list_podium[] = array(
        'id_contender'      => $contender,
        'nom_contender'     => get_the_title($contender),
        'visuel_contender'  => get_the_post_thumbnail_url($contender, 'thumbnail'),
      );
    }
    $results[] = array(
      'vainkeur'      => $vainkeur_infos,
      'podium'        => $list_podium,
      'toplist_url'   => get_the_permalink($id_ranking),
    );

  endwhile;

  return $results;
}

function get_numberpage_vainkeur($data)
{

  $id_vainkeur          = $data['id_vainkeur'];
  $nb_items             = 25;
  $vainkeur_toplist     = get_user_toplist($id_vainkeur);
  $total_items          = count($vainkeur_toplist);

  return array(
    'total_items' => $total_items,
    'nb_pages'    => ceil($total_items / $nb_items),
  );
}

function get_all_toplist_by_id_vainkeur($data)
{

  $results              = array();
  $id_vainkeur          = $data['id_vainkeur'];
  $page                 = $data['page'];
  $vainkeur_toplist     = get_user_toplist($id_vainkeur);

  $nb_items             = 25;
  $val_min              = $nb_items * $page - $nb_items;
  $val_max              = $nb_items * $page;

  if ($vainkeur_toplist) {

    foreach (array_slice($vainkeur_toplist, $val_min, $val_max) as $toplist) {

      $id_top         = $toplist['id_top'];
      $id_ranking     = $toplist['id_ranking'];
      $typetop        = $toplist['typetop'];
      $state          = $toplist['state'];
      $list_type    = array();

      $get_top_type = get_the_terms($id_top, 'type');
      if ($get_top_type) {
        foreach ($get_top_type as $type_top) {
          array_push($list_type, $type_top->slug);
        }
      }
      if (!in_array('private', $list_type) && !in_array('onboarding', $list_type) && get_post_status($id_top)) {

        $thumbnail    = get_the_post_thumbnail_url($id_top, 'thumbnail');
        $top_link     = get_the_permalink($id_top);
        $toplist_link = get_the_permalink($id_ranking);
        $elo_link     = get_the_permalink(get_page_by_path('elo')) . "?id_top=" . $id_top;
        $top_question = get_field('question_t', $id_top);

        $nb_votes     = intval(get_field('nb_votes_r', $id_ranking));

        if ($id_ranking) {
          $top_type       = get_field('type_top_r', $id_ranking);
          if ($top_type == "top3") {
            $top_number = 3;
          } else {
            $top_number = get_field('count_contenders_t', $id_top);
          }
        } else {
          $top_number = get_field('count_contenders_t', $id_top);
        }

        $list_cat   = get_the_terms($id_top, 'categorie');
        $cat_id     = false;
        if ($list_cat) {
          foreach ($list_cat as $cat) {
            $cat_id = $cat->term_id;
          }
        }
        if ($cat_id) {
          $cat_icon = get_field('icone_cat', 'term_' . $cat_id);
        } else {
          $cat_icon = "<span class='va va-crossed-swords va-lg'></span>";
        }
        $top_title    = "TOP " . $top_number . " " . $cat_icon . " " . get_the_title($id_top);

        $user_top3    = get_user_ranking($id_ranking, 3);
        $list_podium  = array();
        foreach ($user_top3 as $contender) {
          $list_podium[] = array(
            'id_contender'      => $contender,
            'nom_contender'     => get_the_title($contender),
            'visuel_contender'  => get_the_post_thumbnail_url($contender, 'thumbnail'),
          );
        };

        $results[] = array(
          "id_top"            => $id_top,
          "top_title"         => $top_title,
          "typetop"           => $typetop,
          "thumbnail"         => $thumbnail,
          "top_link"          => $top_link,
          "toplist_link"      => $toplist_link,
          "top_question"      => $top_question,
          "nb_votes"          => $nb_votes,
          "elo_link"          => $elo_link,
          "podium"            => $list_podium,
          "state"             => $state
        );
      }
    }
  }

  return $results;
}

function get_the_dodo($data)
{

  $type      = $data['critere'];
  $period    = $data['duree'];
  $limit     = 1;
  $return    = array();


  $tops = new WP_Query(array(
    "post_type"              => "classement",
    "posts_per_page"         => -1,
    "fields"                 => "ids",
    "post_status"            => "publish",
    "update_post_meta_cache" => false,
    "no_found_rows"          => false,
    "author__not_in"         => array(0, 1, 18, 58), // To exclude vainkeur not registered (with no author)
    "date_query"             => array(
      array(
        "after" => $period . " days ago"
      )
    )
  ));

  if ($tops->have_posts()) {

    foreach ($tops->posts as $top_id) {

      $author_id = get_post_field("post_author", $top_id);

      $key = array_search($author_id, array_column($return, 'author_id'));

      if ($key !== false || $key === 0) {
        $return[$key]["total_vote"] = $return[$key]["total_vote"] + intval(get_field("nb_votes_r", $top_id));
        get_field("done_r", $top_id) == "done" ? $return[$key]["total_top"]++ : $return[$key]["total_top"];
      } 
      else {
        $vainkeur = new WP_Query(array(
          "post_type"              => "vainkeur",
          "posts_per_page"         => "1",
          "fields"                 => "ids",
          "post_status"            => "publish",
          "ignore_sticky_posts"    => true,
          "update_post_meta_cache" => false,
          "no_found_rows"          => false,
          "author"                 => $author_id,
        ));

        if ($vainkeur->have_posts()) {
          $vainkeur_id = $vainkeur->posts[0];

          $return[] = array(
            "vainkeur_id"   => $vainkeur_id,
            "author_id"     => $author_id,
            "uuid"          => get_field("uuid_user_r", $top_id)
          );
        }
      }
    }
  }

  if ($type == "money") {
    usort($return, function ($a, $b) {
      return $b["money"] <=> $a["money"];
    });
  }

  if ($type == "top") {
    usort($return, function ($a, $b) {
      return $b["total_top"] <=> $a["total_top"];
    });
  }

  if ($type == "vote") {
    usort($return, function ($a, $b) {
      return $b["total_vote"] <=> $a["total_vote"];
    });
  }

  $user_info       = get_userdata($author_id);
  $user_pseudo     = $user_info->user_nicename;
  $dodo            = array_slice($return, 0, $limit);

  if (get_field('id_vainkeur_dodo', 'options') != $dodo[0]['vainkeur_id']) {
    update_field('id_vainkeur_dodo', $dodo[0]['vainkeur_id'], 'options');
    update_field('uuid_dodo', $dodo[0]['uuid'], 'options');
    update_field('pseudo_dodo', $user_pseudo, 'options');
    update_field('date_dodo', date('d-m-Y H:i:s'), 'options');
    update_field('nb_votes_dodo', $dodo[0]['total_vote'], 'options');
    update_field('nb_tops_dodo', $dodo[0]['total_top'], 'options');

    if ($dodo[0]['vainkeur_id']) {
      if (!get_vainkeur_badge($dodo[0]['vainkeur_id'], "Dodo")) {
        update_vainkeur_badge($dodo[0]['vainkeur_id'], "Dodo");
      }
    }
  }
  else{
    update_field('nb_votes_dodo', $dodo[0]['total_vote'], 'options');
    update_field('nb_tops_dodo', $dodo[0]['total_top'], 'options');
  }
}


function get_shopper($data)
{

  $keurz     = intval($data['keurz']);
  $shopper   = new WP_Query(array(
    "post_type"              => "vainkeur",
    "posts_per_page"         => -1,
    "fields"                 => "ids",
    "post_status"            => "publish",
    "update_post_meta_cache" => false,
    "no_found_rows"          => false,
    'meta_query' => array(
      array(
        'key'     => 'money_disponible_vkrz',
        'value'   => $keurz,
        'compare' => '>=',
        'type'    => 'NUMERIC'
      ),
    ),
  ));

  return $shopper->post_count;

}