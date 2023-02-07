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
<div class="my-3">
  <div class="container-xxl">
    <div class="row">
      <div class="col-3">
        <div class="bloc">
          <h3 class="titre-section">
            C'est koi une <span class="t-rose">TopList</span> ?
          </h3>
          <div class="content-box">
            <p>
              C'est clairement le moyen le plus douloureux de classer tout ce que tu préfères et ça ressemble à ça 👇
            </p>
            <img src="https://bltzr.fr/vkrz.gif" alt="" class="img-fluid rounded">
          </div>
        </div>
        <div class="bloc">
          <h3 class="titre-section">
            Dernière Interview TopList
          </h3>
          <div class="content-box">
            <a href="">
              <img src="<?php bloginfo('template_directory'); ?>/assets/images/events/toplist.png" class="img-fluid rounded" alt="">
            </a>
          </div>
        </div>
        <div class="bloc">
          <h3 class="titre-section">
            Sponso du moment <span class="va va-barber va-lg"></span>
          </h3>
          <div class="content-box">
            <?php
            $tops_vedette      = new WP_Query(array(
              'ignore_sticky_posts'    => true,
              'update_post_meta_cache' => false,
              'no_found_rows'          => true,
              'post_type'              => 'tournoi',
              'orderby'                => 'date',
              'order'                  => 'DESC',
              'posts_per_page'         => 1,
              'tax_query' => array(
                array(
                  'taxonomy' => 'type',
                  'field'    => 'slug',
                  'terms'    => array('sponso'),
                  'operator' => 'IN'
                ),
              ),
            ));
            if ($tops_vedette->have_posts()) : ?>
              <?php while ($tops_vedette->have_posts()) : $tops_vedette->the_post(); ?>
                <?php get_template_part('partials/min-t'); ?>
              <?php endwhile; ?>
            <?php endif; ?>
          </div>
        </div>
      </div>
      <div class="col-8 offset-md-1">
        <div class="row">
          <div class="col-md-6">
            <div class="bloc">
              <h3 class="titre-section">
                C'était en live Twitch !
              </h3>
              <div class="post-frame">
                <div class="lauch_embed" data-modal="frame1">
                  <img src="<?php bloginfo('template_directory'); ?>/assets/images/events/drey.png" class="img-fluid rounded" alt="">
                  <div class="play">
                    <img src="<?php bloginfo('template_directory'); ?>/assets/images/emojis/play.png">
                  </div>
                  <div class="caption-frame">
                    <ul>
                      <li>
                        <h4>
                          Drey
                        </h4>
                      </li>
                      <li>
                        <a href="" class="btn">
                          <i class="fab fa-instagram"></i>
                        </a>
                      </li>
                      <li>
                        <a href="" class="btn">
                          <i class="fab fa-instagram"></i>
                        </a>
                      </li>
                      <li>
                        <a href="" class="btn">
                          <i class="fab fa-tiktok"></i>
                        </a>
                      </li>
                    </ul>
                  </div>
                </div>
                <div class="modal-video hide" id="frame1">
                  <div class="container-xxl">
                    <div class="row">
                      <div class="col">
                        <div style="width:100%;height:0px;position:relative;padding-bottom:56.250%;">
                          <iframe src="https://streamable.com/e/14mxdn" frameborder="0" width="100%" height="100%" allowfullscreen style="width:100%;height:100%;position:absolute;left:0px;top:0px;overflow:hidden;"></iframe>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="bloc">
              <h3 class="titre-section">
                Sur Youtube
              </h3>
              <div class="post-frame">
                <div class="lauch_embed" data-modal="frame1">
                  <img src="<?php bloginfo('template_directory'); ?>/assets/images/events/fletch.png" class="img-fluid rounded" alt="">
                  <div class="play">
                    <img src="<?php bloginfo('template_directory'); ?>/assets/images/emojis/play.png">
                  </div>
                </div>
              </div>
              <div class="caption-frame">
                <ul>
                  <li>
                    <h4>
                      Fletch
                    </h4>
                  </li>
                  <li>
                    <a href="" class="btn">
                      <i class="fab fa-instagram"></i>
                    </a>
                  </li>
                  <li>
                    <a href="" class="btn">
                      <i class="fab fa-instagram"></i>
                    </a>
                  </li>
                  <li>
                    <a href="" class="btn">
                      <i class="fab fa-tiktok"></i>
                    </a>
                  </li>
                </ul>
              </div>
            </div>
          </div>
        </div>
        <div class="bloc">
          <?php
          $tops_vedette      = new WP_Query(array(
            'ignore_sticky_posts'    => true,
            'update_post_meta_cache' => false,
            'no_found_rows'          => true,
            'post_type'              => 'tournoi',
            'orderby'                => 'date',
            'post__not_in'           => $list_user_tops,
            'order'                  => 'DESC',
            'posts_per_page'         => 6,
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
            <section class="list-vedette">
              <div class="text-center">
                <h3 class="titre-section">
                  <span class="va va-barber va-lg"></span> Quelques Tops en vedette
                </h3>
              </div>
              <div class="row">
                <?php while ($tops_vedette->have_posts()) : $tops_vedette->the_post(); ?>
                  <div class="col-md-4">
                    <?php get_template_part('partials/min-t'); ?>
                  </div>
                <?php endwhile; ?>
              </div>
            </section>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </div>
</div>

<?php get_footer(); ?>