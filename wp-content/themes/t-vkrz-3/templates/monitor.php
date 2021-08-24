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
                    <div class="row match-height">
                        <div class="col-md-5">
                            <div class="card text-center">
                                <div class="card-body d-flex align-items-center winbloc">
                                    <?php
                                    if(get_field('nb_total_votes', 'options') < 1000000) : ?>
                                        <div class="illuwin">
                                            <img src="<?php bloginfo('template_directory'); ?>/assets/images/vkrz/switch-towin.png" alt="" class="img-fluid">
                                        </div>
                                        <h3 class="mt-3">
                                            Une <span class="t-violet">SWITCH LITE Bleu</span> à gagner !
                                        </h3>
                                        <p class="card-text mt-2">
                                            Le Vainkeur qui fera le <span class="t-rose">millionème vote</span> l'emporte. <br>
                                            L'identifiant du gagnant sera annoncé sur Twitter et sur cette même page. <span class="ico">🥶</span>
                                        </p>
                                    <?php else: ?>
                                        <div class="illuwin">
                                            <img src="<?php bloginfo('template_directory'); ?>/assets/images/vkrz/switch-win.png" alt="" class="img-fluid">
                                        </div>
                                        <h3 class="mt-2">
                                            La <span class="t-violet">SWITCH LITE Bleu</span> a été remportée !
                                        </h3>
                                        <p class="card-text mt-2">
                                            Félicitation au Vainkeur qui a fait le <span class="t-rose">millionème vote</span>. <br>
                                            Go sur notre Twitter pour découvrir le gagnant, c'est peut-être toi <span class="ico">😜</span>
                                        </p>
                                    <?php endif; ?>
                                    <div class="mt-2">
                                        <div class="w-100 btn-group justify-content-center share-t" role="group">
                                            <a data-rs-name="discord" href="https://discord.gg/E9H9e8NYp7" class="btn btn-outline-primary waves-effect sociallink" target="_blank">
                                                <i class="fab fa-discord"></i>
                                            </a>
                                            <a data-rs-name="instagram" href="https://www.instagram.com/wearevainkeurz/" class="btn btn-outline-primary waves-effect sociallink" target="_blank">
                                                <i class="fab fa-instagram"></i>
                                            </a>
                                            <a data-rs-name="twitter" href="https://twitter.com/Vainkeurz" target="_blank" class="btn btn-outline-primary waves-effect sociallink">
                                                <i class="fab fa-twitter"></i>
                                            </a>
                                            <a data-rs-name="facebook" href="https://www.facebook.com/vainkeurz" target="_blank" class="btn btn-outline-primary waves-effect sociallink">
                                                <i class="fab fa-facebook-f"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
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
                            <div class="card text-center mt-2">
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