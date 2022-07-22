<?php
/*
    Template Name: Users Ranks
*/
if (isset($_GET['id_top'])) {
    $id_top  = $_GET['id_top'];
} else {
    header('Location: ' . get_bloginfo('url'));
}
get_header();
global $id_vainkeur;
global $top_infos;
$top_datas = get_top_data($id_top);
?>
<div class="app-content content">
    <div class="content-overlay"></div>
    <div class="content-wrapper">
        <div class="content-body mt-2">

            <div class="intro-mobile">
                <div class="tournament-heading text-center">
                    <h3 class="mb-0 t-titre-tournoi">
                        Liste de tous les Tops <?php echo $top_infos['top_number']; ?> <span class="ico text-center va va-trophy va-lg"></span> <?php echo $top_infos['top_title']; ?>
                    </h3>
                    <h4 class="mb-0">
                        <?php echo $top_infos['top_question']; ?>
                    </h4>
                </div>
            </div>

            <div class="classement">
                <div class="row">
                    <div class="col-md-8">
                        <?php
                        $all_users_ranks_of_t = new WP_Query(array(
                            'post_type'                     => 'classement',
                            'posts_per_page'                => '-1',
                            'post_status'                   => 'publish',
                            'ignore_sticky_posts'           => true,
                            'update_post_meta_cache'        => false,
                            'no_found_rows'                 => true,
                            'meta_query' => array(
                                'relation' => 'AND',
                                array(
                                    'key'       => 'done_r',
                                    'value'     => 'done',
                                    'compare'   => '=',
                                ),
                                array(
                                    'key'       => 'id_tournoi_r',
                                    'value'     => $id_top,
                                    'compare'   => '=',
                                )
                            )
                        ));
                        ?>
                        <section id="profile-info">
                            <?php if ($all_users_ranks_of_t->have_posts()) : ?>
                                <div class="row" id="table-bordered">
                                    <div class="col-12">
                                        <div class="card">
                                            <div class="card-header">
                                                <h4 class="card-title pt-1 pb-1">
                                                    <?php echo $all_users_ranks_of_t->post_count; ?> <span class="va va-trophy va-lg"></span> TopList générées pour ce Top !
                                                </h4>
                                            </div>
                                            <div class="table-responsive">
                                                <div class="dataTables_wrapper dt-bootstrap4 no-footer">
                                                    <table class="invoice-list-table table table-tdone dataTable no-footer">
                                                        <thead>
                                                            <tr>
                                                                <th>
                                                                    <span class="text-muted">
                                                                        Vainkeurs
                                                                    </span>
                                                                </th>
                                                                <th>
                                                                    <span class="text-muted">
                                                                        Podium
                                                                    </span>
                                                                </th>
                                                                <th class="text-right">
                                                                    <span class="text-muted">
                                                                        Voir
                                                                    </span>
                                                                </th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php while ($all_users_ranks_of_t->have_posts()) : $all_users_ranks_of_t->the_post(); ?>
                                                                <tr>
                                                                    <td class="vainkeur-table">
                                                                        <?php
                                                                        $id_rank                 = get_the_ID();
                                                                        $uuid_user_r             = get_field('uuid_user_r', $id_rank);
                                                                        $vainkeur_data_selected  = find_vkrz_user($uuid_user_r);
                                                                        ?>
                                                                        <span class="avatar">
                                                                            <?php if ($vainkeur_data_selected) : ?>
                                                                                <a href="<?php echo esc_url(get_author_posts_url($vainkeur_data_selected['id_vainkeur'])); ?>">
                                                                                    <span class="avatar-picture" style="background-image: url(<?php echo $vainkeur_data_selected['avatar']; ?>);"></span>
                                                                                </a>
                                                                            <?php else : ?>
                                                                                <span class="avatar-picture" style="background-image: url(<?php echo $vainkeur_data_selected['avatar']; ?>);"></span>
                                                                            <?php endif; ?>
                                                                            <?php if ($vainkeur_data_selected) : ?>
                                                                                <span class="user-niveau">
                                                                                    <?php echo $vainkeur_data_selected['level']; ?>
                                                                                </span>
                                                                            <?php endif; ?>
                                                                        </span>
                                                                        <span class="font-weight-bold championname">
                                                                            <?php if ($vainkeur_data_selected) : ?>
                                                                                <a href="<?php echo esc_url(get_author_posts_url($vainkeur_data_selected['id_vainkeur'])); ?>">
                                                                                    <?php echo $vainkeur_data_selected['pseudo']; ?>
                                                                                    <?php if ($vainkeur_data_selected) : ?>
                                                                                        <span class="user-niveau-xs">
                                                                                            <?php echo $vainkeur_data_selected['level']; ?>
                                                                                        </span>
                                                                                    <?php endif; ?>
                                                                                    <?php if ($vainkeur_data_selected['user_role'] == "administrator") : ?>
                                                                                        <span class="ico va va-vkrzteam va-lg" data-toggle="tooltip" data-placement="top" title="" data-original-title="TeamVKRZ">
                                                                                        </span>
                                                                                    <?php endif; ?>
                                                                                    <?php if ($vainkeur_data_selected['user_role'] == "administrator" || $vainkeur_data_selected['user_role'] == "author") : ?>
                                                                                        <span class="ico va va-man-singer va-lg" data-toggle="tooltip" data-placement="top" title="" data-original-title="Créateur de Tops">
                                                                                        </span>
                                                                                    <?php endif; ?>
                                                                                </a>
                                                                            <?php else : ?>
                                                                                <i>Anonyme</i>
                                                                            <?php endif; ?>
                                                                            <!--
                                                                            UUID    : <?php the_field('uuid_user_r', $id_rank); ?>
                                                                            ID rank : <?php echo $id_rank; ?>
                                                                            Date    : <?php echo get_the_date('d/m/Y - H:i:s', $id_rank); ?>
                                                                            -->
                                                                        </span>
                                                                    </td>
                                                                    <td>
                                                                        <?php
                                                                        $user_top3 = get_user_ranking($id_rank, 3);
                                                                        $l = 1;
                                                                        foreach ($user_top3 as $top) : ?>

                                                                            <div data-toggle="tooltip" data-popup="tooltip-custom" data-placement="bottom" data-original-title="<?php echo get_the_title($top); ?>" class="avatartop3 avatar pull-up">
                                                                                <?php if (get_field('visuel_instagram_contender', $top)) : ?>
                                                                                    <img src="<?php the_field('visuel_instagram_contender', $top); ?>" alt="<?php echo get_the_title($top); ?>">
                                                                                <?php else : ?>
                                                                                    <?php $illu = get_the_post_thumbnail_url($top, 'thumbnail'); ?>
                                                                                    <img src="<?php echo $illu; ?>" alt="<?php echo get_the_title($top); ?>">
                                                                                <?php endif; ?>
                                                                            </div>

                                                                        <?php $l++;
                                                                            if ($l == 4) break;
                                                                        endforeach; ?>
                                                                    </td>

                                                                    <td class="text-right">
                                                                        <a href="<?php the_permalink($id_rank); ?>" class="mr-1 btn btn-outline-primary waves-effect">
                                                                            <span class="ico ico-reverse va va-eyes va-lg"></span>
                                                                        </a>
                                                                    </td>

                                                                </tr>
                                                            <?php endwhile; ?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </section>
                    </div>

                    <div class="col-md-3 offset-md-1">

                        <div class="related">

                            <div class="infoelo">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="card text-left">
                                            <?php
                                            $creator_id         = get_post_field('post_author', $id_top);
                                            $creator_uuiduser   = get_field('uuiduser_user', 'user_' . $creator_id);
                                            $creator_data       = get_user_infos($creator_uuiduser);
                                            ?>
                                            <div class="card-body">
                                                <h4 class="card-title">
                                                    <?php
                                                    date_default_timezone_set('Europe/Paris');
                                                    $origin     = new DateTime(get_the_date('Y-m-d', $id_top));
                                                    $target     = new DateTime(date('Y-m-d'));
                                                    $interval   = $origin->diff($target);
                                                    if ($interval->days == 0) {
                                                        $info_date = "aujourd'hui";
                                                    } elseif ($interval->days == 1) {
                                                        $info_date = "hier";
                                                    } else {
                                                        $info_date = "depuis " . $interval->days . " jours";
                                                    }
                                                    ?>
                                                    <span class="ico va va-birthday-cake va-lg"></span> Créé <span class="t-violet"><?php echo $info_date; ?></span> par :
                                                </h4>
                                                <div class="employee-task d-flex justify-content-between align-items-center">
                                                    <a href="<?php echo $creator_data['profil']; ?>" class="d-flex flex-row link-to-creator">
                                                        <div class="avatar me-75 mr-1">
                                                            <img src="<?php echo $creator_data['avatar']; ?>" class="circle" width="42" height="42" alt="Avatar">
                                                        </div>
                                                        <div class="my-auto">
                                                            <h3 class="mb-0">
                                                                <?php echo $creator_data['pseudo']; ?> <br>
                                                                <span class="ico" data-toggle="tooltip" data-placement="top" title="" data-original-title="Niveau actuel">
                                                                    <?php echo $creator_data['level']; ?>
                                                                </span>
                                                                <?php if ($creator_data['user_role']  == "administrator") : ?>
                                                                    <span class="ico va va-vkrzteam va-lg" data-toggle="tooltip" data-placement="top" title="" data-original-title="TeamVKRZ">
                                                                    </span>
                                                                <?php endif; ?>
                                                                <?php if ($creator_data['user_role']  == "administrator" || $creator_data['user_role'] == "author") : ?>
                                                                    <span class="ico va va-man-singer va-lg" data-toggle="tooltip" data-placement="top" title="" data-original-title="Créateur de Tops">
                                                                    </span>
                                                                <?php endif; ?>
                                                            </h3>
                                                        </div>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="card text-center">
                                            <div class="card-body">
                                                <div class="mb-1">
                                                    <span class="ico4 va-high-voltage va va-md"></span>
                                                </div>
                                                <h2 class="font-weight-bolder">
                                                    <?php echo $top_datas['nb_votes']; ?>
                                                </h2>
                                                <p class="card-text legende">
                                                    <?php if ($top_datas['nb_votes'] <= 1) : ?>
                                                        vote
                                                    <?php else : ?>
                                                        Votes
                                                    <?php endif; ?>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="card text-center">
                                            <div class="card-body">
                                                <div class="mb-1">
                                                    <span class="ico4 va-trophy va va-md"></span>
                                                </div>
                                                <h2 class="font-weight-bolder">
                                                    <?php echo $all_users_ranks_of_t->post_count; ?>
                                                </h2>
                                                <p class="card-text legende">
                                                    <?php if ($all_users_ranks_of_t->post_count <= 1) : ?>
                                                        Top
                                                    <?php else : ?>
                                                        Tops
                                                    <?php endif; ?>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title">
                                        <span class="ico va va-speech-balloon va-lg"></span> <?php echo $top_datas['nb_comments']; ?>
                                        <?php if ($top_datas['nb_comments'] <= 1) : ?>
                                            Commentaire
                                        <?php else : ?>
                                            Commentaires
                                        <?php endif; ?>
                                    </h4>
                                    <h6 class="card-subtitle text-muted mb-1">
                                        Tout ce qui te passe par la tête à propos de ce Top mérite d'être partagé avec les autres Vainkeurs.
                                    </h6>
                                    <a href="<?php echo get_the_permalink(get_page_by_path('discuz')) . '?id_top=' . $id_top; ?>" class="btn btn-outline-primary waves-effect">
                                        Lire & poster
                                    </a>
                                </div>
                            </div>

                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title">
                                        <span class="ico">🌎</span> Voir la TopList mondiale
                                    </h4>
                                    <h6 class="card-subtitle text-muted mb-1">
                                        Découvre le classement complet généré par les <?php echo $top_datas['nb_votes']; ?> votes !
                                    </h6>
                                    <a href="<?php the_permalink(get_page_by_path('elo')); ?>?id_top=<?php echo $id_top; ?>" class="btn btn-outline-primary waves-effect">
                                        Voir la TopList mondiale
                                    </a>
                                </div>
                            </div>

                            <?php if (!get_top_done_by_current_vainkeur($id_top, $id_vainkeur)) : ?>
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="card-title">
                                            <span class="ico va va-victory-hand va-lg"></span> A toi de jouer
                                        </h4>
                                        <h6 class="card-subtitle text-muted mb-1">
                                            Toi aussi fais ta TopList afin de faire bouger les positions !
                                        </h6>
                                        <a href="<?php the_permalink($id_top); ?>" class="btn btn-outline-primary waves-effect">
                                            Faire ma propre TopList
                                        </a>
                                    </div>
                                </div>
                            <?php endif; ?>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php get_footer(); ?>