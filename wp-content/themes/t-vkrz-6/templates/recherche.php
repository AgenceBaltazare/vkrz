<?php
/*
    Template Name: Recherche
*/
?>
<?php
global $term_to_search;
global $total_top_founded;
global $infos_vainkeur;

if (isset($_GET['term']) && $_GET['term'] != "") {
  $term_to_search = $_GET['term'];
}
$list_tops = array();

// SEARCH BY TITLE…
$tops_to_find = new WP_Query(array(
  'post_type'                 => 'tournoi',
  'posts_per_page'            => -1,
  'ignore_sticky_posts'       => true,
  'update_post_meta_cache'    => false,
  'no_found_rows'             => true,
  'tax_query'                 => array(
    array(
      'taxonomy' => 'type',
      'field'    => 'slug',
      'terms'    => array('private', 'whitelabel', 'onboarding'),
      'operator' => 'NOT IN'
    ),
  ),
  's'                         => $term_to_search,
));
while ($tops_to_find->have_posts()) : $tops_to_find->the_post();
  array_push($list_tops, get_the_ID());
endwhile;

// SEARCH BY QUESTION_T…
$tops_to_find = new WP_Query(array(
  'post_type'                 => 'tournoi',
  'posts_per_page'            => -1,
  'ignore_sticky_posts'       => true,
  'update_post_meta_cache'    => false,
  'no_found_rows'             => true,
  'tax_query'                 => array(
    array(
      'taxonomy' => 'type',
      'field'    => 'slug',
      'terms'    => array('private', 'whitelabel', 'onboarding'),
      'operator' => 'NOT IN'
    ),
  ),
  'meta_query'                => array(
    array(
      'key'		   => 'question_t',
			'value'		 => $term_to_search,
      'compare'  => 'LIKE',
    ),
  ),
));
while ($tops_to_find->have_posts()) : $tops_to_find->the_post();
  array_push($list_tops, get_the_ID());
endwhile;

$cat_id = 0;
$cat_t = get_terms(array(
  'taxonomy'      => 'categorie',
  'orderby'       => 'count',
  'order'         => 'DESC',
  'hide_empty'    => true,
));
foreach ($cat_t as $cat) :
  if ($term_to_search == mb_strtolower($cat->name)) {
    $cat_id = $cat->term_id;
  }
endforeach;
$tops_to_find = new WP_Query(array(
  'post_type'                 => 'tournoi',
  'posts_per_page'            => -1,
  'ignore_sticky_posts'       => true,
  'update_post_meta_cache'    => false,
  'no_found_rows'             => true,
  'tax_query'                 => array(
    'relation' => 'AND',
    array(
      'taxonomy' => 'categorie',
      'field'    => 'term_id',
      'terms'    => $cat_id,
    ),
    array(
      'taxonomy' => 'type',
      'field'    => 'slug',
      'terms'    => array('private', 'whitelabel', 'onboarding'),
      'operator' => 'NOT IN'
    ),
  ),
));
while ($tops_to_find->have_posts()) : $tops_to_find->the_post();
  array_push($list_tops, get_the_ID());
endwhile;

$type_top_id = 0;
$type_t = get_terms(array(
  'taxonomy'      => 'type',
  'orderby'       => 'count',
  'order'         => 'DESC',
  'hide_empty'    => true,
));
foreach ($type_t as $type) :
  if ($term_to_search == mb_strtolower($type->name)) {
    $type_top_id = $type->term_id;
  }
endforeach;
$tops_to_find = new WP_Query(array(
  'post_type'                 => 'tournoi',
  'posts_per_page'            => -1,
  'ignore_sticky_posts'       => true,
  'update_post_meta_cache'    => false,
  'no_found_rows'             => true,
  'tax_query'                 => array(
    'relation' => 'AND',
    array(
      'taxonomy' => 'type',
      'field'    => 'term_id',
      'terms'    => $type_top_id,
    ),
    array(
      'taxonomy' => 'type',
      'field'    => 'slug',
      'terms'    => array('private', 'whitelabel', 'onboarding'),
      'operator' => 'NOT IN'
    ),
  ),
));
while ($tops_to_find->have_posts()) : $tops_to_find->the_post();
  array_push($list_tops, get_the_ID());
