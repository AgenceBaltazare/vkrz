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
global $commu_id;
global $cover_commu;
global $id_membre;
?>
<div class="my-3">
  <div class="container-xxl">
    <div class="row">
      <div class="col-md-3 col">
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
            <div class="content-box d-flex justify-content-center align-items-center">
              <a href="#" data-bs-toggle="modal" data-bs-target="#toplist-<?php the_ID(); ?>" data-target="#toplist-<?php the_ID(); ?>">
                <?php
                if (has_post_thumbnail()) {
                  the_post_thumbnail('large', array('class' => 'img-fluid rounded', 'alt' => get_the_title()));
                }
                ?>
              </a>
            </div>
            <!-- Modal -->
            <div class="modal modal-transparent fade" id="toplist-<?php the_ID(); ?>" tabindex="-1" aria-hidden="true">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-body">
                    <a href="javascript:void(0);" class="btn-close text-white" data-bs-dismiss="modal" aria-label="Close">
                    </a>
                    <div class="modal-iframe">
                      <p class="text-white text-large fw-bold mb-3 text-center"><?php the_title() ?></p>
                      <?php the_field('video_video_commu'); ?>
                    </div>
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
      <div class="col-md-8 col offset-md-1">
        <div class="row">
          <div class="col-md-6">
            <div class="bloc">
              <h3 class="titre-section">
                C'était en live Twitch !
              </h3>
              <?php
              $commu_id     = get_field('twitch_home', $id_home);
              $commu_id     = $commu_id[0];
              get_template_part('partials/commu');
              ?>
            </div>
          </div>
          <div class="col-md-6">
            <div class="bloc">
              <h3 class="titre-section">
                Sur Youtube
              </h3>
              <?php
              $commu_id     = get_field('youtube_home', $id_home);
              $commu_id     = $commu_id[0];
              get_template_part('partials/commu');
              ?>
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

<?php 

    // echo "<h1 style='text-align:center;'>" . get_current_user_id() . "</h1>";

?>

<?php get_footer(); ?>