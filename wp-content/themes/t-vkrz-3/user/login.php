<?php
/*
    Template Name: Log In
*/
?>
<?php
global $user_role;
if(is_user_logged_in()){
    wp_redirect(get_bloginfo('url'));
    exit;
}
else{
    $user_role = "visitor";
}
?>
<?php get_template_part('partials/head'); ?>

<body <?php body_class('vertical-layout vertical-menu-modern blank-page navbar-floating footer-static user-page'); ?> data-open="click" data-menu="vertical-menu-modern" data-col="blank-page">
<div class="app-content content ">
    <div class="header-navbar-shadow"></div>
    <div class="content-wrapper">
        <div class="content-header row"></div>
        <div class="content-body">
            <div class="auth-wrapper auth-v2">
                <div class="auth-inner row m-0">
                    <div class="d-none d-lg-flex col-lg-4 align-items-center p-5">
                        <div class="w-100 d-lg-flex align-items-center justify-content-center px-5">
                            <div class="gif1 animate__animated">
                                <img class="img-fluid" src="<?php bloginfo('template_directory'); ?>/assets/images/vkrz/login/28.gif" alt="Login V2" />
                            </div>
                            <div class="gif2 animate__animated">
                                <img class="img-fluid" src="<?php bloginfo('template_directory'); ?>/assets/images/vkrz/login/27.gif" alt="Login V2" />
                            </div>
                            <div class="gif3 animate__animated">
                                <img class="img-fluid" src="<?php bloginfo('template_directory'); ?>/assets/images/vkrz/login/2.gif" alt="Login V2" />
                            </div>
                            <div class="gif4 animate__animated">
                                <img class="img-fluid" src="<?php bloginfo('template_directory'); ?>/assets/images/vkrz/login/5.gif" alt="Login V2" />
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-8 auth-bg px-2 p-lg-5">

                        <div class="col-12 mx-auto">

                            <div class="d-flex align-items-center">
                                <a class="logo-sign" href="<?php bloginfo('url'); ?>/">
                                    <h2 class="brand-text">
                                        <img src="<?php bloginfo('template_directory'); ?>/assets/images/vkrz/logo-vkrz.png" alt="VAINKEURZ logo" class="img-fluid">
                                    </h2>
                                </a>
                                <h2 class="card-title font-weight-bold mb-1">
                                    Bienvenue <span class="ico">🖖</span>
                                </h2>
                            </div>

                            <div class="w-100"></div>

                            <p class="annonce">

                            </p>

                            <div class="auth-register-form mt-2">
                                <?php echo do_shortcode('[wppb-login form_name="log-in"]'); ?>
                            </div>

                            <p class="text-left mt-2">
                                <a href="<?php the_permalink(get_page_by_path('mot-de-passe')); ?>">
                                    <span>Mot de passe oublié ? <span class="ico text-center">🙃</span></span>
                                </a>
                            </p>

                            <hr class="divider">

                            <p class="text-left already-account">
                                <span>Tu n'as pas encore de compte <span class="ico text-center">🥴</span></span>
                                <a href="<?php the_permalink(get_page_by_path('creer-mon-compte')); ?>">
                                    <span>Clique ici pour te créer un compte</span>
                                </a>
                            </p>
                            <!--
                            <div class="divider my-2">
                                <div class="divider-text">or</div>
                            </div>
                            <div class="auth-footer-btn d-flex justify-content-center">
                                <?php do_action('oa_social_link'); ?>
                            </div>
                            -->
                        </div>
                    </div>
                    <!-- /Login-->
                </div>
            </div>
        </div>
    </div>
</div>
<?php get_footer(); ?>