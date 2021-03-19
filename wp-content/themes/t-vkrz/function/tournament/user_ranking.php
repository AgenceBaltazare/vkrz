<?php
function do_user_ranking( $id_tournament, $id_winner, $id_looser ) {
	$id_ranking = get_or_create_ranking_if_not_exists( $id_tournament );
    do_vote($id_winner, $id_looser, $id_ranking);
	return get_next_duel( $id_ranking, $id_tournament, $id_winner, $id_looser );
}

function get_next_duel( $id_ranking, $id_tournament) {

	$next_duel               = [];
    $is_next_duel            = true;

    $next_duel = array();

    $list_w_r        = get_field('list_winners_r', $id_ranking);
    if(!$list_w_r){
        $list_w_r    = array();
    }
    $list_l_r        = get_field('list_losers_r', $id_ranking);
    if(!$list_l_r){
        $list_l_r    = array();
    }
    $timeline_votes  = get_field('nb_votes_r', $id_ranking);
    $list_contenders = get_field('ranking_r', $id_ranking);


    // Count contenders
    $nb_contenders      = count($list_contenders);

    // Timeline Main
    if($timeline_votes == $nb_contenders-5){
        update_field('timeline_main', 2, $id_ranking);
    }
    $timeline_main = get_field('timeline_main', $id_ranking);

    if($timeline_main == 1){

        $key_c_1 = $nb_contenders - (1 + $timeline_votes);
        $key_c_2 = $nb_contenders - (6 + $timeline_votes);

        array_push($next_duel, $list_contenders[$key_c_1]['id_wp']);
        array_push($next_duel, $list_contenders[$key_c_2]['id_wp']);

    }

    if($timeline_main == 2){

        $timeline_2      = get_field('timeline_2', $id_ranking);

        foreach($list_contenders as $key => $contender) {

            if($contender['id_wp'] == $list_l_r[$timeline_2 - 1]){
                $key_c1             = $key;
                $list_inf_of_c1     = $contender['more_to'];
                $list_sup_of_c1     = $contender['less_to'];
            }

            if($contender['id_wp'] == $list_l_r[$timeline_2]){
                $key_c2             = $key;
                $list_inf_of_c2     = $contender['more_to'];
                $list_sup_of_c2     = $contender['less_to'];
            }

        }

        $c1_less_more = array_merge($list_inf_of_c1, $list_sup_of_c1);
        $c2_less_more = array_merge($list_inf_of_c2, $list_sup_of_c2);

        if(in_array($key_c1, $c2_less_more) || in_array($key_c2, $c1_less_more)){

            $timeline_2      = $timeline_2 + 1;
            update_field('timeline_2', $timeline_2, $id_ranking);

        }

        array_push($next_duel, $list_l_r[$timeline_2 - 1]);
        array_push($next_duel, $list_l_r[$timeline_2]);
    }

    if($timeline_main == 3){

        $nb_loosers      = count($list_l_r) - 1;

        foreach($list_contenders as $key => $contender) {

            if($contender['id_wp'] == $list_l_r[$nb_loosers]){
                $key_c1             = $key;
                $list_inf_of_c1     = $contender['more_to'];
                $list_sup_of_c1     = $contender['less_to'];
            }

            if($contender['id_wp'] == $list_w_r[count($list_w_r) - 5]){
                $key_c2             = $key;
                $list_inf_of_c2     = $contender['more_to'];
                $list_sup_of_c2     = $contender['less_to'];
            }

        }

        $c1_less_more = array_merge($list_inf_of_c1, $list_sup_of_c1);
        $c2_less_more = array_merge($list_inf_of_c2, $list_sup_of_c2);

        if(in_array($key_c1, $c2_less_more) || in_array($key_c2, $c1_less_more)){

            update_field('timeline_main', 4, $id_ranking);

        }
        else{

            array_push($next_duel, $list_l_r[$nb_loosers]);
            array_push($next_duel, $list_w_r[count($list_w_r) - 5]);

        }

    }

    if($timeline_main == 4){

        $timeline_4      = get_field('timeline_4', $id_ranking);

        foreach($list_contenders as $key => $contender) {

            if($contender['id_wp'] == $list_w_r[$timeline_4 - 1]){
                $key_c1             = $key;
                $list_inf_of_c1     = $contender['more_to'];
                $list_sup_of_c1     = $contender['less_to'];
            }

            if($contender['id_wp'] == $list_w_r[$timeline_4]){
                $key_c2             = $key;
                $list_inf_of_c2     = $contender['more_to'];
                $list_sup_of_c2     = $contender['less_to'];
            }

        }

        $c1_less_more = array_merge($list_inf_of_c1, $list_sup_of_c1);
        $c2_less_more = array_merge($list_inf_of_c2, $list_sup_of_c2);

        if(in_array($key_c1, $c2_less_more) || in_array($key_c2, $c1_less_more)){

            $timeline_4      = $timeline_4 + 1;
            update_field('timeline_4', $timeline_4, $id_ranking);

        }

        array_push($next_duel, $list_w_r[$timeline_4 - 1]);
        array_push($next_duel, $list_w_r[$timeline_4]);

    }

    if($timeline_main == 5){

        $is_same_ratio   = false;
        $is_same_place   = false;
        $c_at_same_place = array();
        $c_at_same_ratio = array();

        // On lance des boucles jusqu'à obtenir le tableau "$next_duel" avec deux valeurs
        // On lance autant de boucle que de participant-1

        for($s = 0; $s <= $nb_contenders-1; $s++){

            // Si le tableau "$next_duel" est supérieur ou égal à deux valeurs alors on stop car nous pouvons faire un nouveau duel
            // Sinon on le remet à zéro
            if(count($c_at_same_place) >= 2){
                break;
            }
            else{
                $c_at_same_place = array();
            }

            // On boucle sur tous les participant et on stocke leur ID global quand leur place est égal à l'incrémentation
            foreach ($list_contenders as $d => $val){

                if($val['place'] == $s){
                    array_push($c_at_same_place, $val['id_wp']);
                }

            }

        }

        array_filter($c_at_same_place);

        if(count($c_at_same_place) >= 2){
            $is_same_place = true;
            array_push($next_duel, $c_at_same_place[0]);
            array_push($next_duel, $c_at_same_place[1]);
        }

        if(!$is_same_place){
            // On lance des boucles jusqu'à obtenir le tableau "$next_duel" avec deux valeurs
            // On lance autant de boucle que de participant-1
            for($s = 0; $s <= $nb_contenders-1; $s++){

                // Si le tableau "$next_duel" est supérieur ou égal à deux valeurs alors on stop car nous pouvons faire un nouveau duel
                // Sinon on le remet à zéro
                if(count($c_at_same_ratio) >= 2){
                    break;
                }
                else{
                    $c_at_same_ratio = array();
                }

                // On boucle sur tous les participant et on stocke leur ID global quand leur place est égal à l'incrémentation
                foreach ($list_contenders as $d => $val){

                    if($val['ratio'] == $s){
                        array_push($c_at_same_ratio, $val['id_wp']);
                    }

                }

            }

            array_filter($c_at_same_ratio);

            if(count($c_at_same_ratio) >= 2){
                $is_same_ratio = true;
                array_push($next_duel, $c_at_same_ratio[0]);
                array_push($next_duel, $c_at_same_ratio[1]);
            }
        }

        if(!$is_same_ratio && !$is_same_place){
            $is_next_duel = false;
            if(!get_field('done_r', $id_ranking)){
                update_field('done_r', 'done', $id_ranking);
                update_field('done_date_r', date('d/m/Y'), $id_ranking);
            }
        }

    }

	$all_votes_counts = all_votes_in_tournament( $id_tournament );
	$nb_user_votes    = all_user_votes_in_tournament( $id_tournament );

	$contender_1      = $next_duel[0];
    $contender_2      = $next_duel[1];

	return compact(
		'is_next_duel',
		'contender_1',
		'contender_2',
		'timeline_main',
		'all_votes_counts',
		'nb_user_votes',
		'nb_contenders',
		'id_tournament'
	);

}

