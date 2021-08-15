<?php
/*
    Template Name: Users Ranks
*/
if(isset($_GET['id_top'])){
    $id_top  = $_GET['id_top'];
}
else{
    header('Location: ' . get_bloginfo('url'));
}
get_header();
global $top_infos;
$top_datas = get_top_data($id_top);
?>
<div class="app-content content cover" style="background: url(<?php echo $top_infos['top_cover']; ?>) center center no-repeat">
    <div class="content-overlay"></div>
    <div class="content-wrapper">
    <div class="content-body mt-2">

        <div class="intro-mobile">
            <div class="tournament-heading text-center">
                <h3 class="mb-0 t-titre-tournoi">
                    Liste de tous les Tops <?php echo $top_infos['top_number']; ?> <span class="ico text-center">🏆</span> <?php echo $top_infos['top_title']; ?>
                </h3>
                <h4 class="mb-0">
                    <?php echo $top_infos['top_question']; ?>
                </h4>
            </div>
        </div>

        <div class="classement">
            <div class="container-fluid">
                <?php
                $all_users_ranks_of_t       = new WP_Query(array(
                    'post_type' => 'classement',
                    'posts_per_page' => '-1',
                    'post_status' => 'publish',
                    'ignore_sticky_posts'    => true,
                    'update_post_meta_cache' => false,
                    'no_found_rows'          => true,
                    'meta_query' => array(
                        array(
                            'key' => 'id_tournoi_r',
                            'value' => $id_top,
                            'compare' => '=',
                        )
                    )
                ));
                ?>
                <section id="profile-info">
                    <?php
                    if($all_users_ranks_of_t->have_posts()) : ?>
                        <div class="row" id="table-bordered">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h4 class="card-title pt-1 pb-1">
                                            Depuis le <?php echo $top_infos['top_date']; ?>, <?php echo $top_datas['nb_votes']; ?>💎 ont générés <?php echo $top_datas['nb_tops']; ?> 🏆
                                        </h4>
                                    </div>
                                    <div class="table-responsive">
                                        <table class="table">
                                            <thead>
                                            <tr>
                                                <th>
                                                    Vainkeurs
                                                </th>
                                                <th>Top 3</th>
                                                <th></th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                                <?php while ($all_users_ranks_of_t->have_posts()) : $all_users_ranks_of_t->the_post(); ?>
                                                    <tr>

                                                        <td>
                                                            <?php
                                                            $id_rank                 = get_the_ID();
                                                            $uuid_user_r             = get_field('uuid_user_r', $id_rank);
                                                            $vainkeur_data_selected  = find_vkrz_user($uuid_user_r);
                                                            ?>
                                                            <span class="avatar">
                                                                <?php if($vainkeur_data_selected): ?>
                                                                    <a href="<?php echo esc_url(get_author_posts_url($vainkeur_data_selected['id_vainkeur'])); ?>">
                                                                        <span class="avatar-picture" style="background-image: url(<?php echo $vainkeur_data_selected['avatar']; ?>);"></span>
                                                                    </a>
                                                                <?php else: ?>
                                                                    <span class="avatar-picture" style="background-image: url(<?php echo $vainkeur_data_selected['avatar']; ?>);"></span>
                                                                <?php endif; ?>
                                                                <?php if($vainkeur_data_selected): ?>
                                                                    <span class="user-niveau">
                                                                        <?php echo $vainkeur_data_selected['level']; ?>
                                                                    </span>
                                                                <?php endif; ?>
                                                            </span>
                                                            <span class="font-weight-bold championname">
                                                                <?php if($vainkeur_data_selected): ?>
                                                                    <a href="<?php echo esc_url(get_author_posts_url($vainkeur_data_selected['id_vainkeur'])); ?>">
                                                                         <?php echo $vainkeur_data_selected['pseudo']; ?>
                                                                         <?php if($vainkeur_data_selected['user_role'] == "administrator"): ?>
                                                                            <span class="ico" data-toggle="tooltip" data-placement="top" title="" data-original-title="TeamVKRZ">
                                                                                🦙
                                                                            </span>
                                                                        <?php endif; ?>
                                                                        <?php if($vainkeur_data_selected['user_role'] == "administrator" || $vainkeur_data_selected['user_role'] == "author"): ?>
                                                                            <span class="ico" data-toggle="tooltip" data-placement="top" title="" data-original-title="Créateur de Tops">
                                                                                🎨
                                                                            </span>
                                                                        <?php endif; ?>
                                                                    </a>
                                                                <?php else: ?>
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
                                                            $user_top3 = get_user_ranking($id_rank);
                                                            $l=1;
                                                            foreach($user_top3 as $top => $p): ?>

                                                                <div data-toggle="tooltip" data-popup="tooltip-custom" data-placement="bottom" data-original-title="<?php echo get_the_title($top); ?>" class="avatartop3 avatar pull-up">
                                                                    <?php $illu = get_the_post_thumbnail_url($top, 'thumbnail'); ?>
                                                                    <img src="<?php echo $illu; ?>" alt="Avatar">
                                                                </div>

                                                            <?php $l++; if($l==4) break; endforeach; ?>
                                                        </td>

                                                        <td>
                                                            <a href="<?php the_permalink($id_rank); ?>" class="mr-1 btn btn-outline-primary waves-effect">
                                                                <span class="ico ico-reverse">👀</span> le Top complet
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
                    <?php endif; ?>
                </section>
            </div>
        </div>
    </div>
    </div>
</div>
<?php get_footer(); ?>