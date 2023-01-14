<?php
global $uuid_vainkeur;
global $user_id;
global $user_tops;
global $infos_vainkeur;
global $id_vainkeur;
global $utm;
global $id_top;
global $id_ranking;
global $top_infos;
global $id_top_global;
global $creator_data;
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
$id_top_global      = $id_top;
get_header();
?>
<script>
  const link_to_ranking = "<?= get_the_permalink($id_ranking) ?>";
</script>

<div class="tournoi-content my-4">
  <?php if (!$id_ranking) : ?>

    <div class="content-intro container mt-4">
      <div class="row justify-content-center">
        <div class="col-md-8">
          <div class="card animate__animated animate__flipInX card-developer-meetup">
            <div class="meetup-img-wrapper rounded-top text-left" style="background-image: url(<?php echo $top_infos['top_img']; ?>);">
              <span class="badge badge-light-primary">Créé le <?php echo $top_infos['top_date']; ?></span>
              <div class="list-unstyled m-0 d-flex align-items-center avatar-group my-3 list-contenders">
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
                ?>
                <?php while ($contenders_t->have_posts()) : $contenders_t->the_post(); ?>
                  <li data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-custom-class="tooltip-danger" data-bs-placement="top" class="avatar pull-up" aria-label="<?php echo get_the_title(get_the_id()); ?>" data-bs-original-title="<?php echo get_the_title(get_the_id()); ?>">
                    <?php if (get_field('visuel_instagram_contender', get_the_id())) : ?>
                      <img src="<?php the_field('visuel_instagram_contender', get_the_id()); ?>" alt="<?php echo get_the_title(get_the_id()); ?>" height="32" width="32">
                    <?php else : ?>
                      <?php $illu = get_the_post_thumbnail_url(get_the_id(), 'thumbnail'); ?>
                      <img src="<?php echo $illu; ?>" alt="<?php echo get_the_title(get_the_id()); ?>" height="32" width="32">
                    <?php endif; ?>
                  </li>
                <?php endwhile; ?>
              </div>
            </div>
            <div class="card-body presentationtop">
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
              <?php if ($top_infos['top_number'] <= 20) : ?>
                <div class="choosecta">
                  <div class="cta-begin cta-complet">
                    <a href="#" id="begin_t" data-typetop="complet" data-top="<?php echo $id_top; ?>" data-id_vainkeur="<?php echo $id_vainkeur; ?>" data-uuiduser="<?php echo $uuid_vainkeur; ?>" class="w-100 animate__jello animate__animated animate__delay-1s btn btn-max btn-primary waves-effect waves-float waves-light laucher_t">
                      <i class="fab fa-twitch twitch-icon-tbegin d-none"></i>&nbsp;
                      Top Complet
                    </a>
                    <small class="text-muted">
                      <?php
                      $min = ($top_infos['top_number'] - 5) * 2 + 6;
                      $max = $min * 2;
                      ?>
                      <?php if ($top_infos['top_number'] < 3) : ?>
                        Un seul vote suffira pour finir ce Top
                      <?php else : ?>
                        Prévoir entre <?php echo $min; ?> et <?php echo $max; ?> votes pour finir ton Top du 1er au dernier
                      <?php endif; ?>
                    </small>
                  </div>
                  <?php if ($top_infos['top_number'] > 10) : ?>
                    <div class="cta-begin cta-top3">
                      <a href="#" id="begin_top3" data-typetop="top3" data-top="<?php echo $id_top; ?>" data-id_vainkeur="<?php echo $id_vainkeur; ?>" data-uuiduser="<?php echo $uuid_vainkeur; ?>" class="w-100 animate__jello animate__animated animate__delay-1s btn btn-max btn-primary waves-effect waves-float waves-light laucher_t">
                        <i class="fab fa-twitch twitch-icon-tbegin d-none"></i>&nbsp;
                        Top 3
                      </a>
                      <small class="text-muted">
                        <?php
                        $max = (floor($top_infos['top_number'] / 2)) + (3 * ((round($top_infos['top_number'] / 2)) - 1));
                        $min = (floor($top_infos['top_number'] / 2)) + ((round($top_infos['top_number'] / 2)) - 1) + 3;
                        $moy = ($max + $min) / 2;
                        ?>
                        Prévoir environ <?php echo round($moy); ?> votes pour juste faire ton podium
                      </small>
                    </div>
                  <?php endif; ?>
                </div>
              <?php else : ?>
                <div class="choosecta flex-row-reverse">
                  <div class="cta-begin cta-complet">
                    <a href="#" id="begin_t" data-typetop="complet" data-top="<?php echo $id_top; ?>" data-id_vainkeur="<?php echo $id_vainkeur; ?>" data-uuiduser="<?php echo $uuid_vainkeur; ?>" class="w-100 animate__jello animate__animated animate__delay-1s btn btn-max btn-primary waves-effect waves-float waves-light laucher_t">
                      <i class="fab fa-twitch twitch-icon-tbegin d-none"></i>&nbsp;
                      Top Complet
                    </a>
                    <small class="text-muted">
                      <?php
                      $min = ($top_infos['top_number'] - 5) * 2 + 6;
                      $max = $min * 2;
                      ?>
                      <?php if ($top_infos['top_number'] < 3) : ?>
                        Un seul vote suffira pour finir ce Top
                      <?php else : ?>
                        Prévoir entre <?php echo $min; ?> et <?php echo $max; ?> votes pour finir ton Top du 1er au dernier
                      <?php endif; ?>
                    </small>
                  </div>
                  <?php if ($top_infos['top_number'] > 10) : ?>
                    <div class="cta-begin cta-top3">
                      <a href="#" id="begin_top3" data-typetop="top3" data-top="<?php echo $id_top; ?>" data-id_vainkeur="<?php echo $id_vainkeur; ?>" data-uuiduser="<?php echo $uuid_vainkeur; ?>" class="w-100 animate__jello animate__animated animate__delay-1s btn btn-max btn-primary waves-effect waves-float waves-light laucher_t">
                        <i class="fab fa-twitch twitch-icon-tbegin d-none"></i>&nbsp;
                        Top 3
                      </a>
                      <small class="text-muted">
                        <?php
                        $max = (floor($top_infos['top_number'] / 2)) + (3 * ((round($top_infos['top_number'] / 2)) - 1));
                        $min = (floor($top_infos['top_number'] / 2)) + ((round($top_infos['top_number'] / 2)) - 1) + 3;
                        $moy = ($max + $min) / 2;
                        ?>
                        Prévoir environ <?php echo round($moy); ?> votes pour juste faire ton podium
                      </small>
                    </div>
                  <?php endif; ?>
                </div>
              <?php endif; ?>
            </div>
            <div class="card-footer">
              <div class="row meetings align-items-center">
                <div class="col">
                  <div class="infos-card-t info-card-t-v d-flex align-items-center">
                    <div class="mr-1">
                      <span class="ico va-high-voltage va va-2x"></span>
                    </div>
                    <div class="content-body text-center">
                      <h4 class="mb-0">
                        <?php echo $top_datas['nb_votes']; ?>
                      </h4>
                      <small class="text-muted">votes</small>
                    </div>
                  </div>
                </div>
                <div class="col">
                  <div class="infos-card-t d-flex align-items-center">
                    <div class="mr-1">
                      <span class="ico va va-trophy va-2x"></span>
                    </div>
                    <div class="content-body text-center">
                      <h4 class="mb-0">
                        <?php echo $top_datas['nb_tops']; ?>
                      </h4>
                      <small class="text-muted">TopList</small>
                    </div>
                  </div>
                </div>
                <div class="col">
                  <div class="infos-card-t d-flex align-items-center infos-card-t-c">
                    <div class="">
                      <a href="<?php the_permalink(218587); ?>?creator_id=<?php echo $creator_id; ?>" target="_blank">
                        <div class="avatar avatar-t-single">
                          <img src="<?php echo $creator_data['avatar']; ?>" alt="Avatar" width="38" height="38">
                        </div>
                      </a>
                    </div>
                    <div class="content-body text-left">
                      <small class="text-muted text-left">Conçu par</small>
                      <h4 class="mb-0 link-creator">
                        <a href="<?php the_permalink(218587); ?>?creator_id=<?php echo $creator_id; ?>" target="_blank" class="link-to-creator">
                          <?php echo $creator_data['pseudo']; ?>
                          <span class="ico" data-toggle="tooltip" data-placement="top" title="" data-original-title="niveau">
                            <?php echo $creator_data['level']; ?>
                          </span>
                          <?php if ($creator_data['user_role']  == "administrator") : ?>
                            <span class="ico va va-vkrzteam va-lg" data-toggle="tooltip" data-placement="top" title="" data-original-title="TeamVKRZ">
                            </span>
                          <?php endif; ?>
                          <?php if ($creator_data['user_role']  == "administrator" || $creator_data['user_role'] == "author") : ?>
                            <span class="ico va va-man-singer va-lg" data-toggle="tooltip" data-placement="top" title="" data-original-title="Créateur de Tops">
                            </span>
                          <?php endif; ?>
                        </a>
                      </h4>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <?php if (!isMobile() && is_user_logged_in() && get_userdata($user_id)->twitch_user) : ?>
          <div class="col-md-4 d-none modes-jeu-twitch animate__animated animate__slideInRight" style="background-image: url(<?php bloginfo('template_directory'); ?>/assets/images/events/twitch-games-banner.png);">
            <div class="modes-jeu-twitch__content">
              <div class="modes-jeu-twitch__content-header">
                <h4>
                  <i class="fab fa-2x fa-twitch mb-50"></i>
                  <br>
                  Modes de jeu pour ton stream
                </h4>
                <h6>
                  Choisis un mode pour permettre à ton tchat de voter 🫡
                </h6>
              </div>
              <div class="modes-jeu-twitch__content-btns">
                <button type="button" id="voteParticipatif" class="btn btn-gradient-primary modeGameTwitchBtn" spellcheck="false">Votes collaboratifs</button>
                <button type="button" id="votePrediction" class="btn btn-gradient-primary modeGameTwitchBtn" spellcheck="false">Mort subite</button>
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

    <div class="tournoi-content-final">
      <div class="tournament-heading">
        <div class="container">
          <h1 class="t-titre-tournoi">
            <div class="text-muted">
              TOP <?php echo $top_infos['top_number']; ?> <?php echo $top_infos['top_cat_icon']; ?> <?php echo $top_infos['top_title']; ?>
            </div>
            <?php echo $top_infos['top_question']; ?>
          </h1>
          <?php if ($top_infos['top_type'] != "top3") : ?>
            <div class="container d-none d-sm-block">
              <div class="tournoi-infos">
                <div class="display_current_user_rank">
                  <div class="current_rank">
                    <?php
                    set_query_var('current_user_ranking_var', compact('id_ranking', 'id_top'));
                    get_template_part('templates/parts/content', 'user-ranking');
                    ?>
                  </div>
                </div>
              </div>
            </div>
          <?php endif; ?>
        </div>
      </div>
      <div class="row">
        <div class="col-md-12">
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
                  <div class="d-none twitch-votes-container row align-items-center justify-content-center" data-twitchChannel="<?= get_userdata($user_id)->twitch_user; ?>" data-top="<?= $top_infos['top_title'] . ' ' . $top_infos['top_number'] . ' ' . $top_infos['top_question'];  ?> " data-topCategory="<?= $top_infos['top_cat_name'] ?>" data-idTop="<?= $id_top; ?>" data-idVainkeur="<?= $id_vainkeur; ?>">
                    <div class="row">
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
                  </div>
                  <div class="twitchGamesWinnerContainer">
                    <span class="twitchGamesWinnerName confetti"></span>
                    <div class="buttons">
                      <a data-phrase1="Es-tu sûr de vouloir recommencer ?" data-phrase2="Tous les votes de ce Top seront remis à 0" data-id_ranking="<?php echo $id_ranking; ?>" data-id_vainkeur="<?php echo $id_vainkeur; ?>" href="#" class="confirm_delete btn btn-sm btn-outline-dark waves-effect mr-1"> Recommencer</a>
                      <a href="#" class="btn btn-sm btn-outline-primary waves-effect mr-1" id="winner-continuer"> Continuer</a>
                      <a href="#" class="btn btn-sm btn-outline-danger waves-effect" id="winner-relancer"> Relancer</a>
                    </div>
                  </div>
                  <audio id="winner-sound" style="display: none; width: 0 !important;">
                    <source src="<?php bloginfo('template_directory'); ?>/assets/audios/winner-sound.mp3" type="audio/mpeg" />
                  </audio>
                  <div class="twitch-overlay d-none">
                    <h4>Lancement du jeu dans</h4>
                    <div id="countdown">
                      <div class="counter">
                        <div class="nums">
                          <span class="in">59</span>
                          <span>58</span>
                          <span>57</span>
                          <span>56</span>
                          <span>55</span>
                          <span>54</span>
                          <span>53</span>
                          <span>52</span>
                          <span>51</span>
                          <span>50</span>
                          <span>49</span>
                          <span>48</span>
                          <span>47</span>
                          <span>46</span>
                          <span>45</span>
                          <span>44</span>
                          <span>43</span>
                          <span>42</span>
                          <span>41</span>
                          <span>40</span>
                          <span>39</span>
                          <span>38</span>
                          <span>37</span>
                          <span>36</span>
                          <span>35</span>
                          <span>34</span>
                          <span>33</span>
                          <span>32</span>
                          <span>31</span>
                          <span>30</span>
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
                        <button type="button" id="launchGameBtn" class="btn btn-lg waves-effect btn-rose" spellcheck="false">
                          Lancer le jeu
                        </button>
                      </div>
                    </div>
                    <span class="mode-alert"><i class="far fa-info-circle"></i> Il faut au moins deux participants</span>
                    <div id="participants-overlay" class="mt-2 text-white d-none" data-content="Participants :"></div>
                    <a data-phrase1="Es-tu sûr de vouloir recommencer ?" data-phrase2="Tous les votes de ce Top seront remis à 0" data-id_ranking="<?php echo $id_ranking; ?>" data-id_vainkeur="<?php echo $id_vainkeur; ?>" href="#" class="confirm_delete btn btn-sm btn-outline-dark waves-effect">
                      Annuler
                    </a>
                  </div>
                <?php endif; ?>
              </div>
              <?php if (!isMobile() && is_user_logged_in() && get_userdata($user_id)->twitch_user) : ?>
                <div id="prediction-player" class="col-3 d-none">
                  <div class="card mb-2" id="participants">
                    <div class="card-header flex-column align-items-start">
                      <h4 class="card-title">
                        <i class="fab fa-twitch"></i> <strong class="prediction-participants-votey-nbr">0</strong> de <strong class="prediction-participants">0</strong> Participants ont Voté
                      </h4>
                      <h4 class="card-title elimines d-none"></h4>
                    </div>
                    <div class="card-body">
                    </div>
                  </div>
                </div>
                <div id="ranking-player" class="col-3 d-none">
                  <h4 class="card-title">
                    <i class="fab fa-twitch"></i> <strong class="points-participants-votey-nbr">0</strong> de <strong class="points-participants">0</strong> Participants ont Voté
                  </h4>
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
              <?php endif; ?>
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

