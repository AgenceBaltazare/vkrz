<?php
global $uuid_vainkeur;
global $user_id;
global $user_tops;
global $infos_vainkeur;
global $id_vainkeur;
global $utm;
global $id_ranking;
global $id_top;
$user_id        = get_user_logged_id();
$vainkeur       = get_vainkeur();
$uuid_vainkeur  = $vainkeur['uuid_vainkeur'];
$id_vainkeur    = $vainkeur['id_vainkeur'];
if (is_user_logged_in()) {
  $infos_vainkeur = get_user_infos($uuid_vainkeur, "complete");
} else {
  $infos_vainkeur = get_fantom($id_vainkeur);
}
$id_top         = get_the_ID();
$id_ranking     = get_user_ranking_id($id_top, $uuid_vainkeur, $id_vainkeur);
if ($id_ranking) {
  extract(get_next_duel($id_ranking, $id_top, $id_vainkeur));
  if (!$is_next_duel) {
    wp_redirect(get_the_permalink($id_ranking));
  }
}
$url_top            = get_the_permalink($id_top);
$top_datas          = get_top_data($id_top);
$top_infos          = get_top_infos($id_top);
$creator_id         = get_post_field('post_author', $id_top);
$creator_uuiduser   = get_field('uuiduser_user', 'user_' . $creator_id);
$creator_data       = get_user_infos($creator_uuiduser);
get_header();
?>
<script>
  const link_to_ranking = "<?= get_the_permalink($id_ranking) ?>";
