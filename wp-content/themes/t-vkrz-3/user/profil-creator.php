<?php
/*
    Template Name: Profil - Creator
*/
global $vainkeur_id;
if(isset($_GET['creator_id'])){
    $vainkeur_id  = $_GET['creator_id'];
}
else{
    header('Location: ' . get_bloginfo('url'));
}
global $uuiduser;
global $user_id;
global $user_infos;
get_header();

if (false === ( $data_t_created = get_transient( 'user_'.$vainkeur_id.'_get_creator_t' ) )) {
    $data_t_created = get_creator_t($vainkeur_id);
    set_transient( 'user_'.$vainkeur_id.'_get_creator_t', $data_t_created, DAY_IN_SECONDS );
} else {
    $data_t_created = get_transient( 'user_'.$vainkeur_id.'_get_creator_t' );
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
                                                    <span class="ico4">⚔️</span>
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
                                                    <span class="ico4">💎</span>
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
                                                    <span class="ico4">🏆</span>
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
                                                    <span class="ico4">🌟</span>
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
                                                                    💎
                                                                </th>
                                                                <th class="text-right">
                                                                    🏆
                                                                </th>
                                                                <th class="text-right">
                                                                    🌟
                                                                </th>
                                                                <th>

                                                                </th>
                                                            </tr>
                                                            </thead>
                                                            <tbody>
                                                            <?php
                                                            foreach($data_t_created['creator_tops'] as $item) : ?>
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
                                                                        <?php echo number_format($item['top_votes'], 0, ",", " "); ?> <span class="ico3">💎</span>
                                                                    </td>
                                                                    <td class="text-right">
                                                                        <?php echo number_format($item['top_ranks'], 0, ",", " "); ?> <span class="ico3">🏆</span>
                                                                    </td>
                                                                    <td class="text-right">
                                                                        <?php echo $item['top_completed'] ? round($item['top_completed'] / $item['top_ranks'] * 100).'%' : '0%'; ?>
                                                                    </td>
                                                                    <td class="text-right">
                                                                        <div class="d-flex align-items-center justify-content-end col-actions">
                                                                            <a class="mr-1" href="<?php the_permalink(get_page_by_path('liste-des-tops')); ?>?id_top=<?php echo $item['top_id']; ?>" data-toggle="tooltip" data-placement="top" title="" data-original-title="Voir tous les Tops">
                                                                                <span class="ico">
                                                                                    👀
                                                                                </span>
                                                                            </a>
                                                                            <a class="mr-1" href="<?php the_permalink(get_page_by_path('elo')); ?>?id_top=<?php echo $item['top_id']; ?>" data-toggle="tooltip" data-placement="top" title="" data-original-title="Voir le Top mondial">
                                                                                <span class="ico">
                                                                                    🌍
                                                                                </span>
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