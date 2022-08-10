<?php

function update_vainkeur_badge($id_vainkeur, $badge_name) {

    $vainkeur_badges = get_the_terms($id_vainkeur, 'badges');
    $badge           = get_term_by('name', $badge_name, 'badges');

    if ($vainkeur_badges == false || (is_array($vainkeur_badges) && !in_array($badge, $vainkeur_badges))) {
        
        wp_set_post_terms($id_vainkeur, $badge_name, 'badges', true);
        
        // Increase user total money
        $recompense_badge  = get_field('recompense_badge', 'badges_' . $badge->term_id);
        $user_money        = get_field('money_vkrz', $id_vainkeur);
        update_field('money_vkrz', $user_money + $recompense_badge, $id_vainkeur);
        
    }

    if (is_user_logged_in()) {
        check_user_level($id_vainkeur);
    }

    
}

function get_vainkeur_badge($vainkeur_id, $badge_name) {
    $vainkeur_badges = get_the_terms($vainkeur_id, 'badges');
    $badge           = get_term_by('name', $badge_name, 'badges');

    if (is_array($vainkeur_badges) && in_array($badge, $vainkeur_badges)) {
        return true;
    }

    return false;
}
