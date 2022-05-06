<?php /* Template Name: Ajouter un contenders */ ?>

<?php

// PREVENT WordPress FROM CHANGING THE IMAGE SIZE
/**
 * @param array $sizes    An associative array of image sizes.
 * @param array $metadata An associative array of image metadata: width, height, file.
 */
function remove_image_sizes($sizes, $metadata)
{
  return [];
}
add_filter('intermediate_image_sizes_advanced', 'remove_image_sizes', 10, 2);

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

// FUNCTION TO GET A RANDOM WORD FOR THE IMAGE TITLE TO AVOID CONFLICTS
function randWord($length = 4)
{
  return substr(str_shuffle("qwertyuiopasdfghjklzxcvbnm"), 0, $length);
}
$randomWord = randWord();

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

<link rel="stylesheet" type="text/css" href="<?php bloginfo('template_directory'); ?>/assets/css/plugins/forms/form-file-uploader.css">

<div class="app-content content ajout-contender-page">
  <div class="content-wrapper">
    <div class="content-body">
      <div class="content-monitor">
        <div class="container">
          <div class="row mt-2">
            <div class="col-md-12">

              <h1 class="text-center" id="h1-ajout-contender">
                <?php the_title(); ?> <span class="va va-sign-of-the-horns va-lg"></span>
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

                <div class="col-md-6 my-auto">
                  <div class="typeform">
                    <form method="POST" id="form-ajout-contender" enctype="multipart/form-data">

                      <div class="form-group">
                        <input type="hidden" class="form-control p-2" id="idphoto" name="idphoto" placeholder="ID Photo" value="<?= uniqid() ?>">
                      </div>

                      <div class="dropzone-area">
                        <input type="file" class="inputfile" onchange='uploadFile(this)' name="url_visual" id="url_visual" required accept="image/*">
                        <label for="file">
                          <span class="dz-message text-center p-1" id="file-name">Déposez l'image ici ou cliquez pour la télécharger.</span>
                        </label>
                      </div>

                      <div class="form-group input-group-lg mt-1">
                        <input type="text" class="form-control p-2" id="pseudo" name="pseudo" placeholder="Pseudo" required onchange="uploadFile(this)">
                      </div>

                      <div class="form-group input-group-lg">
                        <input type="email" class="form-control p-2" id="email" name="email" placeholder="Adresse mail" required>
                      </div>

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

                    <div class="overlay" style="display: none;"></div>

                    <div class="notification rotate-in-center" style="display: none;">
                      <button class="closeNotification">&times;</button>

                      <div class="notification-text">
                        <span class="va va-grinning-face-with-smiling-eyes va-5x"></span> <br>
                        <h3>Bravo!</h3>
                        <p>Nous avons bien reçu ton visuel.</p>
                        <a href="#" class="btn btn-lg waves-effect waves-float waves-light">Bouton</a>
                      </div>
                    </div>

                    <div class="notification-2" style="display: none;">
                      Nous reviendrons vers toi dans moins de 24h pour te confirmer ta participation au Top.
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

<script>
  function uploadFile(target) {
    document.getElementById("file-name").innerHTML = target.files[0].name;
    document.getElementById("pseudo").value = target.files[0].name.charAt(0).toUpperCase() + target.files[0].name.slice(1).split('.').slice(0, -1).join('.');
  }

  $(document).ready(function($) {
    let form = $('#form-ajout-contender');

    $('.closeNotification').click(function() {
      $('.notification').hide();
      $('.overlay').hide();
    })

    form.submit(function(e) {
      e.preventDefault();

      // PROCESS TO RENAME THE IMAGE
      let imgType = document.getElementById("url_visual").files[0].name.split('.').pop().toLowerCase();
      let element = document.getElementById('url_visual');
      let file = element.files[0];
      let blob = file.slice(0, file.size, `image/${imgType}`);
      let newImgFileName = new File([blob], `<?php echo $randomWord; ?>.${imgType}`, {
        type: `image/${imgType}`
      });

      let formData = new FormData();
      formData.append('url_visual', newImgFileName);

      $('#ajout-contender').html('Envoi en cours...');

      $.ajax({
        // SAVE THE IMAGE IN THE MEDIA LIBRARY, SO WE CAN GET THE LINK 1️⃣
        url: "<?= 'https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']; ?>",
        method: "POST",
        processData: false,
        contentType: false,
        data: formData,
        success: function(data) {
          $.ajax({
            // GET THE CONTENDER ONLINE 2️⃣
            url: "https://vainkeurz.com/wp-json/vkrz/v1/addcontender",
            method: "GET",
            data: {
              idphoto: form.find('#idphoto').val(),
              url_visual: "<?= 'https://' . $_SERVER['HTTP_HOST'] . "/wp-content/uploads/" . date("Y") . '/' . date('m') . '/' . $randomWord . '.' ?>" + imgType,
              pseudo: form.find('#pseudo').val(),
              email: form.find('#email').val(),
              id_top: form.find('#id_top').val()
            },
          })
        }
      }).done(function(response) {
        $('.overlay').show();
        form.hide();
        $(".notification").show();
        $(".notification-2").show();
      }).always(function() {});
    });
  });
</script>

<?php get_footer(); ?>