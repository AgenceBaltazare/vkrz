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
global $cat_name;
global $user_tops;
global $list_user_tops;
global $list_user_tops_begin;
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
$user_ranking        = get_user_ranking($id_ranking);
$uuid_who_did_toplist = get_field('uuid_user_r', $id_ranking);
$url_ranking         = get_the_permalink($id_ranking);
$top_datas           = get_top_data($id_top_global);
$get_top_type        = get_the_terms($id_top_global, 'type');
$types_top           = array();
if ($get_top_type) {
  foreach ($get_top_type as $type_top) {
    array_push($types_top, $type_top->slug);
  }
}
$already_done       = get_top_done_by_current_vainkeur($id_top, $id_vainkeur, $list_user_tops);
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
?>
<div class="app-content content cover" style="background: url(<?php echo $top_infos['top_cover']; ?>) center center no-repeat">
  <div class="content-overlay"></div>
  <div class="content-wrapper">
    <div class="content-body">
      <?php if (!is_user_logged_in() && !in_array("sponso", $types_top)) : ?>
        <section class="please-rejoin app-user-view">
          <div role="alert" aria-live="polite" aria-atomic="true" class="alert alert-account" data-v-aa799a9e="">
            <div class="alert-body d-flex align-items-center justify-content-between">
              <span><span class="ico">💾</span> Pour sauvegarder et retrouver sur tous tes supports ta progression l'idéal serait de te créer un compte.</span>
              <div class="btns-alert text-right">
                <a class="btn btn-primary waves-effect btn-rose" href="<?php the_permalink(get_page_by_path('creer-mon-compte')); ?>">
                  Excellente idée - je créé mon compte <span class="ico">🎉</span>
                </a>
                <a class="btn btn-outline-white waves-effect t-white ml-1" href="<?php the_permalink(get_page_by_path('se-connecter')); ?>">
                  J'ai déjà un compte
                </a>
              </div>
            </div>
          </div>
        </section>
      <?php endif; ?>
      <div class="intro-mobile">
        <div class="tournament-heading text-center">
          <h3 class="mb-0 t-titre-tournoi">
            Top <?php echo $top_infos['top_number']; ?> <span class="va va-trophy va-md"></span> <?php echo $top_infos['top_title']; ?>
          </h3>
          <h4 class="mb-0">
            <?php echo $top_infos['top_question']; ?>
          </h4>
        </div>
      </div>
      <div class="classement" data-idranking="<?= $id_ranking ?>">
        <div class="row">
          <div class="col-md-8">
            <?php if (get_field('uuid_user_r', $id_ranking) == $uuid_vainkeur && in_array("sponso", $types_top)) : ?>
              <div class="participation-content-sponso mb-4">
                <?php if (!already_play($uuid_vainkeur, $id_top)) : ?>
                  <?php if (get_field('inscription_requise_t_sponso', $id_top_global) && !is_user_logged_in()) : ?>
                    <div class="popup-overlay">
                      <div class="popup participate-popup inscription-requise-popup scale-up-center">
                        <div class="popup-body">
                          <h3>
                            Hier c'était hier mais..
                          </h3>

                          <div class="info-win">
                            <p>
                              Aujourd'hui tu peux te tourner vers un avenir meilleur en rejoignant le concept VAINKEURZ 🚀 !
                            </p>
                            <p>
                              Si tu souhaites participer au <strong class="t-rose">Tirage au Sort</strong>, n'hésites pas et créer ton compte ! Si tu fais déjà parti des Vainkeurs, connecte-toi simplement 👇
                            </p>
                          </div>

                          <a href="<?php the_permalink(get_page_by_path('connexion')); ?>?redirect=<?php the_permalink($id_ranking); ?>/" class="w-100 btn btn-rose waves-effect p-1">
                            <p class="h4 text-white m-0">
                              S'INSCRIRE (ou se connecter)
                            </p>
                          </a>
                        </div>

                        <div class="popup-footer">
                          <hr class="m-0">

                          <button id="close-popup">
                            <span class="va va-backhand-index-pointing-right va-md"></span>
                            Ne pas partager et voir ma TopList
                            <span class="va va-backhand-index-pointing-right va-md"></span>
                          </button>
                        </div>
                      </div>
                    </div>
                  <?php else : ?>
                    <div class="popup-overlay participate-init">
                      <div class="popup participate-popup scale-up-center">
                        <div class="popup-body">
                          <span class="va va-party-popper va-3x mb-2"></span>

                          <?php if (isset($_GET['message'])) : ?>
                            <div class="label label-coco">
                              <p>Félicitation pour votre connexion, tu peux maintenant participer :)</p>
                            </div>
                          <?php endif; ?>
                          <div class="col-md-12 info-concours">
                            <div class="info-win">
                              <?php the_field('message_de_fin_t_sponso', $id_top_global); ?>
                            </div>
                          </div>
                          <?php if (get_field('type_de_fin_t_sponso', $id_top_global) == "mail_1") : ?>
                            <form action="" method="post" name="form2" id="form-coupon">
                              <?php if (is_user_logged_in()) : ?>
                                <input type="email" value="<?php echo $infos_vainkeur['user_email']; ?>" name="email-player-input" id="email-player-input" required>
                              <?php else : ?>
                                <input type="email" placeholder="Mon adresse mail" name="email-player-input" id="email-player-input" required>
                              <?php endif; ?>
                              <input type="hidden" value="<?php echo $id_ranking; ?>" name="ranking" id="ranking">
                              <input type="hidden" value="<?php echo $uuid_vainkeur; ?>" name="uuiduser" id="uuiduser">
                              <input type="hidden" value="<?php echo $id_top_global; ?>" name="top" id="top">
                              <input type="hidden" value="<?php echo $id_vainkeur; ?>" name="id_vainkeur" id="id_vainkeur">
                              <button class="btn" id="btn-coupon">
                                <?php the_field('intitule_cta_mail_t_sponso', $id_top_global); ?>
                              </button>
                            </form>
                          <?php elseif (get_field('type_de_fin_t_sponso', $id_top_global) == "twitter_1") : ?>
                            <?php if (!get_field('bouton_copier_toplist_tweet_twitter', $id_top_global)) : ?>
                              <a href="#" class="sharelinkbtn2 animate__jello animate__animated animate__delay-1s btn btn-max btn-outline-primary waves-effect waves-float waves-light copy-toplist-url-btn">
                                <input type="text" value="<?php echo get_the_permalink($id_ranking); ?>" class="input_to_share2">
                                <i class="social-media fas fa-paperclip"></i>
                                Copier le lien de ma TopList
                              </a><br>
                            <?php endif; ?>
                            <a href="<?php the_field('lien_du_tweet_t_sponso', $id_top_global); ?>" target="_blank" class="animate__jello animate__animated animate__delay-1s btn btn-max btn-tweet btn-rose waves-effect waves-float waves-light">
                              <?php if (get_field('intitule_du_bouton_tweet_twitter', $id_top_global)) : ?>
                                <?php the_field('intitule_du_bouton_tweet_twitter', $id_top_global); ?>
                              <?php else : ?>
                                <img src="https://vainkeurz.com/wp-content/uploads/2022/06/twitter.png" class="mr-50" width="20" height="16" alt="Tweet icon"> Post Twitter
                              <?php endif; ?>
                            </a>
                          <?php elseif (get_field('type_de_fin_t_sponso', $id_top_global) == "twitter_2") : ?>
                            <a href="https://twitter.com/intent/tweet?hashtags=<?php the_field('hashtags_du_tweet_twitter_2', $id_top_global); ?>&original_referer=<?php echo $url_ranking; ?>&ref_src=&text=<?php the_field('message_du_tweet_twitter_2', $id_top_global); ?>&url=<?php echo $url_ranking; ?>&via=<?php the_field('compte_twitter_twitter_2', $id_top_global); ?>" class="animate__jello animate__animated animate__delay-1s btn btn-max btn-tweet btn-rose waves-effect waves-float waves-light" target="_blank">
                              <img src="https://vainkeurz.com/wp-content/uploads/2022/06/twitter.png" width="20" height="16" alt="Tweet icon">
                              <?php the_field('message_du_bouton_tweet_twitter2', $id_top_global); ?>
                            </a>
                          <?php endif; ?>
                        </div>
                        <div class="popup-footer">
                          <hr class="m-0">
                          <button id="close-popup">
                            <span class="va va-backhand-index-pointing-right va-md"></span>
                            Ne pas partager et voir ma TopList
                            <span class="va va-backhand-index-pointing-right va-md"></span>
                          </button>
                        </div>
                      </div>
                    </div>
                    <div class="popup-overlay participation-confirme d-none">
                      <div class="popup participate-popup finish-participate-popup scale-up-center">
                        <button class="close-popup only-x" id="close-popup">&times;</button>

                        <div class="popup-body">
                          <div class="popup-body__left">
                            <h3>Participation confirmée ! <span class="va va-sign-of-the-horns va-lg"></span></h3>

                            <div class="bravo d-block">
                              <?php the_field('message_de_confirmation_t_sponso', $id_top_global); ?>
                            </div>
                          </div>

                          <div class="popup-body__right">
                            <div class="popup-body__right-top">
                              <p class="m-0"><span class="va va-trophy va-sm mr-50"></span> Partager ma TopList <span class="va va-trophy va-sm ml-50"></span></p>

                              <div class="rs">
                                <div class="d-flex align-items-center">
                                  <ul>
                                    <li>
                                      <a href="#" class="sharelinkbtn">
                                        <input type="text" value="<?php echo $url_ranking; ?>" class="input_to_share">
                                        <span>
                                          <i class="fa fa-link"></i>
                                        </span>
                                      </a>
                                    </li>
                                    <li>
                                      <a href="<?php echo $banner; ?>" download target="_blank">
                                        <span>
                                          <i class="fa fa-download"></i>
                                        </span>
                                      </a>
                                    </li>
                                    <li>
                                      <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo $url_ranking; ?>" title="Partager sur Facebook" target="_blank">
                                        <span>
                                          <i class="fab fa-facebook-f"></i>
                                        </span>
                                      </a>
                                    </li>
                                    <li>
                                      <?php if (get_field('tweet_personnalise_t', $id_top_global)) : ?>
                                        <a href="https://twitter.com/intent/tweet?text=<?php the_field('tweet_personnalise_t', $id_top_global); ?>&via=<?php the_field('a_personnalise_t', $id_top_global); ?>&hashtags=<?php the_field('#top_twitter', $id_top_global); ?>&url=<?php echo $url_ranking; ?>" target="_blank" title="Tweet">
                                          <span>
                                            <i class="fab fa-twitter"></i>
                                          </span>
                                        </a>
                                        </a>
                                      <?php else : ?>
                                        <?php if (get_field('@_twitter', $id_top_global)) : ?>
                                          <?php
                                          $arobaseFirstContender  = get_field('info_supplementaire_contender', $first_id_contender);
                                          $arobaseSecondContender = get_field('info_supplementaire_contender', $second_id_contender);
                                          $arobaseThirdContender  = get_field('info_supplementaire_contender', $third_id_contender);
                                          ?>
                                          <a href="https://twitter.com/intent/tweet?text=Voici ma TopList <?php echo $top_infos['top_title']; ?>%0a🥇<?= $arobaseFirstContender ?> 🥈<?= $arobaseSecondContender ?> 🥉<?= $arobaseThirdContender ?>%0a&via=vainkeurz&hashtags=VKRZ&hashtags=<?php echo get_field('#top_twitter', $id_top_global) ?>&url=<?php echo $url_ranking; ?>" target="_blank" title="Tweet">
                                            <span>
                                              <i class="fab fa-twitter"></i>
                                            </span>
                                          </a>
                                        <?php else :  ?>
                                          <a href="https://twitter.com/intent/tweet?text=Voici ma TopList <?php echo $top_infos['top_title']; ?>&via=vainkeurz&hashtags=VKRZ&url=<?php echo $url_ranking; ?>" target="_blank" title="Tweet">
                                            <span>
                                              <i class="fab fa-twitter"></i>
                                            </span>
                                          </a>
                                        <?php endif; ?>
                                      <?php endif; ?>
                                    </li>
                                    <li>
                                      <a href="whatsapp://send?text=<?php echo $url_ranking; ?>" data-action="share/whatsapp/share">
                                        <span>
                                          <i class="fab fa-whatsapp"></i>
                                        </span>
                                      </a>
                                    </li>
                                  </ul>
                                </div>
                              </div>
                            </div>

                            <strong>OU</strong>

                            <div class="popup-body__right-bottom">
                              <p class="m-0"><span class="va va-medal-1 va-md mr-50"></span> Partager le Top <span class="va va-medal-1 va-md ml-50"></span></p>

                              <div class="rs">
                                <div class="d-flex align-items-center">
                                  <ul>
                                    <li>
                                      <a href="#" class="sharelinkbtn2">
                                        <input type="text" value="<?php echo $top_infos['top_url']; ?>" class="input_to_share2">
                                        <span>
                                          <i class="fa fa-link"></i>
                                        </span>
                                      </a>
                                    </li>
                                    <li>
                                      <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo $top_infos['top_url']; ?>" title="Partager sur Facebook" target="_blank">
                                        <span>
                                          <i class="fab fa-facebook-f"></i>
                                        </span>
                                      </a>
                                    </li>
                                    <li>
                                      <a href="https://twitter.com/intent/tweet?text=Go faire le TOP <?php echo $top_infos['top_number']; ?> <?php echo $top_infos['top_title']; ?>&via=vainkeurz&hashtags=VKRZ&url=<?php echo $top_infos['top_url']; ?>" target="_blank" title="Tweet">
                                        <span>
                                          <i class="fab fa-twitter"></i>
                                        </span>
                                      </a>
                                    </li>
                                    <li>
                                      <a href="whatsapp://send?text=<?php echo $top_infos['top_url']; ?>" data-action="share/whatsapp/share">
                                        <span>
                                          <i class="fab fa-whatsapp"></i>
                                        </span>
                                      </a>
                                    </li>
                                  </ul>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  <?php endif; ?>
                <?php else : ?>
                  <div class="popup-overlay">
                    <div class="popup participate-popup finish-participate-popup scale-up-center">
                      <button class="close-popup only-x" id="close-popup">&times;</button>

                      <div class="popup-body">
                        <div class="popup-body__left">
                          <h3>Participation confirmée ! <span class="va va-sign-of-the-horns va-lg"></span></h3>

                          <div class="bravo d-block">
                            <?php the_field('message_de_confirmation_t_sponso', $id_top_global); ?>
                          </div>
                        </div>

                        <div class="popup-body__right">
                          <div class="popup-body__right-top">
                            <p class="m-0"><span class="va va-trophy va-sm mr-50"></span> Partager ma TopList <span class="va va-trophy va-sm ml-50"></span></p>

                            <div class="rs">
                              <div class="d-flex align-items-center">
                                <ul>
                                  <li>
                                    <a href="#" class="sharelinkbtn">
                                      <input type="text" value="<?php echo $url_ranking; ?>" class="input_to_share">
                                      <span>
                                        <i class="fa fa-link"></i>
                                      </span>
                                    </a>
                                  </li>
                                  <li>
                                    <a href="<?php echo $banner; ?>" download target="_blank">
                                      <span>
                                        <i class="fa fa-download"></i>
                                      </span>
                                    </a>
                                  </li>
                                  <li>
                                    <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo $url_ranking; ?>" title="Partager sur Facebook" target="_blank">
                                      <span>
                                        <i class="fab fa-facebook-f"></i>
                                      </span>
                                    </a>
                                  </li>
                                  <li>
                                    <?php if (get_field('tweet_personnalise_t', $id_top_global)) : ?>
                                      <a href="https://twitter.com/intent/tweet?text=<?php the_field('tweet_personnalise_t', $id_top_global); ?>&via=<?php the_field('a_personnalise_t', $id_top_global); ?>&hashtags=<?php the_field('#top_twitter', $id_top_global); ?>&url=<?php echo $url_ranking; ?>" target="_blank" title="Tweet">
                                        <span>
                                          <i class="fab fa-twitter"></i>
                                        </span>
                                      </a>
                                      </a>
                                    <?php else : ?>
                                      <?php if (get_field('@_twitter', $id_top_global)) : ?>
                                        <?php
                                        $arobaseFirstContender  = get_field('info_supplementaire_contender', $first_id_contender);
                                        $arobaseSecondContender = get_field('info_supplementaire_contender', $second_id_contender);
                                        $arobaseThirdContender  = get_field('info_supplementaire_contender', $third_id_contender);
                                        ?>
                                        <a href="https://twitter.com/intent/tweet?text=Voici ma TopList <?php echo $top_infos['top_title']; ?>%0a🥇<?= $arobaseFirstContender ?> 🥈<?= $arobaseSecondContender ?> 🥉<?= $arobaseThirdContender ?>%0a&via=vainkeurz&hashtags=VKRZ&hashtags=<?php echo get_field('#top_twitter', $id_top_global) ?>&url=<?php echo $url_ranking; ?>" target="_blank" title="Tweet">
                                          <span>
                                            <i class="fab fa-twitter"></i>
                                          </span>
                                        </a>
                                      <?php else :  ?>
                                        <a href="https://twitter.com/intent/tweet?text=Voici ma TopList <?php echo $top_infos['top_title']; ?>&via=vainkeurz&hashtags=VKRZ&url=<?php echo $url_ranking; ?>" target="_blank" title="Tweet">
                                          <span>
                                            <i class="fab fa-twitter"></i>
                                          </span>
                                        </a>
                                      <?php endif; ?>
                                    <?php endif; ?>
                                  </li>
                                  <li>
                                    <a href="whatsapp://send?text=<?php echo $url_ranking; ?>" data-action="share/whatsapp/share">
                                      <span>
                                        <i class="fab fa-whatsapp"></i>
                                      </span>
                                    </a>
                                  </li>
                                </ul>
                              </div>
                            </div>
                          </div>

                          <strong>OU</strong>

                          <div class="popup-body__right-bottom">
                            <p class="m-0"><span class="va va-medal-1 va-md mr-50"></span> Partager le Top <span class="va va-medal-1 va-md ml-50"></span></p>

                            <div class="rs">
                              <div class="d-flex align-items-center">
                                <ul>
                                  <li>
                                    <a href="#" class="sharelinkbtn2">
                                      <input type="text" value="<?php echo $top_infos['top_url']; ?>" class="input_to_share2">
                                      <span>
                                        <i class="fa fa-link"></i>
                                      </span>
                                    </a>
                                  </li>
                                  <li>
                                    <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo $top_infos['top_url']; ?>" title="Partager sur Facebook" target="_blank">
                                      <span>
                                        <i class="fab fa-facebook-f"></i>
                                      </span>
                                    </a>
                                  </li>
                                  <li>
                                    <a href="https://twitter.com/intent/tweet?text=Go faire le TOP <?php echo $top_infos['top_number']; ?> <?php echo $top_infos['top_title']; ?>&via=vainkeurz&hashtags=VKRZ&url=<?php echo $top_infos['top_url']; ?>" target="_blank" title="Tweet">
                                      <span>
                                        <i class="fab fa-twitter"></i>
                                      </span>
                                    </a>
                                  </li>
                                  <li>
                                    <a href="whatsapp://send?text=<?php echo $top_infos['top_url']; ?>" data-action="share/whatsapp/share">
                                      <span>
                                        <i class="fab fa-whatsapp"></i>
                                      </span>
                                    </a>
                                  </li>
                                </ul>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                <?php endif; ?>
              </div>
            <?php endif; ?>

            <?php if (get_field('uuid_user_r', $id_ranking) != $uuid_vainkeur && $id_top_global == 465667) : ?>
              <div class="participation-content-sponso mb-4">
                <div class="doitbro mt-1">
                  <h1>Toi aussi participe au concours eneba</h1>
                  <p>Pour tenter de gagner 1 bon d'achat d'une valeur de 50€, termine ta TopList et partage-la sur Twitter</p>
                  <a href="<?php echo $top_infos['top_url']; ?>" class="animate__jello animate__animated animate__delay-1s btn btn-max btn-tweet btn-rose waves-effect waves-float waves-light">Je Participe</a>
                </div>
              </div>
            <?php endif; ?>

            <div class="list-classement mt-2">
              <div class="row align-items-end justify-content-center">
                <?php
                $i = 1;
                foreach ($user_ranking as $c) : ?>
                  <?php if ($i == 1) : ?>
                    <div class="col-12 col-md-5">
                    <?php elseif ($i == 2) : ?>
                      <div class="col-7 col-md-4">
                      <?php elseif ($i == 3) : ?>
                        <div class="col-5 col-md-3">
                        <?php else : ?>
                          <div class="col-md-2 col-4">
                          <?php endif; ?>
                          <?php
                          if ($i >= 4) {
                            $d = 3;
                          } else {
                            $d = $i - 1;
                          }
                          ?>
                          <div class="animate__jackInTheBox animate__animated animate__delay-<?php echo $d; ?>s contenders_min <?php echo ($top_infos['top_d_rounded']) ? 'rounded' : ''; ?> mb-3">
                            <div class="illu">
                              <?php if ($top_infos['top_d_cover']) : ?>
                                <?php $illu = get_the_post_thumbnail_url($c, 'large'); ?>
                                <div class="cov-illu" style="background: url(<?php echo $illu; ?>) center center no-repeat"></div>
                              <?php else : ?>
                                <?php if (get_field('visuel_instagram_contender', $c)) : ?>
                                  <img src="<?php the_field('visuel_instagram_contender', $c); ?>" alt="" class="img-fluid">
                                <?php else : ?>
                                  <?php echo get_the_post_thumbnail($c, 'large', array('class' => 'img-fluid')); ?>
                                <?php endif; ?>
                              <?php endif; ?>
                            </div>
                            <div class="name eh2">
                              <h5 class="mt-2 eh3">
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
                                  <?php echo get_the_title($c); ?>
                                <?php endif; ?>
                              </h5>
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
                      </div>
                    </div>

                    <div class="col-md-4">

                      <div class="animate__fadeInUp animate__animated animate__delay-2s">

                        <div class="separate mt-1 mb-2 d-block d-sm-none"></div>

                        <?php
                        global $vainkeur_data_selected;
                        $vainkeur_data_selected = get_user_infos($uuid_who_did_toplist);
                        if ($uuid_who_did_toplist != $uuid_vainkeur) :
                        ?>
                          <div class="card text-left">
                            <div class="card-body">
                              <h4 class="card-title">
                                <span class="ico va va-trophy va-lg"></span> Une TopList signée par :
                              </h4>
                              <div class="employee-task d-flex justify-content-between align-items-center">

                                <?php get_template_part('partials/vainkeur-card'); ?>

                                <?php if ($vainkeur_data_selected['user_role'] != "anonyme") : ?>

                                  <?php if (is_user_logged_in()) : ?>

                                    <?php if ($vainkeur_data_selected && get_current_user_id() != $vainkeur_data_selected['id_user'] && is_user_logged_in()) : ?>

                                      <button type="button" id="followBtn" class="btn waves-effect btn-follow d-none" data-userid="<?= get_current_user_id(); ?>" data-uuid="<?= get_field('uuiduser_user', 'user_' . get_current_user_id()); ?>" data-relatedid="<?= $vainkeur_data_selected['id_user']; ?>" data-relateduuid="<?= get_field('uuiduser_user', 'user_' . $vainkeur_data_selected['id_user']); ?>" data-text="<?= get_the_author_meta('nickname', get_current_user_id()); ?> te guette !" data-url="<?= get_author_posts_url(get_current_user_id()); ?>">
                                        <span class="wording">Guetter</span>
                                        <span class="va va-guetteur-close va va-z-20 emoji"></span>
                                      </button>

                                    <?php endif; ?>

                                  <?php else : ?>

                                    <a href="<?php the_permalink(get_page_by_path('se-connecter')); ?>" class="btn btn-flat-secondary waves-effect" data-toggle="tooltip" data-placement="top" title="" data-original-title="Tu dois être connecté pour guetter <?php echo $vainkeur_data_selected['pseudo']; ?>">
                                      <span class="text-muted">
                                        <span class="wording">Guetter</span> <span class="va va-guetteur-close va va-z-20 emoji"></span>
                                      </span>
                                    </a>

                                  <?php endif; ?>

                                <?php endif; ?>
                              </div>

                              <div class="separate mt-2"></div>

                              <div class="vs-resemblance" data-idranking="<?= $id_ranking; ?>" data-idtop="<?= $id_top; ?>" data-topurl="<?= $top_infos['top_url']; ?>">
                                <div class="loader loader--style1 w-100 mx-auto mt-1 text-center" title="0">
                                  <svg version="1.1" id="loader-1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="40px" height="40px" viewBox="0 0 40 40" enable-background="new 0 0 40 40" xml:space="preserve">
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
                          </div>

                          <div class="separate mt-2 mb-2"></div>
                        <?php endif; ?>

                        <?php if (in_array("sponso", $types_top)) : ?>
                          <div class="card">
                            <div class="share-content-sponso">
                              <div class="text-left">
                                <p>
                                  <?php the_field('top_propose_par_t_sponso', $id_top_global); ?>
                                </p>
                              </div>
                              <div class="d-flex align-items-center flex-column">
                                <div class="logo-vkrz-sponso">
                                  <?php
                                  if (get_field('illustration_de_la_sponso_t_sponso', $id_top_global)) : ?>
                                    <a href="<?php the_field('lien_de_la_sponso_t_sponso', $id_top_global); ?>" target="_blank">
                                      <?php echo wp_get_attachment_image(get_field('illustration_de_la_sponso_t_sponso', $id_top_global), 'large', '', array('class' => 'img-fluid')); ?>
                                    </a>
                                  <?php elseif (get_field('logo_de_la_sponso_t_sponso', $id_top_global)) : ?>
                                    <a href="<?php the_field('lien_de_la_sponso_t_sponso', $id_top_global); ?>" target="_blank">
                                      <?php echo wp_get_attachment_image(get_field('logo_de_la_sponso_t_sponso', $id_top_global), 'large', '', array('class' => 'img-fluid')); ?>
                                    </a>
                                  <?php endif; ?>
                                </div>
                                <div class="mt-2 social-media-sponso btn-group">
                                  <?php if (have_rows('liste_des_liens_t_sponso', $id_top_global)) : ?>
                                    <?php while (have_rows('liste_des_liens_t_sponso', $id_top_global)) : the_row(); ?>
                                      <a href="<?php the_sub_field('lien_vers_t_sponso'); ?>" class="w-100 animate__jello animate__animated animate__delay-1s btn btn-icon btn-outline-primary waves-effect waves-float waves-light" target="_blank">
                                        <?php the_sub_field('intitule_t_sponso'); ?>
                                      </a>
                                    <?php endwhile; ?>
                                  <?php endif; ?>
                                </div>
                              </div>
                            </div>

                            <div class="card-footer text-center p-20 m-0">
                              <span class="t-rose">
                                On te rappelle que la date de fin est <br>
                                <b><?php echo lcfirst(get_field('fin_de_la_sponso_t_sponso', $id_top)); ?></b>
                              </span>
                            </div>
                          </div>
                        <?php endif; ?>

                        <?php if (!isMobile() && is_user_logged_in() && get_userdata($user_id)->twitch_user) : ?>
                          <div id="twitch-games-ranking" class="card d-none" data-idRanking="<?= $id_ranking; ?>"></div>
                        <?php endif; ?>

                        <div class="card">
                          <div class="card-body">
                            <h2 class="stats-mondiales mb-0">
                              <b>Stats mondiales :</b>
                              <?php echo $top_datas['nb_tops']; ?> <span class="va va-trophy va-md"></span> <span class="space"></span> <?php echo $top_datas['nb_votes']; ?> <span class="va va-high-voltage va-md"></span>
                            </h2>
                            <div class="mt-1">
                              <a href="<?php the_permalink(get_page_by_path('liste-des-tops')); ?>?id_top=<?php echo $id_top_global; ?>" class="btn btn-outline-primary waves-effect mb-1">
                                <span class="va va-duo va-lg"></span> Voir les <?php echo $top_datas['nb_tops']; ?> TopList et ressemblance 
                              </a>
                              <h2 class="stats-mondiales mt-50">
                                <b>Ressemblance mondiale : </b>
                                <span id="ressemblance-mondiale">
                                  <span class="">
                                    <div class="loader loader--style1" title="0">
                                      <svg version="1.1" id="loader-1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="30px" height="30px" viewBox="0 0 40 40" enable-background="new 0 0 40 40" xml:space="preserve">
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
                                </span>
                              </h2>
                              <a href="<?php the_permalink(get_page_by_path('elo')); ?>?id_top=<?php echo $id_top_global; ?>" class="btn btn-outline-primary waves-effect mt-50">
                                <span class="va va-globe va-lg"></span> TopList mondiale
                              </a>
                            </div>
                          </div>
                        </div>

                        <?php if ($vainkeur_data_selected['id_user']) : ?>
                          <div id="jugement" class="card toplist_comments" data-id_vainkeur_actual="<?= $id_vainkeur; ?>" data-authorid="<?= $vainkeur_data_selected["id_user"] ?>" data-authorpseudo="<?= $vainkeur_data_selected["pseudo"] ?>" data-authoruuid="<?= $vainkeur_data_selected["uuid_vainkeur"] ?>" data-idranking="<?= $id_ranking; ?>" data-urlranking="<?= get_permalink($id_ranking); ?>">
                            <div class="card-body">
                              <h4 class="card-title">
                                <span class="va va-hache va-lg"></span> Laisser un jugement
                              </h4>
                              <li class="comments-container scrollable-container media-list">

                              </li>
                              <div class="card-footer border-0">
                                <div class="d-flex align-items-center commentarea-container">
                                  <textarea name="comment" id="comment" placeholder="Juger…"></textarea>

                                  <button id="send_comment_btn">
                                    <span class="va va-icon-arrow-up va-z-40"></span>
                                  </button>
                                </div>
                              </div>
                            </div>
                          </div>
                        <?php endif; ?>

                        <?php if (get_field('liste_des_createurs_top', $id_top)) : ?>

                          <div class="separate mt-2 mb-2"></div>

                          <div class="card text-left">
                            <div class="card-body">
                              <h4 class="card-title">
                                <span class="ico va va-star-struck va-lg"></span> Ce TOP a été fait par :
                              </h4>
                              <?php if (have_rows('liste_des_createurs_top', $id_top)) : ?>
                                <?php while (have_rows('liste_des_createurs_top', $id_top)) : the_row(); ?>
                                  <div class="employee-task d-flex justify-content-between align-items-center mb-1 mt-1">
                                    <a href="<?php the_sub_field('lien_vers_la_video_top'); ?>" class="d-flex flex-row link-to-creator" target="_blank">
                                      <div class="avatar me-75 mr-1">
                                        <?php
                                        if (get_sub_field('avatar_createur_top')) {
                                          $avatar_creator = wp_get_attachment_image_src(get_sub_field('avatar_createur_top'), 'medium');
                                        }
                                        ?>
                                        <div class="avatar-creator" style="background-image: url(<?php echo $avatar_creator[0]; ?>);"></div>
                                      </div>
                                      <div class="my-auto">
                                        <h3 class="mb-0">
                                          <?php the_sub_field('nom_du_createur'); ?>
                                        </h3>
                                        <span class="seevideocreator">Voir sa vidéo sur <?php the_sub_field('plateforme_top'); ?></span>
                                      </div>
                                    </a>
                                  </div>
                                <?php endwhile; ?>
                              <?php endif; ?>
                            </div>
                          </div>
                        <?php endif; ?>

                        <?php
                        $top_cat = $top_infos['top_cat'];
                        foreach ($top_cat as $cat) {
                          $top_cat_id = $cat->term_id;
                        }
                        $list_souscat  = array();
                        $top_souscat   = get_the_terms($id_top_global, 'concept');
                        if (!empty($top_souscat)) {
                          foreach ($top_souscat as $souscat) {
                            array_push($list_souscat, $souscat->slug);
                          }
                        }

                        $tops_in_close_cat     = new WP_Query(array(
                          'ignore_sticky_posts'    => true,
                          'update_post_meta_cache' => false,
                          'no_found_rows'          => true,
                          'post_type'              => 'tournoi',
                          'post__not_in'           => $list_user_tops,
                          'orderby'                => 'rand',
                          'order'                  => 'ASC',
                          'posts_per_page'         => 4,
                          'tax_query' => array(
                            'relation' => 'AND',
                            array(
                              'taxonomy' => 'categorie',
                              'field'    => 'term_id',
                              'terms'    => array($top_cat_id)
                            ),
                            array(
                              'taxonomy' => 'concept',
                              'field' => 'slug',
                              'terms' => $list_souscat
                            ),
                            array(
                              'taxonomy' => 'type',
                              'field'    => 'slug',
                              'terms'    => array('private', 'whitelabel'),
                              'operator' => 'NOT IN'
                            ),
                          ),
                        ));
                        $count_similar = $tops_in_close_cat->post_count;
                        $count_next    = 4 - $count_similar;

                        if ($count_similar < 4) {

                          $tops_in_large_cat     = new WP_Query(array(
                            'ignore_sticky_posts'    => true,
                            'update_post_meta_cache' => false,
                            'no_found_rows'          => true,
                            'post_type'              => 'tournoi',
                            'post__not_in'           => $list_user_tops,
                            'orderby'                => 'rand',
                            'order'                  => 'ASC',
                            'posts_per_page'         => $count_next,
                            'tax_query' => array(
                              'relation' => 'AND',
                              array(
                                'taxonomy' => 'categorie',
                                'field'    => 'term_id',
                                'terms'    => array($top_cat_id)
                              ),
                              array(
                                'taxonomy' => 'type',
                                'field'    => 'slug',
                                'terms'    => array('private', 'whitelabel', 'onboarding'),
                                'operator' => 'NOT IN'
                              ),
                            ),
                          ));
                        }
                        if ($tops_in_close_cat->have_posts() || $tops_in_large_cat->have_posts()) : ?>

                          <div class="separate mt-2 mb-2"></div>

                          <section class="list-tournois">
                            <div class="mt-1 pslim">
                              <h4 class="card-title">
                                <span class="ico">🥰</span> Tops similaires
                              </h4>
                              <h6 class="card-subtitle text-muted mb-1">
                                Voici quelques Tops qui devraient te plaire <span class="ico">👇</span>
                              </h6>
                            </div>
                            <div class="similar-list mt-2">
                              <div class="row">
                                <?php
                                while ($tops_in_close_cat->have_posts()) : $tops_in_close_cat->the_post(); ?>

                                  <?php get_template_part('partials/min-t'); ?>

                                <?php endwhile; ?>
                                <?php if ($count_similar < 4) : ?>
                                  <?php
                                  while ($tops_in_large_cat->have_posts()) : $tops_in_large_cat->the_post(); ?>

                                    <?php get_template_part('partials/min-t'); ?>

                                  <?php endwhile; ?>
                                <?php endif; ?>
                              </div>
                            </div>
                            <div class="gocat">
                              <?php
                              $current = get_term_by('term_id', $top_cat_id, 'categorie');
                              ?>
                              <a class="w-100 btn btn-primary waves-effect" href="<?php echo get_category_link($top_cat_id); ?>">
                                Voir tous les Tops <span class="text-uppercase"><?php echo $cat_name; ?></span> <span class="ico"><?php the_field('icone_cat', 'term_' . $top_cat_id); ?></span>
                              </a>
                            </div>
                            <div class="separate mt-2 mb-2"></div>
                          </section>
                        <?php endif; ?>
                      </div>
                    </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <section class="nav-single">
    <nav class="navbar fixed-bottom mobile-navbar">
      <div class="row">
        <div class="col-md-8">
          <?php 
            if(is_user_logged_in())  $space_for_crisp = isMobile() && get_userdata(get_user_logged_id())->roles[0] != 'administrator';
            elseif(!is_user_logged_in() && isMobile()) $space_for_crisp = true;
          ?>
          <div class="toplist-footer" style="<?php echo $space_for_crisp ? "width: 82%;gap:7px;" : "" ?>">
            <?php if (!in_array('private', $types_top)) : ?>
              <?php if ($already_done) : ?>
                <?php if(get_field('uuid_user_r', $id_ranking) != $uuid_vainkeur) :  ?>
                  <a href="<?php echo $top_infos['top_url']; ?>" class="toplist-f-item bubbly-button" style="<?php echo $space_for_crisp ? "padding: 0.3rem !important;" : "" ?>">
                    Voir ma TopList
                  </a>
                <?php else : ?>
                  <button class="toplist-f-item bubbly-button share-content-show share-natif-classement" style="<?php echo $space_for_crisp ? "padding: 0.3rem !important;" : "" ?>">
                    Partage ta TopList                  
                  </button>
                <?php endif; ?>
              <?php else : ?>
                <a href="<?php echo $top_infos['top_url']; ?>" class="toplist-f-item bubbly-button" style="<?php echo $space_for_crisp ? "padding: 0.3rem !important;" : "" ?>">
                  Faire ma TopList
                </a>
              <?php endif; ?>

              <div class="toplist-f-item btn-show-hover box-info-show">
                <span class="tooltiptext hide-xs">Infos du Top</span> <i class="fas fa-info-circle"></i>
              </div>
            <?php endif; ?>

            <a href="<?php echo get_the_permalink(get_page_by_path('discuz')) . '?id_top=' . $id_top_global; ?>" class="toplist-f-item btn-show-hover ">
              <span class="tooltiptext hide-xs">Commenter</span> <i class="fas fa-pencil-alt"></i>
            </a>

            <?php if ($already_done && get_field('uuid_user_r', $id_ranking) == $uuid_vainkeur) : ?>
              <a data-phrase1="Es-tu sûr de vouloir recommencer ?" data-phrase2="Tous les votes de ce Top seront remis à 0" data-id_ranking="<?php echo $id_ranking; ?>" data-id_vainkeur="<?php echo $id_vainkeur; ?>" href="#" class="confirm_delete toplist-f-item btn-show-hover">
               <span class="tooltiptext hide-xs">Recommencer</span> <i class="far fa-sync-alt"></i>
              </a>
            <?php endif; ?>
          </div>                       
        </div>
      </div>
    </nav>
    <div class="share-classement-content">
      <h3>
        <span class="va va-backhand-index-pointing-right va-lg"></span>
        Partager ma TopList
        <span class="va va-backhand-index-pointing-right va-lg"></span>
      </h3>
      <p>(Pas besoin de screen ! Une image de ton Top 3 sera ajoutée automatiquement à ton post avec le lien)</p>

      <div class="close-share">
        <i class="fal fa-times"></i>
      </div>

      <div class="share-classement-content-box">
        <div class="left">
          <img src="<?php echo $banner ?>" alt="Top 3">
          <!-- <img src="<?php echo $banner ?>" height="300" width="300" alt="Top 3"> -->
        </div>
        <div class="right">
          <a href="<?php echo $banner; ?>" download target="_blank">
            <i class="social-media fas fa-download"></i> Télécharger l'image de ma TopList 
          </a>

          <a href="#" class="sharelinkbtn" data-toggle="tooltip" data-placement="top" title="" data-original-title="Copier le lien de ta TopList">
            <input type="text" value="<?php echo $url_ranking; ?>" class="input_to_share">
            <i class="social-media fas fa-paperclip"></i> Copier le lien de la TopList
          </a>

          <?php if (get_field('tweet_personnalise_t', $id_top_global)) : ?>
            <a href="https://twitter.com/intent/tweet?text=<?php the_field('tweet_personnalise_t', $id_top_global); ?>&via=<?php the_field('a_personnalise_t', $id_top_global); ?>&hashtags=<?php the_field('#top_twitter', $id_top_global); ?>&url=<?php echo $url_ranking; ?>" target="_blank" title="Tweet">
              <i class="social-media fab fa-twitter"></i> Twitter
            </a>
          <?php else : ?>
            <?php if (get_field('@_twitter', $id_top_global)) : ?>
              <?php
              $arobaseFirstContender = get_field('info_supplementaire_contender', $first_id_contender);
              $arobaseSecondContender = get_field('info_supplementaire_contender', $second_id_contender);
              $arobaseThirdContender = get_field('info_supplementaire_contender', $third_id_contender);
              ?>
              <a href="https://twitter.com/intent/tweet?text=Voici ma TopList <?php echo $top_infos['top_title']; ?>%0a🥇<?= $arobaseFirstContender ?> 🥈<?= $arobaseSecondContender ?> 🥉<?= $arobaseThirdContender ?>%0a&via=vainkeurz&hashtags=VKRZ&hashtags=<?php echo get_field('#top_twitter', $id_top_global) ?>&url=<?php echo $url_ranking; ?>" target="_blank" title="Tweet">
                <i class="social-media fab fa-twitter"></i> Twitter
              </a>
            <?php else :  ?>
              <a href="https://twitter.com/intent/tweet?text=Voici ma TopList <?php echo $top_infos['top_title']; ?>&via=vainkeurz&hashtags=VKRZ&url=<?php echo $url_ranking; ?>" target="_blank" title="Tweet">
                <i class="social-media fab fa-twitter"></i> Twitter
              </a>
            <?php endif; ?>
          <?php endif; ?>

          <a href="whatsapp://send?text=<?php echo $url_ranking; ?>" data-action="share/whatsapp/share">
            <i class="social-media fab fa-whatsapp"></i> WhatsApp
          </a>

          <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo $url_ranking; ?>" title="Partager sur Facebook" target="_blank">
            <i class="social-media fab fa-facebook-f"></i> Facebook
          </a>
        </div>
      </div>
    </div>
    <div class="share-top-content">
      <h3>
        Partager le lien du Top
      </h3>
      <div class="close-share">
        <i class="fal fa-times"></i>
      </div>
      <ul>
        <li>
          <a href="#" class="sharelinkbtn2" data-toggle="tooltip" data-placement="top" title="" data-original-title="Copier le lien de ton Top">
            <input type="text" value="<?php echo $top_infos['top_url']; ?>" class="input_to_share2">
            <i class="social-media fas fa-paperclip"></i> Copier le lien du Top
          </a>
        </li>
        <li>
          <a href="https://twitter.com/intent/tweet?text=Go faire le TOP <?php echo $top_infos['top_number']; ?> <?php echo $top_infos['top_title']; ?>&via=vainkeurz&hashtags=VKRZ&url=<?php echo $top_infos['top_url']; ?>" target="_blank" title="Tweet">
            <i class="social-media fab fa-twitter"></i> Dans un Tweet
          </a>
        </li>
        <li>
          <a href="whatsapp://send?text=<?php echo $top_infos['top_url']; ?>" data-action="share/whatsapp/share">
            <i class="social-media mb-12 fab fa-whatsapp"></i> Sur WhatsApp
          </a>
        </li>
        <li>
          <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo $top_infos['top_url']; ?>" title="Partager sur Facebook" target="_blank">
            <i class="social-media fab fa-facebook-f"></i> Sur Facebook
          </a>
        </li>
      </ul>
    </div>
    <div class="box-info-content">
      <h3>
        <span class="ico va va-placard va-lg"></span> Tous les infos du Top
      </h3>
      <div class="close-share">
        <i class="fal fa-times"></i>
      </div>
      <div class="box-info-list">
        <div class="card text-left">
          <div class="card-body">
            <div class="row">
              <div class="col-md-5 mb-2 mb-md-0">
                <div class="top-resume-tool">
                  <h4 class="mb-1">
                    Top <?php echo $top_infos['top_number']; ?> <span class="ico">⚔️</span> <?php echo $top_infos['top_title']; ?>
                  </h4>
                  <h5 class="t-rose">
                    <?php echo $top_infos['top_question']; ?> <br>
                  </h5>
                  <?php if (get_field('precision_t', $id_top_global)) : ?>
                    <div class="card-precision">
                      <p class="card-text mb-1">
                        <?php the_field('precision_t', $id_top_global); ?>
                      </p>
                    </div>
                  <?php endif; ?>
                </div>
              </div>

              <div class="col-md-4">
                <h4 class="card-title">
                  <?php
                  date_default_timezone_set('Europe/Paris');
                  $origin     = new DateTime(get_the_date('Y-m-d', $id_top_global));
                  $target     = new DateTime(date('Y-m-d'));
                  $interval   = $origin->diff($target);
                  if ($interval->days == 0) {
                    $info_date = "aujourd'hui";
                  } elseif ($interval->days == 1) {
                    $info_date = "hier";
                  } else {
                    $info_date = "depuis " . $interval->days . " jours";
                  }
                  $creator_id         = get_post_field('post_author', $id_top_global);
                  $creator_uuiduser   = get_field('uuiduser_user', 'user_' . $creator_id);
                  $creator_data       = get_user_infos($creator_uuiduser);
                  ?>
                  <span class="va va-birthday-cake va-md"></span> Créé <span class="t-violet"><?php echo $info_date; ?></span> par :
                </h4>
                <div class="employee-task d-flex justify-content-between align-items-center">
                  <a href="<?php echo esc_url(get_author_posts_url($creator_data['id_user'])); ?>" class="d-flex flex-row link-to-creator">
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

              <div class="col-md-3 mt-1">
                <a href="#" class="share-natif-top btn btn-primary text-uppercase">
                  Partage le Top <span class="va va-trophy va-md"></span>
                </a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>

<?php get_footer(); ?>