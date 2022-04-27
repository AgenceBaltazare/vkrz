<?php
/*
    Template Name: Blog
*/
?>
<?php get_header(); ?>

<!-- BEGIN: Content-->
<div class="app-content content ">
  <div class="content-overlay position-fixed" style="z-index: -1 !important;"></div>
  <div class="header-navbar-shadow"></div>
  <div class="content-wrapper container-xxl p-0 mt-2">
    <div class="content-detached content-left">
      <div class="content-body">
        <!-- Blog List -->
        <div class="blog-list-wrapper">
          <!-- Blog List Items -->
          <div class="row">

            <?php
            $posts = new WP_Query(array('post_type' => 'post', 'post_status' => 'publish', 'posts_per_page' => -1)); ?>

            <?php if ($posts->have_posts()) : ?>
              <?php while ($posts->have_posts()) : $posts->the_post(); ?>

                <div class="col-md-6 col-12">
                  <div class="card">
                    <a href="<?php the_permalink(); ?>">
                      <img class="card-img-top img-fluid" src="<?= get_the_post_thumbnail_url(); ?>" alt="Blog Post pic">
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

                      <p class="card-text blog-content-truncate">

                        <?= the_excerpt(); ?>
                      </p>
                      <hr>

                      <div class="d-flex justify-content-between align-items-center">
                        <a href="<?php the_permalink(); ?>#comments">
                          <div class="d-flex align-items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-message-square font-medium-1 text-body me-50">
                              <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path>
                            </svg>
                            <span class="text-body fw-bold"><?= get_comments_number() ?> Commentaires</span>
                          </div>
                        </a>

                        <a href="<?php the_permalink(); ?>" class="fw-bold">Lire la suite</a>
                      </div>
                    </div>
                  </div>
                </div>

              <?php endwhile; ?>
            <?php else : ?>
              <?= wpautop('Sorry, No posts were found'); ?>
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
    <div class="sidebar-detached sidebar-right">
      <div class="sidebar">
        <div class="blog-sidebar my-2 my-lg-0">
          <!-- Recent Posts -->
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
                    <div class="blog-info ml-25">
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
          <!--/ Recent Posts -->

          <!-- Categories -->
          <div class="blog-categories mt-3">
            <h6 class="section-label">Catégories</h6>
            <div class="mt-1">

              <?php
              $categories = get_terms(array(
                'taxonomy'      => 'category',
                'orderby'       => 'count',
                'order'         => 'DESC',
                'hide_empty'    => true,
              ));

              $styles = [
                'bg-light-primary',
                'bg-light-success',
                'bg-light-danger'
              ];
              $i = 0;
              foreach ($categories as $category) : ?>
                <div class="d-flex justify-content-start align-items-center mb-75">
                  <a href="<?php echo get_category_link($category->term_id); ?>" class="mr-25">
                    <div class="avatar <?= $styles[$i++]; ?> rounded">
                      <div class="avatar-content">
                        <?php the_field('icone_cat_article', 'term_' . $category->term_id); ?>
                      </div>
                    </div>
                  </a>

                  <a href="<?php echo get_category_link($category->term_id); ?>">
                    <div class="blog-category-title text-body">
                      <?php echo $category->name; ?>
                    </div>
                  </a>
                </div>
              <?php endforeach; ?>

              <!--
              <div class="d-flex justify-content-start align-items-center mb-75">
                <a href="#" class="me-75">
                  <div class="avatar bg-light-success rounded">
                    <div class="avatar-content">
                      <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-shopping-cart avatar-icon font-medium-1">
                        <circle cx="9" cy="21" r="1"></circle>
                        <circle cx="20" cy="21" r="1"></circle>
                        <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path>
                      </svg>
                    </div>
                  </div>
                </a>
                <a href="#">
                  <div class="blog-category-title text-body">Food</div>
                </a>
              </div>
              <div class="d-flex justify-content-start align-items-center mb-75">
                <a href="#" class="me-75">
                  <div class="avatar bg-light-danger rounded">
                    <div class="avatar-content">
                      <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-command avatar-icon font-medium-1">
                        <path d="M18 3a3 3 0 0 0-3 3v12a3 3 0 0 0 3 3 3 3 0 0 0 3-3 3 3 0 0 0-3-3H6a3 3 0 0 0-3 3 3 3 0 0 0 3 3 3 3 0 0 0 3-3V6a3 3 0 0 0-3-3 3 3 0 0 0-3 3 3 3 0 0 0 3 3h12a3 3 0 0 0 3-3 3 3 0 0 0-3-3z"></path>
                      </svg>
                    </div>
                  </div>
                </a>
                <a href="#">
                  <div class="blog-category-title text-body">Gaming</div>
                </a>
              </div>
              <div class="d-flex justify-content-start align-items-center mb-75">
                <a href="#" class="me-75">
                  <div class="avatar bg-light-info rounded">
                    <div class="avatar-content">
                      <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-hash avatar-icon font-medium-1">
                        <line x1="4" y1="9" x2="20" y2="9"></line>
                        <line x1="4" y1="15" x2="20" y2="15"></line>
                        <line x1="10" y1="3" x2="8" y2="21"></line>
                        <line x1="16" y1="3" x2="14" y2="21"></line>
                      </svg>
                    </div>
                  </div>
                </a>
                <a href="#">
                  <div class="blog-category-title text-body">Quote</div>
                </a>
              </div>
              <div class="d-flex justify-content-start align-items-center">
                <a href="#" class="me-75">
                  <div class="avatar bg-light-warning rounded">
                    <div class="avatar-content">
                      <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-video avatar-icon font-medium-1">
                        <polygon points="23 7 16 12 23 17 23 7"></polygon>
                        <rect x="1" y="5" width="15" height="14" rx="2" ry="2"></rect>
                      </svg>
                    </div>
                  </div>
                </a>
                <a href="#">
                  <div class="blog-category-title text-body">Video</div>
                </a>
              </div>
              -->

            </div>
          </div>
          <!--/ Categories -->
        </div>
      </div>
    </div>
  </div>
</div>
<!-- END: Content-->

<?php get_footer(); ?>