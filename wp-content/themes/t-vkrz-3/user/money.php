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
                            <div class="row">
                                <div class="col-6 col-sm-12">
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
                                            <p class="card-text legende">
                                                Collection en tant que vainkeur
                                            </p>
                                            <small class="text-primary">Mis à jour en temps réel</small>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6 col-sm-12">
                                    <div class="card text-center">
                                        <div class="card-body text-center">
                                            <div class="mb-1">
                                                <span class="ico4 va va-gem-rose va va-z-85"></span>
                                            </div>
                                            <h2 class="font-weight-bolder">
                                                <?php if ($user_infos['money_creator_vkrz']) : ?>
                                                    <?php echo number_format($user_infos['money_creator_vkrz'], 0, ",", " "); ?>
                                                <?php else : ?>
                                                    -
                                                <?php endif; ?>
                                            </h2>
                                            <p class="card-text legende">
                                                Collection en tant que créateur
                                            </p>
                                            <small class="text-primary">Mis à jour tous les 24h</small>
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
                                            Collecte en tant que <span class="m-l-5 va-llama va va-1x"></span>
                                        </a>
                                    </li>
                                    <?php if ($vainkeur_info['user_role'] == "administrator" || $vainkeur_info['user_role'] == "author") : ?>
                                        <li class="nav-item">
                                            <a class="nav-link" id="homeIcon-tab" data-toggle="tab" href="#tab1" aria-controls="home" role="tab" aria-selected="false">
                                                Collecte en tant que <span class="m-l-5 va-man-singer va va-1x"></span>
                                            </a>
                                        </li>
                                    <?php endif; ?>
                                    <li class="nav-item">
                                        <a class="nav-link" id="profileIcon-tab" data-toggle="tab" href="#tab3" aria-controls="profile" role="tab" aria-selected="false">
                                            Historique des commandes
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
                                                                if ($vainkeur_badges) :
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
                                                                <?php endforeach;
                                                                endif; ?>
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
                                    <?php if ($vainkeur_info['user_role'] == "administrator" || $vainkeur_info['user_role'] == "author") : ?>
                                        <div class="tab-pane" id="tab1" aria-labelledby="profileIcon-tab" role="tabpanel">
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
                                                                            Créateur : Top créés
                                                                        </th>
                                                                        <th class="text-right">
                                                                            <span class="text-muted">1000 x</span> <?php echo $data_t_created['creator_nb_tops']; ?>
                                                                        </th>
                                                                        <th class="text-right">
                                                                            <?php echo $data_t_created['creator_nb_tops'] * 1000; ?> <span class="va-gem va va-1x"></span>
                                                                        </th>
                                                                    </tr>
                                                                    <tr>
                                                                        <th>
                                                                            Créateur : Top générés
                                                                        </th>
                                                                        <th class="text-right">
                                                                            <span class="text-muted">5 x</span> <?php echo $data_t_created['total_completed_top']; ?>
                                                                        </th>
                                                                        <th class="text-right">
                                                                            <?php echo round($data_t_created['total_completed_top'] * 5); ?> <span class="va-gem va va-1x"></span>
                                                                        </th>
                                                                    </tr>
                                                                    <tr>
                                                                        <th>
                                                                            Créateur : Votes reçus sur les Tops créés
                                                                        </th>
                                                                        <th class="text-right">
                                                                            <span class="text-muted">0.3 x</span> <?php echo $data_t_created['creator_all_v']; ?>
                                                                        </th>
                                                                        <th class="text-right">
                                                                            <?php echo round($data_t_created['creator_all_v'] * 0.3); ?> <span class="va-gem va va-1x"></span>
                                                                        </th>
                                                                    </tr>
                                                                    <tr>
                                                                        <th>
                                                                            Total collecté
                                                                        </th>
                                                                        <th class="text-right">

                                                                        </th>
                                                                        <th class="text-right">
                                                                            <?php echo $user_infos['money_creator_vkrz']; ?> <span class="va-gem va va-1x"></span>
                                                                        </th>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                    <div class="tab-pane" id="tab3" aria-labelledby="profileIcon-tab" role="tabpanel">
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="card invoice-list-wrapper">
                                                    <div class="card-datatable table-responsive">
                                                        <table class="invoice-list-table table table-tdone">
                                                            <thead>
                                                                <tr>
                                                                    <th class="">
                                                                        Produit commandé
                                                                    </th>
                                                                    <th class="text-right">
                                                                        Date
                                                                    </th>
                                                                    <th class="text-right">
                                                                        Montant
                                                                    </th>
                                                                    <th class="text-right">
                                                                        Etat
                                                                    </th>
                                                                </tr>
                                                            </thead>
                                                            <tbody class="nobold">
                                                                <?php
                                                                $transaction = new WP_Query(array(
                                                                    'ignore_sticky_posts'        => true,
                                                                    'update_post_meta_cache'     => false,
                                                                    'no_found_rows'              => true,
                                                                    'post_type'                  => 'transaction',
                                                                    'posts_per_page'             => -1,
                                                                    'meta_query'                 => array(
                                                                        array(
                                                                            'key'       => 'id_vainkeur_transaction',
                                                                            'value'     => $vainkeur_info['id_vainkeur'],
                                                                            'compare'   => '='
                                                                        )
                                                                    ),
                                                                ));
                                                                if ($transaction->have_posts()) :
                                                                    while ($transaction->have_posts()) : $transaction->the_post(); ?>

                                                                        <tr>
                                                                            <td>
                                                                                <?php echo get_the_title(get_field('id_produit_transaction')); ?>
                                                                            </td>
                                                                            <td class="text-right">
                                                                                <?php echo get_the_date('d/m/Y'); ?>
                                                                            </td>
                                                                            <td class="text-right">
                                                                                <?php the_field('montant_transaction'); ?> <span class="va-gem va va-1x"></span>
                                                                            </td>
                                                                            <td class="text-right">
                                                                                <?php if (get_field('etat_transaction') == "pending") : ?>
                                                                                    <span class="badge rounded-pill badge-light-warning me-1">En traitement</span>
                                                                                <?php elseif (get_field('etat_transaction') == "done") : ?>
                                                                                    <span class="badge rounded-pill badge-light-success me-1">Livré</span>
                                                                                <?php elseif (get_field('etat_transaction') == "problem") : ?>
                                                                                    <span class="badge rounded-pill badge-light-danger me-1">Incident</span>
                                                                                <?php endif; ?>
                                                                            </td>
                                                                        </tr>

                                                                    <?php endwhile; ?>
                                                                <?php else : ?>
                                                                    <tr>
                                                                        <td colspan="4">
                                                                            <span class="text-muted">Aucune commande effectuée depuis le shop</span>
                                                                        </td>
                                                                    </tr>
                                                                <?php endif; ?>
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