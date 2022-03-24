<?php global $top_comments_id; ?>
<div id="comments" class="comments-area">
  <?php
  $response_to_comment = false;
  $actual_link         = get_the_permalink(get_page_by_path('discuz')) . '?id_top=' . $top_comments_id;
  $comments            = get_comments('status=approve&type=comments&hierarchical=true&post_id=' . $top_comments_id);
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
      <span class="t-rose"><?php echo $nb_comments; ?> <?php echo $comment_wording; ?></span> sur le Top <?php the_field('count_contenders_t', $top_comments_id); ?> <span class="ico">⚡️</span> <?php echo get_the_title($top_comments_id); ?> <span class="text-muted"><?php the_field('question_t', $top_comments_id); ?></span>
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
          foreach ($sub_comments as $comment) : ?>
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
      Top <?php the_field('count_contenders_t', $top_comments_id); ?> <span class="ico">⚡️</span> <?php echo get_the_title($top_comments_id); ?> <span class="text-muted"><?php the_field('question_t', $top_comments_id); ?></span>
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
                <input type="hidden" name="comment_post_ID" value="<?php echo $top_comments_id; ?>" id="comment_post_ID">
                <input type="hidden" name="comment_parent" id="comment_parent" value="<?php echo $top_reponse_id; ?>">
              </div>
            </div>
          </form>
        </div>
      </div>
  </div>
</div>