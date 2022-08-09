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
                                                            <?php $r = 1;
                                                            foreach ($vainkeurs as $vainkeur) :
                                                                $user_id            = $vainkeur["author_id"];
                                                                $total_vote         = $vainkeur["total_vote"];
                                                                $total_top          = $vainkeur["total_top"];
                                                                $uuiduser           = get_field('uuiduser_user', 'user_' . $user_id);
                                                                $user_infos         = get_user_infos($uuiduser);
                                                                $avatar             = $user_infos['avatar'];
                                                                $info_user_level    = get_user_level($user_id);
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
                                                                        <span class="avatar">
                                                                            <a href="<?php echo esc_url(get_author_posts_url($user_id)); ?>">
                                                                                <span class="avatar-picture" style="background-image: url(<?php echo $user_infos['avatar']; ?>);"></span>
                                                                            </a>
                                                                            <span class="user-niveau">
                                                                                <?php echo $user_infos['level']; ?>
                                                                            </span>
                                                                        </span>
                                                                        <span class="font-weight-bold championname">
                                                                            <a href="<?php echo esc_url(get_author_posts_url($user_id)); ?>">
                                                                                <?php echo $user_infos['pseudo']; ?>
                                                                                <?php if ($user_infos) : ?>
                                                                                    <span class="user-niveau-xs">
                                                                                        <?php echo $user_infos['level']; ?>
                                                                                    </span>
                                                                                <?php endif; ?>
                                                                                <?php if ($user_infos['user_role'] == "administrator") : ?>
                                                                                    <span class="ico va va-vkrzteam va-lg" data-toggle="tooltip" data-placement="top" title="" data-original-title="TeamVKRZ">
                                                                                    </span>
                                                                                <?php endif; ?>
                                                                                <?php if ($user_infos['user_role'] == "administrator" || $user_infos['user_role'] == "author") : ?>
                                                                                    <span class="ico va va-man-singer va-lg" data-toggle="tooltip" data-placement="top" title="" data-original-title="Créateur de Tops">
                                                                                    </span>
                                                                                <?php endif; ?>
                                                                            </a>
                                                                        </span>
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

                                                                    <td class="text-right checking-follower">
                                                                        <?php if (get_current_user_id() != $user_id && is_user_logged_in()) : ?>
                                                                            <button 
                                                                                type="button" 
                                                                                id="followBtn" 
                                                                                class="btn waves-effect btn-follow d-none" 
                                                                                data-userid="<?= get_current_user_id(); ?>" 
                                                                                data-uuid="<?= get_field('uuiduser_user', 'user_' . get_current_user_id()); ?>" 
                                                                                data-relatedid="<?= $user_id; ?>" 
                                                                                data-relateduuid="<?= get_field('uuiduser_user', 'user_' . $user_id); ?>" 
                                                                                data-text="<?= get_the_author_meta('nickname', get_current_user_id()); ?> te guette !" 
                                                                                data-url="<?= get_author_posts_url(get_current_user_id()); ?>"
                                                                            >
                                                                                <span class="mr-10p wording">Guetter</span>
                                                                                <span class="va va-guetteur-close va va-z-20 emoji"></span>
                                                                            </button>
                                                                        <?php endif; ?>
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