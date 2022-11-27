<?php
function get_creator_money($creator_id)
{

    $list_creator_score  = array();
    $nb_votes_all_t     = 0;
    $nb_ranks_all_t     = 0;

    $list_tops = new WP_Query(array(
        'post_type'              => 'tournoi',
        'orderby'                => 'date',
        'posts_per_page'         => '-1',
        'ignore_sticky_posts'    => true,
        'update_post_meta_cache' => false,
        'no_found_rows'          => false,
        'author'                 => $creator_id,
        'tax_query' => array(
            array(
                'taxonomy' => 'categorie',
                'field'    => 'slug',
                'terms'    => array('onboarding', 'private', 'whitelabel'),
                'operator' => 'NOT IN',
            )
        ),
        'meta_query' => array(
            array(
                'key'     => 'duplication_top_t',
                'compare' => 'NOT EXISTS',
            ),
        )
    ));
    while ($list_tops->have_posts()) : $list_tops->the_post();

        $id_top                 = get_the_ID();
        $id_resume              = get_resume_id($id_top);
        $nb_votes_t             = intval(get_field('nb_votes_resume', $id_resume));
        $nb_ranks_t             = intval(get_field("nb_done_resume", $id_resume));
        $nb_votes_all_t         = $nb_votes_all_t + $nb_votes_t;
        $nb_ranks_all_t         = $nb_ranks_all_t + $nb_ranks_t;

    endwhile;

    array_push($list_creator_score, array(
        "top_votes"         => $nb_votes_all_t,
        "top_ranks"         => $nb_ranks_all_t,
        "nb_top_created"    => $list_tops->post_count
    ));

    return $list_creator_score;
}

function get_creator_money_for_duplicated($user_id){

    $list_tops = new WP_Query(array(
        'post_type'              => 'tournoi',
        'orderby'                => 'date',
        'posts_per_page'         => '-1',
        'ignore_sticky_posts'    => true,
        'update_post_meta_cache' => false,
        'no_found_rows'          => false,
        'tax_query' => array(
            array(
                'taxonomy' => 'categorie',
                'field'    => 'slug',
                'terms'    => array('onboarding', 'private', 'whitelabel'),
                'operator' => 'NOT IN',
            )
        ),
        'meta_query' => array(
            'relation' => 'AND',
            array(
                'key'     => 'duplication_top_t',
                'compare' => 'EXISTS',
            ),
            array(
                'key'     => 'duplication_createur_t',
                'value'   => $user_id,
                'type'    => 'numeric',
                'compare' => '=',
            ),
        )
    ));
    
    while ($list_tops->have_posts()) : $list_tops->the_post();

        $id_top                 = get_the_ID();
        $nb_contenders          = get_field('count_contenders_t', $id_top);

    endwhile;

    $total_money                = 500 + $nb_contenders * 50;

    return array(
        "money_duplicated"     => $total_money,
        "nb_top_duplicated"    => $list_tops->post_count
    );

}