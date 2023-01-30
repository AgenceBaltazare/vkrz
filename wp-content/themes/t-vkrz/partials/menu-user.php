<?php
global $infos_vainkeur;
global $cat_name;
global $term_to_search;
global $total_top_founded;
global $searching_for_a_vainkeur;
if (is_single() && get_post_type() == "tournoi") {
  global $top_infos;
  global $id_top;
  global $id_ranking;
} elseif (is_single() && get_post_type() == "classement") {
  global $top_infos;
  $id_top = get_field('id_tournoi_r');
} elseif (is_author() || is_page(218587)) {
  global $infos_vainkeur_to_watch;
}
?>
<div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none">
  <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
    <i class="ti ti-menu-2 ti-sm"></i>
  </a>
</div>

<div class="navbar-nav-right d-flex align-items-center justify-content-between" id="navbar-collapse">

  <!-- Réseaux -->
  <div class="reseauxicons">
    <ul>
      <li class="menu-item d-none d-sm-block">
        <div class="rs-menu justify-content-center share-t" role="group">
          <a data-rs-name="discord" href="https://discord.gg/E9H9e8NYp7" class="btn rounded-pill btn-icon btn-outline-primary waves-effect" target="_blank">
            <i class="fab fa-discord"></i>
          </a>
          <a data-rs-name="instagram" href="https://www.instagram.com/wearevainkeurz/" class="btn rounded-pill btn-icon btn-outline-primary waves-effect" target="_blank" spellcheck="false">
            <i class="fab fa-instagram"></i>
          </a>
          <a data-rs-name="twitter" href="https://twitter.com/Vainkeurz" target="_blank" class="btn rounded-pill btn-icon btn-outline-primary waves-effect">
            <i class="fab fa-twitter"></i>
          </a>
          <a data-rs-name="tiktok" href="https://www.tiktok.com/@vainkeurz" target="_blank" class="btn rounded-pill btn-icon btn-outline-primary waves-effect" spellcheck="false">
            <i class="fab fa-tiktok"></i>
          </a>
        </div>
      </li>
    </ul>
  </div>

  <div class="search">
    <form action="<?php the_permalink(435459); ?>" method="GET">
      <div class="search-group">
        <div class="select-search">
          <select class="selectpicker" name="typesearch" id="typesearch">
            <option>Tops</option>
            <option>Membres</option>
          </select>
        </div>
        <div class="input-search">
          <input id="searchmembres" name="member_to_search" type="text" class="form-control typeahead-prefetch" autocomplete="off" placeholder="Recherche un vainkeur...">
          <input id="searchtops" name="term_to_search" type="text" class="form-control typeahead-prefetch" autocomplete="off" placeholder="Recherche des Tops...">
        </div>
        <div class="btn-loupe">
          <button class="submitbtn" type="submit">
            <span class="va va-eyes va-md"></span>
          </button>
        </div>
      </div>
    </form>
  </div>

  <div class="menu-user-div">
    <ul class="navbar-nav flex-row align-items-center ms-auto">
      <!-- Search -->
      <li class="nav-item navbar-search-wrapper me-2 me-xl-0 d-block d-sm-none">
        <a class="nav-link search-toggler" href="javascript:void(0);">
          <span class="va va-loupe va-lg"></span>
        </a>
      </li>

      <!-- /Search -->

      <!-- Statisques  -->
      <li class="nav-item dropdown-shortcuts navbar-dropdown dropdown me-2 me-xl-0">
        <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false">
          <?php if ($infos_vainkeur) : ?>
            <?php echo $infos_vainkeur['level']; ?>
          <?php endif; ?>
        </a>
        <div class="dropdown-menu dropdown-menu-end py-0">
          <div class="dropdown-menu-header border-bottom">
            <div class="dropdown-header d-flex align-items-center py-3">
              <h5 class="text-body mb-0 me-auto">Statisques</h5>
              <a href="javascript:void(0)" class="dropdown-shortcuts-add text-body" data-bs-toggle="tooltip" data-bs-placement="top" title="Add shortcuts">
                <?php echo $infos_vainkeur['level']; ?>
              </a>
            </div>
          </div>
          <div class="dropdown-shortcuts-list scrollable-container">
            <div class="row row-bordered overflow-visible g-0">
              <div class="dropdown-shortcuts-item col">
                <a class="stretched-link" href="<?php the_permalink(get_page_by_path('mon-compte')); ?>">
                  <div class="progress-wrapper progressionniveau">
                    <?php
                    $nb_need_money       = get_vote_to_next_level($infos_vainkeur['level_number'], $infos_vainkeur['money_vkrz']);
                    $money_to_next_level = $nb_need_money + $infos_vainkeur['money_vkrz'];
                    $percent_progression = round($infos_vainkeur['money_vkrz'] * 100 / $money_to_next_level);
                    ?>
                    <div id="example-caption-5">Encore <span class="decompte_vote"><?php echo $nb_need_money; ?></span> <span class="ico text-center va va-mush va-z-15"></span> pour passer <?php echo $infos_vainkeur['next_level']; ?></div>
                    <div class="progress progress-bar-primary w-100" style="height: 6px; margin-top: 5px;">
                      <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="<?php echo $percent_progression; ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $percent_progression; ?>%"></div>
                    </div>
                  </div>
                </a>
              </div>
            </div>
            <div class="row row-bordered overflow-visible g-0">
              <div class="dropdown-shortcuts-item col">
                <a href="<?php the_permalink(get_page_by_path('mon-compte')); ?>" class="stretched-link">
                  <div class="itemstat">
                    <div>
                      <span class="iconstats va-mush va va-lg"></span>
                    </div>
                    <div class="valuestat">
                      <?php if ($infos_vainkeur['money_vkrz']) : ?>
                        <?php echo $infos_vainkeur['money_vkrz']; ?>
                      <?php else : ?>
                        0
                      <?php endif; ?>
                      <small class="text-muted mb-0">XP</small>
                    </div>
                  </div>
                </a>
              </div>
              <div class="dropdown-shortcuts-item col">
                <a href="<?php the_permalink(get_page_by_path('mon-compte/keurz')); ?>" class="stretched-link">
                  <div class="itemstat">
                    <div>
                      <span class="iconstats va-gem va va-lg"></span>
                    </div>
                    <div class="valuestat">
                      <?php if ($infos_vainkeur['current_money_vkrz']) : ?>
                        <?php echo $infos_vainkeur['current_money_vkrz']; ?>
                      <?php else : ?>
                        0
                      <?php endif; ?>
                      <small class="text-muted mb-0">KEURZ</small>
                    </div>
                  </div>
                </a>
              </div>
            </div>
            <div class="row row-bordered overflow-visible g-0">
              <div class="dropdown-shortcuts-item col">
                <a href="<?php the_permalink(get_page_by_path('mon-compte')); ?>" class="stretched-link">
                  <div class="itemstat">
                    <div>
                      <span class="iconstats va-trophy va va-lg"></span>
                    </div>
                    <div class="valuestat">
                      <?php echo $infos_vainkeur['nb_top_vkrz']; ?>
                      <small class="text-muted mb-0">TopList</small>
                    </div>
                  </div>
                </a>
              </div>
              <div class="dropdown-shortcuts-item col">
                <a href="<?php the_permalink(get_page_by_path('mon-compte')); ?>" class="stretched-link">
                  <div class="itemstat">
                    <div>
                      <span class="iconstats va-high-voltage va va-lg"></span>
                    </div>
                    <div class="valuestat">
                      <?php echo $infos_vainkeur['nb_vote_vkrz']; ?>
                      <small class="text-muted mb-0">votes</small>
                    </div>
                  </div>
                </a>
              </div>
            </div>
            <div class="row row-bordered overflow-visible g-0">
              <div class="dropdown-shortcuts-item col">
                <a href="<?php the_permalink(get_page_by_path('mon-compte/guetteur')); ?>" class="stretched-link">
                  <div class="itemstat">
                    <div>
                      <span class="iconstats va-guetteur va va-lg"></span>
                    </div>
                    <div class="valuestat">
                      <span class="followers-account-nbr"></span>
                      <small class="text-muted mb-0 followers-account-nbr-text">Guetteurs</small>
                    </div>
                  </div>
                </a>
              </div>
              <div class="dropdown-shortcuts-item col">
                <a href="<?php the_permalink(get_page_by_path('mon-compte/parrainage')); ?>" class="stretched-link">
                  <div class="itemstat">
                    <div>
                      <span class="iconstats va-love-people  va va-lg"></span>
                    </div>
                    <div class="valuestat">
                      0
                      <small class="text-muted mb-0">Parrainage</small>
                    </div>
                  </div>
                </a>
              </div>
            </div>
          </div>
        </div>
      </li>
      <!-- Statisques -->

      <?php if (is_user_logged_in()) : ?>

        <!-- Notification -->
        <li class="nav-item dropdown-notifications navbar-dropdown dropdown me-3 me-xl-1">
          <a class="menuuser-bell nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false">
            <span class="va va-z-20 va va-bell"></span>
            <!--<span class="badge bg-danger rounded-pill badge-notifications notifications-nombre"></span>-->
          </a>
          <ul class="dropdown-menu dropdown-menu-end py-0">
            <li class="dropdown-menu-header border-bottom">
              <div class="dropdown-header d-flex align-items-center py-3">
                <h5 class="text-body mb-0 me-auto">Notifications</h5>
                <div class="badge rounded-pill bg-label-primary">
                  <span class="notifications-nombre"></span>
                  <span class="notifications-span"></span>
                </div>
              </div>
            </li>
            <li class="dropdown-notifications-list scrollable-container">
              <ul class="list-group list-group-flush">
                <li class="scrollable-container media-list notifications-container">
                </li>
              </ul>
            </li>
            <li class="dropdown-menu-footer border-top">
              <a href="<?php the_permalink(get_page_by_path('mon-compte/notifications')); ?>" class="dropdown-item d-flex justify-content-center text-primary p-2 h-px-40 mb-1 align-items-center">
                Voir toutes les notifications
              </a>
            </li>
          </ul>
        </li>
        <!--/ Notification -->

        <!-- User -->
        <li class="nav-item navbar-dropdown dropdown-user dropdown me-xl-1">
          <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown">
            <div class="avatar avatar-online">
              <img src="<?php echo $infos_vainkeur['avatar']; ?>" alt class="h-auto rounded-circle" />
            </div>
          </a>
          <ul class="dropdown-menu dropdown-menu-end">
            <a class="dropdown-item" href="<?php the_permalink(get_page_by_path('mon-compte')); ?>">
              Mon compte
            </a>
            <a class="dropdown-item" href="<?php the_permalink(305107); ?>">
              Mes KEURZ <span class="ico va va-gem va-lg"></span>
            </a>
            <a class="dropdown-item" href="<?php the_permalink(27794); ?>">
              Paramètres
            </a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="<?php the_permalink(get_page_by_path('deconnexion')); ?>">
              Déconnexion <span class="ico va va-waving-hand va-lg"></span>
            </a>
          </ul>
        </li>
        <!--/ User -->
      <?php else : ?>
        <!-- Connexion / Inscription -->
        <li class="nav-item me-2 ms-1">
          <a class="nav-link btn btn-rose waves-effect waves-light" href="<?php the_permalink(get_page_by_path('se-connecter')); ?>">
            Connexion / Inscription
          </a>
        </li>
        <!-- Connexion / Inscription -->
      <?php endif; ?>

      <!-- Proposer Top -->
      <li class="nav-item ms-2 d-none d-sm-block">
        <a class="nav-link btn btn-primary waves-effect waves-light propose" href="<?php the_permalink(get_page_by_path(('proposition-de-tops'))); ?>">
          Propose tes Tops
        </a>
      </li>
      <!--/ Proposer Top -->
    </ul>
  </div>
</div>

<!-- Search Small Screens -->
<div class="navbar-search-wrapper search-input-wrapper container-xxl d-none">
  <input type="text" class="form-control search-input border-0" placeholder="Search..." aria-label="Search..." />
  <i class="ti ti-x ti-sm search-toggler cursor-pointer"></i>
</div>