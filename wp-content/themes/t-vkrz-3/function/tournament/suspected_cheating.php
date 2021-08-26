<?php

function suspected_cheating($start, $end, $battle_count) {
    $warning_battle_time = 2; // in seconds

    $interval = strtotime($end) - strtotime($start);
    $average_time_by_battle = $interval / $battle_count;

    if ($average_time_by_battle <= $warning_battle_time && $interval > 0) {
        return true;
    }

    return false;
}
