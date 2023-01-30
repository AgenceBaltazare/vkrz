<?php
/*
  Template Name: Best of - Tops
*/
get_header();
?>
<div class="my-2">
  <div class="container-xxl">
    <div class="intro-archive">
      <h1>
        Les Tops les plus populaires sur VAINKEURZ
      </h1>
    </div>
  </div>

  <div class="container-xxl">
    <div class="row">
      <div class="col">
        <div class="classement">
          <section id="profile-info">
            <div class="card">
              <div class="table-responsive">
                <table class="table table-bestops">
                  <thead>
                    <tr>
                      <th>
                        <span class="va va-chequered-flag va-lg"></span>
                      </th>
                      <th class="text-left">
                        <span class="text-muted">Top</span>
                      </th>
                      <th class="text-center shorted">
                        <span class="text-muted">TopList <span class="va va-updown va-z-15"></span></span>
                      </th>
                      <th class="text-center shorted">
                        <span class="text-muted">Votes <span class="va va-updown va-z-15"></span></span>
                      </th>
                      <th class="text-center">
                        <span class="text-muted">TopList mondiale</span>
                      </th>
                      <th class="text-right">
                        <span class="text-muted">Conçu par</span>
                      </th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    $r = 1;
                    $best_tops = new WP_Query(array(
                      'ignore_sticky_posts'       => true,
                      'update_post_meta_cache'    => false,
                      'no_found_rows'             => true,
                      'post_type'                 => 'resume',
                      'orderby'                   => 'meta_value_num',
                      'meta_key'                  => 'nb_tops_resume',
                      'order'                     => 'DESC',
                      'posts_per_page'            => 20
                    ));
                    while ($best_tops->have_posts()) : $best_tops->the_post();
                      $id_top   = get_field('id_top_resume');
                      $type_top = array();
                      $type_top = get_the_terms($id_top, 'type');
                      $slug_type_top = array();
                      if ($type_top) {
                        foreach ($type_top as $type) {
                          array_push($slug_type_top, $type->slug);
                        }
                      }
                      if (get_post_status($id_top) == "publish" && !in_array('private', $slug_type_top)) : ?>
                        <tr>
                          <td>
                            <?php if ($r == 1) : ?>
                              <span class="ico va va-medal-1 va-lg"></span>
                            <?php elseif ($r == 2) : ?>
                              <span class="ico va va-medal-2 va-lg"></span>
                            <?php elseif ($r == 3) : ?>
                              <span class="ico va va-medal-3 va-lg"></span>
                            <?php else : ?>
                              #<?php echo $r; ?>
                            <?php endif; ?>
                          </td>
                          <td>
                            <?php get_template_part('partials/top-card'); ?>
                          </td>

                          <td class="text-center">
                            <a href="<?php the_permalink(get_page_by_path('liste-des-tops')); ?>?id_top=<?php echo $id_top; ?>" class="btn btn-flat-secondary waves-effect text-white" data-toggle="tooltip" data-placement="top" title="" data-original-title="Voir toutes les TopList">
                              <?php the_field('nb_tops_resume'); ?>&nbsp;<span class="ico va-trophy va va-lg"></span>
                            </a>
                          </td>

                          <td class="text-center">
                            <?php the_field('nb_votes_resume'); ?> <span class="ico va-high-voltage va va-lg"></span>
                          </td>

                          <td class="text-center">
                            <a href="<?php the_permalink(get_page_by_path('elo')); ?>?id_top=<?php echo $id_top; ?>" class="btn btn-label-primary waves-effect" data-toggle="tooltip" data-placement="top" title="" data-original-title="Voir la TopList mondiale">
                              Voir <span class="ms-2 va-globe va va-lg"></span>
                            </a>
                          </td>

                          <td class="text-right">
                            <?php
                            global $vainkeur_data_selected;
                            $creator_id             = get_post_field('post_author', $id_top);
                            $creator_uuiduser       = get_field('uuiduser_user', 'user_' . $creator_id);
                            $vainkeur_data_selected = get_user_infos($creator_uuiduser);
                            ?>
                            <?php get_template_part('partials/vainkeur-card'); ?>
                          </td>
                        </tr>
                    <?php endif;
                      $r++;
                    endwhile; ?>
                  </tbody>
                </table>
              </div>
            </div>
          </section>
        </div>
      </div>
    </div>
  </div>
  <?php get_footer(); ?>