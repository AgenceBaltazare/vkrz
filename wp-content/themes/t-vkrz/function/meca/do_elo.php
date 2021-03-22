<?php
function do_elo_ranking( $id_tournoi, $id_winner, $id_looser ) {
	include_once 'VkrzELoRranking.php';
	$elo_winner = floor(get_field( 'ELO_c', $id_winner ));
	$elo_looser = floor(get_field( 'ELO_c', $id_looser ));
	$eloRanking  = new VkrzELoRranking( $elo_winner, $elo_looser, 1, 0 );
	$newRankings = $eloRanking->getNewRatings();

	update_field( 'ELO_c', round($newRankings['a']), $id_winner );
	update_field( 'ELO_c', round($newRankings['b']), $id_looser );

	if ( is_user_logged_in() ) {
		$is_logged = "true";
	} else {
		$is_logged = "false";
	}

	if ( ! empty( $_SERVER['HTTP_CLIENT_IP'] ) ) {
		$ip_user_v = $_SERVER['HTTP_CLIENT_IP'];
	} elseif ( ! empty( $_SERVER['HTTP_X_FORWARDED_FOR'] ) ) {
		$ip_user_v = $_SERVER['HTTP_X_FORWARDED_FOR'];
	} else {
		$ip_user_v = $_SERVER['REMOTE_ADDR'];
	}
	$new_vote = array(
		'post_type'   => 'vote',
		'post_title'  => 'U:' . $_COOKIE['vainkeurz_user_id'] . ' T:' . $id_tournoi . ' V:' . $id_winner . '(' . $newRankings['a'] . ')' . ' L:' . $id_looser . '(' . $newRankings['b'] . ')',
		'post_status' => 'publish',
	);
	$id_vote  = wp_insert_post( $new_vote );

	update_field( 'id_user_v', $_COOKIE['vainkeurz_user_id'], $id_vote );
	update_field( 'ip_user_v', $ip_user_v, $id_vote );
	update_field( 'id_v_v', $id_winner, $id_vote );
	update_field( 'elo_v_v', $newRankings['a'], $id_vote );
	update_field( 'id_l_v', $id_looser, $id_vote );
	update_field( 'elo_l_v', $newRankings['b'], $id_vote );
	update_field( 'id_t_v', $id_tournoi, $id_vote );
	update_field( 'loggue_v', $is_logged, $id_vote );
}



