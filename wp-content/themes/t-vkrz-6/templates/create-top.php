<?php
/*
    Template Name: Create Top
*/
get_header();

// // PREVENT WordPress FROM CHANGING THE IMAGE SIZE
// /**
//  * @param array $sizes    An associative array of image sizes.
//  * @param array $metadata An associative array of image metadata: width, height, file.
//  */
// function remove_image_sizes($sizes, $metadata)
// {
//   return [];
// }
// add_filter('intermediate_image_sizes_advanced', 'remove_image_sizes', 10, 2);

// // TO SAVE THE IMAGE IN MEDIA LIBRARY
// function register_team_show_case_setting()
// {
//   register_setting('my_team_show_case_setting', 'topImage');
// }
// add_action('admin_init', 'register_team_show_case_setting');

// require_once(ABSPATH . 'wp-admin/includes/image.php');
// require_once(ABSPATH . 'wp-admin/includes/file.php');
// require_once(ABSPATH . 'wp-admin/includes/media.php');

// $attach_id = media_handle_upload('topImage', $post_id);
// if (is_numeric($attach_id)) {
//   update_option('option_image', $attach_id);
//   update_post_meta($post_id, '_topImage', $attach_id);
// }
?>

<div class="app-content content ecommerce-application create-top-page">
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
            <div class="top-form-wrapper tabs tab hidden">

              <!-- TITLE, CATEGORY -->
              <div class="form-group">
                <input type="text" name="top-title" id="top-title" placeholder="Title" value="">
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
              <!-- QUESTION -->
              <input type="text" name="top-question" id="top-question" placeholder="Question">
              <!-- DESCRIPTION -->
              <input type="text" name="top-description" id="top-description" placeholder="Description">
              <!-- IMAGE -->
              <div class="image-upload-wrapper" data-text="Déposez l'image ici ou cliquez pour la télécharger.">
                <input name="top-image" type="file" class="top-image" id="top-image" value="" onchange="uploadFile(this)" accept="image/*" multiple="false">
                <br><br><br>
                <img id="output" width="100" height="100" />
              </div>

            </div>

            <div class="contenders-form-wrapper tabs tab show">
              <div class="image-upload-wrapper" data-text="Déposez l'image ici ou cliquez pour la télécharger.">
                <input name="file-upload-field" type="file" class="file-upload-field" value="" accept="image/*" onchange="uploadFiles(this)" multiple>
              </div>

              <div class="images"></div>

              <a href="#" class="btn btn-primary mt-3" id="soumettre">Soumettre</a>
            </div>

            <div class="finish-wrapper tabs tab hidden">Youpi</div>

          </form>

          <p class="alert d-none">
            <i class="fa fa-exclamation-triangle" aria-hidden="true"></i>
            Concentre-toi et rempli bien tous les champs 😝
          </p>

          <div class="paginate">
            <a href="#" class="prec" data-index="0">Précedent</a>
            <a href="#" class="suivant" data-index="0">Suivant</a>
          </div>
        </div>
      </section>
    </div>
  </div>
</div>

<script>
  function uploadFile(target) {
    target.parentElement.dataset.text = target.files[0].name;
    var output = document.getElementById('output');
    output.src = URL.createObjectURL(target.files[0]);
    output.onload = function() {
      URL.revokeObjectURL(output.src)
    }
  }

  function uploadFiles(target) {
    const images = document.querySelector('.images');

    let text = "";
    for (const image in target.files) {
      if(target.files[image].name && target.files[image].type) {
        text += target.files[image].name + ", ";

        images.insertAdjacentHTML('beforeend', `
          <input type="text" class="imageName" value="${(target.files[image].name).split('.')[0]}" />
          <img id="outputo-${target.files[image].name}" width="100" height="100" style="margin-top: 1rem;" /><br>
        `)

        var outputo = document.getElementById(`outputo-${target.files[image].name}`);
        outputo.src = URL.createObjectURL(target.files[image]);
        outputo.onload = function() {
          URL.revokeObjectURL(outputo.src) // free memory
        }
      }
    }

    document.querySelector('#soumettre').addEventListener('click', function() {
      const imagesNames = document.querySelectorAll('.imageName');

      imagesNames.forEach((imageInput, index) => {
        console.log(imageInput.value)
        target.files[index].title = imageInput.value
      })

      console.log(target.files);
    })
      
    target.parentElement.dataset.text = text.slice(0, -2);
  }
</script>

<?php get_footer(); ?>