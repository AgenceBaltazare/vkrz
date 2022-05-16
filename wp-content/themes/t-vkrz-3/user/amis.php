<?php
/*
    Template Name: Account - Amis
*/
global $vainkeur_id;
global $uuiduser;
global $user_id;
global $user_infos;
get_header();

if (false === ($data_t_created = get_transient('user_' . $vainkeur_id . '_get_creator_t'))) {
  $data_t_created = get_creator_t($vainkeur_id);
  set_transient('user_' . $vainkeur_id . '_get_creator_t', $data_t_created, DAY_IN_SECONDS);
} else {
  $data_t_created = get_transient('user_' . $vainkeur_id . '_get_creator_t');
}
/////////////////////
$amis_ids = array();
$amis_ids = get_field('liste_amis_user', 'user_' . $user_id, false);
if (is_array($amis_ids)) {
  $amis = array();
  foreach (array_unique($amis_ids) as $ami_id) :
    $ami_uuid = get_field('uuiduser_user', 'user_' . $ami_id);
    $ami_infos = get_user_infos($ami_uuid);

    array_push($amis, $ami_infos);
  endforeach;
}
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
                        <div class="card">

                          <div class="table-responsive">
                            <table class="table table-amigos">
                              <thead>
                                <tr>
                                  <th>
                                    <?php if (empty($amis)) : ?>
                                      <span class="text-muted">
                                        <span class="text-muted">Liste des Amis
                                        </span>
                                      <?php elseif (count($amis) == 1) : ?>
                                        <span class="text-muted">
                                          <span class="text-muted">Ton ami</span>
                                        </span>
                                      <?php else : ?>
                                        <span class="text-muted">
                                          <span class="text-muted">Liste des <span class="t-rose"><?php echo count($amis); ?></span> Amis</span>
                                        </span>
                                      <?php endif; ?>
                                  </th>
                                  <?php if (!empty($amis)) : ?>

                                    <th class="text-right">
                                      <small class="text-muted pr-1">KEURZ</small>
                                    </th>
                                    <th class="text-right">
                                      <small class="text-muted">Votes effectués</small>
                                    </th>
                                    <th class="text-right">
                                      <small class="text-muted">Top terminés</small>
                                    </th>
                                    <th class="text-right">
                                      <small class="text-muted pr-1">Guetter ses Tops</small>
                                    </th>
                                </tr>
                              </thead>
                              <tbody>
                                <?php foreach ($amis as $ami) : ?>
                                  <tr>
                                    <td>
                                      <div class="d-flex align-items-center">
                                        <?php
                                        $user_id            = $ami["user_id"];
                                        $total_vote         = $ami["nb_vote_vkrz"];
                                        $total_top          = $ami["nb_top_vkrz"];
                                        $money              = $ami["money_vkrz"];
                                        $user_infos         = deal_vainkeur_entry($user_id);
                                        $avatar             = $ami['avatar'];
                                        $info_user_level    = get_user_level($user_id);
                                        ?>
                                        <div class="avatar">
                                          <span class="avatar-picture" style="background-image: url(<?php echo $avatar; ?>);"></span>
                                          <?php if ($info_user_level) : ?>
                                            <span class="user-niveau">
                                              <?php echo $info_user_level['level_ico']; ?>
                                            </span>
                                          <?php endif; ?>
                                        </div>
                                        <div class="font-weight-bold championname">
                                          <span>
                                            <?php echo get_the_author_meta('nickname', $user_id); ?>
                                          </span>
                                          <?php if ($user_infos['user_role'] == "administrator") : ?>
                                            <span class="ico va va-vkrzteam va-lg" data-toggle="tooltip" data-placement="top" title="" data-original-title="TeamVKRZ">
                                            </span>
                                          <?php endif; ?>
                                          <?php if ($user_infos['user_role'] == "administrator" || $user_infos['user_role'] == "author") : ?>
                                            <span class="ico va va-man-singer va-lg" data-toggle="tooltip" data-placement="top" title="" data-original-title="Créateur de Tops">
                                            </span>
                                          <?php endif; ?>
                                        </div>
                                      </div>
                                    </td>

                                    <td class="text-right">
                                      <?php echo $money; ?> <span class="ico va-gem va va-lg"></span>
                                    </td>

                                    <td class="text-right">
                                      <?php echo $total_vote; ?> <span class="ico va-high-voltage va va-lg"></span>
                                    </td>

                                    <td class="text-right">
                                      <?php echo $total_top; ?> <span class="ico va va-trophy va-lg"></span>
                                    </td>

                                    <td class="text-right">
                                      <a href="<?php echo esc_url(get_author_posts_url($user_id)); ?>" class="mr-1 btn btn-outline-primary waves-effect">
                                        <span class="va va-eyes va-lg"></span>
                                      </a>
                                    </td>
                                  </tr>
                                <?php endforeach; ?>
                              </tbody>
                            <?php endif; ?>
                            </table>

                          </div>

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