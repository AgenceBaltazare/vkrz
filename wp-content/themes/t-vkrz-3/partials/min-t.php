<?php
global $user_tops;
global $id_top;
$id_top        = get_the_ID();
$top_datas          = get_top_data($id_top);
$list_user_tops   = $user_tops['list_user_tops'];
$state            = "";
$id_top           = get_the_ID();
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
                <span class="badge badge-light-rose ml-0">Top sponsorisé</span>
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
                        🏆
                        <h5>Voir mon TOP</h5>
                    </div>
                <?php elseif ($state == "begin") : ?>
                    <div class="spoun">
                        ⚔️
                        <h5>Terminer</h5>
                    </div>
                <?php else : ?>
                    <div class="spoun">
                        ⚔️
                        <h5>Faire mon Top</h5>
                    </div>
                <?php endif; ?>
            </div>
        </div>
        <div class="card-body eh">
            <p class="card-text text-primary">
                TOP <?php echo get_field('count_contenders_t', $id_top); ?> : <?php echo get_the_title($id_top); ?>
            </p>
            <h4 class="card-title">
                <?php the_field('question_t', $id_top); ?>
            </h4>
        </div>
        <a href="<?php the_permalink($id_top); ?>" class="stretched-link"></a>
        <div class="info-top">
            <div class="card-footer pt-075">
                <div class="row meetings align-items-center m-0">
                    <div class="col-4">
                        <div class="infos-card-t info-card-t-v d-flex align-items-center flex-column">
                            <div class="">
                                <span class="ico va-high-voltage va va-lg"></span>
                            </div>
                            <div class="content-body mt-01">
                                <h4 class="mb-0">
                                    <?php echo $top_datas['nb_votes']; ?>
                                </h4>
                                <p class="text-muted">votes réalisés</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="infos-card-t d-flex align-items-center flex-column">
                            <div class="">
                                <span class="ico va va-trophy va-lg"></span>
                            </div>
                            <div class="content-body mt-01">
                                <h4 class="mb-0">
                                    <?php echo $top_datas['nb_completed_top']; ?>
                                </h4>
                                <p class="text-muted">Tops terminés</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="infos-card-t d-flex align-items-center infos-card-t-c flex-column">
                            <div class="">
                                <a href="<?php the_permalink(218587); ?>?creator_id=<?php echo $creator_id; ?>" target="_blank">
                                    <div class="avatar me-50">
                                        <img src="<?php echo $creator_data['avatar']; ?>" alt="Avatar" width="38" height="38">
                                    </div>
                                </a>
                            </div>
                            <div class="content-body mt-01>
                                <p class="text-muted">Conçu par</p>
                                <h4 class="mb-0 link-creator">
                                    <a href="<?php the_permalink(218587); ?>?creator_id=<?php echo $creator_id; ?>" target="_blank" class="link-to-creator">
                                        <?php echo $creator_data['pseudo']; ?>
                                        <span class="ico" data-toggle="tooltip" data-placement="top" title="" data-original-title="Niveau actuel">
                                            <?php echo $creator_data['level']; ?>
                                        </span>
                                        <?php if ($creator_data['user_role']  == "administrator") : ?>
                                            <span class="ico" data-toggle="tooltip" data-placement="top" title="" data-original-title="TeamVKRZ">
                                                🦙
                                            </span>
                                        <?php endif; ?>
                                        <?php if ($creator_data['user_role']  == "administrator" || $creator_data['user_role'] == "author") : ?>
                                            <span class="ico" data-toggle="tooltip" data-placement="top" title="" data-original-title="Créateur de Tops">
                                                👨‍🎤
                                            </span>
                                        <?php endif; ?>
                                    </a>
                                </h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>