<?php
global $uuiduser;
global $user_id;
global $user_tops;
global $user_infos;
global $id_vainkeur;
global $utm;
global $id_top;
global $type_top;
if (is_single()) {
    $get_top_type = get_the_terms(get_the_ID(), 'type');
    foreach ($get_top_type as $type_top) {
        $type_top = $type_top->slug;
    }
}
if (!is_single() || get_post_type() != "tournoi") {
    $user_id        = get_user_logged_id();
    $uuiduser       = deal_uuiduser();
    $utm            = deal_utm();

    if (is_user_logged_in() && env() != "local") {
        if (false === ($user_tops = get_transient('user_' . $user_id . '_get_user_tops'))) {
            $user_tops = get_user_tops();
            set_transient('user_' . $user_id . '_get_user_tops', $user_tops, DAY_IN_SECONDS);
        } else {
            $user_tops = get_transient('user_' . $user_id . '_get_user_tops');
        }
    } else {
        $user_tops  = get_user_tops();
    }
    $user_infos  = deal_vainkeur_entry();
    $id_vainkeur = $user_infos['id_vainkeur'];
}
wp_reset_query();
?>
<!DOCTYPE html>
<html class="loading dark-layout" lang="fr" data-layout="dark-layout" data-textdirection="ltr">

<head>
    <!--[if lt IE 9]>
    <script src="https://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
    <link rel="profile" href="http://gmpg.org/xfn/11">
    <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="apple-touch-icon" sizes="120x120" href="<?php bloginfo('template_directory'); ?>/assets/favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="<?php bloginfo('template_directory'); ?>/assets/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="<?php bloginfo('template_directory'); ?>/assets/favicon/favicon-16x16.png">
    <link rel="manifest" href="<?php bloginfo('template_directory'); ?>/assets/favicon/site.webmanifest">
    <link rel="mask-icon" href="<?php bloginfo('template_directory'); ?>/assets/favicon/safari-pinned-tab.svg" color="#5bbad5">
    <meta name="msapplication-TileColor" content="#da532c">
    <meta name="theme-color" content="#ffffff">
    <meta property="fb:app_id" content="458083104324596">
    <meta property="og:site_name" content="VAINKEURZ" />
    <meta property="og:locale" content="fr_FR" />
    <meta property="og:type" content="article" />
    <meta name="twitter:card" content="summary_large_image" />
    <meta name="twitter:site" content="@Vainkeurz">
    <meta name="twitter:creator" content="@Vainkeurz">
    <meta name="twitter:domain" content="vainkeurz.com">

    <?php if (is_page(array(26626, 256697, 256700, 284944))) : ?>
        <meta name='robots' content='noindex, nofollow' />
    <?php endif; ?>

    <?php get_template_part('partials/meta'); ?>

    <?php if ($user_infos['user_role'] != "administrator" && env() != "local") : ?>
        <!-- Google Tag Manager -->
        <script>
            (function(w, d, s, l, i) {
                w[l] = w[l] || [];
                w[l].push({
                    'gtm.start': new Date().getTime(),
                    event: 'gtm.js'
                });
                var f = d.getElementsByTagName(s)[0],
                    j = d.createElement(s),
                    dl = l != 'dataLayer' ? '&l=' + l : '';
                j.async = true;
                j.src =
                    'https://www.googletagmanager.com/gtm.js?id=' + i + dl;
                f.parentNode.insertBefore(j, f);
            })(window, document, 'script', 'dataLayer', 'GTM-KH379F5');
        </script>
        <!-- End Google Tag Manager -->
    <?php endif; ?>
    <script>
        window.dataLayer = window.dataLayer || [];
    </script>

    <script type="text/javascript">
        window.$crisp = [];
        window.CRISP_WEBSITE_ID = "ec6a3187-bf39-4eb5-a90d-dda00a2995c8";
        (function() {
            d = document;
            s = d.createElement("script");
            s.src = "https://client.crisp.chat/l.js";
            s.async = 1;
            d.getElementsByTagName("head")[0].appendChild(s);
        })();
    </script>
    <script>
        $crisp.push(["set", "user:email", ["<?php echo $user_infos['user_email']; ?>"]]);
        $crisp.push(["set", "user:nickname", ["<?php echo $user_infos['pseudo']; ?>"]]);
        $crisp.push(["set", "user:avatar", ["<?php echo $user_infos['avatar']; ?>"]]);
    </script>

    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.15.4/css/all.css" integrity="sha384-rqn26AG5Pj86AF4SO72RK5fyefcQ/x32DNQfChxWvbXIyXFePlEktwD18fEz+kQU" crossorigin="anonymous">

    <?php wp_head(); ?>

    <?php if ((is_single() && get_field('fichier_css', $id_top)) || (is_page(get_page_by_path('elo')) && $_GET['sponso'] == "active")) : ?>
        <link rel='stylesheet' href='<?php bloginfo('template_directory'); ?>/assets/special/css/<?php the_field('fichier_css', $id_top); ?>' type='text/css' media='all' />
    <?php endif; ?>
</head>

<?php
if (is_single() || is_page(get_page_by_path('monitor'))) {
    $list_body_class = "vertical-layout vertical-menu-modern navbar-floating footer-static menu-collapsed";
} elseif (is_page(get_page_by_path('elo')) && $_GET['sponso'] == "active") {
    $list_body_class = "vertical-layout vertical-menu-modern navbar-floating footer-static menu-collapsed";
} else {
    $list_body_class = "vertical-layout vertical-menu-modern navbar-floating footer-static";
}
if ($type_top == "whitelabel") {
    $list_body_class = $list_body_class . " t-marqueblanche";
}
?>

<body <?php body_class($list_body_class); ?> data-open="click" data-menu="vertical-menu-modern" data-col="">

    <?php if ($user_infos['user_role'] != "administrator" && env() != "local") : ?>
        <!-- Google Tag Manager (noscript) -->
        <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-KH379F5" height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
        <!-- End Google Tag Manager (noscript) -->
    <?php endif; ?>

    <?php if (!is_single() || $type_top != "whitelabel") : ?>
        <?php
        get_template_part('partials/menu-user');
        get_template_part('partials/menu-vkrz');
        ?>
    <?php endif; ?>