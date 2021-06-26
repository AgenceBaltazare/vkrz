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
}



