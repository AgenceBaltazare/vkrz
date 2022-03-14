<?php


add_action('rest_api_init', function(){

    // List of contenders into a ranking
    register_rest_route( 'vkrz/v1', '/ranking/(?P<id_ranking>[\d]+)', array(
        'methods' => 'GET',
        'callback' => 'get_single_ranking',
        'args' => [
            'id_ranking'
        ]
    ));

    // Create contender
    register_rest_route('vkrz/v1', '/addcontender/', array(
        'methods' => 'POST',
        'callback' => 'add_contender_from_api',
    ));
});

