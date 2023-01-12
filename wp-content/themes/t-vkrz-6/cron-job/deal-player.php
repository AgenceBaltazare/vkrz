<?php
include __DIR__ . '/../../../../wp-load.php';

$players = new WP_Query(array(
  'post_type'              => 'player',
  'posts_per_page'         => -1,
  'fields'                 => 'ids',
  'post_status'            => 'publish',
  'ignore_sticky_posts'    => true,
  'update_post_meta_cache' => false,
  'no_found_rows'          => false,
  'orderby'                => 'date',
  'order'                  => 'DESC',
  'meta_query' => array(
    array(
      'key'     => 'sendtofirebase',
      'compare' => 'NOT EXISTS',
    ),
  )
));
if ($players->have_posts()) {

  foreach ($players->posts as $player_id) {

    $uuid_vainkeur  = get_field('uuid_vainkeur_p', $player_id);
    $id_vainkeur    = get_vainkeur_id($uuid_vainkeur);
    $id_top         = get_field('id_t_p', $player_id);
    $id_ranking     = get_field('id_r_p', $player_id);
    $email_player   = get_field('email_player_p', $player_id);

    ?>
    <script>
        const vkrz_ajaxurl = "<?= admin_url('admin-ajax.php') ?>";
        const id_vainkeur = "<?= $id_vainkeur ?>";
    </script>


    <?php


    update_field('sendtofirebase', date('d/m/Y'), $player_id);

  }
}
