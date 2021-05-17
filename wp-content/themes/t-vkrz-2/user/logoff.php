<?php
/*
    Template Name: Log off
*/
?>
<?php
global $user_role;
if(is_user_logged_in()){
    wp_logout();
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
                    <div class="col-lg-12 p-5 text-center">
                        <div class="w-100">
                            <div class="gif1 animate__animated">
                                <img class="img-fluid" src="<?php bloginfo('template_directory'); ?>/assets/images/vkrz/login/9.gif" alt="Login V2" />
                            </div>
                            <div class="gif3 animate__animated">
                                <img class="img-fluid" src="<?php bloginfo('template_directory'); ?>/assets/images/vkrz/login/15.gif" alt="Login V2" />
                            </div>
                        </div>
                        <div class="bigup w-100">
                            <h1>
                                Ça rend malade de te voir partir comme ça !
                            </h1>
                            <p class="text-center mt-2 already-account">
                                <span>C'était une erreur <span class="ico text-center">😅</span></span>
                                <a href="<?php the_permalink(get_page_by_path('se-connecter')); ?>">
                                    <span>Me reconnecter</span>
                                </a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="<?php bloginfo('template_directory'); ?>/assets/vendors/js/vendors.min.js"></script>
<script src="<?php bloginfo('template_directory'); ?>/assets/vendors/js/extensions/sweetalert2.all.min.js"></script>
<script src="<?php bloginfo('template_directory'); ?>/assets/vendors/js/extensions/polyfill.min.js"></script>
<script src="<?php bloginfo('template_directory'); ?>/assets/js/core/app-menu.js"></script>
<script src="<?php bloginfo('template_directory'); ?>/assets/js/core/app.js"></script>
<script src="<?php bloginfo('template_directory'); ?>/assets/js/scripts/extensions/ext-component-sweet-alerts.js"></script>
<script src="<?php bloginfo('template_directory'); ?>/assets/js/core/main.js"></script>

<?php wp_footer(); ?>
</body>
</html>