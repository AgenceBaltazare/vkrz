<?php

add_action('rest_api_init', function () {

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

  // Create contender
  register_rest_route('vkrz/v1', '/addcontender2/', array(
    'methods' => 'POST',
    'callback' => 'add_contender_from_api2',
  ));

  // Create Top
  register_rest_route('vkrz/v1', '/addtop/', array(
    'methods' => 'POST',
    'callback' => 'add_top_from_api',
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

  // Liste des TopList d'un Top
  register_rest_route('vkrz/v1', '/getalltoplistbyidvainkeur/(?P<id_vainkeur>\w+)/(?P<page>\w+)', array(
    'methods' => 'GET',
    'callback' => 'get_all_toplist_by_id_vainkeur',
    'args' => [
      'id_vainkeur',
      'page'
    ]
  ));

  // Liste des TopList d'un Top
  register_rest_route('vkrz/v1', '/getdodo/(?P<critere>\w+)/(?P<duree>\w+)', array(
    'methods' => 'GET',
    'callback' => 'get_the_dodo',
    'args' => [
      'critere',
      'duree'
    ]
  ));

  // Nombre de Shopper
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

});
