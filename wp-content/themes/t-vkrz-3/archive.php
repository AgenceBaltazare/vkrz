<?php
get_header();

if (isset($_GET['term']) && $_GET['term'] != "") {
  $term_to_search = $_GET['term'];
} else {
  $term_to_search = '';
}

global $user_tops;
$list_user_tops     = $user_tops['list_user_tops'];
$current_cat        = get_queried_object();
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
      'taxonomy' => $current_cat->taxonomy,
      'field'    => 'term_id',
      'terms'    => $current_cat->term_taxonomy_id,
    ),
    array(
      'taxonomy' => 'type',
      'field'    => 'slug',
      'terms'    => array('private', 'whitelabel', 'onboarding'),
      'operator' => 'NOT IN'
    ),
  ),
  's' => $term_to_search,
));
$list_tops = array();
while ($tops_in_cat->have_posts()) : $tops_in_cat->the_post();
  array_push($list_tops, get_the_ID());
endwhile;

$contenders_to_find = new WP_Query(array(
  'post_type'                 => 'contender',
  'posts_per_page'            => -1,
  'ignore_sticky_posts'       => true,
  'update_post_meta_cache'    => false,
  'no_found_rows'             => true,
  's'                         => $term_to_search,
  'tax_query'                 => array(
    array(
      'taxonomy' => $current_cat->taxonomy,
      'field'    => 'term_id',
      'terms'    => $current_cat->term_taxonomy_id,
    )
  ),
));
while ($contenders_to_find->have_posts()) : $contenders_to_find->the_post();
  array_push($list_tops, get_field('id_tournoi_c'));
endwhile;

$list_tops_unique = array_unique($list_tops);

if (!empty($list_tops_unique)) {
  $tops_unique_to_find = new WP_Query(array(
    'post_type'                 => 'tournoi',
    'posts_per_page'            => -1,
    'ignore_sticky_posts'       => true,
    'update_post_meta_cache'    => false,
    'no_found_rows'             => true,
    'post__in'                  => $list_tops_unique,
    'tax_query'                 => array(
      'relation' => 'AND',
      array(
        'taxonomy' => $current_cat->taxonomy,
        'field'    => 'term_id',
        'terms'    => $current_cat->term_taxonomy_id,
      ),
      array(
        'taxonomy' => 'type',
        'field'    => 'slug',
        'terms'    => array('private', 'whitelabel', 'onboarding'),
        'operator' => 'NOT IN'
      ),
    ),
  ));
}
global $total_top_founded;
if (!empty($tops_unique_to_find)) {
  $total_top_founded = $tops_unique_to_find->post_count;
}
?>
<div class="app-content content">
  <div class="content-wrapper">
    <div class="content-body">

      <div class="intro-mobile">
        <div class="tournament-heading text-center">
          <h3 class="mb-0 t-titre-tournoi">
            <?php the_field('icone_cat', 'term_' . $current_cat->term_id); ?> <?php echo $current_cat->name; ?>
          </h3>
          <h4 class="mb-0">
            <?php echo $current_cat->description; ?>
          </h4>
        </div>
      </div>

      <?php if (!empty($list_tops_unique)) : ?>
        <section class="grid-to-filtre row match-height mt-2 tournois">

          <?php $i = 1;
          while ($tops_unique_to_find->have_posts()) : $tops_unique_to_find->the_post();
            $id_top             = get_the_ID();
            $illu               = get_the_post_thumbnail_url($id_top, 'medium');
            $id_top             = get_the_ID();
            $top_datas          = get_top_data($id_top);
            $creator_id       = get_post_field('post_author', $id_top);
            $creator_info     = get_userdata($creator_id);
            $creator_pseudo   = $creator_info->nickname;
            $creator_avatar   = get_avatar_url($creator_id, ['size' => '80', 'force_default' => false]);
            $list_user_tops   = $user_tops['list_user_tops'];
            $user_single_top_data = array_search($id_top, array_column($list_user_tops, 'id_top'));
            if ($user_single_top_data !== false) {
              $state = $list_user_tops[$user_single_top_data]['state'];
            } else {
              $state = "todo";
            }
            $tag_slug         = "";
            $concept_slug     = "";
            $sujet_slug       = "";
            $term_to_search   = "";

            if (get_the_terms($id_top, 'sous-cat')) {
              foreach (get_the_terms($id_top, 'sous-cat') as $sujet) {
                $sujet_slug     .= $sujet->slug . " ";
              }
            }
            if (get_the_terms($id_top, 'tag')) {
              foreach (get_the_terms($id_top, 'tag') as $tag) {
                $tag_slug     .= $tag->slug . " ";
              }
            }
            if (get_the_terms($id_top, 'concept')) {
              foreach (get_the_terms($id_top, 'concept') as $concept) {
                $concept_slug   .= $concept->slug . " ";
              }
            }
            $top_question   = get_field('question_t', $id_top);
            $top_title      = get_the_title($id_top);
            $term_to_search = $sujet_slug . " " . $concept_slug . " " . $top_question . " " . $top_title;
            $get_top_type = get_the_terms($id_top, 'type');
            if ($get_top_type) {
              foreach ($get_top_type as $type_top) {
                $type_top = $type_top->slug;
              }
            }
          ?>
            <div class="same-h grid-item col-md-3 col-6">
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
                <div class="card-body mb-3-hover">
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
                    <?php echo $top_question; ?>
                  </h4>
                </div>
                <a href="<?php the_permalink($id_top); ?>" class="stretched-link"></a>
              </div>
            </div>
          <?php $i++;
          endwhile; ?>
        </section>
      <?php else : ?>

        <div class="noresult">
          <h2>
            <span class="ico va va-woozy-face va-lg"></span> Aucun résultat pour ta recherche
          </h2>
        </div>

      <?php endif; ?>
    </div>
  </div>
</div>
<?php get_footer(); ?>