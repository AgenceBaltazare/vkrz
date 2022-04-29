<?php
get_header();
global $user_tops;
$list_user_tops     = $user_tops['list_user_tops'];
$current_cat        = get_queried_object();
$tops_in_cat        = new WP_Query(array(
  'post_type'                 => 'post',
  'orderby'                   => 'date',
  'order'                     => 'DESC',
  'posts_per_page'            => -1,
  'ignore_sticky_posts'       => true,
  'update_post_meta_cache'    => false,
  'no_found_rows'             => true,
  'tax_query'                 => array(
    'relation' => 'AND',
    array(
      'taxonomy' => $current_cat->taxonomy,
      'field'    => 'term_id',
      'terms'    => $current_cat->term_taxonomy_id,
    )
  ),
));
$list_tags        = array();
$list_concepts    = array();
$list_sujets      = array();
?>
<div class="app-content content ecommerce-application">
  <div class="content-overlay"></div>
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

      <section id="ecommerce-header" class="mb-2 mt-2">
        <div id="ecommerce-searchbar" class="ecommerce-searchbar">
          <div class="input-group input-group-merge">
            <form action="?" method="get" id="search_form">
              <span class="ico ico-search ico-search-result va va-magnifying-glass-tilted-left va-lg"></span>
              <span class="ico ico-search ico-search-clear">❌</span>
              <input type="text" class="form-control search-product" placeholder="Rechercher dans les <?php echo $tops_in_cat->post_count; ?> Articles..." aria-label="Rechercher..." aria-describedby="shop-search" />
            </form>
          </div>
        </div>
      </section>

      <section class="grid-to-filtre row match-height mt-2">
        <?php $i = 1;
        while ($tops_in_cat->have_posts()) : $tops_in_cat->the_post(); ?>
          <div data-filter-item data-filter-name="<?php echo $term_to_search; ?>" class="card same-h grid-item col-md-3 col-6 mr-1">
            <a href="<?php the_permalink(); ?>">
              <img class="card-img-top img-fluid" src="<?= get_the_post_thumbnail_url(); ?>" alt="Blog Post pic">
            </a>

            <div class="card-body p-25">
              <h4 class="card-title mt-50">
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

              <p class="card-text blog-content-truncate">

                <?= the_excerpt(); ?>
              </p>
              <hr>

              <div class="d-flex flex-md-row flex-column justify-content-between align-items-center mb-1">
                <a href="<?php the_permalink(); ?>#comments">
                  <div class="d-flex align-items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-message-square font-medium-1 text-body me-50">
                      <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path>
                    </svg>
                    <span class="text-body fw-bold ml-25">
                      <?= get_comments_number() >= 1 ?  get_comments_number() . ' Commentaires' : get_comments_number() . ' Commentaire' ?></span>
                  </div>
                </a>

                <a href="<?php the_permalink(); ?>" class="btn btn-max btn-primary m-sm-0 mt-50">Lire</a>
              </div>
            </div>
          </div>
        <?php $i++;
        endwhile; ?>
      </section>
    </div>
  </div>
</div>
<?php get_footer(); ?>