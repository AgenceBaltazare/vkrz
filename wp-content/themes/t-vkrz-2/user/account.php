<?php
/*
    Template Name: Account
*/
?>
<!DOCTYPE html>
<html class="loading dark-layout" lang="en" data-layout="dark-layout" data-textdirection="ltr">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1.0,user-scalable=0,minimal-ui">

    <link rel="apple-touch-icon" sizes="120x120" href="<?php bloginfo('template_directory'); ?>/assets/favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="<?php bloginfo('template_directory'); ?>/assets/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="<?php bloginfo('template_directory'); ?>/assets/favicon/favicon-16x16.png">
    <link rel="manifest" href="<?php bloginfo('template_directory'); ?>/assets/favicon/site.webmanifest">
    <link rel="mask-icon" href="<?php bloginfo('template_directory'); ?>/assets/favicon/safari-pinned-tab.svg" color="#5bbad5">
    <meta name="msapplication-TileColor" content="#da532c">
    <meta name="theme-color" content="#ffffff">

    <!-- External -->
    <script src="https://kit.fontawesome.com/30edd5507e.js" crossorigin="anonymous"></script>

    <!-- BEGIN: Vendor CSS-->
    <link rel="stylesheet" type="text/css" href="<?php bloginfo('template_directory'); ?>/app-assets/vendors/css/vendors.min.css">
    <!-- END: Vendor CSS-->

    <!-- BEGIN: Theme CSS-->
    <link rel="stylesheet" type="text/css" href="<?php bloginfo('template_directory'); ?>/app-assets/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="<?php bloginfo('template_directory'); ?>/app-assets/css/bootstrap-extended.css">
    <link rel="stylesheet" type="text/css" href="<?php bloginfo('template_directory'); ?>/app-assets/css/colors.css">
    <link rel="stylesheet" type="text/css" href="<?php bloginfo('template_directory'); ?>/app-assets/css/components.css">
    <link rel="stylesheet" type="text/css" href="<?php bloginfo('template_directory'); ?>/app-assets/css/themes/dark-layout.css">
    <link rel="stylesheet" type="text/css" href="<?php bloginfo('template_directory'); ?>/app-assets/css/themes/bordered-layout.css">
    <link rel="stylesheet" type="text/css" href="<?php bloginfo('template_directory'); ?>/app-assets/css/themes/semi-dark-layout.css">

    <!-- BEGIN: Page CSS-->
    <link rel="stylesheet" type="text/css" href="<?php bloginfo('template_directory'); ?>/app-assets/css/core/menu/menu-types/vertical-menu.css">
    <link rel="stylesheet" type="text/css" href="<?php bloginfo('template_directory'); ?>/app-assets/css/plugins/forms/form-validation.css">
    <link rel="stylesheet" type="text/css" href="<?php bloginfo('template_directory'); ?>/app-assets/css/pages/page-auth.css">
    <!-- END: Page CSS-->

    <!-- BEGIN: Custom CSS-->
    <link rel="stylesheet" type="text/css" href="<?php bloginfo('template_directory'); ?>/assets/css/style.css">
    <!-- END: Custom CSS-->

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
<!-- END: Head-->

<!-- BEGIN: Body-->

<body class="vertical-layout vertical-menu-modern blank-page navbar-floating footer-static  " data-open="click" data-menu="vertical-menu-modern" data-col="blank-page">
<!-- BEGIN: Content-->
<div class="app-content content ">
    <div class="content-overlay"></div>
    <div class="header-navbar-shadow"></div>
    <div class="content-wrapper">
        <div class="content-header row">
        </div>
        <div class="content-body">
            <div class="auth-wrapper auth-v2">
                <div class="auth-inner row m-0">
                    <!-- Brand logo-->


                    <!-- /Brand logo-->
                    <!-- Left Text-->
                    <div class="d-none d-lg-flex col-lg-8">
                      <div class="logo">
                      <?php
                      $id_vainkeur_elo   = get_elo_vainkeur(1798);
                      $illu_vainkeur_elo = get_the_post_thumbnail_url($id_vainkeur_elo, 'full');
                      ?>
                      <img src="<?php echo $illu_vainkeur_elo; ?>" alt="VAINKEURZ logo" class="img-fluid">
                      </div>
                          </div>
                    <!-- /Left Text-->
                    <!-- Register-->
                    <div class="d-flex col-lg-4 align-items-center auth-bg px-2 p-lg-5">
                        <div class="col-12 col-sm-8 col-md-6 col-lg-12 px-xl-2 mx-auto">
                            <h2 class="card-title font-weight-bold mb-1">Les vrais tops commencent maintenant ! 🚀</h2>

                            <div class="auth-register-form mt-2">
                                <?php echo do_shortcode('[user_registration_form id="23154"]'); ?>
                            </div>
                            <p class="text-center mt-2"><span>Vous avez déjà un compte?</span><a href="<?php the_permalink(get_page_by_path('connexion')); ?>"><span>&nbsp;Connectez vous</span></a></p>
                            <div class="divider my-2">
                                <div class="divider-text">or</div>
                            </div>
                            <div class="auth-footer-btn d-flex justify-content-center">
                                <?php do_action('oa_social_link'); ?>
                      </div>
                        </div>
                        </div>
                    <!-- /Register-->
                </div>
            </div>
        </div>
    </div>
</div>
<!-- END: Content-->

<script src="<?php bloginfo('template_directory'); ?>/app-assets/vendors/js/vendors.min.js"></script>
<script src="<?php bloginfo('template_directory'); ?>/app-assets/vendors/js/forms/validation/jquery.validate.min.js"></script>
<script src="<?php bloginfo('template_directory'); ?>/app-assets/js/core/app-menu.js"></script>
<script src="<?php bloginfo('template_directory'); ?>/app-assets/js/core/app.js"></script>
<script src="<?php bloginfo('template_directory'); ?>/app-assets/js/scripts/pages/page-auth-register.js"></script>
<script>
    $(window).on('load', function() {
        if (feather) {
            feather.replace({
                width: 14,
                height: 14
            });
        }
    });
</script>
<?php wp_footer(); ?>
</body>
</html>
