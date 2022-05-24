<?php
add_action('rest_api_init', function () {

  // Info Top
  register_rest_route('vkrz/top', '/infos/(?P<id_top>[\d]+)', array(
    'methods' => 'GET',
    'callback' => 'get_top_infos',
    'args' => [
      'id_top'
    ]
  ));
});
