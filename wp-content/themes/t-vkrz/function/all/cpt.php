<?php
function cpt_init() {

    // Tournoi
    $labels = array(
        'name' => 'Tournoi',
        'singular_name' => 'Tournoi',
        'add_new' => 'Ajouter un tournoi',
        'add_new_item' => 'Ajouter un tournoi',
        'edit_item' => 'Editer un tournoi',
        'new_item' => 'Nouveau tournoi',
        'all_items' => 'Tous les tournois',
        'view_item' => 'Voir tournoi',
        'search_items' => 'Chercher un tournoi',
        'not_found' =>  'Aucun tournoi trouvé',
        'not_found_in_trash' => 'Aucun tournoi trouvé dans la corbeille',
        'menu_name' => 'Tournois'
    );
    $args = array(
        'labels' => $labels,
        'public' => true,
        'publicly_queryable' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'query_var' => true,
        'rewrite' => array('slug' => 't'),
        'capability_type' => 'post',
        'has_archive' => true,
        'hierarchical' => false,
        'menu_position' => null,
        'menu_icon' => 'dashicons-editor-code',
        'show_in_rest' => true,
        'supports' => array('title', 'editor', 'thumbnail', 'author')
    );
    register_post_type('tournoi', $args);

    // Classement
    $labels = array(
        'name' => 'Classement',
        'singular_name' => 'Classement',
        'add_new' => 'Ajouter un classement',
        'add_new_item' => 'Ajouter un classement',
        'edit_item' => 'Editer un classement',
        'new_item' => 'Nouveau classement',
        'all_items' => 'Tous les classements',
        'view_item' => 'Voir classement',
        'search_items' => 'Chercher un classement',
        'not_found' =>  'Aucun classement trouvé',
        'not_found_in_trash' => 'Aucun classement trouvé dans la corbeille',
        'menu_name' => 'Classements'
    );
    $args = array(
        'labels' => $labels,
        'public' => true,
        'publicly_queryable' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'query_var' => true,
        'rewrite' => array('slug' => 'r'),
        'capability_type' => 'post',
        'has_archive' => true,
        'hierarchical' => false,
        'menu_position' => null,
        'menu_icon' => 'dashicons-editor-code',
        'show_in_rest' => true,
        'supports' => array('title')
    );
    register_post_type('classement', $args);

    // Contenders
    $labels = array(
        'name' => 'Contender',
        'singular_name' => 'Contender',
        'add_new' => 'Ajouter un contender',
        'add_new_item' => 'Ajouter un contender',
        'edit_item' => 'Editer un contender',
        'new_item' => 'Nouveau contender',
        'all_items' => 'Tous les contenders',
        'view_item' => 'Voir contender',
        'search_items' => 'Chercher un contender',
        'not_found' =>  'Aucun contender trouvé',
        'not_found_in_trash' => 'Aucun contender trouvé dans la corbeille',
        'menu_name' => 'Contenders'
    );
    $args = array(
        'labels' => $labels,
        'public' => true,
        'publicly_queryable' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'query_var' => true,
        'rewrite' => array('slug' => 'c'),
        'capability_type' => 'post',
        'has_archive' => true,
        'hierarchical' => false,
        'menu_position' => null,
        'menu_icon' => 'dashicons-universal-access',
        'show_in_rest' => true,
        'supports' => array('title', 'editor', 'thumbnail', 'author')
    );
    register_post_type('contender', $args);

    // Votes
    $labels = array(
        'name' => 'Votes',
        'singular_name' => 'Vote',
        'add_new' => 'Ajouter un vote',
        'add_new_item' => 'Ajouter un vote',
        'edit_item' => 'Editer un vote',
        'new_item' => 'Nouveau vote',
        'all_items' => 'Tous les votes',
        'view_item' => 'Voir vote',
        'search_items' => 'Chercher un vote',
        'not_found' =>  'Aucun vote trouvé',
        'not_found_in_trash' => 'Aucun vote trouvé dans la corbeille',
        'menu_name' => 'Votes'
    );
    $args = array(
        'labels' => $labels,
        'public' => true,
        'publicly_queryable' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'query_var' => true,
        'rewrite' => array('slug' => 'v'),
        'capability_type' => 'post',
        'has_archive' => true,
        'hierarchical' => false,
        'menu_position' => null,
        'menu_icon' => 'dashicons-heart',
        'show_in_rest' => true,
        'supports' => array('title', 'author')
    );
    register_post_type('vote', $args);

}
add_action( 'init', 'cpt_init' );



