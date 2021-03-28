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

}
add_action('init', 'tax_init');