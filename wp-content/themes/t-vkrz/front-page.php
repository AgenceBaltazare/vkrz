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
      <div class="col-md-3 col-12">
        <div class="bloc">
          <h3 class="titre-section">
            C'est koi une <span class="t-rose">TopList</span> <i class="va va-monocle va-z-20"></i>
          </h3>
          <div class="content-box">
            <p>
              C'est clairement le moyen le plus douloureux de classer tout ce que tu préfères et ça ressemble à ça 👇
            </p>
            <img src="https://bltzr.fr/vkrz.gif" alt="" class="img-fluid rounded">
          </div>
        </div>
        <div class="bloc text-center d-block d-sm-none">
          <h3 class="titre-section">
            <span class="va va-wrapped-gift va-lg"></span> Sponso du moment <span class="va va-wrapped-gift va-lg"></span>
          </h3>
          <div class="content-box">
            <div class="row">
              <?php
              $tops_vedette      = new WP_Query(array(
                'ignore_sticky_posts'    => true,
                'update_post_meta_cache' => false,
                'no_found_rows'          => true,
                'post_type'              => 'tournoi',
                'orderby'                => 'date',
                'order'                  => 'DESC',
                'posts_per_page'         => 2,
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
                  <div class="col-md-6">
                    <?php get_template_part('partials/min-t'); ?>
                  </div>
                <?php endwhile; ?>
              <?php endif; ?>
            </div>
          </div>
        </div>
        <div class="bloc">
          <h3 class="titre-section">
            Interview TopList <i class="va va-micro va-z-20"></i>
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
              <a href="#" data-bs-toggle="modal" data-bs-target="#toplist-<?php the_ID(); ?>" data-bs-target="#toplist-<?php the_ID(); ?>">
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
      </div>
      <div class="col-md-8 col-12 offset-md-1">
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
    <div class="row">
      <div class="col-md-6  d-none d-sm-block">
        <div class="bloc text-center">
          <h3 class="titre-section">
            <span class="va va-wrapped-gift va-lg"></span> Sponso du moment <span class="va va-wrapped-gift va-lg"></span>
          </h3>
          <div class="content-box">
            <div class="row">
              <?php
              $tops_vedette      = new WP_Query(array(
                'ignore_sticky_posts'    => true,
                'update_post_meta_cache' => false,
                'no_found_rows'          => true,
                'post_type'              => 'tournoi',
                'orderby'                => 'date',
                'order'                  => 'DESC',
                'posts_per_page'         => 2,
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
                  <div class="col-md-6">
                    <?php get_template_part('partials/min-t'); ?>
                  </div>
                <?php endwhile; ?>
              <?php endif; ?>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-6">
        <div class="row">
          <div class="col-md-6">
            <div class="bloc text-center">
              <h3 class="titre-section">
                Qui est le <i class="va va-dodo va-z-20"></i> ?
              </h3>
              <div class="card">
                <div class="card-body">
                  <p class="card-text text-muted mb-2 text-center">
                    GG au vainkeur le plus <span class="va va-fire va-z-15"></span> des <span class="va va-seven va-z-15"></span> derniers jours
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
                                  <span class="va va-vkrzteam va-z-15" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-bs-original-title="TeamVKRZ"></span>
                                <?php endif; ?>
                                <?php if ($info_dodo['user_role'] == "administrator" || $info_dodo['user_role'] == "author") : ?>
                                  <span class="va va-man-singer va-z-15" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-bs-original-title="Créateur de Tops"></span>
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
            </div>
            <div class="bloc text-center">
              <h3 class="titre-section">
                <i class="va va-spiral-eyes va-z-20"></i> Panne d'inspi
              </h3>
              <div class="card">
                <div class="card-body">
                  <p class="card-text text-muted mb-2">
                    On te propose <i class="va va-keycap-digit-three va-z-15"></i> Tops au hasard !
                  </p>
                  <a href="<?php the_permalink(470569); ?>" class="btn btn-outline-primary btn-flat-primary waves-effect">
                    Let's go
                  </a>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="bloc text-center">
              <h3 class="titre-section">
                Dernières TopList <i class="va va-trophy va-z-20"></i>
              </h3>
              <div class="list-toplist-home">
                <?php
                $lasttoplist  = new WP_Query(array(
                  'ignore_sticky_posts'       => true,
                  'update_post_meta_cache'    => false,
                  'no_found_rows'             => true,
                  'post_type'                 => 'classement',
                  'orderby'                   => 'date',
                  'order'                     => 'DESC',
                  'posts_per_page'            => 3,
                ));
                while ($lasttoplist->have_posts()) : $lasttoplist->the_post();
                  global $vainkeur_data_selected;
                  $uuiduser                = get_field('uuid_user_r', $id_ranking);
                  $top_id                  = get_field('id_tournoi_r', $id_ranking);
                  $vainkeur_data_selected  = get_user_infos($uuiduser);
                  $top_cover               = wp_get_attachment_image_src(get_field('cover_t', $top_id), 'large');
                ?>
                  <div class="toplist-min">
                    <div class="toplist-min-header">
                      <div class="toplist-min-ranking">
                        <h6>
                          <?php echo get_the_title($top_id); ?>
                          <br>
                          <span class="t-violet">
                            <?php the_field('question_t', $top_id); ?>
                          </span>
                        </h6>
                        <div class="list-unstyled m-0 d-flex align-items-center avatar-group list-contenders">
                          <?php
                          $user_top3 = get_user_ranking($id_ranking);
                          $l = 1;
                          foreach ($user_top3 as $top) :
                          ?>
                            <li data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-custom-class="tooltip-danger" data-bs-placement="top" class="avatar pull-up" aria-label="<?php echo get_the_title($top); ?>" data-bs-original-title="<?php echo get_the_title($top); ?>">
                              <?php if (get_field('visuel_instagram_contender', $top)) : ?>
                                <img src="<?php the_field('visuel_instagram_contender', $top); ?>" alt="<?php echo get_the_title($top); ?>" height="32" width="32">
                              <?php else : ?>
                                <?php $illu = get_the_post_thumbnail_url($top, 'thumbnail'); ?>
                                <img src="<?php echo $illu; ?>" alt="<?php echo get_the_title($top); ?>" height="32" width="32">
                              <?php endif; ?>
                            </li>
                          <?php $l++;
                          endforeach; ?>
                        </div>
                      </div>
                    </div>
                    <div class="toplist-min-footer">
                      <div class="toplist-min-vainkeur">
                        <?php get_template_part('partials/vainkeur-card'); ?>
                      </div>
                      <div class="juger-min">
                        <a href="<?php the_permalink($id_ranking); ?>#juger" class="btn btn-flat-secondary waves-effect">
                          <i class="va va-hache va-lg"></i>
                          Juger
                        </a>
                      </div>
                    </div>
                    <div class="voilecover" style="background-image: url(<?php echo $top_cover[0]; ?>);"></div>
                  </div>
                <?php endwhile;
                wp_reset_query(); ?>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="row mt-3">
      <?php
      $cat_t = get_terms(array(
        'taxonomy'      => 'categorie',
        'orderby'       => 'count',
        'order'         => 'DESC',
        'hide_empty'    => true,
      ));
      foreach ($cat_t as $cat) : ?>
        <div class="col-3 col-sm-4 col-6">
          <div class="card scaler cat-min">
            <div class="card-header d-flex align-items-center justify-content-between">
              <div>
                <h4 class="font-weight-bolder mb-0">
                  <span class="ico2 ">
                    <span>
                      <?php the_field('icone_cat', 'term_' . $cat->term_id); ?>
                    </span>
                  </span>
                  <?php echo $cat->name; ?>
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
<?php get_footer(); ?>