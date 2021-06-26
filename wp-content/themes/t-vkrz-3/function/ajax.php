<?php
add_action( 'wp_ajax_vkzr_process_vote', 'vkzr_process_vote' );
add_action( 'wp_ajax_nopriv_vkzr_process_vote', 'vkzr_process_vote' );
function vkzr_process_vote() {
	do_elo_ranking( $_POST['id_tournament'], $_POST['id_winner'], $_POST['id_looser'], $_POST['id_ranking'] );
	$tournanment_infos = do_user_ranking( $_POST['id_tournament'], $_POST['id_winner'], $_POST['id_looser'] );
	genrerate_tournament_response($tournanment_infos);
}

add_action( 'wp_ajax_vkzr_process_delete_ranking', 'vkzr_process_delete_ranking' );
add_action( 'wp_ajax_nopriv_vkzr_process_delete_ranking', 'vkzr_process_delete_ranking' );
function vkzr_process_delete_ranking() {
    delete_ranking($_POST['id_ranking']);
}

add_action( 'wp_ajax_vkzr_process_delete_real_ranking', 'vkzr_process_delete_real_ranking' );
add_action( 'wp_ajax_nopriv_vkzr_process_delete_real_ranking', 'vkzr_process_delete_real_ranking' );
function vkzr_process_delete_real_ranking() {
    delete_real_ranking($_POST['id_ranking']);
}

add_action( 'wp_ajax_vkzr_process_note', 'vkzr_process_note' );
add_action( 'wp_ajax_nopriv_vkzr_process_note', 'vkzr_process_note' );
function vkzr_process_note() {
    do_note($_POST['id_tournament'], $_POST['uuiduser'], $_POST['star']);
}

add_action( 'wp_ajax_vkzr_process_commentaire_note', 'vkzr_process_commentaire_note' );
add_action( 'wp_ajax_nopriv_vkzr_process_commentaire_note', 'vkzr_process_commentaire_note' );
function vkzr_process_commentaire_note() {
    do_commentaire_note($_POST['id_tournament'], $_POST['uuiduser'], $_POST['commentaire_note']);
}

add_action( 'wp_ajax_vkzr_begin_t', 'vkzr_begin_t' );
add_action( 'wp_ajax_nopriv_vkzr_begin_t', 'vkzr_begin_t' );
function vkzr_begin_t() {
    begin_t($_POST['id_tournament'], $_POST['uuiduser'], $_POST['typetop']);
}
