<?php
function do_transaction($id_produit, $user_uuid, $price, $user_email, $idvainkeur){

    if ($id_produit) {

        $new_transaction = array(
            'post_type'   => 'transaction',
            'post_title'  => 'U:' . $user_uuid . ' P:' . $id_produit . ' M:' . $price . ' V:' . $idvainkeur,
            'post_status' => 'publish',
        );
        $id_new_transaction  = wp_insert_post($new_transaction);

        update_field('uuid_transaction', $user_uuid, $id_new_transaction);
        update_field('id_vainkeur_transaction', $idvainkeur, $id_new_transaction);
        update_field('id_produit_transaction', $id_produit, $id_new_transaction);
        update_field('montant_transaction', $price, $id_new_transaction);
        update_field('email_acheteur_transaction', $user_email, $id_new_transaction);

        $current_money = get_current_money($idvainkeur);

        return die(json_encode($current_money));

    }
}
