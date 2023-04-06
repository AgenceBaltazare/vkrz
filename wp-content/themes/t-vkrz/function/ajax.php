<?php
add_action( 'wp_ajax_vkzr_process_vote', 'vkzr_process_vote' );
add_action( 'wp_ajax_nopriv_vkzr_process_vote', 'vkzr_process_vote' );
function vkzr_process_vote() {
    if(get_field('done_r', $_POST['id_ranking']) != "done"){
        do_elo_ranking($_POST['id_winner'], $_POST['id_looser']);
        if (!in_array($_POST['id_top'], get_exclude_top())) {
            increase_vote_counter($_POST['current_id_vainkeur']);
            increase_vote_resume($_POST['id_top']);
        }
        $top_infos = do_user_ranking($_POST['id_top'], $_POST['id_ranking'], $_POST['id_winner'], $_POST['id_looser'], $_POST['current_id_vainkeur']);
        $user_levels_infos = [];

        if (is_user_logged_in()) {
            $user_levels_infos = check_user_level($_POST['current_id_vainkeur']);
        }

        genererate_tournament_response($top_infos, $user_levels_infos);
    }
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
    delete_real_ranking($_POST['id_ranking'], $_POST['id_vainkeur']);
}

add_action('wp_ajax_vkzr_do_transaction', 'vkzr_do_transaction');
add_action('wp_ajax_nopriv_vkzr_vkzr_do_transaction', 'vkzr_do_transaction');
function vkzr_do_transaction(){
    do_transaction($_POST['id_produit'], $_POST['user_uuid'], $_POST['price'], $_POST['user_email'], $_POST['idvainkeur']);
}

add_action( 'wp_ajax_vkzr_begin_t', 'vkzr_begin_t' );
add_action( 'wp_ajax_nopriv_vkzr_begin_t', 'vkzr_begin_t' );
function vkzr_begin_t() {
    begin_t($_POST['id_top'], $_POST['uuiduser'], $_POST['typetop'], $_POST['id_vainkeur']);
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

add_action('wp_ajax_vkzr_save_to_firestore_finish_top', 'vkzr_save_to_firestore_finish_top');
add_action('wp_ajax_nopriv_vkzr_save_to_firestore_finish_top', 'vkzr_save_to_firestore_finish_top');
function vkzr_save_to_firestore_finish_top()
{
    save_to_firestore($_POST['id_top'], $_POST['id_vainkeur'], $_POST['id_ranking']);
}

add_action('wp_ajax_vkzr_maj_firebase_delete_toplist', 'vkzr_maj_firebase_delete_toplist');
add_action('wp_ajax_nopriv_vkzr_maj_firebase_delete_toplist', 'vkzr_maj_firebase_delete_toplist');
function vkzr_maj_firebase_delete_toplist()
{
    save_elo_to_firestore_delete($_POST['id_ranking'], $_POST['id_vainkeur']);
}

add_action('wp_ajax_vkzr_save_elo_to_firestore', 'vkzr_save_elo_to_firestore');
add_action('wp_ajax_nopriv_vkzr_save_elo_to_firestore', 'vkzr_save_elo_to_firestore');
function vkzr_save_elo_to_firestore()
{
    save_elo_to_firestore($_POST['contender_1'], $_POST['contender_2']);
}

add_action('wp_ajax_vkrz_to_discord', 'vkrz_to_discord');
add_action('wp_ajax_nopriv_vkrz_to_discord', 'vkrz_to_discord');
function vkrz_to_discord()
{
    to_discord($_POST['typeMessage'], $_POST["data"]);
}

add_action('wp_ajax_vkzr_new_jugement', 'vkzr_new_jugement');
add_action('wp_ajax_nopriv_vkzr_new_jugement', 'vkzr_new_jugement');
function vkzr_new_jugement()
{
    do_jugement($_POST['id_ranking'], $_POST['id_vainkeur'], $_POST['todo']);
}

add_action('wp_ajax_deal_vkrz_save_top', 'deal_vkrz_save_top');
add_action('wp_ajax_nopriv_deal_vkrz_save_top', 'deal_vkrz_save_top');
function deal_vkrz_save_top()
{
    deal_save_top($_POST['id_top'], $_POST['id_vainkeur']);
}

add_action('wp_ajax_save_ranking', 'save_ranking');
add_action('wp_ajax_nopriv_save_ranking', 'save_ranking');
function save_ranking()
{
    save_ranking_to_wp($_POST['ranking'], $_POST['id_ranking'], $_POST['nbvotes']);
}