<aside id="layout-menu" class="layout-menu-horizontal menu-horizontal menu bg-menu-theme flex-grow-0">
  <div class="container-xxl d-flex h-100">
    <ul class="menu-inner">
      <!-- Catégories de Tops -->
      <li class="menu-item">
        <a href="javascript:void(0)" class="menu-link menu-toggle">
          <div class="iconmenu">
            <span class="va va-trophy va-lg"></span>
          </div>
          <div>Catégories de Tops</div>
        </a>
        <ul class="menu-sub">
          <?php
          $cat_t = get_terms(array(
            'taxonomy'      => 'categorie',
            'orderby'       => 'count',
            'order'         => 'DESC',
            'hide_empty'    => false
          ));
          foreach ($cat_t as $cat) : ?>
            <li class="menu-item">
              <a href="<?php echo get_category_link($cat->term_id); ?>" class="menu-link">
                <span class="iconmenu">
                  <?php the_field('icone_cat', 'term_' . $cat->term_id); ?>
                </span>
                <div>
                  <?php echo $cat->name; ?>
                </div>
              </a>
            </li>
          <?php endforeach; ?>
        </ul>
      </li>
      <!-- Des lots à gagner -->
      <li class="menu-item">
        <a href="javascript:void(0)" class="menu-link menu-toggle">
          <div class="iconmenu">
            <span class="va va-wrapped-gift va-lg"></span>
          </div>
          <div>Lots à gagner</div>
        </a>
        <ul class="menu-sub">
          <li class="menu-item">
            <a href="<?php the_permalink(get_page_by_path('tops-sponso')); ?>" class="menu-link">
              <span class="iconmenu">
                <span class="va va-four-leaf-clover va-lg"></span>
              </span>
              <div>
                Concours du moment
              </div>
            </a>
          </li>
          <li class="menu-item">
            <a href="<?php the_permalink(get_page_by_path('tas')); ?>" class="menu-link">
              <span class="iconmenu">
                <span class="va va-calendar va-lg"></span>
              </span>
              <div>
                Date des tirages
              </div>
            </a>
          </li>
        </ul>
      </li>
      <!-- Best OF -->
      <li class="menu-item">
        <a href="javascript:void(0)" class="menu-link menu-toggle">
          <div class="iconmenu">
            <span class="va va-exploding-head va-lg"></span>
          </div>
          <div>Best Of</div>
        </a>
        <ul class="menu-sub">
          <li class="menu-item">
            <a href="<?php the_permalink(get_page_by_path('best-of/best-tops')); ?>" class="menu-link">
              <span class="iconmenu">
                <span class="va va-trophy va-lg"></span>
              </span>
              <div>
                Tops popuplaires
              </div>
            </a>
          </li>
          <li class="menu-item">
            <a href="<?php the_permalink(get_page_by_path('best-of/best-vainkeurs')); ?>" class="menu-link">
              <span class="iconmenu">
                <span class="va va-crown va-lg"></span>
              </span>
              <div>
                Vainkeurs les + déters
              </div>
            </a>
          </li>
          <li class="menu-item">
            <a href="<?php the_permalink(get_page_by_path('best-of/best-createurs')); ?>" class="menu-link">
              <span class="iconmenu">
                <span class="va va-man-singer va-lg"></span>
              </span>
              <div>
                Rang des créateurs
              </div>
            </a>
          </li>
        </ul>
      </li>
      <!-- Communauté -->
      <li class="menu-item">
        <a href="<?php the_permalink(get_page_by_path('communaute')); ?>" class="menu-link">
          <div class="iconmenu">
            <span class="va va-smiling-face-with-heart-eyes va-lg"></span>
          </div>
          <div>Communauté</div>
        </a>
      </li>
      <!-- VAINKEURZ -->
      <li class="menu-item">
        <a href="javascript:void(0)" class="menu-link menu-toggle">
          <div class="iconmenu">
            <span class="va va-lama va-lg"></span>
          </div>
          <div>VAINKEURZ</div>
        </a>
        <ul class="menu-sub">
          <li class="menu-item">
            <a href="<?php the_permalink(get_page_by_path('a-propos')); ?>" class="menu-link">
              <span class="iconmenu">
                <span class="va va-monocle va-lg"></span>
              </span>
              <div>
                A propos
              </div>
            </a>
          </li>
          <li class="menu-item">
            <a href="<?php the_permalink(get_page_by_path('blog')); ?>" class="menu-link">
              <span class="iconmenu">
                <span class="va va-sun va-lg"></span>
              </span>
              <div>
                Blog
              </div>
            </a>
          </li>
          <li class="menu-item">
            <a href="<?php the_permalink(get_page_by_path('evolution')); ?>" class="menu-link">
              <span class="iconmenu">
                <span class="va va-rocket va-lg"></span>
              </span>
              <div>
                Les niveaux
              </div>
            </a>
          </li>
          <li class="menu-item">
            <a href="<?php the_permalink(get_page_by_path('trophees')); ?>" class="menu-link">
              <span class="iconmenu">
                <span class="va va-sports-medal va-lg"></span>
              </span>
              <div>
                Les trophées
              </div>
            </a>
          </li>
        </ul>
      </li>
      <li class="menu-item">
        <a href="<?php the_permalink(get_page_by_path('shop')); ?>" class="menu-link">
          <div class="iconmenu">
            <span class="va va-gem va-lg"></span>
          </div>
          <div>Récompenses</div>
        </a>
      </li>
      <li class="menu-item">
        <a href="<?php the_permalink(get_page_by_path('monitor')); ?>" class="menu-link">
          <div class="iconmenu">
            <span class="va va-satellite-antenna va-lg"></span>
          </div>
          <div>Monitor</div>
        </a>
      </li>
    </ul>
  </div>
</aside>