<?php
/*
    Template Name: Profil - Creator
*/
global $vainkeur_id;
if (isset($_GET['creator_id'])) {
  $vainkeur_id  = $_GET['creator_id'];
} else {
  header('Location: ' . get_bloginfo('url'));
}
global $user_id;
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
              <section class="app-user-view">
                <div class="row match-height">
                  <div class="col-sm-3 col-6">
                    <div class="card text-center">
                      <div class="card-body">
                        <div class="mb-1">
                          <span class="ico4 va va-crossed-swords va-z-30"></span>
                        </div>
                        <h2 class="font-weight-bolder">
                          <?php echo number_format($data_t_created['creator_nb_tops'], 0, ",", " "); ?>
                        </h2>
                        <p class="card-text legende">
                          <?php echo ($data_t_created['creator_nb_tops'] > 1) ? "Tops créés" : "Top créé"; ?>
                        </p>
                      </div>
                    </div>
                  </div>
                  <div class="col-sm-3 col-6">
                    <div class="card text-center">
                      <div class="card-body">
                        <div class="mb-1">
                          <span class="ico4 va-high-voltage va va-z-30"></span>
                        </div>
                        <h2 class=" font-weight-bolder">
                          <?php echo number_format($data_t_created['creator_all_v'], 0, ",", " "); ?>
                        </h2>
                        <p class="card-text legende">
                          <?php echo ($data_t_created['creator_all_v'] > 1) ? "Votes générés" : "Vote généré"; ?>
                        </p>
                      </div>
                    </div>
                  </div>
                  <div class="col-sm-3 col-6">
                    <div class="card text-center">
                      <div class="card-body">
                        <div class="mb-1">
                          <span class="ico4 va va-trophy va-z-30"></span>
                        </div>
                        <h2 class="font-weight-bolder">
                          <?php echo number_format($data_t_created['creator_all_t'], 0, ",", " "); ?>
                        </h2>
                        <p class="card-text legende">
                          <?php echo ($data_t_created['creator_all_t'] > 1) ? "TopList générées" : "Classement généré"; ?>
                        </p>
                      </div>
                    </div>
                  </div>
                  <div class="col-sm-3 col-6">
                    <div class="card text-center">
                      <div class="card-body">
                        <div class="mb-1">
                          <span class="ico4 va va-hundred va-z-30"></span>
                        </div>
                        <h2 class="font-weight-bolder">
                          <?php echo $data_t_created['finition_globale']; ?> %
                        </h2>
                        <p class="card-text legende">Taux moyen de finition</p>
                      </div>
                    </div>
                  </div>
                </div>
              </section>
              <section id="basic-tabs-components">
                <div class="tab-content">
                  <div class="tab-pane active" id="tab3" aria-labelledby="profileIcon-tab" role="tabpanel">
                    <div class="row">
                      <div class="col-12">
                        <div class="card">
                          <div class="table-responsive">
                            <table class="table table-creator">
                              <thead>
                                <tr>
                                  <th class="">
                                    <span class="text-muted">
                                      Liste des Tops créés
                                    </span>
                                  </th>
                                  <th class="text-right shorted">
                                    <span class="text-muted">Total des votes <span class="va va-updown va-z-15"></span></span>
                                  </th>
                                  <th class="text-right shorted">
                                    <span class="text-muted">Tops générés <span class="va va-updown va-z-15"></span></span>
                                  </th>
                                  <th class="text-right shorted">
                                    <span class="text-muted">% de finition <span class="va va-updown va-z-15"></span></span>
                                  </th>
                                  <th class="text-right">
                                    <span class="text-muted">Action</span>
                                  </th>
                                </tr>
                              </thead>
                              <tbody>
                                <?php
                                foreach ($data_t_created['creator_tops'] as $item) : ?>
                                  <?php if (!in_array($item['top_id'], get_exclude_top())) : ?>
                                    <tr>
                                      <td>
                                        <?php
                                        global $id_top;
                                        $id_top = $item['top_id'];
                                        get_template_part('partials/top-card');
                                        ?>
                                      </td>
                                      <td class="text-right">
                                        <?php echo $item['top_votes']; ?> <span class="ico3 va-high-voltage va va-lg"></span>
                                      </td>
                                      <td class="text-right">
                                        <?php echo $item['top_ranks']; ?> <span class="ico3 va va-trophy va-lg"></span>
                                      </td>
                                      <td class="text-right">
                                        <?php echo $item['top_finition']; ?> %
                                      </td>
                                      <td class="text-right">
                                        <a class="btn btn-flat-secondary waves-effect" href="<?php the_permalink(get_page_by_path('liste-des-tops')); ?>?id_top=<?php echo $item['top_id']; ?>" data-toggle="tooltip" data-placement="top" title="" data-original-title="Voir toutes les TopList">
                                          <span class="ico va va-eyes va-lg">
                                          </span>
                                        </a>
                                        <a class="btn btn-flat-secondary waves-effect" href="<?php the_permalink(get_page_by_path('elo')); ?>?id_top=<?php echo $item['top_id']; ?>" data-toggle="tooltip" data-placement="top" title="" data-original-title="Voir la TopList mondiale">
                                          <span class="ico va va-globe va-lg">
                                          </span>
                                        </a>
                                      </td>
                                    </tr>
                                <?php endif;
                                endforeach; ?>
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