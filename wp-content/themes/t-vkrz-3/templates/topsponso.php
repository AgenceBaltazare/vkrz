<?php /* Template Name: Tops sponso */ ?>

<?php
get_header();
global $user_tops;
$list_user_tops     = $user_tops['list_user_tops'];
$tops_in_cat        = new WP_Query(array(
  'post_type'                 => 'tournoi',
  'orderby'                   => 'date',
  'order'                     => 'DESC',
  'posts_per_page'            => -1,
  'ignore_sticky_posts'       => true,
  'update_post_meta_cache'    => false,
  'no_found_rows'             => true,
  'tax_query'                 => array(
    'relation' => 'AND',
    array(
      'taxonomy' => 'type',
      'field'    => 'slug',
      'terms'    => array('sponso'),
      'operator' => 'IN'
    ),
    array(
      'taxonomy' => 'type',
      'field'    => 'slug',
      'terms'    => array('private'),
      'operator' => 'NOT IN'
    ),
  ),
));
?>
<div class="app-content content ecommerce-application">
  <div class="content-overlay"></div>
  <div class="content-wrapper">
    <div class="content-body">

      <div class="intro-mobile">
        <div class="tournament-heading text-center">
          <h3 class="mb-0 t-titre-tournoi">
            <span class="ico va va-wrapped-gift va-lg"></span> Tops sponso
          </h3>
          <h4 class="mb-0">
            Ici on ne gagne pas à tous les coups - certes - mais on se donne une chance 🤞
          </h4>
        </div>
      </div>

      <section class="grid-to-filtre row match-height mt-2">

        <?php $i = 1;
        while ($tops_in_cat->have_posts()) : $tops_in_cat->the_post(); ?>

          <?php
          $id_top             = get_the_ID();
          $illu               = get_the_post_thumbnail_url($id_top, 'medium');
          $top_datas          = get_top_data($id_top);
          $creator_id         = get_post_field('post_author', $id_top);
          $creator_uuiduser   = get_field('uuiduser_user', 'user_' . $creator_id);
          $creator_data       = get_user_infos($creator_uuiduser);
          $user_sinle_top_data = array_search($id_top, array_column($list_user_tops, 'id_top'));
          if ($user_sinle_top_data !== false) {
            $state = $list_user_tops[$user_sinle_top_data]['state'];
          } else {
            $state = "todo";
          }
          $top_question   = get_field('question_t', $id_top);
          $top_title      = get_the_title($id_top);
          $term_to_search = $sujet_slug . " " . $concept_slug . " " . $top_question . " " . $top_title;
          $get_top_type = get_the_terms($id_top, 'type');
          foreach ($get_top_type as $type_top) {
            $type_top = $type_top->slug;
          }
          ?>

          <div class="same-h grid-item  col-12 col-md-4">
            <div class="min-tournoi card scaler" style="position: relative;">
              <div class="cov-illu cover" style="background: url(<?php echo $illu; ?>) center center no-repeat; height: 200px;">

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
                      <h5>Participer</h5>
                    </div>
                  <?php elseif ($state == "begin") : ?>
                    <div class="spoun">
                      <h5>Terminer</h5>
                    </div>
                  <?php else : ?>
                    <div class="spoun">
                      <h5>Participer</h5>
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
                </div>
              </div>

              <div class="card-body mb-3-hover">
                <p class="card-text text-primary font-weight-bold">
                  TOP <?= get_field('count_contenders_t', $id_top); ?> ⚡ <span class="namecontenders"><?= $top_title; ?></span>
                </p>

                <h3 class="card-title t-rose">
                  <?= $top_question; ?>
                </h3>

                <div class="card-footer a-gagner mt-1 p-1 d-flex flex-column align-items-left justify-content-between">
                  <span class="text-muted mb-1 d-block">À gagner</span>

                  <div style="background: url(<?= wp_get_attachment_image_url(get_field('cadeau_t_sponso', $id_top), 'large', false); ?>) no-repeat center center / contain; height: 150px;">
                  </div>

                  <h2 class="mt-2"><?= the_field('titre_de_la_sponso_t_sponso', $id_top); ?></h2>

                  <small class="text-primary" style="margin-top: -5px;">
                    <?= the_field('fin_de_la_sponso_t_sponso', $id_top); ?>
                  </small>
                </div>
                <a href="<?php the_permalink($id_top); ?>" class="stretched-link"></a>
              </div>
            </div>
          </div>

        <?php $i++;
        endwhile; ?>
      </section>

    </div>
  </div>
</div>
<?php get_footer(); ?>