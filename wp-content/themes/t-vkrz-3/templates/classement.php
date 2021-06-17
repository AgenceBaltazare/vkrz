<?php
/*
    Template Name: Classement
*/
global $uuiduser;
if(isset($_GET['id_top'])){
    $id_tournament  = $_GET['id_top'];
}
else{
    header('Location: ' . get_bloginfo('url'));
}
$display_titre      = get_field('ne_pas_afficher_les_titres_t', $id_tournament);
$rounded            = get_field('c_rounded_t', $id_tournament);
$illu               = wp_get_attachment_image_src(get_field('cover_t', $id_tournament), 'full');
$illu_url           = $illu[0];
get_header();
$top_title     = get_the_title($id_tournament);
$top_question  = get_field('question_t', $id_tournament);
$top_number    = get_numbers_of_contenders($id_tournament);
?>
<div class="app-content content cover" style="background: url(<?php echo $illu_url; ?>) center center no-repeat">
    <div class="content-overlay"></div>
    <div class="content-wrapper">
        <div class="content-body mt-2">

            <div class="intro-mobile">
                <div class="tournament-heading text-center">
                    <h3 class="mb-0 t-titre-tournoi">
                        Top <?php echo $top_number; ?> <span class="ico text-center">🏆</span> <?php echo $top_title; ?>
                    </h3>
                    <h4 class="mb-0">
                        <?php echo $top_question; ?>
                    </h4>
                </div>
            </div>

            <div class="classement">
                <div class="container-fluid">

                    <div class="row">

                        <div class="col-md-7 offset-md-1">

                            <div class="list-classement">

                                <div class="row align-items-end justify-content-center">

                                    <?php
                                    $id_tournament = $_GET['id_top'];
                                    $contenders_tournament = new WP_Query(array('post_type' => 'contender', 'meta_key' => 'ELO_c', 'orderby' => 'meta_value_num', 'posts_per_page' => '-1', 'meta_query' => array(
                                        array(
                                            'key'     => 'id_tournoi_c',
                                            'value'   => $id_tournament,
                                            'compare' => '=',
                                        )
                                    )));?>
                                    <?php $i=1; while ($contenders_tournament->have_posts()) : $contenders_tournament->the_post();?>

                                        <?php if($i == 1): ?>
                                            <div class="col-12 col-md-5">
                                        <?php elseif($i == 2): ?>
                                            <div class="col-7 col-md-4">
                                        <?php elseif($i == 3): ?>
                                            <div class="col-5 col-md-3">
                                        <?php else: ?>
                                            <div class="col-md-2 col-4">
                                        <?php endif; ?>
                                                <?php
                                                if($i >= 4){
                                                    $d = 3;
                                                }
                                                else{
                                                    $d = $i-1;
                                                }
                                                ?>
                                                <div class="animate__jackInTheBox animate__animated animate__delay-<?php echo $d; ?>s contenders_min <?php if(get_field('c_rounded_t', $id_tournament)){ echo 'rounded'; } ?> mb-3">
                                                    <div class="illu">
                                                        <?php if(get_field('visuel_cover_t', $id_tournament)): ?>
                                                            <?php $illu = get_the_post_thumbnail_url(get_the_ID(), 'full'); ?>
                                                            <div class="cov-illu" style="background: url(<?php echo $illu; ?>) center center no-repeat"></div>
                                                        <?php else: ?>
                                                            <?php echo get_the_post_thumbnail(get_the_ID(), 'full', array('class' => 'img-fluid')); ?>
                                                        <?php endif; ?>
                                                    </div>
                                                    <div class="name eh2">
                                                        <h5 class="mt-2">
                                                            <?php if($i == 1): ?>
                                                                <span class="ico">🥇</span>
                                                            <?php elseif($i == 2): ?>
                                                                <span class="ico">🥈</span>
                                                            <?php elseif($i == 3): ?>
                                                                <span class="ico">🥉</span>
                                                            <?php else: ?>
                                                                <span><?php echo $i; ?><br></span>
                                                            <?php endif; ?>
                                                            <?php if(!$display_titre): ?>
                                                                <?php the_title(); ?>
                                                            <?php endif; ?>
                                                        </h5>
                                                    </div>
                                                </div>
                                            </div>
                                    <?php $i++; endwhile; ?>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3 offset-md-1">

                            <div class="related">

                                <div class="infoelo">
                                    <?php
                                    $count_votes_of_t       = 0;
                                    $list_ranking_of_t      = array();
                                    $date_of_t              = 0;
                                    $current_user_have_r    = false;
                                    $all_ranking_of_t       = new WP_Query(array(
                                        'post_type' => 'classement',
                                        'orderby' => 'date',
                                        'order' => 'ASC',
                                        'posts_per_page' => '-1',
                                        'ignore_sticky_posts'    => true,
                                        'update_post_meta_cache' => false,
                                        'no_found_rows'          => true,
                                        'meta_query' => array(
                                            'meta_query' => array(
                                                'relation' => 'AND',
                                                array(
                                                    'key' => 'nb_votes_r',
                                                    'value' => 0,
                                                    'compare' => '>',
                                                ),
                                                array(
                                                    'key' => 'id_tournoi_r',
                                                    'value' => $id_tournament,
                                                    'compare' => '=',
                                                )
                                            )
                                        )
                                    ));
                                    $c=1; while ($all_ranking_of_t->have_posts()) : $all_ranking_of_t->the_post();

                                        if($c == 1){
                                            $date_of_t = get_the_date('d F Y');
                                        }
                                        $count_votes_of_t = $count_votes_of_t + get_field('nb_votes_r');

                                        if(get_field('uuid_user_r') == $uuiduser){
                                            $current_user_have_r     = true;
                                            $current_user_id_ranking = get_the_id();
                                            $current_user_top3       = get_user_ranking($current_user_id_ranking);
                                        }

                                        array_push($list_ranking_of_t, array(
                                                "id_ranking"    => get_the_id(),
                                                "uuid_user"     => get_field('uuid_user_r')
                                        ));

                                    $c++; endwhile;
                                    $nb_tops = $all_ranking_of_t->post_count;
                                    ?>
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="card">
                                                <div class="card-header">
                                                    <div>
                                                        <p class="card-text">
                                                            <span class="ico">🎂</span> Depuis le <?php echo $date_of_t; ?>
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="card text-center">
                                                <div class="card-body">
                                                    <div class="mb-1">
                                                        <span class="ico4">💎</span>
                                                    </div>
                                                    <h2 class="font-weight-bolder">
                                                        <?php echo $count_votes_of_t; ?>
                                                    </h2>
                                                    <p class="card-text legende">
                                                        <?php if($count_votes_of_t <= 1): ?>
                                                            vote
                                                        <?php else: ?>
                                                            Votes
                                                        <?php endif; ?>
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="card text-center">
                                                <div class="card-body">
                                                    <div class="mb-1">
                                                        <span class="ico4">🏆</span>
                                                    </div>
                                                    <h2 class="font-weight-bolder">
                                                        <?php echo $nb_tops; ?>
                                                    </h2>
                                                    <p class="card-text legende">
                                                        <?php if($nb_tops <= 1): ?>
                                                            Top
                                                        <?php else: ?>
                                                            Tops
                                                        <?php endif; ?>
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <?php if($current_user_have_r): ?>
                                    <div class="card">
                                        <div class="card-body">
                                            <h2 class="font-weight-bolder">
                                                <?php echo get_user_percent($uuiduser, $id_tournament); ?>% <small>des Tops</small>
                                            </h2>
                                            <p class="card-text legende">
                                                sont identiques à celui-ci !
                                            </p>
                                            <a href="<?php the_permalink(get_page_by_path('liste-des-tops')); ?>?id_top=<?php echo $id_tournament; ?>" class="btn btn-outline-primary waves-effect">
                                                Voir les <?php echo $nb_tops; ?> Tops
                                            </a>
                                        </div>
                                    </div>
                                <?php endif; ?>

                                <?php if($current_user_id_ranking): ?>
                                    <div class="card">
                                        <div class="card-body profile-suggestion">
                                            <h4 class="card-title">
                                                <span class="ico">🤩</span> Ton podium
                                            </h4>
                                            <?php
                                            $l=1;
                                            foreach($current_user_top3 as $top => $p): ?>

                                                <div class="d-flex justify-content-start align-items-center mb-1">
                                                    <?php $illu = get_the_post_thumbnail_url($top, 'thumbnail'); ?>
                                                    <div class="avatar mr-1">
                                                        <img src="<?php echo $illu; ?>" alt="<?php echo get_the_title($top); ?>" height="40" width="40">
                                                    </div>
                                                    <div class="profile-user-info">
                                                        <h6 class="mb-0">
                                                            <?php echo get_the_title($top); ?>
                                                        </h6>
                                                    </div>
                                                    <div class="profile-star ml-auto">
                                                        <?php if($l == 1): ?>
                                                            🥇
                                                        <?php elseif($l == 2): ?>
                                                            🥈
                                                        <?php elseif($l == 3): ?>
                                                            🥉
                                                        <?php endif; ?>
                                                    </div>
                                                </div>

                                            <?php $l++; if($l==4) break; endforeach; ?>

                                            <div class="card-footer">
                                                <a data-phrase1="Es-tu sûr de toi ?" data-phrase2="Tous les votes de ce Top seront remis à 0" data-idranking="<?php echo $current_user_id_ranking; ?>" id="confirm_delete" href="#" class="mr-1 btn btn-outline-primary waves-effect">
                                                    Recommencer
                                                </a>
                                                <a href="<?php the_permalink($current_user_id_ranking); ?>" class="btn btn-outline-primary waves-effect">
                                                    Mon Top complet
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                <?php endif; ?>

                                <?php if(!$current_user_have_r): ?>
                                    <div class="card">
                                        <div class="card-body">
                                            <h4 class="card-title">
                                                <span class="ico">✌️</span> Participe à ce classement
                                            </h4>
                                            <h6 class="card-subtitle text-muted mb-1">
                                                Toi aussi fais ton Top afin de faire bouger des positions !
                                            </h6>
                                            <a href="<?php the_permalink($id_tournament); ?>" class="btn btn-outline-primary waves-effect">
                                                Faire mon propre Top
                                            </a>
                                        </div>
                                    </div>
                                <?php endif; ?>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- END: Content-->

<?php get_footer(); ?>