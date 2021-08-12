<?php
/*
    Template Name: Users List
*/
global $uuiduser;
get_header();
?>
<div class="app-content content cover">
    <div class="content-overlay"></div>
    <div class="content-wrapper">
        <div class="content-body mt-2">
            <div class="intro-mobile">
                <div class="tournament-heading text-center">
                    <h3 class="mb-0 t-titre-tournoi">
                        Top 20 des champions
                    </h3>
                </div>
            </div>
            <?php
            $users_ids_list = get_vkrz_users_list();
            $vainkeur_boss = new WP_Query(array(
                'post_type'              => 'vainkeur',
                'posts_per_page'         => '20',
                'post_status'            => 'publish',
                'meta_key'			     => 'nb_vote_vkrz',
                'orderby'			     => 'meta_value_num',
                'order'                  => 'DESC',
                'author__in'             => $users_ids_list,
                'author__not_in'         => array(1),
                'ignore_sticky_posts'    => true,
                'update_post_meta_cache' => false,
                'no_found_rows'          => false,
            ));
            ?>
            <div class="classement">
                <div class="container-fluid">
                    <section id="profile-info">
                        <div class="row">
                            <div class="col-md-12">
                                <?php
                                if($vainkeur_boss->have_posts()) : ?>
                                    <div class="row" id="table-bordered">
                                        <div class="col-12">
                                            <div class="card">
                                                <div class="card-header">
                                                    <h4 class="card-title pt-1 pb-1">
                                                        <span class="t-rose">TOP 20</span> des champions
                                                    </h4>
                                                </div>
                                                <div class="table-responsive">
                                                    <table class="table">
                                                        <thead>
                                                        <tr>
                                                            <th>🏁</th>
                                                            <th>🤴</th>
                                                            <th class="text-right">💎</th>
                                                            <th class="text-right">🏆</th>
                                                            <th>👀</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        <?php $r=1; while ($vainkeur_boss->have_posts()) : $vainkeur_boss->the_post(); ?>
                                                            <tr>
                                                                <td>
                                                                    <?php if($r == 1): ?>
                                                                        <span class="ico">🥇</span>
                                                                    <?php elseif($r == 2): ?>
                                                                        <span class="ico">🥈</span>
                                                                    <?php elseif($r == 3): ?>
                                                                        <span class="ico">🥉</span>
                                                                    <?php else: ?>
                                                                        #<?php echo $r; ?>
                                                                    <?php endif; ?>
                                                                </td>
                                                                <td>
                                                                    <div class="d-flex align-items-center">
                                                                        <?php
                                                                        $user_id     = get_the_author_meta('ID');
                                                                        $avatar_url  = get_avatar_url($user_id, ['size' => '80']);
                                                                        $user_uuid   = get_field('uuiduser_user', 'user_'.$user_id);
                                                                        $user_infos  = deal_vainkeur_entry($user_uuid);
                                                                        $nb_user_votes = $user_infos[0]['nb_vote_vkrz'];
                                                                        if(!$avatar_url){
                                                                            $avatar_url = get_bloginfo('template_directory')."/assets/images/vkrz/ninja.png";
                                                                        }
                                                                        $info_user_level = get_user_level($uuiduser, $user_id, $nb_user_votes);
                                                                        ?>
                                                                        <div class="avatar">
                                                                            <span class="avatar-picture" style="background-image: url(<?php echo $avatar_url; ?>);"></span>
                                                                            <?php if($info_user_level): ?>
                                                                                <span class="user-niveau">
                                                                                    <?php echo $info_user_level['level_ico']; ?>
                                                                                </span>
                                                                            <?php endif; ?>
                                                                        </div>
                                                                        <div class="font-weight-bold championname">
                                                                            <span>
                                                                                <?php echo get_the_author_meta('nickname');; ?>
                                                                            </span>
                                                                            <?php if($user['user_role'] == "administrator"): ?>
                                                                                <span class="ico" data-toggle="tooltip" data-placement="top" title="" data-original-title="TeamVKRZ">
                                                                                🦙
                                                                            </span>
                                                                            <?php endif; ?>
                                                                            <?php if($user['user_role'] == "administrator" || $user['user_role'] == "author"): ?>
                                                                                <span class="ico" data-toggle="tooltip" data-placement="top" title="" data-original-title="Créateur de Tops">
                                                                                🎨
                                                                            </span>
                                                                            <?php endif; ?>
                                                                        </div>
                                                                    </div>
                                                                </td>

                                                                <td class="text-right">
                                                                    <?php the_field('nb_vote_vkrz'); ?> <span class="ico">💎</span>
                                                                </td>

                                                                <td class="text-right">
                                                                    <?php the_field('nb_top_vkrz'); ?> <span class="ico">🏆</span>
                                                                </td>

                                                                <td>
                                                                    <a href="<?php echo esc_url(get_author_posts_url($champion_id)); ?>" class="mr-1 btn btn-outline-primary waves-effect">
                                                                        Guetter ses Tops
                                                                    </a>
                                                                </td>
                                                            </tr>
                                                            <?php $r++; endwhile; ?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </section>
                </div>
            </div>

        </div>
    </div>
</div>
<?php get_footer(); ?>