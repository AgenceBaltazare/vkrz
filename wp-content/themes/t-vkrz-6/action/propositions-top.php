<?php
/*
    Template Name: Proposition de top
*/
get_header();
if (isset($_GET['id_vainkeur']) && $_GET['id_vainkeur'] != "") {
  $id_vainkeur = $_GET['id_vainkeur'];
}
if (isset($_GET['badge-selection']) && $_GET['badge-selection'] != "") {
  $badge_selection = $_GET['badge-selection'];
}
$user = wp_get_current_user();
$roles = (array) $user->roles;
?>
<div class="app-content content ">
  <div class="content-wrapper">
    <div class="content-body">
      <div class="blog-detail-wrapper propositions-top-wrapper mt-3">
        <div class="row">

          <div class="col-md-9 col-12">
            <div class="heading">
              <h1 class="heading-title">
                Propose ton <strong>Top</strong>
              </h1>

              <?php if(!is_user_logged_in()) : ?>
                <p>
                  Tu dois Être connecté pour proposer une idée de Top&nbsp; <span class="va va-backhand-index-pointing-right va-2x"></span> &nbsp;<a href="<?php the_permalink(get_page_by_path('connexion')); ?>?redirect=<?php the_permalink(get_page_by_path('Proposition de Tops')); ?>" class="btn">Se connecter/ s'inscrire</a>
                </p>
                <?php endif; ?>
            </div>

            <div class="row">
              <div class="col-md-12">
                <div class="card form-propositions-card">
                  <div class="card-body">
                    <form id="form-propositions" class="<?php echo !is_user_logged_in() ? "disable" : "" ?>" method="POST" action="">

                          <div class="categorie-input form-input">
                            <label for="categorie">Catégorie</label>
                            <select class="form-control categorie" name="categorie">
                              <option value="">Choix de catégorie</option>
                              <?php
                              $list_categorie = get_terms(array(
                                'taxonomy'      => 'categorie',
                                'orderby'       => 'title',
                                'order'         => 'ASC',
                                'hide_empty'    => false,
                              ));
                              foreach ($list_categorie as $categorie) : ?>
                                <option value="<?php echo $categorie->name; ?>">
                                  <span class="ico">
                                    <?php the_field('icone_cat', 'term_' . $categorie->term_id); ?>
                                  </span>
                                  <?php echo $categorie->name; ?>
                                </option>
                              <?php endforeach; ?>
                            </select>
                          </div>

                          <div class="theme_propose-input form-input">
                            <label for="theme_propose">Thème</label>
                            <input class="form-control theme_propose" type="text" name="theme_propose" placeholder="Ex: DBZ - Game of Thrones…">
                          </div>

                          <div class="question_top-input form-input">
                            <label for="question_top">Question</label>
                            <input class="form-control question_top" type="text" name="question_top" placeholder="Ex: Quel est ton album préféré ?">
                          </div>

                          <div class="proposer_btn-input form-input">
                            <button type="submit" class="proposer-btn btn btn-primary waves-effect waves-float waves-light">Proposer le Top</button>
                          </div>

                    </form>

                    <p class="merci-proposition d-none">Merci pour ta proposition, tu seras tenu au courant de la suite par mail si ton idée est acceptée et un autre mail quand le Top sera en ligne.</p>

                    <p class="prop-alert d-none">
                      <i class="fa fa-exclamation-triangle" aria-hidden="true"></i>
                      Essaye avec remplir tous les champs.
                    </p>
                  </div>
                </div>
              </div>
            </div>

            <div class="col-md-12 d-block mx-auto p-0">
              <section id="profile-info">
                <div class="card liste-propositions-card">
                  <div class="card-header p-0">
                    <h2 class="card-title">
                     Liste des propositions
                    </h2>
                  </div>
                  <div class="table-responsive">

                    <table class="table table-propositions">
                      <thead>
                        <tr>
                          <th class="text-left">
                            <span class="text-muted">Date</span>
                          </th>

                          <th class="text-left">
                            <span class="text-muted">Top</span>
                          </th>

                          <th class="text-center">
                            <span class="text-muted">Proposer Par</span>
                          </th>

                          <th class="text-center">
                            <span class="text-muted">Statut</span>
                          </th>

                          <th class="text-left">
                            <span class="text-muted">Attribué Par</span>
                          </th>
                        </tr>
                      </thead>

                      <tbody>

                        <!-- data load from firebase -->
                        <tr>
                          <th></th>
                          <th></th>
                          <th>
                            <span class="similarpercent">
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
              </section>
            </div>
          </div>

          <div class="col-md-3 col-12">
            <div class="deviens-createur-wrapper">
              <div class="heading">
                <h3>Deviens Créateur</h3>
              </div>

              <div class="text">
                <p>Ce serait tellement kool que tu rejoingnes l'ékip des créateurs de VAINKEURZ.</p>
                <p>Au délà du prestige que ça va te procurer, tu accumuleras aussi un pakey de KEURZ.</p>
                <p>En effet, tu gagnes des KEURZ à chaque fois que vainkeur vote et termine un de tes Tops.</p>
                <p>Mais tu connais, la passion avant tout.</p>
              </div>

              <a href="<?php the_permalink(get_page_by_path('recrutement')); ?>" class="btn">Postuler</a>
            </div>
          </div>

        </div>
      </div>
    </div>
  </div>
</div>
<?php get_footer(); ?>