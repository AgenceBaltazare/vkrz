<?php
/*
    Template Name: Create Top
*/
get_header();
?>

<div class="app-content content create-top-page">
  <div class="content-wrapper">
    <div class="content-body">

      <section class="create-top-wrapper">
        <div class="create-top-steps">
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
            <span>Finish!</span>
          </div>
        </div>

        <div class="create-top-content">
          <form class="create-top-form" autocomplete="off" method="POST" enctype="multipart/form-data" data-idtop="">
            <div class="top-form-wrapper tabs tab show">

              <div class="form-group">
                <input type="text" name="top-title" id="top-title" placeholder="Title" value="" required>
                <select class="top-category" name="top-category" id="top-category" required>
                  <option value="" disabled selected>Category</option>

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
              <input type="text" name="top-question" id="top-question" placeholder="Question" required>
              <input type="text" name="top-description" id="top-description" placeholder="Description" required>
              <div class="image-upload-wrapper" data-text="Déposez l'image ici ou cliquez pour la télécharger.">
                <input name="top-image" type="file" class="top-image" id="top-image" value="" onchange="uploadFile(this)" accept="image/*" multiple="false" required>
                <br><br>
                <img id="output" width="150" height="100" />
              </div>

              <button type="submit" class="btn btn-primary mt-3 float-right soumettre-top">Soumettre</button>
            </div>
          </form>

          <form class="create-top-contenders-form" autocomplete="off" method="POST" enctype="multipart/form-data">
            <div class="contenders-form-wrapper tabs tab hidden">
              <div class="image-upload-wrapper" data-text="Déposez vos Contenders ici ou cliquez pour les télécharger.">
                <input name="file-upload-field" type="file" class="file-upload-field" value="" accept="image/*" onchange="uploadFiles(this)" multiple required />
              </div>

              <div class="images"></div>

              <button type="submit" class="btn btn-primary mt-2 float-right soumettre-contenders">Soumettre</button>
            </div>
          </form>

          <div class="finish-wrapper tabs tab hidden">La fin!</div>

          <p class="alert d-none">
            <i class="fa fa-exclamation-triangle" aria-hidden="true"></i>
            Concentre-toi et rempli bien tous les champs 😝
          </p>
        </div>
      </section>
    </div>
  </div>
</div>

<?php get_footer(); ?>