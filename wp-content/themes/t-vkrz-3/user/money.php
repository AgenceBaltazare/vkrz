<?php
/*
    Template Name: Money
*/
get_header();
global $uuiduser;
global $user_id;
global $vainkeur_id;
global $vainkeur_info;
global $user_infos;
$vainkeur_info = isset($vainkeur_info) ? $vainkeur_info : $user_infos;
if ($vainkeur_info['user_role'] == "administrator" || $vainkeur_info['user_role'] == "author") {
    if (false === ($data_t_created = get_transient('user_' . $user_id . '_get_creator_t'))) {
        $data_t_created = get_creator_t($user_id);
        set_transient('user_' . $user_id . '_get_creator_t', $data_t_created, DAY_IN_SECONDS);
    } else {
        $data_t_created = get_transient('user_' . $user_id . '_get_creator_t');
    }
}
$money_votes = $user_infos['nb_vote_vkrz'];
$money_tops  = $user_infos['nb_top_vkrz'] * 5;
$money_badges = 0;
$vainkeur_badges = get_the_terms($vainkeur_info['id_vainkeur'], 'badges');
if ($vainkeur_badges) {
    foreach ($vainkeur_badges as $badge) {
        $money_badges = $money_badges + get_field('recompense_badge', 'badges_' . $badge->term_id);
    }
}
$money_createur = round($data_t_created['total_completed_top'] * 10) + round($data_t_created['creator_all_v'] * 1) + $data_t_created['creator_nb_tops'] * 100;
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

                <section id="nav-filled">
                    <div class="row">
                        <div class="col-sm-3">
                            <div class="card">
                                <div class="card-body text-center">
                                    <div class="mb-1">
                                        <span class="ico4 va va-gem va va-z-85"></span>
                                    </div>
                                    <h2 class="font-weight-bolder">
                                        <?php if ($user_infos['money_vkrz']) : ?>
                                            <?php echo number_format($user_infos['money_vkrz'], 0, ",", " "); ?>
                                        <?php else : ?>
                                            -
                                        <?php endif; ?>
                                    </h2>
                                    <p class="card-text legende">KEURZ</p>

                                    <div class="row mt-2">
                                        <div class="col-12">
                                            <a class="btn btn-primary btn-block waves-effect waves-float waves-light" href="<?php the_permalink(get_page_by_path('trophees')); ?>">
                                                Voir le Store
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-6">
                                    <div class="card text-center">
                                        <div class="card-body">
                                            <div class="mb-1">
                                                <span class="ico4 va va-llama va va-z-30"></span>
                                            </div>
                                            <h2 class="font-weight-bolder">
                                                <?php echo number_format($user_infos['nb_vote_vkrz'] + $money_tops + $money_badges, 0, ",", " "); ?> <span class="va-gem va va-1x"></span>
                                            </h2>
                                            <p class="card-text legende">
                                                Collecté en tant que Vainkeur
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="card text-center">
                                        <div class="card-body">
                                            <div class="mb-1">
                                                <span class="ico4 va va-man-singer va va-z-30"></span>
                                            </div>
                                            <h2 class="font-weight-bolder">
                                                <?php echo number_format($money_createur, 0, ",", " "); ?> <span class="va-gem va va-1x"></span>
                                            </h2>
                                            <p class="card-text legende">
                                                Collecté en tant que créateur
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-9">
                            <section id="basic-tabs-components">
                                <ul class="nav nav-tabs" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" id="profileIcon-tab" data-toggle="tab" href="#tab2" aria-controls="profile" role="tab" aria-selected="false">
                                            Détails de la collecte de <span class="m-l-5 va-gem va va-1x"></span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="homeIcon-tab" data-toggle="tab" href="#tab1" aria-controls="home" role="tab" aria-selected="true">
                                            Historique
                                        </a>
                                    </li>
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
                                                                        Récompenses
                                                                    </th>
                                                                    <th class="text-right">
                                                                        Détail
                                                                    </th>
                                                                    <th class="text-right">
                                                                        KEURZ <span class="va-gem va va-lg"></span>
                                                                    </th>
                                                                </tr>
                                                            </thead>
                                                            <tbody class="nobold">
                                                                <tr>
                                                                    <th>
                                                                        Votes réalisés
                                                                    </th>
                                                                    <th class="text-right">
                                                                        <span class="text-muted">1 x</span> <?php echo $user_infos['nb_vote_vkrz']; ?>
                                                                    </th>
                                                                    <th class="text-right">
                                                                        <?php echo $money_votes; ?> <span class="va-gem va va-1x"></span>
                                                                    </th>
                                                                </tr>
                                                                <tr>
                                                                    <th>
                                                                        Tops finalisés
                                                                    </th>
                                                                    <th class="text-right">
                                                                        <span class="text-muted">5 x</span> <?php echo $user_infos['nb_top_vkrz']; ?>
                                                                    </th>
                                                                    <th class="text-right">
                                                                        <?php echo $money_tops; ?> <span class="va-gem va va-1x"></span>
                                                                    </th>
                                                                </tr>
                                                                <?php
                                                                foreach ($vainkeur_badges as $badge) : ?>
                                                                    <tr>
                                                                        <th>
                                                                            Trophée : <?php echo $badge->name; ?>
                                                                        </th>
                                                                        <th class="text-right">
                                                                            <?php the_field('recompense_badge', 'badges_' . $badge->term_id); ?>
                                                                        </th>
                                                                        <th class="text-right">
                                                                            <?php the_field('recompense_badge', 'badges_' . $badge->term_id); ?> <span class="va-gem va va-1x"></span>
                                                                        </th>
                                                                    </tr>
                                                                <?php endforeach; ?>
                                                                <?php if ($vainkeur_info['user_role'] == "administrator" || $vainkeur_info['user_role'] == "author") : ?>
                                                                    <tr>
                                                                        <th>
                                                                            Créateur : Top créés
                                                                        </th>
                                                                        <th class="text-right">
                                                                            <span class="text-muted">10 x</span> <?php echo $data_t_created['creator_nb_tops']; ?>
                                                                        </th>
                                                                        <th class="text-right">
                                                                            <?php echo $data_t_created['creator_nb_tops'] * 100; ?> <span class="va-gem va va-1x"></span>
                                                                        </th>
                                                                    </tr>
                                                                    <tr>
                                                                        <th>
                                                                            Créateur : Top générés
                                                                        </th>
                                                                        <th class="text-right">
                                                                            <span class="text-muted">1 x</span> <?php echo $data_t_created['total_completed_top']; ?>
                                                                        </th>
                                                                        <th class="text-right">
                                                                            <?php echo round($data_t_created['total_completed_top'] * 10); ?> <span class="va-gem va va-1x"></span>
                                                                        </th>
                                                                    </tr>
                                                                    <tr>
                                                                        <th>
                                                                            Créateur : Votes reçus sur les Tops créés
                                                                        </th>
                                                                        <th class="text-right">
                                                                            <span class="text-muted">0.1 x</span> <?php echo $data_t_created['creator_all_v']; ?>
                                                                        </th>
                                                                        <th class="text-right">
                                                                            <?php echo round($data_t_created['creator_all_v'] * 1); ?> <span class="va-gem va va-1x"></span>
                                                                        </th>
                                                                    </tr>
                                                                <?php endif; ?>
                                                                <tr>
                                                                    <th>
                                                                        Total collecté
                                                                    </th>
                                                                    <th class="text-right">

                                                                    </th>
                                                                    <th class="text-right">
                                                                        <?php echo $user_infos['money_vkrz']; ?> <span class="va-gem va va-1x"></span>
                                                                    </th>
                                                                </tr>
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