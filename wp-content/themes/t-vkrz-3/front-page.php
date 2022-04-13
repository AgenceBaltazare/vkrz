<?php
get_header();
global $user_tops;
$list_t_already_done = $user_tops['list_user_tops_done_ids'];
$list_user_tops      = $user_tops['list_user_tops'];
?>
<div class="app-content content ">
  <div class="content-wrapper">
    <div class="content-body">

      <div class="intro-mobile">
        <h3 class="mb-0 animate__animated animate__slideInLeft"><span class="va va-vulcan-salute va-1x"></span> Bienvenue</h3>
        <h4 class="mb-0 kick animate__animated animate__slideInRight" data-kick="Commence par choisir un Top qui t'intéresse et enchaîne les votes <span class='va va-backhand-index-pointing-down va-1x'>">
          Ici, tu fais et revendique tes propres Tops !
        </h4>
      </div>

      <div class="d-block d-sm-none my-2">
        <form action="<?= the_permalink(get_page_by_path('recherche')); ?>" method="POST" class="d-flex rechercher-form" autocomplete="off">
          <input type="search" name="term" id="term" class="form-control rechercher-input" placeholder="Trouve ton meilleur Top..." required oninvalid="this.setCustomValidity('Son goku par exemple..')">

          <button type="submit" name="go" class="form-control lead go-input">
            <span class="ico ico-search va va-magnifying-glass-tilted-left va-lg"></span>
          </button>
        </form>
      </div>

      <section class="list-tournois">
        <div class="big-cat">
          <div class="heading-cat">
            <div class="row">
              <div class="col">
                <h2 class="text-primary text-uppercase">
                  <span class="va va-stopwatch va-lg"></span> Tops les plus récents
                  <small class="text-muted">Toutes catégories confondues</small>
                </h2>
              </div>
            </div>
          </div>
        </div>
        <div id="component-swiper-responsive-breakpoints">
          <div class="swiper-responsive-breakpoints swiper-container swiper-0">
            <div class="swiper-wrapper">
              <?php
              $tournois_in_cat = new WP_Query(array(
                'ignore_sticky_posts'    => true,
                'update_post_meta_cache' => false,
                'no_found_rows'          => true,
                'post_type'              => 'tournoi',
                'post__not_in'           => $list_t_already_done,
                'orderby'                => 'date',
                'order'                  => 'DESC',
                'posts_per_page'         => 10,
                'tax_query' => array(
                  array(
                    'taxonomy' => 'type',
                    'field'    => 'slug',
                    'terms'    => array('private', 'whitelabel', 'onboarding'),
                    'operator' => 'NOT IN'
                  ),
                ),
              ));
              while ($tournois_in_cat->have_posts()) : $tournois_in_cat->the_post(); ?>

                <?php get_template_part('partials/min-t'); ?>

              <?php endwhile; ?>
            </div>
            <div class="swiper-button-next swiper-button-next-0"></div>
            <div class="swiper-button-prev swiper-button-prev-0"></div>
          </div>
        </div>
      </section>

      <section class="list-tournois">
        <div class="big-cat">
          <div class="heading-cat">
            <div class="row">
              <div class="col">
                <h2 class="text-primary text-uppercase">
                  <span class="va va-smiling-face-with-hearts va-lg"></span> Tops les plus populaires
                  <small class="text-muted">Des 7 derniers jours</small>
                </h2>
              </div>
            </div>
          </div>
        </div>
        <div id="component-swiper-responsive-breakpoints">
          <div class="swiper-responsive-breakpoints swiper-container swiper-0">
            <div class="swiper-wrapper">
              <?php
              $latest_rankings = new WP_Query(
                array(
                  'post_type'              => 'classement',
                  'posts_per_page'         => '-1',
                  'fields'                 => 'ids',
                  'post_status'            => 'publish',
                  'ignore_sticky_posts'    => true,
                  'update_post_meta_cache' => false,
                  'no_found_rows'          => false,
                  'date_query' => array(
                    array(
                      'column' => 'post_date_gmt',
                      'after' => '1 week ago',
                    ),
                  ),
                  'meta_query' => array(
                    array(
                      'key' => 'done_r',
                      'value' => 'done',
                      'compare' => '=',
                    )
                  )
                )
              );
              $best_tops = best_tops($latest_rankings);
              foreach (array_slice($best_tops, 0, 20, true) as $top_id => $completed_top_number) :
                $type_top = array();
                $type_top = get_the_terms($top_id, 'type');
                $slug_type_top = array();
                if ($type_top) {
                  foreach ($type_top as $type) {
                    array_push($slug_type_top, $type->slug);
                  }
                }
                if (get_post_status($top_id) == "publish" && !in_array('private', $slug_type_top)) :
                  global $user_tops;
                  $id_top           = $top_id;
                  $top_datas        = get_top_data($id_top);
                  $creator_id       = get_post_field('post_author', $id_top);
                  $creator_info     = get_userdata($creator_id);
                  $creator_pseudo   = $creator_info->nickname;
                  $creator_avatar   = get_avatar_url($creator_id, ['size' => '80', 'force_default' => false]);
                  $list_user_tops   = $user_tops['list_user_tops'];
                  $state            = "";
                  $illu             = get_the_post_thumbnail_url($id_top, 'medium');
                  if (is_home()) {
                    $class        = "swiper-slide";
                  } elseif (is_single()) {
                    $class        = "col-md-12 col-6";
                  } else {
                    $class        = "col-12";
                  }
                  $user_single_top_data = array_search($id_top, array_column($list_user_tops, 'id_top'));
                  if ($user_single_top_data !== false) {
                    $state = $list_user_tops[$user_single_top_data]['state'];
                  } else {
                    $state = "todo";
                  }
                  $get_top_type = get_the_terms($id_top, 'type');
                  if ($get_top_type) {
                    foreach ($get_top_type as $type_top) {
                      $type_top = $type_top->slug;
                    }
                  }
              ?>
                  <div class="<?php echo $class; ?>">
                    <div class="min-tournoi card scaler">
                      <div class="cov-illu cover" style="background: url(<?php echo $illu; ?>) center center no-repeat">
                        <?php if ($type_top == "sponso") : ?>
                          <span class="badge badge-light-rose ml-0">Top sponso</span>
                        <?php endif; ?>
                        <?php if ($state == "done") : ?>
                          <div class="badge badge-success">Terminé</div>
                        <?php elseif ($state == "begin") : ?>
                          <div class="badge badge-warning">En cours</div>
                        <?php else : ?>
                          <div class="badge badge-primary">A faire</div>
                        <?php endif; ?>
                        <div class="voile">
                          <?php if ($state == "done") : ?>
                            <div class="spoun">
                              <h5>Voir mon 🏆</h5>
                            </div>
                          <?php elseif ($state == "begin") : ?>
                            <div class="spoun">
                              <h5>Terminer</h5>
                            </div>
                          <?php else : ?>
                            <div class="spoun">
                              <h5>Faire mon 🏆</h5>
                            </div>
                          <?php endif; ?>
                        </div>
                        <div class="info-top row align-items-center justify-content-center">
                          <div class="info-top-col">
                            <div class="infos-card-t info-card-t-v d-flex align-items-center">
                              <div class="d-flex align-items-center mr-10px">
                                <span class="ico va-high-voltage va va-md"></span>
                              </div>
                              <div class="content-body mt-01">
                                <h4 class="mb-0">
                                  <?php echo $top_datas['nb_votes']; ?>
                                </h4>
                              </div>
                            </div>
                          </div>
                          <div class="info-top-col">
                            <div class="infos-card-t d-flex align-items-center">
                              <div class="d-flex align-items-center mr-10px">
                                <span class="ico va va-trophy va-md"></span>
                              </div>
                              <div class="content-body mt-01">
                                <h4 class="mb-0">
                                  <?php echo $top_datas['nb_completed_top']; ?>
                                </h4>
                              </div>
                            </div>
                          </div>
                          <div class="info-top-col hide-xs">
                            <div class="infos-card-t d-flex align-items-center infos-card-t-c">
                              <div class="avatar-infomore">
                                <a href="<?php the_permalink(218587); ?>?creator_id=<?php echo $creator_id; ?>" target="_blank">
                                  <div class="avatar me-50">
                                    <img src="<?php echo $creator_avatar; ?>" alt="<?php echo $creator_pseudo; ?>" width="38" height="38">
                                  </div>
                                </a>
                              </div>
                              <div class="content-body mt-01">
                                <h4 class="mb-0 link-creator d-flex flex-column text-left">
                                  <span class="text-muted">Créé par</span>
                                  <a href="<?php the_permalink(218587); ?>?creator_id=<?php echo $creator_id; ?>" target="_blank" class="link-to-creator">
                                    <?php echo $creator_pseudo; ?>
                                  </a>
                                </h4>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="card-body eh mb-3-hover">
                        <p class="card-text text-primary">
                          <?php
                          foreach (get_the_terms($id_top, 'categorie') as $cat) {
                            $cat_id     = $cat->term_id;
                            $cat_name   = $cat->name;
                          }
                          ?>
                          TOP <?php echo get_field('count_contenders_t', $id_top); ?> <?php the_field('icone_cat', 'term_' . $cat_id); ?> <?php echo get_the_title($id_top); ?>
                        </p>
                        <h4 class="card-title">
                          <?php the_field('question_t', $id_top); ?>
                        </h4>
                      </div>
                      <a href="<?php the_permalink($id_top); ?>" class="stretched-link"></a>
                    </div>
                  </div>
                <?php endif; ?>

              <?php endforeach;
              wp_reset_query(); ?>
            </div>
            <div class="swiper-button-next swiper-button-next-0"></div>
            <div class="swiper-button-prev swiper-button-prev-0"></div>
          </div>
        </div>
      </section>

      <section id="vkrz-intro">
        <div class="row match-height mt-2">
          <div class="col-md-5">
            <div class="card">
              <div class="card-body">
                <h4 class="card-title">
                  <span class="ico va va-face-with-monocle va-z-20"></span> VAINKEURZ, c'est quoi ?
                </h4>
                <p class="card-text mb-2">
                  C'est clairement le moyen le plus douloureux de classer tout ce que tu préfères <span class="ico va va-woozy-face va-z-20"></span>
                  <br><br>
                  Ici, c'est pas aussi simple qu'une Tier List <span class="ico va va-squinting-face-with-tongue va-z-20"></span> car pas d'égalité possible.
                  <br>
                  Tu vas forcément devoir faire des choix que tu voulais clairement pas avoir à faire <span class="ico va va-face-screaming va-z-20"></span>
                  <br><br>
                  Ensuite, tu pourras comparer tes <span class="ico va va-trophy va-z-20"></span> à ceux de tes amis - si tu en as bien sûr. Et puis si tu n'en pas, <span class="ico va va-hugging-face va-z-20"></span> rejoins notre Discord.
                </p>
                <a href="<?php the_permalink(104853); ?>" class="btn btn-primary waves-effect">
                  Découvrir l'histoire de VAINKEURZ
                </a>
                <div class="mt-10p">
                  <a href="https://discord.gg/w882sUnrhE" class="sociallink btn btn-outline-primary waves-effect mr-10p mt-10p" target="_blank">
                    Discord
                  </a>
                  <a href="https://www.instagram.com/wearevainkeurz/" class="sociallink btn btn-outline-primary waves-effect mr-10p mt-10p" target="_blank">
                    Insta
                  </a>
                  <a href="https://twitter.com/Vainkeurz" class="sociallink btn btn-outline-primary waves-effect mr-10p mt-10p" target="_blank">
                    Twitter
                  </a>
                  <a href="https://www.tiktok.com/@vainkeurz" target="_blank" class="sociallink btn btn-outline-primary waves-effect mt-10p">
                    TikTok
                  </a>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-7">
            <div class="row">
              <?php
              $cat_t = get_terms(array(
                'taxonomy'      => 'categorie',
                'orderby'       => 'count',
                'order'         => 'DESC',
                'hide_empty'    => true,
              ));
              foreach ($cat_t as $cat) : ?>
                <div class="col-6">
                  <div class="card scaler cat-min">
                    <div class="card-header">
                      <div>
                        <h2 class="font-weight-bolder mb-0">
                          <span class="ico2 ">
                            <span>
                              <?php the_field('icone_cat', 'term_' . $cat->term_id); ?>
                            </span>
                          </span> <?php echo $cat->name; ?>
                        </h2>
                      </div>
                      <div class="p-50 m-0 text-primary">
                        <?php echo $cat->count; ?> Tops
                      </div>
                    </div>
                    <a href="<?php echo get_category_link($cat->term_id); ?>" class="stretched-link"></a>
                  </div>
                </div>
              <?php endforeach; ?>
            </div>
          </div>
        </div>
      </section>

      <section class="list-tournois">
        <?php $swip = 1;
        $cat_t = get_terms(array(
          'taxonomy'      => 'categorie',
          'orderby'       => 'count',
          'order'         => 'DESC',
          'hide_empty'    => true,
        ));
        foreach ($cat_t as $cat) : ?>
          <?php
          $tournois_in_cat = new WP_Query(array(
            'post_type' => 'tournoi',
            'post__not_in' => $list_t_already_done,
            'orderby' => 'rand',
            'order' => 'ASC',
            'posts_per_page' => 10,
            'ignore_sticky_posts'    => true,
            'update_post_meta_cache' => false,
            'no_found_rows'          => true,
            'tax_query' => array(
              'relation' => 'AND',
              array(
                'taxonomy' => 'categorie',
                'field'    => 'term_id',
                'terms'    => $cat->term_id,
              ),
              array(
                'taxonomy' => 'type',
                'field'    => 'slug',
                'terms'    => array('private', 'whitelabel', 'onboarding'),
                'operator' => 'NOT IN'
              ),
            ),
          ));
          if ($tournois_in_cat->have_posts()) : ?>
            <div class="big-cat">
              <div class="heading-cat">
                <div class="row">
                  <div class="col">
                    <h2 class="text-primary text-uppercase">
                      <a href="<?php echo get_category_link($cat->term_id); ?>">
                        <?php the_field('icone_cat', 'term_' . $cat->term_id); ?> <?php echo $cat->name; ?>
                        <small class="text-muted"><?php echo $cat->description; ?></small>
                      </a>
                    </h2>
                  </div>
                </div>
              </div>
            </div>
            <div id="component-swiper-responsive-breakpoints">
              <div class="swiper-responsive-breakpoints swiper-container swiper-<?php echo $swip; ?>">
                <div class="swiper-wrapper">
                  <?php
                  while ($tournois_in_cat->have_posts()) : $tournois_in_cat->the_post(); ?>

                    <?php get_template_part('partials/min-t'); ?>

                  <?php endwhile; ?>
                </div>
                <?php if ($cat->count > 2) : ?>
                  <div class="swiper-button-next swiper-button-next-<?php echo $swip; ?>"></div>
                  <div class="swiper-button-prev swiper-button-prev-<?php echo $swip; ?>"></div>
                <?php endif; ?>
              </div>
            </div>
        <?php endif;
          $swip++;
        endforeach; ?>
      </section>
    </div>
  </div>
</div>
<!-- END: Content-->

<?php get_footer(); ?>