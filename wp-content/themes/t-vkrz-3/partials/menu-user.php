<?php
global $user_infos;
global $cat_name;
if (is_single() && get_post_type() == "tournoi") {
  global $top_infos;
  global $id_top;
  global $id_ranking;
} elseif (is_single() && get_post_type() == "classement") {
  global $top_infos;
  $id_top = get_field('id_tournoi_r');
} elseif (is_author()) {
  global $vainkeur_info;
}
?>
<nav class="header-navbar navbar navbar-expand-lg align-items-center floating-nav navbar-dark navbar-shadow menu-user">
  <div class="navbar-container d-flex content align-items-center justify-content-between">

    <?php if (is_home()) : ?>
      <div class="menu-logo d-flex align-items-center d-xl-none">
        <div class="d-block d-sm-none">
          <a href="<?php bloginfo('url'); ?>/">
            <img src="<?php bloginfo('template_directory'); ?>/assets/images/vkrz/logo-vkrz.png" alt="VAINKEURZ logo" class="logo img-fluid">
          </a>
        </div>

        <ul class="nav navbar-nav d-xl-none">
          <li class="nav-item">
            <a class="nav-link menu-toggle" href="javascript:void(0);">
              <i class="ficon" data-feather="menu"></i>
            </a>
          </li>
        </ul>
      </div>
    <?php endif; ?>

    <?php if (!is_home()) : ?>
      <div class="navquick d-flex align-items-center">
        <div class="menu-logo d-flex align-items-center d-xl-none">
          <div class="d-block d-sm-none">
            <a href="<?php bloginfo('url'); ?>/">
              <img src="<?php bloginfo('template_directory'); ?>/assets/images/vkrz/logo-vkrz.png" alt="VAINKEURZ logo" class="logo img-fluid">
            </a>
          </div>

          <ul class="nav navbar-nav d-xl-none">
            <li class="nav-item">
              <a class="nav-link menu-toggle" href="javascript:void(0);">
                <i class="ficon" data-feather="menu"></i>
              </a>
            </li>
          </ul>
        </div>
        <div class="content-header row">
          <div class="content-header-left col-12">
            <div class="row breadcrumbs-top">
              <div class="col-12">
                <div class="breadcrumb-wrapper">
                  <ol class="breadcrumb">

                    <li class="breadcrumb-item">
                      <a href="<?php bloginfo('url'); ?>/">
                        <span class="va va-house va-lg"></span>
                      </a>
                    </li>

                    <?php if ((is_single() && get_post_type() == "tournoi") || (is_single() && get_post_type() == "classement")) : ?>

                      <li class="breadcrumb-item">
                        <?php
                        if ($id_top) {
                          foreach (get_the_terms($id_top, 'categorie') as $cat) {
                            $cat_id     = $cat->term_id;
                            $cat_name   = $cat->name;
                          }
                        }

                        ?>
                        <a href="<?php echo get_category_link($cat_id); ?>">
                          <span class="ico">
                            <?php the_field('icone_cat', 'term_' . $cat_id); ?>
                          </span>
                          <span class="menu-title text-truncate">
                            <?php echo $cat_name; ?>
                          </span>
                        </a>
                      </li>

                    <?php elseif (!is_author() && is_archive()) : ?>

                      <?php
                      if (is_archive()) {
                        global $current_cat;
                        global $cat_name;
                        global $cat_id;
                      }
                      ?>
                      <li class="breadcrumb-item">
                        <a href="<?php echo get_category_link($cat_id); ?>">
                          <?php the_field('icone_cat', 'term_' . $cat_id); ?> <span class="menu-title text-truncate"><?php echo $cat_name; ?></span>
                        </a>
                      </li>
                    <?php elseif (is_page(get_page_by_path('tops-sponso'))) : ?>

                      <li class="breadcrumb-item">
                        <a href="<?php the_permalink(get_page_by_path('tops-sponso')); ?>">
                          <span class="ico va va-wrapped-gift va-lg"></span> <span class="menu-title text-truncate">Tops sponso</span>
                        </a>
                      </li>

                    <?php elseif (is_page(get_page_by_path('elo'))) : ?>

                      <?php global $id_top; ?>

                      <li class="breadcrumb-item">
                        <?php
                        foreach (get_the_terms($id_top, 'categorie') as $cat) {
                          $cat_id     = $cat->term_id;
                          $cat_name   = $cat->name;
                        }
                        ?>
                        <a href="<?php echo get_category_link($cat_id); ?>">
                          <span class="ico"><?php the_field('icone_cat', 'term_' . $cat_id); ?></span> <span class="menu-title text-truncate"><?php echo $cat_name; ?></span>
                        </a>
                      </li>
                      <li class="breadcrumb-item">
                        <a href="<?php the_permalink($id_top); ?>">
                          <span class="menu-title text-truncate">
                            <?php echo get_the_title($id_top); ?>
                          </span>
                        </a>
                      </li>

                    <?php elseif (is_page(get_page_by_path('liste-des-tops'))) : ?>

                      <?php global $id_top; ?>

                      <li class="breadcrumb-item">
                        <?php
                        if (get_the_terms($id_top, 'categorie')) {
                          foreach (get_the_terms($id_top, 'categorie') as $cat) {
                            $cat_id     = $cat->term_id;
                            $cat_name   = $cat->name;
                          }
                        }
                        ?>
                        <a href="<?php echo get_category_link($cat_id); ?>">
                          <span class="ico"><?php the_field('icone_cat', 'term_' . $cat_id); ?></span> <span class="menu-title text-truncate"><?php echo $cat_name; ?></span>
                        </a>
                      </li>
                      <li class="breadcrumb-item">
                        <a href="<?php the_permalink($id_top); ?>">
                          <span class="menu-title text-truncate">
                            <?php echo get_the_title($id_top); ?>
                          </span>
                        </a>
                      </li>

                    <?php endif; ?>
                  </ol>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    <?php endif; ?>

    <div class="bookmark-wrapper d-flex align-items-baseline">

      <?php if (is_home()) : ?>

        <h3 class="mb-0 animate__animated animate__slideInLeft"><span class="va va-vulcan-salute va-1x"></span> Bienvenue</h3>
        <h4 class="mb-0 kick animate__animated animate__slideInRight" data-kick="Commence par choisir un Top qui t'intéresse et enchaîne les votes <span class='va va-backhand-index-pointing-down va-1x'></span>">Tu vas pouvoir générer et revendiquer tes propres classements !</h4>

      <?php elseif (is_single() && (get_post_type() == "tournoi")) : ?>

        <?php if ($id_ranking) : ?>
          <div class="tournament-heading text-center">
            <h3 class="mb-0 t-titre-tournoi">Top <?php echo $top_infos['top_number']; ?> <span class="ico va va-high-voltage va va-lg"></span> <?php echo $top_infos['top_title']; ?></h3>
            <h4 class="mb-0 t-rose t-max">
              <?php echo $top_infos['top_question']; ?>
            </h4>
          </div>
        <?php else : ?>
          <div class="tournament-heading text-center">
            <h3 class="mb-0 t-titre-tournoi">Introduction</h3>
          </div>
        <?php endif; ?>

      <?php elseif (is_single() && (get_post_type() == "classement")) : ?>

        <div class="tournament-heading text-center">
          <h3 class="mb-0 t-titre-tournoi">
            Top <?php echo $top_infos['top_number']; ?> <span class="ico text-center va va-trophy va-lg"></span> <?php echo $top_infos['top_title']; ?>
          </h3>
          <h4 class="mb-0">
            <?php echo $top_infos['top_question']; ?>
          </h4>
        </div>

      <?php elseif (is_page(get_page_by_path('elo'))) : ?>

        <?php $id_top = $_GET['id_top']; ?>
        <div class="tournament-heading text-center">
          <h3 class="mb-0 t-titre-tournoi">Top <?php echo get_field('count_contenders_t', $id_top); ?> mondial <span class="ico text-center va va-globe va-lg"></span> <?php echo get_the_title($id_top); ?></h3>
          <h4 class="mb-0">
            <?php the_field('question_t', $id_top); ?>
          </h4>
        </div>

      <?php elseif (is_page(get_page_by_path('shop'))) : ?>

        <div class="tournament-heading text-center">
          <h3 class="mb-0 t-titre-tournoi"><span class="va va-shopping va-lg"></span> Ici, c'est Shopping !</h3>
          <h4 class="mb-0">
            Achète tout ce que tu veux - enfin tout ce que tu peux <span class="va va-cheese2 va-z-20"></span>
          </h4>
        </div>

      <?php elseif (is_page(get_page_by_path('liste-des-tops'))) : ?>

        <?php $id_top = $_GET['id_top']; ?>
        <div class="tournament-heading text-center">
          <h3 class="mb-0 t-titre-tournoi">Liste des Tops <span class="ico text-center va va-trophy va-lg"></span> <?php echo get_the_title($id_top); ?></h3>
          <h4 class="mb-0">
            <?php the_field('question_t', $id_top); ?>
          </h4>
        </div>

      <?php elseif (!is_author() && is_archive()) : ?>

        <div class="tournament-heading text-center">
          <h3 class="mb-0 t-titre-tournoi"><?php the_field('icone_cat', 'term_' . $cat_id); ?> <?php echo $cat_name; ?></h3>
          <h4 class="mb-0"><?php echo $current_cat->description; ?></h4>
        </div>

      <?php elseif (is_page(get_page_by_path('tops-sponso'))) : ?>

        <div class="tournament-heading text-center">
          <h3 class="mb-0 t-titre-tournoi"><span class="ico va va-wrapped-gift va-lg"></span> Tops sponso</h3>
          <h4 class="mb-0">Plein de choses à gagner par ici</h4>
        </div>

      <?php elseif (is_page(get_page_by_path('mon-compte'))) : ?>


      <?php elseif (is_page(get_page_by_path('rechercher'))) : ?>

        <?php
        if (isset($_POST['term']) && $_POST['term'] != "") {
          $term_to_search = $_POST['term'];
        }
        global $total_top_founded;
        global $searching_for_a_vainkeur;
        ?>

        <div class="tournament-heading text-center">
          <h3 class="mb-0 t-titre-tournoi">Recherche : <?php echo $term_to_search; ?></h3>
          <?php if ($total_top_founded > 0) : ?>
            <h4 class="mb-0"><?php echo $total_top_founded; ?> tops trouvés</h4>
          <?php elseif ($searching_for_a_vainkeur) : ?>
            <h4 class="mb-0">Vainkeur trouvé!</h4>
          <?php else : ?>
            <h4 class="mb-0">aucuns tops trouvés 😐</h4>
          <?php endif; ?>
        </div>

      <?php elseif (is_page(get_page_by_path('paris-manga-2022'))) : ?>

        <div class="tournament-heading text-center">
          <h3 class="mb-0 t-titre-tournoi"><span class="ico va va-wrapped-gift va-lg"></span> TOPS Paris Manga 2022</h3>
          <h4 class="mb-0">Plein de choses à gagner par ici 🤗</h4>
        </div>

      <?php elseif (is_page(get_page_by_path('tous-les-sujets'))) : ?>

        <div class="tournament-heading text-center">
          <h3 class="mb-0 t-titre-tournoi"><span class="ico va va-package va-lg"></span> Tous les sujets</h3>
          <h4 class="mb-0">que tu retrouves sur VAINKEURZ</h4>
        </div>

      <?php elseif (is_author()) : ?>

        <div class="tournament-heading text-center">
          <h3 class="mb-0 t-titre-tournoi">
            Profil de <?php echo $vainkeur_info['pseudo']; ?> <?php echo $vainkeur_info['level']; ?>
          </h3>
        </div>

      <?php endif; ?>
    </div>

    <ul class="nav navbar-nav align-items-center justify-content-around">
      <li class="nav-item dropdown dropdown-cart mt-3px">
        <a class="nav-link d-flex flex-column align-items-center" href="javascript:void(0);" data-toggle="dropdown">
          <span class="ico text-center va-gem va va-lg"></span>
          <span class="value-user-stats user-total-vote-value">
            <?php if ($user_infos['current_money_vkrz']) : ?>
              <?php echo $user_infos['current_money_vkrz']; ?>
            <?php else : ?>
              0
            <?php endif; ?>
          </span>
        </a>
        <ul class="dropdown-menu dropdown-menu-media dropdown-menu-right">
          <li class="dropdown-menu-header">
            <div class="dropdown-header d-flex">
              <h4 class="notification-title mb-0 mr-auto">
                <span class="va-gem va va-lg"></span> <?php echo $user_infos['current_money_vkrz']; ?>
              </h4>
              <div class="badge badge-pill badge-light-primary">
                Solde de KEURZ disponible
              </div>
            </div>
          </li>
          <li class="dropdown-menu-footer">
            <div class="text-center mb-2">
              <h6 class="font-weight-bolder mb-0">
                <?php if (is_user_logged_in()) : ?>
                  Profite du Shop pour dépenser tes KEURZ
                <?php else : ?>
                  Il te faut un compte commander dans le shop
                <?php endif; ?>
              </h6>
            </div>
            <?php if (is_user_logged_in()) : ?>
              <div class="row">
                <div class="col-sm-6">
                  <a class="btn btn-outline-primary btn-block" href="<?php the_permalink(get_page_by_path('mon-compte/keurz')); ?>">
                    Détail des KEURZ
                  </a>
                </div>
                <div class="col-sm-6">
                  <a class="btn btn-primary btn-block" href="<?php the_permalink(get_page_by_path('shop')); ?>">
                    Aller dans le shop
                  </a>
                </div>
              </div>
            <?php else : ?>
              <div class="row">
                <div class="col-sm-6">
                  <a class="btn btn-outline-primary btn-block" href="<?php the_permalink(305107); ?>">
                    Détail des KEURZ
                  </a>
                </div>
                <div class="col-sm-6">
                  <a class="btn btn-primary btn-block" href="<?php the_permalink(get_page_by_path('creer-mon-compte')); ?>">
                    Créer mon compte
                  </a>
                </div>
              </div>
            <?php endif; ?>
          </li>
        </ul>
      </li>
      <li class="nav-item mr-25">
        <a class="nav-link d-flex flex-column align-items-center" href="<?php the_permalink(get_page_by_path('mon-compte')); ?>">
          <span class="ico text-center va va-trophy va-lg"></span>
          <span class="value-user-stats">
            <?php echo $user_infos['nb_top_vkrz']; ?>
          </span>
        </a>
      </li>
      <li class="nav-item dropdown dropdown-user ml-25">
        <a class="nav-link dropdown-toggle dropdown-user-link" id="dropdown-user" href="javascript:void(0);" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <span class="avatar">
            <span class="avatar-picture" style="background-image: url(<?php echo $user_infos['avatar']; ?>);"></span>
            <span class="user-niveau">
              <?php echo $user_infos['level']; ?>
            </span>
          </span>
        </a>
        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdown-user">
          <?php if (is_user_logged_in()) : ?>
            <a class="dropdown-item" href="<?php the_permalink(get_page_by_path('mon-compte')); ?>">
              <div class="progress-wrapper">
                <?php
                $nb_need_money       = get_vote_to_next_level($user_infos['level_number'], $user_infos['money_vkrz']);
                $money_to_next_level = $nb_need_money + $user_infos['money_vkrz'];
                $percent_progression = round($user_infos['money_vkrz'] * 100 / $money_to_next_level);
                ?>
                <div id="example-caption-5">Encore <span class="decompte_vote"><?php echo $nb_need_money; ?></span> <span class="ico text-center va va-gem va-z-15"></span> pour <?php echo $user_infos['next_level']; ?></div>
                <div class="progress progress-bar-primary w-100" style="height: 6px; margin-top: 5px;">
                  <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="<?php echo $percent_progression; ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $percent_progression; ?>%"></div>
                </div>
              </div>
            </a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="<?php the_permalink(get_page_by_path('mon-compte')); ?>">
              Mon compte
            </a>
            <a class="dropdown-item" href="<?php the_permalink(305107); ?>">
              Mes KEURZ <span class="ico va va-gem va-lg"></span>
            </a>
            <a class="dropdown-item" href="<?php the_permalink(get_page_by_path('parametres')); ?>">
              Paramètres
            </a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="<?php the_permalink(get_page_by_path('deconnexion')); ?>">
              <span class="ico va va-waving-hand va-lg"></span> Déconnexion
            </a>
          <?php else : ?>
            <a class="dropdown-item" href="<?php the_permalink(get_page_by_path('mon-compte')); ?>">
              Mon compte
            </a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="<?php the_permalink(get_page_by_path('se-connecter')); ?>">
              <span class="ico va va-call-me-hand va-lg"></span> Me connecter
            </a>
            <a class="dropdown-item" href="<?php the_permalink(get_page_by_path('creer-mon-compte')); ?>">
              <span class="ico va va-party-pooper va-lg">🎉</span> M'inscrire
            </a>
          <?php endif; ?>

        </div>
      </li>
    </ul>

  </div>
</nav>
<!-- END: Header-->