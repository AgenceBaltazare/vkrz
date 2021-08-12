<?php
/*
    Template Name: Users Ranks
*/
global $uuiduser;
if(isset($_GET['id_top'])){
    $id_top  = $_GET['id_top'];
}
else{
    header('Location: ' . get_bloginfo('url'));
}
$display_titre      = get_field('ne_pas_afficher_les_titres_t', $id_top);
$rounded            = get_field('c_rounded_t', $id_top);
$illu               = wp_get_attachment_image_src(get_field('cover_t', $id_top), 'full');
$illu_url           = $illu[0];
get_header();
$top_title     = get_the_title($id_top);
$top_question  = get_field('question_t', $id_top);
$top_number    = get_numbers_of_contenders($id_top);
$top_datas     = get_tournoi_data($id_top, $uuiduser);
?>
<div class="app-content content cover" style="background: url(<?php echo $illu_url; ?>) center center no-repeat">
    <div class="content-overlay"></div>
    <div class="content-wrapper">
    <div class="content-body mt-2">

        <div class="intro-mobile">
            <div class="tournament-heading text-center">
                <h3 class="mb-0 t-titre-tournoi">
                    Liste de tous les Tops <?php echo $top_number; ?> <span class="ico text-center">🏆</span> <?php echo $top_title; ?>
                </h3>
                <h4 class="mb-0">
                    <?php echo $top_question; ?>
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
                                            Depuis le <?php echo $top_datas[0]['date_of_t']; ?>, <?php echo $top_datas[0]['nb_votes']; ?>💎 ont générés <?php echo $top_datas[0]['nb_tops']; ?> 🏆
                                        </h4>
                                    </div>
                                    <div class="table-responsive">
                                        <table class="table">
                                            <thead>
                                            <tr>
                                                <th>
                                                    Champions
                                                </th>
                                                <th>Podium</th>
                                                <th></th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                                <?php while ($all_users_ranks_of_t->have_posts()) : $all_users_ranks_of_t->the_post(); ?>
                                                    <tr>

                                                        <td>
                                                            <?php
                                                            $id_rank        = get_the_ID();
                                                            $uuid_user_r    = get_field('uuid_user_r', $id_rank);
                                                            $champion_id    = find_vkrz_user($uuid_user_r);
                                                            $champion_data  = get_user_by('ID', $champion_id);
                                                            ?>
                                                            <span class="avatar">
                                                                <?php
                                                                if($champion_data){
                                                                    $avatar_url = get_avatar_url($champion_id, ['size' => '80']);
                                                                }
                                                                else{
                                                                    $avatar_url = get_bloginfo('template_directory')."/assets/images/vkrz/ninja.png";
                                                                }
                                                                ?>
                                                                <?php if($champion_data): ?>
                                                                    <a href="<?php echo esc_url(get_author_posts_url($champion_id)); ?>">
                                                                        <span class="avatar-picture" style="background-image: url(<?php echo $avatar_url; ?>);"></span>
                                                                    </a>
                                                                <?php else: ?>
                                                                    <span class="avatar-picture" style="background-image: url(<?php echo $avatar_url; ?>);"></span>
                                                                <?php endif; ?>
                                                                <?php if($champion_data): ?>
                                                                    <span class="user-niveau">
                                                                    <?php
                                                                    $uuidchampion    = get_field('uuiduser_user', 'user_'.$champion_id);
                                                                    $user_full_data  = get_user_full_data($uuidchampion);
                                                                    $nb_user_votes   = $user_full_data[0]['nb_user_votes'];
                                                                    $info_user_level = get_user_level($uuidchampion, $champion_id, $nb_user_votes);
                                                                    echo $info_user_level['level_ico'];
                                                                    ?>
                                                                </span>
                                                                <?php endif; ?>
                                                            </span>
                                                            <span class="font-weight-bold championname">
                                                                <?php if($champion_data): ?>
                                                                    <a href="<?php echo esc_url(get_author_posts_url($champion_id)); ?>">
                                                                         <?php echo $champion_data->nickname; ?>
                                                                    </a>
                                                                    <span class="votechamp">
                                                                        - <?php echo $nb_user_votes; ?> <span class="ico">💎</span>
                                                                    </span>
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
                                                                <span class="ico">🏆</span> Voir le Top complet
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