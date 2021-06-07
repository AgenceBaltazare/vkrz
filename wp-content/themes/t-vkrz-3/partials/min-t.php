<?php
global $uuiduser;
$state            = "";
$id_tournament    = get_the_ID();
$illu             = get_the_post_thumbnail_url($id_tournament, 'medium');
if(is_home()){
    $class        = "swiper-slide";
}
elseif(is_archive()){
    $class        = "col-md-4 col-lg-3 col-xxl-2";
}
else{
    $class        = "col-12";
}
$user_ranking     = new WP_Query(array(
    'post_type' => 'classement',
    'posts_per_page' => '1',
    'ignore_sticky_posts'    => true,
    'update_post_meta_cache' => false,
    'fields'                 => 'ids',
    'no_found_rows'          => true,
    'meta_query' =>
        array(
            'relation'  => 'AND',
            array(
                'key'     => 'id_tournoi_r',
                'value'   => $id_tournament,
                'compare' => '=',
            ),
            array(
                'key' => 'uuid_user_r',
                'value' => $uuiduser,
                'compare' => '=',
            )
        )
    )
);
if($user_ranking->have_posts()){
    while ($user_ranking->have_posts()) : $user_ranking->the_post();
        $id_user_ranking = get_the_ID();
        if(get_field('done_r')){
            $state  = "done";
        }
        else{
            $state = "begin";
        }
    endwhile;
}
?>
<div class="<?php echo $class; ?>">
    <div class="min-tournoi card scaler">
        <div class="cov-illu cover" style="background: url(<?php echo $illu; ?>) center center no-repeat">
            <?php if($state == "done"): ?>
                <div class="badge badge-success">Terminé</div>
            <?php elseif($state == "begin"): ?>
                <div class="badge badge-warning">En cours</div>
            <?php else: ?>
                <div class="badge badge-primary">A faire</div>
            <?php endif; ?>
            <div class="voile">
                <?php if($state == "done"): ?>
                    <div class="spoun">
                        🏆
                        <h5>Voir mon TOP</h5>
                    </div>
                <?php elseif($state == "begin"): ?>
                    <div class="spoun">
                        ⚔️
                        <h5>Terminer</h5>
                    </div>
                <?php else: ?>
                    <div class="spoun">
                        ⚔️
                        <h5>Créer mon Top</h5>
                    </div>
                <?php endif; ?>
            </div>
        </div>
        <div class="card-body eh">
            <p class="card-text text-primary">
                TOP <?php echo get_numbers_of_contenders($id_tournament); ?> : <?php echo get_the_title($id_tournament); ?>
            </p>
            <h4 class="card-title">
                <?php the_field('question_t', $id_tournament); ?>
            </h4>
        </div>
        <?php if($state == "done"): ?>
            <a href="<?php the_permalink($id_user_ranking); ?>" class="stretched-link"></a>
        <?php else: ?>
            <a href="<?php the_permalink($id_tournament); ?>" class="stretched-link"></a>
        <?php endif; ?>
    </div>
</div>