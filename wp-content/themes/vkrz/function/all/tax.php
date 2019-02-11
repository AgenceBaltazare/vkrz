<?php
// CT
function ct_tax_init() {
    // Cat battle
    register_taxonomy(
        'battle',
        array('battle'),
        array(
            'label' => 'Category',
            'rewrite' => array('slug' => 'cat-battle'),
            'hierarchical' => true,
        )
    );
    // Tax battle
    register_taxonomy(
        'tax-battle',
        array('battle'),
        array(
            'label' => 'Keywords',
            'rewrite' => array('slug' => 'tax-battle'),
            'hierarchical' => false,
        )
    );
}
add_action('init', 'ct_tax_init');