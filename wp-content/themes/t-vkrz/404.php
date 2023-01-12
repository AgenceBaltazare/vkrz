<?php
global $user_role;
if (!is_user_logged_in()) {
    $user_role = "visitor";
}
?>
<?php get_header(); ?>

<body <?php body_class('vertical-layout vertical-menu-modern blank-page navbar-floating footer-static user-page'); ?> data-open="click" data-menu="vertical-menu-modern" data-col="blank-page">

    <div class="auth-wrapper auth-v2">
        <div class="auth-inner row">
            <div class="col-lg-12 text-center">
                <div class="w-100">
                    <span class="ico ico-max va va-anxious-face-with-sweat va-1x"></span>
                </div>
                <div class="bigup w-100">
                    <h1>
                        On se demande comment tu es arrivé là ?
                    </h1>
                    <p class="text-center mt-2 already-account">
                        <span>Bref <span class="ico text-center va va-upside-down-face va-lg">🙃</span></span>
                        <a href="<?php bloginfo('url'); ?>/">
                            <span>Je veux retourner sur la home</span>
                        </a>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <?php wp_footer(); ?>
</body>

</html>