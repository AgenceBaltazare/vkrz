<?php
/*
    Template Name: TAS
*/
global $user_id;
global $uuiduser;
global $user_tops;
get_header();
$list_user_tops = $user_tops['list_user_tops'];
$tops_sponso = new WP_Query(array(
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
                                                        <a href="<?php the_permalink(get_page_by_path('tops-sponso')); ?>/" class="btn btn-primary waves-effect">
                                                            Voir tous les Tops sponso en cours <span class="va va-wrapped-gift va-md"></span>
                                                        </a>
                                                    </div>
                                                </div>
                                                <div class="table-responsive">
                                                    <table class="table table-bestcreator">
                                                        <thead>
                                                            <tr>
                                                                <th>
                                                                    <small class="text-muted">Etat</small>
                                                                </th>
                                                                <th>
                                                                    <small class="text-muted">TOP</small>
                                                                </th>
                                                                <th class="text-center">
                                                                    <small class="text-muted">Participations</small>
                                                                </th>
                                                                <th class="text-center">
                                                                    <small class="text-muted">Récompense</small>
                                                                </th>
                                                                <th class="text-right">
                                                                    <small class="text-muted">Date du tirage</small>
                                                                </th>
                                                                <th class="text-right">
                                                                    <small class="text-muted">Gagnant</small>
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
                                                                $player_test = new WP_Query(array(
                                                                    'ignore_sticky_posts'       => true,
                                                                    'update_post_meta_cache'    => false,
                                                                    'no_found_rows'             => true,
                                                                    'post_type'                 => 'player',
                                                                    'orderby'                   => 'date',
                                                                    'order'                     => 'DESC',
                                                                    'posts_per_page'            => 1,
                                                                    'meta_query'                => array(
                                                                        'relation' => 'AND',
                                                                        array(
                                                                            'key'       => 'id_t_p',
                                                                            'value'     => $id_top,
                                                                            'compare'   => '='
                                                                        ),
                                                                        array(
                                                                            'key'       => 'uuid_vainkeur_p',
                                                                            'value'     => $uuiduser,
                                                                            'compare'   => '='
                                                                        )
                                                                    ),
                                                                ));
                                                                if ($player_test->have_posts()) {
                                                                    $state = "participation";
                                                                } else {
                                                                    $user_sinle_top_data = array_search($id_top, array_column($list_user_tops, 'id_top'));
                                                                    if ($user_sinle_top_data !== false) {
                                                                        $state = $list_user_tops[$user_sinle_top_data]['state'];
                                                                    } else {
                                                                        $state = "todo";
                                                                    }
                                                                }
                                                                wp_reset_query();
                                                                $top_question   = get_field('question_t', $id_top);
                                                                $top_title      = get_the_title($id_top);
                                                            ?>
                                                                <tr>
                                                                    <td>
                                                                        <?php if ($state == "participation") : ?>
                                                                            <div class="badge badge-success">Déjà fait !</div>
                                                                        <?php elseif ($state == "begin" || $state == "done") : ?>
                                                                            <div class="badge badge-warning">En cours</div>
                                                                        <?php else : ?>
                                                                            <div class="badge badge-primary">A faire</div>
                                                                        <?php endif; ?>
                                                                    </td>
                                                                    <td>
                                                                        <div class="d-flex align-items-center">
                                                                            <div class="avatar">
                                                                                <?php
                                                                                $minia = get_the_post_thumbnail_url($top_id, 'large')
                                                                                ?>
                                                                                <span class="avatar-picture avatar-top" style="background-image: url(<?php echo $minia; ?>);"></span>
                                                                                <?php
                                                                                foreach (get_the_terms($top_id, 'categorie') as $cat) {
                                                                                    $cat_id     = $cat->term_id;
                                                                                    $cat_name   = $cat->name;
                                                                                }
                                                                                ?>
                                                                                <span class="user-niveau">
                                                                                    <?php the_field('icone_cat', 'term_' . $cat_id); ?>
                                                                                </span>
                                                                            </div>
                                                                            <div class="font-weight-bold topnamebestof">
                                                                                <div class="media-body">
                                                                                    <div class="media-heading">
                                                                                        <h6 class="cart-item-title mb-0">
                                                                                            <a class="text-body" href="<?php the_permalink($top_id); ?>">
                                                                                                Top <?php the_field('count_contenders_t', $top_id); ?> <span class="ico">⚡</span> <?php echo get_the_title($top_id); ?>
                                                                                            </a>
                                                                                        </h6>
                                                                                        <small class="cart-item-by legende">
                                                                                            <?php the_field('question_t', $top_id); ?>
                                                                                        </small>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </td>

                                                                    <td class="text-center">
                                                                        <?php echo $players->post_count; ?>
                                                                    </td>

                                                                    <td class="text-center">
                                                                        <?php the_field('gain_champs_1_t_sponso'); ?> <br>
                                                                        <?php the_field('gain_champs_2_t_sponso'); ?>
                                                                    </td>

                                                                    <td class="text-right">
                                                                        <?php
                                                                        $date_tas = get_field('date_fin_de_la_sponso_t_sponso');
                                                                        echo $date_tas;
                                                                        ?>
                                                                    </td>

                                                                    <td class="text-right">


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
                                Si on restait connecté ? <span class="va va-right-facing-fist va-2x"></span> <span class="va va-left-facing-fist va-2x"></span>
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