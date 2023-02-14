<?php
global $commu_id;
$cover_commu  = get_the_post_thumbnail_url($commu_id, 'large');
$id_membre    = get_field('selection_du_streamer_commu', $commu_id);
?>
<div class="post-frame">
  <div class="minipost">
    <div class="lauch_embed" data-bs-toggle="modal" data-bs-target="#vedette-<?php echo $commu_id; ?>">
      <img src="<?php echo $cover_commu; ?>" alt="" class="img-fluid rounded">
      <div class="play">
        <img src="<?php bloginfo('template_directory'); ?>/assets/images/emojis/play.png">
      </div>
    </div>
    <div class="caption-frame">
      <h4>
        <?php
        if ($id_membre) {
          echo get_userdata($id_membre)->display_name;
        } else {
          echo get_the_title($commu_id);
        }
        ?>
      </h4>
      <div class="rezo">
        <?php if ($id_membre) : ?>
          <a href="<?php echo get_author_posts_url($id_membre); ?>" target="_blank" class="btn btn-icon btn-label-primary waves-effect">
            <i class="va va-md va-vkrzteam"></i>
          </a>
          <?php if (get_userdata($id_membre)->twitch_user) : ?>
            <a href="https://www.twitch.tv/<?php echo get_userdata($id_membre)->twitch_user; ?>" target="_blank" class="btn btn-icon btn-label-primary waves-effect">
              <i class="fab fa-twitch"></i>
            </a>
          <?php endif; ?>
          <?php if (get_userdata($id_membre)->youtube_user) : ?>
            <a href="https://www.youtube.com/user/<?php echo get_userdata($id_membre)->youtube_user; ?>" target="_blank" class="btn btn-icon btn-label-primary waves-effect">
              <i class="fab fa-youtube"></i>
            </a>
          <?php endif; ?>
          <?php if (get_userdata($id_membre)->Instagram_user) : ?>
            <a href="https://www.instagram.com/<?php echo get_userdata($id_membre)->Instagram_user; ?>" target="_blank" class="btn btn-icon btn-label-primary waves-effect">
              <i class="fab fa-instagram"></i>
            </a>
          <?php endif; ?>
          <?php if (get_userdata($id_membre)->twitter_user) : ?>
            <a href="https://www.twitter.com/<?php echo get_userdata($id_membre)->twitter_user; ?>" target="_blank" class="btn btn-icon btn-label-primary waves-effect">
              <i class="fab fa-twitter"></i>
            </a>
          <?php endif; ?>
          <?php if (get_userdata($id_membre)->snapchat_user) : ?>
            <a href="https://www.snapchat.com/add/<?php echo get_userdata($id_membre)->snapchat_user; ?>" target="_blank" class="btn btn-icon btn-label-primary waves-effect">
              <i class="fab fa-snapchat"></i>
            </a>
          <?php endif; ?>
          <?php if (get_userdata($id_membre)->tiktok_user) : ?>
            <a href="https://www.tiktok.com/&<?php echo get_userdata($id_membre)->tiktok_user; ?>" target="_blank" class="btn btn-icon btn-label-primary waves-effect">
              <i class="fab fa-tiktok"></i>
            </a>
          <?php endif; ?>
        <?php else : ?>
          <?php if (get_field('twitch_commu_ano')) : ?>
            <a href="<?php the_field('twitch_commu_ano'); ?>" target="_blank" class="btn btn-icon btn-label-primary waves-effect">
              <i class="fab fa-twitch"></i>
            </a>
          <?php endif; ?>
          <?php if (get_field('youtube_commu_ano')) : ?>
            <a href="<?php the_field('youtube_commu_ano'); ?>" target="_blank" class="btn btn-icon btn-label-primary waves-effect">
              <i class="fab fa-youtube"></i>
            </a>
          <?php endif; ?>
          <?php if (get_field('instagram_commu_ano')) : ?>
            <a href="<?php the_field('instagram_commu_ano'); ?>" target="_blank" class="btn btn-icon btn-label-primary waves-effect">
              <i class="fab fa-instagram"></i>
            </a>
          <?php endif; ?>
          <?php if (get_field('tiktok_commu_ano')) : ?>
            <a href="<?php the_field('tiktok_commu_ano'); ?>" target="_blank" class="btn btn-icon btn-label-primary waves-effect">
              <i class="fab fa-tiktok"></i>
            </a>
          <?php endif; ?>
        <?php endif; ?>
      </div>
    </div>
  </div>
  <!-- Modal -->
  <div class="modal modal-transparent fade" id="vedette-<?php echo $live_vedette; ?>" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-body">
          <a href="javascript:void(0);" class="btn-close text-white" data-bs-dismiss="modal" aria-label="Close">
          </a>
          <div class="modal-iframe">
            <p class="text-white text-large fw-bold mb-3 text-center"><?= get_the_title($live_vedette); ?></p>
            <?php the_field('video_video_commu', $live_vedette); ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>