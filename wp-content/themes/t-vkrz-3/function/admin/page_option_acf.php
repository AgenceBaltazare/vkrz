<?php
    if( function_exists('acf_add_options_page') ) {
        acf_add_options_page();
        acf_add_options_sub_page('Global');
        acf_add_options_sub_page('Social');
        acf_add_options_sub_page('Datas');
        acf_add_options_sub_page('Games');
    }