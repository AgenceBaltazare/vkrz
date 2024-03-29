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

                    <?php elseif (is_page(get_page_by_path('blog'))) : ?>

                      <li class="breadcrumb-item">
                        <a href="<?php the_permalink(get_page_by_path('blog')); ?>" title="Blog">
                          <span class="ico"><span class="va va-sun va-lg"></span></span>
                          <span class="menu-title text-truncate">Blog</span>
                        </a>
                      </li>

                    <?php elseif (is_archive() && !is_tax() && !is_author() && !is_page(218587)) : ?>

                      <?php
                      if (is_archive()) {
                        global $current_cat;
                        global $cat_name;
                        global $cat_id;
                      }
                      ?>
                      <li class="breadcrumb-item">
                        <a href="<?php the_permalink(get_page_by_path('blog')); ?>" title="Blog">
                          <span class="ico"><span class="va va-sun va-lg"></span></span>
                        </a>
                      </li>
                      <li class="breadcrumb-item active">
                        <span class="menu-title text-truncate"><?php echo $cat_name; ?></span>
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

                    <?php elseif (is_single() && (get_post_type() === "post")) : ?>

                      <li class="breadcrumb-item">
                        <a href="<?php the_permalink(get_page_by_path('blog')); ?>" title="Blog">
                          <span class="ico"><span class="va va-sun va-lg"></span></span>
                          <span class="menu-title text-truncate">Blog</span>
                        </a>
                      </li>
                      <li class="breadcrumb-item active">
                        <span class="menu-title text-truncate"><?php the_title(); ?></span>
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
        <h4 class="mb-0 kick animate__animated animate__slideInRight" data-kick="Commence par choisir un Top qui t'intéresse et enchaîne les votes <span class='va va-backhand-index-pointing-down va-1x'></span>">Tu vas pouvoir générer et revendiquer tes propres TopList !</h4>

      <?php elseif (is_single() && (get_post_type() == "tournoi")) : ?>

        <?php if ($id_ranking) : ?>
          <div class="tournament-heading text-center">
            <h3 class="mb-0 t-titre-tournoi">Top <?php echo $top_infos['top_number']; ?> <span class="ico va va-high-voltage va va-lg"></span> <?php echo $top_infos['top_title']; ?></h3>
            <h4 class="mb-0 t-violet t-max">
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

        <?php $id_top = $_GET['id_top'];
        global $count_toplist; ?>
        <div class="tournament-heading text-center">
          <h3 class="mb-0 t-titre-tournoi"><?php echo $count_toplist; ?> TopList <span class="ico text-center va va-trophy va-lg"></span> <?php echo get_the_title($id_top); ?></h3>
          <h4 class="mb-0">
            <?php the_field('question_t', $id_top); ?>
          </h4>
        </div>

      <?php elseif (!is_author() && is_archive()) : ?>

        <div class="tournament-heading text-center">
          <h3 class="mb-0 t-titre-tournoi"><?php the_field('icone_cat', 'term_' . $cat_id); ?> <?php echo $cat_name; ?></h3>
          <h4 class="mb-0"><?php echo $current_cat->description; ?></h4>
        </div>

      <?php elseif (is_page(get_page_by_path('rechercher'))) : ?>

        <div class="tournament-heading text-center">
          <h3 class="mb-0 t-titre-tournoi"><span class="text-muted">Recherche</span> <span class="ico va va-loupe va-lg"></span> <span class="text-uppercase"><?php echo $term_to_search; ?></span></h3>
          <h4 class="mb-0">
            <?php
            if ($searching_for_a_vainkeur) {
              echo 'Vainkeur trouvé  - ';
            }
            if ($total_top_founded == 0 || !$total_top_founded) {
              echo "Aucun Top trouvé";
            } elseif ($total_top_founded == 1) {
              echo "Un seul Top trouvé";
            } else {
              echo $total_top_founded . " Tops trouvés";
            }
            ?>
          </h4>
        </div>

      <?php elseif (is_page(get_page_by_path('tops-sponso'))) : ?>

        <div class="tournament-heading text-center">
          <h3 class="mb-0 t-titre-tournoi"><span class="ico va va-wrapped-gift va-lg"></span> Tops sponso</h3>
          <h4 class="mb-0">Plein de choses à gagner par ici</h4>
        </div>

      <?php elseif (is_page(array(27040, 172849, 468675, 305107, 468673))) : ?>

        <div class="tournament-heading text-center">
          <h3 class="mb-0 t-titre-tournoi">
            <span class="text-uppercase"><?php echo $infos_vainkeur['pseudo']; ?></span> <?php echo $infos_vainkeur['level']; ?>
          </h3>
          <h4 class="mb-0"><?php the_title(); ?></h4>
        </div>

      <?php elseif (is_page(get_page_by_path('blog'))) : ?>

        <div class="tournament-heading text-center">
          <h3 class="mb-0 t-titre-tournoi"><span class="ico va va-sun va-lg"></span> Blog</h3>
          <h4 class="mb-0">De la littérature littéralement envoûtante <span class="va va-upside-down-face va-md"></span></h4>
        </div>

      <?php elseif (is_page(get_page_by_path('tous-les-sujets'))) : ?>

        <div class="tournament-heading text-center">
          <h3 class="mb-0 t-titre-tournoi"><span class="ico va va-package va-lg"></span> Tous les sujets</h3>
          <h4 class="mb-0">que tu retrouves sur VAINKEURZ</h4>
        </div>

      <?php elseif (is_author()) : ?>

        <div class="tournament-heading text-center">
          <h3 class="mb-0 t-titre-tournoi">
            Profil de <?php echo $infos_vainkeur_to_watch['pseudo']; ?> <?php echo $infos_vainkeur_to_watch['level']; ?>
          </h3>
        </div>

      <?php elseif (is_page(218587)) : ?>

        <div class="tournament-heading text-center">
          <h3 class="mb-0 t-titre-tournoi">
            Profil créateur de <?php echo $infos_vainkeur_to_watch['pseudo']; ?> <?php echo $infos_vainkeur_to_watch['level']; ?>
          </h3>
        </div>

      <?php elseif (is_single() && (get_post_type() === "post")) : ?>

        <div class="tournament-heading text-center">
          <h3 class="mb-0 t-titre-tournoi"><span class="ico va va-sun va-lg"></span> Blog</h3>
          <h4 class="mb-0"><?php the_title(); ?></h4>
        </div>

      <?php elseif (get_page_template_slug() == 'special/special.php') : ?>

        <div class="tournament-heading text-center">
          <h3 class="mb-0 t-titre-tournoi"><span class="ico va va-wrapped-gift va-lg"></span> <?php the_field('intro_1_special'); ?></h3>
          <h4 class="mb-0"><?php the_field('intro_2_special'); ?></h4>
        </div>

      <?php endif; ?>
    </div>

    <ul class="nav navbar-nav align-items-center justify-content-around">
      <li class="nav-item dropdown dropdown-cart mt-3px keurz-dropdown-container">
        <a class="nav-link d-flex flex-column align-items-center" href="javascript:void(0);" data-toggle="dropdown">
          <div class="d-flex flex-column">
            <div>
              <span class="ico text-center va-mush va va-lg"></span>
              <span class="value-user-stats user-total-vote-value">
                <?php if ($infos_vainkeur['money_vkrz']) : ?>
                  <?php echo $infos_vainkeur['money_vkrz']; ?>
                <?php else : ?>
                  0
                <?php endif; ?>
              </span>
            </div>
            <div>
              <span class="ico text-center va-gem va va-lg to-sign <?php echo is_user_logged_in() ? "connected" : "" ?>"></span>
              <span class="value-user-stats money-disponible">
                <?php if ($infos_vainkeur['current_money_vkrz']) : ?>
                  <?php echo $infos_vainkeur['current_money_vkrz']; ?>
                <?php else : ?>
                  0
                <?php endif; ?>
              </span>
            </div>
          </div>
        </a>
        <ul class="dropdown-menu dropdown-menu-media dropdown-menu-right keurz-dropdown">
          <li class="dropdown-menu-header">
            <div class="dropdown-header d-flex justify-content-between align-items-center">
              <h4 class="mb-0 mr-auto">
                <?php echo $infos_vainkeur['current_money_vkrz']; ?> <span class="va-gem va va-lg "></span>
              </h4>
              <?php if (is_user_logged_in()) : ?>
                <a href="#" class="btn btn-rose open-popup">Invite tes amis <span class="va-cheese1 va va-lg"></span></a>
              <?php endif; ?>
            </div>
          </li>
          <li class="dropdown-menu-footer">
            <div class="text-center mb-2 ">
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
            <?php echo $infos_vainkeur['nb_top_vkrz']; ?>
          </span>
        </a>
      </li>

      <?php if (is_user_logged_in()) : ?>
        <li class="nav-item dropdown dropdown-notification mr-25">
          <a class="nav-link menuuser-bell" href="javascript:void(0);" data-toggle="dropdown">
            <span class="ico text-center va va-bell"></span>
            <span class="d-block text-center notifications-nombre">
              -
            </span>
          </a>
          <ul class="dropdown-menu dropdown-menu-media dropdown-menu-right">
            <li class="dropdown-menu-header">
              <div class="dropdown-header d-flex">
                <h4 class="notification-title mb-0 mr-auto">Notifications</h4>
                <div class="badge badge-pill badge-light-primary">
                  <span class="notifications-nombre">-</span>
                  <span class="notifications-span">Nouvelle</span>
                </div>
              </div>
            </li>
            <li class="scrollable-container media-list notifications-container">
            </li>
            <li class="dropdown-menu-footer">
              <a class="btn btn-primary w-100 waves-effect waves-float waves-light" href="<?php the_permalink(get_page_by_path('mon-compte/notifications')); ?>">
                Voir toutes les notifications
              </a>
            </li>
          </ul>
        </li>
      <?php endif; ?>

      <li class="nav-item dropdown dropdown-user ml-25">
        <a class="nav-link dropdown-toggle dropdown-user-link" id="dropdown-user" href="javascript:void(0);" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <span class="avatar">
            <span class="avatar-picture" style="background-image: url(<?php echo $infos_vainkeur['avatar']; ?>);"></span>
            <span class="user-niveau">
              <?php echo $infos_vainkeur['level']; ?>
            </span>
          </span>
        </a>
        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdown-user">
          <?php if (is_user_logged_in()) : ?>
            <a class="dropdown-item" href="<?php the_permalink(get_page_by_path('mon-compte')); ?>">
              <div class="progress-wrapper">
                <?php
                $nb_need_money       = get_vote_to_next_level($infos_vainkeur['level_number'], $infos_vainkeur['money_vkrz']);
                $money_to_next_level = $nb_need_money + $infos_vainkeur['money_vkrz'];
                $percent_progression = round($infos_vainkeur['money_vkrz'] * 100 / $money_to_next_level);
                ?>
                <div id="example-caption-5">Encore <span class="decompte_vote"><?php echo $nb_need_money; ?></span> <span class="ico text-center va va-mush va-z-15"></span> pour <?php echo $infos_vainkeur['next_level']; ?></div>
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
            <a class="dropdown-item" href="<?php the_permalink(27794); ?>">
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

