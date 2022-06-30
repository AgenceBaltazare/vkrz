<!-- BEGIN: Main Menu-->
<div class="main-menu menu-fixed menu-dark menu-accordion menu-shadow" data-scroll-to-active="true">
  <div class="navbar-header">
    <ul class="nav navbar-nav flex-row">
      <li class="nav-item mr-auto">
        <a class="navbar-brand" href="<?php bloginfo('url'); ?>/">
          <h2 class="brand-text">
            <img src="<?php bloginfo('template_directory'); ?>/assets/images/vkrz/logo-vkrz.png" alt="VAINKEURZ logo" class="img-fluid">
          </h2>
          <div class="badge-beta">
            <span class="badge">
              <?php
              $template_data       = wp_get_theme();
              $template_version    = $template_data['Version'];
              ?>
              BETA <?php echo $template_version; ?>
            </span>
          </div>
        </a>
      </li>
      <li class="nav-item nav-toggle hide-lg">
        <a class="nav-link modern-nav-toggle pr-0" data-toggle="collapse">
          <span class="ico va va-person-gesturing-no va-lg"></span>
          fermer
        </a>
      </li>
    </ul>
  </div>
  <div class="main-menu-content">
    <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">
      <li class="nav-item">
        <div class="rs-menu mt-1">
          <div class="w-100 btn-group justify-content-center share-t" role="group">
            <a data-rs-name="discord" href="https://discord.gg/E9H9e8NYp7" class="btn btn-outline-primary waves-effect sociallink" target="_blank">
              <i class="fab fa-discord"></i>
            </a>
            <a data-rs-name="instagram" href="https://www.instagram.com/wearevainkeurz/" class="btn btn-outline-primary waves-effect sociallink" target="_blank">
              <i class="fab fa-instagram"></i>
            </a>
            <a data-rs-name="twitter" href="https://twitter.com/Vainkeurz" target="_blank" class="btn btn-outline-primary waves-effect sociallink">
              <i class="fab fa-twitter"></i>
            </a>
            <a data-rs-name="tiktok" href="https://www.tiktok.com/@vainkeurz" target="_blank" class="btn btn-outline-primary waves-effect sociallink">
              <i class="fab fa-tiktok"></i>
            </a>
          </div>
        </div>
      </li>

      <?php if (!is_page(get_page_by_path('rechercher'))) : ?>
        <li class="mx-auto boxtosearch" style="width: 80%;">
          <form action="<?= the_permalink(get_page_by_path('rechercher')); ?>" method="GET" class="mt-2 d-flex rechercher-form" autocomplete="off">
            <input type="search" name="term" id="term" class="form-control rechercher-input" placeholder="Rechercher..." required oninvalid="this.setCustomValidity('Son goku par exemple..')">
            <button type="submit" class="form-control lead go-input">
              <span class="ico ico-search va va-magnifying-glass-tilted-left va-lg"></span>
            </button>
          </form>
        </li>
      <?php endif; ?>

      <li class="navigation-header">
        <span data-i18n="">Catégories de Tops</span> <i data-feather="more-horizontal"></i>
      </li>
      <?php
      $cat_t = get_terms(array(
        'taxonomy'      => 'categorie',
        'orderby'       => 'count',
        'order'         => 'DESC',
        'hide_empty'    => true,
        'include'       => array(3, 7, 5)
      ));
      foreach ($cat_t as $cat) : ?>
        <li class="nav-item">
          <a class="d-flex align-items-center" href="<?php echo get_category_link($cat->term_id); ?>">
            <span class="ico">
              <?php the_field('icone_cat', 'term_' . $cat->term_id); ?>
            </span>
            <span class="menu-title text-truncate">
              <?php echo $cat->name; ?>
            </span>
          </a>
        </li>
      <?php endforeach; ?>
      <li class="nav-item has-sub">
        <a class="d-flex align-items-center" href="#">
          <span class="ico">
            <span class="va va-keycap-5 va-lg"></span>
          </span>
          <span class="menu-title text-truncate">
            Autres catégories
          </span>
        </a>
        <ul class="menu-content">
          <?php
          $cat_t = get_terms(array(
            'taxonomy'      => 'categorie',
            'orderby'       => 'count',
            'order'         => 'DESC',
            'hide_empty'    => true,
            'include'       => array(2, 4, 10, 56, 6)
          ));
          foreach ($cat_t as $cat) : ?>
            <li>
              <a class="d-flex align-items-center" href="<?php echo get_category_link($cat->term_id); ?>">
                <span class="ico">
                  <?php the_field('icone_cat', 'term_' . $cat->term_id); ?>
                </span>
                <span class="menu-title text-truncate">
                  <?php echo $cat->name; ?>
                </span>
              </a>
            </li>
          <?php endforeach; ?>
        </ul>
      </li>
      <li class="navigation-header">
        <span>Des lots à gagner</span> <i data-feather="more-horizontal"></i>
      </li>
      <li class="nav-item">
        <a class="d-flex align-items-center" href="<?php the_permalink(get_page_by_path('tops-sponso')); ?>/">
          <span class="ico">
            <span class="va va-wrapped-gift va-lg"></span>
          </span>
          <span class="menu-title text-truncate">
            Tops sponso
          </span>
        </a>
      </li>
      <li class="nav-item">
        <a class="d-flex align-items-center" href="<?php the_permalink(get_page_by_path('tas')); ?>/">
          <span class="ico">
            <span class="va va-four-leaf-clover va-lg"></span>
          </span>
          <span class="menu-title text-truncate">
            Tirages au sort
          </span>
        </a>
      </li>
      <li class="nav-item">
        <a class="d-flex align-items-center" href="<?php the_permalink(get_page_by_path('shop')); ?>/">
          <span class="ico">
            <span class="va va-shopping va-lg"></span>
          </span>
          <span class="menu-title text-truncate">
            Shop
          </span>
        </a>
      </li>
      <li class="navigation-header">
        <span>VAINKEURZ</span> <i data-feather="more-horizontal"></i>
      </li>
      <li class="nav-item has-sub">
        <a class="d-flex align-items-center" href="#">
          <span class="ico">
            <span class="va va-exploding-head va-lg"></span>
          </span>
          <span class="menu-title text-truncate">
            Best Of
          </span>
        </a>
        <ul class="menu-content">
          <li>
            <a class="d-flex align-items-center" href="<?php the_permalink(get_page_by_path('best-of/best-vainkeurs')); ?>">
              <span class="ico">
                <span class="va va-crown va-lg"></span>
              </span>
              <span class="menu-title text-truncate">
                Vainkeurs
              </span>
            </a>
          </li>
          <li>
            <a class="d-flex align-items-center" href="<?php the_permalink(get_page_by_path('best-of/best-tops')); ?>">
              <span class="ico">
                <span class="va va-trophy va-lg"></span>
              </span>
              <span class="menu-title text-truncate">
                Tops
              </span>
            </a>
          </li>
          <li>
            <a class="d-flex align-items-center" href="<?php the_permalink(get_page_by_path('best-of/best-createurs')); ?>">
              <span class="ico">
                <span class="va va-man-singer  va-lg"></span>
              </span>
              <span class="menu-title text-truncate">
                Créateurs
              </span>
            </a>
          </li>
        </ul>
      </li>
      <li class="nav-item">
        <a class="d-flex align-items-center" href="<?php the_permalink(get_page_by_path('monitor')); ?>">
          <span class="ico">
            <span class="va va-satellite-antenna va-lg"></span>
          </span>
          <span class="menu-title text-truncate">
            Monitor
          </span>
        </a>
      </li>
      <li class="nav-item">
        <a class="d-flex align-items-center" href="<?php the_permalink(get_page_by_path('recrutement')); ?>/">
          <span class="ico">
            <span class="va va-man-singer va-lg"></span>
          </span>
          <span class="menu-title text-truncate">
            Créer des Tops
          </span>
        </a>
      </li>
      <li class="nav-item">
        <a class="d-flex align-items-center" href="<?php the_permalink(get_page_by_path('evolution')); ?>">
          <span class="ico">
            <span class="va va-rocket va-lg"></span>
          </span>
          <span class="menu-title text-truncate">
            Les niveaux
          </span>
        </a>
      </li>
      <li class="nav-item">
        <a class="d-flex align-items-center" href="<?php the_permalink(get_page_by_path('trophees')); ?>">
          <span class="ico">
            <span class="va va-sports-medal va-lg"></span>
          </span>
          <span class="menu-title text-truncate">
            Les trophées
          </span>
        </a>
      </li>
      <li class="nav-item">
        <a class="d-flex align-items-center" href="<?php the_permalink(104853); ?>">
          <span class="ico">
            <span class="va va-llama va-lg"></span>
          </span>
          <span class="menu-title text-truncate">
            A propos
          </span>
        </a>
      </li>
      <li class="nav-item">
        <a class="d-flex align-items-center" href="<?php the_permalink(get_page_by_path('blog')); ?>">
          <span class="ico">
            <span class="va va-sun va-lg"></span>
          </span>
          <span class="menu-title text-truncate">
            Blog
          </span>
        </a>
      </li>
    </ul>
  </div>
</div>
<!-- END: Main Menu-->