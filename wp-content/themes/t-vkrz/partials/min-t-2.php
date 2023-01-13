<?php
global $user_tops;
global $list_user_tops;
global $list_user_tops_begin;
global $id_top;
$class            = "";
$id_top           = get_the_ID();
$top_datas        = get_top_data($id_top);
$creator_id       = get_post_field('post_author', $id_top);
$creator_info     = get_userdata($creator_id);
$creator_pseudo   = $creator_info->nickname;
$creator_avatar   = get_avatar_url($creator_id, ['size' => '80', 'force_default' => false]);
$type_top         = "";
$state            = "";
$illu             = get_the_post_thumbnail_url($id_top, 'large');
?>
<div class="min-tournoi card scaler min-t-2">
  <div class="content-card">
    <div class="voilecover" style="background: url(<?php echo $illu; ?>) center center no-repeat"></div>
    <div class="row">
      <div class="col-md-12">
        <div class="content-text">
          <h4 class="card-text text-white">
            <?php
            foreach (get_the_terms($id_top, 'categorie') as $cat) {
              $cat_id     = $cat->term_id;
              $cat_name   = $cat->name;
            }
            ?>
            TOP <?php echo get_field('count_contenders_t', $id_top); ?> <?php the_field('icone_cat', 'term_' . $cat_id); ?> <?php echo get_the_title($id_top); ?>
          </h4>
          <h3 class="card-title">
            <?php the_field('question_t', $id_top); ?>
          </h3>
        </div>
      </div>
    </div>
  </div>
  <a href="<?php the_permalink($id_top); ?>" class="stretched-link"></a>
</div>