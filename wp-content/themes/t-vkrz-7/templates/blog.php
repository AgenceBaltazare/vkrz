<?php
/*
    Template Name: Blog
*/
get_header(); ?>

<div class="row mt-lg-3">
  <div class="col-sm-9">
    <div class="content-detached content-left">
      <div class="content-body">

        <div class="intro-mobile">
          <div class="tournament-heading text-center">
            <h3 class="mb-0 t-titre-tournoi">
              BLOG
            </h3>
            <h4 class="mb-0">De la littérature littéralement envoûtante <span class="va va-upside-down-face va-md"></span></h4>
          </div>
        </div>

        <div class="blog-list-wrapper">
          <div class="row">
            <?php
            $posts = new WP_Query(array('post_type' => 'post', 'post_status' => 'publish', 'posts_per_page' => -1)); ?>

            <?php if ($posts->have_posts()) : ?>
              <?php while ($posts->have_posts()) : $posts->the_post(); ?>

                <div class="col-md-6 col-12">
                  <div class="card blog-min">
                    <a href="<?php the_permalink(); ?>">
                      <div class="cover" style="background: url(<?= get_the_post_thumbnail_url(); ?>) center center no-repeat; min-height: 320px; width: auto;">
                      </div>
                    </a>
                    <div class="card-body">
                      <h4 class="card-title">
                        <a href="<?php the_permalink(); ?>" class="blog-title-truncate text-body-heading"><?= the_title(); ?></a>
                      </h4>
                      <div class="d-flex">
                        <div class="avatar mr-25">
                          <?= get_avatar(get_the_author_meta('ID'), 28); ?>

                          <a href="<?= get_author_posts_url(get_the_author_meta('ID')); ?>" class="stretched-link"></a>
                        </div>
                        <div class="author-info">
                          <small class="text-muted me-25">par</small>
                          <small>
                            <a href="<?php echo get_author_posts_url(get_the_author_meta('ID')) ?>" class="text-body"><?php the_author(); ?></a>
                          </small>
                          <span class="text-muted ms-50 me-25">|</span>
                          <small class="text-muted"><?= get_the_date(); ?></small>
                        </div>
                      </div>
                      <!--
                          <div class="my-1 py-25">
                            <?php
                            foreach (get_the_terms(get_the_ID(), 'category') as $cat) {
                              $cat_id     = $cat->term_id;
                              $cat_name   = $cat->name;
                            }
                            ?>
                            <a href="<?= get_category_link($cat_id); ?>">
                              <span class="badge rounded-pill badge-light-info me-50">
                                <?= $cat_name; ?>
                              </span>
                            </a>
                          </div>
                          -->
                      <p class="card-text blog-content-truncate">
                        <?php echo get_the_excerpt(); ?>
                      </p>
                      <hr>
                      <div class="d-flex justify-content-between align-items-center">
                        <a href="<?php the_permalink(); ?>#comments">
                          <div class="d-flex align-items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-message-square font-medium-1 text-body me-50">
                              <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path>
                            </svg>
                            <span class="text-body fw-bold ml-25">
                              <?= get_comments_number() >= 1 ?  get_comments_number() . ' Commentaires' : get_comments_number() . ' Commentaire' ?></span>
                          </div>
                        </a>
                        <a href="<?php the_permalink(); ?>" class="btn btn-max btn-primary">Lire</a>
                      </div>
                    </div>
                  </div>
                </div>
              <?php endwhile; ?>
            <?php else : ?>
              <?= wpautop("Désolé, aucun article n'a été trouvé. 😐"); ?>
            <?php endif; ?>

            <?php
            wp_reset_query();
            wp_reset_postdata();
            ?>

          </div>
          <!--/ Blog List Items -->

        </div>
        <!--/ Blog List -->

      </div>
    </div>
  </div>

  <div class="col-sm-3">
    <div class="sidebar-detached sidebar-right">
      <div class="sidebar">
        <div class="blog-sidebar my-2 my-lg-0">
          <div class="blog-recent-posts">
            <h6 class="section-label">Actualités</h6>
            <div class="mt-75">

              <?php
              $paged = get_query_var('paged') ? get_query_var('paged') : 1;
              $args = array(
                'post_type' => 'post',
                'posts_per_page' => 3,
                'paged' => $paged
              );
              $recent_posts = new Wp_Query($args);
              ?>

              <?php if ($recent_posts->have_posts()) : ?>
                <?php while ($recent_posts->have_posts()) : $recent_posts->the_post(); ?>

                  <div class="d-flex mb-2">
                    <a href="<?php the_permalink(); ?>" class="me-2">
                      <img class="rounded" src="<?= get_the_post_thumbnail_url(); ?>" width="90" height="60" alt="Recent Post Pic">
                    </a>
                    <div class="blog-info ml-50">
                      <h6 class="blog-recent-post-title">
                        <a href="<?php the_permalink(); ?>" class="text-body-heading"><?= the_title(); ?></a>
                      </h6>
                      <div class="text-muted mb-0"><?= get_the_date(); ?></div>
                    </div>
                  </div>

                <?php endwhile; ?>
              <?php else : ?>
                <?php echo wpautop('Sorry, No posts were found'); ?>
              <?php endif; ?>

              <?php
              wp_reset_query();
              wp_reset_postdata();
              ?>

            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>


<?php get_footer(); ?>