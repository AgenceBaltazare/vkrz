<?php
/*
    Template Name: Account - Creator
*/
global $uuiduser;
global $user_id;
global $user_infos;
get_header();
if (false === ( $data_t_created = get_transient( 'user_'.$user_id.'_get_creator_t' ) )) {
    $data_t_created = get_creator_t($user_id);
    set_transient( 'user_'.$user_id.'_get_creator_t', $data_t_created, DAY_IN_SECONDS );
} else {
    $data_t_created = get_transient( 'user_'.$user_id.'_get_creator_t' );
}
?>
<!-- BEGIN: Content-->
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
                        <div class="col-12">
                            <section class="app-user-view">
                                <div class="row match-height">
                                    <div class="col-sm-3 col-6">
                                        <div class="card text-center">
                                            <div class="card-body">
                                                <div class="mb-1">
                                                    <span class="ico4 va va-crossed-swords va-z-30"></span>
                                                </div>
                                                <h2 class="font-weight-bolder">
                                                    <?php echo number_format($data_t_created['creator_nb_tops'], 0, ",", " "); ?>
                                                </h2>
                                                <p class="card-text legende">
                                                    <?php echo ($data_t_created['creator_nb_tops'] > 1) ? "Tops créés" : "Top créé"; ?>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-3 col-6">
                                        <div class="card text-center">
                                            <div class="card-body">
                                                <div class="mb-1">
                                                    <span class="ico4 va-high-voltage va va-z-30"></span>
                                                </div>
                                                <h2 class="font-weight-bolder">
                                                    <?php echo number_format($data_t_created['creator_all_v'], 0, ",", " "); ?>
                                                </h2>
                                                <p class="card-text legende">
                                                    <?php echo ($data_t_created['creator_all_v'] > 1) ? "Votes générés" : "Vote généré"; ?>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-3 col-6">
                                        <div class="card text-center">
                                            <div class="card-body">
                                                <div class="mb-1">
                                                    <span class="ico4 va va-trophy va-z-30"></span>
                                                </div>
                                                <h2 class="font-weight-bolder">
                                                    <?php echo number_format($data_t_created['creator_all_t'], 0, ",", " "); ?>
                                                </h2>
                                                <p class="card-text legende">
                                                    <?php echo ($data_t_created['creator_all_t'] > 1) ? "Classements générés" : "Classement généré"; ?>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-3 col-6">
                                        <div class="card text-center">
                                            <div class="card-body">
                                                <div class="mb-1">
                                                    <span class="ico4 va va-glowing-star va-z-30"></span>
                                                </div>
                                                <h2 class="font-weight-bolder">
                                                    <?php echo $data_t_created['total_completed_top'] ? round($data_t_created['total_completed_top'] / $data_t_created['creator_all_t'] * 100).'%' : '0%'; ?>
                                                </h2>
                                                <p class="card-text legende">Taux moyen de finition</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </section>
                            <section id="basic-tabs-components">
                                <div class="tab-content">
                                    <div class="tab-pane active" id="tab3" aria-labelledby="profileIcon-tab" role="tabpanel">
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="card invoice-list-wrapper">
                                                    <div class="card-datatable table-responsive">
                                                        <table class="invoice-list-table table table-creator">
                                                            <thead>
                                                            <tr>
                                                                <th class="">
                                                                    Liste des <span class="t-rose"><?php echo $data_t_created['creator_nb_tops']; ?></span> Tops créés
                                                                </th>
                                                                <th class="text-right">
                                                                    <span class="va-high-voltage va va-lg"></span>
                                                                </th>
                                                                <th class="text-right">
                                                                    <span class="va va-trophy va-lg"></span>
                                                                </th>
                                                                <th class="text-right">
                                                                    <span class="va va-glowing-star va-lg"></span>
                                                                </th>
                                                                <th>

                                                                </th>
                                                            </tr>
                                                            </thead>
                                                            <tbody>
                                                            <?php
                                                            foreach($data_t_created['creator_tops'] as $item) : ?>
                                                                <?php if (!get_field('private_t', $item['top_id'])) : ?>
                                                                    <tr>
                                                                        <td>
                                                                            <div class="media-body">
                                                                                <div class="media-heading">
                                                                                    <h6 class="cart-item-title mb-0">
                                                                                        <a class="text-body" href="<?php the_permalink($item['top_id']); ?>">
                                                                                            Top <?php echo $item['nb_top']; ?> - <?php echo $item['top_title']; ?>
                                                                                        </a>
                                                                                    </h6>
                                                                                    <small class="cart-item-by legende">
                                                                                        <?php the_field('question_t', $item['top_id']); ?>
                                                                                    </small>
                                                                                </div>
                                                                            </div>
                                                                        </td>
                                                                        <td class="text-right">
                                                                            <?php echo number_format($item['top_votes'], 0, ",", " "); ?> <span class="ico3 va-high-voltage va va-lg"></span>
                                                                        </td>
                                                                        <td class="text-right">
                                                                            <?php echo $item['top_ranks']; ?> <span class="ico3 va va-trophy va-lg"></span>
                                                                        </td>
                                                                        <td class="text-right">
                                                                            <?php echo $item['top_completed'] ? round($item['top_completed'] / $item['top_ranks'] * 100).'%' : '0%'; ?>
                                                                        </td>
                                                                        <td class="text-right">
                                                                            <div class="d-flex align-items-center justify-content-end col-actions">
                                                                                <a class="mr-1" href="<?php the_permalink(get_page_by_path('liste-des-tops')); ?>?id_top=<?php echo $item['top_id']; ?>" data-toggle="tooltip" data-placement="top" title="" data-original-title="Voir tous les Tops">
                                                                                    <span class="ico va va-eyes va-lg">
                                                                                    </span>
                                                                                </a>
                                                                                <a class="mr-1" href="<?php the_permalink(get_page_by_path('elo')); ?>?id_top=<?php echo $item['top_id']; ?>" data-toggle="tooltip" data-placement="top" title="" data-original-title="Voir le Top mondial">
                                                                                    <span class="ico va va-globe va-lg">
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