<?php
/*
    Template Name: Recrutement 
*/
get_header(); ?>

<div class="content-monitor recrutement-page apropos">
    <div class="container">
        <div class="row mt-5">
            <div class="col-md-8 offset-md-2">
                <h1 class="text-uppercase">
                    <?php the_field('phrase_recruement_#1'); ?>
                </h1>
                <h3 class="mt-1">
                    <?php the_field('phrase_recruement_#2'); ?>
                </h3>
                <div class="typeform mt-3">
                    <iframe src="<?php the_field('formulaire_recrutement'); ?>" width="100%" height="100%" frameborder="0" marginheight="0" marginwidth="0" title="Recrutement"></iframe>
                </div>
            </div>
        </div>
    </div>
</div>

<?php get_footer(); ?>