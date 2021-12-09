<?php
get_header();
global $vainkeur_id;
global $vainkeur_info;
global $vainkeur_tops;
$list_user_tops = $vainkeur_tops['list_user_tops'];
$list_t_done    = array();
foreach ($list_user_tops as $top) {
    if ($top['state'] == 'done') {
        array_push($list_t_done, $top);
    }
}
?>
<div class="app-content content ">
    <div class="content-wrapper">
        <div class="content-body">

            <div id="user-profile">
                <div class="row">
                    <div class="col-12">
                        <?php get_template_part('partials/profil'); ?>
                    </div>
                </div>

                <section id="profile-info">
                    <div class="row">
                        <div class="col-lg-3 col-12 order-2 order-lg-1">

                            <div class="card card-transaction">
                                <div class="card-body">
                                    <div class="info-bio">
                                        <h5 class="mb-75 t-rose">Inscription</h5>
                                        <p class="card-text">
                                            <?php echo $vainkeur_id; ?>ème vainkeur à avoir rejoint le concept
                                            <!-- #<?php $vainkeur_info['uuid_user_vkrz']; ?> -->
                                        </p>
                                    </div>
                                    <?php
                                    if (get_userdata($vainkeur_id)->description) : ?>
                                        <div class="info-bio mt-2">
                                            <h5 class="mb-75 t-rose">Bio</h5>
                                            <p class="card-text">
                                                <?php echo get_userdata($vainkeur_id)->description; ?>
                                            </p>
                                        </div>
                                    <?php endif; ?>

                                    <?php if (get_userdata($vainkeur_id)->twitch_user || get_userdata($vainkeur_id)->youtube_user || get_userdata($vainkeur_id)->Instagram_user || get_userdata($vainkeur_id)->tiktok_user) : ?>
                                        <div class="info-bio mt-2">
                                            <h5 class="mb-75 t-rose">Réseaux</h5>
                                            <div class="row">
                                                <?php if (get_userdata($vainkeur_id)->twitch_user) : ?>
                                                    <div class="col-md-6">
                                                        <div class="transaction-item mb-2">
                                                            <a href="https://www.twitch.tv/<?php echo get_userdata($vainkeur_id)->twitch_user; ?>" target="_blank">
                                                                <div class="d-flex align-items-center">
                                                                    <div class="avatar bg-light-primary rounded">
                                                                        <div class="avatar-content picto-rs">
                                                                            <i class="fab fa-twitch"></i>
                                                                        </div>
                                                                    </div>
                                                                    <div class="transaction-info">
                                                                        <h6 class="transaction-title mb-0">
                                                                            Twitch
                                                                        </h6>
                                                                    </div>
                                                                </div>
                                                            </a>
                                                        </div>
                                                    </div>
                                                <?php endif; ?>
                                                <?php if (get_userdata($vainkeur_id)->youtube_user) : ?>
                                                    <div class="col-md-6">
                                                        <div class="transaction-item mb-2">
                                                            <a href="https://www.youtube.com/user/<?php echo get_userdata($vainkeur_id)->youtube_user; ?>" target="_blank">
                                                                <div class="d-flex align-items-center">
                                                                    <div class="avatar bg-light-primary rounded">
                                                                        <div class="avatar-content picto-rs">
                                                                            <i class="fab fa-youtube"></i>
                                                                        </div>
                                                                    </div>
                                                                    <div class="transaction-info">
                                                                        <h6 class="transaction-title mb-0">
                                                                            Youtube
                                                                        </h6>
                                                                    </div>
                                                                </div>
                                                            </a>
                                                        </div>
                                                    </div>
                                                <?php endif; ?>
                                                <?php if (get_userdata($vainkeur_id)->Instagram_user) : ?>
                                                    <div class="col-md-6">
                                                        <div class="transaction-item mb-2">
                                                            <a href="https://www.instagram.com/<?php echo get_userdata($vainkeur_id)->Instagram_user; ?>" target="_blank">
                                                                <div class="d-flex align-items-center">
                                                                    <div class="avatar bg-light-primary rounded">
                                                                        <div class="avatar-content picto-rs">
                                                                            <i class="fab fa-instagram"></i>
                                                                        </div>
                                                                    </div>
                                                                    <div class="transaction-info">
                                                                        <h6 class="transaction-title mb-0">
                                                                            Instagram
                                                                        </h6>
                                                                    </div>
                                                                </div>
                                                            </a>
                                                        </div>
                                                    </div>
                                                <?php endif; ?>
                                                <?php if (get_userdata($vainkeur_id)->twitter_user) : ?>
                                                    <div class="col-md-6">
                                                        <div class="transaction-item mb-2">
                                                            <a href="https://twitter.com/<?php echo get_userdata($vainkeur_id)->twitter_user; ?>" target="_blank">
                                                                <div class="d-flex align-items-center">
                                                                    <div class="avatar bg-light-primary rounded">
                                                                        <div class="avatar-content picto-rs">
                                                                            <i class="fab fa-twitter"></i>
                                                                        </div>
                                                                    </div>
                                                                    <div class="transaction-info">
                                                                        <h6 class="transaction-title mb-0">
                                                                            Twitter
                                                                        </h6>
                                                                    </div>
                                                                </div>
                                                            </a>
                                                        </div>
                                                    </div>
                                                <?php endif; ?>
                                                <?php if (get_userdata($vainkeur_id)->snapchat_user) : ?>
                                                    <div class="col-md-6">
                                                        <div class="transaction-item mb-2">
                                                            <a href="https://www.snapchat.com/add/<?php echo get_userdata($vainkeur_id)->snapchat_user; ?>" target="_blank">
                                                                <div class="d-flex align-items-center">
                                                                    <div class="avatar bg-light-primary rounded">
                                                                        <div class="avatar-content picto-rs">
                                                                            <i class="fab fa-snapchat-ghost"></i>
                                                                        </div>
                                                                    </div>
                                                                    <div class="transaction-info">
                                                                        <h6 class="transaction-title mb-0">
                                                                            Snapchat
                                                                        </h6>
                                                                    </div>
                                                                </div>
                                                            </a>
                                                        </div>
                                                    </div>
                                                <?php endif; ?>
                                                <?php if (get_userdata($vainkeur_id)->tiktok_user) : ?>
                                                    <div class="col-md-6">
                                                        <div class="transaction-item mb-2">
                                                            <a href="https://www.tiktok.com/@<?php echo get_userdata($vainkeur_id)->tiktok_user; ?>?" target="_blank">
                                                                <div class="d-flex align-items-center">
                                                                    <div class="avatar bg-light-primary rounded">
                                                                        <div class="avatar-content picto-rs">
                                                                            <i class="fab fa-tiktok"></i>
                                                                        </div>
                                                                    </div>
                                                                    <div class="transaction-info">
                                                                        <h6 class="transaction-title mb-0">
                                                                            TikTok
                                                                        </h6>
                                                                    </div>
                                                                </div>
                                                            </a>
                                                        </div>
                                                    </div>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">
                                        <span class="ico va va-medal-1 va-lg"></span> Trophées
                                    </h4>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <?php
                                        $vainkeur_badges = get_the_terms($vainkeur_info['id_vainkeur'], 'badges');
                                        foreach ($vainkeur_badges as $badge) : ?>
                                            <div class="col-4 col-sm-6 col-lg-4">
                                                <div class="text-center">
                                                    <div class="user-level" data-toggle="tooltip" data-placement="top" title="" data-original-title="<?php echo $badge->name; ?> : <?php echo $badge->description; ?>">
                                                        <span class="icomedium">
                                                            <?php the_field('symbole_badge', 'badges_' . $badge->term_id); ?>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            </div>

                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">
                                        <span class="ico va va-hourglass va-lg"></span> Progression
                                    </h4>
                                </div>
                                <div class="card-body">
                                    <div class="row avg-sessions pt-50">
                                        <?php
                                        $cat_t = get_terms(array(
                                            'taxonomy'      => 'categorie',
                                            'orderby'       => 'count',
                                            'order'         => 'DESC',
                                            'hide_empty'    => true
                                        ));

                                        foreach ($cat_t as $cat) :
                                            $tops_in_cat = $cat->count;
                                            $id_cat      = $cat->term_id;
                                            $count_top_done_in_cat = 0;

                                            foreach ($list_user_tops as $top_done) {
                                                if ($id_cat == $top_done['cat_t'] && $top_done['state'] == 'done') {
                                                    $count_top_done_in_cat++;
                                                }
                                            }
                                            $percent_done_cat = round($count_top_done_in_cat * 100 / $tops_in_cat);
                                            if ($percent_done_cat >= 100) {
                                                $classbar = "success";
                                            } elseif ($percent_done_cat < 100 && $percent_done_cat >= 25) {
                                                $classbar = "primary";
                                            } else {
                                                $classbar = "warning";
                                            }
                                        ?>
                                            <div class="col-12 mt-1 mb-1">
                                                <p class="mb-50">
                                                    <span class="ico2">
                                                        <span class="<?php if ($cat->term_id == 2) {
                                                                            echo 'rotating';
                                                                        } ?>">
                                                            <?php the_field('icone_cat', 'term_' . $cat->term_id); ?>
                                                        </span>
                                                    </span>
                                                    <?php echo $cat->name; ?>
                                                    <small class="infosmall text-<?php echo $classbar; ?>"><?php echo $count_top_done_in_cat; ?> sur <?php echo $tops_in_cat; ?>
                                                    </small>
                                                </p>
                                                <div class="progress progress-bar-<?php echo $classbar; ?>" style="height: 6px">
                                                    <div class="progress-bar" role="progressbar" aria-valuenow="<?php echo $percent_done_cat; ?>" aria-valuemin="<?php echo $percent_done_cat; ?>" aria-valuemax="100" style="width: <?php echo $percent_done_cat; ?>%"></div>
                                                </div>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-9 col-12 order-1 order-lg-2">
                            <section class="app-user-view">
                                <div class="row match-height">
                                    <div class="col-sm-4">
                                        <div class="card text-center">
                                            <div class="card-body">
                                                <div class="pricing-badge text-right">
                                                    <div class="badge badge-pill badge-light-primary">
                                                        <a href="<?php the_permalink(get_page_by_path('evolution')); ?>">
                                                            ?
                                                        </a>
                                                    </div>
                                                </div>
                                                <div class="user-level">
                                                    <span class="icomax">
                                                        <?php echo $vainkeur_info['level']; ?>
                                                    </span>
                                                </div>
                                                <p class="card-text legende">Niveau actuel</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-4 col-6">
                                        <div class="card text-center">
                                            <div class="card-body">
                                                <div class="mb-1">
                                                    <span class="ico4 va va-gem va-z-30"></span>
                                                </div>
                                                <h2 class="font-weight-bolder">
                                                    <?php echo $vainkeur_info['nb_vote_vkrz']; ?>
                                                </h2>
                                                <?php if ($vainkeur_info['nb_vote_vkrz'] > 1) : ?>
                                                    <p class="card-text legende">Votes</p>
                                                <?php else : ?>
                                                    <p class="card-text legende">Vote</p>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-4 col-6">
                                        <div class="card text-center">
                                            <div class="card-body">
                                                <div class="mb-1">
                                                    <span class="ico4 va va-trophy va-z-30"></span>
                                                </div>
                                                <h2 class="font-weight-bolder">
                                                    <?php echo $vainkeur_info['nb_top_vkrz']; ?>
                                                </h2>
                                                <p class="card-text legende">
                                                    <?php if (count($list_t_done) > 1) : ?>
                                                        Tops terminés
                                                    <?php else : ?>
                                                        Top terminé
                                                    <?php endif; ?>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </section>
                            <section id="basic-tabs-components">
                                <div class="tab-content">
                                    <div class="tab-pane active" id="tab2" aria-labelledby="profileIcon-tab" role="tabpanel">
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="card invoice-list-wrapper">
                                                    <div class="card-datatable table-responsive">
                                                        <table class="invoice-list-table table table-4">
                                                            <thead>
                                                                <tr>
                                                                    <th class="">
                                                                        <?php if (count($list_t_done) > 1) : ?>
                                                                            <span class="t-rose"><?php echo count($list_t_done); ?></span> Tops terminés
                                                                        <?php else : ?>
                                                                            <span class="t-rose"><?php echo count($list_t_done); ?></span> Top terminé
                                                                        <?php endif; ?>
                                                                    </th>
                                                                    <th class="text-right">
                                                                        <span class="va va-gem va-lg"></span>
                                                                    </th>
                                                                    <th class="">
                                                                        <span class="va va-medal-1 va-lg"></span><span class="va va-medal-2 va-lg"></span><span class="va va-medal-3 va-lg"></span>
                                                                    </th>
                                                                    <th>
                                                                        <span class="va va-eyes va-lg"></span>
                                                                    </th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php
                                                                foreach ($list_t_done as $r_user) : ?>
                                                                    <?php
                                                                    $get_top_type = get_the_terms($r_user['id_top'], 'type');
                                                                    foreach ($get_top_type as $type_top) {
                                                                        $type_top = $type_top->slug;
                                                                    }
                                                                    ?>
                                                                    <?php if ($type_top == "classik" || $type_top == "sponso") : ?>
                                                                        <tr id="top-<?php echo $r_user['id_ranking']; ?>">
                                                                            <td>
                                                                                <div class="media-body">
                                                                                    <div class="media-heading">
                                                                                        <h6 class="cart-item-title mb-0">
                                                                                            <a class="text-body" href="<?php the_permalink($r_user['id_top']); ?>">
                                                                                                Top <?php echo $r_user['nb_top']; ?> - <?php echo get_the_title($r_user['id_top']); ?>
                                                                                            </a>
                                                                                        </h6>
                                                                                        <small class="cart-item-by legende">
                                                                                            <?php the_field('question_t', $r_user['id_top']); ?>
                                                                                        </small>
                                                                                    </div>
                                                                                </div>
                                                                            </td>
                                                                            <td class="text-right">
                                                                                <?php echo $r_user['nb_votes']; ?> <span class="ico3 va va-gem va-lg"></span>
                                                                            </td>
                                                                            <td>
                                                                                <?php
                                                                                $user_top3 = get_user_ranking($r_user['id_ranking']);
                                                                                $l = 1;
                                                                                foreach ($user_top3 as $top) : ?>

                                                                                    <div data-toggle="tooltip" data-popup="tooltip-custom" data-placement="bottom" data-original-title="<?php echo get_the_title($top); ?>" class="avatartop3 avatar pull-up">
                                                                                        <?php $illu = get_the_post_thumbnail_url($top, 'thumbnail'); ?>
                                                                                        <img src="<?php echo $illu; ?>" alt="Avatar">
                                                                                    </div>

                                                                                <?php $l++;
                                                                                    if ($l == 4) break;
                                                                                endforeach; ?>
                                                                            </td>
                                                                            <td>
                                                                                <div class="d-flex align-items-center col-actions">
                                                                                    <?php
                                                                                    if ($r_user['typetop'] == "top3") {
                                                                                        $wording = "Voir le Top 3";
                                                                                    } else {
                                                                                        $wording = "Voir le Top complet";
                                                                                    }
                                                                                    ?>
                                                                                    <a class="mr-1" href="<?php the_permalink($r_user['id_ranking']); ?>" data-toggle="tooltip" data-placement="top" title="" data-original-title="<?php echo $wording; ?>">
                                                                                        <span class="ico">
                                                                                            <span class="va va-trophy va-lg"></span>
                                                                                        </span>
                                                                                    </a>
                                                                                    <a class="mr-1" href="<?php the_permalink(get_page_by_path('elo')); ?>?id_top=<?php echo $r_user['id_top']; ?>" data-toggle="tooltip" data-placement="top" title="" data-original-title="Voir le Top mondial">
                                                                                        <span class="ico">
                                                                                            <span class="va va-globe va-lg"></span>
                                                                                        </span>
                                                                                    </a>
                                                                                </div>
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
                                    </div>
                                </div>
                            </section>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
</div>

<?php get_footer(); ?>