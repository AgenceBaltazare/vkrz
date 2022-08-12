<?php

function do_jugement($id_ranking, $id_vainkeur, $todo = "add"){

    if($todo == "delete"){

        // incremente TopList
        $nb_jugement_r = get_field('nb_jugement_r', $id_ranking);
        $nb_jugement_r--;
        if ($nb_jugement_r < 0) {
            $nb_jugement_r = 0;
        }
        update_field('nb_jugement_r', $nb_jugement_r, $id_ranking);

        // incremente Vainkeur
        $nb_jugement_vkrz = get_field('nb_jugement_vkrz', $id_vainkeur);
        $nb_jugement_vkrz--;

        if($nb_jugement_vkrz < 0){
            $nb_jugement_vkrz = 0;
        }
        update_field('nb_jugement_vkrz', $nb_jugement_vkrz, $id_vainkeur);

    }
    else{

        // incremente TopList
        $nb_jugement_r = get_field('nb_jugement_r', $id_ranking);
        $nb_jugement_r++;
        update_field('nb_jugement_r', $nb_jugement_r, $id_ranking);

        // incremente Vainkeur
        $nb_jugement_vkrz = get_field('nb_jugement_vkrz', $id_vainkeur);
        $nb_jugement_vkrz++;
        update_field('nb_jugement_vkrz', $nb_jugement_vkrz, $id_vainkeur);

        // Badge : Juge
        if (!get_vainkeur_badge($id_vainkeur, "Juge")) {
            update_vainkeur_badge($id_vainkeur, "Juge");
        }

    }

}