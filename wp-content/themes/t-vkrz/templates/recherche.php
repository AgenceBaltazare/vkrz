<?php
/*
  Template Name: Recherche
*/
?>
<?php
global $user_tops;
global $list_user_tops;
global $list_user_tops_begin;
global $term_to_search;
global $total_top_founded;
global $infos_vainkeur;
global $id_vainkeur;
$type_to_search = "tops";

if (isset($_GET['term_to_search']) && $_GET['term_to_search'] != "") {
  $term_to_search = $_GET['term_to_search'];
}
if (isset($_GET['member_to_search']) && $_GET['member_to_search'] != "") {
  $member_to_search = $_GET['member_to_search'];
}
if (isset($_GET['typesearch']) && $_GET['typesearch'] != "") {
  $type_to_search = $_GET['typesearch'];
}

if ($type_to_search == "Tops") {
  $recherche      = strval($term_to_search);
  $list_result    = array();
  $tops_to_find   = new WP_Query(array(
    'post_type'                 => 'tournoi',
    'posts_per_page'            => -1,
    'ignore_sticky_posts'       => true,
    'update_post_meta_cache'    => false,
    'no_found_rows'             => true,
    'fields'                    => 'ids',
    's'                         => $recherche,
    'tax_query'                 => array(
      array(
        'taxonomy' => 'type',
        'field'    => 'slug',
        'terms'    => array('private', 'whitelabel', 'onboarding'),
        'operator' => 'NOT IN'
      ),
    ),
  ));
  if ($tops_to_find->have_posts()) {
    while ($tops_to_find->have_posts()) : $tops_to_find->the_post();
      array_push($list_result, get_the_ID());
    endwhile;
  }

  $contenders_to_find = new WP_Query(array(
    'post_type'                 => 'contender',
    'posts_per_page'            => -1,
    'ignore_sticky_posts'       => true,
    'update_post_meta_cache'    => false,
    'no_found_rows'             => true,
    's'                         => $recherche
  ));
  while ($contenders_to_find->have_posts()) : $contenders_to_find->the_post();
    array_push($list_result, get_field('id_tournoi_c', get_the_ID()));
  endwhile;

  $list_result_unique   = array_unique($list_result);
} else {
  $recherche  = strval($member_to_search);
  $user_query = new WP_User_Query(
    array(
      'number'          => 1000,
      'search'          => '*' . $recherche . '*',
      'search_columns'  => array('user_login')
    )
  );
  $searching_for_a_vainkeur = $user_query->get_results();
}
if (!empty($list_result_unique)) {
  $top_resultats = new WP_Query(array(
    'ignore_sticky_posts'      => true,
    'update_post_meta_cache'  => false,
    'no_found_rows'            => true,
    'post_type'                => 'tournoi',
    'orderby'                  => 'date',
    'order'                    => 'DESC',
    'posts_per_page'          => -1,
    'post__in'                => $list_result_unique
  ));
}
get_header();
?>
<?php if ($type_to_search == "Tops") : ?>
  <div class="my-3">
    <div class="container-xxl mt-2">
      <div class="row">
        <div class="col">
          <div class="filtres-bloc">
            <div class="row align-items-center justify-content-center">
              <div class="col-md-4 offset-md-1">
                <div class="intro-archive">
                  <?php if (!empty($list_result_unique)) : ?>
                    <h2>
                      Résultats pour
                    </h2>
                    <h1>
                      <?php echo $recherche; ?> <span class="infonbtops"><?php echo $top_resultats->post_count; ?> Tops</span>
                    </h1>
                  <?php else : ?>
                    <h1>
                      Aucun Top trouvé
                    </h1>
                    <h2>
                      Malheureusement
                    </h2>
                  <?php endif; ?>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="container-xxl">
      <?php if (!empty($list_result_unique)) : ?>
        <section class="row match-height mt-4 grid-to-filtre">
          <?php while ($top_resultats->have_posts()) : $top_resultats->the_post(); ?>
            <div class="col-md-3 col-sm-4 col-6 grid-item">
              <?php get_template_part('partials/min-t'); ?>
            </div>
          <?php $i++;
          endwhile; ?>
        </section>
      <?php endif; ?>
    </div>
  </div>
