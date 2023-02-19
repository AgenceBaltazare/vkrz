<?php
/*
  Template Name: Tops au hasard
*/
get_header();
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
$tops_rand          = new WP_Query(array(
  'post_type'                 => 'tournoi',
  'orderby'                   => 'rand',
  'order'                     => 'ASC',
  'posts_per_page'            => 3,
  'post__not_in'              => $list_user_tops,
  'ignore_sticky_posts'       => true,
  'update_post_meta_cache'    => false,
  'no_found_rows'             => true,
  'tax_query'                 => array(
    array(
      'taxonomy' => 'type',
      'field'    => 'slug',
      'terms'    => array('private'),
      'operator' => 'NOT IN'
    ),
  ),
));
?>
<div class="my-3">
  <div class="container-xxl">
    <div class="intro-archive">
      <h1>
        Ô hasard
      </h1>
      <h2>
        Voici 3 propositions en espérant que tu y trouves ton bonheur !
      </h2>
    </div>

    <section class="row mt-5">
      <?php $i = 1;
      while ($tops_rand->have_posts()) : $tops_rand->the_post(); ?>

        <div class="col-md-4">
          <?php get_template_part('partials/min-t'); ?>
        </div>

      <?php $i++;
      endwhile; ?>
    </section>

    <div class="text-center mt-5">
      <a href="<?php the_permalink(470569); ?>" class="btn btn-outline-primary btn-flat-primary waves-effect">
        Relancer 3 nouveaux Tops
      </a>
    </div>

  </div>
</div>

<?php get_footer(); ?>