<?php
global $user_tops;
global $list_user_tops;
global $list_user_tops_begin;
global $id_vainkeur;
get_header();
if ($id_vainkeur) {
  
    $user_tops  = get_user_tops($id_vainkeur);
  
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
        <form action="<?= the_permalink(get_page_by_path('recherche')); ?>" method="GET" class="d-flex rechercher-form" autocomplete="off">
          <input type="search" name="term" id="term" class="form-control rechercher-input" placeholder="Rechercher..." required oninvalid="this.setCustomValidity('Son goku par exemple..')">
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
                'post__not_in'           => $list_user_tops,
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