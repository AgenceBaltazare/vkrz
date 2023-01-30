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
<div class="card mb-4 card-compte">
  <div class="card-body">
    <div class="user-avatar-section">
      <div class="d-flex align-items-center flex-column mb-3">
        <img class="img-fluid percent50" src="<?php echo $infos_vainkeur['avatar']; ?>" height="100" width="100" alt="<?php echo $infos_vainkeur['pseudo'] ? $infos_vainkeur['pseudo'] : "Futur Vainkeur"; ?>" />
      </div>
      <div class="user-info text-center">
        <h4 class="mb-2">
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
        <div class="mt-3">
          <div class="d-flex align-items-center justify-content-center">
            <?php if ($infos_vainkeur['user_role']  == "administrator" || $infos_vainkeur['user_role'] == "author" && is_user_logged_in()) : ?>
              <a class="btn btn-primary waves-effect waves-light" href="<?php bloginfo('url'); ?>/wp-admin/edit.php?post_type=tournoi" target="_blank">
                Gestion des Tops
              </a>
            <?php endif; ?>
            <?php if (is_user_logged_in()) : ?>
              <a class="btn btn-primary waves-effect waves-light ms-2" href="<?php the_permalink(get_page_by_path('/mon-compte/parametres')); ?>">
                Editer mes infos
              </a>
            <?php endif; ?>
          </div>
          <div class="separate my-3"></div>
          <?php if (!is_author() && is_user_logged_in() && !is_page(218587)) : ?>
            <div>
              <a href="<?php echo get_author_posts_url($user_id); ?>" class="w-100 btn btn-outline-primary waves-effect">
                Accéder au profil public
              </a>
            </div>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </div>
</div>