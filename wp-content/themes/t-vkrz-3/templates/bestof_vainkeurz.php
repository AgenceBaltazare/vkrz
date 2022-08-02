<?php
/*
    Template Name: Best of - vainkeurs
*/
global $uuiduser;
get_header();
$vainkeurs = get_best_vainkeur("money", NULL, 20);
?>
<div class="app-content content cover">
    <div class="content-overlay"></div>
    <div class="content-wrapper">
        <div class="content-body mt-2">
            <div class="intro-mobile">
                <div class="tournament-heading text-center">
                    <h3 class="mb-0 t-titre-tournoi">
                        Top 20 des Vainkeurs les plus actifs <span class="va va-fire va-lg"></span>
                    </h3>
                </div>
            </div>
            <div class="classement">
                <div class="container-fluid">
                    <section id="profile-info">
                        <div class="row">
                            <div class="col-md-12">
                                <?php
                                if (!empty($vainkeurs)) : ?>
                                    <div class="row" id="table-bordered">
                                        <div class="col-12">
                                            <div class="card">
                                                <div class="card-header">
                                                    <h4 class="card-title pt-1 pb-1">
                                                        <span class="t-rose">TOP 20</span> des Vainkeurs les plus <span>🔥</span>
                                                    </h4>
                                                </div>
                                                <div class="table-responsive">
                                                    <table class="table table-vainkeurz">
                                                        <thead>
                                                            <tr>
                                                                <th>
                                                                    <span class="va va-chequered-flag va-lg"></span>
                                                                </th>
                                                                <th>
                                                                    <span class="va va-llama va-lg"></span> <small class="text-muted">Vainkeur</small>
                                                                </th>
                                                                <th class="text-right">
                                                                    <small class="text-muted">KEURZ</small>
                                                                </th>
                                                                <th class="text-right">
                                                                    <small class="text-muted">Votes effectués</small>
                                                                </th>
                                                                <th class="text-right">
                                                                    <small class="text-muted">TopList</small>
                                                                </th>
                                                                <th class="text-right">
                                                                    <small class="text-muted">Voir</small>
                                                                </th>

                                                                <th class="text-right">
                                                                    <small class="text-muted">Guetter</small>
                                                                </th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <script>
                                                                let idVainkeurProfil
                                                            </script>
                                                            <?php $r = 1;
                                                            foreach ($vainkeurs as $vainkeur) : ?>
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
                                                                            $user_id            = $vainkeur["author_id"];
                                                                            $total_vote         = $vainkeur["total_vote"];
                                                                            $total_top          = $vainkeur["total_top"];
                                                                            $money              = $vainkeur["money"];
                                                                            $uuiduser           = get_field('uuiduser_user', 'user_' . $user_id);
                                                                            $user_infos         = get_user_infos($uuiduser);
                                                                            $avatar             = $user_infos['avatar'];
                                                                            $info_user_level    = get_user_level($user_id);
                                                                            ?>
                                                                            <div class="avatar">
                                                                                <span class="avatar-picture" style="background-image: url(<?php echo $avatar; ?>);"></span>
                                                                                <?php if ($info_user_level) : ?>
                                                                                    <span class="user-niveau">
                                                                                        <?php echo $info_user_level['level_ico']; ?>
                                                                                    </span>
                                                                                <?php endif; ?>
                                                                            </div>
                                                                            <div class="font-weight-bold championname">
                                                                                <span>
                                                                                    <?php echo get_the_author_meta('nickname', $user_id); ?>
                                                                                </span>
                                                                                <?php if ($user_infos['user_role'] == "administrator") : ?>
                                                                                    <span class="ico va va-vkrzteam va-lg" data-toggle="tooltip" data-placement="top" title="" data-original-title="TeamVKRZ">
                                                                                    </span>
                                                                                <?php endif; ?>
                                                                                <?php if ($user_infos['user_role'] == "administrator" || $user_infos['user_role'] == "author") : ?>
                                                                                    <span class="ico va va-man-singer va-lg" data-toggle="tooltip" data-placement="top" title="" data-original-title="Créateur de Tops">
                                                                                    </span>
                                                                                <?php endif; ?>
                                                                            </div>
                                                                        </div>
                                                                    </td>

                                                                    <td class="text-right">
                                                                        <?php echo $money; ?> <span class="ico va-gem va va-lg"></span>
                                                                    </td>

                                                                    <td class="text-right">
                                                                        <?php echo $total_vote; ?> <span class="ico va-high-voltage va va-lg"></span>
                                                                    </td>

                                                                    <td class="text-right">
                                                                        <?php echo $total_top; ?> <span class="ico va va-trophy va-lg"></span>
                                                                    </td>

                                                                    <td class="text-right">
                                                                        <a href="<?php echo esc_url(get_author_posts_url($user_id)); ?>">
                                                                            <span class="va va-eyes va-lg"></span>
                                                                        </a>
                                                                    </td>

                                                                    <?php if (is_user_logged_in()) : ?>
                                                                        <td class="text-right checking-follower">

                                                                            <button type="button" id="followBtn" class="btn btn-warning waves-effect waves-float waves-light" style="display: none;" data-userid="<?= get_current_user_id(); ?>" data-uuid="<?= get_field('uuiduser_user', 'user_' . get_current_user_id()); ?>" data-relatedid="<?= $user_id; ?>" data-relateduuid="<?= $uuiduser_search ?>" data-text="<?= get_the_author_meta('nickname', get_current_user_id()); ?> te guette !" data-url="<?= get_author_posts_url(get_current_user_id()); ?>">
                                                                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-star me-25">
                                                                                    <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon>
                                                                                </svg>
                                                                                <span>Guetter</span>
                                                                            </button>

                                                                        </td>
                                                                    <?php endif; ?>
                                                                </tr>
                                                            <?php $r++;
                                                            endforeach; ?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </div>
</div>
<?php get_footer(); ?>