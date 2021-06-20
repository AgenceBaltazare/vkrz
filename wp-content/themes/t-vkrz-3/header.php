<?php
global $uuiduser;
global $user_id;
$user_role = "visitor";
if(get_post_type() != "tournoi" || !is_single()){
    if(is_user_logged_in()){
        $current_user   = wp_get_current_user();
        $user_id        = $current_user->ID;
        $user_name      = $current_user->display_name;
        $user_email     = $current_user->user_email;
        $user_info      = get_userdata($user_id);
        $user_role      = $user_info->roles[0];
    }
    $uuiduser           = deal_uuiduser();
}
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
    <meta property="fb:app_id" content="458083104324596">
    <meta property="og:site_name" content="VAINKEURZ" />
    <meta property="og:locale" content="fr_FR" />
    <meta property="og:type" content="article" />
    <meta name="twitter:card" content="summary_large_image" />
    <meta name="twitter:site" content="@Vainkeurz">
    <meta name="twitter:creator" content="@Vainkeurz">
    <meta name="twitter:domain" content="vainkeurz.com">
    <?php if(is_page(26626)): ?>
        <meta name='robots' content='noindex, nofollow' />
    <?php endif; ?>

    <?php get_template_part('partials/meta'); ?>

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

    <script type="text/javascript">window.$crisp=[];window.CRISP_WEBSITE_ID="ec6a3187-bf39-4eb5-a90d-dda00a2995c8";(function(){d=document;s=d.createElement("script");s.src="https://client.crisp.chat/l.js";s.async=1;d.getElementsByTagName("head")[0].appendChild(s);})();</script>
    <script>
        $crisp.push(["set", "user:email", ["<?php echo $user_email; ?>"]]);
        $crisp.push(["set", "user:nickname", ["<?php echo $user_name; ?>"]]);
    </script>

    <link rel="stylesheet" type="text/css" href="<?php bloginfo('template_directory'); ?>/css/plugins/charts/chart-apex.min.css">
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

