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
$list_rubrique = array();
foreach ($tops_in_cat->posts as $top_in_cat) {
  $get_top_rubrique = get_the_terms($top_in_cat, 'rubrique');
  if ($get_top_rubrique) {
    foreach ($get_top_rubrique as $rubrique) {
      array_push($list_rubrique, $rubrique->term_id);
    }
  }
}
$list_rubrique     = array_unique($list_rubrique);
$list_tags        = array();
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
              <div class="d-flex flex-column">
                <div class="filtre-bloc">
                  <div class="row align-items-center">
                    <div class="col-8">
                      <select id="selectpickerLiveSearch" class="selectpicker w-100" data-style="btn-default" data-live-search="true">
                        <option data-tokens="">Rubriques populaires</option>
                        <?php
                        $list_rubrique = get_terms(array(
                          'taxonomy'    => 'rubrique',
                          'orderby'     => 'count',
                          'order'       => 'DESC',
                          'hide_empty'  => true,
                          'include'     => $list_rubrique,
                        ));
                        $c = 0;
                        foreach ($list_rubrique as $rubrique) :
                          if ($c <= 20) : ?>
                            <option data-tokens="<?php echo $rubrique->slug; ?>" value="<?php echo $rubrique->slug; ?>">
                              <?php echo $rubrique->name; ?>
                            </option>
                        <?php endif;
                          $c++;
                        endforeach; ?>
                      </select>
                    </div>
                    <div class="col-4">
                      <label class="switch switch-primary">
                        <input type="checkbox" class="switch-input" value="todo" />
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
                  <div class="input-group input-group-merge" id="search_form">
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

    <section class="row match-height mt-4 grid-to-filtre">

      <?php while ($tops_in_cat->have_posts()) : $tops_in_cat->the_post();

        $id_top             = get_the_ID();
        $get_top_rubrique   = get_the_terms($id_top, 'rubrique');
        $list_des_rubriques = array();
        if ($get_top_rubrique) {
          foreach ($get_top_rubrique as $rubrique) {
            $list_des_rubriques = $rubrique->slug;
          }
        }
        $top_question   = get_field('question_t', $id_top);
        $top_title      = get_the_title($id_top);
        $term_to_search = $top_question . " " . $top_title;
        $id_top           = get_the_ID();
        $top_datas        = get_top_data($id_top);
        $creator_id       = get_post_field('post_author', $id_top);
        $creator_info     = get_userdata($creator_id);
        $creator_pseudo   = $creator_info->nickname;
        $creator_avatar   = get_avatar_url($creator_id, ['size' => '80', 'force_default' => false]);
        $type_top         = "";
        $state            = "";
        $illu             = get_the_post_thumbnail_url($id_top, 'large');
        $get_top_type = get_the_terms($id_top, 'type');
        if ($get_top_type) {
          foreach ($get_top_type as $type_top) {
            $type_top = $type_top->slug;
          }
        }
        if (in_array($id_top, $list_user_tops)) {
          $state = "done";
        } elseif (in_array($id_top, $list_user_tops_begin)) {
          $state = "begin";
        } else {
          $state = "todo";
        }
      ?>
        <div class="col-md-3 col-sm-4 col-6 grid-item" data-filter-item="<?php echo $state; ?> <?php echo $list_des_rubriques; ?>" data-filter-name="<?php echo $term_to_search; ?>">
          <div class="min-tournoi card scaler ehcard">
            <div class="cov-illu cover" style="background: url(<?php echo $illu; ?>) center center no-repeat">
              <?php if ($type_top == "sponso") : ?>
                <span class="badge badge-light-rose ml-0">Top sponso</span>
              <?php endif; ?>
              <?php if ($state == "done") : ?>
                <div class="badge bg-success">Terminé</div>
              <?php elseif ($state == "begin") : ?>
                <div class="badge bg-warning">En cours</div>
              <?php else : ?>
                <div class="badge bg-primary">A faire</div>
              <?php endif; ?>
              <div class="voile">
                <?php if ($state == "done") : ?>
                  <div class="spoun">
                    <h5>Voir ma Toplist</h5>
                  </div>
                <?php elseif ($state == "begin") : ?>
                  <div class="spoun">
                    <h5>Terminer</h5>
                  </div>
                <?php else : ?>
                  <div class="spoun">
                    <h5>Faire ma Toplist</h5>
                  </div>
                <?php endif; ?>
              </div>
              <div class="info-top">
                <div class="info-top-col">
                  <div class="infos-card-t info-card-t-v d-flex align-items-center">
                    <div class="d-flex align-items-center mr-10px">
                      <span class="ico va-high-voltage va va-md"></span>
                    </div>
                    <div class="content-body mt-01">
                      <h5 class="mb-0">
                        <?php echo $top_datas['nb_votes']; ?>
                      </h5>
                    </div>
                  </div>
                </div>
                <div class="info-top-col">
                  <div class="infos-card-t d-flex align-items-center">
                    <div class="d-flex align-items-center mr-10px">
                      <span class="ico va va-trophy va-md"></span>
                    </div>
                    <div class="content-body mt-01">
                      <h5 class="mb-0">
                        <?php echo $top_datas['nb_tops']; ?>
                      </h5>
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
                      <h5 class="mb-0 link-creator d-flex flex-column text-left">
                        <span class="text-muted">Créé par</span>
                        <a href="<?php the_permalink(218587); ?>?creator_id=<?php echo $creator_id; ?>" target="_blank" class="link-to-creator">
                          <?php echo $creator_pseudo; ?>
                        </a>
                      </h5>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="card-body eh mb-3-hover">
              <h4 class="card-text text-white">
                <?php
                foreach (get_the_terms($id_top, 'categorie') as $cat) {
                  $cat_id     = $cat->term_id;
                  $cat_name   = $cat->name;
                }
                ?>
                TOP <?php echo get_field('count_contenders_t', $id_top); ?> <?php the_field('icone_cat', 'term_' . $cat_id); ?> <?php echo get_the_title($id_top); ?>
              </h4>
              <h3 class="card-title">
                <?php the_field('question_t', $id_top); ?>
              </h3>
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
        <span class="ico va va-woozy-face va-lg"></span> Aucun Top disponible par ici 🤪
      </h2>
    </div>

  <?php endif; ?>
</div>

<?php get_footer(); ?>