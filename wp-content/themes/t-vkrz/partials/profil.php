<?php
global $user_id;
global $vainkeur_id;
global $infos_vainkeur_to_watch;
global $infos_vainkeur;
global $user_id;
global $id_membre;
if (is_author() || is_page(218587)) {
  $infos_vainkeur = $infos_vainkeur_to_watch;
} else {
  $id_membre = $user_id;
}
$cover_profil_id = 0;
?>
<script>
  const uuidVainkeurProfile = "<?php echo get_field('uuiduser_user', 'user_' . $id_membre); ?>";
</script>

<!-- Header -->
<div class="row">
  <div class="col-12">
    <div class="card mb-4">
      <div class="user-profile-header-banner">
        <?php
        $cover_profil_url   = "";
        if ($id_membre) {
          if (get_userdata($id_membre)->cover_profil) {
            $cover_profil_id  = get_userdata($id_membre)->cover_profil;
            $cover_profil_url = wp_get_attachment_url($cover_profil_id);
          }
        }
        ?>
        <div class="card-img-top cover-profil" style="background-image: url(<?php echo $cover_profil_url; ?>">
          <?php if (!is_author() && !is_page(218587)) : ?>
            <a href="<?php the_permalink(27794); ?>" class="badge bg-primary edit-cover-btn">
              Changer de cover
            </a>
          <?php endif; ?>
        </div>
      </div>
      <div class="user-profile-header d-flex flex-column flex-sm-row text-sm-start text-center mb-4">
        <div class="flex-shrink-0 mt-n2 mx-sm-0 mx-auto">
          <img src="<?php echo $infos_vainkeur['avatar']; ?>" alt="avatar de <?php echo $infos_vainkeur['pseudo'] ? $infos_vainkeur['pseudo'] : "Futur Vainkeur"; ?>" class="d-block h-auto ms-0 ms-sm-4 percent50" />
        </div>
        <div class="flex-grow-1 mt-3 mt-sm-5">
          <div class="d-flex align-items-md-end align-items-sm-start align-items-center justify-content-md-between justify-content-start mx-4 flex-md-row flex-column gap-4">
            <div class="user-profile-info">
              <h4>
                <?php echo $infos_vainkeur['pseudo'] ? $infos_vainkeur['pseudo'] : "Futur Vainkeur"; ?>
                <span class="va-md" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-bs-original-title="Niveau">
                  <?php echo $infos_vainkeur['level']; ?>
                </span>
                <?php if ($infos_vainkeur['user_role']  == "administrator") : ?>
                  <span class="va va-vkrzteam va-md" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-bs-original-title="TeamVKRZ"></span>
                <?php endif; ?>
                <?php if ($infos_vainkeur['user_role']  == "administrator" || $infos_vainkeur['user_role'] == "author") : ?>
                  <span class="va va-man-singer va-md" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-bs-original-title="Créateur de Tops"></span>
                <?php endif; ?>
              </h4>
            </div>
            <?php if (!is_author() && is_user_logged_in() && !is_page(218587)) : ?>
              <div class="ml-auto">
                <a href="<?php echo get_author_posts_url($user_id); ?>" class="btn btn-outline-primary waves-effect">
                  Profil public
                </a>
              </div>
            <?php endif; ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!--/ Header -->

<!-- Navbar pills -->
<div class="row">
  <div class="col-md-12">
    <ul class="nav nav-pills flex-column flex-sm-row mb-4">
      <?php if (!is_author() && !is_page(218587)) : ?>
        <li class="nav-item">
          <a class="nav-link <?php if (is_page(get_page_by_path('mon-compte'))) { echo 'active'; }; ?>" href="<?php the_permalink(get_page_by_path('mon-compte')); ?>">
            Récap
          </a>
        </li>
        <?php if (is_user_logged_in()) : ?>
          <li class="nav-item">
            <a class="nav-link <?php if (is_page(305107)) : echo 'active'; endif; ?>" href="<?php the_permalink(305107); ?>">
              KEURZ
            </a>
          </li>
        <?php endif; ?>
        <?php if ($infos_vainkeur['user_role'] == "administrator" || $infos_vainkeur['user_role'] == "author") : ?>
          <li class="nav-item">
            <a class="nav-link <?php if (is_page(172849)) : echo 'active'; endif; ?>" href="<?php the_permalink(get_page_by_path('mon-compte/createur')); ?>">
              Créateur
            </a>
          </li>
        <?php endif; ?>
        <?php if (is_user_logged_in()) : ?>
          <li class="nav-item">
            <a class="nav-link <?php if (is_page('Notifications')) : echo 'active'; endif; ?>" href="<?php the_permalink(get_page_by_path('/mon-compte/notifications')); ?>">
              Notifs
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link <?php if (is_page('Guetteur')) : echo 'active'; endif; ?>" href="<?php the_permalink(get_page_by_path('/mon-compte/Guetteur')); ?>">
              Guetteur
            </a>
          </li>
        <?php endif; ?>
        <?php if (is_user_logged_in()) : ?>
          <li class="nav-item">
            <a class="nav-link <?php if (is_page('parametres')) : echo 'active'; endif; ?>" href="<?php the_permalink(get_page_by_path('/mon-compte/parametres')); ?>">
              Editer
            </a>
          </li>

          <li class="nav-item">
            <a class="nav-link <?php if (is_page('Parrainage')) : echo 'active'; endif; ?>" href="<?php the_permalink(get_page_by_path('/mon-compte/parrainage')); ?>">
              Parrainage
            </a>
          </li>
        <?php endif; ?>
        <?php if ($infos_vainkeur['user_role']  == "administrator" || $infos_vainkeur['user_role'] == "author" && is_user_logged_in()) : ?>
          <li class="nav-item">
            <a class="nav-link" href="<?php bloginfo('url'); ?>/wp-admin/edit.php?post_type=tournoi" target="_blank">
              Gestion de mes Tops
            </a>
          </li>
        <?php endif; ?>
      <?php else : ?>
        <li class="nav-item">
          <a class="nav-link <?php if (is_author()) : echo 'active'; endif; ?>" href="<?php echo get_author_posts_url($vainkeur_id); ?>">
            Récap
          </a>
        </li>
        <?php if ($infos_vainkeur['user_role'] == "administrator" || $infos_vainkeur['user_role'] == "author") : ?>
          <li class="nav-item">
            <a class="nav-link <?php if (is_page(218587)) : echo 'active'; endif; ?>" href="<?php the_permalink(218587); ?>?creator_id=<?php echo $id_membre; ?>">
              Créateur
            </a>
          </li>
        <?php endif; ?>
      <?php endif; ?>
    </ul>
    <?php if ($infos_vainkeur['id_user'] != $user_id && is_user_logged_in()) : ?>
      <button type="button" id="followBtn" class="btn waves-effect d-none btn-follow" data-userid="<?= $user_id; ?>" data-uuid="<?= get_field('uuiduser_user', 'user_' . $user_id); ?>" data-relatedid="<?= $infos_vainkeur['id_user']; ?>" data-relateduuid="<?= get_field('uuiduser_user', 'user_' . $infos_vainkeur['id_user']);  ?>" data-text="<?= wp_get_current_user()->user_login ?> te guette !" data-url="<?= get_author_posts_url($user_id); ?>">
        <span class="wording">Guetter ce Vainkeur</span>
        <span class="va va-guetteur-close va va-z-20 emoji"></span>
        <span class="va va-guetteur-close va va-z-20 emoji"></span>
      </button>
    <?php endif; ?>
  </div>
</div>
<!--/ Navbar pills -->