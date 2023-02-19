<?php
global $user_tops;
global $list_user_tops;
global $list_user_tops_begin;
global $id_top;
global $id_vainkeur;
$class            = "";
$id_top           = get_the_ID();
$top_datas        = get_top_data($id_top);
$top_info         = get_top_infos($id_top);
$is_top_saved     = check_top_saved($id_top, $id_vainkeur);
$creator_id       = get_post_field('post_author', $id_top);
$creator_info     = get_user_infos(get_field('uuiduser_user', 'user_' . $creator_id));
$type_top         = "";
$state            = "";
$illu             = get_the_post_thumbnail_url($id_top, 'large');
$get_top_type     = get_the_terms($id_top, 'type');
if ($get_top_type) {
  foreach ($get_top_type as $type_top) {
    $type_top = $type_top->slug;
  }
}
if (is_single()) {
  $class        = "col-md-3";
} elseif (is_page(302768)) {
  $class        = "col-md-4";
}
if ($list_user_tops) {
  if (in_array($id_top, $list_user_tops)) {
    $state = "done";
  } elseif (in_array($id_top, $list_user_tops_begin)) {
    $state = "begin";
  } else {
    $state = "todo";
  }
}
$state_infos      = get_state($state, $type_top);
?>
<div class="min-tournoi card">
  <div class="min-tournoi-content">
    <div class="cov-illu cover" style="background: url(<?php echo $illu; ?>) center center no-repeat">
      <?php if ($type_top == "sponso") : ?>
        <span class="badge rounded-fill badge-light-rose">Top sponso</span>
      <?php endif; ?>
      <span class="badge rounded-fill <?php echo $state_infos['bg']; ?>"><?php echo $state_infos['label']; ?></span>
    </div>
    <div class="card-body eh mb-3-hover">
      <h4 class="card-text text-white">
        TOP <?php echo $top_info['top_number']; ?> <?php echo $top_info['top_cat_icon']; ?> <?php echo $top_info['top_title']; ?>
      </h4>
      <h3 class="card-title">
        <?php echo $top_info['top_question']; ?>
      </h3>
    </div>
    <?php if ($type_top == "sponso") : ?>
      <div class="agagner">
        <span class="titrewin">
          À gagner <span class="va va-backhand-index-pointing-down va-lg"></span>
        </span>
        <div class="imgcado" style="background-image: url(<?= wp_get_attachment_image_url(get_field('cadeau_t_sponso', $id_top), 'large', false); ?>)"></div>
        <h5>
          <?= the_field('titre_de_la_sponso_t_sponso', $id_top); ?>
        </h5>
        <small class="datefinsponso">
          <?= the_field('fin_de_la_sponso_t_sponso', $id_top); ?>
        </small>
      </div>
    <?php endif; ?>
    <div class="voile">
      <div class="spoun">
        <a href="<?php echo $top_info['top_url']; ?>" class="w-100 animate__jello animate__animated animate__delay-1s btn btn-max btn-rose waves-effect waves-float waves-light">
          <?php echo $state_infos['wording']; ?>
        </a>
      </div>
    </div>
    <?php if (is_user_logged_in()) : ?>
      <?php
      if (!$is_top_saved) {
        $wordingfav = "Ajouter aux favoris";
        $statutfav  = "notsaved";
        $iconfav    = "star";
      } else {
        $wordingfav = "Retirer des favoris";
        $statutfav  = "saved";
        $iconfav    = "avis";
      }
      ?>
      <div class="badge save-top <?php echo $statutfav; ?>" data-idtop="<?= $id_top; ?>" data-idvainkeur="<?= $id_vainkeur; ?>">
        <i class="va va-md va-star"></i>
        <i class="va va-md va-avis"></i>
        <span>
          <?php echo $wordingfav; ?>
        </span>
      </div>
    <?php endif; ?>
    <div class="infohide">
      <div class="stats-top">
        <div class="data-top">
          <h5>
            <?php echo $top_datas['nb_votes']; ?>
          </h5>
          <i class="va-high-voltage va va-md"></i>
        </div>
        <div class="data-top">
          <h5>
            <?php echo $top_datas['nb_tops']; ?>
          </h5>
          <i class="va va-trophy va-md"></i>
        </div>
        <div class="data-top">
          <h5>
            <?php echo $top_datas['nb_comments']; ?>
          </h5>
          <i class="va va-comment va-md"></i>
        </div>
      </div>
      <div class="info-creator text-center">
        <?php if ($type_top != "sponso") : ?>
          <div class="vainkeur-card">
            <a href="<?php the_permalink(218587); ?>?creator_id=<?php echo $creator_id; ?>" class="btn btn-flat-primary waves-effect">
              <span class="avatar">
                <span class="avatar-picture" style="background-image: url(<?php echo $creator_info['avatar']; ?>);"></span>
              </span>
              <span class="championname scale08">
                <small class="text-muted">
                  Créé par
                </small>
                <div class="creatornametopmin">
                  <h4><?php echo $creator_info['pseudo']; ?></h4>
                  <span class="medailles">
                    <?php echo $creator_info['level']; ?>
                    <?php if ($creator_info['user_role'] == "administrator") : ?>
                      <span class="va va-vkrzteam va-z-15" data-toggle="tooltip" data-placement="top" title="" data-original-title="TeamVKRZ"></span>
                    <?php endif; ?>
                    <?php if ($creator_info['user_role'] == "administrator" || $creator_info['user_role'] == "author") : ?>
                      <span class="va va-man-singer va-z-15" data-toggle="tooltip" data-placement="top" title="" data-original-title="Créateur de Tops"></span>
                    <?php endif; ?>
                  </span>
                </div>
              </span>
            </a>
          </div>
        <?php endif; ?>
      </div>
    </div>
  </div>
</div>