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
$is_top_saved       = check_top_saved($id_top, $id_vainkeur);
$creator_id         = get_post_field('post_author', $id_top);
$creator_info       = get_user_infos(get_field('uuiduser_user', 'user_' . $creator_id));
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
    <!-- Top pas lancé -->
    <div class="top_not_started">
      <div class="content-intro container mt-4">
        <div class="row justify-content-center">
          <div class="col-xl-8 order-1 order-sm-0">
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
                  <span class="badge bg-label-primary">Créé le <?php echo $top_infos['top_date']; ?></span>
                <?php endif; ?>

                <?php 
                if(is_user_logged_in() ) :
                  $wording = "";
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
                <div class="badge save-top <?= $statutfav; ?>" data-idtop="<?= $id_top; ?>" data-idvainkeur="<?= $id_vainkeur; ?>">
                <span>
                      <?php echo $wordingfav; ?>
                    </span>
                    <i class="va va-md va-star"></i>
                    <i class="va va-md va-avis"></i>
    
                  </div>
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
                      <a href="#" id="begin_t" data-typetop="complet" data-top="<?php echo $id_top; ?>" data-id_vainkeur="<?php echo $id_vainkeur; ?>" data-uuiduser="<?php echo $uuid_vainkeur; ?>" class="w-100 animate__jello animate__animated animate__delay-1s btn btn-max btn-rose waves-effect waves-float waves-light laucher_t begin_t_js">
                        <i class="fab fa-twitch twitch-icon-tbegin d-none"></i>&nbsp;
                        <?php if ($type_top == "sponso") : ?>
                          Participer au Top sponso
                        <?php else : ?>
                          Lancer ta TopList
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
                          <?php echo $min; ?> et <?php echo $max; ?> votes pour ta TopList du 1er au <?php echo $top_infos['top_number']; ?><sup>ème</sup>
                        <?php endif; ?>
                      </small>
                    </div>
                  </div>
                <?php else : ?>
                  <div class="choosecta flex-row-reverse">
                    <?php if ($type_top != "sponso") : ?>
                      <div class="cta-begin cta-complet">
                        <a href="#" id="begin_t" data-typetop="complet" data-top="<?php echo $id_top; ?>" data-id_vainkeur="<?php echo $id_vainkeur; ?>" data-uuiduser="<?php echo $uuid_vainkeur; ?>" class="w-100 animate__jello animate__animated animate__delay-1s btn btn-max btn-rose waves-effect waves-float waves-light laucher_t">
                          <i class="fab fa-twitch twitch-icon-tbegin d-none"></i>&nbsp;
                          Lancer le Top complet
                        </a>
                        <small class="text-muted">
                          <?php
                          $min = ($top_infos['top_number'] - 5) * 2 + 6;
                          $max = $min * 2;
                          ?>
                          <?php if ($top_infos['top_number'] < 3) : ?>
                            Un seul vote suffira pour finir ce Top
                          <?php else : ?>
                            Entre <?php echo $min; ?> et <?php echo $max; ?> votes pour ta TopList du 1<sup>er</sup> au <?php echo $top_infos['top_number']; ?><sup>ème</sup>
                          <?php endif; ?>
                        </small>
                      </div>
                    <?php endif; ?>
                    <div class="cta-begin cta-top3">
                      <a href="#" id="begin_top3" data-typetop="top3" data-top="<?php echo $id_top; ?>" data-id_vainkeur="<?php echo $id_vainkeur; ?>" data-uuiduser="<?php echo $uuid_vainkeur; ?>" class="w-100 animate__jello animate__animated animate__delay-1s btn btn-max btn-rose waves-effect waves-float waves-light laucher_t">
                        <i class="fab fa-twitch twitch-icon-tbegin d-none"></i>&nbsp;
                        <?php if ($type_top == "sponso") : ?>
                          Participer au Top sponso
                        <?php else : ?>
                          Faire juste le Top3
                        <?php endif; ?>
                      </a>
                      <small class="text-muted">
                        <?php
                        $max = (floor($top_infos['top_number'] / 2)) + (3 * ((round($top_infos['top_number'] / 2)) - 1));
                        $min = (floor($top_infos['top_number'] / 2)) + ((round($top_infos['top_number'] / 2)) - 1) + 3;
                        $moy = ($max + $min) / 2;
                        ?>
                        Prévoir environ <?php echo round($moy); ?> votes
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
                      <div class="infos-card-t d-flex align-items-center">
                        <div class="me-1">
                          <span class="ico va va-comment va-2x"></span>
                        </div>
                        <div class="info-numbers">
                          <h4>
                            <?php echo $top_datas['nb_comments']; ?>
                          </h4>
                          <?php if ($top_datas['nb_comments'] > 1) : ?>
                            <small class="text-muted">Commentaires</small>
                          <?php else : ?>
                            <small class="text-muted">Commentaire</small>
                          <?php endif; ?>
                        </div>
                      </div>
                    </div>
                    <div class="col">
                      <div class="vainkeur-card">
                        <a href="<?php the_permalink(218587); ?>?creator_id=<?php echo $creator_id; ?>" class="btn btn-flat-primary waves-effect">
                          <span class="avatar">
                            <span class="avatar-picture" style="background-image: url(<?php echo $creator_info['avatar']; ?>);"></span>
                          </span>
                          <span class="championname">
                            <small class="text-muted">
                              Conçu par
                            </small>
                            <div class="creatornametop">
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
              <button type="button" class="btn btn-label-blanc ba-tranparent waves-effect cancel-or-go" data-bs-dismiss="offcanvas">Annuler</button>
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
                <button type="button" id="votePrediction" class="mb-3 btn btn-gradient-primary modeGameTwitchBtn">
                  <div>
                    Élimination directe <span class="va va-skull va-lg"></span>
                  </div>
                  <div>
                    <small>A chaque nouveau duel, tes viewvers doivent deviner ton choix. Ceux qui se trompent sont éliminés et à la fin il n'en restera qu'un</small>
                  </div>
                </button>
                <button type="button" id="votePoints" class="btn btn-gradient-primary modeGameTwitchBtn">
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
    </div>
    <!-- // Top pas lancé -->
    
    <!-- Top lancé -->
    <div class="top_started">
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
                        <!-- current_user_ranking_var -->
                    </div>
                  </div>
                </div>
              </div>
            <?php endif; ?>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <div class="container">
              <div class="row">
                <div class="col">
                  <div class="display_battle">
                    <div class="row align-items-center justify-content-center contenders-containers battle-marqueblanche">
                      <div class="col-sm-5 col-12">
                          <div class="bloc-contenders link-contender_1 contender_1 cover_contenders link-contender">
                              <div class="contenders_min contender_zone animate__animated" data-idwinner="" data-idlooser="" id="c_1">
                                <div class="illu">
                                  <img id="cover_contender_1" src="" alt="" class="img-fluid contender-1-votes-twitch">
                                </div>
                                <h2 id="name_contender_2" class="title-contender"></h2>
                              </div>
                          </div>
                          <!-- get_field('lien_vers_contender', $contender_1)/ -->
                      </div>

                      <div class="col-sm-2">
                          <!-- if (isset($nb_user_votes) && $nb_user_votes != "") :/ -->
  
                          <h4 class="text-center versus">
                              <img src="<?php bloginfo('template_directory'); ?>/assets/images/vkrz/versus.png" alt="" class="img-fluid">
                          </h4>
                      </div>

                      <div class="col-sm-5 col-12">
                          <div class="bloc-contenders link-contender_2 contender_2 cover_contenders link-contender">
                              <div class="contenders_min contender_zone animate__animated" data-idwinner="" data-idlooser="" id="c_2">
                                <div class="illu">
                                  <img id="cover_contender_2" src="" alt="" class="img-fluid contender-2-votes-twitch">
                                </div>
                                <h2 id="name_contender_2" class="title-contender"></h2>
                              </div>
                          </div>
                          <!-- get_field('lien_vers_contender', $contender_2)/ -->
                      </div>
                    </div>
                  </div>
                  <!-- MATCH A MORT DIV/ -->
                </div>
                <!-- MATCH A POINT DIV/ -->
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- // Top lancé -->
</div>

<div class="top_started">
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
    <a class="btn-emoji btn-avatar" data-bs-toggle="tooltip" data-bs-placement="left" data-bs-original-title="Top créé par <?php echo $creator_data['pseudo']; ?>" style="background-image: url(<?php echo $creator_data['avatar']; ?>);">
      <div data-bs-toggle="offcanvas" data-bs-target="#infostop" aria-controls="offcanvasScroll" class="divfill">
      </div>
    </a>
  </div>
  <!-- /Right Nav -->

  <!-- Offcanvas -->
  <?php get_template_part('widgets/top-info'); ?>
  <!-- /Offcanvas -->
</div>

<?php get_template_part('partials/loader'); ?>
<?php get_template_part('partials/recommencer'); ?>

<!-- VARIABLES -->
<script>
  const id_top  = <?= $id_top; ?>;
  const id_user = <?= $user_id; ?>;
</script>
<!-- /VARIABLES -->

<?php get_footer(); ?>