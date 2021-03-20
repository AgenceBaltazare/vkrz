<?php
function genrerate_tournament_response($tournament_infos){
    extract($tournament_infos);

    ob_start();
    set_query_var( 'battle_vars', compact( 'contender_1', 'contender_2', 'id_tournament', 'all_votes_counts' ) );
    get_template_part( 'templates/parts/content', 'battle' );
    $contenders_html = ob_get_clean();

    ob_start();
    set_query_var( 'steps_var', compact('timeline_main', 'current_step'));
    get_template_part( 'templates/parts/content', 'step-bar' );
    $stepbar_html = ob_get_clean();

    ob_start();
    set_query_var( 'user_votes_vars', compact( 'nb_user_votes' ) );
    get_template_part( 'templates/parts/content', 'user-votes' );
    $uservotes_html = ob_get_clean();


    return die(json_encode( array(
        'current_step' => $current_step,
        'stepbar_html' => $stepbar_html,
        'contenders_html' => $contenders_html,
        'uservotes_html' => $uservotes_html,
        'all_votes_counts' => $all_votes_counts,
        'is_next_duel' => $is_next_duel
    ) ));
}
?>