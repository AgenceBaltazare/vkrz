<?php get_header(); ?>
<!-- BEGIN: Content-->
<div class="app-content content ">
    <div class="content-wrapper">

        <div class="content-body">

            <section class="list-tournois">

                <div class="big-cat">
                    <div class="heading-cat">
                        <div class="row">
                            <div class="col">
                                <h2 class="text-primary text-uppercase">
                                    <span class="ico">🤖</span> Tops au hasard
                                    <small class="text-muted">Toutes catégories confondues</small>
                                </h2>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="component-swiper-responsive-breakpoints">
                    <div class="swiper-responsive-breakpoints swiper-container swiper-0">
                        <div class="swiper-wrapper">
                            <?php
                            $tournois_in_cat = new WP_Query(array('post_type' => 'tournoi', 'post__not_in' => $list_t_already_done, 'orderby' => 'rand', 'order' => 'ASC', 'posts_per_page' => 10));
                            while ($tournois_in_cat->have_posts()) : $tournois_in_cat->the_post(); ?>

                                <?php get_template_part('partials/min-t'); ?>

                            <?php endwhile;?>
                        </div>
                        <div class="swiper-button-next swiper-button-next-0"></div>
                        <div class="swiper-button-prev swiper-button-prev-0"></div>
                    </div>
                </div>
            </section>


            <section id="vkrz-intro">
                <div class="row match-height">
                    <div class="col-md-5">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">
                                    <span class="ico">🧐</span> VAINKEURZ, c'est quoi ?
                                </h4>
                                <p class="card-text mb-2">
                                    C'est le site qui te demande de faire des choix que tu voulais pas faire. Comme de choisir entre Végéta et Sangoku, NOS et Adémo... 🥴
                                    <br><br>
                                    En gros, tu choisis un Top et ensuite tu votes en enchainant les duels jusqu'à finaliser ton classement 🥇🥈🥉
                                    <br><br>
                                    Ensuite, tu peux comparer tes classements à ceux de tes amis - si tu en as bien sûr. Et puis si tu n'en pas, 🤗 rejoins notre Discord.
                                </p>
                                <!--
                                <a href="<?php the_permalink(); ?>" class="btn btn-primary waves-effect">
                                    En savoir plus sur VKRZ
                                </a>
                                -->
                                <a href="https://discord.gg/PhjrFtwx" class="btn btn-outline-primary waves-effect" target="_blank">
                                    <span class="ico">🍻</span> Nous rejoindre sur Discord
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-7">
                        <div class="row">
                            <?php
                            $cat_t = get_terms( array(
                                'taxonomy'      => 'categorie',
                                'orderby'       => 'count',
                                'order'         => 'DESC',
                                'hide_empty'    => true,
                            ));
                            foreach($cat_t as $cat) : ?>
                                <div class="col-6">
                                    <div class="card scaler cat-min">
                                        <div class="card-header">
                                            <div>
                                                <h2 class="font-weight-bolder mb-0">
                                                    <span class="ico2 ">
                                                        <span class="<?php if($cat->term_id == 2){echo 'rotating';} ?>">
                                                            <?php the_field('icone_cat', 'term_'.$cat->term_id); ?>
                                                        </span>
                                                    </span> <?php echo $cat->name; ?>
                                                </h2>
                                            </div>
                                            <div class="p-50 m-0 text-primary">
                                                <?php echo $cat->count; ?> Tops
                                            </div>
                                        </div>
                                        <a href="<?php echo get_category_link($cat->term_id); ?>" class="stretched-link"></a>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </section>

            <section class="list-tournois">
                <?php $swip = 1; foreach($cat_t as $cat) : ?>
                    <div class="big-cat">
                        <div class="heading-cat">
                            <div class="row">
                                <div class="col">
                                    <h2 class="text-primary text-uppercase">
                                        <a href="<?php echo get_category_link($cat->term_id); ?>">
                                            <span class="ico"><?php the_field('icone_cat', 'term_'.$cat->term_id); ?></span> <?php echo $cat->name; ?>
                                            <small class="text-muted"><?php echo $cat->description; ?></small>
                                        </a>
                                    </h2>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="component-swiper-responsive-breakpoints">
                        <div class="swiper-responsive-breakpoints swiper-container swiper-<?php echo $swip; ?>">
                            <div class="swiper-wrapper">
                                <?php
                                $tournois_in_cat = new WP_Query(array('post_type' => 'tournoi', 'post__not_in' => $list_t_already_done, 'orderby' => 'rand', 'order' => 'ASC', 'posts_per_page' => 10,
                                    'tax_query' => array(
                                        array(
                                            'taxonomy' => 'categorie',
                                            'field'    => 'term_id',
                                            'terms'    => $cat->term_id,
                                        ),
                                    )
                                ));
                                while ($tournois_in_cat->have_posts()) : $tournois_in_cat->the_post(); ?>

                                    <?php get_template_part('partials/min-t'); ?>

                                <?php endwhile;?>
                            </div>
                            <?php if($cat->count > 2): ?>
                                <div class="swiper-button-next swiper-button-next-<?php echo $swip; ?>"></div>
                                <div class="swiper-button-prev swiper-button-prev-<?php echo $swip; ?>"></div>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php $swip++; endforeach; ?>
            </section>

        </div>
    </div>
</div>
<!-- END: Content-->

<?php get_footer(); ?>
