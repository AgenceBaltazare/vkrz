<?php
/*
    Template Name: Best of - creator
*/
get_header();
global $vainkeur_data_selected;
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
                                    <th class="text-right">
                                        <span class="text-muted">Guetter</span>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $r = 1;
                                foreach ($best_creators as $creator) :
                                    $nb_tops_created = count_user_posts($creator['user_id'], 'tournoi');
                                    if ($nb_tops_created >= 1) :
                                        $creator_uuiduser       = get_field('uuiduser_user', 'user_' . $creator['user_id']);
                                        $vainkeur_data_selected = get_user_infos($creator_uuiduser);
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
                                                <?php echo $nb_tops_created; ?>
                                            </td>

                                            <td class="text-right">
                                                <?php echo number_format($creator['total_vote'], 0, ",", " "); ?> <span class="ico va-high-voltage va va-lg"></span>
                                            </td>

                                            <td class="text-right">
                                                <?php echo number_format($creator['total_completed_top'], 0, ",", " "); ?> <span class="ico va va-trophy va-lg"></span>
                                            </td>

                                            <td class="text-right">
                                                <a href="<?php the_permalink(218587); ?>?creator_id=<?php echo $creator['user_id']; ?>" class="btn btn-flat-secondary waves-effect" data-toggle="tooltip" data-placement="top" title="" data-original-title="Voir les Tops créés par <?php echo $vainkeur_data_selected['pseudo']; ?>">
                                                    <span class="ico ico-reverse va va-eyes va-lg"></span>
                                                </a>
                                            </td>

                                            <td class="text-right checking-follower">
                                                <?php if (get_current_user_id() != $creator['user_id'] && is_user_logged_in()) : ?>
                                                    <button type="button" id="followBtn" class="btn waves-effect btn-follow d-none" data-userid="<?= get_current_user_id(); ?>" data-uuid="<?= get_field('uuiduser_user', 'user_' . get_current_user_id()); ?>" data-relatedid="<?= $creator['user_id']; ?>" data-relateduuid="<?= get_field('uuiduser_user', 'user_' . $creator['user_id']); ?>" data-text="<?= get_the_author_meta('nickname', get_current_user_id()); ?> te guette !" data-url="<?= get_author_posts_url(get_current_user_id()); ?>">
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
<?php get_footer(); ?>