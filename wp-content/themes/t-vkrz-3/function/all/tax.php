<?php
function tax_init() {

    # Catégorie tournoi
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

    # Target tournoi
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

    # Tags tournoi
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

    # Concept tournoi
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

}
add_action('init', 'tax_init');