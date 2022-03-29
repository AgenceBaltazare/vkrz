<?php /* Template Name: Ajouter Contenders */ ?>
<?php /* CETTE PAGE EST ACTUELLEMENT EN COURS DE FINITION. DES CHANGEMENTS PEUVENT ÊTRE EFFECTUER ! ⛔ */ ?>

<?php get_header(); ?>

<?php if (isset($_REQUEST['envoyer'])) {

  /*
  SOURCE CODE USED :
    https://wordpress.stackexchange.com/questions/228301/how-to-upload-image-from-front-end-and-save-in-media-library
  */

  $idphoto = $_POST['idphoto'];

  // FOR THE IMAGE
  function register_team_show_case_setting()
  {
    //register our settings
    register_setting('my_team_show_case_setting', 'url_visual');
  }
  add_action('admin_init', 'register_team_show_case_setting');

  require_once(ABSPATH . 'wp-admin/includes/image.php');
  require_once(ABSPATH . 'wp-admin/includes/file.php');
  require_once(ABSPATH . 'wp-admin/includes/media.php');

  $attach_id = media_handle_upload('url_visual', $post_id);
  if (is_numeric($attach_id)) {
    update_option('option_image', $attach_id);
    update_post_meta($post_id, '_url_visual', $attach_id);
  }

  // echo wp_get_attachment_url(get_option('option_image'));
  $_POST['url_visual'] = wp_get_attachment_url(get_option('option_image'));
  $url_visual = $_POST['url_visual'];

  // OTHERS
  $pseudo = $_POST['pseudo'];
  $id_top = $_POST['id_top']; ?>

  <script>
    $(document).ready(function($) {

      $.ajax({
        method: "GET",
        url: 'https://bltzr.fr/vkrz/wp-json/vkrz/v1/addcontender',
        data: {
          idphoto: "<?= $idphoto ?>",
          url_visual: "<?= $url_visual ?>",
          pseudo: "<?= $pseudo ?>",
          id_top: "<?= $id_top ?>",
        }
      }).done(function(response) {
        // $(".notification").show();
        <?php echo 'YES'; ?>

      }).always(function() {

      });
    });
  </script>


<?php } ?>


<div class="app-content content recrutement-page">
  <div class="content-wrapper">
    <div class="content-body">
      <div class="content-monitor apropos">
        <div class="container">
          <div class="row mt-5">
            <div class="col-md-8 offset-md-2">

              <h1 class="text-uppercase text-center" id="h1-ajout-contender">
                Ajouter un contender 🤟
              </h1>

              <div class="typeform mt-3">
                <form method="POST" id="form-ajout-contender" enctype="multipart/form-data">

                  <?php
                  /*
                    TO INSERT :
                      idphoto
                      url_visual
                      pseudo
                      id_top
                  */
                  ?>

                  <div class="form-group">
                    <input type="hidden" class="form-control p-2" id="idphoto" name="idphoto" placeholder="ID Photo" value="<?= uniqid() ?>">
                  </div>

                  <div class="form-group input-group-lg">
                    <input type="file" class="form-control p-2" id="url_visual" name="url_visual" placeholder="URL Visual" title="Entrez le lien de l'image">
                  </div>

                  <div class="form-group input-group-lg">
                    <input type="text" class="form-control p-2" id="pseudo" name="pseudo" placeholder="Pseudo">
                  </div>

                  <div class="form-group input-group-lg">
                    <input type="number" class="form-control p-2" id="id_top" name="id_top" placeholder="ID Top">
                  </div>

                  <div class="text-center mt-2">
                    <button type="submit" name="envoyer" id="ajout-contender" class="btn btn-primary btn-lg">Envoyer</button>
                  </div>
                </form>

                <div class="notification mt-2" style="display: none;">
                  <div class="notification-text">
                    <i class="fas fa-check-circle"></i>
                    <span>Contender added successfully! 🚀</span>
                  </div>
                </div>

              </div>

            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<?php get_footer(); ?>