<?php if (!isMobile() && is_user_logged_in() && get_userdata($user_id)->twitch_user) : ?>
  <div class="showTwitchBanner d-none" style="background-image: url(<?php bloginfo('template_directory'); ?>/assets/images/events/twitch-plus.png);" onmouseover="twitchGamesToggleIcon('plus')" onmouseout="twitchGamesToggleIcon('twitch')">
    <i class="fab fa-twitch"></i>
    <i class="fa fa-plus d-none"></i>
    <i class="fa fa-minus d-none"></i>
  </div>
<?php endif; ?>

<?php if ($id_ranking) : ?>
  <!-- Right Nav -->
  <div class="infos-toplist">
    <a href="#" class="btn-emoji btn-emoji-recommencer confirm_delete" data-bs-toggle="tooltip" data-bs-placement="left" data-bs-original-title="Recommencer" data-phrase1="Es-tu sûr de vouloir recommencer ?" data-phrase2="Tous les votes de ce Top seront remis à 0" data-id_ranking="<?php echo $id_ranking; ?>" data-id_vainkeur="<?php echo $id_vainkeur; ?>">
      <span class="va va-recommencer va-lg"></span>
    </a>
    <a href="<?php echo get_the_permalink(get_page_by_path('discuz')) . '?id_top=' . $id_top; ?>" class="btn-emoji btn-emoji-wording" data-bs-toggle="tooltip" data-bs-placement="left" data-bs-original-title="Commente le Top">
      <span class="va va-writing-hand va-lg"></span>
      <div class="value">
        5
      </div>
    </a>
    <?php
    $creator_id = get_post_field('post_author', $id_top);
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
  <?php get_template_part('widgets/top-info'); ?>
  <!-- /Offcanvas -->
<?php endif; ?>

<?php get_template_part('partials/loader'); ?>
<?php get_template_part('partials/recommencer'); ?>

<?php get_footer(); ?>