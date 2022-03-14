<?php
/*
    Template Name: Account
*/
get_header();
global $uuiduser;
global $user_tops;
global $user_infos;
global $id_vainkeur;
$list_user_tops = $user_tops['list_user_tops'];
$list_t_begin   = array();
$list_t_done    = array();
$has_t_begin    = false;
foreach ($list_user_tops as $top) {
    if ($top['state'] == 'begin') {
        array_push($list_t_begin, $top);
    }
    if ($top['state'] == 'done') {
        array_push($list_t_done, $top);
    }
}
?>
<div class="app-content content ">
    <div class="content-wrapper">
        <div class="content-body">
            <?php if (!is_user_logged_in()) : ?>
                <section class="please-rejoin app-user-view">
                    <div role="alert" aria-live="polite" aria-atomic="true" class="alert alert-account">
                        <div class="alert-body d-flex align-items-center justify-content-between">
                            <span><span class="ico va va-floppy-disk va-lg"></span> Pour sauvegarder et retrouver sur tous tes supports ta progression l'idéal serait de te créer un compte.</span>
                            <div class="btns-alert text-right">
                                <a class="btn btn-primary waves-effect btn-rose" href="<?php the_permalink(get_page_by_path('creer-mon-compte')); ?>">
                                    Excellente idée - je créé mon compte <span class="ico va va-party-popper va-lg"></span>
                                </a>
                                <a class="btn btn-outline-white waves-effect t-white ml-1" href="<?php the_permalink(get_page_by_path('se-connecter')); ?>">
                                    J'ai déjà un compte
                                </a>
                            </div>
                        </div>
                    </div>
                </section>
            <?php endif; ?>

            <div id="user-profile">
                <div class="row">
                    <div class="col-12">
                        <?php get_template_part('partials/profil'); ?>
                    </div>
                </div>

                <section id="profile-info">
                    <div class="row">
                        <div class="col-lg-3 col-12 order-2 order-lg-1">

                            <div class="hide-xs">

                                <div class="card">
                                    <div class="card-header">
                                        <h4 class="card-title">
                                            <span class="ico va va-sports-medal va-lg"></span> Trophées
                                        </h4>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <?php
                                            $vainkeur_badges = get_the_terms($id_vainkeur, 'badges');
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
                                        <div class="row mt-2">
                                            <div class="col-12">
                                                <a class="btn btn-primary btn-block waves-effect waves-float waves-light" href="<?php the_permalink(get_page_by_path('trophees')); ?>">
                                                    Découvrir les trophées <span class="va va-eyes va-z-20"></span>
                                                </a>
                                            </div>
                                        </div>
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
                                        foreach ($cat_t as $cat) : ?>
                                            <?php
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
                                                    <small class="infosmall text-<?php echo $classbar; ?>">
                                                        <?php echo $count_top_done_in_cat; ?> sur <?php echo $tops_in_cat; ?>
                                                    </small>
                                                </p>
                                                <div class="progress progress-bar-<?php echo $classbar; ?>" style="height: 6px">
                                                    <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="<?php echo $percent_done_cat; ?>" aria-valuemin="<?php echo $percent_done_cat; ?>" aria-valuemax="100" style="width: <?php echo $percent_done_cat; ?>%"></div>
                                                </div>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div id="levelbloc" class="col-lg-9 col-12 order-1 order-lg-2">
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
                                                    <span class="icomax2">
                                                        <?php echo $user_infos['level']; ?>
                                                    </span>
                                                </div>
                                                <p class="card-text legende">Niveau actuel</p>
                                                <div class="progress-wrapper mt-1">
                                                    <?php
                                                    $nb_need_money       = get_vote_to_next_level($user_infos['level_number'], $user_infos['money_vkrz']);
                                                    $money_to_next_level = $nb_need_money + $user_infos['money_vkrz'];
                                                    $percent_progression = round($user_infos['money_vkrz'] * 100 / $money_to_next_level);
                                                    ?>
                                                    <div class="progress progress-bar-primary w-100 mb-1" style="height: 6px; margin-top: 5px;">
                                                        <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="<?php echo $percent_progression; ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $percent_progression; ?>%"></div>
                                                    </div>
                                                    <?php if (is_user_logged_in()) : ?>
                                                        <div id="example-caption-5">Encore <span class="decompte_vote"><?php echo $nb_need_money; ?></span> <span class="ico text-center va va-gem va-z-15"></span> pour <?php echo $user_infos['next_level']; ?></div>
                                                    <?php else : ?>
                                                        <a href="<?php the_permalink(get_page_by_path('creer-mon-compte')); ?>" class="t-white">
                                                            <div id="example-caption-5">Créé ton compte pour passer <?php echo $user_infos['next_level']; ?></div>
                                                        </a>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-4 col-6">
                                        <div class="card text-center">
                                            <div class="card-body">
                                                <div>
                                                    <span class="icomax">
                                                        <span class="va-sm va-high-voltage va"></span>
                                                    </span>
                                                </div>
                                                <h2 class="font-weight-bolder">
                                                    <?php echo $user_infos['nb_vote_vkrz']; ?>
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
                                                <div class="">
                                                    <span class="icomax">
                                                        <span class="va-sm va va-trophy"></span>
                                                    </span>
                                                </div>
                                                <h2 class="font-weight-bolder">
                                                    <?php echo $user_infos['nb_top_vkrz']; ?>
                                                </h2>
                                                <?php if ($user_infos['nb_top_vkrz'] > 1) : ?>
                                                    <p class="card-text legende">Tops terminés</p>
                                                <?php else : ?>
                                                    <p class="card-text legende">Top terminé</p>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </section>
                            <section class="moredata hide-sm hide-md hide-lg hide-lg">
                                <div class="card">
                                    <div class="card-header">
                                        <h4 class="card-title">
                                            <span class="ico va va-sports-medal va-lg"></span> Trophées
                                        </h4>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <?php
                                            $vainkeur_badges = get_the_terms($id_vainkeur, 'badges');
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
                                        <div class="row mt-2">
                                            <div class="col-12">
                                                <a class="btn btn-primary btn-block waves-effect waves-float waves-light" href="<?php the_permalink(get_page_by_path('trophees')); ?>">
                                                    Découvrir les trophées <span class="va va-eyes va-z-20"></span>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </section>
                            <section id="basic-tabs-components">
                                <ul class="nav nav-tabs" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" id="profileIcon-tab" data-toggle="tab" href="#tab2" aria-controls="profile" role="tab" aria-selected="false">
                                            <?php if (count($list_t_done) > 1) : ?>
                                                Tops terminés
                                            <?php else : ?>
                                                Top terminé
                                            <?php endif; ?>
                                        </a>
                                    </li>
                                    <?php if ($has_t_begin) : ?>
                                        <li class="nav-item">
                                            <a class="nav-link" id="homeIcon-tab" data-toggle="tab" href="#tab1" aria-controls="home" role="tab" aria-selected="true">
                                                <?php if (count($list_t_begin) > 1) : ?>
                                                    Tops à terminer
                                                <?php else : ?>
                                                    Top à terminer
                                                <?php endif; ?>
                                            </a>
                                        </li>
                                    <?php endif; ?>
                                </ul>
                                <div class="tab-content">
                                    <div class="tab-pane active" id="tab2" aria-labelledby="profileIcon-tab" role="tabpanel">
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="card invoice-list-wrapper">
                                                    <div class="card-datatable table-responsive">
                                                        <table class="invoice-list-table table table-tdone">
                                                            <thead>
                                                                <tr>
                                                                    <th class="">
                                                                        <span class="text-muted">
                                                                            <?php if ($user_infos['nb_top_vkrz'] > 1) : ?>
                                                                                <span class="t-rose"><?php echo $user_infos['nb_top_vkrz']; ?></span> Tops terminés
                                                                            <?php else : ?>
                                                                                <span class="t-rose"><?php echo $user_infos['nb_top_vkrz']; ?></span> Top terminé
                                                                            <?php endif; ?>
                                                                        </span>
                                                                    </th>
                                                                    <th class="text-center">
                                                                        <span class="text-muted">
                                                                            Cat
                                                                        </span>
                                                                    </th>
                                                                    <th class="text-right">
                                                                        <span class="text-muted">Votes</span>
                                                                    </th>
                                                                    <th class="">
                                                                        <span class="text-muted">Podium</span>
                                                                    </th>
                                                                    <th>
                                                                        <span class="text-muted">Voir</span>
                                                                    </th>
                                                                    <th>
                                                                        <span class="text-muted">Action</span>
                                                                    </th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php
                                                                foreach ($list_t_done as $top) : ?>
                                                                    <?php if (!get_field('private_t', $top['id_top'])) : ?>
                                                                        <tr id="top-<?php echo $top['id_ranking']; ?>">
                                                                            <td>
                                                                                <div class="d-flex align-items-center">
                                                                                    <div class="avatar">
                                                                                        <?php
                                                                                        $minia = get_the_post_thumbnail_url($top['id_top'], 'large')
                                                                                        ?>
                                                                                        <span class="avatar-picture avatar-top" style="background-image: url(<?php echo $minia; ?>);"></span>
                                                                                    </div>
                                                                                    <div class="font-weight-bold topnamebestof">
                                                                                        <div class="media-body">
                                                                                            <div class="media-heading">
                                                                                                <h6 class="cart-item-title mb-0">
                                                                                                    <a class="text-body" href="<?php the_permalink($top['id_top']); ?>">
                                                                                                        Top <?php the_field('count_contenders_t', $top['id_top']); ?> <span class="ico">⚡</span> <?php echo get_the_title($top['id_top']); ?>
                                                                                                    </a>
                                                                                                </h6>
                                                                                                <small class="cart-item-by legende">
                                                                                                    <?php the_field('question_t', $top['id_top']); ?>
                                                                                                </small>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </td>
                                                                            <td class="text-center">
                                                                                <?php
                                                                                foreach (get_the_terms($top['id_top'], 'categorie') as $cat) {
                                                                                    $cat_id     = $cat->term_id;
                                                                                    $cat_name   = $cat->name;
                                                                                }
                                                                                ?>
                                                                                <span class="hide"><?php echo $cat_name; ?></span>
                                                                                <?php the_field('icone_cat', 'term_' . $cat_id); ?>
                                                                            </td>
                                                                            <td class="text-right">
                                                                                <?php echo $top['nb_votes']; ?> <span class="ico3 va-high-voltage va va-lg"></span>
                                                                            </td>
                                                                            <td>
                                                                                <?php
                                                                                $user_top3 = get_user_ranking($top['id_ranking']);
                                                                                $l = 1;
                                                                                foreach ($user_top3 as $contender) : ?>

                                                                                    <div data-toggle="tooltip" data-popup="tooltip-custom" data-placement="bottom" data-original-title="<?php echo get_the_title($contender); ?>" class="avatartop3 avatar pull-up">
                                                                                        <?php if (get_field('visuel_instagram_contender', $contender)) : ?>
                                                                                            <img src="<?php the_field('visuel_instagram_contender', $contender); ?>" alt="<?php echo get_the_title($contender); ?>">
                                                                                        <?php else : ?>
                                                                                            <?php $illu = get_the_post_thumbnail_url($contender, 'thumbnail'); ?>
                                                                                            <img src="<?php echo $illu; ?>" alt="<?php echo get_the_title($contender); ?>">
                                                                                        <?php endif; ?>
                                                                                    </div>

                                                                                <?php $l++;
                                                                                    if ($l == 4) break;
                                                                                endforeach; ?>
                                                                            </td>
                                                                            <td>
                                                                                <div class="d-flex align-items-center col-actions">
                                                                                    <?php
                                                                                    if ($top['typetop'] == "top3") {
                                                                                        $wording = "Voir le Top 3";
                                                                                    } else {
                                                                                        $wording = "Voir le Top complet";
                                                                                    }
                                                                                    ?>
                                                                                    <a class="mr-1" href="<?php the_permalink($top['id_ranking']); ?>" data-toggle="tooltip" data-placement="top" title="" data-original-title="<?php echo $wording; ?>">
                                                                                        <span class="ico va va-trophy va-lg">

                                                                                        </span>
                                                                                    </a>
                                                                                    <a class="mr-1" href="<?php the_permalink(get_page_by_path('elo')); ?>?id_top=<?php echo $top['id_top']; ?>" data-toggle="tooltip" data-placement="top" title="" data-original-title="Voir le Top mondial">
                                                                                        <span class="ico va va-globe va-lg">

                                                                                        </span>
                                                                                    </a>
                                                                                </div>
                                                                            </td>
                                                                            <td class="text-center">
                                                                                <div class="dropdown">
                                                                                    <a class="btn btn-sm btn-icon px-0" data-toggle="dropdown">
                                                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-more-vertical font-medium-2">
                                                                                            <circle cx="12" cy="12" r="1"></circle>
                                                                                            <circle cx="12" cy="5" r="1"></circle>
                                                                                            <circle cx="12" cy="19" r="1"></circle>
                                                                                        </svg>
                                                                                    </a>
                                                                                    <div class="dropdown-menu dropdown-menu-right">
                                                                                        <a data-phrase1="Es-tu sûr de vouloir recommencer ?" data-phrase2="Tous les votes de ce Top seront remis à 0" data-id_vainkeur="<?php echo $id_vainkeur; ?>" data-id_ranking="<?php echo $top['id_ranking']; ?>" class="confirm_delete dropdown-item" href="#">
                                                                                            <span class="ico-action va va-new-button va-z-20"></span> Recommencer
                                                                                        </a>
                                                                                        <a data-phrase1="Es-tu sûr de vouloir recommencer ?" data-phrase2="Le Top sera supprimé définitivement 😱" data-id_vainkeur="<?php echo $id_vainkeur; ?>" data-id_ranking="<?php echo $top['id_ranking']; ?>" class="confirmDeleteReal dropdown-item" href="#">
                                                                                            <span class="ico-action va va-throw-bin-button va-z-20"></span> Supprimer
                                                                                        </a>
                                                                                        <a href="#" class="dropdown-item" data-toggle="modal" data-target="#commentModal-<?php echo $top['id_top']; ?>">
                                                                                            <span class="ico-action va va-free-button va-z-20"></span> Commenter
                                                                                        </a>
                                                                                    </div>
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
                                    <?php if ($has_t_begin) : ?>
                                        <div class="tab-pane" id="tab1" aria-labelledby="homeIcon-tab" role="tabpanel">
                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="card invoice-list-wrapper">
                                                        <div class="card-datatable table-responsive">
                                                            <table class="invoice-list-table table table-tbegin">
                                                                <thead>
                                                                    <tr>
                                                                        <th class="">
                                                                            <?php if (count($list_t_done) > 1) : ?>
                                                                                <span class="t-rose"><?php echo count($list_t_begin); ?></span> Tops à terminer
                                                                            <?php else : ?>
                                                                                <span class="t-rose"><?php echo count($list_t_begin); ?></span> Top à terminer
                                                                            <?php endif; ?>
                                                                        </th>
                                                                        <th class="text-center">
                                                                            <span class="va-high-voltage va va-lg"></span>
                                                                        </th>
                                                                        <th>
                                                                            <span class="va va-eyes va-lg"></span>
                                                                        </th>
                                                                        <th>

                                                                        </th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <?php
                                                                    foreach ($list_t_begin as $top) : ?>
                                                                        <tr id="top-<?php echo $top['id_ranking']; ?>">
                                                                            <td>
                                                                                <div class="media-body">
                                                                                    <div class="media-heading">
                                                                                        <h6 class="cart-item-title mb-0">
                                                                                            <a class="text-body" href="<?php the_permalink($top['id_top']); ?>">
                                                                                                Top <?php echo $top['nb_top']; ?> - <?php echo get_the_title($top['id_top']); ?>
                                                                                            </a>
                                                                                        </h6>
                                                                                        <small class="cart-item-by legende">
                                                                                            <?php the_field('question_t', $top['id_top']); ?>
                                                                                        </small>
                                                                                    </div>
                                                                                </div>
                                                                            </td>
                                                                            <td class="text-center">
                                                                                <?php echo $top['nb_votes']; ?> <span class="ico3 va-high-voltage va va-lg"></span>
                                                                            </td>
                                                                            <td>
                                                                                <a class="mr-1" href="<?php the_permalink(get_page_by_path('elo')); ?>?id_top=<?php echo $top['id_top']; ?>" data-toggle="tooltip" data-placement="top" title="" data-original-title="Voir le Top mondial">
                                                                                    <span class="ico va va-globe va-lg">

                                                                                    </span>
                                                                                </a>
                                                                            </td>
                                                                            <td class="text-center">
                                                                                <div class="d-flex align-items-center col-actions">
                                                                                    <a href="<?php the_permalink($top['id_top']); ?>" data-toggle="tooltip" data-placement="top" title="" data-original-title="Continuer le Top">
                                                                                        <span class="ico-action va va-play-button va-z-20"></span>
                                                                                    </a>
                                                                                    <a data-phrase1="Es-tu sûr de vouloir recommencer ?" data-phrase2="Tous les votes de ce Top seront remis à 0" data-id_vainkeur="<?php echo $id_vainkeur; ?>" data-id_ranking="<?php echo $top['id_ranking']; ?>" class="confirm_delete" href="#" data-toggle="tooltip" data-placement="top" title="" data-original-title="Recommencer le Top">
                                                                                        <span class="ico-action va va-new-button va-z-20"></span>
                                                                                    </a>
                                                                                    <a data-phrase1="Es-tu sûr de vouloir recommencer ?" data-phrase2="Le Top sera supprimé définitivement 😱" data-id_vainkeur="<?php echo $id_vainkeur; ?>" data-id_ranking="<?php echo $top['id_ranking']; ?>" class="confirmDeleteReal" href="#" data-toggle="tooltip" data-placement="top" title="" data-original-title="Abandonner le Top">
                                                                                        <span class="ico-action va va-throw-bin-button va-z-20"></span>
                                                                                    </a>
                                                                                </div>
                                                                            </td>
                                                                        </tr>
                                                                    <?php endforeach; ?>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endif; ?>
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