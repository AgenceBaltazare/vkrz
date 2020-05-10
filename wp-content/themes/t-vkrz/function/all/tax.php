<?php
function tax_init() {

    # Secteur
    register_taxonomy(
        'secteur',
        array('post'),
        array(
            'label'         => 'Secteurs',
            'rewrite'       => array('slug' => 'secteur'),
            'hierarchical'  => true,
            'show_in_rest'  => true,
        )
    );

    # Catégories parcours
    register_taxonomy(
        'categorie-parcours',
        array('parcours'),
        array(
            'label'         => 'Categories',
            'rewrite'       => array('slug' => 'categorie-parcours'),
            'hierarchical'  => true,
            'show_in_rest'  => true,
        )
    );

}
add_action('init', 'tax_init');