/**
 * Créer un classement pour associer à l'utilisateur et au tournoi si il n'existe pas
 *
 * @param int $id_tournament
 *
 * @return bool|false|int|WP_Error $id_classment_user
 */
function get_or_create_ranking_if_not_exists($id_tournament) {

    $uuiduser = $_COOKIE["vainkeurz_user_id"];
    
    // Get user ranking
    $user_ranking = new WP_Query(array('post_type' => 'classement', 'orderby' => 'date', 'posts_per_page' => '1', 'meta_query' =>
        array(
            'relation'  => 'AND',
            array(
                'key'     => 'id_tournoi_r',
                'value'   => $id_tournament,
                'compare' => '=',
            ),
            array(
                'key' => 'uuid_user_r',
                'value' => $uuiduser,
                'compare' => '=',
            )
        )
    ));
    if($user_ranking->have_posts()){
        while ($user_ranking->have_posts()) : $user_ranking->the_post();
            $id_ranking = get_the_ID();
        endwhile;
    }
    else{
        $new_ranking = array(
            'post_type'   => 'classement',
            'post_title'  => 'T:' . $id_tournament .' U:' . $uuiduser,
            'post_status' => 'publish',
        );
        $id_ranking  = wp_insert_post($new_ranking);

        $list_contenders = array();

        $contenders = new WP_Query(
            array(
                'post_type'      => 'contender',
                'posts_per_page' => -1,
                'meta_key'       => 'ELO_c',
                'orderby'        => 'meta_value_num',
                'order'          => 'DESC',
                'meta_query'     => array(
                    array(
                        'key'     => 'id_tournoi_c',
                        'value'   => $id_tournament,
                        'compare' => 'LIKE',
                    )
                )
            )
        );

        $i=0; while ($contenders->have_posts()) : $contenders->the_post();

            array_push($list_contenders, array(
                "id"                => $i,
                "id_wp"             => get_the_ID(),
                "elo"               => get_field('ELO_c'),
                "c_name"            => get_the_title(),
                "more_to"           => array(),
                "less_to"           => array(),
                "place"             => 0,
                "ratio"             => 0
            ));

            $i++; endwhile;

        update_field('uuid_user_r', $uuiduser, $id_ranking);
        update_field('id_tournoi_r', $id_tournament, $id_ranking);
        update_field("ranking_r", $list_contenders, $id_ranking);
        update_field('nb_votes_r', 0, $id_ranking);
        update_field('timeline_main', 1, $id_ranking);
        update_field('timeline_2', 0, $id_ranking);
        update_field('timeline_4', 1, $id_ranking);

    }

    return $id_ranking;

}

