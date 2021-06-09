<?php
/*
    Template Name: A propos
*/
?>
<?php get_header(); ?>
    <div class="app-content content ">
        <div class="content-wrapper">
            <div class="content-body">
                <div class="blog-detail-wrapper">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body apropos">
                                    <h1>
                                        Curieux d'en savoir plus <img src="<?php bloginfo('template_directory'); ?>/assets/images/vkrz/vainkeurz-text.png" alt="" class="img-fluid"> ?
                                    </h1>
                                    <h2 class="infoabout">
                                        ⏲ <span class="space"></span> Temps de lecture estimé : <b>je vais pas te mentir, c'est dense</b>
                                    </h2>
                                    <div class="card-text mb-2 mt-2">
                                        <?php while (have_posts()) : the_post(); ?>
                                            <?php the_content(); ?>
                                        <?php endwhile; ?>
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