<?php
global $uuiduser;
global $user_full_data;
global $list_t_done;
$list_t_begin     = $user_full_data[0]['list_user_ranking_begin'];
$state            = "";
$id_tournament    = get_the_ID();
$illu             = get_the_post_thumbnail_url($id_tournament, 'medium');
if(is_home() || is_single()){
    $class        = "swiper-slide";
}
elseif(is_archive()){
    $class        = "col-md-4 col-lg-3 col-xxl-2";
}
else{
    $class        = "col-12";
}
if(array_search($id_tournament, array_column($list_t_done, 'id_tournoi')) !== false) {
    $state = "done";
}
elseif(array_search($id_tournament, array_column($list_t_begin, 'id_tournoi')) !== false) {
    $state = "begin";
}
else{
    $state = "todo";
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
        <a href="<?php the_permalink($id_tournament); ?>" class="stretched-link"></a>
    </div>
</div>