// All total votes in the current tournoi by the current user
function all_user_votes_in_tournament( $id_tournament ) {

	$all_user_votes = new WP_Query( array(
		'post_type'      => 'vote',
		'posts_per_page' => - 1,
		'meta_query'     => array(
			'relation' => 'AND',
			array(
				'key'     => 'id_t_v',
				'value'   => $id_tournament,
				'compare' => '=',
			),
			array(
				'key'     => 'id_user_v',
				'value'   => $_COOKIE['vainkeurz_user_id'],
				'compare' => '=',
			)
		)
	) );

	return $all_user_votes->found_posts;
}

// All total votes in the current tournoi
function all_votes_in_tournament( $id_tournament ) {

	$all_votes = new WP_Query( array(
		'post_type'      => 'vote',
		'posts_per_page' => - 1,
		'meta_query'     => array(
			array(
				'key'     => 'id_t_v',
				'value'   => $id_tournament,
				'compare' => '=',
			)
		)
	) );

	return $all_votes->found_posts;
}


function genrerate_tournament_response($tournament_infos){
	extract($tournament_infos);
	ob_start();
	set_query_var( 'battle_vars', compact( 'contender_1', 'contender_2', 'id_tournament', 'all_votes_counts' ) );
	get_template_part( 'templates/parts/content', 'battle' );

	$contenders_html = ob_get_clean();


	ob_start();
	set_query_var( 'user_votes_vars', compact( 'nb_user_votes' ) );
	get_template_part( 'templates/parts/content', 'user-votes' );
	$uservotes_html = ob_get_clean();

	return die(json_encode( array(
		'contenders_html' => $contenders_html,
		'uservotes_html' => $uservotes_html,
		'all_votes_counts' => $all_votes_counts,
		'is_next_duel' => $is_next_duel
	) ));
}
