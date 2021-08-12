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
        'menu_icon' => 'dashicons-heart',
        'show_in_rest' => true,
        'supports' => array('title', 'author')
    );
    register_post_type('classement', $args);

    // Vainkeur
    $labels = array(
        'name' => 'Vainkeur',
        'singular_name' => 'Vainkeur',
        'add_new' => 'Ajouter un vainkeur',
        'add_new_item' => 'Ajouter un vainkeur',
        'edit_item' => 'Editer un vainkeur',
        'new_item' => 'Nouveau vainkeur',
        'all_items' => 'Tous les vainkeurs',
        'view_item' => 'Voir vainkeur',
        'search_items' => 'Chercher un vainkeur',
        'not_found' =>  'Aucun vainkeur trouvé',
        'not_found_in_trash' => 'Aucun vainkeur trouvé dans la corbeille',
        'menu_name' => 'Vainkeurs'
    );
    $args = array(
        'labels' => $labels,
        'public' => true,
        'publicly_queryable' => false,
        'show_ui' => true,
        'show_in_menu' => true,
        'query_var' => true,
        'rewrite' => array('slug' => 'vkrz'),
        'capability_type' => 'post',
        'has_archive' => true,
        'hierarchical' => false,
        'menu_position' => null,
        'menu_icon' => 'dashicons-admin-users',
        'show_in_rest' => true,
        'supports' => array('title', 'author')
    );
    register_post_type('vainkeur', $args);

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
        'publicly_queryable' => false,
        'show_ui' => true,
        'show_in_menu' => true,
        'query_var' => true,
        'rewrite' => array('slug' => 'c'),
        'capability_type' => 'post',
        'has_archive' => true,
        'hierarchical' => false,
        'menu_position' => null,
        'menu_icon' => 'dashicons-universal-access',
        'show_in_rest' => false,
        'supports' => array('title', 'thumbnail', 'author')
    );
    register_post_type('contender', $args);

    // Ratings
    $labels = array(
        'name' => 'Notes',
        'singular_name' => 'Note',
        'add_new' => 'Ajouter une note',
        'add_new_item' => 'Ajouter une note',
        'edit_item' => 'Editer une note',
        'new_item' => 'Nouvelle note',
        'all_items' => 'Toutes les notes',
        'view_item' => 'Voir note',
        'search_items' => 'Chercher note',
        'not_found' =>  'Aucune note trouvée',
        'not_found_in_trash' => 'Aucune note trouvée dans la corbeille',
        'menu_name' => 'Notes'
    );
    $args = array(
        'labels' => $labels,
        'public' => true,
        'publicly_queryable' => false,
        'show_ui' => true,
        'show_in_menu' => true,
        'query_var' => true,
        'rewrite' => array('slug' => 'n'),
        'capability_type' => 'post',
        'has_archive' => true,
        'hierarchical' => false,
        'menu_position' => null,
        'menu_icon' => 'dashicons-star-half',
        'show_in_rest' => false,
        'supports' => array('title', 'author')
    );
    register_post_type('note', $args);

}
add_action( 'init', 'cpt_init' );