<?php else : ?>
  <div class="my-3">
    <div class="container-xxl mt-2">
      <div class="row">
        <div class="col">
          <div class="filtres-bloc">
            <div class="row align-items-center justify-content-center">
              <div class="col-md-4">
                <div class="intro-archive">
                  <?php if (!empty($searching_for_a_vainkeur)) : ?>
                    <h2>
                      Recherche pour
                    </h2>
                    <h1>
                      <?php echo $recherche; ?>
                    </h1>
                  <?php else : ?>
                    <h1>
                      Aucun vainkeur trouvé
                    </h1>
                  <?php endif; ?>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <?php if (!empty($searching_for_a_vainkeur)) : ?>
      <div class="container-xxl">
        <div class="row">
          <div class="col">
            <div class="classement">
              <section id="profile-info">
                <div class="card">
                  <div class="table-responsive">
                    <table class="table table-vainkeurz-recherche">
                      <thead>
                        <tr>
                          <th>
                            <span class="va va-lama va-lg"></span> <span class="text-muted">Vainkeur</span>
                          </th>
                          <th class="text-center shorted">
                            <span class="text-muted">XP <span class="va va-updown va-z-10"></span></span>
                          </th>
                          <th class="text-center shorted">
                            <span class="text-muted">Votes <span class="va va-updown va-z-10"></span></span>
                          </th>
                          <th class="text-center shorted">
                            <span class="text-muted">TopList <span class="va va-updown va-z-10"></span></span>
                          </th>
                          <th class="text-right">
                            <span class="text-muted">Guetter</span>
                          </th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php $r = 1;
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

                            <td class="text-center">
                              <?php echo $vainkeur_data_selected['money_vkrz']; ?> <span class="ico va-mush va va-lg"></span>
                            </td>

                            <td class="text-center">
                              <?php echo $vainkeur_data_selected['nb_vote_vkrz']; ?> <span class="ico va-high-voltage va va-lg"></span>
                            </td>

                            <td class="text-center">
                              <?php echo $vainkeur_data_selected['nb_top_vkrz']; ?> <span class="ico va va-trophy va-lg"></span>
                            </td>


                            <td class="text-right checking-follower">
                              <?php if (get_current_user_id() != $user_id) : ?>
                                <?php if (get_current_user_id() != $user_id && is_user_logged_in()) : ?>
                                  <button type="button" id="followBtn" class="btn waves-effect btn-follow d-none" data-userid="<?= get_current_user_id(); ?>" data-uuid="<?= get_field('uuiduser_user', 'user_' . get_current_user_id()); ?>" data-relatedid="<?= $user_id; ?>" data-relateduuid="<?= get_field('uuiduser_user', 'user_' . $user_id); ?>" data-text="<?= get_the_author_meta('nickname', get_current_user_id()); ?> te guette !" data-url="<?= get_author_posts_url(get_current_user_id()); ?>">
                                    <span class="wording">Guetter</span>
                                    <span class="va va-guetteur-close va va-z-20 emoji"></span>
                                    <span class="va va-guetteur va va-z-20 emoji d-none notsee"></span>
                                  </button>
                                <?php else : ?>
                                  <a href="<?php the_permalink(get_page_by_path('se-connecter')); ?>" class="btn btn-flat-secondary waves-effect" data-toggle="tooltip" data-placement="top" title="" data-original-title="Tu dois être connecté pour guetter <?php echo $vainkeur_data_selected['pseudo']; ?>">
                                    <span class="text-muted">
                                      Guetter <span class="va va-guetteur-close va va-z-20 emoji"></span>
                                    </span>
                                  </a>
                                <?php endif; ?>
                              <?php endif; ?>
                            </td>
                          </tr>
                        <?php $r++;
                        endforeach; ?>
                      </tbody>
                    </table>
                  </div>
                </div>
              </section>
            </div>
          </div>
        </div>
      </div>
    <?php endif; ?>
  </div>
<?php endif; ?>

<?php get_footer(); ?>