<?php
function genrerate_tournament_response($tournament_infos){
    extract($tournament_infos);

    ob_start();
    set_query_var( 'battle_vars', compact( 'contender_1', 'contender_2', 'id_tournament', 'nb_user_votes' ) );
    get_template_part( 'templates/parts/content', 'battle' );
    $contenders_html = ob_get_clean();

    ob_start();
    set_query_var('current_user_ranking_var', compact('id_ranking', 'id_tournament'));
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


    return die(json_encode( array(
        'id_ranking'        => $id_ranking,
        'current_step'      => $current_step,
        'timeline_main'     => $timeline_main,
        'stepbar_html'      => $stepbar_html,
        'contenders_html'   => $contenders_html,
        'uservotes_html'    => $uservotes_html,
        'all_votes_counts'  => $all_votes_counts,
        'nb_user_votes'     => $nb_user_votes,
        'user_ranking_html' => $user_ranking_html,
        'is_next_duel'      => $is_next_duel
    ) ));
}
?>