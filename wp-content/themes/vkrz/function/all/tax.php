<?php
// CT
function ct_gopened_init() {
    // Action Réalisation
    register_taxonomy(
        'type_rea',
        array('realisation', 'visite'),
        array(
            'label' => 'Type',
            'rewrite' => array( 'slug' => 'type-rea' ),
            'hierarchical' => true,
        )
    );
}
add_action( 'init', 'ct_gopened_init' );