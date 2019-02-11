<?php
function cpt_init() {
    // Battle
    register_post_type( 'battle',
        array(
            'labels' => array(
                'name' => 'Battles',
                'singular_name' => 'Battle'
            ),
            'public' => true,
            'supports' => array('title', 'editor', 'thumbnail', 'author', 'revisions'),
            'rewrite' => array( 'slug' => 'b' ),
            'menu_icon' => 'dashicons-star-filled',
            'has_archive' => true
        )
    );
    // Contender
    register_post_type( 'contender',
        array(
            'labels' => array(
                'name' => 'Contenders',
                'singular_name' => 'Contender'
            ),
            'public' => true,
            'supports' => array('title', 'editor', 'thumbnail', 'author', 'revisions'),
            'rewrite' => array( 'slug' => 'c' ),
            'menu_icon' => 'dashicons-admin-users',
            'has_archive' => true
        )
    );
    // Vote
    register_post_type( 'vote',
        array(
            'labels' => array(
                'name' => 'Votes',
                'singular_name' => 'Vote'
            ),
            'public' => true,
            'supports' => array('title', 'author'),
            'rewrite' => array( 'slug' => 'v' ),
            'menu_icon' => 'dashicons-heart',
            'has_archive' => true
        )
    );
}
add_action( 'init', 'cpt_init' );