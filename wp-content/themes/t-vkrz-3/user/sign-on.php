<?php
/*
    Template Name: Sign On
*/
?>
<?php
global $user_role;
if (is_user_logged_in()) {
    wp_redirect(get_bloginfo('url'));
    exit;
} else {
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
                                    Créer ton compte <br>
                                    pour enregistrer tes Tops <span class="ico">🤩</span>
                                </h2>
                            </div>

                            <div class="auth-register-form mt-2">
                                <div class="login-form">
                                    <h3>En un seul click</h3>
                                    <?php do_action('oa_social_login'); ?>
                                </div>
                                <div class="separateur separateur-1 mt-0"></div>
                                <div class="classic-form">
                                    <h3>ou en mode classik</h3>
                                    <?php echo do_shortcode('[wppb-register form_name="sign-on"]'); ?>
                                </div>
                            </div>

                            <p class="mt-2 already-account">
                                <span>Tu as déjà un compte <span class="ico text-center">🥴</span></span>
                                <a href="<?php the_permalink(get_page_by_path('se-connecter')); ?>">
                                    <span>Clique ici pour te connecter</span>
                                </a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php get_footer(); ?>