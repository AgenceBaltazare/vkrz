<?php
/*
    Template Name: Connexion
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

  <div class="app-content content get-connected">
    <div class="content-wrapper">
      <div class="content-body">

        <a href="#logIn" class="go-logIn">
          Cliquer pour Se Connecter
          <span class="ico va va-down-arrow va-1x"></span>
        </a>

        <div class="auth-wrapper auth-v2">
          <div class="auth-inner row justify-content-between mt-1">
            <div class="col-lg-6 px-0 px-md-1">
              <div class="sign-up">
                <div class="d-flex align-items-center justify-content-center">
                  <h2 class="card-title text-center font-weight-bold mb-1">
                    Créer ton compte <br>
                    pour enregistrer tes Tops <span class="ico va va-star-struck va-1x"></span>
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
                    <?php
                    if (isset($_GET['redirect']) && $_GET['redirect'] != "") {
                      $link_to_redirect = $_GET['redirect'] . "?message=logyes";
                      echo do_shortcode('[wppb-register form_name="sign-on" redirect_url="' . $link_to_redirect . '"]');
                    } else {
                      echo do_shortcode('[wppb-register form_name="sign-on"]');
                    }
                    ?>
                  </div>
                </div>
              </div>
            </div>

            <div class="col-lg-6 mt-3 mt-lg-0 px-0 px-md-1">
              <div class="sign-in" onmouseover="document.querySelector('.sign-up').classList.add('shade')" onmouseout="document.querySelector('.sign-up').classList.remove('shade')">
                <div class="d-flex align-items-center flex-column">
                  <h2 class="card-title font-weight-bold mb-1 text-uppercase" id="logIn">
                    Se connecter <span class="ico va va-vulcan-salute va-1x"></span>
                  </h2>
                </div>

                <div class="auth-register-form mt-2">
                  <div class="login-form mt-4">
                    <h3>En un seul click</h3>
                    <?php do_action('oa_social_login'); ?>
                  </div>
                  <div class="separateur separateur-1 mt-0"></div>
                  <div class="classic-form">
                    <h3>ou en mode classik</h3>
                    <?php
                    if (isset($_GET['redirect']) && $_GET['redirect'] != "") {
                      $link_to_redirect = $_GET['redirect'] . "?message=logyes";
                      echo do_shortcode('[wppb-login form_name="log-in" redirect_url="' . $link_to_redirect . '"]');
                    } else {
                      echo do_shortcode('[wppb-login form_name="log-in"]');
                    }
                    ?>
                  </div>
                </div>

                <p class="text-center mt-2">
                  <a href="<?php the_permalink(get_page_by_path('mot-de-passe')); ?>">
                    <span>Mot de passe oublié ? <span class="ico text-center va va-upside-down-face va-lg"></span></span>
                  </a>
                </p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <?php get_footer(); ?>