<?php

add_action( 'wp_ajax_vkzr_do_elo_vote', 'vkzr_do_elo_vote' );
add_action( 'wp_ajax_nopriv_vkzr_do_elo_vote', 'vkzr_do_elo_vote' );

function vkzr_do_elo_vote() {

	$tournament = $_POST['t'];
	$winner     = $_POST['v'];
	$looser     = $_POST['l'];
	$k          = 16;
	$u          = 0;

	$elo_v = get_field( 'ELO_c', $winner );
	$elo_l = get_field( 'ELO_c', $looser );

	$rank_v = 1 / ( 1 + ( pow( 10, ( $elo_l - $elo_v ) / 400 ) ) );
	$rank_l = 1 / ( 1 + ( pow( 10, ( $elo_v - $elo_l ) / 400 ) ) );

	$new_score_v = floor( $elo_v + $k * ( 1 - $rank_v ) );
	$new_score_l = floor( $elo_l + $k * ( 0 - $rank_l ) );


	update_field( 'ELO_c', $new_score_v, $winner );
	update_field( 'ELO_c', $new_score_l, $looser );

//
// Add vote
//
	if ( is_user_logged_in() ) {
		$is_logged  = "true";
	}
	else{
        $is_logged  = "false";
    }

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
    update_field( 'loggue_v', $is_logged, $id_vote );

    $all_user_votes       = new WP_Query( array(
        'post_type'      => 'vote',
        'posts_per_page' => - 1,
        'meta_query'     => array(
            'relation'   => 'AND',
            array(
                'key'     => 'id_t_v',
                'value'   => $tournament,
                'compare' => '=',
            ),
            array(
                'key'     => 'id_user_v',
                'value'   => $_COOKIE["vainkeurz_user_id"],
                'compare' => '=',
            )
        )
    ));
    $nb_user_votes = $all_user_votes->post_count;

	$all_votes  = new WP_Query( array(
		'post_type'      => 'vote',
		'posts_per_page' => - 1,
		'meta_query'     => array(
			array(
				'key'     => 'id_t_v',
				'value'   => $tournament,
				'compare' => '=',
			)
		)
	));
	$contenders = new WP_Query( array(
		'post_type'      => 'contender',
		'posts_per_page' => 2,
		'orderby'        => 'rand',
		'meta_query'     => array(
			array(
				'key'     => 'id_tournoi_c',
				'value'   => (int) $tournament,
				'compare' => '=',
			)
		)
	));

	$contendersHtml = [];
	$index          = 1;
	while ( $contenders->have_posts() ) : $contenders->the_post();
		$contendersHtml[] = formatContenderHtml( $tournament, get_the_ID(), $index );
		$index ++;
	endwhile;

	if($nb_user_votes == 0){
	    $display_user_votes = "Aucun vote encore";
	}
	elseif($nb_user_votes == 1){
        $display_user_votes = "Bravo pour ton 1er vote";
    }
    else{
        $display_user_votes = "Vos votes : ".$all_user_votes->post_count;
    }

	return die( json_encode( [
		'contenders'                => $contendersHtml,
		'vote_count_string'         => $all_votes->post_count . " " . __( 'VOTES', 'vkrz' ),
        'vote_user_count_string'    => $display_user_votes,
		'classement'                => getClassementHtml($tournament),

	] ) );

}

