<?php get_header(); ?>

<body <?php body_class(array('defaut-ba')); ?>>

<div class="main">

    <header class="header">
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="col-sm-4">
                    <div class="logo">
                        <a href="<?php bloginfo('url'); ?>/">
                            <img src="<?php bloginfo('template_directory'); ?>/assets/img/logo-vainkeurz.png" alt="" class="img-fluid">
                        </a>
                    </div>
                </div>
                <div class="col-sm-8 text-right">
                    <div class="display_users_votes">
                        <a href="https://baltazare1.typeform.com/to/j9n8JU" target="_blank" class="cta_2">
                            ☝️ Donnez nous votre avis !
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <div class="container">
        <div class="titre_home">
            <div class="row">
                <div class="col">
                    <h1 class="text-center">Les tournois du moment</h1>
                </div>
            </div>
        </div>
        <div class="list_tournoi">
            <div class="row">
                <?php $list_tournois = new WP_Query(array('post_type' => 'tournoi', 'orderby' => 'date', 'posts_per_page' => '-1')); ?>
                <?php while ($list_tournois->have_posts()) : $list_tournois->the_post(); ?>
                    <?php
                    $uuiduser         = $_COOKIE["vainkeurz_user_id"];
                    $done             = 'pas_fini';
                    $classement_perso = new WP_Query(array('post_type' => 'classement', 'orderby' => 'date', 'posts_per_page' => '1', 'meta_query' =>
                        array(
                            'relation'  => 'AND',
                            array(
                                'key'     => 'id_tournoi_r',
                                'value'   => get_the_ID(),
                                'compare' => '=',
                            ),
                            array(
                                'key' => 'uuid_user_r',
                                'value' => $uuiduser,
                                'compare' => '=',
                            )
                        )
                    ));
                    if($classement_perso->have_posts()){
                        while ($classement_perso->have_posts()) : $classement_perso->the_post();
                            $id_classement_user = get_the_ID();
                        endwhile; $list_tournois->reset_postdata();
                        if(get_field('done_r', $id_classement_user)){
                            $done = 'fini';
                        }
                    }
                    ?>
                    <div class="col-12 col-md">
                        <div class="tournoi_min <?php echo $done; ?>">
                            <a href="<?php the_permalink(); ?>" class="eh">
                                <?php if (has_post_thumbnail()) : ?>
                                    <div class="illu_min">
                                        <div class="check">
                                            <i class="fal fa-badge-check"></i>
                                        </div>
                                        <?php
                                            if (has_post_thumbnail()){
                                                $illu = get_the_post_thumbnail_url(get_the_ID(), 'full');
                                            }
                                        ?>
                                        <div class="cov-illu" style="background: url(<?php echo $illu; ?>) center center no-repeat"></div>
                                    </div>
                                <?php endif; ?>
                                <h2 class="h2eh">
                                    <b><?php the_title(); ?></b>
                                    <span><?php the_field('objectif_t'); ?></span>
                                </h2>
                                <p class="peh">
                                    <?php the_field('precision_t'); ?>
                                </p>
                            </a>
                        </div>
                    </div>
                <?php endwhile;?>
            </div>
        </div>
    </div>

</div>


<?php get_footer(); ?>