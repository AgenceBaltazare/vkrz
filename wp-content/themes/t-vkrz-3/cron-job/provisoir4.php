<?php
include __DIR__ . '/../../../../wp-load.php';

$vainkeur = new WP_Query(array(
    'ignore_sticky_posts'    => true,
    'update_post_meta_cache' => false,
    'no_found_rows'          => true,
    'post_type'              => 'vainkeur',
    'orderby'                => 'date',
    'order'                  => 'DESC',
    'posts_per_page'         => -1,
));
while ($vainkeur->have_posts()) : $vainkeur->the_post();

    $id_vainkeur = get_the_ID();

    // Badge : All categories & Complete category
    if (!get_vainkeur_badge($id_vainkeur, "Polyvalence") || !get_vainkeur_badge($id_vainkeur, "Complete category")) {
        $user_tops = get_user_tops();
        $categories = get_terms(
            array(
                "taxonomy" => "categorie",
                "hide_empty" => false,
            )
        );
        $at_least_one_top_by_category = array();
        $complete_category = array();

        foreach ($categories as $category) {
            $at_least_one_top_by_category[$category->term_id] = false;
            $complete_category[$category->term_id]["count"] = $category->count;
            $complete_category[$category->term_id]["done"] = 0;
        }

        foreach ($user_tops["list_user_tops"] as $top) {
            if ($top["state"] == "done") {
                $at_least_one_top_by_category[$top["cat_t"]] = true;
                $complete_category[$top["cat_t"]]["done"] = $complete_category[$top["cat_t"]]["done"] + 1;
            }
        }

        if (!in_array(false, $at_least_one_top_by_category)) {
            update_vainkeur_badge($id_vainkeur, "Polyvalence");
        }

        foreach ($complete_category as $key => $value) {
            if ($value["done"] == $value["count"]) {
                update_vainkeur_badge($id_vainkeur, "Complete category id " . $key);
            }
        }
    }

endwhile;
