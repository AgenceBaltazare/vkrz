<?php
global $top_infos;
global $id_top_global;
global $list_user_tops;
$top_cat = $top_infos['top_cat'];
foreach ($top_cat as $cat) {
  $top_cat_id = $cat->term_id;
  $top_cat_name = $cat->name;
}
$list_souscat  = array();
$top_souscat   = get_the_terms($id_top_global, 'concept');
if (!empty($top_souscat)) {
  foreach ($top_souscat as $souscat) {
    array_push($list_souscat, $souscat->slug);
  }
}
$tops_in_close_cat     = new WP_Query(array(
  'ignore_sticky_posts'    => true,
  'update_post_meta_cache' => false,
  'no_found_rows'          => true,
  'post_type'              => 'tournoi',
  'post__not_in'           => $list_user_tops,
  'orderby'                => 'rand',
  'order'                  => 'ASC',
  'posts_per_page'         => 12,
  'tax_query' => array(
    'relation' => 'AND',
    array(
      'taxonomy' => 'categorie',
      'field'    => 'term_id',
      'terms'    => array($top_cat_id)
    ),
    array(
      'taxonomy' => 'concept',
      'field' => 'slug',
      'terms' => $list_souscat
    ),
    array(
      'taxonomy' => 'type',
      'field'    => 'slug',
      'terms'    => array('private', 'whitelabel'),
      'operator' => 'NOT IN'
    ),
  ),
));
$count_similar = $tops_in_close_cat->post_count;
$count_next    = 12 - $count_similar;
if ($count_similar < 12) {
  $tops_in_large_cat     = new WP_Query(array(
    'ignore_sticky_posts'    => true,
    'update_post_meta_cache' => false,
    'no_found_rows'          => true,
    'post_type'              => 'tournoi',
    'post__not_in'           => $list_user_tops,
    'orderby'                => 'rand',
    'order'                  => 'ASC',
    'posts_per_page'         => $count_next,
    'tax_query' => array(
      'relation' => 'AND',
      array(
        'taxonomy' => 'categorie',
        'field'    => 'term_id',
        'terms'    => array($top_cat_id)
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
if ($tops_in_close_cat->have_posts() || $tops_in_large_cat->have_posts()) : ?>
  <section class="similar-tops text-center py-5">
    <h4 class="mb-3">
      Voici quelques Tops qui devraient te plaire <span class="va va-smiling-face-with-heart-eyes va-lg"></span>
    </h4>
    <div class="similar-list mt-2">
      <div class="row">
        <?php
        while ($tops_in_close_cat->have_posts()) : $tops_in_close_cat->the_post();
          get_template_part('partials/min-t');
        endwhile;
        if ($count_similar < 4) :
          while ($tops_in_large_cat->have_posts()) : $tops_in_large_cat->the_post();
            get_template_part('partials/min-t');
          endwhile;
        endif;
        ?>
      </div>
    </div>
    <div class="gocat">
      <?php $current = get_term_by('term_id', $top_cat_id, 'categorie'); ?>
      <a class="w-100 btn btn-primary waves-effect" href="<?php echo get_category_link($top_cat_id); ?>">
        Voir tous les Tops <span class="text-uppercase ms-1"> <?php echo $top_cat_name; ?> </span> <span class="ico"><?php the_field('icone_cat', 'term_' . $top_cat_id); ?></span>
      </a>
    </div>
  </section>
<?php endif; ?>