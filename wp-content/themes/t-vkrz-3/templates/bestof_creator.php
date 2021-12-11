<?php
/*
    Template Name: Best of - creator
*/
get_header();

$best_creators = get_transient('best_creators');

?>
<div class="app-content content cover">
    <div class="content-overlay"></div>
    <div class="content-wrapper">
        <div class="content-body mt-2">
            <div class="intro-mobile">
                <div class="tournament-heading text-center">
                    <h3 class="mb-0 t-titre-tournoi">
                        Top des créateurs les plus prolifiques <span>🦾</span>
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
                                            <div class="card-header">
                                                <h4 class="card-title pt-1 pb-1">
                                                    <span class="t-rose">TOP</span> des créateurs les plus prolifiques <span>🦾</span>
                                                </h4>
                                            </div>
                                            <div class="table-responsive">
                                                <table class="table">
                                                    <thead>
                                                        <tr>
                                                            <th>🏁</th>
                                                            <th>🤴</th>
                                                            <th class="text-right">💎</th>
                                                            <th class="text-right">🏆</th>
                                                            <th>👀</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        $i = 1;

                                                        foreach ($best_creators as $creator):
                                                        ?>
                                                            <tr>
                                                                <td>
                                                                    <?php if ($i == 1) : ?>
                                                                        <span class="ico">🥇</span>
                                                                    <?php elseif ($i == 2) : ?>
                                                                        <span class="ico">🥈</span>
                                                                    <?php elseif ($i == 3) : ?>
                                                                        <span class="ico">🥉</span>
                                                                    <?php else : ?>
                                                                        #<?php echo $i; ?>
                                                                    <?php endif; ?>
                                                                </td>
                                                                <td>
                                                                    <div class="d-flex align-items-center">
                                                                        <div class="avatar">
                                                                            <span class="avatar-picture" style="background-image: url(<?php //echo $creator['user_avatar']; ?>);"></span>
                                                                        </div>
                                                                        <div class="font-weight-bold championname">
                                                                            <span>
                                                                                <?php echo $creator['user_pseudo']; ?>
                                                                            </span>
                                                                            <span class="ico" data-toggle="tooltip" data-placement="top" title="" data-original-title="Niveau actuel">
                                                                                <?php echo $creator['user_level_icon']; ?>
                                                                            </span>
                                                                            <?php if ($creator['user_role']  == "administrator") : ?>
                                                                                <span class="ico" data-toggle="tooltip" data-placement="top" title="" data-original-title="TeamVKRZ">
                                                                                    🦙
                                                                                </span>
                                                                            <?php endif; ?>
                                                                        </div>
                                                                    </div>
                                                                </td>

                                                                <td class="text-right">
                                                                    <?php echo number_format($creator['total_vote'], 0, ",", " "); ?> <span class="ico">💎</span>
                                                                </td>

                                                                <td class="text-right">
                                                                    <?php echo number_format($creator['total_completed_top'], 0, ",", " "); ?> <span class="ico">🏆</span>
                                                                </td>

                                                                <td>
                                                                    <a href="<?php the_permalink(218587); ?>?creator_id=<?php echo $creator['user_id']; ?>" class="mr-1 btn btn-outline-primary waves-effect">
                                                                        Voir le profil
                                                                    </a>
                                                                </td>
                                                            </tr>
                                                        <?php $i++;
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