<?php
get_header();
global $uuid_vainkeur;
global $user_id;
global $id_top;
global $id_ranking;
global $top_infos;
global $utm;
global $infos_vainkeur;
global $id_vainkeur;
global $banner;
global $user_tops;
global $list_user_tops;
global $list_user_tops_begin;
global $vainkeur_data_selected;
global $top_datas;
global $id_top_global;
global $top_cat_id;
global $creator_data;
global $url_ranking;
$id_top_global = $id_top;
if ($id_vainkeur) {
  if (is_user_logged_in() && env() != "local") {
    if (false === ($user_tops = get_transient('user_' . $user_id . '_get_user_tops'))) {
      $user_tops = get_user_tops($id_vainkeur);
      set_transient('user_' . $user_id . '_get_user_tops', $user_tops, DAY_IN_SECONDS);
    } else {
      $user_tops = get_transient('user_' . $user_id . '_get_user_tops');
    }
  } else {
    $user_tops  = get_user_tops($id_vainkeur);
  }
  $list_user_tops         = $user_tops['list_user_tops_done_ids'];
  $list_user_tops_begin   = $user_tops['list_user_tops_begin_ids'];
} else {
  $user_tops            = array();
  $list_user_tops       = array();
  $list_user_tops_begin = array();
}
$user_ranking           = get_user_ranking($id_ranking);
$uuid_who_did_toplist   = get_field('uuid_user_r', $id_ranking);
$url_ranking            = get_the_permalink($id_ranking);
$top_datas              = get_top_data($id_top_global);
$get_top_type           = get_the_terms($id_top_global, 'type');
$types_top              = array();
if ($get_top_type) {
  foreach ($get_top_type as $type_top) {
    array_push($types_top, $type_top->slug);
  }
}
$already_done           = get_top_done_by_current_vainkeur($id_top, $id_vainkeur, $list_user_tops);
$j = 1;
foreach ($user_ranking as $c) :
  if ($j == 1) :
    $first_id_contender = $c;
  elseif ($j == 2) :
    $second_id_contender = $c;
  elseif ($j == 3) :
    $third_id_contender = $c;
  endif;
  $j++;
endforeach;
// Info VAINKEURZ
$vainkeur_data_selected = get_user_infos($uuid_who_did_toplist);
if (!is_user_logged_in() && !in_array("sponso", $types_top) && get_field('uuid_user_r', $id_ranking) == $uuid_vainkeur) :
  get_template_part('partials/devenir-vainkeur');
endif;
?>

<!-- TopList -->
<div class="col-12 m-0 ba-cover-r pe-0 py-5" style="background: url(<?php echo $top_infos['top_cover']; ?>) center center no-repeat">
  <div class="container-xxl m-auto">
    <div class="classement" data-idranking="<?= $id_ranking ?>">
      <div class="row">
        <div class="col-12">
          <div class="tournament-heading">
            <h1 class="t-titre-tournoi">
              <div class="text-muted">
                <?php if (get_field('uuid_user_r', $id_ranking) == $uuid_vainkeur) : ?>
                  Voici ta <span class="t-rose">TopList</span> - <?php echo $top_infos['top_title']; ?> : <?php echo $top_infos['top_question']; ?>
                <?php else : ?>
                  Voici la <span class="t-rose">TopList</span> de <?php echo $vainkeur_data_selected['pseudo']; ?> - <?php echo $top_infos['top_title']; ?> : <?php echo $top_infos['top_question']; ?>
                <?php endif; ?>
              </div>
            </h1>
          </div>
        </div>
        <div class="col-md-8 offset-md-2 col-10">
          <!-- TopList -->
          <div class="list-classement">
            <div class="row align-items-end justify-content-center">
              <div class="row align-items-end justify-content-center">
                <?php
                $i = 1;
                foreach ($user_ranking as $c) :
                  if ($i == 1) {
                    $classcontender = "col-8 col-offset-2 col-md-5";
                  } elseif ($i == 2) {
                    $classcontender = "col-6 col-md-4";
                  } elseif ($i == 3) {
                    $classcontender = "col-6 col-md-3";
                  } else {
                    $classcontender = "col-5 col-offset-1 col-sm-4 col-sm-offset-0 col-md-3";
                  }
                  if ($i >= 4) {
                    $d = 0;
                  } else {
                    $d = 4 - $i;
                  }
                ?>
                  <div class="<?php echo $classcontender; ?>">
                    <div class="animate__jackInTheBox animate__animated animate__delay-<?php echo $d; ?>s contenders_min <?php echo ($top_infos['top_d_rounded']) ? 'rounded' : ''; ?> mb-3">
                      <div class="illu">
                        <?php if ($top_infos['top_d_cover']) : ?>
                          <?php $illu = get_the_post_thumbnail_url($c, 'large'); ?>
                          <div class="cov-illu" style="background: url(<?php echo $illu; ?>) center center no-repeat"></div>
                        <?php else : ?>
                          <?php if (get_field('visuel_instagram_contender', $c)) : ?>
                            <img src="<?php the_field('visuel_instagram_contender', $c); ?>" alt="" class="img-fluid">
                          <?php elseif (get_field('visuel_firebase_contender', $c)) : ?>
                            <img src="<?php the_field('visuel_firebase_contender', $c); ?>" alt="" class="img-fluid">
                          <?php else : ?>
                            <?php echo get_the_post_thumbnail($c, 'large', array('class' => 'img-fluid')); ?>
                          <?php endif; ?>
                        <?php endif; ?>
                      </div>
                      <div class="name eh2">
                        <h3 class="mt-2 eh3">
                          <?php if ($i == 1) : ?>
                            <span class="ico">🥇</span><br>
                          <?php elseif ($i == 2) : ?>
                            <span class="ico">🥈</span><br>
                          <?php elseif ($i == 3) : ?>
                            <span class="ico">🥉</span><br>
                          <?php else : ?>
                            <span><?php echo $i; ?><br></span>
                          <?php endif; ?>
                          <?php if (!$top_infos['top_d_titre']) : ?>
                            <?php echo get_the_title($c); ?>
                          <?php endif; ?>
                        </h3>
                        <?php if (get_field('lien_vers_contender', $c)) : ?>
                          <div class="next-bloc">
                            <a href="<?php the_field('lien_vers_contender', $c); ?>" class="seemore" target="_blank">
                              <?php if (get_field('choix_de_licone_contender', $c) == "shop") : ?>
                                Acheter
                              <?php elseif (get_field('choix_de_licone_contender', $c) == "info") : ?>
                                Découvrir
                              <?php endif; ?>
                            </a>
                          </div>
                        <?php endif; ?>
                      </div>
                    </div>
                  </div>
                <?php $i++;
                endforeach; ?>
              </div>

              <!-- Twitch Game Ranking -->
              <?php if (!isMobile() && is_user_logged_in() && get_userdata($user_id)->twitch_user) : ?>
                <div class="popup-overlay d-none" id="twitch-games-ranking" data-idRanking="<?= $id_ranking; ?>"></div>
              <?php endif; ?>
              <!-- /Twitch Game Ranking -->
            </div>
          </div>
          <!-- /TopList -->
        </div>
      </div>
    </div>
  </div>
