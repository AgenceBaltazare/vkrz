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
                                    <div class="pricing-badge text-right">
                                        <div class="badge badge-pill badge-light-primary">
                                            <a href="<?php the_permalink(get_page_by_path('best-of/best-tops')); ?>" data-toggle="tooltip" data-popup="tooltip-custom" data-placement="top" data-original-title="Voir les Tops les plus populaires">
                                                💫
                                            </a>
                                        </div>
                                    </div>
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
                        <div class="col-md-4">
                            <div class="card text-center">
                                <div class="card-body d-flex align-items-center winbloc">
                                    <?php
                                    if (get_field('nb_total_tops', 'options') < 100000) : ?>
                                        <div class="illuwin">
                                            <img src="<?php bloginfo('template_directory'); ?>/assets/images/vkrz/switch-towin.png" alt="" class="img-fluid">
                                        </div>
                                        <h3 class="mt-3">
                                            Une <span class="t-violet">SWITCH LITE Bleu</span> à gagner !
                                        </h3>
                                        <p class="card-text mt-2">
                                            Le Vainkeur qui fera le <span class="t-rose">100 000<sup>ème</sup> Top</span> l'emporte. <br>
                                            L'identifiant du gagnant sera annoncé sur Twitter et sur cette même page. <span class="ico">🥶</span>
                                        </p>
                                    <?php else : ?>
                                        <div class="illuwin">
                                            <img src="<?php bloginfo('template_directory'); ?>/assets/images/vkrz/switch-win.png" alt="" class="img-fluid">
                                        </div>
                                        <h3 class="mt-2">
                                            La <span class="t-violet">SWITCH LITE Bleu</span> a été remportée !
                                        </h3>
                                        <p class="card-text mt-2">
                                            Félicitation au Vainkeur qui a fait le <span class="t-rose">100 000<sup>ème</sup> Top</span>. <br>
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
                        <div class="col-md-3">
                            <section class="app-user-view">
                                <div class="row match-height">
                                    <div class="col-sm-12">
                                        <div class="card text-center">
                                            <div class="card-body">
                                                <div class="pricing-badge text-right">
                                                    <div class="badge badge-pill badge-light-primary">
                                                        <a href="<?php the_permalink(get_page_by_path('best-of/best-vainkeurs')); ?>" data-toggle="tooltip" data-popup="tooltip-custom" data-placement="top" data-original-title="Voir le Top 20 des vainkeurs">
                                                            🔥
                                                        </a>
                                                    </div>
                                                </div>
                                                <div class="mb-1">
                                                    <span class="ico4">🦃</span>
                                                </div>
                                                <h2 class="font-weight-bolder">
                                                    <?php echo count_users_by_level(4); ?>
                                                </h2>
                                                <p class="card-text legende list-vainkeur-monitor">
                                                    <?php
                                                    $list_level_4 = get_users_by_level(4, 'total_vote', 'DESC');
                                                    foreach ($list_level_4 as $vainkeur) :
                                                    ?>
                                                        <a href="<?php echo esc_url(get_author_posts_url($vainkeur['ID'])); ?>">
                                                            <?php echo $vainkeur['pseudo']; ?>
                                                        </a>
                                                    <?php endforeach; ?>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="card text-center">
                                            <div class="card-body">
                                                <div class="mb-1">
                                                    <span class="ico4">🐓</span>
                                                </div>
                                                <h2 class="font-weight-bolder">
                                                    <?php echo count_users_by_level(3); ?>
                                                </h2>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="card text-center">
                                            <div class="card-body">
                                                <div class="mb-1">
                                                    <span class="ico4">🐥</span>
                                                </div>
                                                <h2 class="font-weight-bolder">
                                                    <?php echo count_users_by_level(2); ?>
                                                </h2>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="card text-center">
                                            <div class="card-body">
                                                <div class="mb-1">
                                                    <span class="ico4">🐣</span>
                                                </div>
                                                <h2 class="font-weight-bolder">
                                                    <?php echo count_users_by_level(1); ?>
                                                </h2>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="card text-center">
                                            <div class="card-body">
                                                <div class="pricing-badge text-right">
                                                    <div class="badge badge-pill badge-light-primary">
                                                        <a href="<?php the_permalink(get_page_by_path('recrutement')); ?>" data-toggle="tooltip" data-popup="tooltip-custom" data-placement="top" data-original-title="Postuler pour devenir créateur">
                                                            ✊
                                                        </a>
                                                    </div>
                                                </div>
                                                <div class="mb-1">
                                                    <span class="ico4">👨‍🎤</span>
                                                </div>
                                                <h2 class="font-weight-bolder">
                                                    <?php
                                                    $user_query = new WP_User_Query(array('role__in' => array('author', 'administrator')));
                                                    echo $user_query->get_total();
                                                    ?>
                                                </h2>
                                                <p class="card-text legende">
                                                    Créateurs de Tops
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </section>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    const total_vkrz_votes = "<?php the_field('nb_total_votes', 'options'); ?>";
    const total_vkrz_tops = "<?php the_field('nb_total_tops', 'options'); ?>";
</script>

<?php get_footer(); ?>