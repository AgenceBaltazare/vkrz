<?php
function genererate_tournament_response($top_infos, $user_levels_infos = []){

    extract($top_infos);

    ob_start();
    set_query_var( 'battle_vars', compact( 'contender_1', 'contender_2', 'id_top', 'nb_user_votes', 'id_ranking', 'current_id_vainkeur'));
    get_template_part( 'templates/parts/content', 'battle' );
    $contenders_html = ob_get_clean();

    ob_start();
    set_query_var('current_user_ranking_var', compact('id_ranking'));
    get_template_part( 'templates/parts/content', 'user-ranking' );
    $user_ranking_html = ob_get_clean();

    ob_start();
    set_query_var( 'steps_var', compact('current_step'));
    get_template_part( 'templates/parts/content', 'step-bar' );
    $stepbar_html = ob_get_clean();

    ob_start();
    set_query_var( 'user_votes_vars', compact( 'nb_user_votes' ) );
    get_template_part( 'templates/parts/content', 'user-votes' );
    $uservotes_html = ob_get_clean();

    $array_ranking  = get_field('ranking_r', $id_ranking);
    $date_done      = get_field('done_date_r', $id_ranking);
    $triche         = get_field('suspected_cheating_r', $id_ranking);

    $response =  array(
        'id_ranking'            => $id_ranking,
        'current_step'          => $current_step,
        'timeline_main'         => $timeline_main,
        'stepbar_html'          => $stepbar_html,
        'contenders_html'       => $contenders_html,
        'uservotes_html'        => $uservotes_html,
        'nb_user_votes'         => $nb_user_votes,
        'user_ranking_html'     => $user_ranking_html,
        'is_next_duel'          => $is_next_duel,
        'current_id_vainkeur'   => $current_id_vainkeur,
        'badge_data'            => $badge_data,
        'toplist'               => $array_ranking,
        'date_done'             => $date_done,
        'triche'                => $triche,
        "classement_url"        => get_permalink($id_ranking)
    );
    $response = array_merge($response, $user_levels_infos);

    return die(json_encode($response));
}
?>