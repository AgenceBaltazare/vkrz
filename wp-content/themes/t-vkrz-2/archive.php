<?php get_header(); ?>
<div class="app-content content ">
    <div class="content-overlay"></div>
    <div class="header-navbar-shadow"></div>
    <div class="content-wrapper">

        <div class="content-body">

            <section class="list-tournois">

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
