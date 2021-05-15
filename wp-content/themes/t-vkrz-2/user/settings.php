<?php
/*
    Template Name: User settings
*/
?>
<?php get_header(); ?>
<div class="app-content content">
    <div class="content-wrapper">
        <div class="content-body">
            <section class="app-user-view">
                <div class="row match-height">
                    <div class="col">
                        <div class="card">
                            <div class="card-body">
                                <?php echo do_shortcode('[user_registration_form id="26400"]'); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
</div>
<?php get_footer(); ?>

