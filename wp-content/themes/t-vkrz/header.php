<?php
global $uuiduser;
$user_role = "visitor";
if(is_user_logged_in()){
    $current_user   = wp_get_current_user();
    $user_info      = get_userdata($current_user->ID);
    $user_role      = $user_info->roles[0];
}
$uuiduser           = $_COOKIE["vainkeurz_user_id"];
?>
<!DOCTYPE html>
<html class="loading dark-layout" lang="fr" data-layout="dark-layout" data-textdirection="ltr">
<head>
    <!--[if lt IE 9]>
    <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
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

    <!-- External -->
    <script src="https://kit.fontawesome.com/30edd5507e.js" crossorigin="anonymous"></script>

    <!-- Styles -->
    <link rel="stylesheet" type="text/css" href="<?php bloginfo('template_directory'); ?>/app-assets/vendors/css/vendors.min.css">
    <link rel="stylesheet" type="text/css" href="<?php bloginfo('template_directory'); ?>/app-assets/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="<?php bloginfo('template_directory'); ?>/app-assets/css/bootstrap-extended.css">
    <link rel="stylesheet" type="text/css" href="<?php bloginfo('template_directory'); ?>/app-assets/css/colors.css">
    <link rel="stylesheet" type="text/css" href="<?php bloginfo('template_directory'); ?>/app-assets/css/components.css">
    <link rel="stylesheet" type="text/css" href="<?php bloginfo('template_directory'); ?>/app-assets/css/themes/dark-layout.css">
    <link rel="stylesheet" type="text/css" href="<?php bloginfo('template_directory'); ?>/app-assets/css/themes/bordered-layout.css">
    <link rel="stylesheet" type="text/css" href="<?php bloginfo('template_directory'); ?>/app-assets/css/themes/semi-dark-layout.css">
    <link rel="stylesheet" type="text/css" href="<?php bloginfo('template_directory'); ?>/app-assets/css/core/menu/menu-types/vertical-menu.css">

    <!-- Context CSS -->
    <?php if(is_page(get_page_by_path('data'))): ?>
        <link rel="stylesheet" type="text/css" href="<?php bloginfo('template_directory'); ?>/app-assets/css/core/menu/menu-types/vertical-menu.css">
        <link rel="stylesheet" type="text/css" href="<?php bloginfo('template_directory'); ?>/app-assets/css/plugins/charts/chart-apex.css">
    <?php endif; ?>


    <!-- Custom CSS -->
    <link rel="stylesheet" type="text/css" href="<?php bloginfo('template_directory'); ?>/assets/css/style.css">
    
    <?php if($user_role != "administrator"): ?>
        <!-- Google Tag Manager -->
        <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
                    new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
                j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
                'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
            })(window,document,'script','dataLayer','GTM-5VVNJ52');</script>
        <!-- End Google Tag Manager -->
        <!-- Global site tag (gtag.js) - Google Analytics -->
        <script async src="https://www.googletagmanager.com/gtag/js?id=G-KF4C954X96"></script>
        <script>
            window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);}
            gtag('js', new Date());

            gtag('config', 'G-KF4C954X96');
        </script>
        <!-- Hotjar Tracking Code for https://vainkeurz.com/ -->
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

<!-- Google Tag Manager (noscript) -->
<noscript>
    <iframe src="https://www.googletagmanager.com/ns.html?id=GTM-5VVNJ52" height="0" width="0" style="display:none;visibility:hidden"></iframe>
</noscript>
<!-- End Google Tag Manager (noscript) -->

