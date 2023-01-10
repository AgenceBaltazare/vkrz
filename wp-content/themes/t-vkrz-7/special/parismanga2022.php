<?php
/*
    Template Name: Paris Manga 2022
*/
get_header();
?>

<section id="pricing-plan">

    <div class="text-center">
        <h1 class="mt-1">
            Les cadeaux à gagner sur la convention 🎁🎊
        </h1>
        <p class="mb-4">
            Plusieurs tirages au sort directement sur notre STAND 6️⃣
        </p>
    </div>

    <div class="row pricing-card">
        <div class="col-12">
            <h2 class="t-rose text-center">Samedi 19 mars</h2>
            <div class="row match-height">
                <?php if (have_rows('programme_samedi_parismanga22')) : ?>
                    <?php while (have_rows('programme_samedi_parismanga22')) : the_row(); ?>
                        <div class="col-md-3">
                            <h4 class="text-center mt-1 mb-1"><?php the_sub_field('horaire_parismanga22'); ?></h4>
                            <?php
                            $top_selected       = get_sub_field('liste_des_tops_parismanga22', false, false);
                            $top_selected_query = new WP_Query(array('post_type' => 'tournoi', 'orderby' => 'post__in', 'post__in' => $top_selected, 'posts_per_page' => '1'));
                            while ($top_selected_query->have_posts()) : $top_selected_query->the_post(); ?>
                                <?php get_template_part('partials/min-t'); ?>
                            <?php endwhile;
                            wp_reset_query(); ?>
                        </div>
                    <?php endwhile; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <div class="row pricing-card mt-4 mb-4">
        <div class="col-12">
            <h2 class="t-rose text-center">Dimanche 20 mars</h2>
            <div class="row match-height">
                <?php if (have_rows('programme_dimanche_parismanga22')) : ?>
                    <?php while (have_rows('programme_dimanche_parismanga22')) : the_row(); ?>
                        <div class="col-md-3">
                            <h4 class="text-center mt-1 mb-1"><?php the_sub_field('horaire_parismanga22'); ?></h4>
                            <?php
                            $top_selected       = get_sub_field('liste_des_tops_parismanga22', false, false);
                            $top_selected_query = new WP_Query(array('post_type' => 'tournoi', 'orderby' => 'post__in', 'post__in' => $top_selected, 'posts_per_page' => '1'));
                            while ($top_selected_query->have_posts()) : $top_selected_query->the_post(); ?>
                                <?php get_template_part('partials/min-t'); ?>
                            <?php endwhile;
                            wp_reset_query(); ?>
                        </div>
                    <?php endwhile; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <div class="text-center">
        <h1 class="mt-1">
            Les cadeaux à gagner de n'importe où 🌎🎁
        </h1>
        <p class="mb-4">
            <a href="https://vainkeurz.com/tas">Clique ici pour voir les dates</a> de tirage au sort pour chacun des Tops sponso
        </p>
    </div>

    <div class="row pricing-card">
        <div class="col-12">
            <div class="row match-height">
                <?php
                $top_selected       = get_field('programme_libre_parismanga22', false, false);
                $top_selected_query = new WP_Query(array('post_type' => 'tournoi', 'orderby' => 'post__in', 'post__in' => $top_selected, 'posts_per_page' => '-1'));
                while ($top_selected_query->have_posts()) : $top_selected_query->the_post(); ?>
                    <div class="col-md-3">
                        <div class="row">
                            <?php get_template_part('partials/min-t'); ?>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
        </div>
    </div>

    <div class="row mt-5 match-height">

        <div class="col-12">

            <div class="bloc-result">
                <h3>
                    Si on restait connecté ? <span class="va va-right-facing-fist va-2x"></span> <span class="va va-left-facing-fist va-2x"></span>
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

<?php get_footer(); ?>