<?php get_header(); ?>
<?php
$id_battle = get_the_ID();
$contenders = new WP_Query(array('post_type' => 'contender', 'posts_per_page' => '2', 'orderby' => 'rand', 'meta_query' => array(
    array(
        'key' => 'list_of_battles_id',
        'value' => $id_battle,
        'compare' => 'LIKE',
    )
)));
?>
<div class="main">
    <div class="container-fluid">
        <div class="row">
            <div class="col-1 header">
                <header>
                    <div class="bl">
                        <div class="logo">
                            <a href="<?php bloginfo('url'); ?>/">
                                <img src="<?php bloginfo('template_directory'); ?>/assets/img/logo-vainkeurz-min.png" alt="" class="img-fluid">
                            </a>
                        </div>
                    </div>
                </header>
            </div>
            <div class="col-10">
                <div class="row">
                    <div class="col-12">
                        <div class="bloc-titre">
                            <h1 class="title-battle">
                                <b>
                                    <?php the_title(); ?>
                                </b>
                                <span>
                                    <?php the_field('slug_battle'); ?>
                                </span>
                            </h1>
                            <div class="votes-battle">
                                <?php the_field('total_of_votes_battle'); ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row align-items-center">
                    <?php $i=0; while ($contenders->have_posts()) : $contenders->the_post(); ?>
                        <?php
                            if($i==0){
                                $rel1 = get_the_ID();
                            }
                            elseif($i==1){
                                $rel2 = get_the_ID();
                            }
                        ?>
                        <div class="col-5 link-contender">
                            <a href="<?php the_permalink($id_battle); ?>" class="" rel="<?php get_the_ID(); ?>">
                                <?php if (has_post_thumbnail()) : ?>
                                    <?php the_post_thumbnail('full', array('class'=>'rounded img-fluid')); ?>
                                <?php endif; ?>
                                <h2 class="title-contender">
                                    <?php the_title(); ?>
                                </h2>
                            </a>
                        </div>
                        <?php if($i==0): ?>
                              <div class="col-2">
                                  <h4 class="text-center versus">
                                      VS
                                  </h4>
                              </div>
                        <?php endif; ?>
                    <?php $i++; endwhile; ?>
                </div>
            </div>
            <div class="col-1">
                1200 votes
            </div>
        </div>
    </div>
</div>

<?php get_footer(); ?>
