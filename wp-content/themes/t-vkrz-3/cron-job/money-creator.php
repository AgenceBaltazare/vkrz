<?php
include __DIR__ . '/../../../../wp-load.php';
/**
 * CRON JOB : Update money generated by activity for all creators users
 *
 * When : Everyday @ 02:00
 */
$user_query = new WP_User_Query(
    array(
        'number' => -1,
        'role__in' => array('administrator', 'author')
    )
);
$users = $user_query->get_results();
foreach ($users as $user) {
    $user_id = $user->ID;
    $data_t_created = get_creator_t($user_id);
    $creator_money = round(($data_t_created['total_completed_top'] * 5) + ($data_t_created['creator_all_v'] * 0.3) + ($data_t_created['creator_nb_tops'] * 1000));

    $vainkeur_entry = new WP_Query(array(
        'post_type'              => 'vainkeur',
        'posts_per_page'         => '1',
        'fields'                 => 'ids',
        'post_status'            => 'publish',
        'ignore_sticky_posts'    => true,
        'update_post_meta_cache' => false,
        'no_found_rows'          => false,
        'author'                 => $user_id
    ));

    if ($vainkeur_entry->have_posts()) {

        $id_vainkeur    = $vainkeur_entry->posts[0];
        update_field('money_creator_vkrz', $creator_money, $id_vainkeur);

    }
}
