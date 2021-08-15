<?php
/*
    Template Name: Classement
*/
global $uuiduser;
if(isset($_GET['id_top'])){
    $id_top  = $_GET['id_top'];
}
else{
    header('Location: ' . get_bloginfo('url'));
}
get_header();
global $top_infos;
global $user_tops;
$list_t_already_done  = $user_tops['list_user_tops_done_ids'];
$top_datas            = get_top_data($id_top);
$user_single_top_data = array_search($id_top, $list_t_already_done);
?>
<div class="app-content content cover" style="background: url(<?php echo $top_infos['top_cover']; ?>) center center no-repeat">
    <div class="content-overlay"></div>
    <div class="content-wrapper">
        <div class="content-body mt-2">

            <div class="intro-mobile">
                <div class="tournament-heading text-center">
                    <h3 class="mb-0 t-titre-tournoi">
                        Top <?php echo $top_infos['top_number']; ?> <span class="ico text-center">🏆</span> <?php echo $top_infos['top_title']; ?>
                    </h3>
                    <h4 class="mb-0">
                        <?php echo $top_infos['top_question']; ?>
                    </h4>
                </div>
            </div>

            <div class="classement">
                <div class="container-fluid">

                    <div class="row">

                        <div class="col-md-7 offset-md-1">

                            <div class="list-classement mt-2">

                                <div class="row align-items-end justify-content-center">

                                    <?php
                                    $id_top = $_GET['id_top'];
                                    $contenders_tournament = new WP_Query(array(
                                        'post_type'         => 'contender', 
                                        'meta_key'          => 'ELO_c', 
                                        'orderby'           => 'meta_value_num', 
                                        'posts_per_page'    => '-1', 
                                        'meta_query'        => array(
                                            array(
                                                'key'     => 'id_tournoi_c',
                                                'value'   => $id_top,
                                                'compare' => '=',
                                            )
                                        )
                                    ));?>
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
                                                <div class="animate__jackInTheBox animate__animated animate__delay-<?php echo $d; ?>s contenders_min <?php if(get_field('c_rounded_t', $id_top)){ echo 'rounded'; } ?> mb-3">
                                                    <div class="illu">
                                                        <?php if(get_field('visuel_cover_t', $id_top)): ?>
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
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="card">
                                                <div class="card-header">
                                                    <div>
                                                        <p class="card-text">
                                                            <span class="ico">🎂</span> Depuis le <?php echo $top_infos['top_date']; ?>
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
                                                        <?php echo $top_datas['nb_votes']; ?>
                                                    </h2>
                                                    <p class="card-text legende">
                                                        <?php if($top_datas['nb_votes'] <= 1): ?>
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
                                                    <div class="pricing-badge text-right">
                                                        <div class="badge badge-pill badge-light-primary">
                                                            <a href="<?php the_permalink(get_page_by_path('liste-des-tops')); ?>?id_top=<?php echo $id_top; ?>" data-toggle="tooltip" data-placement="top" title="" data-original-title="Voir les <?php echo $nb_tops; ?> Tops">
                                                                👀
                                                            </a>
                                                        </div>
                                                    </div>
                                                    <div class="mb-1">
                                                        <span class="ico4">🏆</span>
                                                    </div>
                                                    <h2 class="font-weight-bolder">
                                                        <?php echo $top_datas['nb_tops']; ?>
                                                    </h2>
                                                    <p class="card-text legende">
                                                        <?php if($top_datas['nb_tops'] <= 1): ?>
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

                                <?php if($user_sinle_top_data != false): ?>
                                    <div class="card">
                                        <div class="card-body">
                                            <h4 class="card-title">
                                                <span class="ico">✌️</span> Participe à ce Top mondial
                                            </h4>
                                            <h6 class="card-subtitle text-muted mb-1">
                                                Toi aussi fais ton Top afin de faire bouger les positions !
                                            </h6>
                                            <a href="<?php the_permalink($id_top); ?>" class="btn btn-outline-primary waves-effect">
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