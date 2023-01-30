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
<div class="card mb-3 card-compte">
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
        <div class="infovainkeur">
          <?php if (get_userdata($id_membre)->twitch_user || get_userdata($id_membre)->youtube_user || get_userdata($id_membre)->Instagram_user || get_userdata($id_membre)->tiktok_user) : ?>
            <div class="info-bio my-3">
              <div class="d-flex align-items-baseline justify-content-around">
                <?php if (get_userdata($id_membre)->twitch_user) : ?>
                  <a href="https://www.twitch.tv/<?php echo get_userdata($id_membre)->twitch_user; ?>" target="_blank" class="btn btn-icon btn-label-primary waves-effect">
                    <i class="fab fa-twitch"></i>
                  </a>
                <?php endif; ?>
                <?php if (get_userdata($id_membre)->youtube_user) : ?>
                  <a href="https://www.youtube.com/user/<?php echo get_userdata($id_membre)->youtube_user; ?>" target="_blank" class="btn btn-icon btn-label-primary waves-effect">
                    <i class="fab fa-youtube"></i>
                  </a>
                <?php endif; ?>
                <?php if (get_userdata($id_membre)->Instagram_user) : ?>
                  <a href="https://www.instagram.com/<?php echo get_userdata($id_membre)->Instagram_user; ?>" target="_blank" class="btn btn-icon btn-label-primary waves-effect">
                    <i class="fab fa-instagram"></i>
                  </a>
                <?php endif; ?>
                <?php if (get_userdata($id_membre)->twitter_user) : ?>
                  <a href="https://www.twitter.com/<?php echo get_userdata($id_membre)->twitter_user; ?>" target="_blank" class="btn btn-icon btn-label-primary waves-effect">
                    <i class="fab fa-twitter"></i>
                  </a>
                <?php endif; ?>
                <?php if (get_userdata($id_membre)->snapchat_user) : ?>
                  <a href="https://www.snapchat.com/add/<?php echo get_userdata($id_membre)->snapchat_user; ?>" target="_blank" class="btn btn-icon btn-label-primary waves-effect">
                    <i class="fab fa-snapchat"></i>
                  </a>
                <?php endif; ?>
                <?php if (get_userdata($id_membre)->tiktok_user) : ?>
                  <a href="https://www.tiktok.com/&<?php echo get_userdata($id_membre)->tiktok_user; ?>" target="_blank" class="btn btn-icon btn-label-primary waves-effect">
                    <i class="fab fa-tiktok"></i>
                  </a>
                <?php endif; ?>
              </div>
            </div>
          <?php endif; ?>
          <div class="bio">
            <p class="card-text">
              <?php echo get_userdata($id_membre)->description; ?>
            </p>
          </div>
        </div>
        <div class="separate my-3"></div>
        <a class="btn btn-outline-primary waves-effect mb-2 w-100" href="<?php echo get_author_posts_url($user_id); ?>#topsducreateur">
          Liste des Tops crées
        </a>
        <?php if ($infos_vainkeur['id_user'] != $user_id && is_user_logged_in()) : ?>
          <div class="separate my-3"></div>
          <div>
            <button type="button" id="followBtn" class="btn waves-effect d-none btn-follow" data-userid="<?= $user_id; ?>" data-uuid="<?= get_field('uuiduser_user', 'user_' . $user_id); ?>" data-relatedid="<?= $infos_vainkeur['id_user']; ?>" data-relateduuid="<?= get_field('uuiduser_user', 'user_' . $infos_vainkeur['id_user']);  ?>" data-text="<?= wp_get_current_user()->user_login ?> te guette !" data-url="<?= get_author_posts_url($user_id); ?>">
              <span class="wording">Guetter ce Vainkeur</span>
              <span class="va va-guetteur-close va va-z-20 emoji"></span>
            </button>
          </div>
        <?php endif; ?>
      </div>
    </div>
  </div>
</div>
<?php if (get_userdata($id_membre)->twitch_user) : ?>
  <div class="twitchbanaccount mb-3">
    <a href="<?php echo get_userdata($id_membre)->twitch_user; ?>" target="_blank">
      <img src="<?php bloginfo('template_directory'); ?>/assets/images/vkrz/twitch.png" class="img-fluid rounded" alt="">
    </a>
  </div>
<?php endif; ?>