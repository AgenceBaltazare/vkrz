<?php
/*
    Template Name: Live
*/
get_header();
$id_membre          = get_field('vainkeur_live');
$uuid_vainkeur      = get_field('uuiduser_user', 'user_' . $id_membre);
$infos_vainkeur     = get_user_infos($uuid_vainkeur, 'complete');
$id_vainkeur        = $infos_vainkeur['id_vainkeur'];
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
                        <script>
                            const uuidVainkeurProfile = "<?php echo get_field('uuiduser_user', 'user_' . $id_membre); ?>";
                        </script>
                        <div class="card profile-header mb-2">

                            <?php
                            $cover_profil_url   = "";
                            if ($id_membre) {
                                if (get_userdata($id_membre)->cover_profil) {
                                    $cover_profil_id  = get_userdata($id_membre)->cover_profil;
                                    $cover_profil_url = wp_get_attachment_url($cover_profil_id);
                                }
                            }
                            ?>

                            <div class="card-img-top cover-profil" style="background-image: url(<?php echo $cover_profil_url; ?>">
                            </div>

                            <div class="position-relative">

                                <div class="profile-img-container d-flex align-items-center">
                                    <div class="profile-img" style="background: url(<?php echo $infos_vainkeur['avatar']; ?>) #7367f0 no-repeat center center;">

                                    </div>
                                    <div class="profile-title ml-3">
                                        <h2 class="text-white text-uppercase">
                                            <?php echo $infos_vainkeur['pseudo'] ? $infos_vainkeur['pseudo'] : "Futur Vainkeur"; ?>
                                        </h2>
                                        <p class="text-white">
                                            <span class="ico" data-toggle="tooltip" data-placement="top" title="" data-original-title="Niveau">
                                                <?php echo $infos_vainkeur['level']; ?>
                                            </span>
                                            <?php if ($infos_vainkeur['user_role']  == "administrator") : ?>
                                                <span class="ico va va-vkrzteam va-lg" data-toggle="tooltip" data-placement="top" title="" data-original-title="TeamVKRZ">

                                                </span>
                                            <?php endif; ?>
                                            <?php if ($infos_vainkeur['user_role']  == "administrator" || $infos_vainkeur['user_role'] == "author") : ?>
                                                <span class="ico va va-man-singer va-lg" data-toggle="tooltip" data-placement="top" title="" data-original-title="Créateur de Tops">

                                                </span>
                                            <?php endif; ?>
                                        </p>
                                    </div>

                                </div>
                            </div>

                            <div class="profile-header-nav">
                                <nav class="navbar navbar-expand-md navbar-light justify-content-end justify-content-md-between w-100">
                                    <button class="btn btn-icon navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                                        <i data-feather="align-justify" class="font-medium-5"></i>
                                    </button>
                                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                                        <div class="profile-tabs d-flex justify-content-between flex-wrap mt-1 mt-md-0">
                                            <?php if ($infos_vainkeur['id_user'] != $user_id && is_user_logged_in()) : ?>
                                                <button type="button" id="followBtn" class="btn waves-effect d-none btn-follow" data-userid="<?= $user_id; ?>" data-uuid="<?= get_field('uuiduser_user', 'user_' . $user_id); ?>" data-relatedid="<?= $infos_vainkeur['id_user']; ?>" data-relateduuid="<?= get_field('uuiduser_user', 'user_' . $infos_vainkeur['id_user']);  ?>" data-text="<?= wp_get_current_user()->user_login ?> te guette !" data-url="<?= get_author_posts_url($user_id); ?>">
                                                    <span class="wording">Guetter ce Vainkeur</span>
                                                    <span class="va va-guetteur-close va va-z-20 emoji"></span>
                                                </button>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>

                <section id="profile-info">
                    <div class="row">
                        <div class="col-lg-3 col-12 order-2 order-lg-1">

                            <?php
                            if (get_userdata($id_membre)->description) : ?>
                                <div class="card card-transaction">
                                    <div class="card-header">
                                        <h4 class="card-title">
                                            <span class="ico va va-kissing va-lg"></span> Bio
                                        </h4>
                                    </div>
                                    <div class="card-body">
                                        <div class="info-bio">
                                            <p class="card-text">
                                                <?php echo get_userdata($id_membre)->description; ?>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            <?php endif; ?>
                            <?php if (get_userdata($id_membre)->twitch_user || get_userdata($id_membre)->youtube_user || get_userdata($id_membre)->Instagram_user || get_userdata($id_membre)->tiktok_user) : ?>
                                <div class="card card-transaction">
                                    <div class="card-header">
                                        <h4 class="card-title">
                                            <span class="ico va va-lolipop va-lg"></span> Rézeaux
                                        </h4>
                                    </div>
                                    <div class="card-body">
                                        <div class="info-bio">
                                            <div class="flex-row d-flex align-items-baseline">
                                                <?php if (get_userdata($id_membre)->twitch_user) : ?>
                                                    <div class="transaction-item">
                                                        <a href="https://www.twitch.tv/<?php echo get_userdata($id_membre)->twitch_user; ?>" target="_blank">
                                                            <div class="d-flex align-items-center">
                                                                <div class="avatar bg-light-primary rounded">
                                                                    <div class="avatar-content picto-rs">
                                                                        <i class="fab fa-twitch"></i>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </a>
                                                    </div>
                                                <?php endif; ?>
                                                <?php if (get_userdata($id_membre)->youtube_user) : ?>
                                                    <div class="transaction-item">
                                                        <a href="https://www.youtube.com/user/<?php echo get_userdata($id_membre)->youtube_user; ?>" target="_blank">
                                                            <div class="d-flex align-items-center">
                                                                <div class="avatar bg-light-primary rounded">
                                                                    <div class="avatar-content picto-rs">
                                                                        <i class="fab fa-youtube"></i>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </a>
                                                    </div>
                                                <?php endif; ?>
                                                <?php if (get_userdata($id_membre)->Instagram_user) : ?>
                                                    <div class="transaction-item">
                                                        <a href="https://www.instagram.com/<?php echo get_userdata($id_membre)->Instagram_user; ?>" target="_blank">
                                                            <div class="d-flex align-items-center">
                                                                <div class="avatar bg-light-primary rounded">
                                                                    <div class="avatar-content picto-rs">
                                                                        <i class="fab fa-instagram"></i>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </a>
                                                    </div>
                                                <?php endif; ?>
                                                <?php if (get_userdata($id_membre)->twitter_user) : ?>
                                                    <div class="transaction-item">
                                                        <a href="https://twitter.com/<?php echo get_userdata($id_membre)->twitter_user; ?>" target="_blank">
                                                            <div class="d-flex align-items-center">
                                                                <div class="avatar bg-light-primary rounded">
                                                                    <div class="avatar-content picto-rs">
                                                                        <i class="fab fa-twitter"></i>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </a>
                                                    </div>
                                                <?php endif; ?>
                                                <?php if (get_userdata($id_membre)->snapchat_user) : ?>
                                                    <div class="transaction-item">
                                                        <a href="https://www.snapchat.com/add/<?php echo get_userdata($id_membre)->snapchat_user; ?>" target="_blank">
                                                            <div class="d-flex align-items-center">
                                                                <div class="avatar bg-light-primary rounded">
                                                                    <div class="avatar-content picto-rs">
                                                                        <i class="fab fa-snapchat-ghost"></i>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </a>
                                                    </div>
                                                <?php endif; ?>
                                                <?php if (get_userdata($id_membre)->tiktok_user) : ?>
                                                    <div class="transaction-item">
                                                        <a href="https://www.tiktok.com/@<?php echo get_userdata($id_membre)->tiktok_user; ?>?" target="_blank">
                                                            <div class="d-flex align-items-center">
                                                                <div class="avatar bg-light-primary rounded">
                                                                    <div class="avatar-content picto-rs">
                                                                        <i class="fab fa-tiktok"></i>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </a>
                                                    </div>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endif; ?>

                            <?php
                            $vainkeur_badges = get_the_terms($id_vainkeur, 'badges');
                            if ($vainkeur_badges) : ?>
                                <div class="card">
                                    <div class="card-header">
                                        <h4 class="card-title">
                                            <span class="ico va va-medal-1 va-lg"></span> Trophées
                                        </h4>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <?php foreach ($vainkeur_badges as $badge) : ?>
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
                        </div>

                        <div id="ancore" class="col-lg-9 col-12 order-1 order-lg-2">
                            <?php
                            $choix_des_tops_live = get_field('choix_des_tops_live');
                            $tops_in_live        = new WP_Query(array(
                                'ignore_sticky_posts'        => true,
                                'update_post_meta_cache'    => false,
                                'no_found_rows'                => true,
                                'post_type'                    => 'tournoi',
                                'orderby'                    => 'date',
                                'order'                        => 'DESC',
                                'posts_per_page'            => -1,
                                'post__in'                  => $choix_des_tops_live
                            ));
                            if ($tops_in_live->have_posts()) : $i = 1; ?>

                                <section class="grid-to-filtre row match-height mt-2 tournois">

                                    <?php while ($tops_in_live->have_posts()) : $tops_in_live->the_post(); ?>
                                        <div class="col-md-3 col-sm-4 col-6">
                                            <?php get_template_part('partials/min-t'); ?>
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
                    </div>
                </section>
            </div>
        </div>
    </div>
</div>
<?php get_footer(); ?>