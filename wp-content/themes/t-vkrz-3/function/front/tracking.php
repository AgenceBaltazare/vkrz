<?php

//Enqueue variables to be available in a JS context :
function vkrz_tracking_vars()
{
    $current_post_type = get_post_type();
    global $user_id;
    global $uuiduser;
    global $utm;

    $user_id = get_current_user_id();

    vkrz_output_tracking_vars_in_head("vkrz_tracking_vars_user", [
        'uuiduser_layer' => $uuiduser,
        'id_user_layer' => $user_id,
        'utm' => $utm
    ]);

    global $post;

    $pageVars = [
        "page_title" => "",
        "page_category" => ""
    ];

    if (is_home()) {
        $pageVars = [
            "page_title" => "Home",
            "page_category" => ""
        ];

    } elseif (is_archive()) {
        $pageVars = [
            "page_title" => wp_strip_all_tags(get_the_archive_title()),
            "page_category" => ""
        ];
    } elseif (is_single()) {

        if($current_post_type == "tournoi"){
            $post_id = get_the_ID();
        } elseif($current_post_type == "classement"){
            $post_id = get_field('id_tournoi_r');
        }else{
            $post_id = get_the_ID();
        }


        $taxs = get_object_taxonomies(get_post($post_id));
        $terms = [];
        foreach ($taxs as $tax) {
            foreach (get_the_terms($post_id, $tax) as $term) {
                $terms[] = $term->name;
            }
        }

        $pageTitle = get_the_title();
        if(in_array($current_post_type, ["classement", "tournoi"])){
            global $top_infos;
            $pageTitle = $top_infos['top_title'] . " " . $top_infos['top_number'] . " - " . $top_infos['top_question'];
        }

        $pageVars = [
            "page_title" => $pageTitle,
            "page_category" => join(", ", $terms)
        ];
    }else{
        $pageVars = [
            "page_title" => $post->post_title,
            "page_category" => ""
        ];
    }


    vkrz_output_tracking_vars_in_head("vkrz_tracking_vars_current_page", $pageVars);

    $current_post_type = get_post_type();
    // Tracking Classement:
    if (is_single() && in_array($current_post_type, ["classement", "tournoi"])) {
        global $id_top;
        global $top_infos;
        global $user_infos;

        if($current_post_type == "tournoi"){
            $id_top = get_the_ID();
        }
        elseif($current_post_type == "classement"){
            $id_top = get_field('id_tournoi_r');
        }

        vkrz_output_tracking_vars_in_head('vkrz_tracking_vars_top', [
            'top_title_layer' => $top_infos['top_title'] . " " . $top_infos['top_number'] . " - " . $top_infos['top_question'],
            'top_categorie_layer' => !empty($top_infos['top_cat']) ? $top_infos['top_cat'][0]->name : "",
            'top_id_top_layer' => $id_top,
            'top_user_level_layer' => $user_infos['level_number'],
            'top_type_layer' => $top_infos['top_type'],
            'utm_layer' => $utm,
        ]);
    }
}

add_action('wp_head', 'vkrz_tracking_vars');

add_action('init', function () {
    if (isset($_GET['autologin']) && isset($_GET['uid']) && isset($_REQUEST['_wpnonce'])) {
        $uid = absint($_GET['uid']);
        var_dump($uid);
        die;
    }
});


function vkrz_output_tracking_vars_in_head($object_name, $vars, $echo = true)
{

    if (empty($object_name))
        return "";

    ob_start(); ?>
    <script>
        let <?= $object_name ?> = <?= json_encode($vars) ?>;
    </script>
    <?php

    if ($echo) {
        echo ob_get_clean();
        return "";
    }
    return ob_get_clean();


}
