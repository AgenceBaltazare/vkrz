<?php
function do_user_ranking($id_top, $id_ranking, $id_winner, $id_looser, $current_id_vainkeur) {
    do_vote($id_winner, $id_looser, $id_ranking, $id_top);
	return get_next_duel($id_ranking, $id_top, $current_id_vainkeur);
}