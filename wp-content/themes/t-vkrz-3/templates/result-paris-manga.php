<?php
/*
    Template Name: Paris Manga
*/
global $user_id;
global $user_infos;
get_header();
?>
<div class="app-content content evolution">
    <div class="content-wrapper">
        <div class="content-body">
            <section id="pricing-plan">
                <div class="text-center">
                    <div class="logopm">
                        <img src="https://www.dcplanet.fr/wp-content/uploads/2020/02/logo-parismang.png" class="img-fluid" alt="">
                    </div>
                    <h1 class="mt-1">
                        Résultats des Tops sponso 🥶
                    </h1>
                    <p class="mb-4 mt-3">
                        Déjà un grand MERCI 🙏 à tous ceux qui sont venus découvrir le concept de VAINKEURZ à notre stand.
                        <br><br>
                        Ce fut un <span class="t-rose">immense Kiff </span> pour toute l'équipe de vous rencontrer et vous présenter notre concept pour notre première convention 🥰
                        <br>
                        On redouble de motivation pour <span class="t-rose">créer de nouveaux Tops</span> et chercher des collab pour vous faire <span class="t-rose">gagner des lots de folie</span> 🤩
                    </p>
                </div>

                <div class="row pricing-card">
                    <div class="col-12">
                        <div class="row match-height">

                            <?php if (have_rows('liste_des_tops_sponso_resultats')) : ?>

                                <?php while (have_rows('liste_des_tops_sponso_resultats')) : the_row(); ?>

                                    <div class="col-12 col-md-4">
                                        <div class="card basic-pricing text-center">
                                            <div class="card-body">
                                                <div class="pricing-badge text-right">
                                                    <div class="badge badge-pill badge-light-primary">
                                                        <?php the_sub_field('participations_result'); ?> participations
                                                    </div>
                                                </div>
                                                <div class="eh">
                                                    <span class="ico-master">
                                                        <?php the_sub_field('icone_principale_result'); ?>
                                                    </span>
                                                </div>
                                                <h3>
                                                    <?php the_sub_field('titre_result'); ?>
                                                </h3>
                                                <p class="card-text eh2">
                                                    <?php the_sub_field('question_result'); ?>
                                                </p>
                                                <div class="annual-plan">
                                                    <div class="plan-price mt-2 d-flex align-items-center justify-content-center">
                                                        <div class="need">
                                                            <span class="pricing-basic-value text-rose d-block mb-1">
                                                                Le gagnant est 👇
                                                            </span>
                                                            <span class="pricing-basic-value font-weight-bolder text-primary">
                                                                <?php the_sub_field('email_gagnant_result'); ?>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <a href="<?php the_permalink(get_sub_field('id_du_ranking_result')); ?>/" class="btn btn-primary mt-1">
                                                    Voir son Top
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                <?php endwhile; ?>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <div class="row mt-5 match-height">

                    <div class="col-md-4 offset-md-1">

                        <div class="bloc-result">
                            <h3>
                                🍀
                                <br>
                                Voici la vidéo du tirage au sort en live 🎥
                            </h3>

                            <div class="video">

                                <?php the_field('embed_du_loom_result'); ?>

                            </div>
                        </div>

                    </div>

                    <div class="col-md-4 offset-md-1">

                        <div class="bloc-result">
                            <h3>
                                🏆
                                <br>
                                La ParisManga continue avec le Top du meilleur Cosplay
                                <br>
                                <span class="t-rose">A toi de voter 👇</span>
                            </h3>

                            <a href="https://vainkeurz.com/t/cosplay/">
                                <img src="<?php bloginfo('template_directory'); ?>/assets/images/vkrz/cosplaytop.png" class="img-fluid" alt="">
                            </a>
                        </div>

                    </div>

                </div>

                <div class="row mt-5 match-height">

                    <div class="col-12">

                        <div class="bloc-result">
                            <h3>
                                Si on restait connecté ? 🤜 🤛
                            </h3>
                            <div class="mt-10p">
                                <a href="https://discord.gg/w882sUnrhE" class="sociallink btn btn-outline-primary waves-effect mr-10p mt-10p" target="_blank">
                                    Discord
                                </a>
                                <a href="https://www.instagram.com/wearevainkeurz/" class="sociallink btn btn-outline-primary waves-effect mr-10p mt-10p" target="_blank">
                                    Insta
                                </a>
                                <a href="https://twitter.com/Vainkeurz" class="sociallink btn btn-outline-primary waves-effect mr-10p mt-10p" target="_blank">
                                    Twitter
                                </a>
                                <a href="https://www.tiktok.com/@vainkeurz" target="_blank" class="sociallink btn btn-outline-primary waves-effect mt-10p">
                                    TikTok
                                </a>
                            </div>

                        </div>

                    </div>

            </section>
        </div>
    </div>
</div>
<!-- END: Content-->
<?php get_footer(); ?>