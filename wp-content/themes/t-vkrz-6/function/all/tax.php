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
            'label' => 'Trophées 🎖',
            'labels' => array(
                'name'              => 'Trophées 🎖',
                'singular_name'     => 'Trophée 🎖',
                'search_items'      => 'Chercher un Trophée',
                'all_items'         => 'Tous les Trophées',
                'edit_item'         => 'Modifier le Trophée',
                'update_item'       => 'Sauvegarder le Trophée',
                'add_new_item'      => 'Ajouter un Trophée',
                'new_item_name'     => 'Nouveau nom de Trophée',
                'menu_name'         => 'Trophées'
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