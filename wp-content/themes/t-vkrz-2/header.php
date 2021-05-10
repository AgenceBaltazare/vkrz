<?php
global $uuiduser;
global $user_role;
global $current_user;
global $user_id;
global $list_t_already_done;
global $list_t_begin;
$user_role = "visitor";
if(is_user_logged_in()){
    $current_user   = wp_get_current_user();
    $user_id        = $current_user->ID;
    $user_info      = get_userdata($user_id);
    $user_role      = $user_info->roles[0];
}
if(isset($_COOKIE["vainkeurz_user_id"])){
    $uuiduser            = $_COOKIE["vainkeurz_user_id"];
    $list_t_already_done = get_user_tournament_list('t-done', $uuiduser);
    $list_t_begin        = get_user_tournament_list('t-begin', $uuiduser);
}
else{
    $uuiduser       = "nouuiduser";
}
wp_reset_query(); wp_reset_postdata();
?>
<!DOCTYPE html>
<html class="loading dark-layout" lang="fr" data-layout="dark-layout" data-textdirection="ltr">
<head>
    <!--[if lt IE 9]>
    <script src="https://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
    <link rel="profile" href="http://gmpg.org/xfn/11">
    <link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
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

    <?php if(is_home()): ?>

        <title>
            🔥 VAINKEURZ 👉 Créer et partage tes Tops !
        </title>
        <meta name="description" content="Meilleur site de la galaxie - sauf preuve du contraire - pour générer tes Tops facilement." />

    <?php elseif(is_single() && get_post_type() == "tournoi"): ?>

        <title>
            ⚔ TOP : <?php the_title(); ?> - <?php the_field( 'question_t' ); ?> 🔥 VAINKEURZ
        </title>
        <meta name="description" content="<?php the_title(); ?>" />


    <?php elseif(is_single() && get_post_type() == "classement"): ?>

        <?php $id_tournament = get_field('id_tournoi_r'); ?>
        <title>
            🏆 TOP : <?php echo get_the_title($id_tournament); ?> - <?php the_field( 'question_t', $id_tournament ); ?> 🔥 VAINKEURZ
        </title>
        <meta name="description" content="<?php echo get_the_title($id_tournament); ?>" />

        <link rel="canonical" href="https://vainkeurz.com/r/t14597-u1b86cafb238d0/" />
        <meta property="og:locale" content="fr_FR" />
        <meta property="og:image" content="<?php get_the_post_thumbnail_url($id_tournament, 'medium'); ?>" />
        <meta property="og:type" content="article" />
        <meta property="og:title" content="Viens checher mon <?php echo get_the_title($id_tournament); ?> <?php the_field( 'question_t', $id_tournament ); ?>" />
        <meta property="og:url" content="<?php get_the_permalink(); ?>" />
        <meta property="og:site_name" content="🔥 VAINKEURZ 👉" />
        <meta name="twitter:card" content="summary_large_image" />

    <?php elseif(is_page(get_page_by_path('elo'))): ?>

        <?php $id_tournament = $_GET['id_tournoi']; ?>
        <title>
            Classement mondial 👉 <?php echo get_the_title($id_tournament); ?> - <?php the_field( 'question_t', $id_tournament ); ?> 🔥 VAINKEURZ
        </title>
        <meta name="description" content="<?php echo get_the_title($id_tournament); ?>" />


    <?php elseif(is_archive()): ?>

        <?php $current_cat = get_queried_object(); ?>
        <title>
            Tous les Tops de la catégorie <?php echo $current_cat->name; ?> <?php the_field('icone_cat', 'term_'.$current_cat->term_id); ?>
        </title>
        <meta name="description" content="Tous les Tops de la catégorie <?php echo $current_cat->name; ?>" />


    <?php endif; ?>

    <!-- External -->
    <script src="https://kit.fontawesome.com/30edd5507e.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>

    <!-- Styles -->
    <link rel="stylesheet" type="text/css" href="<?php bloginfo('template_directory'); ?>/assets/vendors/css/vendors.min.css">
    <link rel="stylesheet" type="text/css" href="<?php bloginfo('template_directory'); ?>/assets/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="<?php bloginfo('template_directory'); ?>/assets/css/bootstrap-extended.css">
    <link rel="stylesheet" type="text/css" href="<?php bloginfo('template_directory'); ?>/assets/css/colors.css">
    <link rel="stylesheet" type="text/css" href="<?php bloginfo('template_directory'); ?>/assets/css/components.css">
    <link rel="stylesheet" type="text/css" href="<?php bloginfo('template_directory'); ?>/assets/css/themes/dark-layout.css">
    <link rel="stylesheet" type="text/css" href="<?php bloginfo('template_directory'); ?>/assets/css/themes/bordered-layout.css">
    <link rel="stylesheet" type="text/css" href="<?php bloginfo('template_directory'); ?>/assets/css/themes/semi-dark-layout.css">
    <link rel="stylesheet" type="text/css" href="<?php bloginfo('template_directory'); ?>/assets/css/core/menu/menu-types/vertical-menu.css">

    <!-- Home -->
    <link rel="stylesheet" type="text/css" href="<?php bloginfo('template_directory'); ?>/assets/vendors/css/vendors.min.css">
    <link rel="stylesheet" type="text/css" href="<?php bloginfo('template_directory'); ?>/assets/vendors/css/extensions/swiper.min.css">
    <link rel="stylesheet" type="text/css" href="<?php bloginfo('template_directory'); ?>/assets/css/plugins/extensions/ext-component-swiper.css">

    <!-- Custom CSS -->
    <link rel="stylesheet" type="text/css" href="<?php bloginfo('template_directory'); ?>/assets/css/vkrz/main.css">

    <?php if($user_role != "administrator"): ?>
        <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
                    new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
                j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
                'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
            })(window,document,'script','dataLayer','GTM-5VVNJ52');</script>
        <script async src="https://www.googletagmanager.com/gtag/js?id=G-KF4C954X96"></script>
        <script>
            window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);}
            gtag('js', new Date());

            gtag('config', 'G-KF4C954X96');
        </script>
        <script>
            (function(h,o,t,j,a,r){
                h.hj=h.hj||function(){(h.hj.q=h.hj.q||[]).push(arguments)};
                h._hjSettings={hjid:1825930,hjsv:6};
                a=o.getElementsByTagName('head')[0];
                r=o.createElement('script');r.async=1;
                r.src=t+h._hjSettings.hjid+j+h._hjSettings.hjsv;
                a.appendChild(r);
            })(window,document,'https://static.hotjar.com/c/hotjar-','.js?sv=');
        </script>
    <?php endif; ?>

    <?php wp_head(); ?>
</head>

<?php
    if(is_single()){
        $list_body_class = "vertical-layout vertical-menu-modern navbar-floating footer-static menu-collapsed";
    }
    else{
        $list_body_class = "vertical-layout vertical-menu-modern navbar-floating footer-static";
    }
?>
<body <?php body_class($list_body_class); ?> data-open="click" data-menu="vertical-menu-modern" data-col="">
<noscript>
    <iframe src="https://www.googletagmanager.com/ns.html?id=GTM-5VVNJ52" height="0" width="0" style="display:none;visibility:hidden"></iframe>
</noscript>

<?php get_template_part('partials/menu-user'); ?>

<?php get_template_part('partials/menu-vkrz'); ?>