</div>
<!-- /TopList -->

<!-- Similar -->
<div class="col-12">
  <div class="container-xxl">
    <div class="row">
      <div class="col-md-8 offset-md-2 col-10">
        <?php get_template_part('widgets/top-similar'); ?>
      </div>
    </div>
  </div>
</div>
<!-- /Similar -->

<!-- Bottom Nav -->
<div class="share-toplist">
  <?php $id_toplistmondiale = get_toplist_mondiale($id_top_global); ?>
  <?php if (!in_array('private', $types_top)) : ?>
    <?php if ($already_done) : ?>
      <?php if (get_field('uuid_user_r', $id_ranking) != $uuid_vainkeur) :  ?>
        <a href="<?php echo $top_infos['top_url']; ?>" class="btn-wording-rose btn-wording bubbly-button">
          Voir ma TopList
        </a>
      <?php else : ?>
        <button class="btn-wording-rose btn-wording bubbly-button" data-bs-toggle="offcanvas" data-bs-target="#sharetoplist">
          Partage ta TopList
        </button>
      <?php endif; ?>
    <?php else : ?>
      <a href="<?php echo $top_infos['top_url']; ?>" class="btn-wording-rose btn-wording bubbly-button">
        Faire ma TopList
      </a>
    <?php endif; ?>
  <?php endif; ?>
  <a href="<?php the_permalink($id_toplistmondiale); ?>#toplist" class="btn-wording" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="Voir les <?php echo $top_datas['nb_tops']; ?> TopList">
    <span class="va va-trophy va-lg"></span> <?php echo $top_datas['nb_tops']; ?>
  </a>
  <a href="<?php the_permalink($id_toplistmondiale); ?>" class="btn-wording mt-2 mb-1 mt-sm-0 mb-sm-0" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="Générée à partir des <?php echo $top_datas['nb_votes']; ?> votes">
    Découvre la TopList mondiale <span class="va va-globe va-lg"></span>
    <?php if ($already_done) : ?>
      <span id="ressemblance-mondiale">
        <div class="loader loader--style1" title="0">
          <svg version="1.1" id="loader-1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="20px" height="20px" viewBox="0 0 40 40" enable-background="new 0 0 40 40" xml:space="preserve">
            <path opacity="0.2" fill="#000" d="M20.201,5.169c-8.254,0-14.946,6.692-14.946,14.946c0,8.255,6.692,14.946,14.946,14.946
                  s14.946-6.691,14.946-14.946C35.146,11.861,28.455,5.169,20.201,5.169z M20.201,31.749c-6.425,0-11.634-5.208-11.634-11.634
                  c0-6.425,5.209-11.634,11.634-11.634c6.425,0,11.633,5.209,11.633,11.634C31.834,26.541,26.626,31.749,20.201,31.749z" />
            <path fill="#000" d="M26.013,10.047l1.654-2.866c-2.198-1.272-4.743-2.012-7.466-2.012h0v3.312h0
                  C22.32,8.481,24.301,9.057,26.013,10.047z">
              <animateTransform attributeType="xml" attributeName="transform" type="rotate" from="0 20 20" to="360 20 20" dur="0.5s" repeatCount="indefinite" />
            </path>
          </svg>
        </div>
      </span>
    <?php endif; ?>
  </a>
