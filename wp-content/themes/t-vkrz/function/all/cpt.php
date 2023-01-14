<?php
function cpt_init() {

    // Tops
    $labels = array(
        'name' => 'Top',
        'singular_name' => 'Top',
        'add_new' => 'Ajouter un top',
        'add_new_item' => 'Ajouter un top',
        'edit_item' => 'Editer un top',
        'new_item' => 'Nouveau top',
        'all_items' => 'Tous les tops',
        'view_item' => 'Voir top',
        'search_items' => 'Chercher un top',
        'not_found' =>  'Aucun top trouvé',
        'not_found_in_trash' => 'Aucun top trouvé dans la corbeille',
        'menu_name' => 'Tops'
    );
    $args = array(
        'labels' => $labels,
        'public' => true,
        'publicly_queryable' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'query_var' => true,
        'rewrite' => array('slug' => 't'),
        'capabilities' => array(
            'publish_posts' => 'publish_tops',
            'edit_posts' => 'edit_tops',
            'edit_others_posts' => 'edit_others_tops',
            'delete_posts' => 'delete_tops',
            'delete_others_posts' => 'delete_others_tops',
            'read_private_posts' => 'read_private_tops',
            'edit_post' => 'edit_top',
            'delete_post' => 'delete_top',
            'read_post' => 'read_top',
        ),
        'map_meta_cap' => true,
        'has_archive' => true,
        'hierarchical' => false,
        'menu_position' => null,
        'menu_icon' => 'dashicons-editor-code',
        'show_in_rest' => true,
        'supports' => array('title', 'thumbnail', 'author', 'comments')
    );
    register_post_type('tournoi', $args);
    
    // Liste TopList
    $labels = array(
        'name' => 'Liste TopList',
        'singular_name' => 'Liste TopList',
        'add_new' => 'Ajouter une liste de TopList',
        'add_new_item' => 'Ajouter une liste de TopList',
        'edit_item' => 'Editer une liste de TopList',
        'new_item' => 'Nouvelle liste de TopList',
        'all_items' => 'Toutes les listes de TopLists',
        'view_item' => 'Voire la liste de TopList',
        'search_items' => 'Chercher une liste de TopList',
        'not_found' =>  'Aucune liste de TopList trouvée',
        'not_found_in_trash' => 'Aucune liste de TopList trouvée dans la corbeille',
        'menu_name' => 'Liste de TopList'
    );
    $args = array(
        'labels' => $labels,
        'public' => true,
        'publicly_queryable' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'query_var' => true,
        'rewrite' => array('slug' => 'toplist'),
        'map_meta_cap' => true,
        'has_archive' => true,
        'hierarchical' => false,
        'menu_position' => null,
        'menu_icon' => 'dashicons-menu-alt3',
        'show_in_rest' => true,
        'supports' => array('title', 'editor')
    );
    register_post_type('liste-toplist', $args);
    
    // TopList mondial
    $labels = array(
        'name' => 'TopList mondiale',
        'singular_name' => 'TopList mondiale',
        'add_new' => 'Ajouter une TopList mondiale',
        'add_new_item' => 'Ajouter une TopList mondiale',
        'edit_item' => 'Editer une TopList mondiale',
        'new_item' => 'Nouvelle TopList mondiale',
        'all_items' => 'Toutes les TopList mondiales',
        'view_item' => 'Voir la TopList mondiale',
        'search_items' => 'Chercher une TopList mondiale',
        'not_found' =>  'Aucune TopList mondiale trouvée',
        'not_found_in_trash' => 'Aucune TopList mondiale trouvée dans la corbeille',
        'menu_name' => 'TopList mondiale'
    );
    $args = array(
        'labels' => $labels,
        'public' => true,
        'publicly_queryable' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'query_var' => true,
        'rewrite' => array('slug' => 'top-mondial'),
        'map_meta_cap' => true,
        'has_archive' => true,
        'hierarchical' => false,
        'menu_position' => null,
        'menu_icon' => 'dashicons-admin-site',
        'show_in_rest' => true,
        'supports' => array('title', 'editor')
    );
    register_post_type('toplist-mondiale', $args);

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
        'menu_icon' => 'dashicons-superhero',
        'show_in_rest' => false,
        'supports' => array('title', 'thumbnail', 'author')
    );
    register_post_type('contender', $args);

    // Players
    $labels = array(
        'name' => 'Player',
        'singular_name' => 'Player',
        'add_new' => 'Ajouter un player',
        'add_new_item' => 'Ajouter un player',
        'edit_item' => 'Editer un player',
        'new_item' => 'Nouveau player',
        'all_items' => 'Tous les players',
        'view_item' => 'Voir player',
        'search_items' => 'Chercher un player',
        'not_found' =>  'Aucun player trouvé',
        'not_found_in_trash' => 'Aucun player trouvé dans la corbeille',
        'menu_name' => 'Players'
    );
    $args = array(
        'labels' => $labels,
        'public' => true,
        'publicly_queryable' => false,
        'show_ui' => true,
        'show_in_menu' => true,
        'query_var' => true,
        'rewrite' => array('slug' => 'p'),
        'map_meta_cap' => true,
        'has_archive' => true,
        'hierarchical' => false,
        'menu_position' => null,
        'menu_icon' => 'dashicons-buddicons-activity',
        'show_in_rest' => true,
        'supports' => array('title', 'author')
    );
    register_post_type('player', $args);

    // Top résume
    $labels = array(
        'name' => 'Résume',
        'singular_name' => 'Résume',
        'add_new' => 'Ajouter un resumé',
        'add_new_item' => 'Ajouter un resumé',
        'edit_item' => 'Editer un resumé',
        'new_item' => 'Nouveau resumé',
        'all_items' => 'Tous les resumés',
        'view_item' => 'Voir resumé',
        'search_items' => 'Chercher un resumé',
        'not_found' =>  'Aucun resumé trouvé',
        'not_found_in_trash' => 'Aucun resumé trouvé dans la corbeille',
        'menu_name' => 'Resumés'
    );
    $args = array(
        'labels' => $labels,
        'public' => true,
        'publicly_queryable' => false,
        'show_ui' => true,
        'show_in_menu' => true,
        'query_var' => true,
        'rewrite' => array('slug' => 'resume'),
        'map_meta_cap' => true,
        'has_archive' => true,
        'hierarchical' => false,
        'menu_position' => null,
        'menu_icon' => 'dashicons-media-spreadsheet',
        'show_in_rest' => true,
        'supports' => array('title')
    );
    register_post_type('resume', $args);

    // Shop
    $labels = array(
        'name' => 'Produit',
        'singular_name' => 'Produit',
        'add_new' => 'Ajouter un produit',
        'add_new_item' => 'Ajouter un produit',
        'edit_item' => 'Editer un produit',
        'new_item' => 'Nouveau produit',
        'all_items' => 'Tous les produits',
        'view_item' => 'Voir produit',
        'search_items' => 'Chercher un produit',
        'not_found' =>  'Aucun produit trouvé',
        'not_found_in_trash' => 'Aucun produit trouvé dans la corbeille',
        'menu_name' => 'produits'
    );
    $args = array(
        'labels' => $labels,
        'public' => true,
        'publicly_queryable' => false,
        'show_ui' => true,
        'show_in_menu' => true,
        'query_var' => true,
        'rewrite' => array('slug' => 'p'),
        'map_meta_cap' => true,
        'has_archive' => true,
        'hierarchical' => false,
        'menu_position' => null,
        'menu_icon' => 'dashicons-cart',
        'show_in_rest' => true,
        'supports' => array('title', 'thumbnail')
    );
    register_post_type('produit', $args);

    // Transaction
    $labels = array(
        'name' => 'Transaction',
        'singular_name' => 'Transaction',
        'add_new' => 'Ajouter une transaction',
        'add_new_item' => 'Ajouter une transaction',
        'edit_item' => 'Editer une transaction',
        'new_item' => 'Nouveau transaction',
        'all_items' => 'Tous les transactions',
        'view_item' => 'Voir transaction',
        'search_items' => 'Chercher une transaction',
        'not_found' =>  'Aucune transaction trouvée',
        'not_found_in_trash' => 'Aucune transaction trouvée dans la corbeille',
        'menu_name' => 'transactions'
    );
    $args = array(
        'labels' => $labels,
        'public' => true,
        'publicly_queryable' => false,
        'show_ui' => true,
        'show_in_menu' => true,
        'query_var' => true,
        'rewrite' => array('slug' => 'tr'),
        'map_meta_cap' => true,
        'has_archive' => true,
        'hierarchical' => false,
        'menu_position' => null,
        'menu_icon' => 'dashicons-money-alt',
        'show_in_rest' => true,
        'supports' => array('title', 'author')
    );
    register_post_type('transaction', $args);

    // Room
    $labels = array(
        'name' => 'Room',
        'singular_name' => 'Room',
        'add_new' => 'Ajouter une room',
        'add_new_item' => 'Ajouter une room',
        'edit_item' => 'Editer une room',
        'new_item' => 'Nouveau room',
        'all_items' => 'Tous les rooms',
        'view_item' => 'Voir room',
        'search_items' => 'Chercher une room',
        'not_found' =>  'Aucune room trouvée',
        'not_found_in_trash' => 'Aucune room trouvée dans la corbeille',
        'menu_name' => 'Room'
    );
    $args = array(
        'labels' => $labels,
        'public' => true,
        'publicly_queryable' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'query_var' => true,
        'rewrite' => array('slug' => 'room'),
        'map_meta_cap' => true,
        'has_archive' => true,
        'hierarchical' => false,
        'menu_position' => null,
        'menu_icon' => 'dashicons-admin-multisite',
        'show_in_rest' => true,
        'supports' => array('title', 'author', 'thumbnail')
    );
    register_post_type('room', $args);

}
add_action( 'init', 'cpt_init' );