<!-- BEGIN: Header-->
<!--
<nav class="header-navbar navbar navbar-expand-lg align-items-center floating-nav navbar-dark navbar-shadow">
    <div class="navbar-container d-flex content">
        <div class="bookmark-wrapper d-flex align-items-center">
            <ul class="nav navbar-nav d-xl-none">
                <li class="nav-item"><a class="nav-link menu-toggle" href="javascript:void(0);"><i class="ficon" data-feather="menu"></i></a></li>
            </ul>
        </div>
        <ul class="nav navbar-nav align-items-center ml-auto">
            <li class="nav-item dropdown dropdown-user">
                <a class="nav-link dropdown-toggle dropdown-user-link" id="dropdown-user" href="javascript:void(0);" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <div class="user-nav d-sm-flex d-none">
                        <span class="user-name font-weight-bolder">John Doe</span>
                        <span class="user-status">Admin</span>
                    </div>
                    <span class="avatar">
                            <img class="round" src="<?php bloginfo('template_directory'); ?>/app-assets/images/portrait/small/avatar-s-11.jpg" alt="avatar" height="40" width="40">
                            <span class="avatar-status-online"></span>
                        </span>
                </a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdown-user">
                    <a class="dropdown-item" href="page-profile.html">
                        <i class="mr-50" data-feather="user"></i> Profile
                    </a>
                    <a class="dropdown-item" href="app-email.html">
                        <i class="mr-50" data-feather="mail"></i> Inbox
                    </a>
                    <a class="dropdown-item" href="app-todo.html">
                        <i class="mr-50" data-feather="check-square"></i> Task
                    </a>
                    <a class="dropdown-item" href="app-chat.html">
                        <i class="mr-50" data-feather="message-square"></i> Chats
                    </a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="page-account-settings.html">
                        <i class="mr-50" data-feather="settings"></i> Settings
                    </a>
                    <a class="dropdown-item" href="page-auth-login-v2.html">
                        <i class="mr-50" data-feather="power"></i> Logout
                    </a>
                </div>
            </li>
        </ul>
    </div>
</nav>
-->
<!-- END: Header-->


<!-- BEGIN: Main Menu-->
<div class="main-menu menu-fixed menu-light menu-accordion menu-shadow" data-scroll-to-active="true" style="touch-action: none; user-select: none; -webkit-user-drag: none; -webkit-tap-highlight-color: rgba(0, 0, 0, 0);">
    <div class="navbar-header">
        <ul class="nav navbar-nav flex-row">
            <li class="nav-item mr-auto">
                <a class="navbar-brand" href="<?php bloginfo('url'); ?>/">
                    <h2 class="brand-text">
                        <?php
                        $id_vainkeur_elo   = get_elo_vainkeur(1798);
                        $illu_vainkeur_elo = get_the_post_thumbnail_url($id_vainkeur_elo, 'full');
                        ?>
                        <img src="<?php echo $illu_vainkeur_elo; ?>" alt="VAINKEURZ logo" class="img-fluid">
                    </h2>
                    <div class="badge-beta">
                        <span class="badge">
                            BETA
                        </span>
                    </div>
                </a>
            </li>
        </ul>
    </div>
    <div class="main-menu-content">
        <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">
            <li class=" navigation-header">
                <span>Tournois</span> <i data-feather="more-horizontal"></i>
            </li>
            <li class=" nav-item">
                <a class="d-flex align-items-center" href="<?php bloginfo('url'); ?>/">
                    <i class="fal fa-swords"></i> <span class="menu-title text-truncate">Liste des tournois</span>
                </a>
            </li>
            <!--
            <li class=" navigation-header">
                <span>Vue d'ensemble</span> <i data-feather="more-horizontal"></i>
            </li>
            <li class=" nav-item">
                <a class="d-flex align-items-center" href="<?php the_permalink(); ?>">
                    <i class="fal fa-trophy-alt"></i> <span class="menu-title text-truncate">Classements</span>
                </a>
            </li>
            <li class=" navigation-header">
                Vainkeurz <i data-feather="more-horizontal"></i>
            </li>
            <li class=" nav-item">
                <a class="d-flex align-items-center" href="<?php the_permalink(); ?>">
                    <i data-feather="mail"></i> <span class="menu-title text-truncate">Le projet</span>
                </a>
                <a class="d-flex align-items-center" href="<?php the_permalink(); ?>">
                    <i data-feather="mail"></i> <span class="menu-title text-truncate">Participer</span>
                </a>
            </li>
            -->
            <?php if($user_role == "administrator"): ?>
                <li class=" navigation-header">
                    <span>Data</span> <i data-feather="more-horizontal"></i>
                </li>
                <li class=" nav-item">
                    <a class="d-flex align-items-center" href="<?php the_permalink(get_page_by_path('data')); ?>">
                        <i class="fal fa-database"></i> <span class="menu-title text-truncate">Overview</span>
                    </a>
                </li>
            <?php endif; ?>
        </ul>
    </div>
</div>
<!-- END: Main Menu-->