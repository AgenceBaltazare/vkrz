<?php
function get_user_data($request, $uuiduser = false){

    if(!$uuiduser){
        if(isset($_COOKIE["vainkeurz_user_id"])){
            $uuiduser       = $_COOKIE["vainkeurz_user_id"];
        }
        else{
            $uuiduser       = "nouuiduser";
        }
    }

    if($request == "nb-user-vote"){

        $all_user_votes = new WP_Query(array('post_type' => 'vote', 'posts_per_page' => '-1', 'meta_query' => array(
            array(
                'key' => 'id_user_v',
                'value' => $uuiduser,
                'compare' => '=',
            ),
        )));

        $result  = $all_user_votes->post_count;

    }

    return $result;

}

function get_user_top($uuiduser = false, $id_tournament){

    if(!$uuiduser){
        if(isset($_COOKIE["vainkeurz_user_id"])){
            $uuiduser       = $_COOKIE["vainkeurz_user_id"];
        }
        else{
            $uuiduser       = "nouuiduser";
        }
    }

    $user_ranking = new WP_Query(array('post_type' => 'classement', 'posts_per_page' => '1', 'meta_query' => array(
        'relation' => 'AND',
        array(
            'key' => 'uuid_user_r',
            'value' => $uuiduser,
            'compare' => '=',
        ),
        array(
            'key' => 'id_tournoi_r',
            'value' => $id_tournament,
            'compare' => '=',
        ),
    )));
    while ($user_ranking->have_posts()) : $user_ranking->the_post();

        $user_ranking_id = get_the_ID();

    endwhile;

    $user_ranking = get_user_ranking($user_ranking_id);

    return $user_ranking;

}

function get_user_tournament_list($request, $uuiduser = false){

    if(!$uuiduser){
        if(isset($_COOKIE["vainkeurz_user_id"])){
            $uuiduser       = $_COOKIE["vainkeurz_user_id"];
        }
        else{
            $uuiduser       = "nouuiduser";
        }
    }

    if($request == "t-done"){

        $result = array();
        $all_user_ranking = new WP_Query(array('post_type' => 'classement', 'posts_per_page' => '-1', 'meta_query' => array(
            'relation' => 'AND',
            array(
                'key' => 'uuid_user_r',
                'value' => $uuiduser,
                'compare' => '=',
            ),
            array(
                'key' => 'done_r',
                'value' => 'done',
                'compare' => '=',
            ),
        )));
        while ($all_user_ranking->have_posts()) : $all_user_ranking->the_post();

            array_push($result, get_field('id_tournoi_r'));

        endwhile;

    }

    if($request == "t-begin"){

        $result = array();
        $all_user_ranking = new WP_Query(array('post_type' => 'classement', 'meta_key' => 'nb_votes_r', 'orderby' => 'meta_value_num', 'order' => 'DESC', 'posts_per_page' => '-1', 'meta_query' => array(
            array(
                'key' => 'uuid_user_r',
                'value' => $uuiduser,
                'compare' => '=',
            )
        )));
        while ($all_user_ranking->have_posts()) : $all_user_ranking->the_post();

            if(get_field('done_r') == "done"){
                $done = true;
            }
            else{
                $done = false;
            }
            array_push($result, array(
                "id_tournoi" => get_field('id_tournoi_r'),
                "done"       => $done,
                "nb_votes"   => get_field('nb_votes_r'),
                "id_ranking" => get_the_ID(),
            ));

        endwhile;

    }

    return $result;

}

function get_user_ranking_list($request, $uuiduser = false){

    if(!$uuiduser){
        if(isset($_COOKIE["vainkeurz_user_id"])){
            $uuiduser       = $_COOKIE["vainkeurz_user_id"];
        }
        else{
            $uuiduser       = "nouuiduser";
        }
    }

    if($request == "r-done"){

        $result = array();
        $all_user_ranking = new WP_Query(array('post_type' => 'classement', 'orderby' => 'date', 'order' => 'DESC', 'posts_per_page' => '-1', 'meta_query' => array(
            'relation' => 'AND',
            array(
                'key' => 'uuid_user_r',
                'value' => $uuiduser,
                'compare' => '=',
            ),
            array(
                'key' => 'done_r',
                'value' => 'done',
                'compare' => '=',
            ),
        )));
        while ($all_user_ranking->have_posts()) : $all_user_ranking->the_post();

            array_push($result, array(
                "id_tournoi" => get_field('id_tournoi_r'),
                "nb_votes"   => get_field('nb_votes_r'),
                "id_ranking" => get_the_ID(),
            ));

        endwhile;

    }

    if($request == "r-begin"){

        $result = array();
        $all_user_ranking = new WP_Query(array('post_type' => 'classement', 'orderby' => 'date', 'order' => 'DESC', 'posts_per_page' => '-1', 'meta_query' => array(
            'relation' => 'AND',
            array(
                'key' => 'uuid_user_r',
                'value' => $uuiduser,
                'compare' => '=',
            ),
            array(
                'key' => 'done_r',
                'compare' => 'NOT EXISTS',
            ),
        )));
        while ($all_user_ranking->have_posts()) : $all_user_ranking->the_post();

            array_push($result, array(
                "id_tournoi" => get_field('id_tournoi_r'),
                "nb_votes"   => get_field('nb_votes_r'),
                "id_ranking" => get_the_ID(),
            ));

        endwhile;

    }

    if($request == "r-all"){

        $result = array();
        $all_user_ranking = new WP_Query(array('post_type' => 'classement', 'orderby' => 'date', 'order' => 'DESC', 'posts_per_page' => '-1', 'meta_query' => array(
            'relation' => 'AND',
            array(
                'key' => 'uuid_user_r',
                'value' => $uuiduser,
                'compare' => '=',
            )
        )));
        while ($all_user_ranking->have_posts()) : $all_user_ranking->the_post();

            array_push($result, get_the_ID());

        endwhile;

    }

    return $result;

}