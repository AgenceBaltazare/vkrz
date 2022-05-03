<?php /* Template Name: Ajouter un contenders */ ?>
<?php /* CETTE PAGE EST ACTUELLEMENT EN COURS DE FINITION. DES CHANGEMENTS PEUVENT ÊTRE EFFECTUER ! ⛔ */ ?>

<?php
// TO SAVE THE IMAGE IN MEDIA LIBRARY
function register_team_show_case_setting()
{
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
// URL OF IMAGE : echo wp_get_attachment_url(get_option('option_image'));

global $uuiduser;
global $user_id;
global $user_infos;
get_header();
if (false === ($data_t_created = get_transient('user_' . $user_id . '_get_creator_t'))) {
  $data_t_created = get_creator_t($user_id);
  set_transient('user_' . $user_id . '_get_creator_t', $data_t_created, DAY_IN_SECONDS);
} else {
  $data_t_created = get_transient('user_' . $user_id . '_get_creator_t');
}
?>

<!-- IMPORTING BOOTSTRAP-SELECT -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/js/bootstrap-select.min.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/css/bootstrap-select.min.css" rel="stylesheet" />

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

                  <div class="form-group">
                    <input type="hidden" class="form-control p-2" id="idphoto" name="idphoto" placeholder="ID Photo" value="<?= uniqid() ?>">
                  </div>

                  <div class="form-group input-group-lg">
                    <input type="file" class="form-control p-2" id="url_visual" name="url_visual" placeholder="URL Visual">
                  </div>

                  <div class="form-group input-group-lg">
                    <input type="text" class="form-control p-2" id="pseudo" name="pseudo" placeholder="Pseudo">
                  </div>

                  <!-- <div class="form-group input-group-lg">
                    <input type="number" class="form-control p-2" id="id_top" name="id_top" placeholder="ID Top">
                  </div> -->

                  <div class="form-group input-group-lg">
                    <select name="id_top" id="id_top" class="selectpicker" data-live-search="true" data-hide-disabled="true" data-width="100%" title="Sélectionnez ton Top">
                      <?php
                      foreach ($data_t_created['creator_tops'] as $item) : ?>
                        <?php if (!get_field('private_t', $item['top_id'])) : ?>
                          <option value="<?= $item['top_id']; ?>" data-tokens="<?= $item['top_title']; ?>"><?= $item['top_title']; ?></option>
                        <?php endif; ?>
                      <?php endforeach; ?>
                    </select>
                  </div>

                  <div class="text-center mt-2">
                    <button type="submit" name="envoyer" id="ajout-contender" class="btn btn-primary btn-lg">Envoyer</button>
                  </div>
                </form>

                <div class="notification mt-2" style="display: none;">
                  <div class="notification-text">
                    <span style="font-size: 1.5rem;">Contender added successfully! 🚀</span>
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

<script>
  $(document).ready(function($) {

    $(function() {
      $('#selectpicker').selectpicker();
    });

    var form = $('#form-ajout-contender');

    form.submit(function(e) {

      e.preventDefault();

      // SAVE THE IMAGE IN MEDIA LIBRARY, SO THAT IMAGE'S URL WORKS! 1️⃣
      let file = $('#url_visual')[0].files[0]
      let formData = new FormData();
      formData.append('url_visual', file);

      $.ajax({
        url: "<?= 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']; ?>",
        method: "POST",
        processData: false,
        contentType: false,
        data: formData,
        success: function(data) {
          $.ajax({
            // GET THE CONTENDER ONLINE 2️⃣

            /* 
              TO PREPARE THE IMAGE URL HERE'S THE ORIGINAL LINK : http://localhost:7882/vkrz/wp-content/uploads/2022/03/banniere-2.png
            */

            url: "https://vainkeurz.com/wp-json/vkrz/v1/addcontender",
            method: "GET",
            data: {
              idphoto: form.find('#idphoto').val(),
              url_visual: "<?= 'http://' . $_SERVER['HTTP_HOST'] . "/vkrz/wp-content/uploads/" . date("Y") . '/' . date('m') . '/' ?>" + document.getElementById("url_visual").files[0].name,
              pseudo: form.find('#pseudo').val(),
              id_top: form.find('#id_top').val()
            },
          })
        }
      }).done(function(response) {
        form.hide();
        $(".notification").show();

      }).always(function() {

      });
    });
  });
</script>

<?php get_footer(); ?>