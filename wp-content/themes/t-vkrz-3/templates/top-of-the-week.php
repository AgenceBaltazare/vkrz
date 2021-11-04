<?php
/*
    Template Name: Top of the week
*/
get_header();

$latest_rankings = new WP_Query(
    array(
        'post_type'              => 'classement',
        'posts_per_page'         => '-1',
        'fields'                 => 'ids',
        'post_status'            => 'publish',
        'ignore_sticky_posts'    => true,
        'update_post_meta_cache' => false,
        'no_found_rows'          => false,
        'date_query' => array(
            array(
                'column' => 'post_date_gmt',
                'after' => '1 week ago',
            ),
        ),
        'meta_query' => array(
            array(
                'key' => 'done_r',
                'value' => 'done',
                'compare' => '=',
            )
        )
    )
);
$best_tops = best_tops($latest_rankings);
?>
<div class="app-content content cover">
    <div class="content-wrapper">
        <?php
        if (!empty($best_tops)) {
            echo "<ol>";
            foreach (array_slice($best_tops, 0, 20, true) as $top_id => $completed_top_number) {
                echo "<li>";
                    echo "Top n°".$top_id." avec ".$completed_top_number." tops complets.";
                echo "</li>";
            }
            echo "</ol>";
        }
        ?>
    </div>
</div>
<?php get_footer(); ?>