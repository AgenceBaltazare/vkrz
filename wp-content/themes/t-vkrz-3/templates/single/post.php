<?php get_header(); ?>
<div class="app-content content cover" style="background: url(<?php echo $top_infos['top_cover']; ?>) center center no-repeat">
    <div class="content-overlay"></div>
    <div class="content-wrapper">
        <div class="content-body tournoi-content">

            <div class="container">

                <div class="row">

                    <div class="col-12">

                        <h1><?php the_title(); ?></h1>

                        <?php global $top_comments_id; $top_comments_id = get_the_ID();   ?>
                        <?php echo get_template_part('comments'); ?>

                    </div>

                </div>

            </div>
            
        </div>
    </div>
</div>

<?php get_footer(); ?>
