<?php
global $uuid_vainkeur;
global $id_top_global;
global $infos_vainkeur;
global $id_ranking;
global $id_vainkeur;
global $url_ranking;
global $banner;
?>
<div class="participation-content-sponso mb-4">
  <?php if (already_play($uuid_vainkeur, $id_top_global)) : ?>
    <?php if (get_field('inscription_requise_t_sponso', $id_top_global) && !is_user_logged_in()) : ?>
      <div class="popup-overlay">
        <div class="popup participate-popup inscription-requise-popup scale-up-center">
          <div class="popup-header">
            <h3>
              Participer au tirage au sort <span class="va va-chance va-lg ms-2"></span>
            </h3>
          </div>
          <div class="popup-body">
            <p>
              Aujourd'hui est un grand jour.
              <br>
              C'est le jour où tu deviens officiellement un Vainkeur... ou pas <span class="va va-upside-down-face va-md"></span>
              <br><br>
              Toujours est-il que la participation à ce Top est réservée aux membres donc il faut te co !
            </p>
            <a href="<?php the_permalink(get_page_by_path('connexion')); ?>?redirect=<?php the_permalink($id_ranking); ?>/" class="btn-wording-rose btn-wording bubbly-button">
              S'inscrire ou se connecter
            </a>
          </div>
          <div class="popup-footer">
            <button id="close-popup" class="close-popup">
              <span class="text-muted">
                Ne pas participer et juste voir ma TopList
              </span>
            </button>
          </div>
        </div>
      </div>
    <?php else : ?>
      <div class="popup-overlay participate-init">
        <div class="popup participate-popup scale-up-center">
          <div class="popup-header">
            <h3>
              Participer au tirage au sort <span class="va va-chance va-lg ms-2"></span>
            </h3>
          </div>
          <div class="popup-body">
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
                  <input type="email" placeholder="Ton email" name="email-player-input" id="email-player-input" required>
                <?php endif; ?>
                <input type="hidden" value="<?php echo $id_ranking; ?>" name="ranking" id="ranking">
                <input type="hidden" value="<?php echo $uuid_vainkeur; ?>" name="uuiduser" id="uuiduser">
                <input type="hidden" value="<?php echo $id_top_global; ?>" name="top" id="top">
                <input type="hidden" value="<?php echo $id_vainkeur; ?>" name="id_vainkeur" id="id_vainkeur">
                <button class="btn" id="btn-coupon">
                  Valider
                </button>
              </form>
            <?php elseif (get_field('type_de_fin_t_sponso', $id_top_global) == "twitter_2") : ?>
              <div class="banner-preview">
                <img src="<?php echo $banner ?>" alt="Top 3" class="img-fluid">
                <p class="legendbanner">Voici le visuel qui sera partagé automatikement <span class="va va-hand-droit va-md"></span></p>
              </div>
              <a href="https://twitter.com/intent/tweet?hashtags=<?php the_field('hashtags_du_tweet_twitter_2', $id_top_global); ?>&original_referer=<?php echo $url_ranking; ?>&ref_src=&text=<?php the_field('message_du_tweet_twitter_2', $id_top_global); ?>&url=<?php echo $url_ranking; ?>&via=<?php the_field('compte_twitter_twitter_2', $id_top_global); ?>" class="animate__jello animate__animated animate__delay-1s btn-wording-rose btn-wording bubbly-button" target="_blank">
                <img src="https://vainkeurz.com/wp-content/uploads/2022/06/twitter.png" width="20" height="16" alt="Tweet icon">
                <?php the_field('message_du_bouton_tweet_twitter2', $id_top_global); ?>
              </a>
            <?php endif; ?>
          </div>
          <div class="popup-footer">
            <button id="close-popup" class="close-popup">
              <span class="text-muted">
                Ne pas participer et juste voir ma TopList
              </span>
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
        <div class="popup-header">
          <h3>
            Participation confirmée <span class="va va-clapping va-lg ms-2"></span>
          </h3>
        </div>
        <div class="popup-body">
          <div class="datefinmail">
            <p>
              Surveille tes e-mails, le tirage au sort se fera le :
              <span><?php the_field('date_fin_de_la_sponso_t_sponso', $id_top_global); ?></span>
            </p>
          </div>
          <div class="separate"></div>
          <div class="bonustop mt-3">
            <?php the_field('message_de_confirmation_t_sponso', $id_top_global); ?>
            <?php if (get_field('lien_de_la_sponso_t_sponso', $id_top_global)) : ?>
              <div class="sitesponsorlien">
                <a href="<?php the_field('lien_de_la_sponso_t_sponso', $id_top_global); ?>" target="_blank">
                  <span class="va va-doigt-droit va-lg"></span> <span class="sitesp"><?php the_field('nom_de_la_sponso_t_sponso', $id_top_global); ?></span> <span class="va va-doigt-droit va-reverse va-lg"></span>
                </a>
              </div>
            <?php endif; ?>
          </div>
        </div>
        <div class="popup-footer">
          <button id="close-popup" class="close-popup">
            <span class="text-muted">
              Fermer et voir ma TopList
            </span>
          </button>
        </div>
      </div>
    </div>
  <?php endif; ?>
</div>