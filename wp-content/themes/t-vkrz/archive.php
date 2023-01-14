<?php
global $user_tops;
global $list_user_tops;
global $list_user_tops_begin;
$user_id        = get_user_logged_id();
$vainkeur       = get_vainkeur();
$uuid_vainkeur  = $vainkeur['uuid_vainkeur'];
$id_vainkeur    = $vainkeur['id_vainkeur'];
if (is_user_logged_in()) {
  $infos_vainkeur = get_user_infos($uuid_vainkeur, "complete");
} else {
  $infos_vainkeur = get_fantom($id_vainkeur);
}
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
$current_cat            = get_queried_object();
$tops_in_cat            = new WP_Query(array(
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
  )
));
$list_souscat = array();
foreach ($tops_in_cat->posts as $top_in_cat) {
  $get_top_souscat = get_the_terms($top_in_cat, 'concept');
  if ($get_top_souscat) {
    foreach ($get_top_souscat as $souscat) {
      array_push($list_souscat, $souscat->term_id);
    }
  }
}
$list_souscat     = array_unique($list_souscat);
$list_tags        = array();
$list_concepts    = array();
$list_sujets      = array();
?>

<div class="my-3">

  <div class="container-xxl mt-2">
    <div class="row">
      <div class="col">
        <div class="filtres-bloc">
          <div class="row align-items-center justify-content-center">
            <div class="col-md-4 offset-md-1">
              <div class="intro-archive">
                <div class="iconarchive">
                  <?php the_field('icone_cat', 'term_' . $current_cat->term_id); ?>
                </div>
                <h1>
                  <?php echo $current_cat->name; ?> <span class="infonbtops"><?php echo $tops_in_cat->post_count; ?> Tops</span>
                </h1>
                <h2>
                  <?php echo $current_cat->description; ?>
                </h2>
              </div>
            </div>
            <div class="col-md-4">
              <div class="d-flex flex-column group-filtres">
                <div class="filtre-bloc">
                  <div class="row align-items-center">
                    <div class="col-8">
                      <select id="selectpickerLiveSearch" class="selectpicker w-100" data-style="btn-default" data-live-search="true">
                        <option data-tokens="">Choix de la Licence</option>
                        <?php
                        $list_souscat = get_terms(array(
                          'taxonomy' => 'concept',
                          'orderby' => 'count',
                          'order' => 'DESC',
                          'hide_empty' => true,
                          'include' => $list_souscat,
                        ));
                        $c = 0;
                        foreach ($list_souscat as $souscat) :
                          if ($c <= 20) : ?>
                            <option data-tokens="<?php echo $souscat->slug; ?>" value="<?php echo $souscat->slug; ?>">
                              <?php echo $souscat->name; ?>
                            </option>
                        <?php endif;
                          $c++;
                        endforeach; ?>
                      </select>
                    </div>
                    <div class="col-4">
                      <label class="switch switch-primary">
                        <input type="checkbox" class="switch-input" checked />
                        <span class="switch-toggle-slider">
                          <span class="switch-on">
                            <i class="ti ti-check"></i>
                          </span>
                          <span class="switch-off">
                            <i class="ti ti-x"></i>
                          </span>
                        </span>
                        <span class="switch-label">A faire</span>
                      </label>
                    </div>
                  </div>
                </div>
                <div class="filtre-bloc">
                  <div class="input-group input-group-merge">
                    <span class="input-group-text" id="basic-addon-search31"><span class="va va-loupe va-lg"></span></span>
                    <input type="text" class="form-control" placeholder="Rechercher dans <?php echo $current_cat->name; ?>..." aria-label="Rechercher dans <?php echo $current_cat->name; ?>..." aria-describedby="basic-addon-search31" spellcheck="false">
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <?php if ($tops_in_cat->have_posts()) : $i = 1; ?>

    <section class="row match-height mt-4">

      <?php while ($tops_in_cat->have_posts()) : $tops_in_cat->the_post();
        $get_top_souscat = get_the_terms($id_top, 'concept');
        $list_sous_cat   = "";
        if ($get_top_souscat) {
          foreach ($get_top_souscat as $sous_cat) {
            $list_sous_cat .= $sous_cat->slug . " ";
          }
        }
        $top_question   = get_field('question_t', $id_top);
        $top_title      = get_the_title($id_top);
        $term_to_search = $top_question . " " . $top_title;
        if (in_array($id_top, $list_user_tops)) {
          $state = "done";
        } elseif (in_array($id_top, $list_user_tops_begin)) {
          $state = "begin";
        } else {
          $state = "todo";
        }
      ?>
        <div class="col-md-3 col-sm-4 col-6" data-filter-item="<?php echo $state; ?> <?php echo $list_sous_cat; ?>" data-filter-name="<?php echo $term_to_search; ?>">
          <?php get_template_part('partials/min-t'); ?>
        </div>
      <?php $i++;
      endwhile; ?>

    </section>

  <?php else : ?>

    <div class="noresult">
      <h2>
        <span class="ico va va-woozy-face va-lg"></span> Aucun Top disponible par ici 🤪
      </h2>
    </div>

  <?php endif; ?>
</div>

<?php get_footer(); ?>