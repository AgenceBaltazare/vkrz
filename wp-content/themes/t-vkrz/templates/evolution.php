<?php
/*
  Template Name: Évolution
*/
global $user_id;
global $infos_vainkeur;
get_header();
$level_user = $infos_vainkeur['level_number'];
?>
<div class="my-3">
  <div class="container-xxl">
    <div class="intro-archive">
      <div class="iconarchive">
        <span class="va-rocket va va-z-17"></span>
      </div>
      <h1>
        Ton projet d'évolution
      </h1>
      <h2>
        En enchaînant les votes et les tops ainsi qu'en optenant des Trophées, tu accumules des <span class="va-mush va va-z-17"></span>.
        <br>
        Voici toutes les étapes à franchir pour devenir légendaire <span class="va va-backhand-index-pointing-down va-z-17"></span>
      </h2>
    </div>
  </div>
  <div class="container-xxl">
    <div class="pricing-card row match-height">
      <div class="col-12 col-md-4">
        <div class="eh3 card basic-pricing text-center <?php echo ($level_user == 0) ? 'popular' : ''; ?>">
          <div class="card-body">
            <?php if ($level_user == 0) : ?>
              <div class="pricing-badge text-right">
                <div class="badge badge-pill badge-light-primary">niveau</div>
              </div>
            <?php endif; ?>
            <div class="eh">
              <span class="ico-master va va-z-85 va-egg"></span>
            </div>
            <h3>Niveau 0</h3>
            <?php if (is_user_logged_in()) : ?>
              <p class="card-text eh2">
                Maintenant que tu fais parti des Vainkeurs, il te faut 50 <span class="ico va-mush va va-lg"></span> pour éclore et passer au niveau 1.
              </p>
            <?php else : ?>
              <p class="card-text eh2">
                Il faut bien commencer quelque part. On t'invite à nous rejoindre pour briser la coquille <span class="va va-hugging-face va-lg"></span>
              </p>
              <a href="<?php the_permalink(get_page_by_path('creer-mon-compte')); ?>" class="btn btn-primary mt-1">
                Créer mon compte <span class="ico va va-party-popper va-lg"></span>
              </a>
            <?php endif; ?>
          </div>
        </div>
      </div>

      <div class="col-12 col-md-4">
        <div class="eh3 card basic-pricing text-center <?php echo ($level_user == 1) ? 'popular' : ''; ?>">
          <div class="card-body">
            <?php if ($level_user == 1) : ?>
              <div class="pricing-badge text-right">
                <div class="badge badge-pill badge-light-primary">niveau</div>
              </div>
            <?php endif; ?>
            <div class="eh">
              <span class="ico-master va va-z-85 va-hatching-chick"></span>
            </div>
            <h3>Niveau 1</h3>
            <p class="card-text eh2">
              La maitrise du concept de VAINKEURZ se fait petit à petit et c'est beau à voir !
            </p>
            <div class="annual-plan">
              <div class="plan-price mt-2 d-flex align-items-center justify-content-center">
                <div class="need">
                  <span class="pricing-basic-value font-weight-bolder text-primary">50 <span class="ico va-mush va va-z-30"></span></span>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="col-12 col-md-4">
        <div class="eh3 card basic-pricing text-center <?php echo ($level_user == 2) ? 'popular' : ''; ?>">
          <div class="card-body">
            <?php if ($level_user == 2) : ?>
              <div class="pricing-badge text-right">
                <div class="badge badge-pill badge-light-primary">niveau</div>
              </div>
            <?php endif; ?>
            <div class="eh">
              <span class="ico-master va va-z-85 va-chick"></span>
            </div>
            <h3>Niveau 2</h3>
            <p class="card-text eh2">
              Ça fait plaisir de te voir grandir et t'approprier de plus en plus VAINKEURZ.
            </p>
            <div class="annual-plan">
              <div class="plan-price mt-2 d-flex align-items-center justify-content-center">
                <div class="need">
                  <span class="pricing-basic-value font-weight-bolder text-primary">500 <span class="ico va-mush va va-z-30"></span></span>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="col-12 col-md-4">
        <div class="eh3 card basic-pricing text-center <?php echo ($level_user == 3) ? 'popular' : ''; ?>">
          <div class="card-body">
            <?php if ($level_user == 3) : ?>
              <div class="pricing-badge text-right">
                <div class="badge badge-pill badge-light-primary">niveau</div>
              </div>
            <?php endif; ?>
            <div class="eh">
              <span class="ico-master va va-z-85 va-rooster"></span>
            </div>
            <h3>Niveau 3</h3>
            <p class="card-text eh2">
              Clairement tu fais parti des Boss de VAINKEURZ maintenant et on est fier de toi <span class="ico va va-star-struck va-lg"></span>
            </p>
            <div class="annual-plan">
              <div class="plan-price mt-2 d-flex align-items-center justify-content-center">
                <div class="need">
                  <span class="pricing-basic-value font-weight-bolder text-primary">2 000 <span class="ico va-mush va va-z-30"></span></span>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="col-12 col-md-4">
        <div class="eh3 card basic-pricing text-center <?php echo ($level_user == 4) ? 'popular' : ''; ?>">
          <div class="card-body">
            <?php if ($level_user == 4) : ?>
              <div class="pricing-badge text-right">
                <div class="badge badge-pill badge-light-primary">niveau</div>
              </div>
            <?php endif; ?>
            <div class="eh">
              <span class="ico-master va va-z-85 va-turkey"></span>
            </div>
            <h3>Niveau 4</h3>
            <p class="card-text eh2">
              Fini la rigolade, maintenant les <span class="ico va va-rooster va-lg"></span> te doivent le respect
            </p>
            <div class="annual-plan">
              <div class="plan-price mt-2 d-flex align-items-center justify-content-center">
                <div class="need">
                  <span class="pricing-basic-value font-weight-bolder text-primary">5 000 <span class="ico va-mush va va-z-30"></span></span>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="col-12 col-md-4">
        <div class="eh3 card basic-pricing text-center  <?php echo ($level_user == 5) ? 'popular' : ''; ?>">
          <div class="card-body">
            <?php if ($level_user == 5) : ?>
              <div class="pricing-badge text-right">
                <div class="badge badge-pill badge-light-primary">niveau</div>
              </div>
            <?php endif; ?>
            <div class="eh">
              <span class="ico-master va va-z-85 va-swan"></span>
            </div>
            <h3>Niveau 5</h3>
            <p class="card-text eh2">
              Atteindre ce niveau, est le signe que tu adhères totalement au concept
            </p>
            <div class="annual-plan">
              <div class="plan-price mt-2 d-flex align-items-center justify-content-center">
                <div class="need">
                  <span class="pricing-basic-value font-weight-bolder text-primary">35 000 <span class="ico va-mush va va-z-30"></span></span>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="col-12 col-md-4">
        <div class="eh3 card basic-pricing text-center <?php echo ($level_user == 6) ? 'popular' : ''; ?>">
          <div class="card-body">
            <?php if ($level_user == 6) : ?>
              <div class="pricing-badge text-right">
                <div class="badge badge-pill badge-light-primary">niveau</div>
              </div>
            <?php endif; ?>
            <div class="eh">
              <span class="ico-master va va-z-85 va-flamingo"></span>
            </div>
            <h3>Niveau 6</h3>
            <p class="card-text eh2">
              Uniquement l'élite atteindra ce niveau - le noyau dur. La crème de la crème <span class="ico va va-smiling-face-with-heart-eyes va-lg"></span>
            </p>
            <div class="annual-plan">
              <div class="plan-price mt-2 d-flex align-items-center justify-content-center">
                <div class="need">
                  <span class="pricing-basic-value font-weight-bolder text-primary">100 000 <span class="ico va-mush va va-z-30"></span></span>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="col-12 col-md-4">
        <div class="eh3 card basic-pricing text-center <?php echo ($level_user == 7) ? 'popular' : ''; ?>">
          <div class="card-body">
            <?php if ($level_user == 7) : ?>
              <div class="pricing-badge text-right">
                <div class="badge badge-pill badge-light-primary">niveau</div>
              </div>
            <?php endif; ?>
            <div class="eh">
              <span class="ico-master va va-z-85 va-peacock"></span>
            </div>
            <h3>Niveau 7</h3>
            <p class="card-text eh2">
              Majestueux - Admirable - Précieux - Tu as poncé le concept et tu mérites tout notre respect !
            </p>
            <div class="annual-plan">
              <div class="plan-price mt-2 d-flex align-items-center justify-content-center">
                <div class="need">
                  <span class="pricing-basic-value font-weight-bolder text-primary">450 000 <span class="ico va-mush va va-z-30"></span></span>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="col-12 col-md-4">
        <div class="eh3 card basic-pricing text-center <?php echo ($level_user == 8) ? 'popular' : ''; ?>">
          <div class="card-body">
            <?php if ($level_user == 8) : ?>
              <div class="pricing-badge text-right">
                <div class="badge badge-pill badge-light-primary">niveau</div>
              </div>
            <?php endif; ?>
            <div class="eh">
              <span class="ico-master va va-z-85 va-dragon"></span>
            </div>
            <h3>Niveau légendaire</h3>
            <p class="card-text eh2">
              Est-il seulement possible qu'un humain atteigne ce niveau ?
            </p>
            <div class="annual-plan">
              <div class="plan-price mt-2 d-flex align-items-center justify-content-center">
                <div class="need">
                  <span class="pricing-basic-value font-weight-bolder text-primary">1 MILLION<span class="ico va-mush va va-z-30"></span></span>
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