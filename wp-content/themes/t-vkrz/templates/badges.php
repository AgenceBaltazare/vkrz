<?php
/*
    Template Name: Trophées
*/
global $id_vainkeur;
get_header();
?>

<section id="pricing-plan">
    <div class="text-center">
        <h1>
            <span class="va va-sports-medal va-1x"></span> Les Trophées disponibles <span class="va va-sports-medal va-1x"></span>
        </h1>
        <p class="mb-4 mt-3">
            Réalise des actions spécifiques pour ajouter des Trophées à ta collection !
        </p>
    </div>

    <div class="row pricing-card">
        <div class="col-12">
            <div class="row match-height">

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
</section>

<?php get_footer(); ?>