<?php if (is_user_logged_in()) :
  $codeparrain = get_field('code_parrain_user', 'user_' . $infos_vainkeur['id_user']);
?>
  <div class="popup-overlay d-none">
    <div class="popup referral-popup rotate-in-center">
      <button class="close-popup">&times;</button>

      <div class="popup-body">
        <span class="va va-love-people va-5x"></span> <br>
        <h3>Partager c'est aimer!</h3>
        <p>Partage ton code de parrainage avec tes amis et gagne 200 <span class="ico text-center va-gem va va-lg"></span> pour toi et 100 <span class="ico text-center va-gem va va-lg"></span> pour celui que tu as parrainé.</p>


        <a href="<?php the_permalink(get_page_by_path('creer-mon-compte')); ?>?codeinvit=<?= $codeparrain ?>" class="btn btn-rose waves-effect waves-float waves-light p-1" id="copyReferralLink">
          <p class="h4 text-white m-0">
            Copier mon code d'invitation
          </p>
        </a>
      </div>
      <div class="popup-footer">
        <hr class="my-2">
        <div class="rs">
          <div class="d-flex align-items-center">
            <ul>
              <li>
                <h6 class="section-label text-center m-0">Ou par</h6>
              </li>
              <li>
                <a href="https://www.facebook.com/sharer/sharer.php?u=<?php the_permalink(get_page_by_path('creer-mon-compte')); ?>?codeinvit=<?= $codeparrain ?>&quote=Deviens toi aussi un vainkeur" title="Share on Facebook" target="_blank">
                  <span>
                    <i class="fab fa-facebook-f"></i>
                  </span>
                </a>
              </li>
              <li>
                <a href="https://twitter.com/intent/tweet?source=<?php the_permalink(get_page_by_path('creer-mon-compte')); ?>?codeinvit=<?= $codeparrain ?>&text=Deviens toi aussi un vainkeur:%20<?php the_permalink(get_page_by_path('creer-mon-compte')); ?>?codeinvit=<?= $codeparrain ?>" target="_blank" title="Tweet" spellcheck="false">
                  <span>
                    <i class="fab fa-twitter"></i>
                  </span>
                </a>
              </li>
              <li class="whatsapp">
                <a href="whatsapp://send?text=<?php the_permalink(get_page_by_path('creer-mon-compte')); ?>?codeinvit=<?= $codeparrain ?>" data-action="share/whatsapp/share">
                  <span>
                    <i class="fab fa-whatsapp"></i>
                  </span>
                </a>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </div>
<?php endif; ?>