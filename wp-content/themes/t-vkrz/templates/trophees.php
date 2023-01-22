<?php
/*
  Template Name: Trophées
*/
global $id_vainkeur;
get_header();
?>
<div class="my-3">
  <div class="container-xxl">
    <div class="intro-archive">
      <div class="iconarchive">
        <span class="va-sports-medal va va-z-17"></span>
      </div>
      <h1>
        Les Trophées disponibles
      </h1>
      <h2>
        Réalise des actions spécifiques pour ajouter des Trophées à ta collection !
      </h2>
    </div>
  </div>
  <div class="container-xxl">
    <div class="pricing-card row match-height">
      <?php
      $all_badges = get_terms(array(
        'taxonomy' => 'badges',
        'hide_empty' => false,
      ));
      foreach ($all_badges as $badge) : ?>
        <div class="col-6 col-md-4 col-lg-3">
          <div class="card basic-pricing text-center <?php if (get_vainkeur_badge($id_vainkeur, $badge->name)) : ?>popular<?php endif; ?>">
            <?php if (get_vainkeur_badge($id_vainkeur, $badge->name)) : ?>
              <div class="pricing-badge text-right">
                <div class="badge badge-pill badge-light-primary">Trophée obtenu</div>
              </div>
            <?php endif; ?>
            <div class="card-body">
              <div>
                <div class="ico-master ico-badge">
                  <?php the_field('symbole_badge', 'badges_' . $badge->term_id); ?>
                </div>
              </div>
              <h3>
                <?php echo $badge->name; ?>
              </h3>
              <p class="card-text eh2">
                <?php echo $badge->description; ?>
              </p>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
      <div class="col-6 col-md-4 col-lg-3">
        <div class="card basic-pricing text-center <?php if (is_user_logged_in()) : ?>popular<?php endif; ?>">
          <?php if (is_user_logged_in()) : ?>
            <div class="pricing-badge text-right">
              <div class="badge badge-pill badge-light-primary">Trophée obtenu</div>
            </div>
          <?php endif; ?>
          <div class="card-body">
            <div>
              <div class="ico-master ico-badge">
                <span class="va va-lama va-1x"></span>
              </div>
            </div>
            <h3>
              Être un Vainkeur
            </h3>
            <p class="card-text eh2">
              Créer son compte
            </p>
          </div>
        </div>
      </div>
      <div class="col-6 col-md-4 col-lg-3">
        <div class="card basic-pricing text-center">
          <div class="card-body">
            <div>
              <div class="ico-master ico-badge">
                <span class="va va-ninja va-1x"></span>
              </div>
            </div>
            <h3>
              Trophée secret
            </h3>
            <p class="card-text eh2">
              Arrivera sans prévenir
            </p>
          </div>
        </div>
      </div>
      <div class="col-6 col-md-4 col-lg-3">
        <div class="card basic-pricing text-center">
          <div class="card-body">
            <div>
              <div class="ico-master ico-badge">
                <span class="va va-ninja va-1x"></span>
              </div>
            </div>
            <h3>
              Trophée secret
            </h3>
            <p class="card-text eh2">
              Arrivera sans prévenir
            </p>
          </div>
        </div>
      </div>
      <div class="col-6 col-md-4 col-lg-3">
        <div class="card basic-pricing text-center">
          <div class="card-body">
            <div>
              <div class="ico-master ico-badge">
                <span class="va va-ninja va-1x"></span>
              </div>
            </div>
            <h3>
              Trophée secret
            </h3>
            <p class="card-text eh2">
              Arrivera sans prévenir
            </p>
          </div>
        </div>
      </div>
    </div>
    <div class="row mt-2">
      <div class="col-md-8 offset-md-2">
        <div class="cta">
          <div class="card basic-pricing text-center">
            <div class="card-body">
              <h3 class="mb-2"><span class="va va-light-bulb va-lg"></span> Proposes <span class="t-rose">ton idée de Trophée</span> <br>& si c'est cool, nous l'ajouterons à la liste</h3>
              <a href="<?php the_permalink(get_page_by_path('proposition-de-trophe')); ?>/" class="btn btn-primary waves-effect">
                Proposer mon Trophée
              </a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<?php get_footer(); ?>