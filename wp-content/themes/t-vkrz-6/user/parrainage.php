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
<!-- BEGIN: Content-->
<div class="app-content content ">
  <div class="content-wrapper">
    <div class="content-body">
      <div id="user-profile">
        <div class="row">
          <div class="col-12">
            <?php get_template_part('partials/profil'); ?>
          </div>
        </div>
        <section id="profile-info">
          <div class="row">
            <div class="col-12">
              <section id="basic-tabs-components">
                <div class="tab-content">
                  <div class="tab-pane active" id="tab3" aria-labelledby="profileIcon-tab" role="tabpanel">
                    <div class="row">
                      <div class="col-12">

                        <div class="card p-1 parrainage-card">
                          <div class="card-header">
                            <h4 class="card-title">
                              Parrainage
                            </h4>
                          </div>

                          <div class="card-body p-2">
                            <a href="<?php the_permalink(get_page_by_path('creer-mon-compte')); ?>?codeinvit=<?= $codeparrain ?>" class="btn btn-rose waves-effect p-1" id="copyReferralLink">
                              <p class="h4 text-white m-0">
                                Copier mon code d'invitation
                              </p>
                            </a>
                          </div>

                          <?php if (!empty($referrals)) : ?>

                            <div class="table-responsive">
                              <table class="table table-vainkeurz">
                                <thead>
                                  <tr>
                                    <th>
                                      <span class="va va-chequered-flag va-lg"></span>
                                    </th>
                                    <th>
                                      <span class="va va-lama va-lg"></span> <span class="text-muted">Vainkeur</span>
                                    </th>
                                    <th class="text-right shorted">
                                      <span class="text-muted">XP <span class="va va-updown va-z-10"></span></span>
                                    </th>
                                    <th class="text-right shorted">
                                      <span class="text-muted">Votes <span class="va va-updown va-z-10"></span></span>
                                    </th>
                                    <th class="text-right shorted">
                                      <span class="text-muted">TopList <span class="va va-updown va-z-10"></span></span>
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
                                  ?>
                                    <tr>
                                      <td>
                                        <?php if ($r == 1) : ?>
                                          <span class="ico va va-medal-1 va-lg"></span>
                                        <?php elseif ($r == 2) : ?>
                                          <span class="ico va va-medal-2 va-lg"></span>
                                        <?php elseif ($r == 3) : ?>
                                          <span class="ico va va-medal-3 va-lg"></span>
                                        <?php else : ?>
                                          #<?php echo $r; ?>
                                        <?php endif; ?>
                                      </td>
                                      <td>
                                        <?php get_template_part('partials/vainkeur-card'); ?>
                                      </td>

                                      <td class="text-right">
                                        <?php echo $xp; ?> <span class="ico va-mush va va-lg"></span>
                                      </td>

                                      <td class="text-right">
                                        <?php echo $total_vote; ?> <span class="ico va-high-voltage va va-lg"></span>
                                      </td>

                                      <td class="text-right">
                                        <?php echo $total_top; ?> <span class="ico va va-trophy va-lg"></span>
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
                    </div>
                  </div>
                </div>
              </section>
            </div>
          </div>
        </section>
      </div>
    </div>
  </div>
</div>
<?php get_footer(); ?>