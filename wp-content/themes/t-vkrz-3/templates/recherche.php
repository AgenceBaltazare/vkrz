<?php
/*
    Template Name: Recherche
*/
?>

<?php

if (isset($_POST['term']) && $_POST['term'] != "") {
  $term_to_search = $_POST['term'];
}

$list_tops = array();
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

////////////////// CATEGORIES 1️⃣ /////////////

function sans_accents($string)
{
  $translit = array('Á' => 'A', 'À' => 'A', 'Â' => 'A', 'Ä' => 'A', 'Ã' => 'A', 'Å' => 'A', 'Ç' => 'C', 'É' => 'E', 'È' => 'E', 'Ê' => 'E', 'Ë' => 'E', 'Í' => 'I', 'Ï' => 'I', 'Î' => 'I', 'Ì' => 'I', 'Ñ' => 'N', 'Ó' => 'O', 'Ò' => 'O', 'Ô' => 'O', 'Ö' => 'O', 'Õ' => 'O', 'Ú' => 'U', 'Ù' => 'U', 'Û' => 'U', 'Ü' => 'U', 'Ý' => 'Y', 'á' => 'a', 'à' => 'a', 'â' => 'a', 'ä' => 'a', 'ã' => 'a', 'å' => 'a', 'ç' => 'c', 'é' => 'e', 'è' => 'e', 'ê' => 'e', 'ë' => 'e', 'í' => 'i', 'ì' => 'i', 'î' => 'i', 'ï' => 'i', 'ñ' => 'n', 'ó' => 'o', 'ò' => 'o', 'ô' => 'o', 'ö' => 'o', 'õ' => 'o', 'ú' => 'u', 'ù' => 'u', 'û' => 'u', 'ü' => 'u', 'ý' => 'y', 'ÿ' => 'y');
  $string = strtr($string, $translit);
  return preg_replace('#[^a-zA-Z0-9\-\._]#', '-', $string);
}

