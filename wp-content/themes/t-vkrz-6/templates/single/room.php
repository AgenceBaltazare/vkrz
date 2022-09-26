<?php
global $user_tops;
global $list_user_tops;
global $list_user_tops_begin;
$user_id        = get_user_logged_id();
$vainkeur       = get_vainkeur();
$uuid_vainkeur  = $vainkeur['uuid_vainkeur'];
$id_vainkeur    = $vainkeur['id_vainkeur'];
if (is_user_logged_in()) {
    $infos_vainkeur = get_user_infos($uuid_vainkeur, "complete");
} else {
    $infos_vainkeur = get_fantom($id_vainkeur);
}
get_header();
if ($id_vainkeur) {
    if (is_user_logged_in() && env() != "local") {
        if (false === ($user_tops = get_transient('user_' . $user_id . '_get_user_tops'))) {
            $user_tops = get_user_tops($id_vainkeur);
            set_transient('user_' . $user_id . '_get_user_tops', $user_tops, DAY_IN_SECONDS);
        } else {
            $user_tops = get_transient('user_' . $user_id . '_get_user_tops');
        }
    } else {
        $user_tops  = get_user_tops($id_vainkeur);
    }
    $list_user_tops         = $user_tops['list_user_tops_done_ids'];
    $list_user_tops_begin   = $user_tops['list_user_tops_begin_ids'];
} else {
    $user_tops            = array();
    $list_user_tops       = array();
    $list_user_tops_begin = array();
}
?>
<div class="app-content content ">
    <div class="content-wrapper">
        <div class="content-body">
            <div id="user-profile">
                <div class="row">
                    <div class="col-12">
                        <div class="card profile-header mb-2">
                            <?php
                            if (get_field('cover_room')) {
                                $cover_url = wp_get_attachment_url(get_field('cover_room'), 'full');
                            }
                            ?>
                            <div class="card-img-top cover-profil" style="background-image: url(<?php echo $cover_url; ?>"></div>
                        </div>
                    </div>
                </div>

                <section id="profile-info">
                    <div class="row">
                        <div id="ancore" class="col-lg-9 col-12">
                            <div class="topdispo">
                                <div class="row">
                                    <div class="col-12">
                                        <h2>
                                            Les Tops <?php the_title(); ?>
                                        </h2>
                                    </div>
                                </div>
                                <?php
                                $choix_des_tops_room = get_field('liste_des_tops_room');
                                $tops_in_room        = new WP_Query(array(
                                    'ignore_sticky_posts'        => true,
                                    'update_post_meta_cache'    => false,
                                    'no_found_rows'                => true,
                                    'post_type'                    => 'tournoi',
                                    'orderby'                    => 'date',
                                    'order'                        => 'DESC',
                                    'posts_per_page'            => -1,
                                    'post__in'                  => $choix_des_tops_room
                                ));
                                if ($tops_in_room->have_posts()) : $i = 1; ?>

                                    <section class="grid-to-filtre row match-height mt-0 tournois">

                                        <?php while ($tops_in_room->have_posts()) : $tops_in_room->the_post(); ?>
                                            <div class="col-md-6 top-big">
                                                <div class="row">
                                                    <?php get_template_part('partials/min-t'); ?>
                                                </div>
                                            </div>
                                        <?php $i++;
                                        endwhile; ?>

                                    </section>

                                <?php else : ?>

                                    <div class="noresult">
                                        <h2>
                                            <span class="ico va va-woozy-face va-lg"></span> Aucun Top disponible par ici 🤪
                                        </h2>
                                    </div>

                                <?php endif; ?>
                            </div>
                            <?php
                            $list_toplist = array();
                            $lasttoplist  = new WP_Query(array(
                                'ignore_sticky_posts'       => true,
                                'update_post_meta_cache'    => false,
                                'no_found_rows'             => true,
                                'post_type'                 => 'classement',
                                'orderby'                   => 'date',
                                'order'                     => 'DESC',
                                'posts_per_page'            => -1,
                                'meta_query' => array(
                                    array(
                                        'key'     => 'id_tournoi_r',
                                        'value'   => $choix_des_tops_room,
                                        'compare' => 'IN',
                                    ),
                                ),
                            ));
                            while ($lasttoplist->have_posts()) : $lasttoplist->the_post();

                                array_push($list_toplist, get_the_ID());

                            endwhile;
                            wp_reset_query(); ?>
                            <?php if ($list_toplist) : ?>
                                <div class="toplistrecent mt-5">
                                    <div class="classement users-ranks">
                                        <h2>
                                            Les <span class="t-rose"><?php echo count($list_toplist); ?></span> dernières TopList <?php the_title(); ?>
                                        </h2>
                                        <div id="table-bordered">
                                            <div class="card">
                                                <div class="card-datatable table-responsive">
                                                    <table class="table table-toplist-room">
                                                        <thead>
                                                            <tr>
                                                                <th>
                                                                    <span class="text-muted">
                                                                        VAINKEUR
                                                                    </span>
                                                                </th>
                                                                <th>
                                                                    <span class="text-muted">
                                                                        Podium
                                                                    </span>
                                                                </th>
                                                                <th class="text-center">
                                                                    <span class="text-muted">
                                                                        Action
                                                                    </span>
                                                                </th>
                                                                <th class="text-right">
                                                                    <span class="text-muted">
                                                                        Guetter
                                                                    </span>
                                                                </th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php foreach (array_slice($list_toplist, 0, 500) as $id_ranking) :
                                                                $uuiduser                = get_field('uuid_user_r', $id_ranking);
                                                                $vainkeur_data_selected  = get_user_infos($uuiduser);
                                                                if ($vainkeur_data_selected['user_role'] != "anonyme") : ?>
                                                                    <tr id="rows" class="<?php echo "uuid" . $uuiduser; ?> uncalculated" data-idranking="<?= $id_ranking; ?>">
                                                                        <td class="vainkeur-table">
                                                                            <span class="avatar">
                                                                                <?php if ($vainkeur_data_selected) : ?>
                                                                                    <a href="<?php echo esc_url(get_author_posts_url($vainkeur_data_selected['id_user'])); ?>">
                                                                                        <span class="avatar-picture" style="background-image: url(<?php echo $vainkeur_data_selected['avatar']; ?>);"></span>
                                                                                    </a>
                                                                                    <?php if ($vainkeur_data_selected) : ?>
                                                                                        <span class="user-niveau">
                                                                                            <?php echo $vainkeur_data_selected['level']; ?>
                                                                                        </span>
                                                                                    <?php endif; ?>
                                                                                <?php else : ?>
                                                                                    <span class="avatar-picture" style="background-image: url(https://i1.wp.com/vainkeurz.com/wp-content/themes/t-vkrz-3/assets/images/vkrz/avatar-rose.png?ssl=1);"></span>
                                                                                <?php endif; ?>
                                                                            </span>
                                                                            <span class="font-weight-bold championname">
                                                                                <a href="<?php echo esc_url(get_author_posts_url($vainkeur_data_selected['id_user'])); ?>">
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
                                                                                <!--
                                                                                UUID    : <?php the_field('uuid_user_r', $id_ranking); ?>
                                                                                ID rank : <?php echo $id_ranking; ?>
                                                                                Date    : <?php echo get_the_date('d/m/Y - H:i:s', $id_ranking); ?>
                                                                                -->
                                                                            </span>
                                                                        </td>
                                                                        <td>
                                                                            <?php
                                                                            $user_top3 = get_user_ranking($id_ranking, 3);
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
                                                                            <a href="<?php the_permalink($id_ranking); ?>" class="btn btn-flat-secondary waves-effect" data-toggle="tooltip" data-placement="top" title="" data-original-title="Voir la TopList">
                                                                                <span class="ico ico-reverse va va-eyes va-lg"></span>
                                                                            </a>
                                                                            <a href="<?php the_permalink($id_ranking); ?>#jugement" class="btn btn-flat-secondary waves-effect" data-toggle="tooltip" data-placement="top" title="" data-original-title="Juger la TopList">
                                                                                <span class="ico va va-hache va-lg"></span>
                                                                            </a>
                                                                        </td>

                                                                        <td class="text-right checking-follower">
                                                                            <?php if ($vainkeur_data_selected && get_current_user_id() != $vainkeur_data_selected['id_user'] && is_user_logged_in()) : ?>

                                                                                <button type="button" id="followBtn" class="btn waves-effect btn-follow d-none" data-userid="<?= get_current_user_id(); ?>" data-uuid="<?= get_field('uuiduser_user', 'user_' . get_current_user_id()); ?>" data-relatedid="<?= $vainkeur_data_selected['id_user']; ?>" data-relateduuid="<?= get_field('uuiduser_user', 'user_' . $vainkeur_data_selected['id_user']); ?>" data-text="<?= get_the_author_meta('nickname', get_current_user_id()); ?> te guette !" data-url="<?= get_author_posts_url(get_current_user_id()); ?>">
                                                                                    <span class="mr-10p wording">Guetter</span>
                                                                                    <span class="va va-guetteur-close va va-z-20 emoji"></span>
                                                                                </button>

                                                                            <?php endif; ?>
                                                                        </td>

                                                                    </tr>
                                                                <?php endif; ?>
                                                            <?php endforeach; ?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>
                        <div class="col-lg-3 col-12">
                            <?php if (get_field('liste_des_trophees_room')) : ?>
                                <?php
                                $room_badges = get_field('liste_des_trophees_room');
                                if ($room_badges) : ?>
                                    <div class="card">
                                        <div class="card-header">
                                            <h4 class="card-title">
                                                <span class="ico va va-medal-1 va-lg"></span> Trophée de la room
                                            </h4>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <?php foreach ($room_badges as $badge) : ?>
                                                    <div class="col-4 col-sm-6 col-lg-4">
                                                        <div class="text-center">
                                                            <div class="user-level" data-toggle="tooltip" data-placement="top" title="" data-original-title="<?php echo $badge->name; ?> : <?php echo $badge->description; ?>">
                                                                <span class="icomedium">
                                                                    <?php the_field('symbole_badge', 'badges_' . $badge->term_id); ?>
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                <?php endforeach; ?>
                                            </div>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            <?php endif; ?>
                            <?php if (get_field('image_annonce_room')) : ?>
                                <div class="card">
                                    <?php if (get_field('lien_principal_room')) : ?>
                                        <a href="<?php the_field('lien_principal_room'); ?>" target="_blank">
                                            <?php echo wp_get_attachment_image(get_field('image_annonce_room'), 'large', '', array('class' => 'img-fluid rounded', 'alt' => get_the_title())); ?>
                                        </a>
                                    <?php else : ?>
                                        <?php echo wp_get_attachment_image(get_field('image_annonce_room'), 'large', '', array('class' => 'img-fluid rounded', 'alt' => get_the_title())); ?>
                                    <?php endif; ?>
                                </div>
                            <?php endif; ?>
                            <?php if (get_field('presentation_room')) : ?>
                                <div class="card card-transaction">
                                    <div class="card-header">
                                        <h4 class="card-title">
                                            <span class="ico va va-kissing va-lg"></span> Prézentation
                                        </h4>
                                    </div>
                                    <div class="card-body">
                                        <div class="info-bio card-text">
                                            <?php the_field('presentation_room'); ?>
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
<?php get_footer(); ?>