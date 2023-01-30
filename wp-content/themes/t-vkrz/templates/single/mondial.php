<?php
global $uuid_vainkeur;
global $id_vainkeur;
global $top_infos;
global $id_top_global;
global $id_top;
global $creator_id;
global $creator_data;
get_header();
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
$id_top               = get_field('id_du_top_tm');
$top_infos            = get_top_infos($id_top);
$top_datas            = get_top_data($id_top);
$contenders_ranking   = get_contenders_ranking($id_top);
$id_top_global        = $id_top;
$id_resume            = get_resume_id($id_top);
$list_toplist         = json_decode(get_field('all_toplist_resume', $id_resume));
$list_toplist         = array_reverse($list_toplist);
$count_toplist        = count($list_toplist);
?>

<div class="col-12 m-0 ba-cover-r pe-0 py-5" style="background: url(<?php echo $top_infos['top_cover']; ?>) center center no-repeat">
  <div class="container-xxl m-auto">
    <div class="row zindex-2 position-relative">
      <div class="col-md-8 offset-md-2">
        <div class="infotoplistmondiale tournament-heading">
          <h1 class="t-titre-tournoi">
            <div class="text-muted">
              TopList Mondiale <?php echo $top_infos['top_cat_icon']; ?> <?php echo $top_infos['top_title']; ?>
            </div>
            <?php echo $top_infos['top_question']; ?>
          </h1>
          <div class="separate"></div>
          <h2>
            Cette TopList a été générée via l'algo ELO à partir des <span class="t-violet"><?php echo $top_datas['nb_votes']; ?></span> votes <span class="va va-high-voltage va-md"></span>
          </h2>

          <?php if (get_top_done_by_current_vainkeur($id_top, $id_vainkeur, $list_user_tops)) : ?>
            <h3>
              Ta <a href="<?= get_permalink($id_top); ?>" class="t-violet">TopList</a> y ressemble à <div id="ressemblance-ma-toplist-mondiale" class="d-inline t-violet">
                <span>
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
              </div>
            </h3>
          <?php endif; ?>

        </div>
      </div>
    </div>
    <div class="row zindex-2 position-relative">
      <div class="col-md-8 offset-md-2">

        <!-- TopList -->
        <div class="list-classement">
          <div class="row align-items-end justify-content-center">
            <?php
            $i = 1;
            foreach ($contenders_ranking as $c) :
              if ($i == 1) {
                $classcontender = "col-12 col-md-5";
              } elseif ($i == 2) {
                $classcontender = "col-7 col-md-4";
              } elseif ($i == 3) {
                $classcontender = "col-5 col-md-3";
              } else {
                $classcontender = "col-md-2 col-4";
              }
              if ($i >= 4) {
                $d = 3;
              } else {
                $d = $i - 1;
              }
            ?>
              <div class="<?php echo $classcontender; ?>">
                <div class="animate__jackInTheBox animate__animated animate__delay-<?php echo $d; ?>s contenders_min <?php echo ($top_infos['top_d_rounded']) ? 'rounded' : ''; ?> mb-3">
                  <div class="illu">
                    <?php if ($top_infos['top_d_cover']) : ?>
                      <?php $illu = get_the_post_thumbnail_url($c["id"], 'large'); ?>
                      <div class="cov-illu" style="background: url(<?php echo $illu; ?>) center center no-repeat"></div>
                    <?php else : ?>
                      <?php if (get_field('visuel_instagram_contender', $c["id"])) : ?>
                        <img src="<?php the_field('visuel_instagram_contender', $c["id"]); ?>" alt="" class="img-fluid">
                      <?php else : ?>
                        <?php echo get_the_post_thumbnail($c["id"], 'large', array('class' => 'img-fluid')); ?>
                      <?php endif; ?>
                    <?php endif; ?>
                  </div>
                  <div class="name eh2">
                    <h3 class="mt-1">
                      <?php if ($i == 1) : ?>
                        <span class="ico">🥇</span>
                      <?php elseif ($i == 2) : ?>
                        <span class="ico">🥈</span>
                      <?php elseif ($i == 3) : ?>
                        <span class="ico">🥉</span>
                      <?php else : ?>
                        <span><?php echo $i; ?><br></span>
                      <?php endif; ?>
                      <?php if (!$top_infos['top_d_titre']) : ?>
                        <?php echo get_the_title($c["id"]); ?>
                      <?php endif; ?>
                    </h3>
                    <div class="pointselo" data-points="<?php echo $c["points"]; ?>">
                      <?php echo $c["points"]; ?> pts
                    </div>
                  </div>
                </div>
              </div>
            <?php $i++;
            endforeach; ?>
          </div>
        </div>
        <!-- TopList -->

      </div>
    </div>
  </div>
</div>

