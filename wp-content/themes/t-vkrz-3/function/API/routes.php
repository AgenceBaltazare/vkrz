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
});