</script>
<div class="app-content content cover t-sponso-container" style="background: url(<?php echo $top_infos['top_cover']; ?>) center center no-repeat">
  <div class="content-overlay"></div>
  <div class="content-wrapper">
    <div class="content-body tournoi-content">

      <?php if (!$id_ranking) : ?>

        <div class="content-intro container intro-sponso">

          <div class="row match-height">
            <div class="col-md-8 start-top">
              <div class="card animate__animated animate__flipInX card-developer-meetup d-block d-sm-none">
                <div class="card-body rules-content p-0">
                  <div class="title-win">
                    <h4>
                      <?php the_field('titre_de_la_sponso_t_sponso', $id_top); ?>
                    </h4>
                  </div>
                </div>
              </div>
              <div class="intro">
                <div class="card animate__animated animate__flipInX card-developer-meetup">
                  <div class="meetup-img-wrapper rounded-top text-left" style="background-image: url(<?php echo $top_infos['top_img']; ?>);">
                    <span class="badge badge-light-primary d-none d-md-inline-block">Créé le <?php echo $top_infos['top_date']; ?></span>
                    <span class="badge badge-light-rose ml-0 d-none d-md-inline-block">Top sponsorisé</span>
                    <div class="voile_contenders"></div>
                    <?php if ($top_infos['top_number'] < 30) : ?>
                      <div class="avatar-group list-contenders">
                        <?php $contenders_t = new WP_Query(array(
                          'post_type' => 'contender', 'orderby' => 'date', 'posts_per_page' => '-1',
                          'meta_query'     => array(
                            array(
                              'key'     => 'id_tournoi_c',
                              'value'   => $id_top,
                              'compare' => '=',
                            )
                          )
                        ));
                        $userAgent = strtolower($_SERVER["HTTP_USER_AGENT"]);
                        $isMobile = is_numeric(strpos($userAgent, "mobile"));
                        $counter = $max = 0;
                        $isMobile ? $max = 20 : $max = 50;
                        ?>
                        <?php while ($contenders_t->have_posts() && ($counter <= $max)) : $contenders_t->the_post(); ?>
                          <div data-toggle="tooltip" data-popup="tooltip-custom" data-placement="top" data-original-title="<?php echo get_the_title(get_the_id()); ?>" class="avatar pull-up">
                            <?php if (get_field('visuel_instagram_contender', get_the_id())) : ?>
                              <img src="<?php the_field('visuel_instagram_contender', get_the_id()); ?>" alt="<?php echo get_the_title(get_the_id()); ?>" height="32" width="32">
                            <?php else : ?>
                              <?php $illu = get_the_post_thumbnail_url(get_the_id(), 'thumbnail'); ?>
                              <img src="<?php echo $illu; ?>" alt="<?php echo get_the_title(get_the_id()); ?>" height="32" width="32">
                            <?php endif; ?>
                          </div>
                        <?php $counter++;
                        endwhile; ?>
                      </div>
                    <?php endif; ?>
                  </div>
                  <div class="card-body">
                    <div class="meetup-header d-flex align-items-center justify-content-center">
                      <div class="my-auto">
                        <h4 class="card-title mb-25">
                          TOP <?php echo $top_infos['top_number']; ?> <?php echo $top_infos['top_cat_icon']; ?> <?php echo $top_infos['top_title']; ?>
                        </h4>
                        <p class="card-text mb-0 t-violet animate__animated animate__flash">
                          <?php echo $top_infos['top_question']; ?>
                        </p>
                      </div>
                    </div>
                    <?php if (get_field('precision_t', $id_top)) : ?>
                      <div class="card-precision">
                        <p class="card-text mb-1">
                          <?php the_field('precision_t', $id_top); ?>
                        </p>
                      </div>
                    <?php endif; ?>
                  </div>
                  <div class="card-cta">
                    <div class="choosecta">
                      <?php if ($top_infos['top_number'] > 15) : ?>
                        <div class="cta-begin cta-top3">
                          <a href="#" id="begin_top3" data-typetop="top3" data-id_vainkeur="<?php echo $id_vainkeur; ?>" data-top="<?php echo $id_top; ?>" data-uuiduser="<?php echo $uuid_vainkeur; ?>" class="w-100 animate__jello animate__animated animate__delay-1s btn btn-max btn-primary waves-effect waves-float waves-light laucher_t">
                            <i class="fab fa-twitch twitch-icon-tbegin d-none"></i>&nbsp;
                            Participer
                          </a>
                          <small class="text-muted">
                            <?php
                            $max = (floor($top_infos['top_number'] / 2)) + (3 * ((round($top_infos['top_number'] / 2)) - 1));
                            $min = (floor($top_infos['top_number'] / 2)) + ((round($top_infos['top_number'] / 2)) - 1) + 3;
                            $moy = ($max + $min) / 2;
                            ?>
                            Prévoir environ <?php echo round($moy); ?> votes pour faire ton <b>TOP 3</b>
                          </small>
                        </div>
                      <?php else : ?>
                        <div class="cta-begin cta-complet">
                          <a href="#" id="begin_t" data-typetop="complet" data-id_vainkeur="<?php echo $id_vainkeur; ?>" data-top="<?php echo $id_top; ?>" data-uuiduser="<?php echo $uuid_vainkeur; ?>" class="w-100 animate__jello animate__animated animate__delay-1s btn btn-max btn-primary waves-effect waves-float waves-light laucher_t">
                            <i class="fab fa-twitch twitch-icon-tbegin d-none"></i>&nbsp;
                            Participer
                          </a>
                          <small class="text-muted">
                            <?php
                            $min = ($top_infos['top_number'] - 5) * 2 + 6;
                            $max = $min * 2;
                            ?>
                            <?php if ($top_infos['top_number'] < 3) : ?>
                              Un seul vote suffira pour finir ce Top
                            <?php else : ?>
                              Prévoir entre <?php echo $min; ?> et <?php echo $max; ?> votes pour finir ton Top <b>complet</b>
                            <?php endif; ?>
                          </small>
                        </div>
                      <?php endif; ?>
                    </div>
                  </div>
                  <div class="card-footer">
                    <div class="row meetings align-items-center">
                      <div class="col">
                        <div class="infos-card-t info-card-t-v d-flex align-items-center">
                          <div class="mr-1">
                            <span class="ico va-high-voltage va va-2x"></span>
                          </div>
                          <div class="content-body text-left">
                            <h4 class="mb-0">
                              <?php echo $top_datas['nb_votes']; ?>
                            </h4>
                            <small class="text-muted">votes réalisés</small>
                          </div>
                        </div>
                      </div>
                      <div class="col">
                        <div class="infos-card-t d-flex align-items-center">
                          <div class="mr-1">
                            <span class="ico va va-trophy va-2x"></span>
                          </div>
                          <div class="content-body text-left">
                            <h4 class="mb-0">
                              <?php echo $top_datas['nb_tops']; ?>
                            </h4>
                            <small class="text-muted">Tops terminés</small>
                          </div>
                        </div>
                      </div>
                      <div class="col">
                        <div class="infos-card-t d-flex align-items-center">
                          <div class="mr-1">
                            <span class="ico va va-wrapped-gift va-2x"></span>
                          </div>
                          <div class="content-body text-left">
                            <h4 class="mb-0">
                              <?php the_field('gain_champs_1_t_sponso', $id_top); ?>
                            </h4>
                            <small class="text-muted"><?php the_field('gain_champs_2_t_sponso', $id_top); ?></small>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <div class="col-md-4 t-sponso-banner">
              <div class="card animate__animated animate__flipInX card-developer-meetup">
                <div class="card-body rules-content">                  
                  <div class="mb-1 d-none d-sm-block">
                    <div class="title-win">
                      <h4>
                        <?php the_field('titre_de_la_sponso_t_sponso', $id_top); ?>
                      </h4>
                    </div>
                  </div>
                  <div class="text-rules">
                    <?php the_field('description_t_sponso', $id_top); ?>
                  </div>
                </div>
                <div class="card-footer share-content-sponso">
                  <div class="text-left">
                    <p>
                      <?php the_field('top_propose_par_t_sponso', $id_top); ?>
                    </p>
                  </div>
                  <div class="d-flex align-items-center reseaux-sponso m-0">
                    <div class="logo-vkrz-sponso">
                      <?php
                      if (get_field('logo_de_la_sponso_t_sponso', $id_top)) : ?>
                        <a href="<?php the_field('lien_de_la_sponso_t_sponso', $id_top); ?>" target="_blank">
                          <?php echo wp_get_attachment_image(get_field('logo_de_la_sponso_t_sponso', $id_top), 'large', '', array('class' => 'img-fluid')); ?>
                        </a>
                      <?php endif; ?>
                    </div>
                    <div class="mt-2 social-media-sponso">
                      <div class="d-flex buttons-social-media">
                        <?php if (have_rows('liste_des_liens_t_sponso', $id_top)) : ?>
                          <?php while (have_rows('liste_des_liens_t_sponso', $id_top)) : the_row(); ?>
                            <a href="<?php the_sub_field('lien_vers_t_sponso'); ?>" class="w-100 animate__jello animate__animated animate__delay-1s btn btn-max btn-outline-primary waves-effect waves-float waves-light" target="_blank">
                              <?php the_sub_field('intitule_t_sponso'); ?>
                            </a>
                          <?php endwhile; ?>
                        <?php endif; ?>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="card-footer text-center p-20 m-0">
                  <span class="t-rose">
                    <?php the_field('fin_de_la_sponso_t_sponso', $id_top); ?>
                  </span>
                </div>
              </div>
            </div>

            <?php if (!isMobile() && is_user_logged_in() && get_userdata($user_id)->twitch_user) : ?>
              <div class="modes-jeu-twitch" style="background-image: url(<?php bloginfo('template_directory'); ?>/assets/images/events/twitch-games-banner.png);">
                <div class="modes-jeu-twitch__content">

                  <div class="modes-jeu-twitch__content-header">
                    <h4>
                      <i class="fab fa-2x fa-twitch mb-50"></i><br> Modes de jeu pour ton stream
                    </h4>

                    <h6>
                      Clik sur un mode pour permettre à ton chat de voter
                    </h6>
                  </div>

                  <div class="modes-jeu-twitch__content-btns">
                    <button type="button" id="voteParticipatif" class="btn btn-gradient-primary modeGameTwitchBtn" spellcheck="false">Vote Participatif</button>

                    <button type="button" id="votePrediction" class="btn btn-gradient-primary modeGameTwitchBtn" spellcheck="false">Élimination directe</button>

                    <button type="button" id="votePoints" class="btn btn-gradient-primary modeGameTwitchBtn" spellcheck="false">Match aux points</button>
                  </div>
                  <span class="modes-jeu-twitch__content-msg d-none">
                    <i data-feather='check'></i> Mode sélectionné, tu peux lancer le Top 🚀 
                  </span>
                </div>
              </div>
            <?php endif; ?>
          </div>
        </div>

      <?php else : ?>

        <div class="intro-mobile">
          <div class="tournament-heading text-center">
            <h3 class="mb-0 t-titre-tournoi">Top <?php echo $top_infos['top_number']; ?> <span class="ico">⚔️</span> <?php echo $top_infos['top_title']; ?></h3>
            <h4 class="text-center t-question">
              <?php echo $top_infos['top_question']; ?> <br>
            </h4>
          </div>
        </div>

        <div class="row">
          <div class="col-md-12">
            <?php if ($top_infos['top_type'] != "top3") : ?>
              <div class="container-fluid d-none d-sm-block">
                <div class="tournoi-infos mb-2">
                  <div class="display_current_user_rank">
                    <div class="row">
                      <div class="col-12">
                        <div class="current_rank">
                          <?php
                          set_query_var('current_user_ranking_var', compact('id_ranking', 'id_top'));
                          get_template_part('templates/parts/content', 'user-ranking');
                          ?>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            <?php endif; ?>

            <div class="container <?php echo (get_field('c_rounded_t', $id_top)) ? 'rounded' : ''; ?>">
              <div class="row">
                <div class="col">
                  <div class="display_battle">
                    <?php
                    set_query_var('battle_vars', compact('contender_1', 'contender_2', 'id_top', 'id_ranking', 'id_vainkeur'));
                    get_template_part('templates/parts/content', 'battle');
                    ?>
                  </div>

                  <?php if (!isMobile() && is_user_logged_in() && get_userdata($user_id)->twitch_user) : ?>
                    <div 
                      class="d-none twitch-votes-container row align-items-center justify-content-center" data-twitchChannel="<?= get_userdata($user_id)->twitch_user; ?>">
                      <div class="col-sm-4 col-12">
                      </div>

                      <div class="col col-sm-4 row justify-content-between align-items-center">
                        <div class="taper-container animate__animated animate__slideInDown">
                          <div class="votes-container">
                            <p>Taper 1</p>

                            <div class="votes-stats taper-zone d-none" id="votes-stats-1">
                              <p class="votes-percent" id="votes-percent-1">0%</p>
                            </div>
                          </div>
                        </div>

                        <div class="votes-stats-container d-none">
                          <p class="votes-stats-p">
                            <strong class="votes-number">0</strong> <span class="votes-number-wording">Vote</span> du chat
                          </p>
                          <p><strong class="votes-number-total">0</strong> votes depuis le début</p>
                        </div>

                        <div class="taper-container animate__animated animate__slideInUp">
                          <div class="votes-container">
                            <p>Taper 2</p>

                            <div class="votes-stats taper-zone d-none" id="votes-stats-2">
                              <p class="votes-percent" id="votes-percent-2">0%</p>
                            </div>
                          </div>
                        </div>
                      </div>

                      <div class="col-sm-4 col-12">
                      </div>
                    </div>

                    <!-- WINNER MODE… -->
                    <div class="textcontainer">
                      <span class="particletext confetti"></span>
                    </div>
                    <audio id="winner-sound" style="display: none; width: 0 !important;">
                      <source src="<?php bloginfo('template_directory'); ?>/assets/audios/winner-sound.mp3" type="audio/mpeg" />
                    </audio>

                    <div class="twitch-overlay d-none">
                      <h4>Lancement du jeu dans</h4>
                      <div id="countdown">
                        <div class="counter">
                          <div class="nums">
                            <span class="in">30</span>
                            <span>29</span>
                            <span>28</span>
                            <span>27</span>
                            <span>26</span>
                            <span>25</span>
                            <span>24</span>
                            <span>23</span>
                            <span>22</span>
                            <span>21</span>
                            <span>20</span>
                            <span>19</span>
                            <span>18</span>
                            <span>17</span>
                            <span>16</span>
                            <span>15</span>
                            <span>14</span>
                            <span>13</span>
                            <span>12</span>
                            <span>11</span>
                            <span>10</span>
                            <span>9</span>
                            <span>8</span>
                            <span>7</span>
                            <span>6</span>
                            <span>5</span>
                            <span>4</span>
                            <span>3</span>
                            <span>2</span>
                            <span>1</span>
                            <span>0</span>
                          </div>
                          <h4>Taper VKRZ dans le chat <br> pour participer!</h4>

                        </div>

                        <div class="final">
                          <button 
                            type="button" 
                            id="launchGameBtn" 
                            class="btn btn-lg waves-effect btn-rose" 
                            spellcheck="false"
                          >
                            Lancer le jeu
                          </button>
                        </div>
                      </div>
                      <span class="mode-alert"><i class="far fa-info-circle"></i> Il faut au moins deux participants</span>

                      <div id="participants-overlay" class="mt-2 text-white d-none"></div>

                      <a data-phrase1="Es-tu sûr de vouloir recommencer ?" data-phrase2="Tous les votes de ce Top seront remis à 0" data-id_ranking="<?php echo $id_ranking; ?>" data-id_vainkeur="<?php echo $id_vainkeur; ?>" href="#" class="confirm_delete btn btn-sm btn-outline-dark waves-effect">
                        Annuler
                      </a>
                    </div>
                  <?php endif; ?>
                </div>

                <div id="prediction-player" class="col-md-3 d-none">
                  <div class="card mb-2" id="participants">
                    <div class="card-header">
                      <h4 class="card-title"><i class="fab fa-twitch"></i> Participants</h4>
                    </div>
                    <div class="card-body">
                    </div>
                  </div>
                </div>

                <div id="ranking-player" class="col d-none">
                  <table class="table table-points">
                    <thead>
                      <tr>
                        <th>
                          <span class="text-muted">
                            Position
                          </span>
                        </th>

                        <th>
                          <span class="text-muted">
                            Vainkeur
                          </span>
                        </th>

                        <th>
                          <span class="text-muted">
                            A voté ?
                          </span>
                        </th>

                        <th class="text-left">
                          <span class="text-muted">
                            Points
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

        <?php
        set_query_var('steps_var', compact('current_step'));
        get_template_part('templates/parts/content', 'step-bar');
        ?>

      <?php endif; ?>
    </div>
  </div>

  <div class="showTwitchBanner d-none" style="background-image: url(<?php bloginfo('template_directory'); ?>/assets/images/events/twitch-plus.png);" onmouseover="changeIcon('plus')" onmouseout="changeIcon('twitch')">
    <i class="fab fa-twitch"></i>
    <i class="fa fa-plus d-none"></i>
    <i class="fa fa-minus d-none"></i>
  </div>
