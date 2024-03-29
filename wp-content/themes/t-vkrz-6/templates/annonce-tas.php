<?php
/*
    Template Name: TAS
*/
global $id_vainkeur;
global $uuid_vainkeur;
get_header();
if (is_user_logged_in() && env() != "local" && $id_vainkeur) {
    if (false === ($user_tops = get_transient('user_' . $user_id . '_get_user_tops'))) {
        $user_tops = get_user_tops($id_vainkeur);
        set_transient('user_' . $user_id . '_get_user_tops', $user_tops, DAY_IN_SECONDS);
    } else {
        $user_tops = get_transient('user_' . $user_id . '_get_user_tops');
    }
} else {
    $user_tops  = get_user_tops($id_vainkeur);
}
$list_user_tops = $user_tops['list_user_tops_done_ids'];
$tops_sponso    = new WP_Query(array(
    'post_type'                 => 'tournoi',
    'orderby'                   => 'date',
    'order'                     => 'DESC',
    'posts_per_page'            => -1,
    'ignore_sticky_posts'       => true,
    'update_post_meta_cache'    => false,
    'no_found_rows'             => true,
    'tax_query'                 => array(
        'relation' => 'AND',
        array(
            'taxonomy' => 'type',
            'field'    => 'slug',
            'terms'    => array('sponso'),
            'operator' => 'IN'
        ),
        array(
            'taxonomy' => 'type',
            'field'    => 'slug',
            'terms'    => array('private'),
            'operator' => 'NOT IN'
        ),
    ),
));
$tops_sponso_old = new WP_Query(array(
    'post_type'                 => 'tournoi',
    'orderby'                   => 'date',
    'order'                     => 'DESC',
    'posts_per_page'            => -1,
    'ignore_sticky_posts'       => true,
    'update_post_meta_cache'    => false,
    'no_found_rows'             => true,
    'tax_query'                 => array(
        'relation' => 'AND',
        array(
            'taxonomy' => 'type',
            'field'    => 'slug',
            'terms'    => array('sponso'),
            'operator' => 'NOT IN'
        ),
        array(
            'taxonomy' => 'type',
            'field'    => 'slug',
            'terms'    => array('private'),
            'operator' => 'NOT IN'
        ),
    ),
    'meta_query'      => array(
        array(
            'key'     => 'date_fin_de_la_sponso_t_sponso',
            'compare' => '!=',
            'value'   => ''
        ),
    ),
));
?>
<div class="app-content content evolution">
    <div class="content-wrapper">
        <div class="content-body">
            <section id="pricing-plan">
                <div class="text-center">
                    <h1 class="mt-1">
                        Annonce des tirages au sort <span class="va va-four-leaf-clover va-1x"></span>
                    </h1>
                    <p class="mb-4 mt-1">
                        On vous souhaite de figurer sur cette page <span class="va va-hugging-face va-1x"></span>
                    </p>
                </div>

                <div class="classement">
                    <div class="container-fluid">
                        <section id="profile-info">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="row" id="table-bordered">
                                        <div class="col-12">
                                            <div class="card">
                                                <div class="card-header justify-content-between align-items-center">
                                                    <h4 class="card-title pt-1 pb-1 mb-1 mb-sm-0">
                                                        Liste de tous les <span class="t-rose">tirages au sort</span> passés & futur.
                                                    </h4>
                                                    <div class="cta text-right d-flex flex-column">
                                                        <a href="<?php the_permalink(get_page_by_path('tops-sponso')); ?>" class="btn btn-primary waves-effect">
                                                            Voir tous les Tops sponso en cours <span class="va va-wrapped-gift va-md"></span>
                                                        </a>
                                                    </div>
                                                </div>
                                                <div class="table-responsive">
                                                    <table class="table table-tas">
                                                        <thead>
                                                            <tr>
                                                                <th class="text-center">
                                                                    <span class="text-muted">Tirage</span>
                                                                </th>
                                                                <th>
                                                                    <span class="text-muted">TOP</span>
                                                                </th>
                                                                <th class="text-center">
                                                                    <span class="text-muted">Participants</span>
                                                                </th>
                                                                <th class="text-left">
                                                                    <span class="text-muted">Récompense</span>
                                                                </th>
                                                                <th class="text-center">
                                                                    <span class="text-muted">Gagnant</span>
                                                                </th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php $i = 1;
                                                            while ($tops_sponso->have_posts()) : $tops_sponso->the_post();
                                                                $id_top             = get_the_ID();
                                                                $illu               = get_the_post_thumbnail_url($id_top, 'medium');
                                                                $top_datas          = get_top_data($id_top);
                                                                $players = new WP_Query(array(
                                                                    'ignore_sticky_posts'       => true,
                                                                    'update_post_meta_cache'    => false,
                                                                    'no_found_rows'             => true,
                                                                    'post_type'                 => 'player',
                                                                    'orderby'                   => 'date',
                                                                    'order'                     => 'DESC',
                                                                    'posts_per_page'            => -1,
                                                                    'meta_query'                => array(
                                                                        array(
                                                                            'key'       => 'id_t_p',
                                                                            'value'     => $id_top,
                                                                            'compare'   => '='
                                                                        )
                                                                    ),
                                                                ));
                                                                if (in_array($id_top, $user_tops['list_user_tops_done_ids'])) {
                                                                    $state = "participation";
                                                                } else {
                                                                    $user_sinle_top_data = array_search($id_top, array_column($list_user_tops, 'id_top'));
                                                                    if ($user_sinle_top_data !== false) {
                                                                        $state = $list_user_tops[$user_sinle_top_data]['state'];
                                                                    } else {
                                                                        $state = "todo";
                                                                    }
                                                                }
                                                                $players->reset_postdata();
                                                                wp_reset_query();
                                                            ?>
                                                                <tr>
                                                                    <td class="text-center t-rose">
                                                                        <?php
                                                                        $date_tas = get_field('date_fin_de_la_sponso_t_sponso', $id_top);
                                                                        echo $date_tas;
                                                                        ?>
                                                                        <br>
                                                                        <a href="<?php the_permalink($id_top); ?>">
                                                                            <?php if (get_field('gagnant_idplayer_t_sponso', $id_top)) : ?>
                                                                                <div class="badge badge-danger">Terminé</div>
                                                                            <?php else : ?>
                                                                                <?php if ($state == "participation") : ?>
                                                                                    <div class="badge badge-success">Déjà fait !</div>
                                                                                <?php elseif ($state == "begin" || $state == "done") : ?>
                                                                                    <div class="badge badge-warning">Finir</div>
                                                                                <?php else : ?>
                                                                                    <div class="badge badge-primary">Participer</div>
                                                                                <?php endif; ?>
                                                                            <?php endif; ?>
                                                                        </a>
                                                                    </td>

                                                                    <td>
                                                                        <?php get_template_part('partials/top-card'); ?>
                                                                    </td>

                                                                    <td class="text-center">
                                                                        <?php 
                                                                        if(get_field('type_de_fin_t_sponso', $id_top) == "mail_1"){
                                                                            echo $players->post_count;
                                                                        }
                                                                        else{
                                                                            echo "🤷";
                                                                        }
                                                                        ?>
                                                                    </td>

                                                                    <td class="text-left">
                                                                        <?php the_field('gain_champs_1_t_sponso', $id_top); ?> <?php the_field('gain_champs_2_t_sponso', $id_top); ?>
                                                                    </td>

                                                                    <td class="text-center">
                                                                        <?php if (get_field('gagnant_idplayer_t_sponso', $id_top) || get_field('gagnant_non_inscrit_t_sponso', $id_top)) : ?>
                                                                            <div class="scale-xs">
                                                                                <?php if (get_field('gagnant_non_inscrit_t_sponso', $id_top)) : ?>
                                                                                    <span class="font-weight-bold championname">
                                                                                        <?php the_field('gagnant_non_inscrit_t_sponso', $id_top); ?>
                                                                                    </span>
                                                                                <?php else : ?>
                                                                                    <?php
                                                                                    $gagnant_id              = get_field('gagnant_idplayer_t_sponso', $id_top);
                                                                                    $gagnant_uuid            = get_field('uuid_vainkeur_p', $gagnant_id);
                                                                                    $vainkeur_data_selected  = get_user_infos($gagnant_uuid);
                                                                                    global $vainkeur_data_selected;
                                                                                    get_template_part('partials/vainkeur-card');
                                                                                    ?>
                                                                                <?php endif; ?>
                                                                            </div>
                                                                        <?php else : ?>
                                                                            <span class="va va-exclamation-question va-md"></span>
                                                                        <?php endif; ?>
                                                                    </td>
                                                                </tr>
                                                            <?php $i++;
                                                            endwhile; ?>
                                                            <?php $i = 1;
                                                            while ($tops_sponso_old->have_posts()) : $tops_sponso_old->the_post();
                                                                $id_top             = get_the_ID();
                                                                $illu               = get_the_post_thumbnail_url($id_top, 'medium');
                                                                $top_datas          = get_top_data($id_top);
                                                                $players = new WP_Query(array(
                                                                    'ignore_sticky_posts'        => true,
                                                                    'update_post_meta_cache'    => false,
                                                                    'no_found_rows'                => true,
                                                                    'post_type'                    => 'player',
                                                                    'orderby'                    => 'date',
                                                                    'order'                        => 'DESC',
                                                                    'posts_per_page'            => -1,
                                                                    'meta_query'             => array(
                                                                        array(
                                                                            'key'       => 'id_t_p',
                                                                            'value'     => $id_top,
                                                                            'compare'   => '='
                                                                        )
                                                                    ),
                                                                ));
                                                                if (in_array($id_top, $user_tops['list_user_tops_done_ids'])) {
                                                                    $state = "participation";
                                                                } else {
                                                                    $user_sinle_top_data = array_search($id_top, array_column($list_user_tops, 'id_top'));
                                                                    if ($user_sinle_top_data !== false) {
                                                                        $state = $list_user_tops[$user_sinle_top_data]['state'];
                                                                    } else {
                                                                        $state = "todo";
                                                                    }
                                                                }
                                                                $players->reset_postdata();
                                                                wp_reset_query();
                                                            ?>
                                                                <tr>
                                                                    <td class="text-center">
                                                                        <?php
                                                                        $date_tas = get_field('date_fin_de_la_sponso_t_sponso', $id_top);
                                                                        echo "<strike>" . $date_tas;
                                                                        ?>
                                                                        <br>
                                                                        <a href="<?php the_permalink($id_top); ?>">
                                                                            <?php if ($state == "participation") : ?>
                                                                                <div class="badge badge-success">Déjà fait !</div>
                                                                            <?php else : ?>
                                                                                <div class="badge badge-danger">Terminé</div>
                                                                            <?php endif; ?>
                                                                        </a>
                                                                    </td>
                                                                    <td>
                                                                        <?php get_template_part('partials/top-card'); ?>
                                                                    </td>

                                                                    <td class="text-center">
                                                                        <?php echo $players->post_count; ?>
                                                                    </td>

                                                                    <td class="text-left">
                                                                        <?php the_field('gain_champs_1_t_sponso', $id_top); ?> <?php the_field('gain_champs_2_t_sponso', $id_top); ?>
                                                                    </td>

                                                                    <td class="text-center">
                                                                        <?php if (get_field('gagnant_idplayer_t_sponso', $id_top) || get_field('gagnant_non_inscrit_t_sponso', $id_top)) : ?>
                                                                            <div class="scale-xs">
                                                                                <?php if (get_field('gagnant_non_inscrit_t_sponso', $id_top)) : ?>
                                                                                    <span class="font-weight-bold championname">
                                                                                        <?php the_field('gagnant_non_inscrit_t_sponso', $id_top); ?>
                                                                                    </span>
                                                                                <?php else : ?>
                                                                                    <?php
                                                                                    $gagnant_id              = get_field('gagnant_idplayer_t_sponso', $id_top);
                                                                                    $gagnant_uuid            = get_field('uuid_vainkeur_p', $gagnant_id);
                                                                                    $vainkeur_data_selected  = get_user_infos($gagnant_uuid);
                                                                                    global $vainkeur_data_selected;
                                                                                    get_template_part('partials/vainkeur-card');
                                                                                    ?>
                                                                                <?php endif; ?>
                                                                            </div>
                                                                        <?php else : ?>
                                                                            <span class="va va-exclamation-question va-md"></span>
                                                                        <?php endif; ?>
                                                                    </td>
                                                                </tr>
                                                            <?php $i++;
                                                            endwhile; ?>
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

                <div class="row mt-5 match-height">

                    <div class="col-12">

                        <div class="bloc-result">
                            <h3>
                                Pour te tenir au courant des nouveaux Tops sponsos et des résultats 👇
                            </h3>
                            <div class="mt-10p">
                                <a href="https://discord.gg/w882sUnrhE" class="sociallink btn btn-outline-primary waves-effect mr-10p mt-10p" target="_blank">
                                    Discord
                                </a>
                                <a href="https://www.instagram.com/wearevainkeurz/" class="sociallink btn btn-outline-primary waves-effect mr-10p mt-10p" target="_blank">
                                    Insta
                                </a>
                                <a href="https://twitter.com/Vainkeurz" class="sociallink btn btn-outline-primary waves-effect mr-10p mt-10p" target="_blank">
                                    Twitter
                                </a>
                                <a href="https://www.tiktok.com/@vainkeurz" target="_blank" class="sociallink btn btn-outline-primary waves-effect mt-10p">
                                    TikTok
                                </a>
                            </div>

                        </div>

                    </div>

            </section>
        </div>
    </div>
</div>
<!-- END: Content-->
<?php get_footer(); ?>