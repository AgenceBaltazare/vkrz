<?php
global $infos_vainkeur;
get_header(); 
?>
<div class="app-content content">
  <div class="content-overlay position-fixed" style="z-index: -1 !important;"></div>
  <div class="header-navbar-shadow"></div>
  <div class="content-wrapper container-xxl p-0 mt-2">
    <div class="content-detached">
      <div class="content-body">
        <div class="blog blog-detail-wrapper">
          <div class="row">
            <div class="col-lg-9">
              <div class="card">
                <div class="card-body pt-50">
                  <div class="apropos">
                    <div class="card-text">
                      <h1 class="blog-title">
                        <?php the_title(); ?>
                      </h1>
                      <?php the_content(); ?>
                    </div>
                  </div>

                  <hr class="my-2">

                  <div class="infoauthor">
                    <div class="d-flex">
                      <div class="avatar mr-50">
                        <?= get_avatar(get_the_author_meta('ID'), 28); ?>
                      </div>
                      <div class="author-info">
                        <small class="text-muted me-25">par</small>
                        <small>
                          <a href="<?php echo get_author_posts_url(get_the_author_meta('ID')) ?>" class="text-body"><?php the_author(); ?></a>
                        </small>
                        <small class="text-muted me-25">le</small>
                        <small class="text-muted"><?= get_the_date(); ?></small>
                      </div>
                    </div>
                  </div>

                  <hr class="my-2">
                  <div class="blog-rs">
                    <div class="d-flex align-items-center">
                      <?php
                      $id_post        = get_the_ID();
                      $url_post       = get_the_permalink();
                      $title_post     = get_the_title();
                      $text_post      = get_the_excerpt();
                      ?>
                      <ul>
                        <li>
                          <h6 class="section-label text-center m-0">Partager</h6>
                        </li>
                        <!-- Facebook -->
                        <li>
                          <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo $url_post; ?>&quote=<?php echo $title_post; ?>" title="Share on Facebook" target="_blank">
                            <span>
                              <i class="fab fa-facebook-f"></i>
                            </span>
                          </a>
                        </li>
                        <!-- Twitter -->
                        <li>
                          <a href="https://twitter.com/intent/tweet?source=<?php echo $url_post; ?>&text=<?php echo $title_post; ?>:%20<?php echo $url_post; ?>" target="_blank" title="Tweet">
                            <span>
                              <i class="fab fa-twitter"></i>
                            </span>
                          </a>
                        </li>
                        <!-- Linkedin -->
                        <li>
                          <a href="https://www.linkedin.com/shareArticle?mini=true&url=<?php echo $url_post; ?>&title=<?php echo $title_post; ?>" target="_blank">
                            <span>
                              <i class="fab fa-linkedin-in"></i>
                            </span>
                          </a>
                        </li>
                        <!-- Whatsapp -->
                        <li class="whatsapp">
                          <a href="whatsapp://send?text=<?php echo $url_post; ?>" data-action="share/whatsapp/share">
                            <span>
                              <i class="fab fa-whatsapp"></i>
                            </span>
                          </a>
                        </li>
                      </ul>
                    </div>
                  </div>
                </div>
              </div>

              <div id="comments" class="comments-area">
                <?php
                global $post_comments_id;
                $post_comments_id = get_the_ID();

                $response_to_comment = false;
                $actual_link         = get_the_permalink($post_comments_id) . '?post=' . $post_comments_id;
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
                  <h2 class="comments-title mb-50">
                    <span class="t-rose"><?php echo $nb_comments; ?> <?php echo $comment_wording; ?></span>
                  </h2>

                  <div class="comment-list row">
                    <?php foreach ($comments as $comment) : ?>

                      <?php if ($comment->comment_parent == "0") : ?>
                        <div class="col-12 comment-min">
                          <div class="card" data-comment-id="<?php echo $comment->comment_ID; ?>" id="comment-<?php echo $comment->comment_ID; ?>">
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
                                      echo 'Lama2Lombre';
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
                            <div class="card" data-comment-id="<?php echo $comment->comment_ID; ?>" id="comment-<?php echo $comment->comment_ID; ?>">
                              <div class=" card-body">
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
                                        echo 'Lama2Lombre';
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
                        $autor_comment_email    = "";
                        $autor_comment_pseudo   = "";
                        $autor_comment_avatar   = "";
                        $top_reponse_id         = "";
                        if (is_user_logged_in()) {
                          $autor_comment_email  = $infos_vainkeur['user_email'];
                          $autor_comment_pseudo = $infos_vainkeur['pseudo'];
                          $autor_comment_avatar = $infos_vainkeur['avatar'];
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
                            </div>
                          </div>
                          <div class=" row mt-1">
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
            
            <div class="col-lg-3">
              <div class="sidebar">
                <div class="blog-sidebar my-2 my-lg-0">
                  <div class="blog-recent-posts">
                    <h6 class="section-label">Autres posts</h6>
                    <div class="mt-50">
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
                            <div class="blog-info ml-50">
                              <h6 class="blog-recent-post-title">
                                <a href="<?php the_permalink(); ?>" class="text-body-heading"><?= the_title(); ?></a>
                              </h6>
                              <div class="text-muted mb-0"><?= get_the_date(); ?></div>
                            </div>
                          </div>

                        <?php endwhile; ?>
                      <?php else : ?>
                        <?php echo wpautop("Désolé, aucun article n'a été trouvé. 😐"); ?>
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
      </div>
    </div>
  </div>
</div>
<?php get_footer(); ?>