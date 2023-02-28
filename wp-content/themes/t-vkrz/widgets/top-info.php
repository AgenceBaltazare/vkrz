<?php
global $top_infos;
global $id_top_global;
global $creator_id;
global $creator_data;
?>
<div class="offcanvas offcanvas-end bg-deg" id="infostop">
  <div class="offcanvas-header">
    <h5 id="offcanvasScrollLabel" class="offcanvas-title">
      <span class="va va-monocle va-lg"></span> Tous les infos du Top
    </h5>
    <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
  </div>
  <div class="offcanvas-body my-auto mx-0 flex-grow-0">
    <div class="presentationtop">
      <div class="meetup-header d-flex align-items-center justify-content-center">
        <div class="my-auto">
          <h4 class="card-title mb-25">
            TOP <?php echo $top_infos['top_number']; ?> <?php echo $top_infos['top_cat_icon']; ?> <?php echo $top_infos['top_title']; ?>
          </h4>
          <p class="card-text mb-0 t-rose animate__animated animate__flash">
            <?php echo $top_infos['top_question']; ?>
          </p>
        </div>
      </div>
      <?php if (get_field('precision_t', $id_top_global)) : ?>
        <div class="card-precision text-center text-muted">
          <?php the_field('precision_t', $id_top_global); ?>
        </div>
      <?php endif; ?>
    </div>
    <div class="separate"></div>
    <div class="top-resume-tool mt-4">
      <h4 class="card-title">
        <?php
        date_default_timezone_set('Europe/Paris');
        $date_wp    = get_the_date('Y-m-d', $id_top_global);
        $date_clean = get_the_date('d/m/Y', $id_top_global);
        $origin     = new DateTime($date_wp);
        $target     = new DateTime(date('Y-m-d'));
        $interval   = $origin->diff($target);
        if ($interval->days == 0) {
          $info_date = "aujourd'hui";
        } elseif ($interval->days == 1) {
          $info_date = "hier";
        } elseif ($interval->days > 10) {
          $info_date = "le " . $date_clean;
        } else {
          $info_date = "depuis " . $interval->days . " jours";
        }
        ?>
        <span class="va va-birthday-cake va-md"></span> Créé <span class="t-violet"><?php echo $info_date; ?></span> par :
      </h4>
      <div class="vainkeur-card">
        <a href="<?php echo esc_url(get_author_posts_url($creator_data['id_user'])); ?>" class="btn btn-flat-primary waves-effect">
          <span class="avatar">
            <span class="avatar-picture" style="background-image: url(<?php echo $creator_data['avatar']; ?>);"></span>
          </span>
          <span class="championname">
            <h4><?php echo $creator_data['pseudo']; ?></h4>
            <span class="medailles">
              <?php echo $creator_data['level']; ?>
              <?php if ($creator_data['user_role'] == "administrator") : ?>
                <span class="va va-vkrzteam va-z-15" data-toggle="tooltip" data-placement="top" title="" data-original-title="TeamVKRZ"></span>
              <?php endif; ?>
              <?php if ($creator_data['user_role'] == "administrator" || $creator_data['user_role'] == "author") : ?>
                <span class="va va-man-singer va-z-15" data-toggle="tooltip" data-placement="top" title="" data-original-title="Créateur de Tops"></span>
              <?php endif; ?>
            </span>
          </span>
        </a>
      </div>
    </div>
    <div class="separate"></div>
    <div class="partagetop">
      <ul>
        <li>
          <a href="#" class="sharelinkbtn2" data-toggle="tooltip" data-placement="top" title="" data-original-title="Copier le lien de ton Top">
            <input type="text" value="<?php echo $top_infos['top_url']; ?>" class="input_to_share2">
            Copier le lien du Top
          </a>
        </li>
        <li>
          <a href="https://twitter.com/intent/tweet?text=Go faire le TOP <?php echo $top_infos['top_number']; ?> <?php echo $top_infos['top_title']; ?>&via=vainkeurz&hashtags=VKRZ&url=<?php echo $top_infos['top_url']; ?>" target="_blank" title="Tweet">
            Dans un Tweet
          </a>
        </li>
        <li>
          <a href="whatsapp://send?text=<?php echo $top_infos['top_url']; ?>" data-action="share/whatsapp/share">
            Sur WhatsApp
          </a>
        </li>
        <li>
          <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo $top_infos['top_url']; ?>" title="Partager sur Facebook" target="_blank">
            Sur Facebook
          </a>
        </li>
      </ul>
    </div>
  </div>
</div>