$cat_id = 0;
$cat_t = get_terms(array(
  'taxonomy'      => 'categorie',
  'orderby'       => 'count',
  'order'         => 'DESC',
  'hide_empty'    => true,
));
foreach ($cat_t as $cat) :
  if (mb_strtolower(sans_accents($term_to_search)) == mb_strtolower(sans_accents($cat->name))) {
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

//////////////////////////////////////////////

////////////////// TYPE TOP 2️⃣ /////////////
$type_top_id = 0;

$type_t = get_terms(array(
  'taxonomy'      => 'type',
  'orderby'       => 'count',
  'order'         => 'DESC',
  'hide_empty'    => true,
));
foreach ($type_t as $type) :
  if (mb_strtolower(sans_accents($term_to_search)) == mb_strtolower(sans_accents($type->name))) {
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
/////////////////////////////////////////////


////////////////// SUB-CATEGORY 3️⃣ /////////
$sous_cat_id = 0;

$sous_cat_t = get_terms(array(
  'taxonomy'      => 'sous-cat',
  'orderby'       => 'count',
  'order'         => 'DESC',
  'hide_empty'    => true,
));
foreach ($sous_cat_t as $sous_cat) :
  if (mb_strtolower(sans_accents($term_to_search)) == mb_strtolower(sans_accents($sous_cat->name))) {
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
/////////////////////////////////////////////

////////////////// CONCEPT 3️⃣ /////////
$concept_id = 0;

$concept_t = get_terms(array(
  'taxonomy'      => 'tag',
  'orderby'       => 'name',
  'order'         => 'ASC',
  'hide_empty'    => true,
));
foreach ($concept_t as $concept) :
  if (mb_strtolower(sans_accents($term_to_search)) == mb_strtolower(sans_accents($concept->name))) {
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
/////////////////////////////////////////////

////////////////// SUJET 3️⃣ /////////
$sujet_id = 0;

$sujet_t = get_terms(array(
  'taxonomy'      => 'concept',
  'orderby'       => 'name',
  'order'         => 'ASC',
  'hide_empty'    => true,
));
foreach ($sujet_t as $sujet) :
  if (mb_strtolower(sans_accents($term_to_search)) == mb_strtolower(sans_accents($sujet->name))) {
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
/////////////////////////////////////////////


////////////////// CONTENDER 4️⃣ ////////////
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
/////////////////////////////////////////////

if (!empty($list_tops_unique)) {
  $tops_unique_to_find = new WP_Query(array(
    'post_type'                 => 'tournoi',
    'posts_per_page'            => -1,
    'ignore_sticky_posts'       => true,
    'update_post_meta_cache'    => false,
    'no_found_rows'             => true,
    'post__in'                  => $list_tops_unique
  ));
}

////////////////// VAINKEUR 5️⃣ ////////////
function get_vainkeurz()
{
  $vainkeurs = new WP_Query(array(
    "post_type"              => "vainkeur",
    'fields'                 => 'ids',
    "post_status"            => "publish",
    "update_post_meta_cache" => false,
    "no_found_rows"          => false,
    "orderby"                => "meta_value_num",
    "order"                  => "DESC",
  ));

  if ($vainkeurs->have_posts()) {
    foreach ($vainkeurs->posts as $vainkeur_id) {
      $return[] = array(
        "vainkeur_id" => $vainkeur_id,
        "author_id" => get_post_field("post_author", $vainkeur_id),
        "uuid" => get_field("uuid_user_vkrz", $vainkeur_id),
        "money" => get_field("money_vkrz", $vainkeur_id),
        "total_vote" => get_field("nb_vote_vkrz", $vainkeur_id),
        "total_top" => get_field("nb_top_vkrz", $vainkeur_id)
      );
    }
  }

  return $return;
}
$vainkeurz = get_vainkeurz();
global $searching_for_a_vainkeur;
$searching_for_a_vainkeur = false;
$searched_vainkeur =  strtolower($term_to_search);
$vainkeur_final_id = 0;

foreach ($vainkeurz as $vainkeur) {
  $vainkeur_name = strtolower(get_the_author_meta('nickname', $vainkeur["author_id"]));
  if (strcmp($vainkeur_name, $searched_vainkeur) === 0) {
    $searching_for_a_vainkeur = true;
    $vainkeur_final_id = $vainkeur["author_id"];

    $total_vote         = $vainkeur["total_vote"];
    $total_top          = $vainkeur["total_top"];
    $money              = $vainkeur["money"];
  }
}
wp_reset_query();

///////////////////////////////////////////

global $total_top_founded;
$total_top_founded = $tops_unique_to_find->post_count;
get_header();
?>

<div class="app-content content ecommerce-application">
  <!-- <div class="content-overlay"></div> -->
  <div class="content-wrapper">
    <div class="content-body">

      <div class="intro-mobile">
        <div class="tournament-heading text-center">
          <h3 class="mb-0 t-titre-tournoi">
            <?php echo $total_top_founded; ?> résultats pour ta recherche : <?php echo $term_to_search; ?>
          </h3>
        </div>
      </div>

      <section id="ecommerce-header" class="mb-2 mt-2">
        <div id="ecommerce-searchbar" class="ecommerce-searchbar">
          <div class="input-group input-group-merge">
            <form id="search_form" method="POST" autocomplete="off">
              <span class="ico ico-search ico-search-clear">❌</span>

              <input type="text" class="form-control search-product" id="search_text" placeholder="Rechercher..." aria-label="Rechercher..." name="term" aria-describedby="shop-search" required />

              <button type="submit">
                <span class="ico ico-search ico-search-result va va-magnifying-glass-tilted-left va-lg"></span>
              </button>
            </form>
          </div>
        </div>
      </section>

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
            <div data-filter-item data-filter-name="<?php echo $term_to_search; ?>" class="same-h grid-item col-md-3 col-6 <?php echo $sujet_slug; ?> <?php echo $state; ?> <?php echo $concept_slug; ?> <?php echo $tag_slug; ?>">
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
      <?php endif; ?>

      <?php if ($searching_for_a_vainkeur) : ?>
        <?php

        $user_id = $vainkeur_final_id;
        $user_infos = deal_vainkeur_entry($user_id);
        $avatar             = $user_infos['avatar'];
        $info_user_level    = get_user_level($user_id);

        ?>
        <div class="table-responsive">
          <table class="table table-vainkeurz">
            <thead>
              <tr>
                <th>
                  <span class="va va-llama va-lg"></span> <small class="text-muted">Vainkeur</small>
                </th>
                <th class="text-right">
                  <small class="text-muted">KEURZ</small>
                </th>
                <th class="text-right">
                  <small class="text-muted">Votes effectués</small>
                </th>
                <th class="text-right">
                  <small class="text-muted">Top terminés</small>
                </th>
                <th class="text-right">
                  <small class="text-muted">Guetter ses Tops</small>
                </th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>
                  <div class="d-flex align-items-center">
                    <div class="avatar">
                      <span class="avatar-picture" style="background-image: url(<?php echo $avatar; ?>);"></span>
                      <?php if ($info_user_level) : ?>
                        <span class="user-niveau">
                          <?php echo $info_user_level['level_ico']; ?>
                        </span>
                      <?php endif; ?>
                    </div>
                    <div class="font-weight-bold championname">
                      <span>
                        <?php echo get_the_author_meta('nickname', $user_id); ?>
                      </span>
                      <?php if ($user_infos['user_role'] == "administrator") : ?>
                        <span class="ico va va-vkrzteam va-lg" data-toggle="tooltip" data-placement="top" title="" data-original-title="TeamVKRZ">
                        </span>
                      <?php endif; ?>
                      <?php if ($user_infos['user_role'] == "administrator" || $user_infos['user_role'] == "author") : ?>
                        <span class="ico va va-man-singer va-lg" data-toggle="tooltip" data-placement="top" title="" data-original-title="Créateur de Tops">
                        </span>
                      <?php endif; ?>
                    </div>
                  </div>
                </td>

                <td class="text-right">
                  <?php echo $money; ?> <span class="ico va-gem va va-lg"></span>
                </td>

                <td class="text-right">
                  <?php echo $total_vote; ?> <span class="ico va-high-voltage va va-lg"></span>
                </td>

                <td class="text-right">
                  <?php echo $total_top; ?> <span class="ico va va-trophy va-lg"></span>
                </td>

                <td class="text-right">
                  <a href="<?php echo esc_url(get_author_posts_url($user_id)); ?>" class="mr-1 btn btn-outline-primary waves-effect">
                    <span class="va va-eyes va-lg"></span>
                  </a>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      <?php endif; ?>
    </div>
  </div>
</div>


<?php get_footer(); ?>