<!-- Liste des TopList -->
<div class="col-12" id="toplist">
  <div class="container-xxl">
    <div class="row">
      <div class="col-md-8 offset-md-2 col-10">
        <div class="users-ranks">
          <div class="card text-center calc-resemblance card-voile m-0" data-idtop="<?php echo $id_top; ?>" data-topurl="<?php echo get_permalink($id_top) ?>">
            <div class="voile-gif" style="background-image: url(<?php bloginfo('template_directory'); ?>/assets/images/gif/wait-<?php echo rand(1, 7); ?>.gif)"></div>
            <div class="card-body">
              <div class="content-card">
                <div class="loader-block">
                  <div class="loader loader--style1 w-100 mx-auto text-center" title="0">
                    <svg version="1.1" id="loader-1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="40px" height="40px" viewBox="0 0 40 40" enable-background="new 0 0 40 40" xml:space="preserve">
                      <path opacity="0.2" fill="#000" d="M20.201,5.169c-8.254,0-14.946,6.692-14.946,14.946c0,8.255,6.692,14.946,14.946,14.946s14.946-6.691,14.946-14.946C35.146,11.861,28.455,5.169,20.201,5.169z M20.201,31.749c-6.425,0-11.634-5.208-11.634-11.634c0-6.425,5.209-11.634,11.634-11.634c6.425,0,11.633,5.209,11.633,11.634C31.834,26.541,26.626,31.749,20.201,31.749z" />
                      <path fill="#000" d="M26.013,10.047l1.654-2.866c-2.198-1.272-4.743-2.012-7.466-2.012h0v3.312h0C22.32,8.481,24.301,9.057,26.013,10.047z">
                        <animateTransform attributeType="xml" attributeName="transform" type="rotate" from="0 20 20" to="360 20 20" dur="0.5s" repeatCount="indefinite" />
                      </path>
                    </svg>
                  </div>
                </div>
                <h2 class="font-weight-bolder mb-1 mt-1">
                  <small>Récupération des </small> <br>
                  <span class="t-violet"><?php echo $count_toplist; ?></span> TopList
                </h2>
                <?php if (get_top_done_by_current_vainkeur($id_top, $id_vainkeur, $list_user_tops)) : ?>
                  <h6 class="card-subtitle text-muted">
                    Notre algo maison va comparer toutes les TopList pour afficher le % de ressemblance avec la tienne.
                  </h6>
                <?php endif; ?>
              </div>
            </div>
            <div class="bar-container">
              <div class="bar"></div>
              <span class="bar-percent">0 %</span>
            </div>
          </div>
          <div class="card invoice-list-wrapper table-card-container d-none">
            <div class="table-responsive">
              <table class="invoice-list-table table table-listuserranks">
                <thead>
                  <tr>
                    <th>
                      <span class="text-muted">
                        Vainkeur
                      </span>
                    </th>
                    <th>
                      <span class="text-muted">
                        Podium
                      </span>
                    </th>
                    <th class="text-center shorted">
                      <span class="text-muted">Ressemblance</span>
                    </th>
                    <th class="text-center">
                      <span class="text-muted">
                        Action
                      </span>
                    </th>
                    <th class="text-right">
                      <span class="text-muted">
                        Guetter
                      </span>
                    </th>
                  </tr>
                </thead>
                <tbody>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- /Liste des TopList -->

<!-- Commentaires -->
<div class="col-12 mt-5" id="commentaires">
  <div class="container-xxl">
    <div class="row">
      <div class="col-md-8 offset-md-2 col-10">
        <?php echo get_template_part('comments'); ?>
      </div>
    </div>
  </div>
</div>
<!-- /Commentaires -->

<!-- Right Nav -->
<div class="infos-toplist">
  <a href="#toplist" class="btn-emoji btn-emoji-wording" data-bs-toggle="tooltip" data-bs-placement="left" data-bs-original-title="Voir toutes les TopList">
    <span class="va va-trophy va-lg"></span>
    <div class="value">
      <?php echo $top_datas['nb_tops']; ?>
    </div>
  </a>
  <a href="#commentaires" class="btn-emoji btn-emoji-wording" data-bs-toggle="tooltip" data-bs-placement="left" data-bs-original-title="Commente le Top">
    <span class="va va-writing-hand va-lg"></span>
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

<!-- Bottom Nav -->
<div class="share-toplist">
  <?php if (!get_top_done_by_current_vainkeur($id_top, $id_vainkeur, $list_user_tops)) : ?>
    <a href="<?php the_permalink($id_top); ?>" class="btn-wording-rose btn-wording bubbly-button">
      Fais ta TopList pour participer
    </a>
  <?php endif; ?>
  <a href="#commentaires" class="btn-wording" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="Matte les commentaires et laisse le tiens">
    Laisse ton meilleur commentaire
  </a>
</div>
<!-- /Bottom Nav -->

<!-- Offcanvas -->
<?php get_template_part('widgets/top-info'); ?>
<!-- /Offcanvas -->

<script>
  const topId = "<?php echo $id_top; ?>";
</script>
<?php get_footer(); ?>