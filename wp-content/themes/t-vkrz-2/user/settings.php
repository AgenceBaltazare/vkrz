<?php
/*
    Template Name: User settings
*/
?>
<?php get_header(); ?>
<div class="app-content content">
    <div class="content-overlay"></div>
    <div class="content-wrapper">
        <div class="content-header row"></div>
        <div class="content-body">
            <?php while (have_posts()) : the_post(); ?>

                <?php echo do_shortcode('[user_registration_my_account]'); ?>

            <?php endwhile; ?>
        </div>
    </div>
</div>
<?php get_footer(); ?>
