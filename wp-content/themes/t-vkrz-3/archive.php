<?php
get_header();
global $uuiduser;
global $user_id;
?>
    <div class="app-content content">
        <div class="content-wrapper">

            <div class="content-body">

                <div class="intro-mobile">
                    <?php $current_cat = get_queried_object(); ?>
                    <div class="tournament-heading text-center">
                        <h3 class="mb-0 t-titre-tournoi">
                            <span class="ico"><?php the_field('icone_cat', 'term_'.$current_cat->term_id); ?></span> <?php echo $current_cat->name; ?>
                        </h3>
                        <h4 class="mb-0">
                            <?php echo $current_cat->description; ?> - <?php echo $uuiduser; ?>
                        </h4>
                    </div>
                </div>

                <section class="list-tournois mt-1">

                    <div class="row">
                        <?php while (have_posts()) : the_post(); ?>

                            <?php get_template_part('partials/min-t'); ?>

                        <?php endwhile;?>
                    </div>

                </section>
            </div>
        </div>
    </div>
<?php get_footer(); ?>
