<?php
function get_user_data($request, $uuiduser){

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

function get_global_data($request, $id_tournament){

    if($request == "nb-tournoi"){

        $tournoi = new WP_Query(array('post_type' => 'tournoi', 'posts_per_page' => '-1'));

        $result  = $tournoi->post_count;

    }

    elseif($request == "nb-user" || $request == "nb-vote"){

        if($id_tournament){
            $votes = new WP_Query( array(
                'post_type'      => 'vote',
                'posts_per_page' => -1,
                'meta_query'     => array(
                    array(
                        'key'     => 'id_t_v',
                        'value'   => $id_tournament,
                        'compare' => '=',
                    )
                )
            ));
        }
        else{
            $votes   = new WP_Query(array('post_type' => 'vote', 'posts_per_page' => '-1'));
        }

        if($request == "nb-user"){

            $list_uuid = array();

            while($votes->have_posts()) : $votes->the_post();

                array_push($list_uuid, get_field('id_user_v'));

            endwhile;

            $list_uuid = array_unique($list_uuid);

            $result    = count($list_uuid);

        }
        elseif($request == "nb-vote"){

            $result  = $votes->post_count;

        }

    }

    if($request == "nb-ranking"){

        if($id_tournament){
            $ranking   = new WP_Query(array('post_type' => 'classement', 'posts_per_page' => '-1', 'meta_query'     => array(
                'relation' => 'AND',
                array(
                    'key'     => 'id_tournoi_r',
                    'value'   => $id_tournament,
                    'compare' => '=',
                )
            )));
        }
        else{
            $ranking = new WP_Query(array('post_type' => 'classement', 'posts_per_page' => '-1'));
        }

        $result  = $ranking->post_count;

    }

    if($request == "nb-ranking-done"){

        if($id_tournament){
            $ranking_done   = new WP_Query(array('post_type' => 'classement', 'posts_per_page' => '-1', 'meta_query'     => array(
                'relation' => 'AND',
                array(
                    'key'     => 'id_tournoi_r',
                    'value'   => $id_tournament,
                    'compare' => '=',
                ),
                array(
                    'key' => 'done_r',
                    'value' => 'done',
                    'compare' => '=',
                ),
            )));
        }
        else{
            $ranking_done = new WP_Query(array('post_type' => 'classement', 'posts_per_page' => '-1', 'meta_query' => array(
                array(
                    'key' => 'done_r',
                    'value' => 'done',
                    'compare' => '=',
                ),
            )));
        }

        $result  = $ranking_done->post_count;

    }

    return $result;

}

function get_vote_data($request, $id_tournament){

    if($id_tournament){
        $votes = new WP_Query( array(
            'post_type'      => 'vote',
            'posts_per_page' => -1,
            'meta_query'     => array(
                array(
                    'key'     => 'id_t_v',
                    'value'   => $id_tournament,
                    'compare' => '=',
                )
            )
        ));
    }
    else{
        $votes   = new WP_Query(array('post_type' => 'vote', 'posts_per_page' => '-1'));
    }

    $list_uuid = array();

    while($votes->have_posts()) : $votes->the_post();

        array_push($list_uuid, get_field('id_user_v'));

    endwhile;

    $users_votes        = array_count_values($list_uuid);

    if($id_tournament){
        $moy_vote_by_user   = round(get_global_data('nb-vote', $id_tournament) / get_global_data('nb-user', $id_tournament));
    }
    else{
        $moy_vote_by_user   = round(get_global_data('nb-vote', false) / get_global_data('nb-user', false));
    }

    if($request == "moy-vote"){

        return $moy_vote_by_user;

    }

    if($request == "more-moy"){

        $count_sup_moy = 0;
        foreach($users_votes as $user => $v){

            if($v >= $moy_vote_by_user){

                $count_sup_moy++;

            }

        }

        return $count_sup_moy;

    }

    if($request == "less-ten"){

        $lessten = 0;
        foreach($users_votes as $user => $v){

            if($v < 15){

                $lessten++;

            }

        }

        return $lessten;

    }

    if($request == "best-ninja"){

        rsort($users_votes);

        $i=0; foreach($users_votes as $item => $v){
            if($i==0){
                $bestninja = $v;
            }
            $i++;
        }

        return $bestninja;

    }

}