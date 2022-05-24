<?php
function tax_init() {

    # Catégorie Top
    register_taxonomy(
        'categorie',
        array('tournoi'),
        array(
            'label'         => 'Catégories',
            'rewrite'       => array('slug' => 'cat'),
            'hierarchical'  => true,
            'show_in_rest'  => true,
        )
    );

    # Target Top
    register_taxonomy(
        'sous-cat',
        array('tournoi'),
        array(
            'label'         => 'Sous cat',
            'rewrite'       => array('slug' => 'sous-cat'),
            'hierarchical'  => false,
            'show_in_rest'  => true,
        )
    );

    # Tags Top
    register_taxonomy(
        'tag',
        array('tournoi'),
        array(
            'label'         => 'Concepts',
            'rewrite'       => array('slug' => 'tag'),
            'hierarchical'  => false,
            'show_in_rest'  => true,
        )
    );

    # Concept Top
    register_taxonomy(
        'concept',
        array('tournoi'),
        array(
            'label'         => 'Sujet',
            'rewrite'       => array('slug' => 'sujet'),
            'hierarchical'  => false,
            'show_in_rest'  => true,
        )
    );

    # Type de Top
    register_taxonomy(
        'type',
        array('tournoi', 'classement'),
        array(
            'label'         => 'Type',
            'rewrite'       => array('slug' => 'type'),
            'hierarchical'  => false,
            'show_in_rest'  => true,
        )
    );

    register_taxonomy( 
        'badges',
        array('vainkeur'),
        array(
            'label' => 'Badges',
            'labels' => array(
                'name'              => _x( 'Badges', 'taxonomy general name' ),
                'singular_name'     => _x( 'Badge', 'taxonomy singular name' ),
                'search_items'      => __( 'Chercher un badge' ),
                'all_items'         => __( 'Tous les badges' ),
                'edit_item'         => __( 'Modifier le badge' ),
                'update_item'       => __( 'Sauvegarder le badge' ),
                'add_new_item'      => __( 'Ajouter un badge' ),
                'new_item_name'     => __( 'Nouveau nom de badge' ),
                'menu_name'         => __( 'Badges' )
            ),
            'hierarchical'      => false,
            'show_ui'           => true,
            'show_admin_column' => true,
            'query_var'         => true,
            'rewrite'           => array( 'slug' => 'badges' )
        )
    );
}
add_action('init', 'tax_init');