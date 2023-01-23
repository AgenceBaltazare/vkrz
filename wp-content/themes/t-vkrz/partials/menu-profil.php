<?php
global $infos_vainkeur;
?>
<nav class="navbar navbar-example navbar-expand-lg card">
  <div class="container-fluid">
    <a class="navbar-brand" href="javascript:void(0)">Menu</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar-ex-3">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbar-ex-3">
      <div class="navbar-nav me-auto">
        <?php if (!is_author() && !is_page(218587)) : ?>
          <a class="nav-item nav-link <?php if (is_page(get_page_by_path('mon-compte'))) : echo 'active';
                                      endif; ?>" href="<?php the_permalink(get_page_by_path('mon-compte')); ?>">
            Mon récap
          </a>
          <?php if (is_user_logged_in()) : ?>
            <a class="nav-item nav-link <?php if (is_page(305107)) : echo 'active';
                                        endif; ?>" href="<?php the_permalink(305107); ?>">
              KEURZ
            </a>
          <?php endif; ?>
          <?php if (is_user_logged_in()) : ?>
            <a class="nav-item nav-link <?php if (is_page('Notifications')) : echo 'active';
                                        endif; ?>" href="<?php the_permalink(get_page_by_path('/mon-compte/notifications')); ?>">
              Notifs
            </a>
            <a class="nav-item nav-link <?php if (is_page('Guetteur')) : echo 'active';
                                        endif; ?>" href="<?php the_permalink(get_page_by_path('/mon-compte/Guetteur')); ?>">
              Guetteur
            </a>
            <a class="nav-item nav-link <?php if (is_page('Parrainage')) : echo 'active';
                                        endif; ?>" href="<?php the_permalink(get_page_by_path('/mon-compte/parrainage')); ?>">
              Parrainage
            </a>
          <?php endif; ?>
        <?php else : ?>
          <a class="nav-item nav-link <?php if (is_author()) : echo 'active';
                                      endif; ?>" href="<?php echo get_author_posts_url($vainkeur_id); ?>">
            Son récap
          </a>
          <?php if ($infos_vainkeur['user_role'] == "administrator" || $infos_vainkeur['user_role'] == "author") : ?>
            <a class="nav-item nav-link <?php if (is_page(218587)) : echo 'active';
                                        endif; ?>" href="<?php the_permalink(218587); ?>?creator_id=<?php echo $id_membre; ?>">
              Créateur
            </a>
          <?php endif; ?>
        <?php endif; ?>
      </div>
    </div>
  </div>
</nav>