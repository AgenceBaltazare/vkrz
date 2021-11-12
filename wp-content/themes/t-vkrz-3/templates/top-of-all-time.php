<?php
/*
    Template Name: Top of all time
*/
get_header();

$best_tops = get_transient( 'best_tops_of_all_time' );

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