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
$creator_info     = get_userdata($creator_id);
$creator_pseudo   = $creator_info->nickname;
$creator_avatar   = get_avatar_url($creator_id, ['size' => '80', 'force_default' => false]);
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
if($list_user_tops){
  if (in_array($id_top, $list_user_tops)) {
    $state = "done";
  } elseif (in_array($id_top, $list_user_tops_begin)) {
    $state = "begin";
  } else {
    $state = "todo";
  }
}
?>
<div class="min-tournoi card scaler <?php echo $is_top_saved ? 'saved-top': ''?>">
  <div class="cov-illu cover" style="background: url(<?php echo $illu; ?>) center center no-repeat">
    <?php if ($type_top == "sponso") : ?>
      <span class="badge badge-light-rose ml-0">Top sponso</span>
    <?php endif; ?>
    <?php if ($state == "done") : ?>
      <div class="badge bg-success">Terminé</div>
    <?php elseif ($state == "begin") : ?>
      <div class="badge bg-warning">En cours</div>
    <?php else : ?>
      <div class="badge bg-primary">A faire</div>
    <?php endif; ?>
    <div class="voile">
      <?php if ($state == "done") : ?>
        <div class="spoun">
          <h5>Voir ma Toplist</h5>
        </div>
      <?php elseif ($state == "begin") : ?>
        <div class="spoun">
          <h5>Terminer</h5>
        </div>
      <?php else : ?>
        <?php if ($type_top == "sponso") : ?>
          <div class="spoun">
            <h5>Participer</h5>
          </div>
        <?php else : ?>
          <div class="spoun">
            <h5>Faire ma Toplist</h5>
          </div>
        <?php endif; ?>
      <?php endif; ?>
    </div>
    <div class="info-top">
      <div class="info-top-col">
        <span class="ico va-high-voltage va va-md"></span>
        <h5>
          <?php echo $top_datas['nb_votes']; ?>
        </h5>
      </div>
      <div class="info-top-col">
        <span class="ico va va-trophy va-md"></span>
        <h5>
          <?php echo $top_datas['nb_tops']; ?>
        </h5>
      </div>
      <?php if ($type_top != "sponso") : ?>
        <div class="info-top-col hide-xs">
          <div class="infos-card-t d-flex align-items-center infos-card-t-c">
            <div class="avatar-infomore">
              <a href="<?php the_permalink(218587); ?>?creator_id=<?php echo $creator_id; ?>" target="_blank">
                <div class="avatar me-2">
                  <img src="<?php echo $creator_avatar; ?>" alt="<?php echo $creator_pseudo; ?>" width="38" height="38">
                </div>
              </a>
            </div>
            <div class="content-body mt-01">
              <h5 class="mb-0 link-creator d-flex flex-column text-left">
                <span class="text-muted">Créé par</span>
                <a href="<?php the_permalink(218587); ?>?creator_id=<?php echo $creator_id; ?>" target="_blank" class="link-to-creator">
                  <?php echo $creator_pseudo; ?>
                </a>
              </h5>
            </div>
          </div>
        </div>
      <?php endif; ?>
    </div>

    <?php 
    if(is_user_logged_in() ) :
      $wording = "";
      if($is_top_saved) {
        $wording = "Unsave Top";
      } else {
        $wording = "Save Top";
      }
    ?>
      <a href="" class="save-top save-top-mobile" data-idtop="<?= $id_top; ?>" data-idvainkeur="<?= $id_vainkeur; ?>"><?= $wording; ?></a>
    <?php endif; ?>
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
  <a href="<?php echo $top_info['top_url']; ?>" class="stretched-link"></a>
</div>