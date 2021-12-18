<?php
function get_current_money($id_vainkeur){

    $all_transaction        = 0;
    $global_money           = 0;
    $money_vkrz             = get_field('money_vkrz', $id_vainkeur);
    $money_createur_vkrz    = get_field('money_creator_vkrz', $id_vainkeur);

    $transaction = new WP_Query(array(
        'ignore_sticky_posts'	    => true,
        'update_post_meta_cache'    => false,
        'no_found_rows'		        => true,
        'post_type'			        => 'transaction',
        'posts_per_page'		    => -1,
        'meta_query'             => array(
            array(
                'key'       => 'id_vainkeur_transaction',
                'value'     => $id_vainkeur,
                'compare'   => '='
            )
        ),
    ));
    while ($transaction->have_posts()) : $transaction->the_post();

        $all_transaction = $all_transaction + get_field('montant_transaction');
    
    endwhile;

    $global_money = ($money_vkrz + $money_createur_vkrz) - $all_transaction;

    return $global_money;
}
