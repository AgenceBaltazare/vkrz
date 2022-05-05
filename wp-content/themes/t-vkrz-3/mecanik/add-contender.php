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

<link rel="stylesheet" type="text/css" href="<?php bloginfo('template_directory'); ?>/assets/css/plugins/forms/form-file-uploader.css">

<div class="app-content content recrutement-page">
  <div class="content-wrapper">
    <div class="content-body">
      <div class="content-monitor">
        <div class="container">
          <div class="row mt-5">
            <div class="col-md-8 offset-md-2">

              <h1 class="text-uppercase text-center" id="h1-ajout-contender">
                <?php the_title(); ?> 🤟
              </h1>

              <div class="row mt-3">
                <div class="col-md-6">
                  <?php
                  $posts = get_field('id_du_top_add_contender');
                  if ($posts) :
                  ?>
                    <div class="card animate__animated animate__flipInX card-developer-meetup">
                      <div class="card-body rules-content">
                        <div class="mb-1">
                          <?php
                          foreach ($posts as $post) :
                            setup_postdata($post);
                          ?>
                            <div class="title-win">
                              <h4>
                                <?php the_field('titre_de_la_sponso_t_sponso'); ?>
                              </h4>
                            </div>
                          <?php
                          endforeach;
                          wp_reset_postdata();
                          ?>
                        </div>
                        <div class="text-rules">
                          <?php the_content(); ?>
                        </div>
                      </div>
                      <?php
                      foreach ($posts as $post) :
                        setup_postdata($post);
                      ?>
                        <div class="card-footer share-content-sponso">
                          <div class="text-left">
                            <p>
                              <?php the_field('top_propose_par_t_sponso'); ?>
                            </p>
                          </div>
                          <div class="d-flex align-items-center reseaux-sponso m-0">
                            <div class="logo-vkrz-sponso">
                              <?php
                              if (get_field('logo_de_la_sponso_t_sponso')) : ?>
                                <a href="<?php the_field('lien_de_la_sponso_t_sponso'); ?>" target="_blank">
                                  <?php echo wp_get_attachment_image(get_field('logo_de_la_sponso_t_sponso', $id_top), 'large', '', array('class' => 'img-fluid')); ?>
                                </a>
                              <?php endif; ?>
                            </div>
                            <div class="mt-2 social-media-sponso">
                              <div class="d-flex buttons-social-media">
                                <?php if (have_rows('liste_des_liens_t_sponso')) : ?>
                                  <?php while (have_rows('liste_des_liens_t_sponso')) : the_row(); ?>
                                    <a href="<?php the_sub_field('lien_vers_t_sponso'); ?>" class="w-100 animate__jello animate__animated animate__delay-1s btn btn-max btn-outline-primary waves-effect waves-float waves-light" target="_blank">
                                      <?php the_sub_field('intitule_t_sponso'); ?>
                                    </a>
                                  <?php endwhile; ?>
                                <?php endif; ?>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="card-footer text-center p-20 m-0">
                          <span class="t-rose">
                            <?php the_field('fin_de_la_sponso_t_sponso'); ?>
                          </span>
                        </div>
                      <?php
                          endforeach;
                          wp_reset_postdata();
                      ?>
                    </div>
                  <?php endif; ?>
                </div>
                <div class="col-md-6">
                  <div class="typeform">
                    <form method="POST" id="form-ajout-contender" enctype="multipart/form-data">

                      <div class="form-group">
                        <input type="hidden" class="form-control p-2" id="idphoto" name="idphoto" placeholder="ID Photo" value="<?= uniqid() ?>">
                      </div>

                      <!-- <div class="form-group input-group-lg dropzone dropzone-area" id="dpz-single-file">
                        <input type="file" class="form-control p-2" id="url_visual" name="url_visual" placeholder="URL Visual">
                        <div class="dz-message text-center pb-3">Déposez le fichier ici ou cliquez pour le télécharger.</div>
                      </div> -->

                      <!-- <input type="file" class="inputfile form-control" name="url_visual" id="url_visual"> -->

                      <div class="dropzone-area">
                        <input type="file" class="inputfile" onchange='uploadFile(this)' name="url_visual" id="url_visual">
                        <label for="file" class="pt-5">
                          <span class="dz-message text-center pb-3" id="file-name">Déposez le fichier ici ou cliquez pour le télécharger.</span>
                        </label>
                      </div>

                      <div class="form-group input-group-lg mt-1">
                        <input type="text" class="form-control p-2" id="pseudo" name="pseudo" placeholder="Pseudo">
                      </div>

                      <div class="form-group input-group-lg">
                        <input type="mail" class="form-control p-2" id="mail" name="mail" placeholder="Adresse mail">
                      </div>

                      <!-- <div class="form-group input-group-lg">
                            <input type="number" class="form-control p-2" id="id_top" name="id_top" placeholder="ID Top">
                          </div> -->

                      <div class="form-group input-group-lg">
                        <?php
                        if (get_field('id_du_top_add_contender')) : ?>
                          <input type="hidden" class="form-control p-2" id="id_top" name="id_top" value="<?php the_field('id_du_top_add_contender'); ?>">
                        <?php endif; ?>
                      </div>

                      <div class="text-center mt-2">
                        <button type="submit" name="envoyer" id="ajout-contender" class="btn btn-primary btn-lg">Envoyer</button>
                      </div>

                    </form>

                    <div class="notification mt-2" style="display: none;">
                      <div class="notification-text">
                        <span style="font-size: 1.5rem;">Votre visuel a été ajouté au Top avec succès ! 🚀</span>
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
  </div>
</div>

<!-- <script src="<?php bloginfo('template_directory'); ?>/assets/vendors/js/extensions/dropzone.min.js"></script> -->
<script>
  function uploadFile(target) {
	  document.getElementById("file-name").innerHTML = target.files[0].name;
  }
</script>
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

      $('#ajout-contender').html('Envoi en cours...');

      $.ajax({
        url: "<?= 'https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']; ?>",
        method: "POST",
        processData: false,
        contentType: false,
        data: formData,
        success: function(data) {
          $.ajax({
            // GET THE CONTENDER ONLINE 2️⃣

            /* 
              TO PREPARE THE IMAGE URL HERE'S THE ORIGINAK LINK : https://localhost:7882/vkrz/wp-content/uploads/2022/03/banniere-2.png
            */

            url: "https://vainkeurz.com/wp-json/vkrz/v1/addcontender",
            method: "GET",
            data: {
              idphoto: form.find('#idphoto').val(),
              url_visual: "<?= 'https://' . $_SERVER['HTTP_HOST'] . "/wp-content/uploads/" . date("Y") . '/' . date('m') . '/' ?>" + document.getElementById("url_visual").files[0].name,
              pseudo: form.find('#pseudo').val(),
              mail: form.find('#mail').val(),
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