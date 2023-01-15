<?php
global $uuid_who_did_toplist;
global $uuid_vainkeur;
global $vainkeur_data_selected;
global $id_ranking;
global $id_top_global;
?>
<div class="offcanvas offcanvas-end bg-deg" id="topeur">
  <div class="offcanvas-header">
    <h5 id="offcanvasScrollLabel" class="offcanvas-title">
      <span class="va va-trophy va-lg"></span> Qui a fait cette TopList ?
    </h5>
    <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
  </div>
  <div class="offcanvas-body my-auto mx-0 flex-grow-0">
    <div class="presentationtop">

      <h6 class="text-center">Cette TopList a été faîte le <span class="t-violet"><?php echo get_the_date('d/m/Y', $id_ranking); ?></span> par : </h6>

      <div class="employee-task d-flex justify-content-between align-items-center">

        <?php get_template_part('partials/vainkeur-card'); ?>

        <?php if ($vainkeur_data_selected['user_role'] != "anonyme") : ?>
          
          <?php if (is_user_logged_in()) : ?>

            <?php if ($vainkeur_data_selected && get_current_user_id() != $vainkeur_data_selected['id_user']) : ?>

              <button type="button" id="followBtn" class="btn waves-effect btn-follow d-none btn btn-outline-primary" data-userid="<?= get_current_user_id(); ?>" data-uuid="<?= get_field('uuiduser_user', 'user_' . get_current_user_id()); ?>" data-relatedid="<?= $vainkeur_data_selected['id_user']; ?>" data-relateduuid="<?= get_field('uuiduser_user', 'user_' . $vainkeur_data_selected['id_user']); ?>" data-text="<?= get_the_author_meta('nickname', get_current_user_id()); ?> te guette !" data-url="<?= get_author_posts_url(get_current_user_id()); ?>">
                <span class="wording">Guetter</span>
                <span class="va va-guetteur-close va va-z-20 emoji"></span>
              </button>

            <?php endif; ?>

          <?php else : ?>

            <a href="<?php the_permalink(get_page_by_path('se-connecter')); ?>" class="btn btn-flat-secondary waves-effect btn-outline-primary" data-toggle="tooltip" data-placement="top" title="" data-original-title="Tu dois être connecté pour guetter <?php echo $vainkeur_data_selected['pseudo']; ?>">
              <span class="text-muted">
                <span class="wording">Guetter</span> <span class="va va-guetteur-close va va-z-20 emoji"></span>
              </span>
            </a>

          <?php endif; ?>

        <?php endif; ?>
      </div>

      <div class="separate mt-4 mb-4"></div>

      <div class="vs-resemblance" data-idranking="<?= $id_ranking; ?>" data-idtop="<?= $id_top_global; ?>">
        <div class="loader loader--style1 w-100 mx-auto mt-1 text-center" title="0">
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
      </div>
    </div>
  </div>
</div>