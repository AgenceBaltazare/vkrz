<?php
$state            = "";
$id_tournament    = get_the_ID();
$id_user_ranking  = 0;
$uuiduser         = $_COOKIE["vainkeurz_user_id"];
if(is_home()){
    $class        = "swiper-slide";
}
else{
    $class        = "col-md-4 col-xl-2 col-lg-3";
}
$user_ranking     = new WP_Query(array('post_type' => 'classement', 'orderby' => 'date', 'posts_per_page' => '1', 'meta_query' =>
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
));
if($user_ranking->have_posts()){
    while ($user_ranking->have_posts()) : $user_ranking->the_post();
        $id_user_ranking = get_the_ID();
    endwhile;
    if(get_field('done_r', $id_user_ranking)){
        $state  = "done";
    }
    else{
        $state = "begin";
    }
}
?>
<div class="<?php echo $class; ?>">
    <div class="min-tournoi card scaler">
        <?php
        if (has_post_thumbnail()){
            $illu = get_the_post_thumbnail_url(get_the_ID(), 'medium');
        }
        ?>
        <div class="cov-illu cover" style="background: url(<?php echo $illu; ?>) center center no-repeat">
            <?php if($state == "done"): ?>
                <div class="badge badge-success">Terminé</div>
            <?php elseif($state == "begin"): ?>
                <div class="badge badge-warning">En cours</div>
            <?php else: ?>
                <div class="badge badge-primary">A faire</div>
            <?php endif; ?>
            <div class="voile">
                <div class="spoun">
                    ⚔️
                    <h5>Créer mon TOP</h5>
                </div>
            </div>
        </div>
        <div class="card-body eh">
            <p class="card-text text-primary">
                TOP <?php echo get_numbers_of_contenders($id_tournament); ?> : <?php the_title(); ?>
            </p>
            <h4 class="card-title">
                <?php the_field('question_t'); ?>
            </h4>
        </div>
        <?php if($state == "done"): ?>
            <a href="<?php the_permalink($id_user_ranking); ?>" class="stretched-link"></a>
        <?php else: ?>
            <a href="<?php the_permalink(); ?>" class="stretched-link"></a>
        <?php endif; ?>
    </div>
</div>