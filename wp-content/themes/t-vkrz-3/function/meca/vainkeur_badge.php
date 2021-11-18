<?php

function update_vainkeur_badge($vainkeur_id, $badge_name) {
    $vainkeur_badges = get_the_terms($vainkeur_id, 'badges');
    $badge = get_term_by('name', $badge_name, 'badges');

    if ($vainkeur_badges == false || (is_array($vainkeur_badges) && !in_array($badge, $vainkeur_badges))) {
        wp_set_post_terms($vainkeur_id, $badge_name, 'badges', true);
    }
}

function get_vainkeur_badge($vainkeur_id, $badge_name) {
    $vainkeur_badges = get_the_terms($vainkeur_id, 'badges');
    $badge = get_term_by('name', $badge_name, 'badges');

    if (is_array($vainkeur_badges) && in_array($badge, $vainkeur_badges)) {
        return true;
    }

    return false;
}
