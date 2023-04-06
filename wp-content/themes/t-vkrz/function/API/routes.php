<?php

add_action('rest_api_init', function () {

  // // // // // // // // // // //

  // All flammes
  register_rest_route('vkrz/v1', '/allflammes/', array(
    'methods' => 'GET',
    'callback' => 'get_allflammes'
  ));

  // Init classement 
  register_rest_route('vkrz/v1', '/initclassement/(?P<id_top>\w+)/(?P<iduser>\w+)/(?P<uuiduser>\w+)/(?P<id_vainkeur>\w+)/(?P<typetop>\w+)', array(
    'methods' => 'GET',
    'callback' => 'init_new_classement',
    'args' => [
      'id_top',
      'iduser',
      'uuiduser',
      'id_vainkeur',
      'typetop',
    ]
  ));
  
  // GET classement 
  register_rest_route('vkrz/v1', '/getranking/(?P<id_ranking>\w+)', array(
    'methods' => 'GET',
    'callback' => 'get_ranking_json',
    'args' => [
      'id_ranking'
    ]
  ));

  // // // // // // // // // // //

  // GET STATS
  register_rest_route('vkrz/v1', '/stats/(?P<date>\w+)', array(
    'methods' => 'GET',
    'callback' => 'get_stats',
    'args' => [
      'date'
    ]
  ));

  // List of contenders into a ranking
  register_rest_route('vkrz/v1', '/ranking/(?P<id_ranking>[\d]+)', array(
    'methods' => 'GET',
    'callback' => 'get_single_ranking',
    'args' => [
      'id_ranking'
    ]
  ));

  // Create contender
  register_rest_route('vkrz/v1', '/addcontender/', array(
    'methods' => 'GET',
    'callback' => 'add_contender_from_api',
  ));

  // Info Top
  register_rest_route('vkrz/v1', '/infotop/(?P<id_top>[\d]+)', array(
    'methods' => 'GET',
    'callback' => 'get_top_info',
    'args' => [
      'id_top'
    ]
  ));

  // Info Top
  register_rest_route('vkrz/v1', '/getuserinfo/(?P<uuiduser>\w+)', array(
    'methods' => 'GET',
    'callback' => 'get_user_infos_from_api',
    'args' => [
      'uuiduser'
    ]
  ));

  // Info Contender
  register_rest_route('vkrz/v1', '/getcontenderinfo/(?P<id_contender>\w+)', array(
    'methods' => 'GET',
    'callback' => 'get_contender',
    'args' => [
      'id_contender'
    ]
  ));

  // Get number page for a Top
  register_rest_route('vkrz/v1', '/getalltoplistnumberpage/(?P<id_top>\w+)', array(
    'methods' => 'GET',
    'callback' => 'get_numberpage',
    'args' => [
      'id_top'
    ]
  ));

  // Get number page for a vainkeur
  register_rest_route('vkrz/v1', '/get_numberpage_vainkeur/(?P<id_vainkeur>\w+)', array(
    'methods' => 'GET',
    'callback' => 'get_numberpage_vainkeur',
    'args' => [
      'id_vainkeur'
    ]
  ));

  // Liste des TopList d'un Top
  register_rest_route('vkrz/v1', '/getalltoplistbyidtop/(?P<id_top>\w+)/(?P<page>\w+)', array(
    'methods' => 'GET',
    'callback' => 'get_all_toplist_by_id_top',
    'args' => [
      'id_top',
      'page'
    ]
  ));

  // Liste des TopList d'un VAINKEURZ
  register_rest_route('vkrz/v1', '/getalltoplistbyidvainkeur/(?P<id_vainkeur>\w+)/(?P<page>\w+)', array(
    'methods' => 'GET',
    'callback' => 'get_all_toplist_by_id_vainkeur',
    'args' => [
      'id_vainkeur',
      'page'
    ]
  ));

  // Détection du dodo
  register_rest_route('vkrz/v1', '/getdodo/(?P<critere>\w+)/(?P<duree>\w+)', array(
    'methods' => 'GET',
    'callback' => 'get_the_dodo',
    'args' => [
      'critere',
      'duree'
    ]
  ));

  // Nombre de Shopper potentiel
  register_rest_route('vkrz/v1', '/getshopper/(?P<keurz>\w+)', array(
    'methods' => 'GET',
    'callback' => 'get_shopper',
    'args' => [
      'keurz'
    ]
  ));

  // Twitter Monitor - Get top tendance
  register_rest_route('vkrz/v1', '/getstops/(?P<tendance>[a-zA-Z0-9-]+)', array(
    'methods' => 'GET',
    'callback' => 'get_tops_tendance',
    'args' => [
      'tendance'
    ]
  ));
  
  // ALL VKRZ content
  register_rest_route('vkrz/v1', '/getcontent/', array(
    'methods' => 'GET',
    'callback' => 'get_all_content'
  ));
  
  // Result for searchbar
  register_rest_route('vkrz/v1', '/searchbar/(?P<recherche>[a-zA-Z0-9-]+)', array(
    'methods' => 'GET',
    'callback' => 'get_all_tops_ids_for_search',
    'args' => [
      'recherche'
    ]
  ));
  
  // Result for members
  register_rest_route('vkrz/v1', '/get_member_search/(?P<recherche>[a-zA-Z0-9-]+)', array(
    'methods' => 'GET',
    'callback' => 'get_all_members_ids_for_search',
    'args' => [
      'recherche'
    ]
  ));
  
  // List of all members
  register_rest_route('vkrz/v1', '/get_all_users/', array(
    'methods' => 'GET',
    'callback' => 'get_all_users'
  ));

});
