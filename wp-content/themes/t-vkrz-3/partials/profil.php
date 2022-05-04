<?php
global $uuiduser;
global $user_id;
global $vainkeur_id;
global $vainkeur_info;
global $user_infos;
$vainkeur_info = isset($vainkeur_info) ? $vainkeur_info : $user_infos;
?>
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

      <?php
      $check_already_sub = new WP_Query(
        array(
          'post_type' => 'notification',
          'orderby' => 'date',
          'posts_per_page' => '-1',
          'meta_query'     => array(
            'relation' => 'AND',
            array(
              'key'     => 'uuid_user_notif',
              'value'   => $uuiduser,
              'compare' => '=',
            ),
            array(
              'key'     => 'relation_uuid_notif',
              'value'   => $vainkeur_info['uuid_user_vkrz'],
              'compare' => '=',
            )
          )
        )
      );
      ?>
      <?php if (strtolower($user_infos['pseudo']) != strtolower($vainkeur_info['pseudo'])) : ?>
        <div class="ml-auto mb-2">
          <?php if ($check_already_sub->have_posts()) : ?>
            <button id="" disabled="true" class="btn btn-outline-success waves-effect">
              Suivi! 😉
            </button>
          <?php else : ?>
            <button id="follow_btn" class="btn btn-outline-primary waves-effect" data-userid="<?= $user_id; ?>" data-uuid="<?php echo $uuiduser; ?>" data-relatedid="<?= $vainkeur_id; ?>" data-related="<?= $vainkeur_info['uuid_user_vkrz']; ?>" data-text="<?= $user_infos['pseudo'] ?> vous guette !" data-url="<?= $user_infos['avatar']; ?>">
              Suivre <span class="ico text-center va va-smiling-face-with-heart-eyes va-lg"></span>
            </button>
          <?php endif; ?>
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
                  <a class="nav-link font-weight-bold <?php if (is_page(444131)) {
                                                        echo 'btn btn-primary';
                                                      } ?>" href="<?php the_permalink(get_page_by_path('mon-compte/notifications')); ?>">
                    Mes notifications
                  </a>
                </li>

                <li class="nav-item">
                  <a class="nav-link font-weight-bold <?php if (is_page(444177)) {
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
                                                      } ?>" href="<?php the_permalink(218587); ?>?creator_id=<?php echo $vainkeur_id; ?>">
                    Créateur
                  </a>
                </li>
              <?php endif; ?>
            <?php endif; ?>
          </ul>
        </div>
      </div>
    </nav>
  </div>
</div>