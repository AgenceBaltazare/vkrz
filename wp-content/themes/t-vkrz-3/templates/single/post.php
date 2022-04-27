<?php get_header(); ?>

<div class="app-content content">
  <div class="content-overlay position-fixed" style="z-index: -1 !important;"></div>
  <div class="header-navbar-shadow"></div>
  <div class="content-wrapper container-xxl p-0 mt-2">
    <div class="content-detached content-left">
      <div class="content-body">
        <!-- Blog Detail -->
        <div class="blog-detail-wrapper">
          <div class="row">
            <!-- Blog -->
            <div class="col-12">
              <div class="card">
                <img src="<?= get_the_post_thumbnail_url(); ?>" class="img-fluid card-img-top" alt="Blog Detail Pic">
                <div class="card-body">
                  <h4 class="card-title">
                    <?php the_title(); ?>
                  </h4>

                  <div class="d-flex">
                    <div class="avatar mr-25">
                      <?= get_avatar(get_the_author_meta('ID'), 28); ?>
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

                  <?php the_content(); ?>

                  <div class="d-flex align-items-start">
                    <div class="avatar mr-1">
                      <?= get_avatar(get_the_author_meta('ID'), 60); ?>
                    </div>
                    <div class="author-info">
                      <h6 class="fw-bolder">
                        <?php
                        $prenom = get_the_author_meta('first_name');
                        $nom = get_the_author_meta('last_name');
                        $nom_complet = '';

                        if (empty($prenom)) {
                          $nom_complet = $nom;
                        } elseif (empty($nom)) {
                          $nom_complet = $prenom;
                        } else {
                          $nom_complet = "{$prenom} {$nom}";
                        }

                        echo ucwords($nom_complet);
                        ?>
                      </h6>
                      <p class="card-text mb-0">
                        <?php the_author_meta('description'); ?>
                      </p>
                    </div>
                  </div>
                  <hr class="my-2">
                  <div class="d-flex align-items-center justify-content-between">
                    <div class="d-flex align-items-center">
                      <div class="d-flex align-items-center me-1">
                        <a href="<?php the_permalink(); ?>#comments" class="mr-50">
                          <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-message-square font-medium-5 text-body align-middle">
                            <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path>
                          </svg>
                        </a>
                        <a href="<?php the_permalink(); ?>#comments">
                          <div class="text-body align-middle"><?= get_comments_number() ?></div>
                        </a>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!--/ Blog -->

            <!-- Blog Comment -->
            <div class="container">
              <div class="row">
                <div class="col-12">
                  <div id="comments" class="comments-area">
                    <?php
                    global $post_comments_id;
                    $post_comments_id = get_the_ID();

                    $response_to_comment = false;
                    $actual_link         = get_the_permalink(get_page_by_path('discuz')) . '?id_top=' . $post_comments_id;
                    $comments            = get_comments('status=approve&type=comments&hierarchical=true&post_id=' . $post_comments_id);
                    $nb_comments         = count($comments);
                    if (isset($_GET['replytocom']) && $_GET['replytocom'] != "") {
                      $response_to_comment = true;
                    }
                    if ($nb_comments > 1) {
                      $comment_wording = "commentaires";
                    } else {
                      $comment_wording = "commentaire";
                    }

                    if ($nb_comments > 0) : ?>
                      <h2 class="comments-title">
                        <span class="t-rose"><?php echo $nb_comments; ?> <?php echo $comment_wording; ?></span> sur le Poste <?php echo get_the_title($post_comments_id); ?> <span class="text-muted"><?php the_field('question_t', $post_comments_id); ?></span>
                      </h2>

                      <div class="comment-list row">
                        <?php foreach ($comments as $comment) : ?>

                          <?php if ($comment->comment_parent == "0") : ?>
                            <div class="col-12 comment-min">
                              <div class="card" data-comment-id="<?php echo $comment->comment_ID; ?>">
                                <div class="card-body">
                                  <div class="d-flex align-items-start">
                                    <div class="avatar me-75 mr-1">
                                      <?php
                                      if ($comment->comment_author_email) {
                                        $comment_autor      = get_user_by('email', $comment->comment_author_email);
                                        $comment_autor_id   = $comment_autor->ID;
                                        $avatar_url         = get_avatar_url($comment_autor_id, ['size' => '180', 'force_default' => false]);
                                      } else {
                                        $avatar_url         = get_bloginfo('template_directory') . '/assets/images/vkrz/avatar-rose.png';
                                      }
                                      ?>
                                      <img src="<?php echo $avatar_url; ?>" width="60" height="60" alt="Avatar">
                                    </div>
                                    <div class="author-info">
                                      <h6 class="fw-bolder mb-25">
                                        <?php
                                        if ($comment->comment_author_email) {
                                          echo $comment_autor->nickname;
                                        } else {
                                          echo 'Anonyme';
                                        }
                                        ?>
                                      </h6>
                                      <p class="card-text text-muted">
                                        <small><?php echo $comment->comment_date; ?></small>
                                      </p>
                                      <p class="card-text">
                                        <?php echo $comment->comment_content; ?>
                                      </p>
                                      <?php if ($comment->comment_parent == "0") : ?>
                                        <div class="reply-link">
                                          <a href="<?php echo $actual_link; ?>&replytocom=<?php echo $comment->comment_ID; ?>#respond" class="d-inline-flex align-items-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-corner-up-left font-medium-3 me-50">
                                              <polyline points="9 14 4 9 9 4"></polyline>
                                              <path d="M20 20v-7a4 4 0 0 0-4-4H4"></path>
                                            </svg>
                                            <span class="ml-05">Répondre</span>
                                          </a>
                                        </div>
                                      <?php endif; ?>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div>
                          <?php endif; ?>

                          <?php
                          $sub_comments    = get_comments('status=approve&type=comments&hierarchical=true&parent=' . $comment->comment_ID);
                          $nb_sub_comments = count($sub_comments);
                          if ($nb_sub_comments > 0) :
                            foreach (array_reverse($sub_comments) as $comment) : ?>
                              <div class="col-12 comment-min sub-comment-min">
                                <div class="card" data-comment-id="<?php echo $comment->comment_ID; ?>">
                                  <div class="card-body">
                                    <div class="d-flex align-items-start">
                                      <div class="avatar me-75 mr-1">
                                        <?php
                                        if ($comment->comment_author_email) {
                                          $comment_autor      = get_user_by('email', $comment->comment_author_email);
                                          $comment_autor_id   = $comment_autor->ID;
                                          $avatar_url         = get_avatar_url($comment_autor_id, ['size' => '180', 'force_default' => false]);
                                        } else {
                                          $avatar_url         = get_bloginfo('template_directory') . '/assets/images/vkrz/avatar-rose.png';
                                        }
                                        ?>
                                        <img src="<?php echo $avatar_url; ?>" width="60" height="60" alt="Avatar">
                                      </div>
                                      <div class="author-info">
                                        <h6 class="fw-bolder mb-25">
                                          <?php
                                          if ($comment->comment_author_email) {
                                            echo $comment_autor->nickname;
                                          } else {
                                            echo 'Anonyme';
                                          }
                                          ?>
                                        </h6>
                                        <p class="card-text text-muted">
                                          <small><?php echo $comment->comment_date; ?></small>
                                        </p>
                                        <p class="card-text">
                                          <?php echo $comment->comment_content; ?>
                                        </p>
                                        <?php if ($comment->comment_parent == "0") : ?>
                                          <div class="reply-link">
                                            <a href="<?php echo $actual_link; ?>&replytocom=<?php echo $comment->comment_ID; ?>#respond" class="d-inline-flex align-items-center">
                                              <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-corner-up-left font-medium-3 me-50">
                                                <polyline points="9 14 4 9 9 4"></polyline>
                                                <path d="M20 20v-7a4 4 0 0 0-4-4H4"></path>
                                              </svg>
                                              <span class="ml-05">Répondre</span>
                                            </a>
                                          </div>
                                        <?php endif; ?>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                              </div>
                          <?php endforeach;
                          endif;
                          ?>
                        <?php endforeach; ?>
                      </div>

                      <?php
                      the_comments_pagination(
                        array(
                          'before_page_number' => esc_html__('Page', 'twentytwentyone') . ' ',
                          'mid_size'           => 0,
                          'prev_text'          => "",
                          'next_text'          => "",
                        )
                      );
                      ?>
                    <?php else : ?>
                      <h2 class="comments-title">
                        <?php echo get_the_title($post_comments_id); ?> <span class="text-muted"><?php the_field('question_t', $post_comments_id); ?></span>
                      </h2>
                    <?php endif; ?>

                    <div id="respond" class="comment-form mt-3">

                      <h3 class="title-bloc mt-25">
                        <?php if ($response_to_comment) : ?>
                          <span class="t-violet">💬 Répondre au com #<?php echo $_GET['replytocom']; ?></span> <a href="<?php echo $actual_link; ?>">Annuler la réponse</a>
                        <?php else : ?>
                          <?php if ($nb_comments > 0) : ?>
                            <span class="t-violet">💬 Lâche ton meilleur commentaire</span>
                          <?php else : ?>
                            <span class="t-violet">💬 Soit le premier à laisser un commentaire <span>🤟</span></span>
                          <?php endif; ?>
                        <?php endif; ?>
                        </h6>
                        <div class="card mt-1">
                          <div class="card-body">
                            <?php
                            global $user_infos;
                            $autor_comment_email    = "";
                            $autor_comment_pseudo   = "";
                            $autor_comment_avatar   = "";
                            $top_reponse_id         = "";
                            if (is_user_logged_in()) {
                              $autor_comment_email  = $user_infos['user_email'];
                              $autor_comment_pseudo = $user_infos['pseudo'];
                              $autor_comment_avatar = $user_infos['avatar'];
                            }
                            if (!$autor_comment_avatar) {
                              $autor_comment_avatar = get_bloginfo('template_directory') . '/assets/images/vkrz/avatar-rose.png';
                            }
                            if ($response_to_comment) {
                              $top_reponse_id       = $_GET['replytocom'];
                            }
                            ?>
                            <form id="commentform" action="<?php echo get_option('siteurl'); ?>/wp-comments-post.php" method="post" class="form">
                              <div class="d-flex align-items-center">
                                <div class="avatar me-75 mr-1">
                                  <img src="<?php echo $autor_comment_avatar; ?>" width="60" height="60" alt="Avatar">
                                </div>
                                <div class="pseudo-input">
                                  <input class="form-control" id="author" name="author" type="text" <?php if (is_user_logged_in()) {
                                                                                                      echo 'disabled';
                                                                                                    } ?> placeholder="Pseudo" value="<?php echo $autor_comment_pseudo; ?>" />
                                  <input class="form-control" id="email" name="email" type="hidden" placeholder="Email" value="<?php echo $autor_comment_email; ?>" />
                                  <input class="form-control" id="my_redirect_to" name="my_redirect_to" type="hidden" value="<?php echo $actual_link; ?>" />
                                </div>
                              </div>
                              <div class="row mt-1">
                                <div class="col-12">
                                  <?php if (!$response_to_comment) : ?>
                                    <textarea id="comment" class="form-control mb-2" rows="4" placeholder="Ton commentaire" name="comment"></textarea>
                                  <?php else : ?>
                                    <textarea id="comment" class="form-control mb-2" rows="4" placeholder="Ta réponse" name="comment"></textarea>
                                  <?php endif; ?>
                                </div>
                                <div class="col-12">
                                  <input name="submit" class="btn btn-primary waves-effect waves-float waves-light" type="submit" id="submit-comment" value="Poster mon commentaire">
                                  <input type="hidden" name="comment_post_ID" value="<?php echo $post_comments_id; ?>" id="comment_post_ID">
                                  <input type="hidden" name="comment_parent" id="comment_parent" value="<?php echo $top_reponse_id; ?>">
                                </div>
                              </div>
                            </form>
                          </div>
                        </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!--/ Blog Comment -->
          </div>
        </div>
        <!--/ Blog Detail -->
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
                'paged' => $paged,
                'post__not_in'  => array(get_the_ID())
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

<?php get_footer(); ?>