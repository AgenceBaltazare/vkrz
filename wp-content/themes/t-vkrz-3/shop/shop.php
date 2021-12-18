<?php
/*
    Template Name: Shop
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
$solde_disponible = $user_infos['current_money_vkrz'];
?>
<div class="app-content content ecommerce-application">
    <div class="content-overlay"></div>
    <div class="header-navbar-shadow"></div>
    <div class="content-wrapper">
        <div class="content-body">
            <div class="valid-commande">
                <div class="alert alert-info alert-dismissible d-flex align-items-center justify-content-between p-1" role="alert">
                    <div class="alert-body">
                        Ta commande est bien passée 👌
                    </div>
                    <button type="button" class="btn btn-outline-info waves-effect" data-dismiss="alert" aria-label="Close">
                        Fermer
                    </button>
                </div>
            </div>
            <section id="wishlist" class="grid-view wishlist-items mt-2">
                <?php
                $shop = new WP_Query(array(
                    'ignore_sticky_posts'    => true,
                    'update_post_meta_cache' => false,
                    'no_found_rows'          => true,
                    'post_type'              => 'produit',
                    'orderby'                => 'date',
                    'order'                  => 'DESC',
                    'posts_per_page'         => -1
                ));
                $p = 1;
                while ($shop->have_posts()) : $shop->the_post(); ?>

                    <div class="card ecommerce-card">
                        <div class="item-img text-center">
                            <?php
                            if (has_post_thumbnail()) {
                                the_post_thumbnail('large', array('class' => 'img-fluid'));
                            }
                            ?>
                        </div>
                        <div class="card-body">
                            <div class="item-wrapper">
                                <div class="item-rating">
                                    <!--
                                    <div class="row avg-sessions">
                                        <div class="progress progress-bar-primary" style="height: 6px">
                                            <div class="progress-bar" role="progressbar" aria-valuenow="50" aria-valuemin="50" aria-valuemax="100" style="width: 50%"></div>
                                        </div>
                                    </div>
                                    -->
                                </div>
                                <div class="item-cost">
                                    <h6 class="item-price">
                                        <?php echo number_format(get_field('montant_produit'), 0, ",", " "); ?> <span class="m-l-5 va-gem va va-lg"></span>
                                    </h6>
                                </div>
                            </div>
                            <div class="item-name">
                                <h3>
                                    <?php the_title(); ?>
                                </h3>
                            </div>
                            <div class="card-text text-muted">
                                <?php the_field('description_produit'); ?>
                            </div>
                        </div>
                        <div class="item-options text-center px-1 pb-1 pt-0">
                            <?php if (get_field('reserve_aux_createurs_produit')) : ?>
                                <?php if ($vainkeur_info['user_role'] == "administrator" || $vainkeur_info['user_role'] == "author") : ?>
                                    <button type="button" class="btn btn-outline-primary w-100 waves-effect" data-toggle="modal" data-target="#cart-<?php echo $p; ?>">
                                        <span class="add-to-cart">Commander</span>
                                    </button>
                                <?php else : ?>
                                    <button type="button" class="btn btn-primary w-100 disabled">
                                        <span class="add-to-cart">Réserver aux créateurs</span>
                                    </button>
                                <?php endif; ?>

                            <?php else : ?>
                                <button type="button" class="btn btn-outline-primary w-100 waves-effect" data-toggle="modal" data-target="#cart-<?php echo $p; ?>">
                                    <span class="add-to-cart">Commander</span>
                                </button>
                            <?php endif; ?>

                        </div>
                    </div>
                    <div class="modal fade text-start modal-primary" id="cart-<?php echo $p; ?>" tabindex="-1" aria-labelledby="myModalLabel160" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header justify-content-between d-flex align-items-center">
                                    <h5 class="modal-title" id="myModalLabel160"><?php the_title(); ?></h5>
                                    <h5><?php echo number_format(get_field('montant_produit'), 0, ",", " "); ?> <span class="m-l-5 va-gem va va-lg"></span></h5>
                                </div>
                                <div class="modal-body">
                                    <?php if ($solde_disponible >= get_field('montant_produit')) : ?>
                                        <p>
                                            Tu recevras ta commande par email (<span class="t-rose"><?php echo $user_infos['user_email']; ?></span>) dans les 5 prochains jours.
                                            Promi, juré <span class="m-l-5 va-water va va-lg"></span>
                                        </p>
                                    <?php else : ?>
                                        <p class="">
                                            Solde insuffisant malheureusement <span class="m-l-5 va-anxious-face-with-sweat va va-lg"></span>
                                            <br>
                                            Il te manque <?php echo get_field('montant_produit') - $solde_disponible; ?> <span class="m-l-5 va-gem va va-lg"></span>
                                        </p>
                                    <?php endif; ?>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-outline-danger waves-effect" data-dismiss="modal">Annuler</button>
                                    <?php if ($solde_disponible >= get_field('montant_produit')) : ?>
                                        <button type="button" class="ordershop btn btn-primary waves-effect waves-float waves-light" data-dismiss="modal" data-user_email="<?php echo $user_infos['user_email']; ?>" data-idproduit="<?php the_ID(); ?>" data-uuid="<?php echo $user_infos['uuid_user_vkrz']; ?>" data-price="<?php the_field('montant_produit'); ?>" data-idvainkeur="<?php echo $user_infos['id_vainkeur']; ?>">
                                            Valider la commande
                                        </button>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>

                <?php $p++;
                endwhile; ?>
            </section>
        </div>
    </div>
</div>
<?php get_footer(); ?>