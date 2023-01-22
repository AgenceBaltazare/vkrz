<?php
/*
    Template Name: Blog
*/
get_header(); ?>
<div class="my-3">
  <div class="container-xxl">
    <div class="intro-archive">
      <h1>
        BLOG
      </h1>
      <h2>
        De la littérature littéralement envoûtante <span class="va va-upside-down-face va-md"></span>
      </h2>
    </div>
  </div>
  <div class="container-xxl">
    <div class="blog-list-wrapper">
      <div class="row">
        <?php
        $posts = new WP_Query(array('post_type' => 'post', 'post_status' => 'publish', 'posts_per_page' => -1));
        if ($posts->have_posts()) :
          while ($posts->have_posts()) : $posts->the_post(); ?>
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
                  <p class="card-text blog-content-truncate">
                    <?php echo get_the_excerpt(); ?>
                  </p>
                  <hr>
                  <div class="d-flex align-items-center justify-content-start mt-2">
                    <div class="avatar me-2">
                      <?= get_avatar(get_the_author_meta('ID'), 28); ?>
                      <a href="<?= get_author_posts_url(get_the_author_meta('ID')); ?>" class="stretched-link"></a>
                    </div>
                    <div class="author-info">
                      <small class="text-muted me-25">par</small>
                      <small>
                        <a href="<?php echo get_author_posts_url(get_the_author_meta('ID')) ?>" class="text-body"><?php the_author(); ?></a>
                      </small>
                      <span class="text-muted ms-50 me-25">le</span>
                      <small class="text-muted"><?= get_the_date(); ?></small>
                    </div>
                  </div>
                  <hr>
                  <div class="d-flex justify-content-between align-items-center">
                    <a href="<?php the_permalink(); ?>#comments">
                      <div class="d-flex align-items-center">
                        <span class="va va-writing-hand va-lg me-2"></span>
                        <span class="text-body">
                          <?= get_comments_number() >= 1 ?  get_comments_number() . ' Commentaires' : get_comments_number() . ' Commentaire' ?></span>
                      </div>
                    </a>
                    <a href="<?php the_permalink(); ?>" class="btn btn-max btn-primary">Lire</a>
                  </div>
                </div>
              </div>
            </div>
        <?php endwhile;
        endif;
        wp_reset_query();
        wp_reset_postdata();
        ?>
      </div>
    </div>
  </div>
</div>
<?php get_footer(); ?>