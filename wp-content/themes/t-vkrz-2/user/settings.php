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
                                <?php echo do_shortcode('[wppb-edit-profile form_name="edition-profil"]'); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
</div>
<?php get_footer(); ?>

