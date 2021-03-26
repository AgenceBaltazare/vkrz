<?php
function do_user_ranking( $id_tournament, $id_winner, $id_looser ) {
	$id_ranking = get_or_create_ranking_if_not_exists( $id_tournament );
    do_vote($id_winner, $id_looser, $id_ranking);
	return get_next_duel($id_ranking, $id_tournament);
}