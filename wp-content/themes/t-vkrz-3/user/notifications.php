<?php
/*
    Template Name: Account - Notifications
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

$notifications_all = new WP_Query(
  array(
    'post_type' => 'notification',
    'orderby' => 'date',
    'posts_per_page' => '-1',
    'meta_query'     => array(
      'relation' => 'AND',
      array(
        'key'     => 'relation_uuid_notif',
        'value'   => $user_infos['uuid_user_vkrz'],
        'compare' => '=',
      )
    )
  )
);
$number_of_notifications_all = $notifications_all->found_posts;
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
                            <table class="table table-notifications">
                              <thead>
                                <tr>
                                  <th class="">
                                    <span class="text-muted">
                                      <span class="text-muted">Liste des <span class="t-rose"><?php echo $number_of_notifications_all; ?></span> Notifications</span>
                                    </span>
                                  </th>
                                  <th class="text-right">
                                    <span class="text-muted pr-2">Statut</span>
                                  </th>
                                  <th class="text-right">
                                    <span class="text-muted pr-2">Action</span>
                                  </th>
                                </tr>
                              </thead>
                              <tbody>
                                <?php if ($notifications_all->have_posts()) :
                                  while ($notifications_all->have_posts()) : $notifications_all->the_post();

                                    $relation_uuid = get_user_infos(get_field('uuid_user_notif', get_the_id()));
                                ?>
                                    <tr>
                                      <td>
                                        <div class="media-body">
                                          <div class="media-heading">
                                            <div class="d-flex">
                                              <div class="avatar mr-50">
                                                <?php
                                                $texte_notif = get_field('texte_notif', get_the_id());
                                                $pos = strpos(strtolower($texte_notif), "anonyme");
                                                if ($pos !== false) :
                                                ?>
                                                  <span class="avatar-picture" style="background-image: url(http://0.gravatar.com/avatar/?s=80&amp;d=https%3A%2F%2Fvainkeurz.com%2Fwp-content%2Fthemes%2Ft-vkrz-3%2Fassets%2Fimages%2Fvkrz%2Favatar-rose.png&amp;r=g); width: 24px; height: 24px;"></span>
                                                <?php else : ?>
                                                  <a href="<?php echo $relation_uuid['profil_url']; ?>">
                                                    <img src="<?php echo $relation_uuid['avatar'];
                                                              ?>" alt="Avatar" width="24" height="24">
                                                  </a>
                                                <?php endif; ?>
                                              </div>

                                              <div class="">
                                                <h6 class="cart-item-title lead mb-0">
                                                  <?php echo $texte_notif; ?>
                                                </h6>

                                                <small class="cart-item-by legende">
                                                  <?php
                                                  $time = human_time_diff(get_the_time('U'), current_time('timestamp'));
                                                  $findMe   = 'ans';
                                                  $pos = strpos($time, $findMe);

                                                  if ($pos === false) {
                                                    echo 'Il y a ' . human_time_diff(get_the_time('U'), current_time('timestamp'));
                                                  } else {
                                                    the_time('l d F Y à H:i');
                                                  }
                                                  ?>
                                                </small>
                                              </div>

                                            </div>
                                          </div>
                                        </div>
                                      </td>
                                      <td class="text-right">
                                        <?php if (get_field('statut_notif', get_the_id()) == 'nouveau') { ?>
                                          <span class="badge rounded-pill badge-light-success me-1">Nouveau</span>
                                        <?php } else { ?>
                                          <span class="badge rounded-pill badge-light-primary me-1">Vu</span>
                                        <?php } ?>
                                      </td>
                                      <td class="text-right">

                                        <?php
                                        $string = get_field('texte_notif', get_the_id());
                                        $findMe  = "guette";
                                        $pos = strpos($string, $findMe);
                                        if ($pos === false) { ?>
                                          <a class="mr-1" id="read-notification" data-id_notification="<?php echo get_the_ID(); ?>" href="<?php echo get_field('lien_vers_notif', get_the_id()); ?>">
                                            <span class="ico va va-eyes va-lg">
                                            </span>
                                          </a>
                                        <?php } else { ?>
                                          <a class="mr-1" id="read-notification" data-id_notification="<?php echo get_the_ID(); ?>" href="<?php echo $relation_uuid['profil_url']; ?>">
                                            <span class="ico va va-eyes va-lg">
                                            </span>
                                          </a>
                                        <?php } ?>
                                      </td>
                                    </tr>
                                <?php endwhile;
                                endif; ?>
                              </tbody>
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