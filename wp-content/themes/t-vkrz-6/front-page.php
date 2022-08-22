<?php
global $user_tops;
global $list_user_tops;
global $list_user_tops_begin;
global $id_vainkeur;
get_header();
if ($id_vainkeur) {
  if (is_user_logged_in() && env() != "local") {
    if (false === ($user_tops = get_transient('user_' . $user_id . '_get_user_tops'))) {
      $user_tops = get_user_tops($id_vainkeur);
      set_transient('user_' . $user_id . '_get_user_tops', $user_tops, DAY_IN_SECONDS);
    } else {
      $user_tops = get_transient('user_' . $user_id . '_get_user_tops');
    }
  } else {
    $user_tops  = get_user_tops($id_vainkeur);
  }
  $list_user_tops         = $user_tops['list_user_tops_done_ids'];
  $list_user_tops_begin   = $user_tops['list_user_tops_begin_ids'];
} else {
  $user_tops            = array();
  $list_user_tops       = array();
  $list_user_tops_begin = array();
}
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
        <form action="<?= the_permalink(get_page_by_path('rechercher')); ?>" method="GET" class="mt-2 d-flex rechercher-form" autocomplete="off">
          <input type="search" name="term" id="term" class="form-control rechercher-input" placeholder="Rechercher..." minlength="3" required>
          <button type="submit" class="form-control lead go-input">
            <span class="ico ico-search va va-loupe va-lg"></span>
          </button>
        </form>
      </div>

      <?php
      $tops_vedette      = new WP_Query(array(
        'ignore_sticky_posts'    => true,
        'update_post_meta_cache' => false,
        'no_found_rows'          => true,
        'post_type'              => 'tournoi',
        'orderby'                => 'date',
        'post__not_in'           => $list_user_tops,
        'order'                  => 'DESC',
        'posts_per_page'         => 10,
        'meta_query' => array(
          array(
            'key'       => 'vedette_t',
            'value'     => '1',
            'compare'   => '=',
          )
        ),
        'tax_query' => array(
          array(
            'taxonomy' => 'type',
            'field'    => 'slug',
            'terms'    => array('private', 'whitelabel', 'onboarding'),
            'operator' => 'NOT IN'
          ),
        ),
      ));
      if ($tops_vedette->have_posts()) : ?>
        <section class="list-tournois">
          <div class="big-cat">
            <div class="heading-cat">
              <div class="row">
                <div class="col">
                  <h2 class="text-primary text-uppercase">
                    <span class="va va-barber va-lg"></span> Tops en vedette
                    <small class="text-muted">Sélectionnés par notre ékip <span class="va va-lama va-z-15"></span><span class="va va-keurz va-z-15"></span></small>
                  </h2>
                </div>
              </div>
            </div>
          </div>
          <div id="component-swiper-responsive-breakpoints">
            <div class="swiper-responsive-breakpoints swiper-container swiper-0">
              <div class="swiper-wrapper">
                <?php while ($tops_vedette->have_posts()) : $tops_vedette->the_post(); ?>

                  <?php get_template_part('partials/min-t'); ?>

                <?php endwhile; ?>
              </div>
              <div class="swiper-button-next swiper-button-next-0"></div>
              <div class="swiper-button-prev swiper-button-prev-0"></div>
            </div>
          </div>
        </section>
      <?php endif; ?>

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
                'post__not_in'           => $list_user_tops,
                'orderby'                => 'date',
                'order'                  => 'DESC',
                'posts_per_page'         => 10,
                'meta_query' => array(
                  'relation' => 'OR',
                  array(
                    'key'       => 'vedette_t',
                    'value'     => '1',
                    'compare'   => '!=',
                  ),
                  array(
                    'key'       => 'vedette_t',
                    'compare'   => 'NOT EXISTS',
                  )
                ),
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

      <section id="vkrz-intro">
        <div class="row match-height mt-2">
          <div class="col-md-5">
            <div class="card">
              <div class="card-body">
                <h4 class="card-title">
                  <span class="ico va va-monocle va-z-20"></span> VAINKEURZ, c'est quoi ?
                </h4>
                <p class="card-text mb-2">
                  C'est clairement le moyen le plus douloureux de classer tout ce que tu préfères <span class="ico va va-woozy-face va-z-20"></span>
                  <br><br>
                  Ici, c'est pas aussi simple qu'une Tier List <span class="ico va va-squinting-face-with-tongue va-z-20"></span> car pas d'égalité possible.
                  <br>
                  Tu vas forcément devoir faire des choix que tu voulais clairement pas avoir à faire <span class="ico va va-face-screaming va-z-20"></span> C'est le principe des TopList !
                  <br><br>
                  Ensuite, tu pourras comparer tes TopList<span class="ico va va-trophy va-z-20"></span> à ceux de tes amis - si tu en as bien sûr. Et puis si tu n'en pas, <span class="ico va va-hugging-face va-z-20"></span> rejoins notre Discord.
                </p>
                <a href="<?php the_permalink(104853); ?>" class="btn btn-primary waves-effect">
                  Découvre l'histoire incroyable de VAINKEURZ
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
          <div class="col-md-3">
            <div class="card">
              <div class="card-body">
                <h4 class="card-title">
                  <span class="ico va va-dodo va-z-20"></span> Qui est le dodo ?
                </h4>
                <p class="card-text text-muted mb-2 text-center">
                  <span class="va va-clapping va-z-20"></span> au vainkeur le plus <span class="va va-fire va-z-15"></span> des <span class="va va-seven va-z-15"></span> derniers jours
                </p>
                <div class="dodo-box">
                  <div class="d-flex align-items-center flex-column">
                    <div class="dodo-user">
                      <div class="vainkeur-card">
                        <?php $info_dodo = get_user_infos(get_field('uuid_dodo', 'options')); ?>
                        <a href="<?php echo esc_url(get_author_posts_url($info_dodo['id_user'])); ?>" class="btn btn-outline-primary btn-flat-primary waves-effect">
                          <span class="avatar">
                            <span class="avatar-picture" style="background-image: url(<?php echo $info_dodo['avatar']; ?>);"></span>
                          </span>
                          <span class="championname">
                            <h4><?php echo $info_dodo['pseudo']; ?></h4>
                            <span class="medailles">
                              <?php echo $info_dodo['level']; ?>
                              <?php if ($info_dodo['user_role'] == "administrator") : ?>
                                <span class="va va-vkrzteam va-z-15" data-toggle="tooltip" data-placement="top" title="" data-original-title="TeamVKRZ"></span>
                              <?php endif; ?>
                              <?php if ($info_dodo['user_role'] == "administrator" || $info_dodo['user_role'] == "author") : ?>
                                <span class="va va-man-singer va-z-15" data-toggle="tooltip" data-placement="top" title="" data-original-title="Créateur de Tops"></span>
                              <?php endif; ?>
                            </span>
                          </span>
                        </a>
                      </div>
                    </div>
                    <div class="dodo-score text-center mt-1 mb-2">
                      avec <span class="t-rose"><?php the_field('nb_votes_dodo', 'options'); ?></span> votes <span class="va va-high-voltage va-z-15"></span>
                      & <span class="t-rose"><?php the_field('nb_tops_dodo', 'options'); ?></span> TopList <span class="va va-trophy va-z-15"></span>
                    </div>
                    <div class="separate-top">
                      <a href="<?php the_permalink(get_page_by_path('best-of/best-vainkeurs')); ?>" class="btn btn-flat-dark waves-effect">
                        <small>Découvre le classement ALL Time des vainkeurs les plus <span class="va va-fire va-z-15"></span></small>
                      </a>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="card">
              <div class="card-body">
                <h4 class="card-title">
                  <span class="ico va va-spiral-eyes va-z-20"></span> En panne d'inspi
                </h4>
                <p class="card-text text-muted mb-2">
                  On te propose 3 Top au hasard !
                </p>
                <a href="<?php the_permalink(470569); ?>" class="btn btn-outline-primary btn-flat-primary waves-effect">
                  Let's go
                </a>
              </div>
            </div>
          </div>
          <div class="col-md-4">
            <div class="row">
              <?php
              $cat_t = get_terms(array(
                'taxonomy'      => 'categorie',
                'orderby'       => 'count',
                'order'         => 'DESC',
                'hide_empty'    => true,
              ));
              foreach ($cat_t as $cat) : ?>
                <div class="col-12">
                  <div class="card scaler cat-min">
                    <div class="card-header">
                      <div>
                        <h4 class="font-weight-bolder mb-0">
                          <span class="ico2 ">
                            <span>
                              <?php the_field('icone_cat', 'term_' . $cat->term_id); ?>
                            </span>
                          </span> <?php echo $cat->name; ?>
                        </h4>
                      </div>
                      <div class="p-50 m-0 text-primary nb-top-in-cat">
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
            'post__not_in' => $list_user_tops,
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