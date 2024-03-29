<?php
/*
    Template Name: Best of - vainkeurs
*/
global $uuiduser;
global $vainkeur_data_selected;
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
                <section id="profile-info">
                    <?php if (!empty($vainkeurs)) : ?>
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
                                                <span class="va va-lama va-lg"></span> <span class="text-muted">Vainkeur</span>
                                            </th>
                                            <th class="text-right shorted">
                                                <span class="text-muted">XP <span class="va va-updown va-z-10"></span></span>
                                            </th>
                                            <th class="text-right shorted">
                                                <span class="text-muted">Votes <span class="va va-updown va-z-10"></span></span>
                                            </th>
                                            <th class="text-right shorted">
                                                <span class="text-muted">TopList <span class="va va-updown va-z-10"></span></span>
                                            </th>
                                            <th class="text-right">
                                                <span class="text-muted">Guetter</span>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $r = 1;
                                        foreach ($vainkeurs as $vainkeur) :
                                            $user_id                = $vainkeur["author_id"];
                                            $total_vote             = $vainkeur["total_vote"];
                                            $total_top              = $vainkeur["total_top"];
                                            $xp                     = $vainkeur["xp"];
                                            $uuiduser               = get_field('uuiduser_user', 'user_' . $user_id);
                                            $vainkeur_data_selected = get_user_infos($uuiduser);
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
                                                    <?php get_template_part('partials/vainkeur-card'); ?>
                                                </td>

                                                <td class="text-right">
                                                    <?php echo $xp; ?> <span class="ico va-mush va va-lg"></span>
                                                </td>

                                                <td class="text-right">
                                                    <?php echo $total_vote; ?> <span class="ico va-high-voltage va va-lg"></span>
                                                </td>

                                                <td class="text-right">
                                                    <?php echo $total_top; ?> <span class="ico va va-trophy va-lg"></span>
                                                </td>


                                                <td class="text-right checking-follower">
                                                    <?php if (get_current_user_id() != $user_id && is_user_logged_in()) : ?>
                                                        <button type="button" id="followBtn" class="btn waves-effect btn-follow d-none" data-userid="<?= get_current_user_id(); ?>" data-uuid="<?= get_field('uuiduser_user', 'user_' . get_current_user_id()); ?>" data-relatedid="<?= $user_id; ?>" data-relateduuid="<?= get_field('uuiduser_user', 'user_' . $user_id); ?>" data-text="<?= get_the_author_meta('nickname', get_current_user_id()); ?> te guette !" data-url="<?= get_author_posts_url(get_current_user_id()); ?>">
                                                            <span class="wording">Guetter</span>
                                                            <span class="va va-guetteur-close va va-z-20 emoji"></span>
                                                        </button>
                                                    <?php else : ?>
                                                        <a href="<?php the_permalink(get_page_by_path('se-connecter')); ?>" class="btn btn-flat-secondary waves-effect" data-toggle="tooltip" data-placement="top" title="" data-original-title="Tu dois être connecté pour guetter <?php echo $vainkeur_data_selected['pseudo']; ?>">
                                                            <span class="text-muted">
                                                                Guetter <span class="va va-guetteur-close va va-z-20 emoji"></span>
                                                            </span>
                                                        </a>
                                                    <?php endif; ?>
                                                </td>
                                            </tr>
                                        <?php $r++;
                                        endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    <?php endif; ?>
                </section>
            </div>
        </div>
    </div>
</div>
<?php get_footer(); ?>