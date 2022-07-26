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
                      <div class="col-sm-3">
                        <div class="card">
                          <div class="card-body text-center">
                            <div class="mb-1">
                              <span class="ico4 va va-star-struck va va-z-85"></span>
                            </div>
                            <h2 class="font-weight-bolder amigos-nbr">
                                0
                            </h2>
                            <p class="card-text legende">Amigos</p>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-6 col-sm-12">
                            <div class="card text-center">
                              <div class="card-body">
                                <div class="mb-1">
                                  <span class="ico4 va va-waving-hand va va-z-30"></span>
                                </div>
                                <h2 class="font-weight-bolder following-nbr">
                                    0
                                </h2>
                                <p class="card-text legende">
                                  Following
                                </p>
                              </div>
                            </div>
                          </div>
                          <div class="col-6 col-sm-12">
                            <div class="card text-center">
                              <div class="card-body">
                                <div class="mb-1">
                                  <span class="ico4 va va-eyes va va-z-30"></span>
                                </div>
                                <h2 class="font-weight-bolder followers-nbr-amigos">
                                    0
                                </h2>
                                <p class="card-text legende">
                                  Followers
                                </p>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>

                      <div class="col-sm-9 col-12">
                        <div class="card">
                          <div class="table-responsive">
                            <table class="table table-amigos">
                              <thead>
                                <tr>
                                  <th>
                                    <span class="text-muted">
                                      Liste des Amis
                                    </span>
                                  </th>

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
                                    <small class="text-muted">Action</small>
                                  </th>
                                </tr>
                              </thead>
                              <tbody>

                                <tr>
                                  <th></th>
                                  <th></th>
                                  <th style="transform: translateX(45%);">
                                    <span class="similarpercent" data-uuiduser="<?php echo get_field('uuid_user_r', $id_ranking); ?>" data-idtop="<?php echo $id_top_global; ?>">
                                      <div class="loader loader--style1" title="0">
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
                                    </span>
                                  </th>
                                  <th></th>
                                  <th></th>
                                </tr>

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