<?php
global $user_tops;
global $list_user_tops;
global $list_user_tops_begin;
global $id_vainkeur;
$id_home = get_the_ID();
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
$live_vedette     = get_field('twitch_home', $id_home);
$live_vedette     = $live_vedette[0];
$youtube_vedette  = get_field('youtube_home', $id_home);
$youtube_vedette  = $youtube_vedette[0];
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
          <?php
          $toplist_interview = new WP_Query(array(
            'ignore_sticky_posts'     => true,
            'update_post_meta_cache'  => false,
            'no_found_rows'           => true,
            'post_type'               => 'commu',
            'orderby'                 => 'date',
            'order'                   => 'DESC',
            'posts_per_page'          => 1,
            'meta_query' => array(
              array(
                'key'     => 'plateforme_commu',
                'value'   => 'toplist',
                'compare' => '=',
              ),
            ),
          ));
          while ($toplist_interview->have_posts()) : $toplist_interview->the_post(); ?>
            <div class="content-box">
              <a href="#" data-bs-toggle="modal" data-bs-target="#toplist-<?php the_ID(); ?>">
                <?php
                if (has_post_thumbnail()) {
                  the_post_thumbnail('large', array('class' => 'img-fluid rounded', 'alt' => get_the_title()));
                }
                ?>
              </a>
            </div>
            <!-- Modal -->
            <div class="modal fade" id="toplist-<?php the_ID(); ?>" tabindex="-1" aria-hidden="true">
              <div class="modal-dialog modal-fullscreen" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="modalFullTitle">
                      <?php the_title(); ?>
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">
                    <div class="modal-iframe">
                      <?php the_field('video_video_commu'); ?>
                    </div>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Fermer</button>
                    <!--<button type="button" class="btn btn-primary">Voir toutes les interviews</button>-->
                  </div>
                </div>
              </div>
            </div>
          <?php endwhile;
          wp_reset_query(); ?>
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
                <a href="#" class="lauch_embed" data-bs-toggle="modal" data-bs-target="#vedette-<?php echo $live_vedette; ?>">
                  <?php
                  $cover      = get_the_post_thumbnail_url($live_vedette, 'large');
                  $id_membre  = get_field('selection_du_streamer_commu', $live_vedette);
                  ?>
                  <img src="<?php echo $cover; ?>" alt="" class="img-fluid rounded">
                  <div class="play">
                    <img src="<?php bloginfo('template_directory'); ?>/assets/images/emojis/play.png">
                  </div>
                  <div class="caption-frame">
                    <ul>
                      <li>
                        <h4>
                          <?php echo get_the_title($live_vedette); ?>
                          <br>
                          <?php echo get_userdata($id_membre[0])->twitch_user; ?>
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
                        <a href="<?php echo get_userdata($id_membre[0])->tiktok_user; ?>" class="btn">
                          <i class="fab fa-tiktok"></i>
                        </a>
                      </li>
                    </ul>
                  </div>
                </a>
                <!-- Modal -->
                <div class="modal fade" id="vedette-<?php echo $live_vedette; ?>" tabindex="-1" aria-hidden="true">
                  <div class="modal-dialog modal-fullscreen" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="modalFullTitle">
                          <?php the_title(); ?>
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                      </div>
                      <div class="modal-body">
                        <div class="modal-iframe">
                          <?php the_field('video_video_commu', $live_vedette); ?>
                        </div>
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Fermer</button>
                        <!--<button type="button" class="btn btn-primary">Voir toutes les interviews</button>-->
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