<?php
function get_current_money($id_vainkeur, $typemoney = false){

    $all_transaction_vainkeur   = 0;
    $all_transaction_createur   = 0;
    $global_money               = array();
    if(!$typemoney){
        $typemoney = "vainkeur";
    }
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

        $id_produit = get_field('id_produit_transaction');

        if(get_field('reserve_aux_createurs_produit', $id_produit)){
            $all_transaction_vainkeur = $all_transaction_vainkeur + get_field('montant_transaction');
        }
        else{
            $all_transaction_createur = $all_transaction_createur + get_field('montant_transaction');
        }
    
    endwhile;

    $current_money_vainkeur = $money_vkrz - $all_transaction_vainkeur;
    $current_money_createur = $money_createur_vkrz - $all_transaction_createur;

    $global_money = array(
        'money_vainkeur' => $current_money_vainkeur,
        'money_createur' => $current_money_createur
    );

    return $global_money;
}
