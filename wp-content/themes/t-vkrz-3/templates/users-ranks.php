<?php
/*
    Template Name: Users Ranks
*/
if (isset($_GET['id_top'])) {
    $id_top  = $_GET['id_top'];
} else {
    header('Location: ' . get_bloginfo('url'));
}
get_header();
global $id_vainkeur;
global $count_toplist;
$top_datas = get_top_data($id_top);
if ($id_vainkeur) {
    if (is_user_logged_in() && env() != "local") {
        if (false === ($user_tops = get_transient('user_' . $user_id . '_get_user_tops'))) {
            $user_tops = get_user_tops($id_vainkeur);
            set_transient('user_' . $user_id . '_get_user_tops', $user_tops, DAY_IN_SECONDS);
        } else {
            $user_tops = get_transient('user_' . $user_id . '_get_user_tops');
        }
    } else {
        $user_tops  = get_user_tops($id_vainkeur);
    }
    $list_user_tops         = $user_tops['list_user_tops_done_ids'];
} else {
    $list_user_tops       = array();
}
$id_resume            = get_resume_id($id_top);
$list_toplist         = json_decode(get_field('all_toplist_resume', $id_resume));
$list_toplist         = array_reverse($list_toplist);
$count_toplist        = count($list_toplist);
?>
<div class="app-content content">
    <div class="content-overlay"></div>
    <div class="content-wrapper">
        <div class="content-body mt-2">

            <div class="intro-mobile">
                <div class="tournament-heading text-center">
                    <h3 class="mb-0 t-titre-tournoi">
                        Liste de tous les Tops <?php echo $top_infos['top_number']; ?> <span class="ico text-center va va-trophy va-lg"></span> <?php echo $top_infos['top_title']; ?>
                    </h3>
                    <h4 class="mb-0">
                        <?php echo $top_infos['top_question']; ?>
                    </h4>
                </div>
            </div>

            <div class="classement users-ranks">
                <div class="row">
                    <div class="col-md-8">
                        <section id="profile-info">
                            <?php if ($list_toplist) : ?>
                                <div class="row" id="table-bordered">
                                    <div class="col-12">
                                        <div class="card">
                                            <div class="card-datatable table-responsive">
                                                <table class="table-listuserranks">
                                                    <thead>
                                                        <tr>
                                                            <th>
                                                                <span class="text-muted">
                                                                    <span class="t-rose"><?php echo $count_toplist; ?></span> TopList
                                                                </span>
                                                            </th>
                                                            <th>
                                                                <span class="text-muted">
                                                                    Podium
                                                                </span>
                                                            </th>
                                                            <th class="text-center shorted">
                                                                <span class="text-muted">% de ressemblance <span class="va va-updown va-z-15"></span></span>
                                                            </th>
                                                            <th class="text-center">
                                                                <span class="text-muted">
                                                                    Action
                                                                </span>
                                                            </th>
                                                            <th class="text-right">
                                                                <span class="text-muted">
                                                                    Guetter
                                                                </span>
                                                            </th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php foreach (array_slice($list_toplist, 0, 500) as $id_ranking) :
                                                            $uuiduser                = get_field('uuid_user_r', $id_ranking);
                                                            $vainkeur_data_selected  = get_user_infos($uuiduser);
                                                            if ($vainkeur_data_selected['user_role'] != "anonyme") : ?>
                                                                <tr id="rows" class="<?php echo "uuid" . $uuiduser; ?> uncalculated" data-idranking="<?= $id_ranking; ?>">
                                                                    <td class="vainkeur-table">
                                                                        <span class="avatar">
                                                                            <?php if ($vainkeur_data_selected) : ?>
                                                                                <a href="<?php echo esc_url(get_author_posts_url($vainkeur_data_selected['id_user'])); ?>">
                                                                                    <span class="avatar-picture" style="background-image: url(<?php echo $vainkeur_data_selected['avatar']; ?>);"></span>
                                                                                </a>
                                                                                <?php if ($vainkeur_data_selected) : ?>
                                                                                    <span class="user-niveau">
                                                                                        <?php echo $vainkeur_data_selected['level']; ?>
                                                                                    </span>
                                                                                <?php endif; ?>
                                                                            <?php else : ?>
                                                                                <span class="avatar-picture" style="background-image: url(https://i1.wp.com/vainkeurz.com/wp-content/themes/t-vkrz-3/assets/images/vkrz/avatar-rose.png?ssl=1);"></span>
                                                                            <?php endif; ?>
                                                                        </span>
                                                                        <span class="font-weight-bold championname">
                                                                            <a href="<?php echo esc_url(get_author_posts_url($vainkeur_data_selected['id_user'])); ?>">
                                                                                <?php echo $vainkeur_data_selected['pseudo']; ?>
                                                                                <?php if ($vainkeur_data_selected) : ?>
                                                                                    <span class="user-niveau-xs">
                                                                                        <?php echo $vainkeur_data_selected['level']; ?>
                                                                                    </span>
                                                                                <?php endif; ?>
                                                                                <?php if ($vainkeur_data_selected['user_role'] == "administrator") : ?>
                                                                                    <span class="ico va va-vkrzteam va-lg" data-toggle="tooltip" data-placement="top" title="" data-original-title="TeamVKRZ">
                                                                                    </span>
                                                                                <?php endif; ?>
                                                                                <?php if ($vainkeur_data_selected['user_role'] == "administrator" || $vainkeur_data_selected['user_role'] == "author") : ?>
                                                                                    <span class="ico va va-man-singer va-lg" data-toggle="tooltip" data-placement="top" title="" data-original-title="Créateur de Tops">
                                                                                    </span>
                                                                                <?php endif; ?>
                                                                            </a>
                                                                            <!--
                                                                            UUID    : <?php the_field('uuid_user_r', $id_ranking); ?>
                                                                            ID rank : <?php echo $id_ranking; ?>
                                                                            Date    : <?php echo get_the_date('d/m/Y - H:i:s', $id_ranking); ?>
                                                                            -->
                                                                        </span>
                                                                    </td>
                                                                    <td>
                                                                        <?php
                                                                        $user_top3 = get_user_ranking($id_ranking, 3);
                                                                        $l = 1;
                                                                        foreach ($user_top3 as $top) : ?>

                                                                            <div data-toggle="tooltip" data-popup="tooltip-custom" data-placement="bottom" data-original-title="<?php echo get_the_title($top); ?>" class="avatartop3 avatar pull-up">
                                                                                <?php if (get_field('visuel_instagram_contender', $top)) : ?>
                                                                                    <img src="<?php the_field('visuel_instagram_contender', $top); ?>" alt="<?php echo get_the_title($top); ?>">
                                                                                <?php else : ?>
                                                                                    <?php $illu = get_the_post_thumbnail_url($top, 'thumbnail'); ?>
                                                                                    <img src="<?php echo $illu; ?>" alt="<?php echo get_the_title($top); ?>">
                                                                                <?php endif; ?>
                                                                            </div>

                                                                        <?php $l++;
                                                                            if ($l == 4) break;
                                                                        endforeach; ?>
                                                                    </td>
                                                                    <td class="text-center">
                                                                        <button class="btn btn-flat-secondary waves-effect lauch-calressemblance">
                                                                            Lancer le calcul
                                                                        </button>
                                                                    </td>

                                                                    <td class="text-right">
                                                                        <a href="<?php the_permalink($id_ranking); ?>" class="btn btn-flat-secondary waves-effect" data-toggle="tooltip" data-placement="top" title="" data-original-title="Voir la TopList">
                                                                            <span class="ico ico-reverse va va-eyes va-lg"></span>
                                                                        </a>
                                                                        <a href="<?php the_permalink($id_ranking); ?>#jugement" class="btn btn-flat-secondary waves-effect" data-toggle="tooltip" data-placement="top" title="" data-original-title="Juger la TopList">
                                                                            <span class="ico va va-hache va-lg"></span>
                                                                        </a>
                                                                    </td>

                                                                    <td class="text-right checking-follower">
                                                                        <?php if ($vainkeur_data_selected && get_current_user_id() != $vainkeur_data_selected['id_user'] && is_user_logged_in()) : ?>

                                                                            <button type="button" id="followBtn" class="btn waves-effect btn-follow d-none" data-userid="<?= get_current_user_id(); ?>" data-uuid="<?= get_field('uuiduser_user', 'user_' . get_current_user_id()); ?>" data-relatedid="<?= $vainkeur_data_selected['id_user']; ?>" data-relateduuid="<?= get_field('uuiduser_user', 'user_' . $vainkeur_data_selected['id_user']); ?>" data-text="<?= get_the_author_meta('nickname', get_current_user_id()); ?> te guette !" data-url="<?= get_author_posts_url(get_current_user_id()); ?>">
                                                                                <span class="mr-10p wording">Guetter</span>
                                                                                <span class="va va-guetteur-close va va-z-20 emoji"></span>
                                                                            </button>

                                                                        <?php endif; ?>
                                                                    </td>

                                                                </tr>
                                                            <?php endif; ?>
                                                        <?php endforeach; ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </section>
                    </div>

                    <div class="col-md-4">

                        <div class="related">

                            <div class="infoelo">
                                <div class="row">
                                    <div class="col-12">
                                        <!-- CALCULATE RESEMBALNCE… -->
                                        <div class="card text-center calc-resemblance" data-idtop="<?php echo $id_top; ?>">
                                            <div class="card-body">
                                                <div class="mb-50">
                                                    <span class="ico4 va va-duo va va-z-50"></span>
                                                </div>
                                                <h2 class="font-weight-bolder mb-1 calc-resemblance-h1">
                                                    Calculer les ressemblances
                                                </h2>
                                                <h6 class="card-subtitle text-muted">
                                                    Notre algo maison va alors parcourir toutes les Toplist pour les comparer à la tienne et afficher le % de ressemblance.
                                                </h6>
                                            </div>
                                            <div class="bar"></div>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="card text-center">
                                            <div class="card-body">
                                                <div class="mb-1">
                                                    <span class="ico4 va-high-voltage va va-md"></span>
                                                </div>
                                                <h2 class="font-weight-bolder">
                                                    <?php echo $top_datas['nb_votes']; ?>
                                                </h2>
                                                <p class="card-text legende">
                                                    <?php if ($top_datas['nb_votes'] <= 1) : ?>
                                                        vote
                                                    <?php else : ?>
                                                        Votes
                                                    <?php endif; ?>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="card text-center">
                                            <div class="card-body">
                                                <div class="mb-1">
                                                    <span class="ico4 va-trophy va va-md"></span>
                                                </div>
                                                <h2 class="font-weight-bolder">
                                                    <?php echo $count_toplist; ?>
                                                </h2>
                                                <p class="card-text legende">
                                                    <?php if ($count_toplist <= 1) : ?>
                                                        Top
                                                    <?php else : ?>
                                                        Tops
                                                    <?php endif; ?>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title">
                                        <span class="ico va va-speech-balloon va-lg"></span> <?php echo $top_datas['nb_comments']; ?>
                                        <?php if ($top_datas['nb_comments'] <= 1) : ?>
                                            Commentaire
                                        <?php else : ?>
                                            Commentaires
                                        <?php endif; ?>
                                    </h4>
                                    <h6 class="card-subtitle text-muted mb-1">
                                        Tout ce qui te passe par la tête à propos de ce Top mérite d'être partagé avec les autres Vainkeurs.
                                    </h6>
                                    <a href="<?php echo get_the_permalink(get_page_by_path('discuz')) . '?id_top=' . $id_top; ?>" class="btn btn-outline-primary waves-effect">
                                        Lire & poster
                                    </a>
                                </div>
                            </div>

                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title">
                                        <span class="ico">🌎</span> Voir la TopList mondiale
                                    </h4>
                                    <h6 class="card-subtitle text-muted mb-1">
                                        Découvre le classement complet généré par les <?php echo $top_datas['nb_votes']; ?> votes !
                                    </h6>
                                    <a href="<?php the_permalink(get_page_by_path('elo')); ?>?id_top=<?php echo $id_top; ?>" class="btn btn-outline-primary waves-effect">
                                        Voir la TopList mondiale
                                    </a>
                                </div>
                            </div>
                            <?php if (!get_top_done_by_current_vainkeur($id_top, $id_vainkeur, $list_user_tops)) : ?>
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="card-title">
                                            <span class="ico va va-victory-hand va-lg"></span> A toi de jouer
                                        </h4>
                                        <h6 class="card-subtitle text-muted mb-1">
                                            Toi aussi fais ta TopList afin de faire bouger les positions !
                                        </h6>
                                        <a href="<?php the_permalink($id_top); ?>" class="btn btn-outline-primary waves-effect">
                                            Faire ma TopList
                                        </a>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php get_footer(); ?>