</div>
<!-- /Bottom Nav -->

<!-- Right Nav -->
<div class="infos-toplist">
  <?php if (get_field('uuid_user_r', $id_ranking) != $uuid_vainkeur) : ?>
    <button class="btn-emoji btn-emoji" data-bs-toggle="tooltip" data-bs-placement="left" data-bs-original-title="Découvre qui a fait cette TopList">
      <div data-bs-toggle="offcanvas" data-bs-target="#topeur" aria-controls="offcanvasScroll" class="divfill">
        <span class="va va-monocle va-lg"></span>
      </div>
    </button>
  <?php endif; ?>
  <?php if ($already_done && get_field('uuid_user_r', $id_ranking) == $uuid_vainkeur) : ?>
    <a href="#" class="btn-emoji btn-emoji-recommencer confirm_delete" data-bs-toggle="tooltip" data-bs-placement="left" data-bs-original-title="Recommencer" data-phrase1="Es-tu sûr de vouloir recommencer ?" data-phrase2="Tous les votes de ce Top seront remis à 0" data-id_ranking="<?php echo $id_ranking; ?>" data-id_vainkeur="<?php echo $id_vainkeur; ?>">
      <span class="va va-recommencer va-lg"></span>
    </a>
  <?php endif; ?>
  <button class="btn-emoji btn-emoji-wording" data-bs-toggle="tooltip" data-bs-placement="left" data-bs-original-title="Juge cette TopList">
    <div data-bs-toggle="offcanvas" data-bs-target="#jugement" aria-controls="offcanvasScroll" class="divfill">
      <span class="va va-hache va-lg"></span>
      <div class="value jugements-nbr">
        <div class="loader loader--style1" title="0">
          <svg version="1.1" id="loader-1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="20px" height="20px" viewBox="0 0 40 40" enable-background="new 0 0 40 40" xml:space="preserve">
            <path opacity="0.2" fill="#000" d="M20.201,5.169c-8.254,0-14.946,6.692-14.946,14.946c0,8.255,6.692,14.946,14.946,14.946
                s14.946-6.691,14.946-14.946C35.146,11.861,28.455,5.169,20.201,5.169z M20.201,31.749c-6.425,0-11.634-5.208-11.634-11.634
                c0-6.425,5.209-11.634,11.634-11.634c6.425,0,11.633,5.209,11.633,11.634C31.834,26.541,26.626,31.749,20.201,31.749z" />
            <path fill="#000" d="M26.013,10.047l1.654-2.866c-2.198-1.272-4.743-2.012-7.466-2.012h0v3.312h0
                C22.32,8.481,24.301,9.057,26.013,10.047z">
              <animateTransform attributeType="xml" attributeName="transform" type="rotate" from="0 20 20" to="360 20 20" dur="0.5s" repeatCount="indefinite" />
            </path>
          </svg>
        </div>
      </div>
    </div>
  </button>
  <a href="<?php the_permalink($id_toplistmondiale); ?>#commentaires" class="btn-emoji btn-emoji-wording" data-bs-toggle="tooltip" data-bs-placement="left" data-bs-original-title="Commente le Top">
    <span class="va va-comment va-lg"></span>
    <div class="value">
      <?php echo $top_datas['nb_comments']; ?>
    </div>
  </a>
  <?php
  $creator_id = get_post_field('post_author', $id_top_global);
  $creator_uuiduser = get_field('uuiduser_user', 'user_' . $creator_id);
  $creator_data = get_user_infos($creator_uuiduser);
  ?>
  <button class="btn-emoji btn-avatar" data-bs-toggle="tooltip" data-bs-placement="left" data-bs-original-title="Top créé par <?php echo $creator_data['pseudo']; ?>" style="background-image: url(<?php echo $creator_data['avatar']; ?>);">
    <div data-bs-toggle="offcanvas" data-bs-target="#infostop" aria-controls="offcanvasScroll" class="divfill">
    </div>
  </button>
</div>
<!-- /Right Nav -->

<!-- Offcanvas -->
<?php get_template_part('widgets/jugement'); ?>
<?php get_template_part('widgets/toplist-share'); ?>
<?php get_template_part('widgets/top-info'); ?>
<?php get_template_part('widgets/topeur'); ?>
<!-- /Offcanvas -->

<!-- Overlay -->
<?php get_template_part('partials/recommencer'); ?>
<!-- /Overlay -->

<?php if (get_field('uuid_user_r', $id_ranking) == $uuid_vainkeur && in_array("sponso", $types_top)) : ?>
  <?php get_template_part('partials/participer'); ?>
<?php endif; ?>

<?php get_footer(); ?>