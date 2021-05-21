<?php
add_action( 'wp_ajax_vkzr_process_vote', 'vkzr_process_vote' );
add_action( 'wp_ajax_nopriv_vkzr_process_vote', 'vkzr_process_vote' );

function vkzr_process_vote() {
	do_elo_ranking( $_POST['id_tournament'], $_POST['id_winner'], $_POST['id_looser'] );
	$tournanment_infos = do_user_ranking( $_POST['id_tournament'], $_POST['id_winner'], $_POST['id_looser'] );
	genrerate_tournament_response($tournanment_infos);
}

add_action( 'wp_ajax_vkzr_process_delete_ranking', 'vkzr_process_delete_ranking' );
add_action( 'wp_ajax_nopriv_vkzr_process_delete_ranking', 'vkzr_process_delete_ranking' );

function vkzr_process_delete_ranking() {
    delete_ranking($_POST['id_ranking']);
}


