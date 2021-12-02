<?php /* Template Name: Data - Users */ ?>
<?php get_header(); ?>
<?php if ($user_infos['user_role'] == "administrator") : ?>
    <div class="app-content content cover">
        <div class="content-overlay"></div>
        <div class="content-wrapper">
            <div class="content-body mt-2">
                <?php
                $users_ids_list = get_vkrz_users_list();
                $all_users      = new WP_Query(array(
                    'post_type'              => 'vainkeur',
                    'posts_per_page'         => '-1',
                    'post_status'            => 'publish',
                    'meta_key'               => 'nb_vote_vkrz',
                    'orderby'                => 'meta_value_num',
                    'order'                  => 'DESC',
                    'author'                 => $users_ids_list,
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
                                    <div class="card-header">
                                        <h4 class="card-title pt-1 pb-1">
                                            Liste des <span class="t-rose"><?php echo $vainkeur_boss->post_count; ?></span> Vainkeurs
                                        </h4>
                                    </div>
                                    <?php
                                    if ($all_users->have_posts()) : ?>
                                        <div class="row" id="table-bordered">
                                            <div class="col-12">
                                                <div class="card">
                                                    <div class="table-responsive">
                                                        <table class="table">
                                                            <thead>
                                                                <tr>
                                                                    <th>🏁</th>
                                                                    <th>🤴</th>
                                                                    <th>⏰</th>
                                                                    <th>🗓️</th>
                                                                    <th class="text-right">💎</th>
                                                                    <th class="text-right">🏆</th>
                                                                    <th>📣</th>
                                                                    <th>👀</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php $r = 1;
                                                                while ($all_users->have_posts()) : $all_users->the_post(); ?>
                                                                    <tr>
                                                                        <td>
                                                                            <?php if ($r == 1) : ?>
                                                                                <span class="ico">🥇</span>
                                                                            <?php elseif ($r == 2) : ?>
                                                                                <span class="ico">🥈</span>
                                                                            <?php elseif ($r == 3) : ?>
                                                                                <span class="ico">🥉</span>
                                                                            <?php else : ?>
                                                                                #<?php echo $r; ?>
                                                                            <?php endif; ?>
                                                                        </td>
                                                                        <td>
                                                                            <div class="d-flex align-items-center">
                                                                                <?php
                                                                                $user_id            = get_the_author_meta('ID');
                                                                                $user_data          = get_userdata($user_id);
                                                                                $user_infos         = deal_vainkeur_entry($user_id);
                                                                                $nb_user_votes      = $user_infos['nb_vote_vkrz'];
                                                                                $avatar             = $user_infos['avatar'];
                                                                                $info_user_level    = get_user_level($user_id);
                                                                                ?>
                                                                                <div class="avatar">
                                                                                    <span class="avatar-picture" style="background-image: url(<?php echo $avatar; ?>);"></span>
                                                                                    <?php if ($info_user_level) : ?>
                                                                                        <span class="user-niveau">
                                                                                            <?php echo $info_user_level['level_ico']; ?>
                                                                                        </span>
                                                                                    <?php endif; ?>
                                                                                </div>
                                                                                <div class="font-weight-bold championname">
                                                                                    <span>
                                                                                        <?php echo get_the_author_meta('nickname'); ?>
                                                                                        <!-- #<?php the_ID(); ?> - #<?php echo $user_id; ?> - <?php echo $user_infos['uuid_user_vkrz']; ?> -->
                                                                                    </span>
                                                                                    <?php if ($user_infos['user_role'] == "administrator") : ?>
                                                                                        <span class="ico" data-toggle="tooltip" data-placement="top" title="" data-original-title="TeamVKRZ">
                                                                                            🦙
                                                                                        </span>
                                                                                    <?php endif; ?>
                                                                                    <?php if ($user_infos['user_role'] == "administrator" || $user_infos['user_role'] == "author") : ?>
                                                                                        <span class="ico" data-toggle="tooltip" data-placement="top" title="" data-original-title="Créateur de Tops">
                                                                                            👨‍🎤
                                                                                        </span>
                                                                                    <?php endif; ?>
                                                                                </div>
                                                                            </div>
                                                                        </td>

                                                                        <td>
                                                                            <?php
                                                                            $date_registration = $user_data->user_registered;
                                                                            echo date("d/m/Y", strtotime($date_registration));
                                                                            ?>
                                                                        </td>

                                                                        <td>
                                                                            <?php
                                                                            $last_rank = new WP_Query(
                                                                                array(
                                                                                    'ignore_sticky_posts'        => true,
                                                                                    'update_post_meta_cache'    => false,
                                                                                    'no_found_rows'                => true,
                                                                                    'post_type'                    => 'classement',
                                                                                    'orderby'                    => 'date',
                                                                                    'order'                        => 'DESC',
                                                                                    'posts_per_page'            => 1,
                                                                                    'meta_query'                =>
                                                                                    array(
                                                                                        array(
                                                                                            'key' => 'uuid_user_r',
                                                                                            'value' => $user_infos['uuid_user_vkrz'],
                                                                                            'compare' => '=',
                                                                                        ),
                                                                                    )
                                                                                )
                                                                            );
                                                                            while ($last_rank->have_posts()) : $last_rank->the_post(); ?>
                                                                                <?php
                                                                                $date_last    = strtotime(get_the_date('d-m-Y'));
                                                                                $current_date = strtotime(date('d-m-Y'));
                                                                                $relative     = $current_date - $date_last;
                                                                                echo abs($relative / 60 / 60 / 24) . ' jours';
                                                                                ?>
                                                                            <?php endwhile;
                                                                            $all_users->reset_postdata(); ?>
                                                                        </td>

                                                                        <td class="text-right">
                                                                            <?php the_field('nb_vote_vkrz'); ?>
                                                                        </td>

                                                                        <td class="text-right">
                                                                            <?php the_field('nb_top_vkrz'); ?>
                                                                        </td>

                                                                        <td>
                                                                            <div class="mb-2">
                                                                                <p>
                                                                                    <?php echo get_userdata($user_id)->description; ?>
                                                                                </p>
                                                                            </div>
                                                                            <div class="d-flex justify-content-around">
                                                                                <?php if (get_userdata($user_id)->twitch_user) : ?>
                                                                                    <a href="https://www.twitch.tv/<?php echo get_userdata($user_id)->twitch_user; ?>" target="_blank">
                                                                                        <div class="d-flex align-items-center">
                                                                                            <div class="avatar bg-light-primary rounded">
                                                                                                <div class="avatar-content picto-rs">
                                                                                                    <i class="fab fa-twitch"></i>
                                                                                                </div>
                                                                                            </div>
                                                                                            <div class="transaction-info">
                                                                                                <h6 class="transaction-title mb-0">
                                                                                                    Twitch
                                                                                                </h6>
                                                                                            </div>
                                                                                        </div>
                                                                                    </a>
                                                                                <?php endif; ?>
                                                                                <?php if (get_userdata($user_id)->youtube_user) : ?>
                                                                                    <a href="https://www.youtube.com/user/<?php echo get_userdata($user_id)->youtube_user; ?>" target="_blank">
                                                                                        <div class="d-flex align-items-center">
                                                                                            <div class="avatar bg-light-primary rounded">
                                                                                                <div class="avatar-content picto-rs">
                                                                                                    <i class="fab fa-youtube"></i>
                                                                                                </div>
                                                                                            </div>
                                                                                            <div class="transaction-info">
                                                                                                <h6 class="transaction-title mb-0">
                                                                                                    Youtube
                                                                                                </h6>
                                                                                            </div>
                                                                                        </div>
                                                                                    </a>
                                                                                <?php endif; ?>
                                                                                <?php if (get_userdata($user_id)->Instagram_user) : ?>
                                                                                    <a href="https://www.instagram.com/<?php echo get_userdata($user_id)->Instagram_user; ?>" target="_blank">
                                                                                        <div class="d-flex align-items-center">
                                                                                            <div class="avatar bg-light-primary rounded">
                                                                                                <div class="avatar-content picto-rs">
                                                                                                    <i class="fab fa-instagram"></i>
                                                                                                </div>
                                                                                            </div>
                                                                                            <div class="transaction-info">
                                                                                                <h6 class="transaction-title mb-0">
                                                                                                    Instagram
                                                                                                </h6>
                                                                                            </div>
                                                                                        </div>
                                                                                    </a>
                                                                                <?php endif; ?>
                                                                                <?php if (get_userdata($user_id)->twitter_user) : ?>
                                                                                    <a href="https://twitter.com/<?php echo get_userdata($user_id)->twitter_user; ?>" target="_blank">
                                                                                        <div class="d-flex align-items-center">
                                                                                            <div class="avatar bg-light-primary rounded">
                                                                                                <div class="avatar-content picto-rs">
                                                                                                    <i class="fab fa-twitter"></i>
                                                                                                </div>
                                                                                            </div>
                                                                                            <div class="transaction-info">
                                                                                                <h6 class="transaction-title mb-0">
                                                                                                    Twitter
                                                                                                </h6>
                                                                                            </div>
                                                                                        </div>
                                                                                    </a>
                                                                                <?php endif; ?>
                                                                                <?php if (get_userdata($user_id)->snapchat_user) : ?>
                                                                                    <a href="https://www.snapchat.com/add/<?php echo get_userdata($user_id)->snapchat_user; ?>" target="_blank">
                                                                                        <div class="d-flex align-items-center">
                                                                                            <div class="avatar bg-light-primary rounded">
                                                                                                <div class="avatar-content picto-rs">
                                                                                                    <i class="fab fa-snapchat-ghost"></i>
                                                                                                </div>
                                                                                            </div>
                                                                                            <div class="transaction-info">
                                                                                                <h6 class="transaction-title mb-0">
                                                                                                    Snapchat
                                                                                                </h6>
                                                                                            </div>
                                                                                        </div>
                                                                                    </a>
                                                                                <?php endif; ?>
                                                                                <?php if (get_userdata($user_id)->tiktok_user) : ?>
                                                                                    <a href="https://www.tiktok.com/@<?php echo get_userdata($user_id)->tiktok_user; ?>?" target="_blank">
                                                                                        <div class="d-flex align-items-center">
                                                                                            <div class="avatar bg-light-primary rounded">
                                                                                                <div class="avatar-content picto-rs">
                                                                                                    <i class="fab fa-tiktok"></i>
                                                                                                </div>
                                                                                            </div>
                                                                                            <div class="transaction-info">
                                                                                                <h6 class="transaction-title mb-0">
                                                                                                    TikTok
                                                                                                </h6>
                                                                                            </div>
                                                                                        </div>
                                                                                    </a>
                                                                                <?php endif; ?>
                                                                            </div>
                                                                        </td>

                                                                        <td>
                                                                            <a href="<?php echo esc_url(get_author_posts_url($user_id)); ?>" class="mr-1 btn btn-outline-primary waves-effect">
                                                                                Guetter ses Tops
                                                                            </a>
                                                                        </td>
                                                                    </tr>
                                                                <?php $r++;
                                                                endwhile; ?>
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
<?php endif; ?>
<?php get_footer(); ?>