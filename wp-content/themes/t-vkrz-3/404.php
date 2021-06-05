<?php
global $user_role;
if(!is_user_logged_in()){
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
                                <img class="img-fluid" src="<?php bloginfo('template_directory'); ?>/assets/images/vkrz/login/17.gif" alt="Login V2" />
                            </div>
                            <div class="gif3 animate__animated">
                                <img class="img-fluid" src="<?php bloginfo('template_directory'); ?>/assets/images/vkrz/login/25.gif" alt="Login V2" />
                            </div>
                        </div>
                        <div class="bigup w-100">
                            <h1>
                                On se demande comment tu es arrivé là ?
                            </h1>
                            <p class="text-center mt-2 already-account">
                                <span>Bref <span class="ico text-center">🙃</span></span>
                                <a href="<?php bloginfo('url'); ?>/">
                                    <span>Je veux me retourner sur la home</span>
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