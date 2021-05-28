<?php
global $uuiduser;
global $user_role;
global $current_user;
global $user_id;
global $list_t_already_done;
global $list_t_begin;
global $id_tournament;
global $banner;
global $id_ranking;
$user_role = "visitor";
if(is_user_logged_in()){
    $current_user   = wp_get_current_user();
    $user_id        = $current_user->ID;
    $user_info      = get_userdata($user_id);
    $user_role      = $user_info->roles[0];
    if(is_page(get_page_by_path('mon-compte'))){
        $profil_url = get_author_posts_url($user_id);
        wp_redirect($profil_url);
        exit();
    }
}
$uuiduser            = deal_uuiduser();
$list_t_already_done = get_user_tournament_list('t-done', $uuiduser);
$list_t_begin        = get_user_tournament_list('t-begin', $uuiduser);
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
        <meta name="description" content="Meilleur site de la galaxie d'après la Nasa pour faire ses Tops." />

        <meta property="og:locale" content="fr_FR" />
        <meta property="og:type" content="article" />
        <meta property="og:image" content="<?php bloginfo('template_directory'); ?>/assets/images/vkrz/logo-vkrz.png;" />


        <meta property="og:title" content=" 🔥 VAINKEURZ 👉 Créer et partage tes Tops !" />
        <meta property="og:description" content="Meilleur site de la galaxie d'après la Nasa pour faire ses Tops." />
        <meta property="og:url" content="https://vainkeurz.com/" />
        <meta property="og:site_name" content="VAINKEURZ" />

        <meta name="twitter:card" content="summary_large_image" />
        <meta name="twitter:title" content=" 🔥 VAINKEURZ 👉 Créer et partage tes Tops !" />
        <meta name="twitter:description" content="Meilleur site de la galaxie d'après la Nasa pour faire ses Tops." />
        <meta name="twitter:image" content="<?php echo get_the_post_thumbnail_url($id_tournament, 'large'); ?>" />


    <?php elseif(is_single() && get_post_type() == "tournoi"): ?>

        <?php $id_tournament = get_the_ID(); ?>
        <title>
            TOP <?php echo get_numbers_of_contenders($id_tournament); ?> : <?php the_title(); ?> 🔥 VAINKEURZ
        </title>
        <meta name="description" content="<?php the_title(); ?> : <?php the_field( 'question_t' ); ?>" />
    
        <link rel="canonical" href="<?php get_the_permalink($id_tournament); ?>" />
        <meta property="og:locale" content="fr_FR" />
        <meta property="og:type" content="article" />
        <meta property="og:image" content="<?php echo get_the_post_thumbnail_url($id_tournament, 'large'); ?>" />
        <meta property="og:title" content="TOP <?php echo get_numbers_of_contenders($id_tournament); ?> : <?php the_title(); ?>" />
        <meta property="og:description" content="<?php the_field('question_t', $id_tournament); ?>" />
        <meta property="og:url" content="<?php get_the_permalink($id_tournament); ?>" />
        <meta property="og:site_name" content="VAINKEURZ" />

        <meta name="twitter:card" content="summary_large_image" />
        <meta name="twitter:title" content="TOP <?php echo get_numbers_of_contenders($id_tournament); ?> ⚔️ <?php the_title(); ?>" />
        <meta name="twitter:description" content="<?php the_field('question_t', $id_tournament); ?>" />
        <meta name="twitter:image" content="<?php echo get_the_post_thumbnail_url($id_tournament, 'large'); ?>" />

    <?php elseif(is_single() && get_post_type() == "classement"): ?>

        <?php
        $id_tournament = get_field('id_tournoi_r');
        $id_tournament = get_field('id_tournoi_r');
        ?>
        <title>
            TOP <?php echo get_numbers_of_contenders($id_tournament); ?> : <?php echo get_the_title($id_tournament); ?> - <?php the_field( 'question_t', $id_tournament ); ?> 🔥 VAINKEURZ
        </title>
        <meta name="description" content="Découvre mon TOP <?php echo get_numbers_of_contenders($id_tournament); ?> à propos de <?php echo get_the_title($id_tournament); ?>" />

        <?php
        $api_key    = "3I6bGZa3zyHsiZL2toeoagtt";
        $base_top3       = "https://on-demand.bannerbear.com/signedurl/9K5qxXae3MJyAGRDkj/image.jpg";
        $base_top2       = "https://on-demand.bannerbear.com/signedurl/JjPlQ3XyKQoe6MNobr/image.jpg";
        $user_top3  = get_user_top(false, $id_ranking);
        $l=1;
        foreach($user_top3 as $top => $p) {

            if ($l == 1) {
                $picture_contender_1 = get_the_post_thumbnail_url($top, 'full');
                $name_contender_1    = get_the_title($top);
            } elseif ($l == 2) {
                $picture_contender_2 = get_the_post_thumbnail_url($top, 'full');
                $name_contender_2    = get_the_title($top);
            } elseif ($l == 3) {
                $picture_contender_3 = get_the_post_thumbnail_url($top, 'full');
                $name_contender_3    = get_the_title($top);
            }

            $l++; if($l==4) break;
        }


        if (get_numbers_of_contenders($id_tournament) < 3){
            $modifications = '[{"name":"h1","text":"TOP '.get_numbers_of_contenders($id_tournament).' '.get_the_title($id_tournament).'"},{"name":"h2","text":"Voici mon Top 2 👉"},{"name":"h1-question","text":"'.get_field('question_t', $id_tournament).'"}, {"name":"contenders_1","image_url":"'.$picture_contender_1.'"},{"name":"contenders_2","image_url":"'.$picture_contender_2.'"},{"name":"1","text":"🥇 '.$name_contender_1.'"},{"name":"2","text":"🥈 '.$name_contender_2.'"}]';
            $query = "?modifications=" . rtrim(strtr(base64_encode($modifications), '+/', '-_'), '=');
            $signature = hash_hmac('sha256', $base_top2.$query, $api_key);
            $banner = $base_top2 . $query."&s=" . $signature;
            echo get_the_title($id_tournament);

        }
        else{
            $modifications = '[{"name":"h1","text":"TOP '.get_numbers_of_contenders($id_tournament).' '.get_the_title($id_tournament).'"},{"name":"h2","text":"Voici mon Top 3 👉"},{"name":"h1-question","text":"'.get_field('question_t', $id_tournament).'"}, {"name":"contenders_1","image_url":"'.$picture_contender_1.'"},{"name":"contenders_2","image_url":"'.$picture_contender_2.'"},{"name":"contenders_3","image_url":"'.$picture_contender_3.'"},{"name":"1","text":"🥇 '.$name_contender_1.'"},{"name":"2","text":"🥈 '.$name_contender_2.'"},{"name":"3","text":"🥉 '.$name_contender_3.'"}]';
            $query = "?modifications=" . rtrim(strtr(base64_encode($modifications), '+/', '-_'), '=');
            $signature = hash_hmac('sha256', $base_top3.$query, $api_key);
            $banner = $base_top3 . $query."&s=" . $signature;
        }
        ?>

        <link rel="canonical" href="<?php echo get_the_permalink($id_ranking); ?>" />
        <meta property="og:locale" content="fr_FR" />
        <meta property="og:type" content="article" />
        <meta property="og:image" content="<?php echo $banner; ?>" />
        <meta property="og:title" content="TOP <?php echo get_numbers_of_contenders($id_tournament); ?> 🏆 <?php echo get_the_title($id_tournament); ?> - <?php the_field('question_t', $id_tournament); ?>" />
        <meta property="og:description" content="Découvre mon Top complet et fais ton propre classement !" />
        <meta property="og:url" content="<?php echo get_the_permalink($id_ranking); ?>" />
        <meta property="og:site_name" content="VAINKEURZ" />

        <meta name="twitter:card" content="summary_large_image" />
        <meta name="twitter:site" content="@Vainkeurz">
        <meta name="twitter:creator" content="@Vainkeurz">
        <meta name="twitter:title" content="TOP <?php echo get_numbers_of_contenders($id_tournament); ?> 🏆 <?php echo get_the_title($id_tournament); ?> - <?php the_field('question_t', $id_tournament); ?>" />
        <meta name="twitter:description" content="Découvre mon Top complet et fais ton propre classement !" />
        <meta name="twitter:image" content="<?php echo $banner; ?>" />
        <meta name="twitter:domain" content="vainkeurz.com">

    <?php elseif(is_page(get_page_by_path('elo'))): ?>

        <?php $id_tournament = $_GET['id_tournoi']; ?>
        <title>
            Classement mondial 👉 <?php echo get_the_title($id_tournament); ?> - <?php the_field( 'question_t', $id_tournament ); ?> 🔥 VAINKEURZ
        </title>
        <meta name="description" content="Classement ELO du tournoi rassemblant les votes du monde entier." />

    <?php elseif(is_archive() && !is_author()): ?>

        <?php $current_cat = get_queried_object(); ?>
        <title>
            Tous les Tops de la catégorie <?php echo $current_cat->name; ?> <?php the_field('icone_cat', 'term_'.$current_cat->term_id); ?>
        </title>
        <meta name="description" content="<?php echo $current_cat->description; ?>" />

    <?php elseif(is_author()): ?>

        <title>
            Profil de <?php echo $current_user->display_name; ?> sur VAINKEURZ
        </title>
        <meta name="description" content="Tous les TOPs de ce champion et ses statistiques" />

    <?php else: ?>

        <title>
            VAINKEURZ 🔥
        </title>

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
    <link rel="stylesheet" type="text/css" href="<?php bloginfo('template_directory'); ?>/assets/css/plugins/extensions/ext-component-sweet-alerts.css">
    <link rel="stylesheet" type="text/css" href="<?php bloginfo('template_directory'); ?>/assets/css/pages/page-pricing.css">

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

