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
$tops_in_cat_vedette    = new WP_Query(array(
  'post_type'                 => 'tournoi',
  'orderby'                   => 'date',
  'order'                     => 'DESC',
  'posts_per_page'            => -1,
  'ignore_sticky_posts'       => true,
  'update_post_meta_cache'    => false,
  'no_found_rows'             => true,
  'meta_query' => array(
    array(
      'key'       => 'vedette_t',
      'value'     => '1',
      'compare'   => '=',
    )
  ),
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
$tops_in_cat            = new WP_Query(array(
  'post_type'                 => 'tournoi',
  'orderby'                   => 'date',
  'order'                     => 'DESC',
  'posts_per_page'            => -1,
  'ignore_sticky_posts'       => true,
  'update_post_meta_cache'    => false,
  'no_found_rows'             => true,
  'meta_query' => array(
    'relation' => 'OR',
    array(
      'key'       => 'vedette_t',
      'value'     => '1',
      'compare'   => '!=',
    ),
    array(
      'key'       => 'vedette_t',
      'compare'   => 'NOT EXISTS',
    )
  ),
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

      <?php if ($tops_in_cat->have_posts()) : $i = 1; ?>

        <section class="grid-to-filtre row match-height mt-2 tournois">

          <?php if ($tops_in_cat_vedette->have_posts()) :

            while ($tops_in_cat_vedette->have_posts()) : $tops_in_cat_vedette->the_post(); ?>
              <div class="col-md-3 col-sm-4 col-6">
                <?php get_template_part('partials/min-t'); ?>
              </div>
            <?php $i++;
            endwhile; 
          
          endif;

          while ($tops_in_cat->have_posts()) : $tops_in_cat->the_post(); ?>
            <div class="col-md-3 col-sm-4 col-6">
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
  </div>
</div>
<?php get_footer(); ?>