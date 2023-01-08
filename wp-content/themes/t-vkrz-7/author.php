<?php
global $id_membre;
global $infos_vainkeur_to_watch;
global $id_vainkeur_to_watch;
get_header();
$list_user_toplists = get_user_toplist($id_vainkeur_to_watch);
$list_t_done        = array();
foreach ($list_user_toplists as $top) {
  if ($top['state'] == 'done') {
    array_push($list_t_done, $top);
  }
}
?>
<div class="app-content content ">
  <div class="content-wrapper">
    <div class="content-body">

      <div id="user-profile">
        <div class="row">
          <div class="col-12">
            <?php get_template_part('partials/profil'); ?>
          </div>
        </div>

        <section id="profile-info">
          <div class="row">
            <div class="col-lg-3 col-12 order-2 order-lg-1">

              <?php
              if (get_userdata($id_membre)->description) : ?>
                <div class="card card-transaction">
                  <div class="card-header">
                    <h4 class="card-title">
                      <span class="ico va va-kissing va-lg"></span> Bio
                    </h4>
                  </div>
                  <div class="card-body">
                    <div class="info-bio">
                      <p class="card-text">
                        <?php echo get_userdata($id_membre)->description; ?>
                      </p>
                    </div>
                  </div>
                </div>
              <?php endif; ?>
              <?php if (get_userdata($id_membre)->twitch_user || get_userdata($id_membre)->youtube_user || get_userdata($id_membre)->Instagram_user || get_userdata($id_membre)->tiktok_user) : ?>
                <div class="card card-transaction">
                  <div class="card-header">
                    <h4 class="card-title">
                      <span class="ico va va-lolipop va-lg"></span> Rézeaux
                    </h4>
                  </div>
                  <div class="card-body">
                    <div class="info-bio">
                      <div class="flex-row d-flex align-items-baseline">
                        <?php if (get_userdata($id_membre)->twitch_user) : ?>
                          <div class="transaction-item">
                            <a href="https://www.twitch.tv/<?php echo get_userdata($id_membre)->twitch_user; ?>" target="_blank">
                              <div class="d-flex align-items-center">
                                <div class="avatar bg-light-primary rounded">
                                  <div class="avatar-content picto-rs">
                                    <i class="fab fa-twitch"></i>
                                  </div>
                                </div>
                              </div>
                            </a>
                          </div>
                        <?php endif; ?>
                        <?php if (get_userdata($id_membre)->youtube_user) : ?>
                          <div class="transaction-item">
                            <a href="https://www.youtube.com/user/<?php echo get_userdata($id_membre)->youtube_user; ?>" target="_blank">
                              <div class="d-flex align-items-center">
                                <div class="avatar bg-light-primary rounded">
                                  <div class="avatar-content picto-rs">
                                    <i class="fab fa-youtube"></i>
                                  </div>
                                </div>
                              </div>
                            </a>
                          </div>
                        <?php endif; ?>
                        <?php if (get_userdata($id_membre)->Instagram_user) : ?>
                          <div class="transaction-item">
                            <a href="https://www.instagram.com/<?php echo get_userdata($id_membre)->Instagram_user; ?>" target="_blank">
                              <div class="d-flex align-items-center">
                                <div class="avatar bg-light-primary rounded">
                                  <div class="avatar-content picto-rs">
                                    <i class="fab fa-instagram"></i>
                                  </div>
                                </div>
                              </div>
                            </a>
                          </div>
                        <?php endif; ?>
                        <?php if (get_userdata($id_membre)->twitter_user) : ?>
                          <div class="transaction-item">
                            <a href="https://twitter.com/<?php echo get_userdata($id_membre)->twitter_user; ?>" target="_blank">
                              <div class="d-flex align-items-center">
                                <div class="avatar bg-light-primary rounded">
                                  <div class="avatar-content picto-rs">
                                    <i class="fab fa-twitter"></i>
                                  </div>
                                </div>
                              </div>
                            </a>
                          </div>
                        <?php endif; ?>
                        <?php if (get_userdata($id_membre)->snapchat_user) : ?>
                          <div class="transaction-item">
                            <a href="https://www.snapchat.com/add/<?php echo get_userdata($id_membre)->snapchat_user; ?>" target="_blank">
                              <div class="d-flex align-items-center">
                                <div class="avatar bg-light-primary rounded">
                                  <div class="avatar-content picto-rs">
                                    <i class="fab fa-snapchat-ghost"></i>
                                  </div>
                                </div>
                              </div>
                            </a>
                          </div>
                        <?php endif; ?>
                        <?php if (get_userdata($id_membre)->tiktok_user) : ?>
                          <div class="transaction-item">
                            <a href="https://www.tiktok.com/@<?php echo get_userdata($id_membre)->tiktok_user; ?>?" target="_blank">
                              <div class="d-flex align-items-center">
                                <div class="avatar bg-light-primary rounded">
                                  <div class="avatar-content picto-rs">
                                    <i class="fab fa-tiktok"></i>
                                  </div>
                                </div>
                              </div>
                            </a>
                          </div>
                        <?php endif; ?>
                      </div>
                    </div>
                  </div>
                </div>
              <?php endif; ?>

              <?php
              $vainkeur_badges = get_the_terms($id_vainkeur_to_watch, 'badges');
              if ($vainkeur_badges) : ?>
                <div class="card">
                  <div class="card-header">
                    <h4 class="card-title">
                      <span class="ico va va-medal-1 va-lg"></span> Trophées
                    </h4>
                  </div>
                  <div class="card-body">
                    <div class="row">
                      <?php foreach ($vainkeur_badges as $badge) : ?>
                        <div class="col-4 col-sm-6 col-lg-4">
                          <div class="text-center">
                            <div class="user-level" data-toggle="tooltip" data-placement="top" title="" data-original-title="<?php echo $badge->name; ?> : <?php echo $badge->description; ?>">
                              <span class="icomedium">
                                <?php the_field('symbole_badge', 'badges_' . $badge->term_id); ?>
                              </span>
                            </div>
                          </div>
                        </div>
                      <?php endforeach; ?>
                    </div>
                  </div>
                </div>
              <?php endif; ?>

              <div class="card">
                <div class="card-header">
                  <h4 class="card-title">
                    <span class="ico va va-hourglass va-lg"></span> Progression
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
                      if ($count_top_done_in_cat > $tops_in_cat) {
                        $count_top_done_in_cat = $tops_in_cat;
                      }
                    ?>
                      <div class="col-12 mt-1 mb-1">
                        <p class="mb-50">
                          <span class="ico2">
                            <?php the_field('icone_cat', 'term_' . $cat->term_id); ?>
                          </span>
                          <?php echo $cat->name; ?>
                          <small class="infosmall text-<?php echo $classbar; ?>">
                            <?php echo $count_top_done_in_cat; ?> sur <?php echo $tops_in_cat; ?>
                          </small>
                        </p>
                        <div class="progress progress-bar-<?php echo $classbar; ?>" style="height: 6px">
                          <div class="progress-bar" role="progressbar" aria-valuenow="<?php echo $percent_done_cat; ?>" aria-valuemin="<?php echo $percent_done_cat; ?>" aria-valuemax="100" style="width: <?php echo $percent_done_cat; ?>%"></div>
                        </div>
                      </div>
                    <?php endforeach; ?>
                  </div>
                </div>
              </div>
            </div>

            <div id="ancore" class="col-lg-9 col-12 order-1 order-lg-2">
              <section class="app-user-view">
                <div class="row match-height">
                  <div class="col-sm-3">
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
                            <?php echo $infos_vainkeur_to_watch['level']; ?>
                          </span>
                        </div>
                        <p class="card-text legende mt-2">Niveau</p>
                      </div>
                    </div>
                  </div>
                  <div class="col-sm-3 col-4">
                    <div class="card text-center">
                      <div class="card-body">
                        <div class="mb-1">
                          <span class="ico4 va-high-voltage va va-z-30"></span>
                        </div>
                        <h2 class="font-weight-bolder">
                          <?php echo $infos_vainkeur_to_watch['nb_vote_vkrz']; ?>
                        </h2>
                        <?php if ($infos_vainkeur_to_watch['nb_vote_vkrz'] > 1) : ?>
                          <p class="card-text legende">Votes</p>
                        <?php else : ?>
                          <p class="card-text legende">Vote</p>
                        <?php endif; ?>
                      </div>
                    </div>
                  </div>
                  <div class="col-sm-3 col-4">
                    <div class="card text-center">
                      <div class="card-body">
                        <div class="mb-1">
                          <span class="ico4 va va-trophy va-z-30"></span>
                        </div>
                        <h2 class="font-weight-bolder">
                          <?php echo $infos_vainkeur_to_watch['nb_top_vkrz']; ?>
                        </h2>
                        <p class="card-text legende">
                          <?php if ($infos_vainkeur_to_watch['nb_top_vkrz'] > 1) : ?>
                            Tops terminés
                          <?php else : ?>
                            Top terminé
                          <?php endif; ?>
                        </p>
                      </div>
                    </div>
                  </div>
                  <div class="col-sm-3 col-4">
                    <div class="card text-center">
                      <div class="card-body">
                        <div class="mb-1">
                          <span class="ico4 va-sm va va-guetteur va-z-30"></span>
                        </div>
                        <h2 class="font-weight-bolder followers-nbr">
                          -
                        </h2>
                        <p class="card-text legende followers-nbr-text">
                          Guetteur
                        </p>
                      </div>
                    </div>
                  </div>
                </div>
              </section>
              <section id="basic-tabs-components">
                <div class="tab-content">
                  <div class="tab-pane active" id="tab2" aria-labelledby="profileIcon-tab" role="tabpanel">
                    <div class="row">
                      <div class="col-12">

                        <div class="card text-center loader-list card-voile" data-idtop="<?php echo $id_top; ?>" data-topurl="<?php echo get_permalink($id_top) ?>">
                          <div class="voile-gif" style="background-image: url(<?php bloginfo('template_directory'); ?>/assets/images/gif/wait-<?php echo rand(1, 7); ?>.gif)"></div>
                          <!-- <a href="https://elmobachiadil.com" target="_blank" class="participate-gif-top">
                            <span data-toggle="tooltip" data-placement="top" title="Participate to the best Waiting GIF Top" data-original-title="Participate to the best Waiting GIF Top">
                              <span class="badge badge-pill badge-light-primary">
                                <span class="ico text-center va va-trophy va-lg"></span>
                              </span>
                            </span>
                          </a> -->
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
                          <div class="card-datatable table-responsive">
                            <table class="table table-4 table-toplist-done">
                              <thead>
                                <tr>
                                  <th class="">
                                    <span class="text-muted nb_top_vkrz">
                                      <?php if ($infos_vainkeur['nb_top_vkrz'] >= 25) : ?>
                                        Liste des <span class="t-rose">25</span> dernières TopList
                                      <?php else : ?>
                                        <span class="t-rose"><?php echo $infos_vainkeur['nb_top_vkrz']; ?></span> TopList
                                      <?php endif; ?>
                                    </span>
                                  </th>
                                  <th>
                                    <span class="text-muted">Podium</span>
                                  </th>
                                  <th class="text-right shorted">
                                    <span class="text-muted">Votes <span class="va va-updown va-z-15"></span></span>
                                  </th>
                                  <th class="text-right">
                                    <span class="text-muted">Action</span>
                                  </th>
                                </tr>
                              </thead>
                              <tbody>
                                <?php
                                foreach (array_slice($list_t_done, 0, 25) as $r_user) :
                                  $list_type    = array();
                                  $get_top_type = get_the_terms($r_user['id_top'], 'type');
                                  if ($get_top_type) {
                                    foreach ($get_top_type as $type_top) {
                                      array_push($list_type, $type_top->slug);
                                    }
                                  }
                                  if (!in_array('private', $list_type) && !in_array('onboarding', $list_type) && get_post_status($r_user['id_top'])) : ?>
                                    <tr id="top-<?php echo $r_user['id_ranking']; ?>">
                                      <td>
                                        <?php
                                        global $id_top;
                                        $id_top = $r_user['id_top'];
                                        get_template_part('partials/top-card');
                                        ?>
                                      </td>
                                      <td>
                                        <?php
                                        $user_top3 = get_user_ranking($r_user['id_ranking']);
                                        $l = 1;
                                        foreach ($user_top3 as $top) : ?>

                                          <div data-toggle="tooltip" data-popup="tooltip-custom" data-placement="bottom" data-original-title="<?php echo get_the_title($top); ?>" class="avatartop3 avatar pull-up">
                                            <?php if (get_field('visuel_instagram_contender', $top)) : ?>
                                              <img src="<?php the_field('visuel_instagram_contender', $top); ?>" alt="<?php echo get_the_title($top); ?>">
                                            <?php else : ?>
                                              <?php $illu = get_the_post_thumbnail_url($top, 'thumbnail'); ?>
                                              <img src="<?php echo $illu; ?>" alt="<?php echo get_the_title($top); ?>">
                                            <?php endif; ?>
                                          </div>

                                        <?php $l++;
                                          if ($l == 4) break;
                                        endforeach; ?>
                                      </td>
                                      <td class="text-right">
                                        <?php echo $r_user['nb_votes']; ?> <span class="ico3 va-high-voltage va va-lg"></span>
                                      </td>
                                      <td class="text-right">
                                        <?php
                                        if ($r_user['typetop'] == "top3") {
                                          $wording = "Voir le Top 3";
                                        } else {
                                          $wording = "Voir la TopList";
                                        }
                                        ?>
                                        <a class="btn btn-flat-secondary waves-effect" href="<?php the_permalink($r_user['id_ranking']); ?>" data-toggle="tooltip" data-placement="top" title="" data-original-title="<?php echo $wording; ?>">
                                          <span class="va va-trophy va-lg"></span>
                                        </a>
                                        <a class="btn btn-flat-secondary waves-effect" href="<?php the_permalink(get_page_by_path('elo')); ?>?id_top=<?php echo $r_user['id_top']; ?>" data-toggle="tooltip" data-placement="top" title="" data-original-title="Voir la TopList mondiale">
                                          <span class="va va-globe va-lg"></span>
                                        </a>
                                        <a href="<?php the_permalink($r_user['id_ranking']); ?>" class="btn btn-flat-secondary waves-effect" data-toggle="tooltip" data-placement="top" title="" data-original-title="Juger cette TopList">
                                          <span class="va va-hache va-lg"></span>
                                        </a>
                                      </td>
                                    </tr>
                                  <?php endif; ?>
                                <?php endforeach; ?>
                              </tbody>
                            </table>
                          </div>
                        </div>
                        <?php if ($infos_vainkeur_to_watch['nb_top_vkrz'] >= 25) : ?>
                          <div class="card invoice-list-wrapper list-js">
                            <div class="card-datatable table-responsive">
                              <table class="table table-4 fetch-table table-toplist-done-js" data-idVainkeur="<?= $id_vainkeur_to_watch; ?>">
                                <thead>
                                  <tr>
                                    <th class="">
                                      <span class="text-muted nb_top_vkrz">
                                        <span class="t-rose"><?php echo $infos_vainkeur_to_watch['nb_top_vkrz']; ?></span> TopList
                                      </span>
                                    </th>
                                    <th>
                                      <span class="text-muted">Podium</span>
                                    </th>
                                    <th class="text-right shorted">
                                      <span class="text-muted">Votes <span class="va va-updown va-z-15"></span></span>
                                    </th>
                                    <th class="text-right">
                                      <span class="text-muted">Action</span>
                                    </th>
                                  </tr>
                                </thead>
                                <tbody>
                                  <?php
                                  foreach (array_slice($list_t_done, 0, 25) as $r_user) :
                                    $list_type    = array();
                                    $get_top_type = get_the_terms($r_user['id_top'], 'type');
                                    if ($get_top_type) {
                                      foreach ($get_top_type as $type_top) {
                                        array_push($list_type, $type_top->slug);
                                      }
                                    }
                                    if (!in_array('private', $list_type) && !in_array('onboarding', $list_type)) : ?>
                                      <tr id="top-<?php echo $r_user['id_ranking']; ?>">
                                        <td>
                                          <?php
                                          global $id_top;
                                          $id_top = $r_user['id_top'];
                                          get_template_part('partials/top-card');
                                          ?>
                                        </td>
                                        <td>
                                          <?php
                                          $user_top3 = get_user_ranking($r_user['id_ranking']);
                                          $l = 1;
                                          foreach ($user_top3 as $top) : ?>

                                            <div data-toggle="tooltip" data-popup="tooltip-custom" data-placement="bottom" data-original-title="<?php echo get_the_title($top); ?>" class="avatartop3 avatar pull-up">
                                              <?php if (get_field('visuel_instagram_contender', $top)) : ?>
                                                <img src="<?php the_field('visuel_instagram_contender', $top); ?>" alt="<?php echo get_the_title($top); ?>">
                                              <?php else : ?>
                                                <?php $illu = get_the_post_thumbnail_url($top, 'thumbnail'); ?>
                                                <img src="<?php echo $illu; ?>" alt="<?php echo get_the_title($top); ?>">
                                              <?php endif; ?>
                                            </div>

                                          <?php $l++;
                                            if ($l == 4) break;
                                          endforeach; ?>
                                        </td>
                                        <td class="text-right">
                                          <?php echo $r_user['nb_votes']; ?> <span class="ico3 va-high-voltage va va-lg"></span>
                                        </td>
                                        <td class="text-right">
                                          <?php
                                          if ($r_user['typetop'] == "top3") {
                                            $wording = "Voir le Top 3";
                                          } else {
                                            $wording = "Voir la TopList";
                                          }
                                          ?>
                                          <a class="btn btn-flat-secondary waves-effect" href="<?php the_permalink($r_user['id_ranking']); ?>" data-toggle="tooltip" data-placement="top" title="" data-original-title="<?php echo $wording; ?>">
                                            <span class="va va-trophy va-lg"></span>
                                          </a>
                                          <a class="btn btn-flat-secondary waves-effect" href="<?php the_permalink(get_page_by_path('elo')); ?>?id_top=<?php echo $r_user['id_top']; ?>" data-toggle="tooltip" data-placement="top" title="" data-original-title="Voir la TopList mondiale">
                                            <span class="va va-globe va-lg"></span>
                                          </a>
                                          <a href="<?php the_permalink($r_user['id_ranking']); ?>" class="btn btn-flat-secondary waves-effect" data-toggle="tooltip" data-placement="top" title="" data-original-title="Juger cette TopList">
                                            <span class="va va-hache va-lg"></span>
                                          </a>
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
                              Afficher les <?php echo $infos_vainkeur_to_watch['nb_top_vkrz']; ?> TopList <br>
                              <span class="text-muted">
                                Cela peut prendre quelques instants 🙃
                              </span>
                            </button>
                          </div>
                        <?php endif; ?>
                      </div>
                    </div>
                  </div>
                </div>
              </section>
            </div>
          </div>
        </section>
      </div>
    </div>
  </div>
</div>
<?php get_footer(); ?>