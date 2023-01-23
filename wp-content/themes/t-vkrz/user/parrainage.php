<?php
/*
    Template Name: Account - Parrainage
*/
global $vainkeur_id;
global $uuiduser;
global $user_id;
global $user_infos;
get_header();
$referrals = array();
$referrals = json_decode(get_field('referral_from_me', $id_vainkeur));
$codeparrain = get_field('code_parrain_user', 'user_' . $user_id);
?>
<!-- Content wrapper -->
<div class="content-wrapper content-compte">
  <!-- Content -->
  <div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">
      <!-- User Sidebar -->
      <div class="col-xl-3 col-lg-4 col-md-4">
        <!-- User cover -->
        <?php get_template_part('partials/profil'); ?>
        <!-- User cover -->

        <!-- page keurz -->
        <div class="card text-center">
          <div class="card-body">
            <div class="mb-1">
              <span class="va va-gem va-5x"></span>
            </div>
            <h3 class="font-weight-bolder my-1">
              La page KEURZ
            </h3>
            <p class="card-text legende">
              <a href="<?php the_permalink(get_page_by_path('mon-compte/keurz')); ?>/#tab4" class="btn btn-outline-primary waves-effect w-50" target="_blank">
                Voir plus de details
              </a>
            </p>
          </div>
        </div>
        <!-- /page keurz -->

      </div>
      <!--/ User Sidebar -->

      <!-- User Content -->
      <div class="col-xl-9 col-lg-8 col-md-8">

        <!-- Menu compte -->
        <?php get_template_part('partials/menu-profil'); ?>
        <!-- /Menu compte -->

        <!-- Détails -->
        <section class="detailskeurz">
          <div class="row">
            <div class="col-md-12">
              <!-- parrainage -->
              <div class="card parrainage-card">
                <div class="card-body text-center ">
                  <div class="mb-1">
                    <span class="va va-love-people va-5x"></span>
                  </div>
                  <h2 class="font-weight-bolder">
                    Partager c'est aimer!
                  </h2>
                  <p class="card-text legende">
                    Partage ton code de parrainage avec tes amis et gagne 200 <span class="ico text-center va-gem va va-lg"></span> pour toi et 100 <span class="ico text-center va-gem va va-lg"></span> pour celui que tu as parrainé.
                  </p>

                  <a href="<?php the_permalink(get_page_by_path('creer-mon-compte')); ?>?codeinvit=<?= $codeparrain ?>" class="btn btn-rose waves-effect p-1" id="copyReferralLink">
                    <p class="h4 text-white m-0">
                      Ok je copie le lien <span class="va-cheese1 va va-lg"></span>
                    </p>
                  </a>

                  <a href="<?php echo $codeparrain; ?>" class="btn btn-solocode waves-effect p-1  mt-2" id="copyReferralLink">
                    <p class="h4 m-0">
                      Je copie le code solo <span class="text-white"><?php echo $codeparrain; ?></span> ✨
                    </p>
                  </a>

                  <hr class="mb-3 mt-5">
                  <div class="blog-rs">
                    <div class="d-flex align-items-center">
                      <ul>
                        <li>
                          <h6 class="section-label text-center m-0">Ou par</h6>
                        </li>
                        <li>
                          <a href="https://www.facebook.com/sharer/sharer.php?u=<?php the_permalink(get_page_by_path('creer-mon-compte')); ?>?codeinvit=<?= $codeparrain ?>&quote=Deviens toi aussi un vainkeur" title="Share on Facebook" target="_blank">
                            <span>
                              <i class="fab fa-facebook-f"></i>
                            </span>
                          </a>
                        </li>
                        <li>
                          <a href="https://twitter.com/intent/tweet?source=<?php the_permalink(get_page_by_path('creer-mon-compte')); ?>?codeinvit=<?= $codeparrain ?>&text=Deviens toi aussi un vainkeur:%20<?php the_permalink(get_page_by_path('creer-mon-compte')); ?>?codeinvit=<?= $codeparrain ?>" target="_blank" title="Tweet" spellcheck="false">
                            <span>
                              <i class="fab fa-twitter"></i>
                            </span>
                          </a>
                        </li>
                        <li class="whatsapp">
                          <a href="whatsapp://send?text=<?php the_permalink(get_page_by_path('creer-mon-compte')); ?>?codeinvit=<?= $codeparrain ?>" data-action="share/whatsapp/share">
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
              <!-- /parrainage -->
            </div>
          </div>
          <div class="row">
            <div class="col-12">
              <?php if (!empty($referrals)) : ?>
                <div class="table-responsive">
                  <table class="table table-vainkeurz">
                    <thead>
                      <tr>
                        <th>
                          <span class="text-muted"><?php echo count($referrals) > 1 ? "Liste des <span class='t-rose'>" . count($referrals) . "</span> enfants" : "L'enfant" ?></span>
                        </th>
                        <th class="text-right shorted">
                          <span class="text-muted">XP</span>
                        </th>
                        <th class="text-right shorted">
                          <span class="text-muted">TopList</span>
                        </th>
                        <th class="text-right shorted">
                          <span class="text-muted">KEURZ générés</span>
                        </th>
                        <th class="text-right">
                          <span class="text-muted">Guetter</span>
                        </th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php $r = 1;
                      foreach ($referrals as $referral) :
                        $referral_uuid          = get_field('uuid_user_vkrz', $referral);
                        $infos_referral         = get_user_infos($referral_uuid, 'complete');
                        $user_id                = $infos_referral["id_user"];
                        $total_vote             = $infos_referral["nb_vote_vkrz"];
                        $total_top              = $infos_referral["nb_top_vkrz"];
                        $xp                     = $infos_referral["money_vkrz"];
                        $vainkeur_data_selected = $infos_referral;

                        $get_enfant_money       = round($xp * 0.1);
                      ?>
                        <tr>
                          <td>
                            <?php get_template_part('partials/vainkeur-card'); ?>
                          </td>

                          <td class="text-right">
                            <?php echo $xp; ?> <span class="ico va-mush va va-lg"></span>
                          </td>

                          <td class="text-right">
                            <?php echo $total_top; ?> <span class="ico va va-trophy va-lg"></span>
                          </td>

                          <td class="text-right">
                            <?php echo $get_enfant_money + 200; ?> <span class="va-gem va va-1x"></span>
                          </td>

                          <td class="text-right checking-follower">
                            <?php if (get_current_user_id() != $user_id && is_user_logged_in()) : ?>
                              <button type="button" id="followBtn" class="btn waves-effect btn-follow d-none" data-userid="<?= get_current_user_id(); ?>" data-uuid="<?= get_field('uuiduser_user', 'user_' . get_current_user_id()); ?>" data-relatedid="<?= $user_id; ?>" data-relateduuid="<?= get_field('uuiduser_user', 'user_' . $user_id); ?>" data-text="<?= get_the_author_meta('nickname', get_current_user_id()); ?> te guette !" data-url="<?= get_author_posts_url(get_current_user_id()); ?>">
                                <span class="wording">Guetter</span>
                                <span class="va va-guetteur-close va va-z-20 emoji"></span>
                              </button>
                            <?php else : ?>
                              <a href="<?php the_permalink(get_page_by_path('se-connecter')); ?>" class="btn btn-flat-secondary waves-effect" data-toggle="tooltip" data-placement="top" title="" data-original-title="Tu dois être connecté pour guetter <?php echo $infos_referral['pseudo']; ?>">
                                <span class="text-muted">
                                  Guetter <span class="va va-guetteur-close va va-z-20 emoji"></span>
                                </span>
                              </a>
                            <?php endif; ?>
                          </td>
                        </tr>
                      <?php $r++;
                      endforeach; ?>
                    </tbody>
                  </table>
                </div>

              <?php endif; ?>
            </div>
          </div>
        </section>
        <!-- /Détails -->

      </div>
      <!-- /User Content -->
    </div>
  </div>
  <!-- /Content -->
  <div class="content-backdrop fade"></div>
</div>
<!-- Content wrapper -->

<?php get_footer(); ?>