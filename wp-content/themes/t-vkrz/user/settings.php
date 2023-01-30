<?php
/*
  Template Name: User settings
*/
get_header(); ?>
<!-- Content wrapper -->
<div class="content-wrapper content-compte">
  <!-- Content -->
  <div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">
      <!-- User Sidebar -->
      <div class="col-xl-3 col-lg-4 col-md-4">
        <!-- User cover -->
        <?php get_template_part('partials/profil'); ?>
        <!-- User cover -->
      </div>
      <!--/ User Sidebar -->

      <!-- User Content -->
      <div class="col-xl-9 col-lg-8 col-md-8">

        <!-- Menu compte -->
        <?php get_template_part('partials/menu-profil'); ?>
        <!-- /Menu compte -->

        <!-- Détails des KEURZ -->
        <section class="detailskeurz">
          <ul class="nav nav-tabs" role="tablist">
            <li class="nav-item">
              <a class="nav-link active" id="homeIcon-tab" data-bs-toggle="tab" href="#tab1" aria-controls="home" role="tab" aria-selected="true">
                Infos générales
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" id="profileIcon-tab" data-bs-toggle="tab" href="#tab2" aria-controls="profile" role="tab" aria-selected="false">
                Mes réZeaux
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" id="profileIcon-tab" data-bs-toggle="tab" href="#tab3" aria-controls="profile" role="tab" aria-selected="false">
                Gérer les Identifiants
              </a>
            </li>
          </ul>
          <div class="tab-content bg-card">
            <div class="tab-pane active" id="tab1" aria-labelledby="homeIcon-tab" role="tabpanel">

              <?php echo do_shortcode('[wppb-edit-profile form_name="presentation"]'); ?>

            </div>
            <div class="tab-pane" id="tab2" role="tabpanel" aria-labelledby="tab2">

              <?php echo do_shortcode('[wppb-edit-profile form_name="reseaux"]'); ?>

            </div>
            <div class="tab-pane" id="tab3" role="tabpanel" aria-labelledby="tab3">

              <div class="auth-register-form">
                <div class="classic-form">
                  <?php echo do_shortcode('[wppb-edit-profile form_name="parametres"]'); ?>
                </div>
              </div>

            </div>

          </div>
        </section>
        <!-- /Détails des KEURZ -->
      </div>
      <!-- /User Content -->
    </div>
  </div>
  <!-- /Content -->
  <div class="content-backdrop fade"></div>
</div>
<!-- Content wrapper -->
<?php get_footer(); ?>