<?php
function duplicatator($post_id){

    $post = get_post($post_id);

    $current_user       = wp_get_current_user();
    $new_post_author    = $current_user->ID;

    if ($post) {

        if(get_post_type() == "contender"){
            $status_post = "publish";
        }
        else{
            $status_post = "draft";
        }

        $args = array(
            'comment_status' => $post->comment_status,
            'ping_status'    => $post->ping_status,
            'post_author'    => $new_post_author,
            'post_content'   => $post->post_content,
            'post_excerpt'   => $post->post_excerpt,
            'post_name'      => $post->post_name,
            'post_parent'    => $post->post_parent,
            'post_password'  => $post->post_password,
            'post_status'    => $status_post,
            'post_title'     => $post->post_title,
            'post_type'      => $post->post_type,
            'to_ping'        => $post->to_ping,
            'menu_order'     => $post->menu_order
        );

        $new_post_id = wp_insert_post($args);

        $taxonomies = get_object_taxonomies(get_post_type($post));
        if ($taxonomies) {
            foreach ($taxonomies as $taxonomy) {
                $post_terms = wp_get_object_terms($post_id, $taxonomy, array('fields' => 'slugs'));
                wp_set_object_terms($new_post_id, $post_terms, $taxonomy, false);
            }
        }

        $post_meta = get_post_meta($post_id);
        if ($post_meta) {

            foreach ($post_meta as $meta_key => $meta_values) {

                if ('_wp_old_slug' == $meta_key) {
                    continue;
                }

                foreach ($meta_values as $meta_value) {
                    add_post_meta($new_post_id, $meta_key, $meta_value);
                }
            }
        }

        return $new_post_id;

    }
}
