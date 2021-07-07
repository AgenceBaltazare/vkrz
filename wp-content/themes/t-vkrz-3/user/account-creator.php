<?php
/*
    Template Name: Account - Creator
*/
global $uuiduser;
global $current_user;
global $user_id;
global $nb_user_votes;
global $user_full_data;
global $info_user_level;
global $list_t_done;
get_header();
global $user_role;
$list_t_begin   = $user_full_data[0]['list_user_ranking_begin'];
$data_t_created = get_creator_t($user_id);
$list_t_created = $data_t_created[0]['creator_tops'];
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
                <!--/ profile header -->

                <!-- profile info section -->
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
                                                    <?php echo $data_t_created[0]['creator_nb_tops']; ?>
                                                </h2>
                                                <p class="card-text legende">Tops créés</p>
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
                                                    <?php echo $data_t_created[0]['creator_all_v']; ?>
                                                </h2>
                                                <p class="card-text legende">Votes générés</p>
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
                                                    <?php echo $data_t_created[0]['creator_all_t']; ?>
                                                </h2>
                                                <p class="card-text legende">Classements générés</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-3 col-6">
                                        <div class="card text-center">
                                            <div class="card-body">
                                                <div class="mb-1">
                                                    <span class="ico4">💰</span>
                                                </div>
                                                <h2 class="font-weight-bolder">
                                                    <?php echo $data_t_created[0]['creator_money']; ?>
                                                </h2>
                                                <p class="card-text legende">Cagnotte</p>
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
                                                                    Liste des <span class="t-rose"><?php echo count($list_t_created); ?></span> Tops créés
                                                                </th>
                                                                <th class="text-right">
                                                                    💎
                                                                </th>
                                                                <th class="text-right">
                                                                    🏆
                                                                </th>
                                                                <th class="text-right">
                                                                    💰 <i class="fal fa-sort-alt"></i>
                                                                </th>
                                                                <th>

                                                                </th>
                                                            </tr>
                                                            </thead>
                                                            <tbody>
                                                            <?php
                                                            foreach($list_t_created as $item) : ?>
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
                                                                        <?php echo $item['top_votes']; ?> <span class="ico3">💎</span>
                                                                    </td>
                                                                    <td class="text-right">
                                                                        <?php echo $item['top_ranks']; ?> <span class="ico3">🏆</span>
                                                                    </td>
                                                                    <td class="text-right">
                                                                        <?php echo $item['top_money']; ?>
                                                                    </td>
                                                                    <td class="text-right">
                                                                        <div class="d-flex align-items-center justify-content-end col-actions">
                                                                            <a class="mr-1" href="<?php the_permalink(get_page_by_path('liste-des-tops')); ?>?id_top=<?php echo $item['top_id']; ?>" data-toggle="tooltip" data-placement="top" title="" data-original-title="Voir tous les classements">
                                                                                <span class="ico">
                                                                                    👀
                                                                                </span>
                                                                            </a>
                                                                            <a class="mr-1" href="<?php the_permalink(get_page_by_path('elo')); ?>?id_top=<?php echo $item['top_id']; ?>" data-toggle="tooltip" data-placement="top" title="" data-original-title="Voir le classement mondial">
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