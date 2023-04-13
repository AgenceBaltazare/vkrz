<?php
/*
    Template Name: Creation de Top
*/
if (isMobile()) {
  wp_redirect('proposition-de-tops');
  exit;
}
get_header();
?>

<div class="my-3">
  <div class="container-xxl">
    <div class="intro-archive">
      <div class="iconarchive">
        <span class="va-man-singer va va-z-17"></span>
      </div>
      <h1>
        Crée ton propre top
      </h1>
      <h2>
        Prêt à créer ton top ? En seulement 3 étapes
      </h2>
      <span class="you-can-propose-top">Tu peux également proposer tes tops <a href="<?php the_permalink(get_page_by_path(('proposition-de-tops'))) ?>">ici !</a></span>
    </div>
  </div>
  <div class="container-xxl">
    <div class="blog-detail-wrapper create-top-page mt-3 mx-2">

      <section class="create-top-wrapper">
        <div class="create-top-steps <?php echo is_user_logged_in() ? "" : "disable-create-top" ?>">
          <div class="step" data-tabIndex="0">
            <strong>1</strong>
            <span>Top</span>
          </div>

          <div class="step disable" data-tabIndex="1">
            <strong>2</strong>
            <span>Contenders</span>
          </div>

          <div class="step disable" data-tabIndex="2">
            <strong>3</strong>
            <span>La Fin!</span>
          </div>
        </div>

        <div class="create-top-content <?php echo is_user_logged_in() ? "" : "disable-create-top" ?>">

          <!-- DEAL TOP 1/3 -->
          <div class="top-form-wrapper tabs tab show">
            <form class="create-top-form" autocomplete="off" method="POST" enctype="multipart/form-data" data-idtop="" data-topurl="" data-idtopauthor="<?= get_user_logged_id(); ?>">

              <div class="form-group">
                <input type="text" name="top-title" id="top-title" placeholder="Thème" value="" required
                data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="(ex: DBZ - Vkings…)"
                >
                <select class="top-category" name="top-category" id="top-category" required>
                  <option value="" disabled selected>Catégorie</option>

                  <?php
                  $list_categorie = get_terms(array(
                    'taxonomy'      => 'categorie',
                    'orderby'       => 'count',
                    'order'         => 'DESC',
                    'hide_empty'    => false,
                  ));
                  foreach ($list_categorie as $categorie) : ?>
                    <option value="<?php echo $categorie->term_id; ?>">
                      <?php echo $categorie->name; ?>
                    </option>
                  <?php endforeach; ?>
                </select>
              </div>
              <input type="text" name="top-question" id="top-question" placeholder="Question" required
              data-bs-toggle="tooltip" data-bs-placement="left" data-bs-original-title="(ex: Quel est ton personnage préféré dans Vikings ?)"
              />
              <input type="text" name="top-description" id="top-description" placeholder="Description" required
              data-bs-toggle="tooltip" data-bs-placement="right" data-bs-original-title="(ex: Ragnar Lothbrok sans hésitation)"
              />
              <div 
                class="image-upload-wrapper" 
                data-text="Déposes la bannière du Top ici ou clik pour la télécharger (1200x630px stp)"
                data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-original-title="Tu peux utiliser ce site pour améliorer la qualité de tes images : https://imgupscaler.com/ :)"
              >
                <input name="top-image" type="file" class="top-image" id="top-image" value="" accept="image/*" required>
                <br><br>

                <div class="top-banner-wrapper"></div>
              </div>

              <div class="btn-wrapper">
                <button type="submit" class="btn btn-lg btn-primary soumettre-top text-uppercase">Envoyer</button>
              </div>
            </form>
          </div>
          <!-- /DEAL TOP 1/3 -->

          <!-- DEAL CONTENDER 2/3 -->
          <div class="contenders-form-wrapper tabs tab hidden">
            <form class="create-top-contenders-form" autocomplete="off" method="POST" enctype="multipart/form-data">

              <div class="input-group">
                <fieldset class="w-100 m-0 my-1">
                  <legend>Dimension des Contenders au choix :</legend>
                  <label for="400" class="form-control">
                    <input type="radio" id="400" name="contenders-dimension" value="carre">
                    400x400 (Carré)
                  </label>

                  <label for="400x600" class="form-control">
                    <input type="radio" id="400x600" name="contenders-dimension" value="vertical">
                    400x600 (Vertical)
                  </label>

                  <label for="600x400" class="form-control">
                    <input type="radio" id="600x400" name="contenders-dimension" value="paysage">
                    600x400 (Paysage)
                  </label>
                </fieldset>
              </div>

              <div class="input-group mt-2">
                <div class="image-upload-wrapper contender-image-upload-wrapper d-none" data-text="Dépose ton Contender ici ou clique pour le télécharger.">
                  <input name="contender-image-input" type="file" class="contender-image-input" id="contender-image-input" accept="image/*" required>
                </div>
              </div>

              <div class="contenders-images mt-4"></div>

              <div class="btn-wrapper">
                <button type="submit" class="btn btn-lg btn-primary soumettre-contenders text-uppercase">Envoyer</button>
              </div>
            </form>

          </div>
          <!-- /DEAL CONTENDER 2/3 -->

          <!-- FINISH 3/3 -->
          <div class="finish-wrapper tabs tab hidden">

            <img src="https://media.tenor.com/rTxO8txn5ZQAAAAC/dinosaur-jumping.gif" title="Lama YEAH!" alt="Lama YEAH!">
            <p>Voilà, c'est fait ! Merci pour ta participation.</p>
            <p>Reste connecté, tu recevras une notification de notre part dès que possible <span class="va va-smiling-face-with-hearts va-z-25"></span></p>

            <p>(Pour toute modification, remarque ou question, n'hésite pas à nous en faire part sur notre <a href="https://discord.gg/E9H9e8NYp7" target="_blank"><i class="fab fa-discord"></i>&nbsp;Discord</a> )</p>
          </div>
          <!-- /FINISH 3/3 -->

          <!-- ERROR -->
          <p class="alert d-none">
            <i class="fa fa-exclamation-triangle" aria-hidden="true"></i>
            Concentre-toi et remplis tous les champs ! 😝
          </p>
          <!-- /ERROR -->

          <!-- CROP MODAL -->
          <div class="modal modal-top fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="modalLabel">Recadrer l'image</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                  <div class="img-container">
                    <div class="row">
                      <div class="w-100" id="modal-left">
                        <img id="image-output" />
                      </div>
                      <div class="w-100 d-flex justify-content-between align-items-center" id="modal-right">

                          <div class="preview"></div>

                          <!-- IF CONTENDER -->
                          <div class="contender-group-input d-none">
                            <label for="contender-name" class="ml-50 mb-0">Le nom du Contender : </label>
                            <input type="text" name="contender-name" id="contender-name" class="ml-50">
                          </div>
                          <!-- /IF CONTENDER -->


                          <!-- OPTIONS 🔧 -->
                          <fieldset>
                            <legend>Options: </legend>

                            <button type="button" class="btn btn-label-primary m-1" data-option="cropper-zoom-in" id="cropper-options-btn" title="Zoom avant">
                              <span class="docs-tooltip" data-bs-toggle="tooltip" title="Zoom avant" data-bs-original-title="Zoom avant">
                                <span class="fa fa-search-plus"></span>
                              </span>
                            </button>

                            <button type="button" class="btn btn-label-primary m-1" data-option="cropper-zoom-out" id="cropper-options-btn" title="Zoom arrière">
                              <span class="docs-tooltip" data-bs-toggle="tooltip" title="Zoom arrière" data-bs-original-title="Zoom arrière">
                                <span class="fa fa-search-minus"></span>
                              </span>
                            </button>

                            <button type="button" class="btn btn-label-primary m-1" data-option="cropper-move-left" id="cropper-options-btn" title="Déplacer vers la gauche">
                              <span class="docs-tooltip" data-bs-toggle="tooltip" title="Déplacer vers la gauche" data-bs-original-title="Déplacer vers la gauche">
                                <i class="fas fa-arrow-left"></i>
                              </span>
                            </button>

                            <button type="button" class="btn btn-label-primary m-1" data-option="cropper-move-right" id="cropper-options-btn" title="Déplacer vers la droite">
                              <span class="docs-tooltip" data-bs-toggle="tooltip" title="Déplacer vers la droite" data-bs-original-title="Déplacer vers la droite">
                                <i class="fas fa-arrow-right"></i>

                              </span>
                            </button>

                            <button type="button" class="btn btn-label-primary m-1" data-option="cropper-move-up" id="cropper-options-btn" title="Déplacer vers le haut">
                              <span class="docs-tooltip" data-bs-toggle="tooltip" title="Déplacer vers le haut" data-bs-original-title="Déplacer vers le haut">
                                <i class="fas fa-arrow-up"></i>
                              </span>
                            </button>

                            <button type="button" class="btn btn-label-primary m-1" data-option="cropper-move-down" id="cropper-options-btn" title="Déplacer vers le bas">
                              <span class="docs-tooltip" data-bs-toggle="tooltip" title="Déplacer vers le bas" data-bs-original-title="Déplacer vers le bas">
                                <i class="fas fa-arrow-down"></i>
                              </span>
                            </button>
                          </fieldset>
                          <!-- /OPTIONS -->


                      </div>
                    </div>
                  </div>
                </div>

                <div class="modal-footer" style="background: #170C31;border-top: 1px solid #261C61;">
                  <button type="button" class="btn btn-label-primary " data-bs-dismiss="modal" aria-label="Close" id="cancelSendBtn">
                    Annuler
                  </button>
                  <button type="button" class="btn btn-primary" id="cropAndSendBtn">
                    Envoyer
                  </button>
                </div>

              </div>
            </div>
          </div>
          <!-- /CROP MODAL -->

        </div>

        <?php if(!is_user_logged_in()) : ?>
          <div class="must-log-in">
            <div class="d-flex">
            Tu dois être connecté pour créer ton Top <span class="va va-hugging-face va-z-25 ms-1"></span>
            </div>

            <a href="<?php the_permalink(get_page_by_path('connexion')); ?>?redirect=<?php the_permalink(get_page_by_path('Créer un Top')); ?>" class="connect-btn nav-link btn btn-rose waves-effect waves-light">S'inscrire ou se connecter</a>
          </div>
        <?php endif; ?>
      </section>

    </div>
  </div>
</div>

<?php get_footer(); ?>