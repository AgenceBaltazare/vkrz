<?php
global $uuid_vainkeur;
global $user_id;
global $user_tops;
global $infos_vainkeur;
global $id_vainkeur;
global $utm;
global $id_top;
global $sponso;
$reponse = delete_old_cookies();
if (get_post_type() != "tournoi") {
  $user_id        = get_user_logged_id();
  $vainkeur       = get_vainkeur();
  $uuid_vainkeur  = $vainkeur['uuid_vainkeur'];
  $id_vainkeur    = $vainkeur['id_vainkeur'];
  if (is_user_logged_in()) {
    $infos_vainkeur = get_user_infos($uuid_vainkeur, "complete");
  } else {
    $infos_vainkeur = get_fantom($id_vainkeur);
  }
}
if (get_post_type() == "tournoi") {
  global $top_infos;
}
$utm = deal_utm();
?>
<!DOCTYPE html>
<html lang="fr" class="dark-style dark-layout layout-menu-fixed" dir="ltr" data-theme="theme-default" data-assets-path="assets/" data-template="horizontal-menu-template">

<head>
  <!--[if lt IE 9]>
    <script src="https://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
  <link rel="profile" href="http://gmpg.org/xfn/11">
  <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>">
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

  <?php if (is_page(array(482612, 26626, 256697, 256700, 284944, 292414))) : ?>
    <meta name='robots' content='noindex, nofollow' />
  <?php endif; ?>

  <?php get_template_part('partials/meta'); ?>

  <?php if ($infos_vainkeur['user_role'] != "administrator" && env() != "local") : ?>
    <!-- Google Tag Manager -->
    <script>
      (function(w, d, s, l, i) {
        w[l] = w[l] || [];
        w[l].push({
          'gtm.start': new Date().getTime(),
          event: 'gtm.js'
        });
        var f = d.getElementsByTagName(s)[0],
          j = d.createElement(s),
          dl = l != 'dataLayer' ? '&l=' + l : '';
        j.async = true;
        j.src =
          'https://www.googletagmanager.com/gtm.js?id=' + i + dl;
        f.parentNode.insertBefore(j, f);
      })(window, document, 'script', 'dataLayer', 'GTM-KH379F5');
    </script>
    <!-- End Google Tag Manager -->
  <?php endif; ?>

  <script>
    window.dataLayer = window.dataLayer || [];
  </script>

  <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.15.4/css/all.css" integrity="sha384-rqn26AG5Pj86AF4SO72RK5fyefcQ/x32DNQfChxWvbXIyXFePlEktwD18fEz+kQU" crossorigin="anonymous">

  <?php wp_head(); ?>

  <?php if ((is_single() && get_field('fichier_css', $id_top)) || (is_page(get_page_by_path('elo')))) : ?>
    <link rel='stylesheet' href='<?php bloginfo('template_directory'); ?>/assets/special/css/<?php the_field('fichier_css', $id_top); ?>' type='text/css' media='all' />
  <?php endif; ?>
</head>

<?php
if ($infos_vainkeur) {
  $anonyme_avatar_url = $infos_vainkeur['avatar'];
} else {
  $anonyme_avatar_url = get_bloginfo('template_directory') . '/assets/images/vkrz/avatar-rose.png';
}
?>
<script>
  const currentUserId = "<?php echo $user_id; ?>",
    currentUserProfileUrl = "<?php echo get_author_posts_url($user_id); ?>",
    anonymeAvatarUrl = "<?php echo $anonyme_avatar_url; ?>",
    vainkeurPseudo = "<?php echo $infos_vainkeur['pseudo']; ?>",
    idVainkeurTour = "<?php echo $id_vainkeur; ?>",
    currentUuid = "<?php echo $uuid_vainkeur; ?>",
    currentUserRole = "<?php echo $infos_vainkeur['user_role']; ?>";
</script>

<body <?php body_class(); ?>>
  <?php if ($infos_vainkeur['user_role'] != "administrator" && env() != "local") : ?>
    <!-- Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-KH379F5" height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->
  <?php endif; ?>

  <!-- Layout wrapper -->
  <div class="layout-wrapper layout-navbar-full layout-horizontal layout-without-menu">
    <div class="layout-container">

      <!-- Navbar -->
      <nav class="layout-navbar navbar navbar-expand-xl align-items-center bg-navbar-theme" id="layout-navbar">
        <div class="container-xxl">
          <div class="navbar-brand app-brand demo d-none d-xl-flex py-0 me-4">
            <a href="<?php bloginfo('url'); ?>" class="app-brand-link gap-2">
              <span class="logo">
                <img src="<?php bloginfo('template_directory'); ?>/assets/images/vkrz/logo-vkrz.png" alt="VAINKEURZ logo" class="img-fluid">
              </span>
            </a>
            <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-xl-none">
              <i class="ti ti-x ti-sm align-middle"></i>
            </a>
          </div>
          <?php get_template_part('partials/menu-user'); ?>
        </div>
      </nav>
      <!-- / Navbar -->

      <!-- Layout container -->
      <?php if (isset($top_infos)) : ?>
        <div class="layout-page cover t-normal-container " style="background: url(<?php echo $top_infos['top_cover']; ?>) center center no-repeat">
          <div class="overlay"></div>
        <?php else : ?>
          <div class="layout-page">
          <?php endif; ?>

          <!-- Content wrapper -->
          <div class="content-wrapper">

            <!-- Menu -->
            <?php get_template_part('partials/menu-vkrz'); ?>
            <!-- / Menu -->

            <!-- Content -->
            <?php if (get_post_type() == "classement" || get_post_type() == "toplist-mondiale") : ?>
              <div class="container-fluid flex-grow-1 p-0">
              <?php else : ?>
                <div class="container-xxl flex-grow-1 p-0">
                <?php endif; ?>
                <div class="row g-4 mb-3">