<?php get_header(); ?>
<?php
$id_tournoi                      = get_field('id_tournoi_r');
$uuiduser                        = get_field('uuid_user_r');
$list_contenders_tournoi         = get_field('ranking_r');

$id_contender_classement         = array_column($list_contenders_tournoi, 'id_global');

$all_user_votes       = new WP_Query(array(
    'post_type'      => 'vote',
    'posts_per_page' => -1,
    'meta_query'     => array(
        'relation'   => 'AND',
        array(
            'key'     => 'id_t_v',
            'value'   => $id_tournoi,
            'compare' => '=',
        ),
        array(
            'key'     => 'id_user_v',
            'value'   => $_COOKIE["vainkeurz_user_id"],
            'compare' => '=',
        )
    )
));
$nb_user_votes = $all_user_votes->post_count;
?>
<?php if(get_field('done_r')): ?>
    <div class="classement">
        <div class="container-fluid">
            <div class="row">
                <div class="col">
                    <div class="titre-classement text-center">
                        <h2>Votre classement</h2>
                        <h3>Après <?php echo $nb_user_votes->post_count; ?> votes</h3>
                    </div>
                </div>
            </div>
            <div class="list-classement">
                <div class="row">
                    <?php

                    $i=1; foreach($id_contender_classement as $c) :

                        if($i == 1){
                            $class      = "col-12";
                            $intitule   = "1er";
                        }
                        elseif($i == 2){
                            $class      = "col-sm-4 offset-sm-1 col-6";
                            $intitule   = "2ème";
                        }
                        elseif($i == 3){
                            $class      = "col-sm-4 offset-sm-1 col-6";
                            $intitule   = "3ème";
                        }
                        elseif(count($id_contender_classement) == $i){
                            $class      = "col-12";
                            $intitule   = "Dernier";
                        }
                        else{
                            $class      = "col-md-3 col-sm-4 col-4 col-lg-2";
                            $intitule   = $i;
                        }
                        ?>

                        <div class="contenders_min <?php echo $class; ?>">

                            <div class="illu">
                                <?php
                                echo get_the_post_thumbnail($c, 'full', array('class' => 'img-fluid'));
                                ?>
                            </div>
                            <div class="name">
                                <h5>
                                    <span><?php echo $intitule; ?></span>
                                    <br>
                                    <?php echo get_the_title($c); ?>
                                </h5>
                            </div>

                        </div>

                        <?php $i++; endforeach; ?>
                </div>
            </div>
        </div>
    </div>
<?php else: ?>
    <div class="classement">
        <div class="container-fluid">
            <div class="row">
                <div class="col">
                    <div class="titre-classement text-center">
                        <h2>Classement en cours de finalisation</h2>
                        <h3>
                            <a href="<?php the_permalink($id_tournoi); ?>">
                                Cliquez ici pour revenir au tournoi
                            </a>
                        </h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>
<?php get_footer(); ?>