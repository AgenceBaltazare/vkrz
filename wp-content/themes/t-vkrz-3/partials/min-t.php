<?php
global $user_tops;
global $id_top;
$id_top             = get_the_ID();
$top_datas          = get_top_data($id_top);
$creator_id         = get_post_field('post_author', $id_top);
$creator_uuiduser   = get_field('uuiduser_user', 'user_' . $creator_id);
$creator_data       = get_user_infos($creator_uuiduser);
$list_user_tops     = $user_tops['list_user_tops'];
$state            = "";
$illu             = get_the_post_thumbnail_url($id_top, 'medium');
if (is_home()) {
    $class        = "swiper-slide";
} elseif (is_single()) {
    $class        = "col-md-12 col-6";
} else {
    $class        = "col-12";
}
$user_single_top_data = array_search($id_top, array_column($list_user_tops, 'id_top'));
if ($user_single_top_data !== false) {
    $state = $list_user_tops[$user_single_top_data]['state'];
} else {
    $state = "todo";
}
$get_top_type = get_the_terms($id_top, 'type');
foreach ($get_top_type as $type_top) {
    $type_top = $type_top->slug;
}
?>
<div class="<?php echo $class; ?>">
    <div class="min-tournoi card scaler">
        <div class="cov-illu cover" style="background: url(<?php echo $illu; ?>) center center no-repeat">
            <?php if ($type_top == "sponso") : ?>
                <span class="badge badge-light-rose ml-0">Top sponso</span>
            <?php endif; ?>
            <?php if ($state == "done") : ?>
                <div class="badge badge-success">Terminé</div>
            <?php elseif ($state == "begin") : ?>
                <div class="badge badge-warning">En cours</div>
            <?php else : ?>
                <div class="badge badge-primary">A faire</div>
            <?php endif; ?>
            <div class="voile">
                <?php if ($state == "done") : ?>
                    <div class="spoun">
                        <h5>Voir mon 🏆</h5>
                    </div>
                <?php elseif ($state == "begin") : ?>
                    <div class="spoun">
                        <h5>Terminer</h5>
                    </div>
                <?php else : ?>
                    <div class="spoun">
                        <h5>Faire mon 🏆</h5>
                    </div>
                <?php endif; ?>
            </div>
            <div class="info-top row align-items-center justify-content-center">
                <div class="info-top-col">
                    <div class="infos-card-t info-card-t-v d-flex align-items-center">
                        <div class="d-flex align-items-center mr-10px">
                            <span class="ico va-high-voltage va va-md"></span>
                        </div>
                        <div class="content-body mt-01">
                            <h4 class="mb-0">
                                <?php echo $top_datas['nb_votes']; ?>
                            </h4>
                        </div>
                    </div>
                </div>
                <div class="info-top-col">
                    <div class="infos-card-t d-flex align-items-center">
                        <div class="d-flex align-items-center mr-10px">
                            <span class="ico va va-trophy va-md"></span>
                        </div>
                        <div class="content-body mt-01">
                            <h4 class="mb-0">
                                <?php echo $top_datas['nb_completed_top']; ?>
                            </h4>
                        </div>
                    </div>
                </div>
                <div class="info-top-col hide-xs">
                    <div class="infos-card-t d-flex align-items-center infos-card-t-c">
                        <div class="avatar-infomore">
                            <a href="<?php the_permalink(218587); ?>?creator_id=<?php echo $creator_id; ?>" target="_blank">
                                <div class="avatar me-50">
                                    <img src="<?php echo $creator_data['avatar']; ?>" alt="<?php echo $creator_id; ?>" width="38" height="38">
                                </div>
                            </a>
                        </div>
                        <div class="content-body mt-01">
                            <h4 class="mb-0 link-creator d-flex flex-column text-left">
                                <span class="text-muted">Créé par</span>
                                <a href="<?php the_permalink(218587); ?>?creator_id=<?php echo $creator_id; ?>" target="_blank" class="link-to-creator">
                                    <?php echo $creator_data['pseudo']; ?>
                                </a>
                            </h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body eh mb-3-hover">
            <p class="card-text text-primary">
                TOP <?php echo get_field('count_contenders_t', $id_top); ?> : <?php echo get_the_title($id_top); ?>
            </p>
            <h4 class="card-title">
                <?php the_field('question_t', $id_top); ?>
            </h4>
        </div>
        <a href="<?php the_permalink($id_top); ?>" class="stretched-link"></a>
    </div>
</div>