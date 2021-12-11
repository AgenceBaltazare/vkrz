<?php
include __DIR__.'/../../../../wp-load.php';

/**
 * CRON JOB : Update transient "best_creators"
 *
 * When : Everyday @ 03:00
 */

$best_creators = best_creators();

if (!empty(get_transient( 'best_creators' ))) {
    delete_transient( 'best_creators' );
}
set_transient( 'best_creators', $best_creators, DAY_IN_SECONDS );
