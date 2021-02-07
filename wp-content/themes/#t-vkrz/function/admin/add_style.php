<?php
function add_style_select_buttons( $buttons ) {
    array_unshift( $buttons, 'styleselect' );
    return $buttons;
}
add_filter( 'mce_buttons_2', 'add_style_select_buttons' );

function my_custom_styles( $init_array ) {

    $style_formats = array(
        array(
            'title' => 'Légende',
            'block' => 'small',
            'classes' => '',
            'wrapper' => true,
        )
    );
    $init_array['style_formats'] = json_encode( $style_formats );
    return $init_array;
}
add_filter( 'tiny_mce_before_init', 'my_custom_styles' );