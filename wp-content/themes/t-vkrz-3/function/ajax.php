<?php
add_action( 'wp_ajax_vkzr_process_vote', 'vkzr_process_vote' );
add_action( 'wp_ajax_nopriv_vkzr_process_vote', 'vkzr_process_vote' );
function vkzr_process_vote() {
	do_elo_ranking($_POST['id_winner'], $_POST['id_looser']);
	if (!in_array($_POST['id_top'], get_exclude_top())) {
        increase_vote_counter($_POST['current_id_vainkeur']);
        increase_vote_resume($_POST['id_top']);
    }
	$top_infos = do_user_ranking($_POST['id_top'], $_POST['id_ranking'], $_POST['id_winner'], $_POST['id_looser'], $_POST['current_id_vainkeur']);
	$user_levels_infos = [];

	if(is_user_logged_in()){
        $user_levels_infos = check_user_level($_POST['current_id_vainkeur']);
    }
    
	genererate_tournament_response($top_infos, $user_levels_infos);
}

add_action( 'wp_ajax_vkzr_check_level', 'vkzr_check_level' );
add_action( 'wp_ajax_nopriv_vkzr_check_level', 'vkzr_check_level' );
function vkzr_check_level() {
    if(is_user_logged_in()){
        check_user_level($_POST['current_id_vainkeur']);
    }
}

add_action( 'wp_ajax_vkzr_process_delete_ranking', 'vkzr_process_delete_ranking' );
add_action( 'wp_ajax_nopriv_vkzr_process_delete_ranking', 'vkzr_process_delete_ranking' );
function vkzr_process_delete_ranking() {
    delete_ranking($_POST['id_ranking'], $_POST['id_vainkeur']);
}

add_action( 'wp_ajax_vkzr_process_delete_real_ranking', 'vkzr_process_delete_real_ranking' );
add_action( 'wp_ajax_nopriv_vkzr_process_delete_real_ranking', 'vkzr_process_delete_real_ranking' );
function vkzr_process_delete_real_ranking() {
    delete_real_ranking($_POST['id_ranking'], $_POST['id_vainkeur']);
}

add_action( 'wp_ajax_vkzr_process_note', 'vkzr_process_note' );
add_action( 'wp_ajax_nopriv_vkzr_process_note', 'vkzr_process_note' );
function vkzr_process_note() {
    do_note($_POST['id_top'], $_POST['uuiduser'], $_POST['star']);
}

add_action('wp_ajax_vkzr_do_transaction', 'vkzr_do_transaction');
add_action('wp_ajax_nopriv_vkzr_vkzr_do_transaction', 'vkzr_do_transaction');
function vkzr_do_transaction(){
    do_transaction($_POST['id_produit'], $_POST['user_uuid'], $_POST['price'], $_POST['user_email'], $_POST['idvainkeur']);
}

add_action( 'wp_ajax_vkzr_process_commentaire_note', 'vkzr_process_commentaire_note' );
add_action( 'wp_ajax_nopriv_vkzr_process_commentaire_note', 'vkzr_process_commentaire_note' );
function vkzr_process_commentaire_note() {
    do_commentaire_note($_POST['id_top'], $_POST['uuiduser'], $_POST['commentaire_note']);
}

add_action( 'wp_ajax_vkzr_begin_t', 'vkzr_begin_t' );
add_action( 'wp_ajax_nopriv_vkzr_begin_t', 'vkzr_begin_t' );
function vkzr_begin_t() {
    begin_t($_POST['id_top'], $_POST['uuiduser'], $_POST['typetop']);
}

add_action('wp_ajax_vkzr_form_newplayer', 'vkzr_form_newplayer');
add_action('wp_ajax_nopriv_vkzr_form_newplayer', 'vkzr_form_newplayer');
function vkzr_form_newplayer(){
    form_newplayer($_POST['emailplayer'], $_POST['uuiduser'], $_POST['ranking'], $_POST['top'], $_POST['id_vainkeur']);
}

add_action( 'wp_ajax_vkzr_get_monitor_data', 'vkzr_get_monitor_data' );
add_action( 'wp_ajax_nopriv_vkzr_get_monitor_data', 'vkzr_get_monitor_data' );
function vkzr_get_monitor_data() {
    get_monitor_data();
}

add_action( 'wp_ajax_vkzr_get_contenders_ranking', 'vkzr_get_contenders_ranking' );
add_action( 'wp_ajax_nopriv_vkzr_get_contenders_ranking', 'vkzr_get_contenders_ranking' );
function vkzr_get_contenders_ranking() {
    get_contenders_ranking_json($_POST['topId']);
}

add_action('wp_ajax_vkzr_get_similar_ranking', 'vkzr_get_similar_ranking');
add_action('wp_ajax_nopriv_vkzr_get_similar_ranking', 'vkzr_get_similar_ranking');
function vkzr_get_similar_ranking()
{
    get_similar_ranking($_POST['uuiduser'], $_POST['idtop']);
}
