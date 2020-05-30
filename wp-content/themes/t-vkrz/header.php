<!DOCTYPE html>
<!--[if IE 7]><html class="ie ie7" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 8]><html class="ie ie8" <?php language_attributes(); ?>><![endif]-->
<!--[if !(IE 7) | !(IE 8)  ]><!--><html <?php language_attributes(); ?>><!--<![endif]-->
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

    <!-- Styles -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css?family=Staatliches" rel="stylesheet">
    <script src="https://kit.fontawesome.com/30edd5507e.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="<?php bloginfo( 'template_directory' ); ?>/assets/css/main.css">
    <link rel="stylesheet" href="<?php bloginfo( 'template_directory' ); ?>/assets/css/contenders.css">
    <link rel="stylesheet" href="<?php bloginfo( 'template_directory' ); ?>/assets/css/responsive.css">

    <?php wp_head(); ?>

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
</head>

<?php if(get_post_type() == "tournoi" || get_post_type() == "classement"): ?>

    <?php
    if(get_post_type() == "classement"){
        $id_tournoi     = get_field('id_tournoi_r');
    }
    else{
        $id_tournoi     = get_the_ID();
    }
    if(get_field('cover_t', $id_tournoi)){
        $illu       = wp_get_attachment_image_src(get_field('cover_t', $id_tournoi), 'full');
        $illu_url   = $illu[0];
    }
    ?>
    <body <?php body_class('cover'); ?> style="background: url(<?php echo $illu_url; ?>) center center no-repeat">

<?php else: ?>

    <body <?php body_class(); ?>>

<?php endif; ?>
