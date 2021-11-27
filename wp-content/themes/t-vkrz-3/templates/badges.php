<?php
/*
    Template Name: Trophés
*/
get_header();
?>
<div class="app-content content evolution">
    <div class="content-wrapper">
        <div class="content-body">
            <section id="pricing-plan">
                <div class="text-center">
                    <h1 class="mt-5">
                        🏅 Les Trophés disponibles🏅
                    </h1>
                    <p class="mb-4 mt-3">
                        Réalise des actions spécifiques pour ajouter des Trophés à ta collection !
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
                                    <div class="card basic-pricing text-center">
                                        <div class="card-body">
                                            <div class="eh">
                                                <span class="ico-master">
                                                    <?php the_field('symbole_badge', 'badges_'.$badge->term_id); ?>
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
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
</div>
<!-- END: Content-->
<?php get_footer(); ?>