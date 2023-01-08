<?php
function do_transaction($id_produit, $user_uuid, $price, $user_email, $idvainkeur){

    if ($id_produit && $idvainkeur) {

        // Get vainkeur current money
        $current_money      = get_field('money_disponible_vkrz', $idvainkeur);
        $new_current_money  = $current_money - $price;
        $new_badge          = false;

        if (($current_money - $price) >= 0) {

            $new_transaction = array(
                'post_type'   => 'transaction',
                'post_title'  => get_the_title($id_produit),
                'post_status' => 'publish',
            );
            $id_new_transaction  = wp_insert_post($new_transaction);

            update_field('uuid_transaction', $user_uuid, $id_new_transaction);
            update_field('id_vainkeur_transaction', $idvainkeur, $id_new_transaction);
            update_field('id_produit_transaction', $id_produit, $id_new_transaction);
            update_field('montant_transaction', $price, $id_new_transaction);
            update_field('email_acheteur_transaction', $user_email, $id_new_transaction);
            update_field('etat_transaction', 'pending', $id_new_transaction);

            update_field('money_disponible_vkrz', $new_current_money, $idvainkeur);

            // Badge : Shoper
            if (!get_vainkeur_badge($idvainkeur, "Shopper")) {
                update_vainkeur_badge($idvainkeur, "Shopper");
                $new_badge = "Shopper";
            }

            if ($id_new_transaction) {
                vkrz_push_transaction($id_new_transaction);
            }

            return die(json_encode(array(
                "id_transaction" => $id_new_transaction,
                "current_money"  => $new_current_money,
                "new_badge"      => $new_badge
            )));
        }

    }
}
