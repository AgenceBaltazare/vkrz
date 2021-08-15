<?php
/*
    Template Name: Password
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
<?php get_header(); ?>
<body <?php body_class('vertical-layout vertical-menu-modern blank-page navbar-floating footer-static user-page'); ?> data-open="click" data-menu="vertical-menu-modern" data-col="blank-page">
<div class="app-content content ">
    <div class="content-wrapper">
        <div class="content-body">
            <div class="auth-wrapper auth-v2">
                <div class="auth-inner row">
                    <div class="col-lg-12">
                        <div class="d-flex align-items-center">
                            <h2 class="card-title font-weight-bold mb-1">
                                Reset ton mot de passe <span class="ico">🥴</span>
                            </h2>
                        </div>

                        <div class="w-100"></div>

                        <p class="annonce">

                        </p>

                        <div class="auth-register-form mt-2">
                            <?php echo do_shortcode('[wppb-recover-password]'); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php get_footer(); ?>