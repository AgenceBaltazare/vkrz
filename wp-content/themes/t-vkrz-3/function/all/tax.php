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
            'rewrite'       => array('slug' => 'concept'),
            'hierarchical'  => false,
            'show_in_rest'  => true,
        )
    );

    # Type de Top
    register_taxonomy(
        'type',
        array('tournoi'),
        array(
            'label'         => 'Type',
            'rewrite'       => array('slug' => 'type'),
            'hierarchical'  => false,
            'show_in_rest'  => true,
        )
    );

}
add_action('init', 'tax_init');