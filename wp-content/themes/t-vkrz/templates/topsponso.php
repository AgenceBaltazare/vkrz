<?php
/*
  Template Name: Tops sponso
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
$tops_sponso            = new WP_Query(array(
  'post_type'                 => 'tournoi',
  'orderby'                   => 'date',
  'order'                     => 'ASC',
  'posts_per_page'            => -1,
  'ignore_sticky_posts'       => true,
  'update_post_meta_cache'    => false,
  'no_found_rows'             => true,
  'tax_query'                 => array(
    'relation' => 'AND',
    array(
      'taxonomy' => 'type',
      'field'    => 'slug',
      'terms'    => array('sponso'),
      'operator' => 'IN'
    ),
    array(
      'taxonomy' => 'type',
      'field'    => 'slug',
      'terms'    => array('private'),
      'operator' => 'NOT IN'
    ),
  ),
));
?>
<div class="my-2">
  <div class="container-xxl">
    <div class="intro-archive">
      <div class="iconarchive">
        <span class="va va-wrapped-gift va-lg"></span>
      </div>
      <h1>
        Top sponso <span class="infonbtops"><?php echo $tops_sponso->post_count; ?> Tops</span>
      </h1>
      <h2>
        Ici on ne gagne pas à tous les coups - certes - mais on se donne une chance <span class="va va-chance va-lg"></span>
      </h2>
    </div>
  </div>

  <div class="container-xxl">
    <section class="row">
      <?php while ($tops_sponso->have_posts()) : $tops_sponso->the_post(); ?>
        <div class="col-md-4 col-sm-2 col-12">
          <?php get_template_part('partials/min-t'); ?>
        </div>
      <?php endwhile; ?>
    </section>
  </div>
</div>

<?php get_footer(); ?>