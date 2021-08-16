<?php
get_header();
global $user_tops;
$list_t_already_done = $user_tops['list_user_tops_done_ids'];
?>
<div class="app-content content ">
    <div class="content-wrapper">
        <div class="content-body">

            <div class="intro-mobile">
                <h3 class="mb-0 animate__animated animate__slideInLeft">🖖 Bienvenue</h3>
                <h4 class="mb-0 kick animate__animated animate__slideInRight" data-kick="Commence par choisir un Top qui t'intéresse et enchaîne les votes 👇">
                    Ici, tu fais et revendique tes propres Tops !
                </h4>
            </div>

            <section class="list-tournois">

                <div class="big-cat">
                    <div class="heading-cat">
                        <div class="row">
                            <div class="col">
                                <h2 class="text-primary text-uppercase">
                                    <span class="ico">⏱</span> Tops les plus récents
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
                            $tournois_in_cat = new WP_Query(array(
                                'ignore_sticky_posts'    => true,
                                'update_post_meta_cache' => false,
                                'no_found_rows'          => true,
                                'post_type'              => 'tournoi',
                                'post__not_in'           => $list_t_already_done,
                                'orderby'                => 'date',
                                'order'                  => 'DESC',
                                'posts_per_page'         => 10
                            ));
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
                                    C'est clairement le moyen le plus douloureux de classer tout ce que tu préfères 🥴
                                    <br><br>
                                    Ici, c'est pas aussi simple qu'une Tier List 😝 car pas d'égalité possible.
                                    <br>  
                                    Tu vas forcément devoir faire des choix que tu voulais clairement pas avoir 😱
                                    <br><br>
                                    Ensuite, tu pourras comparer tes 🏆 à ceux de tes amis - si tu en as bien sûr. Et puis si tu n'en pas, 🤗 rejoins notre Discord.
                                </p>
                                <a href="<?php the_permalink(104853); ?>" class="btn btn-primary waves-effect">
                                    Découvrir l'histoire de VAINKEURZ
                                </a>
                                <div class="mt-10p">
                                    <a href="https://discord.gg/w882sUnrhE" class="sociallink btn btn-outline-primary waves-effect mr-10p mt-10p" target="_blank">
                                        Discord
                                    </a>
                                    <a href="https://www.instagram.com/wearevainkeurz/" class="sociallink btn btn-outline-primary waves-effect mr-10p mt-10p" target="_blank">
                                        Insta
                                    </a>
                                    <a href="https://twitter.com/Vainkeurz" class="sociallink btn btn-outline-primary waves-effect mr-10p mt-10p" target="_blank">
                                        Twitter
                                    </a>
                                    <a href="https://www.facebook.com/vainkeurz" class="sociallink btn btn-outline-primary waves-effect mt-10p" target="_blank">
                                        Facebook
                                    </a>
                                </div>
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
                    <?php
                    $tournois_in_cat = new WP_Query(array(
                        'post_type' => 'tournoi',
                        'post__not_in' => $list_t_already_done,
                        'orderby' => 'rand',
                        'order' => 'ASC',
                        'posts_per_page' => 10,
                        'ignore_sticky_posts'    => true,
                        'update_post_meta_cache' => false,
                        'no_found_rows'          => true,
                        'tax_query' => array(
                            array(
                                'taxonomy' => 'categorie',
                                'field'    => 'term_id',
                                'terms'    => $cat->term_id,
                            ),
                        )
                    ));
                    if($tournois_in_cat->have_posts()): ?>
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
                <?php endif; $swip++; endforeach; ?>
            </section>
        </div>
    </div>
</div>
<!-- END: Content-->

<?php get_footer(); ?>
