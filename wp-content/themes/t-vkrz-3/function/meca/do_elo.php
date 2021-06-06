<?php
function do_elo_ranking( $id_tournoi, $id_winner, $id_looser, $id_ranking ) {

    $uuiduser = $_COOKIE['vainkeurz_user_id'];

	include_once 'VkrzELoRranking.php';
	$elo_winner = floor(get_field( 'ELO_c', $id_winner ));
	$elo_looser = floor(get_field( 'ELO_c', $id_looser ));
	$eloRanking  = new VkrzELoRranking( $elo_winner, $elo_looser, 1, 0 );
	$newRankings = $eloRanking->getNewRatings();

	update_field( 'ELO_c', round($newRankings['a']), $id_winner );
	update_field( 'ELO_c', round($newRankings['b']), $id_looser );

	$new_vote = array(
		'post_type'   => 'vote',
		'post_title'  => 'U:' . $uuiduser . ' T:' . $id_tournoi . ' V:' . $id_winner . ' L:' . $id_looser,
		'post_status' => 'publish',
	);
	$id_vote  = wp_insert_post( $new_vote );

	update_field( 'id_user_v', $uuiduser, $id_vote );
	update_field( 'id_v_v', $id_winner, $id_vote );
	update_field( 'id_l_v', $id_looser, $id_vote );
	update_field( 'id_t_v', $id_tournoi, $id_vote );
	update_field( 'id_r_v', $id_ranking, $id_vote );
}



