<?php
get_header();
global $uuiduser;
global $user_id;
global $id_top;
global $id_ranking;
global $top_infos;
global $utm;
global $user_infos;
global $id_vainkeur;

if(is_user_logged_in() && env() != "local") {
    if (false === ( $user_tops = get_transient( 'user_'.$user_id.'_get_user_tops' ) )) {
        $user_tops = get_user_tops();
        set_transient( 'user_'.$user_id.'_get_user_tops', $user_tops, DAY_IN_SECONDS );
    } else {
        $user_tops = get_transient( 'user_'.$user_id.'_get_user_tops' );
    }
} 
else {
    $user_tops  = get_user_tops();
}
$user_ranking = get_user_ranking($id_ranking);
$url_ranking  = get_the_permalink($id_ranking);
?>
<div class="vertical-modal-ex">
    <div class="modal fade" id="commentModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterTitle">Qu'as-tu pensé de ce Top ?</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form class="form form-vertical form-note" data-id-top="<?php echo $id_top; ?>" data-uuiduser="<?php echo $uuiduser; ?>">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <textarea class="form-control commentairezone" rows="4" placeholder="Ton commenaire..."></textarea>
                                    <p class="merci">
                                        Un grand Merci pour ce retour <span class="ico">🙏</span>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer text-center">
                        <button type="submit" class="tohidecta btn btn-primary mr-1 waves-effect waves-float waves-light">Valider</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="app-content content cover" style="background: url(<?php echo $top_infos['top_cover']; ?>) center center no-repeat">
    <div class="content-overlay"></div>
    <div class="content-wrapper">
    <div class="content-body">
    <?php if(!is_user_logged_in()): ?>
        <section class="please-rejoin app-user-view">
            <div role="alert" aria-live="polite" aria-atomic="true" class="alert alert-account" data-v-aa799a9e="">
                <div class="alert-body d-flex align-items-center justify-content-between">
                    <span><span class="ico">💾</span> Pour sauvegarder et retrouver sur tous tes supports ta progression l'idéal serait de te créer un compte.</span>
                    <div class="btns-alert text-right">
                        <a class="btn btn-primary waves-effect btn-rose" href="<?php the_permalink(get_page_by_path('creer-mon-compte')); ?>">
                            Excellente idée - je créé mon compte <span class="ico">🎉</span>
                        </a>
                        <a class="btn btn-outline-white waves-effect t-white ml-1" href="<?php the_permalink(get_page_by_path('se-connecter')); ?>">
                            J'ai déjà un compte
                        </a>
                    </div>
                </div>
            </div>
        </section>
    <?php endif; ?>
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
        <div class="row">
            <div class="col-md-8">
                <div class="list-classement mt-2">
                    <div class="row align-items-end justify-content-center">
                        <?php
                        $i=1; foreach($user_ranking as $c => $p) : ?>
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
                                <div class="animate__jackInTheBox animate__animated animate__delay-<?php echo $d; ?>s contenders_min <?php if($top_infos['top_d_rounded']){ echo 'rounded'; } ?> mb-3">
                                    <div class="illu">
                                        <?php if($top_infos['top_d_cover']): ?>
                                            <?php $illu = get_the_post_thumbnail_url( $c, 'large' ); ?>
                                            <div class="cov-illu" style="background: url(<?php echo $illu; ?>) center center no-repeat"></div>
                                        <?php else: ?>
                                            <?php echo get_the_post_thumbnail($c, 'large', array('class' => 'img-fluid')); ?>
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
                                            <?php if(!$top_infos['top_d_titre']): ?>
                                                <?php echo get_the_title($c); ?>
                                            <?php endif; ?>
                                        </h5>
                                    </div>
                                </div>
                            </div>
                        <?php $i++; endforeach; ?>
                    </div>

                    <?php
                    $list_t_already_done = $user_tops['list_user_tops_done_ids'];

                    $top_cat = $top_infos['top_cat'];
                    foreach($top_cat as $cat){
                        $top_cat_id = $cat->term_id;
                    }

                    $list_souscat  = array();
                    $top_souscat   = get_the_terms($id_top, 'concept');
                    foreach($top_souscat as $souscat){
                        array_push($list_souscat, $souscat->slug);
                    }

                    $tournois_in_cat     = new WP_Query(array(
                        'ignore_sticky_posts'    => true,
                        'update_post_meta_cache' => false,
                        'no_found_rows'          => true,
                        'post_type'              => 'tournoi',
                        'post__not_in'           => $list_t_already_done,
                        'orderby'                => 'rand',
                        'order'                  => 'ASC',
                        'posts_per_page'         => 4,
                        'tax_query' => array(
                            'relation' => 'AND',
                            array(
                                'taxonomy' => 'categorie',
                                'field'    => 'term_id',
                                'terms'    => array($top_cat_id)
                            ),
                            array(
                                'taxonomy' => 'concept',
                                'field' => 'slug',
                                'terms' => $list_souscat
                            )
                        )
                    ));
                    ?>
                    <?php if($tournois_in_cat->have_posts()): ?>
                        <section class="list-tournois mb-3 animate__fadeInUp animate__animated animate__delay-2s">
                            <div class="big-cat">
                                <div class="heading-cat">
                                    <div class="row">
                                        <div class="col">
                                            <h2 class="text-primary text-uppercase">
                                                <span class="ico">🥰</span> Tops similaires
                                                <small class="text-muted">Voici quelques Tops qui devraient te plaire</small>
                                            </h2>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="similar-list mt-2">
                                <div class="row">
                                    <?php
                                    while ($tournois_in_cat->have_posts()) : $tournois_in_cat->the_post(); ?>

                                        <?php get_template_part('partials/min-t'); ?>

                                    <?php endwhile;?>
                                </div>
                            </div>
                        </section>
                    <?php endif; ?>
                </div>
            </div>

            <div class="col-md-3 offset-md-1">

                <?php if(get_field('uuid_user_r', $id_ranking) == $uuiduser): ?>
                    <div class="related animate__backInDown animate__animated animate__delay-3s">
                        <div class="dorating">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title">
                                        <span class="ico">🙏</span> As-tu apprécié ce Top
                                    </h4>
                                    <h6 class="card-subtitle text-muted mb-1">
                                        Vos retours nous aident beaucoup à améliorer VAINKEURZ !
                                    </h6>
                                    <div class="card-stars">
                                        <?php
                                        $note = get_note($id_top, $uuiduser);
                                        if(isset($note["note_value"]) && $note["note_value"] > 0): ?>
                                            <div class="startchoicedone" style="display: block!important;">
                                                <span class="star_number">
                                                    <?php echo $note["note_value"]; ?>
                                                </span>
                                                <span class="ico">⭐️</span>
                                            </div>
                                        <?php else: ?>
                                            <div class="starchoice" data-id-top="<?php echo $id_top; ?>" data-uuiduser="<?php echo $uuiduser; ?>">
                                                <span class="star star-1" data-star="1">⭐️</span>
                                                <span class="star star-2" data-star="2">⭐️</span>
                                                <span class="star star-3" data-star="3">⭐️</span>
                                            </div>
                                            <div class="startchoicedone toshow-<?php echo $id_top; ?>">
                                                <span class="star_number"></span>
                                                <span class="ico">⭐️</span>
                                            </div>
                                        <?php endif; ?>
                                        <div class="commentbox mt-1">
                                            <a href="#" class="btn btn-outline-primary waves-effect" data-toggle="modal" data-target="#commentModal">
                                                Nous laisser un commentaire
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>

                <div class="related animate__fadeInUp animate__animated animate__delay-4s">

                    <?php $top_datas = get_top_data($id_top); ?>

                    <div class="card">
                        <div class="card-body">
                            <h2 class="font-weight-bolder mb-0">
                                <?php
                                $similar = get_user_percent(get_field('uuid_user_r', $id_ranking), $id_top);
                                if($similar['percent'] == 0){
                                    $wording_similar = "0% <small>des Top 3 identiques à celui-ci !</small>";
                                }
                                else{
                                    $wording_similar = $similar['percent']."% <small>des Top 3 identiques à celui-ci !</small>";
                                }
                                ?>
                                <?php echo $wording_similar; ?>
                            </h2>
                        </div>
                        <div class="card-footer" id="clt">
                            <a href="<?php the_permalink(get_page_by_path('elo')); ?>?id_top=<?php echo $id_top; ?>" class="btn btn-outline-primary waves-effect mb-1 mr-1">
                                Top mondial
                            </a>
                            <a href="<?php the_permalink(get_page_by_path('liste-des-tops')); ?>?id_top=<?php echo $id_top; ?>" class="btn btn-outline-primary waves-effect mb-1">
                                Voir les <?php echo $top_datas['nb_tops']; ?> Tops
                            </a>
                        </div>
                    </div>

                    <?php if(get_field('uuid_user_r', $id_ranking) == $uuiduser): ?>
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">
                                    <span class="ico">😎</span> Partage ton classement
                                </h4>
                                <h6 class="card-subtitle text-muted mb-1">
                                    Il est temps de revendiquer et assumer ses choix !
                                </h6>
                                <div class="btn-group justify-content-center share-t w-100" role="group">
                                    <?php
                                    $url_ranking = get_permalink($id_ranking);
                                    ?>
                                    <a href="https://twitter.com/intent/tweet?text=Voici mon TOP <?php echo $top_number; ?> <?php echo $top_title; ?>&via=vainkeurz&hashtags=VKRZ&url=<?php echo $url_ranking; ?>" target="_blank" title="Tweet" class="btn btn-icon btn-outline-primary">
                                        <i class="fab fa-twitter"></i>
                                    </a>
                                    <a href="whatsapp://send?text=<?php echo $url_ranking; ?>" data-action="share/whatsapp/share" class="btn btn-icon btn-outline-primary">
                                        <i class="fab fa-whatsapp"></i>
                                    </a>
                                    <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo $url_ranking; ?>" title="Partager sur Facebook" target="_blank" class="btn btn-icon btn-outline-primary">
                                        <i class="fab fa-facebook-f"></i>
                                    </a>
                                    <a href="javascript: void(0)" class="sharelinkbtn btn btn-icon btn-outline-primary" data-toggle="tooltip" data-placement="top" title="" data-original-title="Copier le lien de ton Top">
                                        <input type="text" value="<?php echo $url_ranking; ?>" class="input_to_share">
                                        <i class="far fa-link"></i>
                                    </a>
                                </div>
                            </div>
                        </div>

                    <?php endif; ?>

                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">
                                <span class="ico">🤪</span> Fais tourner le Top
                            </h4>
                            <h6 class="card-subtitle text-muted mb-1">
                                Plus on est de fou plus on .. TOP !
                            </h6>
                            <div class="btn-group justify-content-center share-t w-100" role="group">
                                <a href="https://twitter.com/intent/tweet?text=J'ai fait mon TOP <?php echo $top_number; ?> <?php echo $top_title; ?> maintenant c'est à vous 🤪🤪 &via=vainkeurz&hashtags=VKRZ&url=<?php echo $top_url; ?>" target="_blank" title="Tweet" class="btn btn-icon btn-outline-primary">
                                    <i class="fab fa-twitter"></i>
                                </a>
                                <a href="whatsapp://send?text=<?php echo $top_url; ?>" data-action="share/whatsapp/share" class="btn btn-icon btn-outline-primary">
                                    <i class="fab fa-whatsapp"></i>
                                </a>
                                <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo $top_url; ?>" title="Partager sur Facebook" target="_blank" class="btn btn-icon btn-outline-primary">
                                    <i class="fab fa-facebook-f"></i>
                                </a>
                                <a href="javascript: void(0)" class="sharelinkbtn2 btn btn-icon btn-outline-primary" data-toggle="tooltip" data-placement="top" title="" data-original-title="Copier le lien du Top">
                                    <input type="text" value="<?php echo $top_url; ?>" class="input_to_share2">
                                    <i class="far fa-link"></i>
                                </a>
                            </div>
                        </div>
                    </div>

                    <?php if(get_field('uuid_user_r', $id_ranking) == $uuiduser): ?>

                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">
                                    <span class="ico">🙃</span> Tu t'attendais pas à ça ?
                                </h4>
                                <h6 class="card-subtitle text-muted mb-1">
                                    T'inquiète on te laisse refaire le Top
                                </h6>
                                <a data-phrase1="Es-tu sûr de toi ?" data-phrase2="Tous les votes de ce Top seront remis à 0" data-id_ranking="<?php echo $id_ranking; ?>" data-id_vainkeur="<?php echo $id_vainkeur; ?>" href="#" class="confirm_delete btn btn-outline-primary waves-effect">
                                    Recommencer
                                </a>
                            </div>
                        </div>

                    <?php else: ?>

                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">
                                    <span class="ico">🤬</span> D'accord ou pas d'accord avec ce Podium ?
                                </h4>
                                <h6 class="card-subtitle text-muted mb-1">
                                    Il est temps d'exprimer et de revendiquer ton propre avis !
                                </h6>
                                <a href="<?php echo $top_url; ?>" class="btn btn-outline-primary waves-effect">
                                    Faire mon propre Top !
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
<?php get_footer(); ?>