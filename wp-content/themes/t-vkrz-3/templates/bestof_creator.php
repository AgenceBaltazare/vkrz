<?php
/*
    Template Name: Best of - creator
*/
get_header();
$creators = new WP_User_Query(
    array(
        'number' => -1,
        'role__in' => array('author', 'administrator')
    )
);
$creators = $creators->get_results();
$best_creators = array();
foreach ($creators as $user) {
    $user_id = $user->ID;
    array_push($best_creators, get_creator_t($user_id));
}
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
                                            <div class="card-header">
                                                <h4 class="card-title pt-1 pb-1">
                                                    <span class="t-rose">TOP</span> des créateurs les plus prolifiques <span class="va va-mechanical-arm va-lg"></span>
                                                </h4>
                                            </div>
                                            <div class="table-responsive">
                                                <table class="table">
                                                    <thead>
                                                        <tr>
                                                            <th>
                                                                <span class="va va-chequered-flag va-lg"></span>
                                                            </th>
                                                            <th>
                                                                <span class="va va-prince va-lg"></span>
                                                            </th>
                                                            <th class="text-right">
                                                                <span class="va va-gem va-lg"></span>
                                                            </th>
                                                            <th class="text-right">
                                                                <span class="va va-trophy va-lg"></span>
                                                            </th>
                                                            <th>
                                                                <span class="va va-eyes va-lg"></span>
                                                            </th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        $r = 1;
                                                        usort($best_creators, function ($a, $b) {
                                                            return $b['total_completed_top'] <=> $a['total_completed_top'];
                                                        });
                                                        foreach ($best_creators as $creator) : 
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
                                                                        <?php
                                                                        $creator_uuiduser   = get_field('uuiduser_user', 'user_' . $creator['creator_id']);
                                                                        $creator_data       = get_user_infos($creator_uuiduser);
                                                                        $data_t_created     = get_transient('user_' . $creator['creator_id'] . '_get_creator_t');
                                                                        ?>
                                                                        <div class="avatar">
                                                                            <span class="avatar-picture" style="background-image: url(<?php echo $creator_data['avatar']; ?>);"></span>
                                                                            <?php if ($info_user_level) : ?>
                                                                                <span class="user-niveau">
                                                                                    <?php echo $info_user_level['level_ico']; ?>
                                                                                </span>
                                                                            <?php endif; ?>
                                                                        </div>
                                                                        <div class="font-weight-bold championname">
                                                                            <span>
                                                                                <?php echo $creator_data['pseudo']; ?>
                                                                            </span>
                                                                            <span class="ico" data-toggle="tooltip" data-placement="top" title="" data-original-title="Niveau actuel">
                                                                                <?php echo $creator_data['level']; ?>
                                                                            </span>
                                                                            <?php if ($creator_data['user_role']  == "administrator") : ?>
                                                                                <span class="ico va va-llama va-lg" data-toggle="tooltip" data-placement="top" title="" data-original-title="TeamVKRZ">
                                                                                </span>
                                                                            <?php endif; ?>
                                                                        </div>
                                                                    </div>
                                                                </td>

                                                                <td class="text-right">
                                                                    <?php echo number_format($data_t_created['creator_all_v'], 0, ",", " "); ?> <span class="ico va va-gem va-lg"></span>
                                                                </td>

                                                                <td class="text-right">
                                                                    <?php echo number_format($creator['total_completed_top'], 0, ",", " "); ?> <span class="ico va va-trophy va-lg">🏆</span>
                                                                </td>

                                                                <td>
                                                                    <a href="<?php the_permalink(218587); ?>?creator_id=<?php echo $creator_id; ?>" class="mr-1 btn btn-outline-primary waves-effect">
                                                                        Voir le profil
                                                                    </a>
                                                                </td>
                                                            </tr>
                                                        <?php $r++;
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