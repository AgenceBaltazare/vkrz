<?php
const VKZR_EVENT_CPT = "vkzr_event";
const VKZR_EVENT_USER_ID_META_KEY = "vkzr_user_id";
const VKZR_EVENT_EVT_TYPE_META_KEY = "vkzr_event_type";

function vkzr_events_scripts()
{
    wp_enqueue_script('script-name', get_template_directory_uri() . '/function/ajax/events.js', array("jquery"), '1.0.0', true);
}

add_action('wp_enqueue_scripts', 'vkzr_events_scripts');

add_action('init', function () {
    register_post_type(VKZR_EVENT_CPT, array(
        'public' => false,
    ));
});

function vkzr_create_event($title, $message, $user_uuid, $event_type = "success")
{
    if (empty($user_uuid)) {
        if (isset($_COOKIE["vainkeurz_user_id"]) && $_COOKIE["vainkeurz_user_id"] != "") {
            $user_uuid = $_COOKIE["vainkeurz_user_id"];
        }
    }
    wp_insert_post([
        'post_type' => VKZR_EVENT_CPT,
        'post_status' => 'publish',
        'post_title' => $title,
        'post_content' => $message,
        'meta_input' => [
            VKZR_EVENT_USER_ID_META_KEY => $user_uuid,
            VKZR_EVENT_EVT_TYPE_META_KEY => $event_type
        ]
    ]);
}

function vkzr_delete_event($event_id)
{
    wp_delete_post($event_id, true);
}

function vkzr_fetch_events()
{
    if (isset($_COOKIE["vainkeurz_user_id"]) && $_COOKIE["vainkeurz_user_id"] != "") {
        $vkzr_cookie = $_COOKIE["vainkeurz_user_id"];
        $events = get_posts(
            [
                'posts_per_page' => -1,
                'post_type' => VKZR_EVENT_CPT,
                'meta_query' => [
                    [
                        'key' => VKZR_EVENT_USER_ID_META_KEY,
                        'value' => $vkzr_cookie,
                        'compare' => '=',
                    ]
                ]
            ]
        );
        $events = array_map(function (WP_Post $ev) {
            return [
                'id' => $ev->ID,
                'title' => $ev->post_title,
                'message' => $ev->post_content,
                'type' => $ev->{VKZR_EVENT_EVT_TYPE_META_KEY}
            ];
        }, $events);

        return die(
        json_encode(
            [
                'events' => $events
            ]
        )
        );
    }
    die(json_encode(["events" => []]));
}

add_action('wp_ajax_nopriv_vkzr_fetch_events', 'vkzr_fetch_events');
add_action('wp_ajax_vkzr_fetch_events', 'vkzr_fetch_events');

function vkzr_remove_seen_event()
{
    vkzr_delete_event($_POST['event_id']);
    return true;
}

add_action('wp_ajax_nopriv_vkzr_remove_seen_event', 'vkzr_remove_seen_event');
add_action('wp_ajax_vkzr_remove_seen_event', 'vkzr_remove_seen_event');






