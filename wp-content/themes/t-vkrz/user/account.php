<?php
/*
    Template Name: Account
*/
global $infos_vainkeur;
global $id_vainkeur;
global $id_membre;
global $user_id;
get_header();
$list_user_toplists = get_user_toplist($id_vainkeur);
$list_t_begin   = array();
$list_t_done    = array();
$has_t_begin    = false;
if ($list_user_toplists) {
  foreach ($list_user_toplists as $top) {
    if ($top['state'] == 'begin') {
      array_push($list_t_begin, $top);
      $has_t_begin    = true;
    }
    if ($top['state'] == 'done') {
      array_push($list_t_done, $top);
    }
  }
}
if ($infos_vainkeur['user_role'] == "administrator" || $infos_vainkeur['user_role'] == "author") {
  if (false === ($data_t_created = get_transient('user_' . $user_id . '_get_creator_t'))) {
    $data_t_created = get_creator_t($user_id);
    set_transient('user_' . $user_id . '_get_creator_t', $data_t_created, DAY_IN_SECONDS);
  } else {
    $data_t_created = get_transient('user_' . $user_id . '_get_creator_t');
  }
}
?>
<!-- Content wrapper -->
<div class="content-wrapper content-compte">
  <!-- Content -->
  <div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">
      <!-- User Sidebar -->
      <div class="col-xl-3 col-lg-4 col-md-4">
        <!-- User cover -->
        <?php get_template_part('partials/profil'); ?>
        <!-- User cover -->

        <!-- User trophées -->
        <div class="card d-none d-sm-block">
          <?php $vainkeur_badges = get_the_terms($id_vainkeur, 'badges'); ?>
          <div class="card-header">
            <h4 class="card-title">
              Trophées
            </h4>
          </div>
          <div class="card-body">
            <div class="row">
              <?php if ($vainkeur_badges) : ?>
                <?php foreach ($vainkeur_badges as $badge) : ?>
                  <div class="col-4 col-sm-6 col-lg-4">
                    <div class="text-center">
                      <div class="user-level" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-bs-original-title="<?php echo $badge->name; ?> : <?php echo $badge->description; ?>">
                        <span class="icomedium">
                          <?php the_field('symbole_badge', 'badges_' . $badge->term_id); ?>
                        </span>
                      </div>
                    </div>
                  </div>
                <?php endforeach; ?>
              <?php else : ?>
                <div class="col">
                  <p class="text-muted">
                    Aucun trophée pour le moment <span class="va va-spiral-eyes va-md"></span>
                  </p>
                </div>
              <?php endif; ?>
            </div>
            <div class="mt-4 text-center">
              <a class="btn btn-outline-primary waves-effect" href="<?php the_permalink(get_page_by_path('trophees')); ?>">
                Découvrir les trophées
              </a>
            </div>
          </div>
        </div>
        <!-- /User trophées -->

        <!-- User progression -->
        <div class="card d-none d-sm-block">
          <div class="card-header">
            <h4 class="card-title">
              Progression
            </h4>
          </div>
          <div class="card-body">
            <div class="row avg-sessions pt-50">
              <?php
              $cat_t = get_terms(array(
                'taxonomy'      => 'categorie',
                'orderby'       => 'count',
                'order'         => 'DESC',
                'hide_empty'    => true
              ));
              foreach ($cat_t as $cat) :
                $tops_in_cat = $cat->count;
                $id_cat      = $cat->term_id;
                $count_top_done_in_cat = 0;
                foreach ($list_user_toplists as $top_done) {
                  if ($id_cat == $top_done['cat_t'] && $top_done['state'] == 'done') {
                    $count_top_done_in_cat++;
                  }
                }
                $percent_done_cat = round($count_top_done_in_cat * 100 / $tops_in_cat);
                if ($percent_done_cat >= 100) {
                  $classbar = "success";
                } elseif ($percent_done_cat < 100 && $percent_done_cat >= 25) {
                  $classbar = "primary";
                } else {
                  $classbar = "warning";
                }
              ?>
                <div class="col-12 mt-1 mb-1">
                  <p class="mb-50">
                    <span class="ico2">
                      <span class="<?php if ($cat->term_id == 2) : echo 'rotating';
                                    endif; ?>">
                        <?php the_field('icone_cat', 'term_' . $cat->term_id); ?>
                      </span>
                    </span>
                    <?php echo $cat->name; ?>
                    <small class="infosmall text-<?php echo $classbar; ?>">
                      <?php echo $count_top_done_in_cat; ?> sur <?php echo $tops_in_cat; ?>
                    </small>
                  </p>
                  <div class="progress progress-bar-<?php echo $classbar; ?>" style="height: 6px">
                    <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="<?php echo $percent_done_cat; ?>" aria-valuemin="<?php echo $percent_done_cat; ?>" aria-valuemax="100" style="width: <?php echo $percent_done_cat; ?>%"></div>
                  </div>
                </div>
              <?php endforeach; ?>
            </div>
          </div>
        </div>
        <!-- /User progression -->
      </div>
      <!--/ User Sidebar -->

      <!-- User Content -->
      <div class="col-xl-9 col-lg-8 col-md-8">

        <!-- Menu compte -->
        <?php get_template_part('partials/menu-profil'); ?>
        <!-- /Menu compte -->
        
        <!-- Stats Users -->
        <section id="ancore" class="app-user-view">
          <div class="row match-height">
            <div class="col-sm-6 col-12">
              <div class="card text-center">
                <div class="card-body">
                  <div class="pricing-badge text-right">
                    <div class="badge badge-pill badge-light-primary">
                      <a href="<?php the_permalink(get_page_by_path('evolution')); ?>">
                        ?
                      </a>
                    </div>
                  </div>
                  <div class="user-level">
                    <span class="icomax2">
                      <?php echo $infos_vainkeur['level']; ?>
                    </span>
                  </div>
                  <div class="progress-wrapper mt-1">
                    <?php
                    $nb_need_money       = get_vote_to_next_level($infos_vainkeur['level_number'], $infos_vainkeur['money_vkrz']);
                    $money_to_next_level = $nb_need_money + $infos_vainkeur['money_vkrz'];
                    $percent_progression = round($infos_vainkeur['money_vkrz'] * 100 / $money_to_next_level);
                    ?>
                    <div class="progress progress-bar-primary w-100 mb-3 mt-4" style="height: 5px;">
                      <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="<?php echo $percent_progression; ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $percent_progression; ?>%"></div>
                    </div>
                    <?php if (is_user_logged_in()) : ?>
                      <div id="example-caption-5">Il te faut encore <span class="decompte_vote"><?php echo $nb_need_money; ?></span> <span class="text-center va va-mush va-z-15"></span> <br> pour passer niveau <?php echo $infos_vainkeur['next_level']; ?></div>
                    <?php else : ?>
                      <a href="<?php the_permalink(get_page_by_path('creer-mon-compte')); ?>" class="t-white">
                        <div id="example-caption-5">Créé ton compte pour passer <?php echo $infos_vainkeur['next_level']; ?></div>
                      </a>
                    <?php endif; ?>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-sm-3 col-6">
              <div class="card text-center">
                <div class="card-body card-stats">
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
                </div>
              </div>
              <div class="card text-center">
                <div class="card-body card-stats">
                  <div class="itemstat">
                    <div>
                      <span class="iconstats va-high-voltage va va-lg"></span>
                    </div>
                    <div class="valuestat">
                      <?php if ($infos_vainkeur['nb_vote_vkrz']) : ?>
                        <?php echo $infos_vainkeur['nb_vote_vkrz']; ?>
                      <?php else : ?>
                        0
                      <?php endif; ?>
                      <small class="text-muted mb-0">Votes</small>
                    </div>
                  </div>
                </div>
              </div>
              <div class="card text-center">
                <div class="card-body card-stats">
                  <div class="itemstat">
                    <div>
                      <span class="iconstats va-guetteur va va-lg"></span>
                    </div>
                    <div class="valuestat">
                      <span class="followers-account-nbr">-</span>
                      <small class="text-muted mb-0 followers-account-nbr-text">Guetteur</small>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-sm-3 col-6">
              <div class="card text-center">
                <div class="card-body card-stats">
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
                </div>
              </div>
              <div class="card text-center">
                <div class="card-body card-stats">
                  <div class="itemstat">
                    <div>
                      <span class="iconstats va-trophy va va-lg"></span>
                    </div>
                    <div class="valuestat">
                      <?php if ($infos_vainkeur['nb_top_vkrz']) : ?>
                        <?php echo $infos_vainkeur['nb_top_vkrz']; ?>
                      <?php else : ?>
                        0
                      <?php endif; ?>
                      <small class="text-muted mb-0">TopList</small>
                    </div>
                  </div>
                </div>
              </div>
              <div class="card text-center">
                <div class="card-body card-stats">
                  <div class="itemstat">
                    <div>
                      <span class="iconstats va-love-people va va-lg"></span>
                    </div>
                    <div class="valuestat">
                      <span class="">
                        <?php 
                          $referrals = array();
                          if(get_field('referral_from_me', $infos_vainkeur["id_vainkeur"])) {
                            $referrals = json_decode(get_field('referral_from_me', $infos_vainkeur["id_vainkeur"]));
                            echo count($referrals);
                          } else {
                            echo 0;
                          }
                        ?>
                      </span>
                      <small class="text-muted mb-0">Parrainage</small>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <?php if ($infos_vainkeur['user_role'] == "administrator" || $infos_vainkeur['user_role'] == "author") : ?>
            <!-- Stats créateur -->
            <div class="row match-height">
              <div class="col-sm-3 col-6">
                <div class="card text-center">
                  <div class="card-body card-stats">
                    <div class="itemstat">
                      <div>
                        <span class="iconstats va-crossed-swords va va-lg"></span>
                      </div>
                      <div class="valuestat">
                        <?php echo number_format($data_t_created['creator_nb_tops'], 0, ",", " "); ?>
                        <small class="text-muted mb-0">
                          <?php echo ($data_t_created['creator_nb_tops'] > 1) ? "Tops créés" : "Top créé"; ?>
                        </small>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-sm-3 col-6">
                <div class="card text-center">
                  <div class="card-body card-stats">
                    <div class="itemstat">
                      <div>
                        <span class="iconstats va-vote-creator va va-lg"></span>
                      </div>
                      <div class="valuestat">
                        <?php echo number_format($data_t_created['creator_all_v'], 0, ",", " "); ?>
                        <small class="text-muted mb-0">
                          Votes générés
                        </small>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-sm-3 col-6">
                <div class="card text-center">
                  <div class="card-body card-stats">
                    <div class="itemstat">
                      <div>
                        <span class="iconstats va-toplist-creator va va-lg"></span>
                      </div>
                      <div class="valuestat">
                        <?php echo number_format($data_t_created['creator_all_t'], 0, ",", " "); ?>
                        <small class="text-muted mb-0">
                          TopList générées
                        </small>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-sm-3 col-6">
                <div class="card text-center">
                  <div class="card-body card-stats">
                    <div class="itemstat">
                      <div>
                        <span class="iconstats va-hundred va va-lg"></span>
                      </div>
                      <div class="valuestat">
                        <?php echo $data_t_created['finition_globale']; ?> %
                        <small class="text-muted mb-0">
                          Taux de finition
                        </small>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!-- /Stats créateur -->
          <?php endif; ?>
        </section>
        <!-- /Stats Users -->

        <!-- Users TopList -->
        <section class="list-toplist">
          <div class="card text-center loader-list card-voile" data-idtop="<?php echo $id_top; ?>" data-topurl="<?php echo get_permalink($id_top) ?>">
            <div class="voile-gif" style="background-image: url(<?php bloginfo('template_directory'); ?>/assets/images/gif/wait-<?php echo rand(1, 7); ?>.gif)"></div>
            <div class="card-body">
              <div class="content-card">
                <div class="loader-block">
                  <div class="loader loader--style1 w-100 mx-auto text-center" title="0">
                    <svg version="1.1" id="loader-1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="40px" height="40px" viewBox="0 0 40 40" enable-background="new 0 0 40 40" xml:space="preserve">
                      <path opacity="0.2" fill="#000" d="M20.201,5.169c-8.254,0-14.946,6.692-14.946,14.946c0,8.255,6.692,14.946,14.946,14.946s14.946-6.691,14.946-14.946C35.146,11.861,28.455,5.169,20.201,5.169z M20.201,31.749c-6.425,0-11.634-5.208-11.634-11.634c0-6.425,5.209-11.634,11.634-11.634c6.425,0,11.633,5.209,11.633,11.634C31.834,26.541,26.626,31.749,20.201,31.749z" />
                      <path fill="#000" d="M26.013,10.047l1.654-2.866c-2.198-1.272-4.743-2.012-7.466-2.012h0v3.312h0C22.32,8.481,24.301,9.057,26.013,10.047z">
                        <animateTransform attributeType="xml" attributeName="transform" type="rotate" from="0 20 20" to="360 20 20" dur="0.5s" repeatCount="indefinite" />
                      </path>
                    </svg>
                  </div>
                </div>
                <h2 class="font-weight-bolder mb-1 mt-1">
                  <small>Récupération des </small> <br>
                  <span class="t-violet"><?php echo $infos_vainkeur['nb_top_vkrz']; ?></span> TopList
                </h2>
              </div>
            </div>
            <div class="bar-container">
              <div class="bar"></div>
              <span class="bar-percent">0 %</span>
            </div>
          </div>
          <div class="card invoice-list-wrapper list-php">
            <div class="table-responsive">
              <table class="invoice-list-table table table-toplist-done">
                <thead>
                  <tr>
                    <th class="">
                      <span class="text-muted nb_top_vkrz">
                        <?php if ($infos_vainkeur['nb_top_vkrz'] >= 25) : ?>
                          Liste des dernières TopList
                        <?php else : ?>
                          <span class="t-rose"><?php echo $infos_vainkeur['nb_top_vkrz']; ?></span> TopList
                        <?php endif; ?>
                      </span>
                    </th>
                    <th>
                      <span class="text-muted">Top3</span>
                    </th>
                    <th class="text-right">
                      <span class="text-muted">Action</span>
                    </th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  foreach (array_slice($list_t_done, 0, 25) as $top) : ?>
                    <?php if (!get_field('private_t', $top['id_top']) && get_post_status($top['id_top'])) : ?>
                      <tr id="top-<?php echo $top['id_ranking']; ?>">
                        <td>
                          <?php
                          global $id_top;
                          $id_top = $top['id_top'];
                          get_template_part('partials/top-card');
                          ?>
                        </td>
                        <td>
                          <div class="top3list">
                            <?php
                            $user_top3 = get_user_ranking($top['id_ranking']);
                            $l = 1;
                            foreach ($user_top3 as $contender) : ?>

                              <div data-bs-toggle="tooltip" data-bs-popup="tooltip-custom" data-bs-placement="bottom" data-bs-original-title="<?php echo get_the_title($contender); ?>" class="avatartop3 avatar pull-up">
                                <?php if (get_field('visuel_instagram_contender', $contender)) : ?>
                                  <img src="<?php the_field('visuel_instagram_contender', $contender); ?>" alt="<?php echo get_the_title($contender); ?>">
                                <?php else : ?>
                                  <?php $illu = get_the_post_thumbnail_url($contender, 'thumbnail'); ?>
                                  <img src="<?php echo $illu; ?>" alt="<?php echo get_the_title($contender); ?>">
                                <?php endif; ?>
                              </div>

                            <?php $l++;
                              if ($l == 4) break;
                            endforeach; ?>
                          </div>
                        </td>
                        <td>
                          <div class="d-flex align-items-center justify-content-end col-actions">
                            <?php
                            if ($top['typetop'] == "top3") {
                              $wording = "Voir le Top 3";
                            } else {
                              $wording = "Voir la TopList";
                            }
                            ?>
                            <a class="btn btn-icon btn-label-primary waves-effect" href="<?php the_permalink($top['id_ranking']); ?>" data-toggle="tooltip" data-placement="top" title="" data-original-title="<?php echo $wording; ?>">
                              <span class="va va-trophy va-lg"></span>
                            </a>
                            <a class="btn btn-icon btn-label-primary waves-effect" href="<?php the_permalink(get_toplist_mondiale($id_top)); ?>" data-toggle="tooltip" data-placement="top" title="" data-original-title="Voir la TopList mondiale">
                              <span class="va va-globe va-lg"></span>
                            </a>
                            <a href="<?php the_permalink($top['id_ranking']); ?>#juger" class="btn btn-icon btn-label-primary waves-effect" data-toggle="tooltip" data-placement="top" title="" data-original-title="Juger cette TopList">
                              <span class="va va-hache va-lg"></span>
                            </a>
                          </div>
                        </td>
                      </tr>
                    <?php endif; ?>
                  <?php endforeach; ?>
                </tbody>
              </table>
            </div>
          </div>
          <?php if ($infos_vainkeur['nb_top_vkrz'] >= 25) : ?>
            <div class="card invoice-list-wrapper list-js">
              <div class="table-responsive">
                <table class="invoice-list-table table fetch-table" data-idVainkeur="<?= $id_vainkeur; ?>">
                  <thead>
                    <tr>
                      <th class="">
                        <span class="text-muted nb_top_vkrz">
                          <span class="t-rose"><?php echo $infos_vainkeur['nb_top_vkrz']; ?></span> TopList
                        </span>
                      </th>
                      <th>
                        <span class="text-muted">Podium</span>
                      </th>
                      <th class="text-right">
                        <span class="text-muted">Action</span>
                      </th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    foreach (array_slice($list_t_done, 0, 25) as $top) : ?>
                      <?php if (!get_field('private_t', $top['id_top'])) : ?>
                        <tr id="top-<?php echo $top['id_ranking']; ?>">
                          <td>
                            <?php
                            global $id_top;
                            $id_top = $top['id_top'];
                            get_template_part('partials/top-card');
                            ?>
                          </td>
                          <td>
                            <div class="top3list">
                              <?php
                              $user_top3 = get_user_ranking($top['id_ranking']);
                              $l = 1;
                              foreach ($user_top3 as $contender) : ?>
                                <div data-toggle="tooltip" data-popup="tooltip-custom" data-placement="bottom" data-original-title="<?php echo get_the_title($contender); ?>" class="avatartop3 avatar pull-up">
                                  <?php if (get_field('visuel_instagram_contender', $contender)) : ?>
                                    <img src="<?php the_field('visuel_instagram_contender', $contender); ?>" alt="<?php echo get_the_title($contender); ?>">
                                  <?php else : ?>
                                    <?php $illu = get_the_post_thumbnail_url($contender, 'thumbnail'); ?>
                                    <img src="<?php echo $illu; ?>" alt="<?php echo get_the_title($contender); ?>">
                                  <?php endif; ?>
                                </div>
                              <?php $l++;
                                if ($l == 4) break;
                              endforeach; ?>
                            </div>
                          </td>
                          <td>
                            <div class="d-flex align-items-center justify-content-end col-actions">
                              <?php
                              if ($top['typetop'] == "top3") {
                                $wording = "Voir le Top 3";
                              } else {
                                $wording = "Voir la TopList";
                              }
                              ?>
                              <a class="btn btn-icon btn-label-primary waves-effect" href="<?php the_permalink($top['id_ranking']); ?>" data-toggle="tooltip" data-placement="top" title="" data-original-title="<?php echo $wording; ?>">
                                <span class="va va-trophy va-lg"></span>
                              </a>
                              <a class="btn btn-icon btn-label-primary waves-effect" href="<?php the_permalink(get_toplist_mondiale($id_top)); ?>" data-toggle="tooltip" data-placement="top" title="" data-original-title="Voir la TopList mondiale">
                                <span class="va va-globe va-lg"></span>
                              </a>
                              <a href="<?php the_permalink($top['id_ranking']); ?>#juger" class="btn btn-icon btn-label-primary waves-effect" data-toggle="tooltip" data-placement="top" title="" data-original-title="Juger cette TopList">
                                <span class="va va-hache va-lg"></span>
                              </a>
                            </div>
                          </td>
                        </tr>
                      <?php endif; ?>
                    <?php endforeach; ?>
                  </tbody>
                </table>
              </div>
            </div>
            <div class="loadmore-container text-center mt-1">
              <button type="button" class="btn btn-outline-primary waves-effect waves-float waves-light load_more_toplists" spellcheck="false">
                Afficher les <?php echo $infos_vainkeur['nb_top_vkrz']; ?> TopList
                <span class="text-muted">
                  Cela peut prendre quelques instants 🙃
                </span>
              </button>
            </div>
          <?php endif; ?>
        </section>
        <!-- /Users TopList -->

        <!-- Creator Top -->
        <section id="topsducreateur" class="mt-4">
          <div class="card">
            <div class="table-responsive">
              <table class="table table-creator">
                <thead>
                  <tr>
                    <th class="">
                      <span class="text-muted">
                        Liste des Tops créés
                      </span>
                    </th>
                    <th class="text-right shorted">
                      <span class="text-muted">Total des votes <span class="va va-updown va-z-15"></span></span>
                    </th>
                    <th class="text-right shorted">
                      <span class="text-muted">Tops générés <span class="va va-updown va-z-15"></span></span>
                    </th>
                    <th class="text-right shorted">
                      <span class="text-muted">% de finition <span class="va va-updown va-z-15"></span></span>
                    </th>
                    <th class="text-right">
                      <span class="text-muted">Action</span>
                    </th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  if(isset($data_t_created)) :
                  foreach ($data_t_created['creator_tops'] as $item) : ?>
                    <?php if (!in_array($item['top_id'], get_exclude_top())) : ?>
                      <tr>
                        <td>
                          <?php
                          global $id_top;
                          $id_top = $item['top_id'];
                          get_template_part('partials/top-card');
                          ?>
                        </td>
                        <td class="text-right">
                          <?php echo $item['top_votes']; ?> <span class="ico3 va-high-voltage va va-lg"></span>
                        </td>
                        <td class="text-right">
                          <?php echo $item['top_ranks']; ?> <span class="ico3 va va-trophy va-lg"></span>
                        </td>
                        <td class="text-right">
                          <?php echo $item['top_finition']; ?> %
                        </td>
                        <td class="text-right">
                          <div class="d-flex align-items-center justify-content-end col-actions">
                            <?php
                            if ($top['typetop'] == "top3") {
                              $wording = "Voir le Top 3";
                            } else {
                              $wording = "Voir la TopList";
                            }
                            ?>
                            <a class="btn btn-icon btn-label-primary waves-effect" href="<?php the_permalink(get_toplist_mondiale($id_top)); ?>#toplist" data-toggle="tooltip" data-placement="top" title="" data-original-title="Voir toutes les TopList">
                              <span class="ico va va-eyes va-lg"></span>
                            </a>
                            <a class="btn btn-icon btn-label-primary waves-effect" href="<?php the_permalink(get_toplist_mondiale($id_top)); ?>" data-toggle="tooltip" data-placement="top" title="" data-original-title="Voir la TopList mondiale">
                              <span class="ico va va-globe va-lg"></span>
                            </a>
                          </div>
                        </td>
                      </tr>
                  <?php endif;
                  endforeach; endif; ?>
                </tbody>
              </table>
            </div>
          </div>
        </section>
        <!-- /Creator Top -->

      </div>
      <!-- /User Content -->
    </div>
  </div>
  <!-- /Content -->
  <div class="content-backdrop fade"></div>
</div>
<!-- Content wrapper -->
<?php get_footer(); ?>