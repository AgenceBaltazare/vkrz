<?php
/*
    Template Name: Best of - creator
*/
get_header();
$best_creators = best_creators();
?>
<div class="app-content content cover">
    <div class="content-overlay"></div>
    <div class="content-wrapper">
        <div class="content-body mt-2">
            <div class="intro-mobile">
                <div class="tournament-heading text-center">
                    <h3 class="mb-0 t-titre-tournoi">
                        Top des créateurs les plus prolifiques <span class="va va-mechanical-arm va-lg"></span>
                    </h3>
                </div>
            </div>
            <div class="classement">
                <div class="container-fluid">
                    <section id="profile-info">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="row" id="table-bordered">
                                    <div class="col-12">
                                        <div class="card">
                                            <div class="card-header justify-content-between align-items-center">
                                                <h4 class="card-title pt-1 pb-1 mb-1 mb-sm-0">
                                                    <span class="t-rose">TOP</span> des créateurs les plus prolifiques <span class="va va-mechanical-arm va-lg"></span>
                                                </h4>
                                                <div class="cta text-right d-flex flex-column">
                                                    <a href="<?php the_permalink(get_page_by_path('recrutement')); ?>/" class="btn btn-primary waves-effect">
                                                        Postuler pour devenir Créateur <br>
                                                        & cumuler des <span class="va va-gem va-md"></span>
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="table-responsive">
                                                <table class="table table-bestcreator">
                                                    <thead>
                                                        <tr>
                                                            <th>
                                                                <span class="va va-chequered-flag va-lg"></span>
                                                            </th>
                                                            <th>
                                                                <span class="va va-man-singer va-lg"></span> <span class="text-muted">Créateur</span>
                                                            </th>
                                                            <th class="text-right">
                                                                <span class="text-muted">Tops créés</span>
                                                            </th>
                                                            <th class="text-right">
                                                                <span class="text-muted">Votes</span>
                                                            </th>
                                                            <th class="text-right">
                                                                <span class="text-muted">Tops générés</span>
                                                            </th>
                                                            <th class="text-right">
                                                                <span class="text-muted">Voir ses Tops</span>
                                                            </th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        $r = 1;
                                                        foreach ($best_creators as $creator) :
                                                            $nb_tops_created = count_user_posts($creator['user_id'], 'tournoi');
                                                            if ($nb_tops_created >= 1) :
                                                        ?>
                                                                <tr>
                                                                    <td>
                                                                        <?php if ($r == 1) : ?>
                                                                            <span class="ico va va-medal-1 va-lg"></span>
                                                                        <?php elseif ($r == 2) : ?>
                                                                            <span class="ico va va-medal-2 va-lg"></span>
                                                                        <?php elseif ($r == 3) : ?>
                                                                            <span class="ico va va-medal-3 va-lg"></span>
                                                                        <?php else : ?>
                                                                            #<?php echo $r; ?>
                                                                        <?php endif; ?>
                                                                    </td>
                                                                    <td>
                                                                        <div class="d-flex align-items-center">
                                                                            <div class="avatar">
                                                                                <span class="avatar-picture" style="background-image: url(<?php echo $creator['user_avatar']; ?>);"></span>
                                                                            </div>
                                                                            <div class="font-weight-bold championname">
                                                                                <span>
                                                                                    <?php echo $creator['user_pseudo']; ?>
                                                                                </span>
                                                                                <span class="ico" data-toggle="tooltip" data-placement="top" title="" data-original-title="Niveau actuel">
                                                                                    <?php echo $creator['user_level_icon']; ?>
                                                                                </span>
                                                                                <?php if ($creator_data['user_role']  == "administrator") : ?>
                                                                                    <span class="ico va va-vkrzteam va-lg" data-toggle="tooltip" data-placement="top" title="" data-original-title="TeamVKRZ">
                                                                                    </span>
                                                                                <?php endif; ?>
                                                                            </div>
                                                                        </div>
                                                                    </td>

                                                                    <td class="text-right">
                                                                        <?php echo $nb_tops_created; ?>
                                                                    </td>

                                                                    <td class="text-right">
                                                                        <?php echo number_format($creator['total_vote'], 0, ",", " "); ?> <span class="ico va-high-voltage va va-lg"></span>
                                                                    </td>

                                                                    <td class="text-right">
                                                                        <?php echo number_format($creator['total_completed_top'], 0, ",", " "); ?> <span class="ico va va-trophy va-lg"></span>
                                                                    </td>

                                                                    <td class="text-right">
                                                                        <a href="<?php the_permalink(218587); ?>?creator_id=<?php echo $creator['user_id']; ?>" class="mr-1 btn btn-outline-primary waves-effect">
                                                                            <span class="va va-eyes va-lg"></span>
                                                                        </a>
                                                                    </td>
                                                                </tr>
                                                        <?php $r++;
                                                            endif;
                                                        endforeach; ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </div>
</div>
<?php get_footer(); ?>