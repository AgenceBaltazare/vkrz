<?php /* Template Name: Monitor */ ?>
<?php get_header(); ?>

<div class="app-content content ">
    <div class="content-wrapper">
        <div class="content-body">
            <div class="header-monitor">
                <div class="container">
                    <div class="row">
                        <div class="col">
                            <img src="<?php bloginfo('template_directory'); ?>/assets/images/vkrz/monitor.png" alt="VAINKEURZ Monitor" class="img-fluid">
                        </div>
                    </div>
                </div>
            </div>

            <div class="content-monitor">
                <div class="container">
                    <div class="row">
                        <div class="col-md-7">
                            <div class="card text-center">
                                <div class="card-body">
                                    <div class="mb-1">
                                        <span class="ico4">💎</span>
                                    </div>
                                    <h1 class="font-weight-bolder">
                                        <span class="count" id="votes_number">
                                            <?php the_field('nb_total_votes', 'options'); ?>
                                        </span>
                                    </h1>
                                    <p class="card-text legende">votes effectués</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="card text-center">
                                <div class="card-body">
                                    <div class="mb-1">
                                        <span class="ico4">🏆</span>
                                    </div>
                                    <h1 class="font-weight-bolder">
                                        <span class="count" id="tops_number">
                                            <?php the_field('nb_total_tops', 'options'); ?>
                                        </span>
                                    </h1>
                                    <p class="card-text legende">Tops terminés</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    const total_vkrz_votes = "<?php the_field('nb_total_votes', 'options'); ?>";
    const total_vkrz_tops  = "<?php the_field('nb_total_tops', 'options'); ?>";
</script>

<?php get_footer(); ?>