endwhile;

$sous_cat_id = 0;
$sous_cat_t = get_terms(array(
  'taxonomy'      => 'sous-cat',
  'orderby'       => 'count',
  'order'         => 'DESC',
  'hide_empty'    => true,
));
foreach ($sous_cat_t as $sous_cat) :
  if ($term_to_search == mb_strtolower($sous_cat->name)) {
    $sous_cat_id = $sous_cat->term_id;
  }
endforeach;
$tops_to_find = new WP_Query(array(
  'post_type'                 => 'tournoi',
  'posts_per_page'            => -1,
  'ignore_sticky_posts'       => true,
  'update_post_meta_cache'    => false,
  'no_found_rows'             => true,
  'tax_query'                 => array(
    'relation' => 'AND',
    array(
      'taxonomy' => 'sous-cat',
      'field'    => 'term_id',
      'terms'    => $sous_cat_id,
    ),
    array(
      'taxonomy' => 'type',
      'field'    => 'slug',
      'terms'    => array('private', 'whitelabel', 'onboarding'),
      'operator' => 'NOT IN'
    ),
  ),
));
while ($tops_to_find->have_posts()) : $tops_to_find->the_post();
  array_push($list_tops, get_the_ID());
endwhile;

$concept_id = 0;
$concept_t = get_terms(array(
  'taxonomy'      => 'tag',
  'orderby'       => 'name',
  'order'         => 'ASC',
  'hide_empty'    => true,
));
foreach ($concept_t as $concept) :
  if ($term_to_search == mb_strtolower($concept->name)) {
    $concept_id = $concept->term_id;
  }
endforeach;
$tops_to_find = new WP_Query(array(
  'post_type'                 => 'tournoi',
  'posts_per_page'            => -1,
  'ignore_sticky_posts'       => true,
  'update_post_meta_cache'    => false,
  'no_found_rows'             => true,
  'tax_query'                 => array(
    'relation' => 'AND',
    array(
      'taxonomy' => 'tag',
      'field'    => 'term_id',
      'terms'    => $concept_id,
    ),
    array(
      'taxonomy' => 'type',
      'field'    => 'slug',
      'terms'    => array('private', 'whitelabel', 'onboarding'),
      'operator' => 'NOT IN'
    ),
  ),
));
while ($tops_to_find->have_posts()) : $tops_to_find->the_post();
  array_push($list_tops, get_the_ID());
endwhile;

$sujet_id = 0;
$sujet_t = get_terms(array(
  'taxonomy'      => 'concept',
  'orderby'       => 'name',
  'order'         => 'ASC',
  'hide_empty'    => true,
));
foreach ($sujet_t as $sujet) :
  if ($term_to_search == mb_strtolower($sujet->name)) {
    $sujet_id = $sujet->term_id;
  }
endforeach;
$tops_to_find = new WP_Query(array(
  'post_type'                 => 'tournoi',
  'posts_per_page'            => -1,
  'ignore_sticky_posts'       => true,
  'update_post_meta_cache'    => false,
  'no_found_rows'             => true,
  'tax_query'                 => array(
    'relation' => 'AND',
    array(
      'taxonomy' => 'concept',
      'field'    => 'term_id',
      'terms'    => $sujet_id,
    ),
    array(
      'taxonomy' => 'type',
      'field'    => 'slug',
      'terms'    => array('private', 'whitelabel', 'onboarding'),
      'operator' => 'NOT IN'
    ),
  ),
));
while ($tops_to_find->have_posts()) : $tops_to_find->the_post();
  array_push($list_tops, get_the_ID());
