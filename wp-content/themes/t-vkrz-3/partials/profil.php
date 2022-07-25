<?php
global $uuiduser;
global $user_id;
global $vainkeur_id;
global $vainkeur_info;
global $user_infos;
global $id_membre;
$vainkeur_info = isset($vainkeur_info) ? $vainkeur_info : $user_infos;
?>
<script>
  const idVainkeurProfil = "<?php echo $id_membre ?>";
</script>
<div class="card profile-header mb-2">

  <div class="card-img-top cover-profil"></div>

  <div class="position-relative">

    <div class="profile-img-container d-flex align-items-center">
      <div class="profile-img" style="background: url(<?php echo $vainkeur_info['avatar']; ?>) #7367f0 no-repeat center center;">

      </div>
      <div class="profile-title ml-3">
        <h2 class="text-white text-uppercase">
          <?php echo $vainkeur_info['pseudo'] ? $vainkeur_info['pseudo'] : "Futur Vainkeur"; ?>
        </h2>
        <p class="text-white">
          <span class="ico" data-toggle="tooltip" data-placement="top" title="" data-original-title="Niveau actuel">
            <?php echo $vainkeur_info['level']; ?>
          </span>
          <?php if ($vainkeur_info['user_role']  == "administrator") : ?>
            <span class="ico va va-vkrzteam va-lg" data-toggle="tooltip" data-placement="top" title="" data-original-title="TeamVKRZ">

            </span>
          <?php endif; ?>
          <?php if ($vainkeur_info['user_role']  == "administrator" || $vainkeur_info['user_role'] == "author") : ?>
            <span class="ico va va-man-singer va-lg" data-toggle="tooltip" data-placement="top" title="" data-original-title="Créateur de Tops">

            </span>
          <?php endif; ?>
        </p>
      </div>

      <?php if (!is_author() && is_user_logged_in() && !is_page(218587)) : ?>
        <div class="ml-auto mb-2">
          <a href="<?php echo get_author_posts_url($user_id); ?>" class="btn btn-outline-primary waves-effect">
            Profil public
          </a>
        </div>
      <?php endif; ?>
    </div>
  </div>

  <div class="profile-header-nav">
    <nav class="navbar navbar-expand-md navbar-light justify-content-end justify-content-md-between w-100">
      <button class="btn btn-icon navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <i data-feather="align-justify" class="font-medium-5"></i>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <div class="profile-tabs d-flex justify-content-between flex-wrap mt-1 mt-md-0">
          <ul class="nav nav-pills mb-0">
            <?php if (!is_author() && !is_page(218587)) : ?>
              <li class="nav-item">
                <a class="nav-link font-weight-bold <?php if (is_page(get_page_by_path('mon-compte'))) {
                                                      echo 'btn btn-primary';
                                                    } ?>" href="<?php the_permalink(get_page_by_path('mon-compte')); ?>">
                  Récap
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link font-weight-bold <?php if (is_page(305107)) {
                                                      echo 'btn btn-primary';
                                                    } ?>" href="<?php the_permalink(305107); ?>">
                  Mes KEURZ
                </a>
              </li>
              <?php if ($vainkeur_info['user_role'] == "administrator" || $vainkeur_info['user_role'] == "author") : ?>
                <li class="nav-item">
                  <a class="nav-link font-weight-bold <?php if (is_page(172849)) {
                                                        echo 'btn btn-primary';
                                                      } ?>" href="<?php the_permalink(get_page_by_path('mon-compte/createur')); ?>">
                    Créateur
                  </a>
                </li>
              <?php endif; ?>
              <?php if (is_user_logged_in()) : ?>
                <li class="nav-item">
                  <a class="nav-link font-weight-bold <?php if (is_page(get_page_by_path('parametres'))) {
                                                        echo 'btn btn-primary';
                                                      } ?>" href="<?php the_permalink(get_page_by_path('parametres')); ?>">
                    Editer mon profil
                  </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link font-weight-bold <?php if (is_page(347883)) {
                                                        echo 'btn btn-primary';
                                                      } ?>" href="<?php the_permalink(get_page_by_path('mon-compte/notifications')); ?>">
                    Mes notifications
                  </a>
                </li>

                <li class="nav-item">
                  <a class="nav-link font-weight-bold <?php if (is_page(347406)) {
                                                        echo 'btn btn-primary';
                                                      } ?>" href="<?php the_permalink(get_page_by_path('mon-compte/amis')); ?>">
                    Amigos
                  </a>
                </li>
              <?php endif; ?>
              <?php if ($vainkeur_info['user_role']  == "administrator" || $vainkeur_info['user_role'] == "author" && is_user_logged_in()) : ?>
                <li class="nav-item">
                  <a class="nav-link font-weight-bold" href="<?php bloginfo('url'); ?>/wp-admin/edit.php?post_type=tournoi" target="_blank">
                    Gestion de mes Tops
                  </a>
                </li>
              <?php endif; ?>
            <?php else : ?>
              <li class="nav-item">
                <a class="nav-link font-weight-bold <?php if (is_author()) {
                                                      echo 'btn btn-primary';
                                                    } ?>" href="<?php echo get_author_posts_url($vainkeur_id); ?>">
                  Récap
                </a>
              </li>
              <?php if ($vainkeur_info['user_role'] == "administrator" || $vainkeur_info['user_role'] == "author") : ?>
                <li class="nav-item">
                  <a class="nav-link font-weight-bold <?php if (is_page(218587)) {
                                                        echo 'btn btn-primary';
                                                      } ?>" href="<?php the_permalink(218587); ?>?creator_id=<?php echo $id_membre; ?>">
                    Créateur
                  </a>
                </li>
              <?php endif; ?>
            <?php endif; ?>
          </ul>
          <?php if (strtolower($user_infos['pseudo']) != strtolower($vainkeur_info['pseudo']) && is_user_logged_in()) : ?>
            <button type="button" id="followBtn" class="btn btn-warning waves-effect waves-float waves-light" style="display: none;" data-userid="<?= $user_id; ?>" data-uuid="<?php echo $uuiduser; ?>" data-relatedid="<?= $id_membre; ?>" data-relateduuid="<?= get_field('uuiduser_user', 'user_' . $id_membre);  ?>" data-text="<?= $user_infos['pseudo'] ?> vous guette !" data-url="<?= get_author_posts_url($user_id); ?>">
              <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-star me-25">
                <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon>
              </svg>
              <span>Suivre</span>
            </button>
          <?php endif; ?>
        </div>
      </div>
    </nav>
  </div>
</div>