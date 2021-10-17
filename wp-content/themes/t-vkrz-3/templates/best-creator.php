<?php
/*
    Template Name: Best creator
*/
get_header();

$creators = new WP_User_Query(
    array(
        'number' => -1,
        'role__in' => array('author')
    )
);
$creators = $creators->get_results();

$best_creators = array();
foreach($creators as $user){
    $user_id = $user->ID;

    array_push($best_creators, get_creator_t($user_id));
}

?>
<div class="app-content content cover">
    <div class="content-wrapper">
        <?php
        if (!empty($best_creators)) {
            usort($best_creators, function ($a, $b) {
                return $b['total_completed_top'] <=> $a['total_completed_top'];
            });
            echo "<ol>";
            foreach ($best_creators as $creator) {
                echo "<li>";
                    echo "Creator ".$creator['creator_id']." avec ".$creator['total_completed_top']." tops complets.";
                echo "</li>";
            }
            echo "</ol>";
        }
        ?>
    </div>
</div>
<?php get_footer(); ?>