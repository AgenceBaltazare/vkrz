<?php
function do_user_ranking( $id_tournament, $id_winner, $id_looser ) {
	$id_classement_user = get_or_create_ranking_if_not_exists( $id_tournament );
	return get_next_duel( $id_classement_user, $id_tournament, $id_winner, $id_looser );
}

function get_next_duel( $id_classement_user, $id_tournament, $id_winner = 0, $id_looser = 0 ) {
	$nb_step                 = 5;
	$next_duel               = [];
	$current_date            = date( 'd/m/Y H:i:s' );
	$list_contenders_tournoi = [];
	$deja_sup_to             = [];

	if ( ! $id_classement_user || empty( get_field( 'ranking_r', $id_classement_user ) ) ) {

		// On boucle sur tous les participants du tournoi
		$contenders = new WP_Query( array(
			'post_type'      => 'contender',
			'posts_per_page' => - 1,
			'orderby'        => 'date',
			'order'          => 'ASC',
			'meta_query'     => array(
				array(
					'key'     => 'id_tournoi_c',
					'value'   => $id_tournament,
					'compare' => '=',
				)
			)
		) );
		$i          = 0;
		while ( $contenders->have_posts() ) : $contenders->the_post();

			// On créé le tableau avec tous les participants
			// On initialise : place => 0 // Supérieur => vide
			array_push( $list_contenders_tournoi, array(
				"id"           => $i,
				"id_global"    => get_the_ID(),
				"name"         => get_the_title() . ' (' . get_the_ID() . ')',
				"superieur_to" => array(),
				"place"        => 0
			) );

			$i ++;
		endwhile;

		// On update le champs Rankin du classement de l'utilisateur
		$list_contenders_tournoi = array_filter( $list_contenders_tournoi );
		update_field( 'ranking_r', $list_contenders_tournoi, $id_classement_user );
	} else {
		$list_contenders_tournoi = get_field( 'ranking_r', $id_classement_user );
	}

// On boucle sur le ranking pour connaître la position dans le tableau du gagnant et du perdant
	if ( $id_winner && $id_looser ) {
		foreach ( $list_contenders_tournoi as $key => $contender ) {
			if ( $contender['id_global'] == $id_winner ) {
				$key_gagnant = $key;
			}
			if ( $contender['id_global'] == $id_looser ) {
				$key_perdant = $key;
			}
		}

// On boucle sur le ranking pour connaître tous les participants qui ont l'ID du gagnant dans le tableau de leur paramètre "superieur_to"
// On stocke dans la variable "$deja_sup_to" la liste des participants(keys) qui ont battu le gagnant
		foreach ( $list_contenders_tournoi as $key => $contender ) {
			if ( in_array( $key_gagnant, $contender['superieur_to'] ) ) {
				array_push( $deja_sup_to, $key );
			}
		}

// On ajoute le gagnant dans la liste de ceux qui l'ont déjà battu
		if ( $id_winner ) {
			array_push( $deja_sup_to, $key_gagnant );
		}

// On récupère la liste des participants battu par le perdant du duel
		$list_sup_to_l = $list_contenders_tournoi[ $key_perdant ]['superieur_to'];
	}
// On boucle sur la liste des participant battant le perdant
// Cela inclus le gagnant du duel + tout ceux qui ont déjà battu ce gagnant
	foreach ( array_unique( $deja_sup_to ) as $k ) {

		// On récupère la liste des participants que ce participant bat
		$to_up_sup_to = $list_contenders_tournoi[ $k ]['superieur_to'];

		// On ajoute à cette liste, l'ID du perdant du duel
		array_push( $to_up_sup_to, $key_perdant );

		// Si il s'agit du gagnant du duel alors on fusionne les deux liste des participants battu par le gagnant et le perdant
		// Puis modifie la liste "superieur_to" du gagnant avec cette nouvelle liste
		// Si c'est un autre participant qui a déjà battu le vainkeurz alors on ajoute juste
		$total_sup_to                                  = array_merge( $list_sup_to_l, $to_up_sup_to );
		$list_contenders_tournoi[ $k ]['superieur_to'] = array_unique( $total_sup_to );

		// On compte le nombre de personne que le participant bat
		$count_place = count( array_unique( $to_up_sup_to ) );
		$new_place   = $count_place;
		// On modifie la valeur de sa place avec cette nouvelle valeur
		$list_contenders_tournoi[ $k ]['place'] = $new_place;

	}

// On liste les uniquement les "place" pour obtenir un tableau simple avec les index des participants et leur place
	$id_contender_next = array_column( $list_contenders_tournoi, 'place', 'name' );

// On compte le nombre de participants
	$nb_contenders = count( $list_contenders_tournoi );

// On lance des boucles jusqu'à obtenir le tableau "$next_duel" avec deux valeurs
// On lance autant de boucle que de participant-1
	for ( $s = 0; $s <= $nb_contenders - 1; $s ++ ) {

		// Si le tableau "$next_duel" est supérieur ou égal à deux valeurs alors on stop car nous pouvons faire un nouveau duel
		// Sinon on le remet à zéro
		if ( count( $next_duel ) >= 2 ) {
			$step_number = $s;
			break;
		} else {
			$next_duel = array();
		}

		// On boucle sur tous les participant et on stocke leur ID global quand leur place est égal à l'incrémentation
		foreach ( $list_contenders_tournoi as $d => $val ) {

			if ( $val['place'] == $s ) {
				array_push( $next_duel, $val['id_global'] );
			}

		}

	}

// On en déduits le nombre d'étapes
	$stade_steps = floor( $nb_contenders / $nb_step );
	if ( isset( $step_number ) ) {

		for ( $m = 1; $m <= $nb_step; $m ++ ) {

			if ( $step_number == 0 ) {
				$current_step = "Début du tournoi";
				$body_class   = "debut_tournoi";
				$bar_step     = "debut_tournoi_bar";
				break;
			} elseif ( $step_number <= $stade_steps * $m ) {
				$current_step = "Étape " . $m . " / " . $nb_step;
				$body_class   = "step_" . $m;
				$bar_step     = "step_bar_" . $m;
				break;
			} else {
				$current_step = "Duel final";
				$body_class   = "fin_tournoi";
				$bar_step     = "fin_tournoi_bar";
			}
		}

	} else {
		$current_step = "Début du tournoi";
	}

// On enregistre la mise à jour du champs "Ranking" du classement en cours
	update_field( "ranking_r", $list_contenders_tournoi, $id_classement_user );

// On supprime les valeurs vide du tableau de duels
	$clear_next_duel = array_filter( $next_duel );
// On prend deux participant au hasard dans ce tableau
	$rand_keys = array_rand( $clear_next_duel, 2 );

// Si le tableau à deux valeur alors on peut faire un autre duel avec les IDs des deux participants
// Sinon c'est la fin du classement et on stock dans le champs "done_r" la date de fin
	if ( count( $clear_next_duel ) >= 2 ) {
		$is_next_duel = true;
		$contender_1  = $clear_next_duel[ $rand_keys[0] ];
		$contender_2  = $clear_next_duel[ $rand_keys[1] ];
	} else {
		$is_next_duel = false;
		if ( ! get_field( 'done_r', $id_classement_user ) ) {
			update_field( 'done_r', 'done', $id_classement_user );
			update_field( 'done_date_r', $current_date, $id_classement_user );
		}
	}

	$all_votes_counts = all_votes_in_tournament( $id_tournament );
	$nb_user_votes    = all_user_votes_in_tournament( $id_tournament );

	return compact(
		'is_next_duel',
		'contender_1',
		'contender_2',
		'current_step',
		'body_class',
		'bar_step',
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
function get_or_create_ranking_if_not_exists( $id_tournament ) {
	$classement_perso = new WP_Query( array(
		'post_type'      => 'classement',
		'posts_per_page' => '1',
		'meta_query'     =>
			array(
				'relation' => 'AND',
				array(
					'key'     => 'id_tournoi_r',
					'value'   => $id_tournament,
					'compare' => '=',
				),
				array(
					'key'     => 'uuid_user_r',
					'value'   => $_COOKIE['vainkeurz_user_id'],
					'compare' => '=',
				)
			)
	) );
	if ( $classement_perso->have_posts() ) {
		while ( $classement_perso->have_posts() ) : $classement_perso->the_post();
			$id_classement_user = get_the_ID();
		endwhile;
		wp_reset_postdata();
	} else {
		$new_classement     = array(
			'post_type'   => 'classement',
			'post_title'  => 'T:' . $id_tournament . ' U:' . $_COOKIE['vainkeurz_user_id'],
			'post_status' => 'publish',
		);
		$id_classement_user = wp_insert_post( $new_classement );
		update_field( 'uuid_user_r', $_COOKIE['vainkeurz_user_id'], $id_classement_user );
		update_field( 'id_tournoi_r', $id_tournament, $id_classement_user );
	}

	return $id_classement_user;

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
	$id_tournoi = $id_tournament;
	set_query_var( 'battle_vars', compact( 'contender_1', 'contender_2', 'id_tournoi', 'all_votes_counts' ) );
	get_template_part( 'templates/parts/content', 'battle' );

	$contenders_html = ob_get_clean();

	ob_start();
	set_query_var( 'steps_var', compact( 'bar_step', 'current_step' ) );
	get_template_part( 'templates/parts/content', 'step-bar' );
	$stepbar_html = ob_get_clean();

	ob_start();
	set_query_var( 'user_votes_vars', compact( 'nb_user_votes' ) );
	get_template_part( 'templates/parts/content', 'user-votes' );
	$uservotes_html = ob_get_clean();

	return die(json_encode( array(
		'stepbar_html' => $stepbar_html,
		'contenders_html' => $contenders_html,
		'uservotes_html' => $uservotes_html,
		'all_votes_counts' => $all_votes_counts,
		'is_next_duel' => $is_next_duel
	) ));
}
