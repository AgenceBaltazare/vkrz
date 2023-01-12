<?php
$top_cat = $top_infos['top_cat'];
foreach ($top_cat as $cat) {
  $top_cat_id = $cat->term_id;
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
  'posts_per_page'         => 4,
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
$count_next    = 4 - $count_similar;

if ($count_similar < 4) {

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
  <section class="list-tournois">
    <div class="mt-1 pslim">
      <h4 class="card-title">
        <span class="ico">🥰</span> Tops similaires
      </h4>
      <h6 class="card-subtitle text-muted mb-1">
        Voici quelques Tops qui devraient te plaire <span class="ico">👇</span>
      </h6>
    </div>
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
        Voir tous les Tops <span class="text-uppercase"><?php echo $cat_name; ?></span> <span class="ico"><?php the_field('icone_cat', 'term_' . $top_cat_id); ?></span>
      </a>
    </div>
    <div class="separate mt-2 mb-2"></div>
  </section>
<?php endif; ?>