endwhile;

$contenders_to_find = new WP_Query(array(
  'post_type'                 => 'contender',
  'posts_per_page'            => -1,
  'ignore_sticky_posts'       => true,
  'update_post_meta_cache'    => false,
  'no_found_rows'             => true,
  's'                         => $term_to_search
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
      array(
        'taxonomy' => 'type',
        'field'    => 'slug',
        'terms'    => array('private', 'whitelabel', 'onboarding'),
        'operator' => 'NOT IN'
      ),
    ),
  ));
}

$user_query = new WP_User_Query(
  array(
    'search'          => '*' . esc_attr($term_to_search) . '*',
    'search_columns'  => array('user_login')
  )
);
$searching_for_a_vainkeur = $user_query->get_results();

wp_reset_query();

global $total_top_founded;
if (!empty($tops_unique_to_find)) {
  $total_top_founded = $tops_unique_to_find->post_count;
}
get_header();
?>
<div class="app-content content ecommerce-application">
  <div class="recherche-firestore"
    data-lama2lombre="<?php echo is_user_logged_in() ? 'Non' : 'Oui' ?>"
    data-userId="<?php echo get_current_user_id() ?>"
    data-userName="<?php echo wp_get_current_user()->display_name; ?>"
    data-uuid="<?php echo get_field('uuiduser_user', 'user_' . get_current_user_id()); ?>"
    data-searchedTerm="<?php echo $term_to_search; ?>"
    data-resultsNumber="<?php echo $total_top_founded + count($searching_for_a_vainkeur); ?>"
  >
  </div>

  <div class="content-wrapper">
    <div class="content-body">

      <div class="intro-mobile">
        <div class="tournament-heading text-center">
          <h3 class="mb-0 t-titre-tournoi">
            <?php
            if ($searching_for_a_vainkeur) {
              echo 'Vainkeur trouvé';
            }
            if ($searching_for_a_vainkeur) {
              echo ' - ';
            }
            if ($total_top_founded == 0 || !$total_top_founded) {
              echo "Aucun Top trouvé";
            } elseif ($total_top_founded == 1) {
              echo "Un seul Top trouvé";
            } else {
              echo $total_top_founded . " Tops trouvés";
            }
            ?>
          </h3>
        </div>
      </div>

      <section id="ecommerce-header" class="mb-2 mt-2">
        <div id="ecommerce-searchbar" class="ecommerce-searchbar">
          <div class="input-group input-group-merge">
            <form id="search_form" method="GET" autocomplete="off">
              <span class="ico ico-search ico-search-clear">❌</span>
              <?php
              if ($term_to_search) {
                $placeholder = $term_to_search;
              } else {
                $placeholder = "Rechercher...";
              }
              ?>
              <input type="text" class="form-control search-product" id="search_text" placeholder="<?php echo $placeholder; ?>" aria-label="<?php echo $placeholder; ?>" name="term" aria-describedby="shop-search" minlength="3" required/>
              <button type="submit">
                <span class="ico ico-search ico-search-result va va-loupe va-lg"></span>
              </button>
            </form>
          </div>
        </div>
      </section>

      <?php if ($searching_for_a_vainkeur) : ?>
        <div class="classement mt-3">
          <section id="profile-info">
            <div id="table-bordered">
              <div class="card">
                <div class="table-responsive">
                  <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
                    <div class="row">
                      <div class="col-sm-12">
                        <table class="table table-vainkeurz dataTable no-footer" id="DataTables_Table_0" role="grid" aria-describedby="DataTables_Table_0_info">
                          <thead>
                            <tr>
                              <th>
                                <span class="va va-lama va-lg"></span> <span class="text-muted">Vainkeur</span>
                              </th>
                              <th class="text-right">
                                <span class="text-muted">Votes</span>
                              </th>
                              <th class="text-right">
                                <span class="text-muted">TopList</span>
                              </th>
                              <th class="text-right">
                                <span class="text-muted">Voir</span>
                              </th>

                              <?php if (strtolower($infos_vainkeur['pseudo']) != strtolower($term_to_search) && is_user_logged_in()) : ?>
                                <th class="text-right">
                                  <span class="text-muted">Guetter</span>
                                </th>
                              <?php endif; ?>
                            </tr>
                          </thead>
                          <tbody>
                            <?php
                            foreach ($searching_for_a_vainkeur as $user) : 
                              $user_id                  = $user->ID;
                              $uuiduser_search          = get_field('uuiduser_user', 'user_' . $user_id);
                              $vainkeur_data_selected   = get_user_infos($uuiduser_search, "complete");
                              global $vainkeur_data_selected;
                              ?>
                              <tr>
                                <td>
                                  <?php get_template_part('partials/vainkeur-card'); ?>
                                </td>

                                <td class="text-right">
                                  <?php echo $vainkeur_data_selected['nb_vote_vkrz']; ?> <span class="ico va-high-voltage va va-lg"></span>
                                </td>

                                <td class="text-right">
                                  <?php echo $vainkeur_data_selected['nb_top_vkrz']; ?> <span class="ico va va-trophy va-lg"></span>
                                </td>

                                <td class="text-right">
                                  <a href="<?php echo esc_url(get_author_posts_url($user_id)); ?>">
                                    <span class="va va-eyes va-lg"></span>
                                  </a>
                                </td>

                                <?php if (get_current_user_id() != $user_id && is_user_logged_in()) : ?>
                                  <td class="text-right checking-follower">
                                    <button type="button" id="followBtn" class="btn waves-effect btn-follow d-none" data-userid="<?= get_current_user_id(); ?>" data-uuid="<?= get_field('uuiduser_user', 'user_' . get_current_user_id()); ?>" data-relatedid="<?= $user_id; ?>" data-relateduuid="<?= $uuiduser_search ?>" data-text="<?= get_the_author_meta('nickname', get_current_user_id()); ?> te guette !" data-url="<?= get_author_posts_url(get_current_user_id()); ?>">
                                      <span class="wording">Guetter</span>
                                      <span class="va va-guetteur-close va va-z-20 emoji"></span>
                                    </button>
                                  </td>
                                <?php endif; ?>

                              </tr>
                            <?php endforeach; ?>
                          </tbody>
                        </table>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </section>
        </div>
      <?php endif; ?>

      <?php if (!empty($list_tops_unique)) :
        if ($id_vainkeur) {
          if (is_user_logged_in() && env() != "local" && $id_vainkeur) {
            if (false === ($user_tops = get_transient('user_' . $user_id . '_get_user_tops'))) {
              $user_tops = get_user_tops($id_vainkeur);
              set_transient('user_' . $user_id . '_get_user_tops', $user_tops, DAY_IN_SECONDS);
            } else {
              $user_tops = get_transient('user_' . $user_id . '_get_user_tops');
            }
          } else {
            $user_tops  = get_user_tops($id_vainkeur);
          }
          $list_user_tops       = $user_tops['list_user_tops_done_ids'];
          $list_user_tops_begin = $user_tops['list_user_tops_begin_ids'];
        } else {
          $user_tops            = array();
          $list_user_tops       = array();
          $list_user_tops_begin = array();
        }
      ?>
        <section class="grid-to-filtre row match-height mt-2 tournois">
          <?php $i = 1;
          while ($tops_unique_to_find->have_posts()) : $tops_unique_to_find->the_post(); ?>

            <div class="col-md-3 col-sm-4 col-6">
              <?php get_template_part('partials/min-t'); ?>
            </div>

          <?php $i++;
          endwhile; ?>
        </section>

      <?php endif; ?>

      <?php if (!$searching_for_a_vainkeur && empty($list_tops_unique)) : ?>
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