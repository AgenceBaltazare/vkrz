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
global $type_top;
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
$get_top_type       = get_the_terms($id_top, 'type');
if ($get_top_type) {
  foreach ($get_top_type as $type_top) {
    $type_top = $type_top->slug;
  }
}
get_header();
?>
<script>
  const link_to_ranking = "<?= get_the_permalink($id_ranking) ?>";
</script>

<div class="tournoi-content my-4">
  <?php if (!$id_ranking) : ?>
    <div class="content-intro container mt-4">
      <div class="row justify-content-center">
        <div class="col-md-8 order-1 order-sm-0">
          <?php if ($type_top == "sponso") : ?>
            <div class="title-win d-none d-sm-block">
              <h4>
                <?php the_field('titre_de_la_sponso_t_sponso', $id_top); ?> <span class="va va-four-leaf-clover va-lg ms-2"></span>
              </h4>
            </div>
          <?php endif; ?>
          <div class="card animate__animated animate__flipInX card-developer-meetup">
            <div class="meetup-img-wrapper rounded-top text-left" style="background-image: url(<?php echo $top_infos['top_img']; ?>);">
              <?php if ($type_top != "sponso") : ?>
                <span class="badge badge-light-primary">Créé le <?php echo $top_infos['top_date']; ?></span>
              <?php endif; ?>
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
                  <h2 class="card-title mb-25">
                    TOP <?php echo $top_infos['top_number']; ?> <?php echo $top_infos['top_cat_icon']; ?> <?php echo $top_infos['top_title']; ?>
                  </h2>
                  <h1 class="card-text mb-0 t-violet animate__animated animate__flash">
                    <?php echo $top_infos['top_question']; ?>
                  </h1>
                </div>
              </div>
            </div>
            <div class="card-cta">
              <?php if ($top_infos['top_number'] <= 10) : ?>
                <div class="choosecta">
                  <div class="cta-begin cta-complet">
                    <a href="#" id="begin_t" data-typetop="complet" data-top="<?php echo $id_top; ?>" data-id_vainkeur="<?php echo $id_vainkeur; ?>" data-uuiduser="<?php echo $uuid_vainkeur; ?>" class="w-100 animate__jello animate__animated animate__delay-1s btn btn-max btn-primary waves-effect waves-float waves-light laucher_t">
                      <i class="fab fa-twitch twitch-icon-tbegin d-none"></i>&nbsp;
                      <?php if ($type_top == "sponso") : ?>
                        Participer
                      <?php else : ?>
                        Top Complet
                      <?php endif; ?>
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
                </div>
              <?php else : ?>
                <div class="choosecta flex-row-reverse">
                  <?php if ($type_top != "sponso") : ?>
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
                  <?php endif; ?>
                  <div class="cta-begin cta-top3">
                    <a href="#" id="begin_top3" data-typetop="top3" data-top="<?php echo $id_top; ?>" data-id_vainkeur="<?php echo $id_vainkeur; ?>" data-uuiduser="<?php echo $uuid_vainkeur; ?>" class="w-100 animate__jello animate__animated animate__delay-1s btn btn-max btn-primary waves-effect waves-float waves-light laucher_t">
                      <i class="fab fa-twitch twitch-icon-tbegin d-none"></i>&nbsp;
                      <?php if ($type_top == "sponso") : ?>
                        Participer
                      <?php else : ?>
                        Top 3
                      <?php endif; ?>
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
                </div>
              <?php endif; ?>
            </div>
            <div class="card-footer info-top-footer">
              <div class="row meetings align-items-center">
                <?php if ($type_top != "sponso") : ?>
                  <div class="col">
                    <div class="infos-card-t info-card-t-v d-flex align-items-center">
                      <div class="me-1">
                        <span class="ico va-high-voltage va va-2x"></span>
                      </div>
                      <div class="info-numbers">
                        <h4>
                          <?php echo $top_datas['nb_votes']; ?>
                        </h4>
                        <small class="text-muted">votes</small>
                      </div>
                    </div>
                  </div>
                  <div class="col">
                    <div class="infos-card-t d-flex align-items-center">
                      <div class="me-1">
                        <span class="ico va va-trophy va-2x"></span>
                      </div>
                      <div class="info-numbers">
                        <h4>
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
                        <h4 class="link-creator">
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
                <?php else : ?>
                  <div class="col">
                    <div class="infos-card-t d-flex align-items-center">
                      <div class="me-2">
                        <span class="ico va va-face-screaming va-2x"></span>
                      </div>
                      <div class="info-numbers">
                        <small class="text-muted">Fin du concours</small>
                        <h4>
                          Le 10/02/23
                        </h4>
                      </div>
                    </div>
                  </div>
                  <div class="col">
                    <div class="infos-card-t d-flex align-items-center">
                      <div class="me-2">
                        <span class="ico va va-wrapped-gift va-2x"></span>
                      </div>
                      <div class="info-numbers mb-n-1">
                        <h4>
                          <?php the_field('gain_champs_1_t_sponso', $id_top); ?>
                        </h4>
                        <small class="text-muted"><?php the_field('gain_champs_2_t_sponso', $id_top); ?></small>
                      </div>
                    </div>
                  </div>
                <?php endif; ?>
              </div>
            </div>
          </div>
        </div>
        <?php if ($type_top == "sponso") : ?>
          <div class="col-md-4 t-sponso-banner">
            <?php if ($type_top == "sponso") : ?>
              <div class="title-win d-block d-sm-none">
                <h4>
                  <?php the_field('titre_de_la_sponso_t_sponso', $id_top); ?> <span class="va va-four-leaf-clover va-lg ms-2"></span>
                </h4>
              </div>
            <?php endif; ?>
            <div class="card animate__animated animate__flipInX ba-deg">
              <div class="card-body rules-content pt-3 py-2">
                <div class="text-rules">
                  <?php the_field('description_t_sponso', $id_top); ?>
                  <?php if (get_field('inscription_requise_t_sponso', $id_top) && !is_user_logged_in()) : ?>
                    <div class="compterequis">
                      <em>
                        * Tu devras te connecter à la fin du Top pour participer au tirage au sort
                      </em>
                    </div>
                  <?php endif; ?>
                </div>
              </div>
              <div class="card-footer share-content-sponso">
                <div class="separate"></div>
                <div class="d-flex align-items-center">
                  <div class="text-left">
                    <?php the_field('top_propose_par_t_sponso', $id_top); ?>
                  </div>
                  <div>
                    <?php
                    if (get_field('logo_de_la_sponso_t_sponso', $id_top)) : ?>
                      <?php $imglogo = wp_get_attachment_image_url(get_field('logo_de_la_sponso_t_sponso', $id_top), 'large'); ?>
                      <a href="<?php the_field('lien_de_la_sponso_t_sponso', $id_top); ?>" class="btn-sponsor" target="_blank">
                        <img src="<?php echo $imglogo; ?>" alt="" class="img-fluid">
                      </a>
                    <?php endif; ?>
                  </div>
                </div>
                <div class="d-flex align-items-center reseaux-sponso m-0">
                  <div class="mt-2 social-media-sponso">
                    <div class="d-flex buttons-social-media">
                      <?php if (have_rows('liste_des_liens_t_sponso', $id_top)) : ?>
                        <?php while (have_rows('liste_des_liens_t_sponso', $id_top)) : the_row(); ?>
                          <a href="<?php the_sub_field('lien_vers_t_sponso'); ?>" class="w-100 animate__jello animate__animated animate__delay-1s btn btn-max btn-outline-primary waves-effect waves-float waves-light" target="_blank">
                            <?php if (get_sub_field('intitule_t_sponso') == "Discord") : ?>
                              <i class="fab fa-discord fa-2x"></i>
                            <?php elseif (get_sub_field('intitule_t_sponso') == "Instagram") : ?>
                              <i class="fab fa-instagram fa-2x"></i>
                            <?php elseif (get_sub_field('intitule_t_sponso') == "Twitter") : ?>
                              <i class="fab fa-twitter fa-2x"></i>
                            <?php elseif (get_sub_field('intitule_t_sponso') == "TikTok") : ?>
                              <i class="fab fa-tiktok fa-2x"></i>
                            <?php elseif (get_sub_field('intitule_t_sponso') == "Site") : ?>
                              <i class="fa-solid fa-desktop fa-2x"></i>
                            <?php elseif (get_sub_field('intitule_t_sponso') == "Facebook") : ?>
                              <i class="fa-brands fa-facebook-f fa-2x"></i>
                            <?php endif; ?>
                          </a>
                        <?php endwhile; ?>
                      <?php endif; ?>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        <?php endif; ?>
      </div>
    </div>
    <?php if (!isMobile() && is_user_logged_in() && get_userdata($user_id)->twitch_user) : ?>
      <button class="btnstarttwitch" type="button" data-bs-toggle="offcanvas" data-bs-target="#twitchgame" aria-controls="twitchgame" spellcheck="false">
        <div class="titre-btn-btnstarttwitch">
          <i class="fab fa-2x fa-twitch mb-50"></i> Faire ta TopList en live
        </div>
        <div>
          <small>Tes viewvers participent en votant 1 ou 2 dans le tchat</small>
        </div>
      </button>
      <div class="modes-jeu-twitch offcanvas offcanvas-bottom" tabindex="-1" id="twitchgame" aria-labelledby="twitchgameLabel" spellcheck="false" aria-modal="true" role="dialog">
        <div class="row align-items-center">
          <div class="col-md-6 offset-md-1">
            <h4>
              <i class="fab fa-2x fa-twitch mb-50"></i>
              <br>
              Le moyen le plus Kool de jouer avec ton tchat
            </h4>
            <h5>
              Choisis un mode de jeu que tes viewers votent dans ta TopList <span class="va va-doigt-droit va-md"></span>
            </h5>
            <a class="btn btn-outline-blanc waves-effect" href="https://vainkeurz.com/twitch/" target="_blank">En savoir plus sur les extensions</a>
            <button type="button" class="btn btn-label-blanc ba-tranparent waves-effect" data-bs-dismiss="offcanvas">Annuler</button>
          </div>
          <div class="col-md-4">
            <div class="modes-jeu-twitch__content-btns">
              <button type="button" id="voteParticipatif" class="mb-3 btn btn-gradient-primary modeGameTwitchBtn">
                <div>
                  Vote Participatif <span class="va va-heart-hands va-lg"></span>
                </div>
                <div>
                  <small>Les viewvers votent en écrivant 1 ou 2 dans chaque duel selon leur propre avis. Tu vois en live le résultat et tu choisis de le suivre ou pas</small>
                </div>
              </button>
              <button type="button" id="votePrediction" class="mb-3 btn btn-gradient-primary modeGameTwitchBtn" spellcheck="false">
                <div>
                  Élimination directe <span class="va va-skull va-lg"></span>
                </div>
                <div>
                  <small>A chaque nouveau duel, tes viewvers doivent deviner ton choix. Ceux qui se trompent sont éliminés et à la fin il n'en restera qu'un</small>
                </div>
              </button>
              <button type="button" id="votePoints" class="btn btn-gradient-primary modeGameTwitchBtn" spellcheck="false">
                <div>Match aux points <span class="va va-hundred va-lg"></span></div>
                <div>
                  <small>Tes viewvers marquent 1 point à chaque fois qu'il devine bien ton choix. Le gagnant est celui qui a le plus scoré à la fin de la TopList</small>
                </div>
              </button>
            </div>
            <span class="modes-jeu-twitch__content-msg d-none">
              <i data-feather='check'></i> Mode sélectionné, tu peux lancer le Top 🚀
            </span>
          </div>
        </div>
      </div>
    <?php endif; ?>
  <?php else : ?>
    <div class="tournoi-content-final mt-3">
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
                          <div class="col col-sm-4 w-100 d-flex justify-content-evenly align-items-center">
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
                              <p>
                                <strong class="votes-number-total">0</strong> votes depuis le début
                              </p>
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
                          <div class="col-sm-4 col-12"></div>
                        </div>
                    </div>
                  <div class="twitchGamesWinnerContainer">
                    <span class="twitchGamesWinnerName confetti"></span>
                    <div class="buttons">
                      <a data-phrase1="Es-tu sûr de vouloir recommencer ?" data-phrase2="Tous les votes de ce Top seront remis à 0" data-id_ranking="<?php echo $id_ranking; ?>" data-id_vainkeur="<?php echo $id_vainkeur; ?>" href="#" class="confirm_delete btn btn-sm btn-outline-dark waves-effect me-2"> Relancer</a>
                      <a href="#" class="btn btn-sm btn-outline-primary waves-effect" id="winner-continuer"> Continuer</a>
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
                          <span class="in">11</span>
                          <!-- <span>58</span>
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
                          <span>11</span> -->
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
                    <span class="mode-alert"><i class="fas fa-info-circle"></i> Il faut au moins deux participants</span>
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
                        <i class="fab fa-twitch"></i> <strong class="prediction-participants-votey-nbr">0</strong> de <strong class="prediction-participants">0</strong> participants ont voté
                      </h4>
                      <h4 class="card-title elimines d-none"></h4>
                    </div>
                    <div class="card-body">
                    </div>
                  </div>
                </div>
                <div id="ranking-player" class="col-3 d-none">
                  <h4 class="card-title">
                    <i class="fab fa-twitch"></i> <strong class="points-participants-votey-nbr">0</strong> de <strong class="points-participants">0</strong> participants ont voté
                  </h4>
                  <table class="table table-points">
                    <thead>
                      <tr>
                        <th class="text-center">
                          <span class="text-muted">
                            Position
                          </span>
                        </th>

                        <th>
                          <span class="text-muted">
                            Vainkeur
                          </span>
                        </th>

                        <th class="text-center">
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

<?php if ($id_ranking) : ?>
  <!-- Right Nav -->
  <div class="infos-toplist">
    <a href="#" class="btn-emoji btn-emoji-recommencer confirm_delete" data-bs-toggle="tooltip" data-bs-placement="left" data-bs-original-title="Recommencer" data-phrase1="Es-tu sûr de vouloir recommencer ?" data-phrase2="Tous les votes de ce Top seront remis à 0" data-id_ranking="<?php echo $id_ranking; ?>" data-id_vainkeur="<?php echo $id_vainkeur; ?>">
      <span class="va va-recommencer va-lg"></span>
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