</div>

<?php if ($id_ranking) : ?>
  <nav class="navbar mobile-navbar">
    <div class="icons-navbar">
      <div class="ico-nav-mobile box-info-show">
        <span class="ico va va-placard va-lg hide-xs"></span> <span class="hide-spot">Infos <span class="hide-xs">du Top</span></span>
      </div>
      <div class="ico-nav-mobile share-natif-top">
        <span class="ico va va-megaphone va-lg hide-xs"></span> <span class="hide-spot">Partager</span>
      </div>
      <div class="ico-nav-mobile">
        <a href="<?php echo get_the_permalink(get_page_by_path('discuz')) . '?id_top=' . $id_top; ?>">
          <span class="ico va va-speech-balloon va-lg hide-xs"></span> <span class="hide-spot">Commenter</span>
        </a>
      </div>
      <?php if (get_post_status($id_top) != "draft") : ?>
        <div class="ico-nav-mobile">
          <a data-phrase1="Es-tu sûr de vouloir recommencer ?" data-phrase2="Tous les votes de ce Top seront remis à 0" data-id_ranking="<?php echo $id_ranking; ?>" data-id_vainkeur="<?php echo $id_vainkeur; ?>" href="#" class="confirm_delete">
            <span class="ico va va-repeat va-lg hide-xs"></span> <span class="hide-spot">Recommencer</span>
          </a>
        </div>
      <?php endif; ?>
    </div>
  </nav>
  <div class="share-top-content">
    <h3>
      <span class="ico va va-megaphone va-lg hide-xs"></span> Partager le lien du Top
    </h3>
    <div class="close-share">
      <i class="fal fa-times"></i>
    </div>
    <ul>
      <li>
        <a href="javascript: void(0)" class="sharelinkbtn2">
          <input type="text" value="<?php echo $top_infos['top_url']; ?>" class="input_to_share2">
          <i class="social-media fas fa-paperclip"></i> <span>Copier le lien du Top</span>
        </a>
      </li>
      <li>
        <a href="https://twitter.com/intent/tweet?text=Go faire le TOP <?php echo $top_infos['top_number']; ?> <?php echo $top_infos['top_title']; ?>&via=vainkeurz&hashtags=VKRZ&url=<?php echo $url_top; ?>" target="_blank" title="Tweet">
          <i class="social-media fab fa-twitter"></i> Dans un Tweet
        </a>
      </li>
      <li>
        <a href="whatsapp://send?text=<?php echo $url_top; ?>" data-action="share/whatsapp/share">
          <i class="social-media mb-12 fab fa-whatsapp"></i> Sur WhatsApp
        </a>
      </li>
      <li>
        <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo $url_top; ?>" title="Partager sur Facebook" target="_blank">
          <i class="social-media fab fa-facebook-f"></i> Sur Facebook
        </a>
      </li>
    </ul>
  </div>
  <div class="box-info-content">
    <h3>
      <span class="ico va va-placard va-lg"></span>
      Tous les infos du Top
    </h3>
    <div class="close-share">
      <i class="fal fa-times"></i>
    </div>
    <div class="box-info-list">
      <div class="card text-left">
        <div class="card-body">
          <h4 class="card-title">
            <?php
            date_default_timezone_set('Europe/Paris');
            $origin     = new DateTime(get_the_date('Y-m-d', $id_top));
            $target     = new DateTime(date('Y-m-d'));
            $interval   = $origin->diff($target);
            if ($interval->days == 0) {
              $info_date = "aujourd'hui";
            } elseif ($interval->days == 1) {
              $info_date = "hier";
            } else {
              $info_date = "depuis " . $interval->days . " jours";
            }
            ?>
            <span class="va va-birthday-cake va-md"></span> Créé <span class="t-violet"><?php echo $info_date; ?></span> par :
          </h4>
          <div class="employee-task d-flex justify-content-between align-items-center">
            <a href="<?php echo $creator_data['creator_url']; ?>" class="d-flex flex-row link-to-creator">
              <div class="avatar me-75 mr-1">
                <img src="<?php echo $creator_data['avatar']; ?>" class="circle" width="42" height="42" alt="Avatar">
              </div>
              <div class="my-auto">
                <h4 class="mb-0">
                  <?php echo $creator_data['pseudo']; ?> <br>
                  <span class="ico" data-toggle="tooltip" data-placement="top" title="" data-original-title="niveau">
                    <?php echo $creator_data['level']; ?>
                  </span>
                  <?php if ($creator_data['user_role']  == "administrator") : ?>
                    <span class="ico va va-vkrzteam va-lg" data-toggle="tooltip" data-placement="top" title="" data-original-title="TeamVKRZ"></span>
                  <?php endif; ?>
                  <?php if ($creator_data['user_role']  == "administrator" || $creator_data['user_role'] == "author") : ?>
                    <span class="ico va va-man-singer va-lg" data-toggle="tooltip" data-placement="top" title="" data-original-title="Créateur de Tops"></span>
                  <?php endif; ?>
                </h4>
              </div>
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>
<?php endif; ?>

<?php get_template_part('partials/loader'); ?>
<?php get_footer(); ?>