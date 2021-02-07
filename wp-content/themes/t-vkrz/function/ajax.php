<?php
add_action( 'wp_ajax_vkzr_do_elo_vote', 'vkzr_do_elo_vote' );
function vkzr_do_elo_vote() {

	$tournament = $_POST['t'];
	$winner     = $_POST['v'];
	$looser     = $_POST['l'];
	$k          = 32;

	$elo_v = get_field( 'ELO_c', $winner );
	$elo_l = get_field( 'ELO_c', $looser );

	$rank_v = 1 / ( 1 + ( pow( 10, ( $elo_l - $elo_v ) / 400 ) ) );
	$rank_l = 1 / ( 1 + ( pow( 10, ( $elo_v - $elo_l ) / 400 ) ) );

	$new_score_v = floor( $elo_v + $k * ( 1 - $rank_v ) );
	$new_score_l = floor( $elo_l + $k * ( 0 - $rank_l ) );

	update_field( 'ELO_c', $new_score_v, $winner );
	update_field( 'ELO_c', $new_score_l, $looser );

    $user_id_uniq      = $_COOKIE["vainkeurz_user_id"];

    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        $ip_user_v = $_SERVER['HTTP_CLIENT_IP'];
    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $ip_user_v = $_SERVER['HTTP_X_FORWARDED_FOR'];
    } else {
        $ip_user_v = $_SERVER['REMOTE_ADDR'];
    }

	$new_vote = array(
		'post_type'   => 'vote',
		'post_title'  => 'U:' . $user_id_uniq . ' T:' . $tournament . ' V:' . $winner . '(' . $elo_v . ')' . ' L:' . $looser . '(' . $elo_l . ')',
		'post_status' => 'publish',
	);
	$id_vote  = wp_insert_post( $new_vote );

	update_field( 'id_user_v', $user_id_uniq, $id_vote );
    update_field( 'ip_user_v', $ip_user_v, $id_vote );
	update_field( 'id_v_v', $winner, $id_vote );
	update_field( 'elo_v_v', $elo_v, $id_vote );
	update_field( 'id_l_v', $looser, $id_vote );
	update_field( 'elo_l_v', $elo_l, $id_vote );
	update_field( 'id_t_v', $tournament, $id_vote );
}

