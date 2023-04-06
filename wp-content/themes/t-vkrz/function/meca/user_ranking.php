<?php
function do_user_ranking($id_top, $id_ranking, $id_winner, $id_looser, $current_id_vainkeur) {
    do_vote($id_winner, $id_looser, $id_ranking, $id_top);
	return get_next_duel($id_ranking, $id_top, $current_id_vainkeur);
}

function save_ranking_to_wp($ranking, $id_ranking, $nbvotes){
    $id_top = get_field('id_tournoi_r', $id_ranking);
    $nb_contenders = get_field('count_contenders_t', $id_top);
    $current_id_vainkeur = get_field('id_vainkeur_r', $id_ranking);

    finish_the_top($id_ranking, $current_id_vainkeur, $id_top, $nb_contenders);

    update_field('ranking_r', $ranking, $id_ranking);
    update_field('nb_votes_r', $nbvotes, $id_ranking);
}