<?php
/*
    Template Name: Trophées
*/
global $id_vainkeur;
get_header();
?>
<div class="app-content content evolution">
    <div class="content-wrapper">
        <div class="content-body">
            <section id="pricing-plan">
                <div class="text-center">
                    <h1 class="mt-5">
                        🏅 Les Trophées disponibles🏅
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
                                <div class="col-12 col-md-4">
                                    <div class="card basic-pricing text-center <?php if (get_vainkeur_badge($id_vainkeur, $badge->name)) : ?>popular<?php endif; ?>">
                                        <?php if (get_vainkeur_badge($id_vainkeur, $badge->name)) : ?>
                                            <div class="pricing-badge text-right">
                                                <div class="badge badge-pill badge-light-primary">Trophée obtenu</div>
                                            </div>
                                        <?php endif; ?>
                                        <div class="card-body">
                                            <div class="eh">
                                                <span class="ico-master">
                                                    <?php the_field('symbole_badge', 'badges_' . $badge->term_id); ?>
                                                </span>
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
                            <div class="col-12 col-md-4">
                                <div class="card basic-pricing text-center">
                                    <div class="card-body">
                                        <div class="eh">
                                            <span class="ico-master">
                                                🥷
                                            </span>
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
                            <div class="col-12 col-md-4">
                                <div class="card basic-pricing text-center">
                                    <div class="card-body">
                                        <div class="eh">
                                            <span class="ico-master">
                                                🦸‍♀️
                                            </span>
                                        </div>
                                        <h3>
                                            e masqué
                                        </h3>
                                        <p class="card-text eh2">
                                            Se dévoile à une seule condition
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-4">
                                <div class="card basic-pricing text-center">
                                    <div class="card-body">
                                        <div class="eh">
                                            <span class="ico-master">
                                                🌫
                                            </span>
                                        </div>
                                        <h3>
                                            Trophée caché
                                        </h3>
                                        <p class="card-text eh2">
                                            Jusqu'à sa découverte
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
                                            <h3 class="mb-2">💡 Proposes <span class="t-rose">ton idée de Trophée</span> <br>& si c'est cool, nous l'ajouterons à la liste</h3>
                                            <a href="<?php the_permalink(get_template_part('proposition-de-trophe')); ?>/" class="btn btn-primary waves-effect">
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
        </div>
    </div>
</div>
<!-- END: Content-->
<?php get_footer(); ?>