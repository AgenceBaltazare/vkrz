<?php
global $user_id;
global $uuiduser;
global $id_vainkeur;
global $id_ranking;
global $id_top;
global $is_next_duel;
global $top_infos;
global $utm;
global $user_infos;
global $user_tops;
$user_id       = get_user_logged_id();
$utm           = deal_utm();
$id_top        = get_the_ID();
$user_tops     = get_user_tops();
$uuiduser      = deal_uuiduser();
$user_infos    = deal_vainkeur_entry();
$id_vainkeur   = $user_infos['id_vainkeur'];
if($id_vainkeur){
    $current_id_vainkeur = $id_vainkeur;
}
$id_ranking    = get_user_ranking_id($id_top, $uuiduser);
if($id_ranking){
    extract(get_next_duel($id_ranking, $id_top, $current_id_vainkeur));
    if(!$is_next_duel){
        wp_redirect(get_the_permalink($id_ranking));
    }
}
get_header();
$top_datas          = get_top_data($id_top);
$creator_id         = get_post_field('post_author', $id_top);
$creator_uuiduser   = get_field('uuiduser_user', 'user_'.$creator_id);
$creator_data       = get_user_infos($creator_uuiduser);
?>
<div class="app-content content cover <?php if(get_field('sponso_t', $id_top)){echo 'top-sponso';} ?>" style="background: url(<?php echo $top_infos['top_cover']; ?>) center center no-repeat">
    <div class="content-overlay"></div>
    <div class="content-wrapper">
        <div class="content-body tournoi-content">

            <?php if(!$id_ranking): ?>

                <div class="content-intro">

                    <?php
                    if(get_field('sponso_t', $id_top)) : ?>

                        <div class="row equalH">
                            <div class="col-md-4">
                                <div class="card animate__animated animate__flipInX card-developer-meetup">
                                    <div class="card-body rules-content">
                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                            <div class="title-win">
                                                <h4>
                                                    Une switch à gagner
                                                </h4>
                                            </div>
                                            <div class="mr-1 ml-3">
                                                <span class="icone-cadeau">🎁</span>
                                            </div>
                                        </div>
                                        <div class="text-rules">
                                            <p>Termine ton Top pour participer au tirage au sort afin de repartir avec ta <span class="t-rose">switch préférée</span> !</p>
                                            <p>Il te suffit de finir ce Top puis de Follow le compte VAINKEURZ sur <span><a href="https://www.instagram.com/wearevainkeurz/" target="_blank" title="Instagram">Insta</a></span> ou <span><a href="https://twitter.com/Vainkeurz" target="_blank" title="Twitter">Twitter</a></span> pour participer au tirage au sort.</p>
                                            <p>Bonne chance à toi !</p>
                                        </div>
                                    </div>
                                    <div class="card-footer timer-content-sponso">
                                        <p class="fs-12px">
                                            Temps avant la fin de la sponso :
                                        </p>
                                        <div class="">
                                            <p id="timer-sponso"></p>
                                        </div>
                                        <a href="#" class="fs-12px grey bb">
                                            Règlement
                                        </a>
                                    </div>
                                    <div class="card-footer share-content-sponso">
                                        <div class="d-flex justify-content-between">
                                            <div class="logo-vkrz-sponso d-flex align-items-center">
                                                <img src="<?php bloginfo('template_directory'); ?>/assets/images/vkrz/logo-vkrz.png" alt="VAINKEURZ logo" class="">
                                            </div>
                                            <div class="mt-2 social-media-sponso">
                                                <div class="text-left">
                                                    <p>Ce Top est proposé par VAINKEURZ</p>
                                                </div>
                                                <div class="d-flex buttons-social-media">
                                                    <a href="https://twitter.com/Vainkeurz" class="w-100 animate__jello animate__animated animate__delay-1s btn btn-max btn-primary waves-effect waves-float waves-light">
                                                        TWITTER
                                                    </a>
                                                    <a href="https://www.instagram.com/wearevainkeurz/" class="w-100 animate__jello animate__animated animate__delay-1s btn btn-max btn-primary waves-effect waves-float waves-light">
                                                        INSTAGRAM
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-footer share-top-sponsor d-flex align-items-baseline justify-content-between">
                                        <h6 class="share-text">
                                            Partage le lien du Top
                                        </h6>
                                        <div class="btn-group justify-content-center share-t w-60" role="group">
                                            <a href="https://twitter.com/intent/tweet?text=J'ai fait mon TOP <?php echo $top_infos['top_number']; ?> <?php echo $top_infos['top_title']; ?> maintenant c'est à vous 🤪🤪 &via=vainkeurz&hashtags=VKRZ&url=<?php echo $top_infos['top_url']; ?>" target="_blank" title="Tweet" class="btn btn-icon btn-outline-primary">
                                                <i class="fab fa-twitter"></i>
                                            </a>
                                            <a href="whatsapp://send?text=<?php echo $top_infos['top_url']; ?>" data-action="share/whatsapp/share" class="btn btn-icon btn-outline-primary">
                                                <i class="fab fa-whatsapp"></i>
                                            </a>
                                            <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo $top_infos['top_url']; ?>" title="Partager sur Facebook" target="_blank" class="btn btn-icon btn-outline-primary">
                                                <i class="fab fa-facebook-f"></i>
                                            </a>
                                            <a href="javascript: void(0)" class="sharelinkbtn2 btn btn-icon btn-outline-primary" data-toggle="tooltip" data-placement="top" title="" data-original-title="Copier le lien du Top">
                                                <input type="text" value="<?php echo $top_infos['top_url']; ?>" class="input_to_share2">
                                                <i class="far fa-link"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="intro">
                                    <div class="card animate__animated animate__flipInX card-developer-meetup">
                                        <div class="meetup-img-wrapper rounded-top text-left" style="background-image: url(<?php echo $top_infos['top_img']; ?>);">
                                            <span class="badge badge-light-primary">Créé le <?php echo $top_infos['top_date']; ?></span>
                                            <div class="voile_contenders"></div>
                                            <?php if($top_infos['top_number'] < 30): ?>
                                                <div class="avatar-group list-contenders">
                                                    <?php $contenders_t = new WP_Query(array('post_type' => 'contender', 'orderby' => 'date', 'posts_per_page' => '-1',
                                                        'meta_query'     => array(
                                                            array(
                                                                'key'     => 'id_tournoi_c',
                                                                'value'   => $id_top,
                                                                'compare' => '=',
                                                            )
                                                        )
                                                    )); ?>
                                                    <?php while ($contenders_t->have_posts()) : $contenders_t->the_post(); ?>
                                                        <div data-toggle="tooltip" data-popup="tooltip-custom" data-placement="top" data-original-title="<?php echo get_the_title(get_the_id()); ?>" class="avatar pull-up">
                                                            <?php $illu = get_the_post_thumbnail_url(get_the_id(), 'medium'); ?>
                                                            <img src="<?php echo $illu; ?>" alt="Avatar" height="32" width="32">
                                                        </div>
                                                    <?php endwhile; ?>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                        <div class="card-body">
                                            <div class="meetup-header d-flex align-items-center justify-content-center">
                                                <div class="my-auto">
                                                    <h4 class="card-title mb-25">
                                                        Top <?php echo $top_infos['top_number']; ?> ⚡ <?php echo $top_infos['top_title']; ?>
                                                    </h4>
                                                    <p class="card-text mb-0 t-rose animate__animated animate__flash">
                                                        <?php echo $top_infos['top_question']; ?>
                                                    </p>
                                                </div>
                                            </div>
                                            <?php if(get_field('precision_t', $id_top)): ?>
                                                <div class="card-precision">
                                                    <p class="card-text mb-1">
                                                        <?php the_field('precision_t', $id_top); ?>
                                                    </p>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                        <div class="card-cta">
                                            <div class="choosecta">
                                                <div class="cta-begin cta-complet">
                                                    <a href="#" id="begin_t" data-typetop="complet" data-top="<?php echo $id_top; ?>" data-uuiduser="<?php echo $uuiduser; ?>" class="w-100 animate__jello animate__animated animate__delay-1s btn btn-max btn-primary waves-effect waves-float waves-light laucher_t">
                                                        Top Complet
                                                    </a>
                                                    <small class="text-muted">
                                                        <?php
                                                        $min = ($top_infos['top_number'] - 5) * 2 + 6;
                                                        $max = $min * 2;
                                                        ?>
                                                        <?php if($top_infos['top_number'] < 3): ?>
                                                            Un seul vote suffira pour finir ce Top
                                                        <?php else: ?>
                                                            Prévoir entre <?php echo $min; ?> et <?php echo $max; ?> votes pour finir ton Top du 1er au dernier
                                                        <?php endif; ?>
                                                    </small>
                                                </div>
                                                <?php if($top_infos['top_number'] > 10): ?>
                                                    <div class="cta-begin cta-top3">
                                                        <a href="#" id="begin_top3" data-typetop="top3" data-top="<?php echo $id_top; ?>" data-uuiduser="<?php echo $uuiduser; ?>" class="w-100 animate__jello animate__animated animate__delay-1s btn btn-max btn-primary waves-effect waves-float waves-light laucher_t">
                                                            Top 3
                                                        </a>
                                                        <small class="text-muted">
                                                            <?php
                                                            $max = (floor($top_infos['top_number']/2))+(3*((round($top_infos['top_number']/2))-1));
                                                            $min = (floor($top_infos['top_number']/2))+((round($top_infos['top_number']/2))-1)+3;
                                                            $moy = ($max+$min) / 2;
                                                            ?>
                                                            Prévoir environ <?php echo round($moy); ?> votes pour juste faire ton podium
                                                        </small>
                                                    </div>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                        <div class="card-footer">
                                            <div class="row meetings align-items-center">
                                                <div class="col">
                                                    <div class="infos-card-t info-card-t-v d-flex align-items-center">
                                                        <div class="mr-1">
                                                            <span class="ico">💎</span>
                                                        </div>
                                                        <div class="content-body text-left">
                                                            <h4 class="mb-0">
                                                                <?php echo $top_datas['nb_votes']; ?>
                                                            </h4>
                                                            <small class="text-muted">votes réalisés</small>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col">
                                                    <div class="infos-card-t d-flex align-items-center">
                                                        <div class="mr-1">
                                                            <span class="ico">🏆</span>
                                                        </div>
                                                        <div class="content-body text-left">
                                                            <h4 class="mb-0">
                                                                <?php echo $top_datas['nb_tops']; ?>
                                                            </h4>
                                                            <small class="text-muted">Tops terminés</small>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col">
                                                    <div class="infos-card-t d-flex align-items-center">
                                                        <div class="mr-1">
                                                            <span class="ico">🎁</span>
                                                        </div>
                                                        <div class="content-body text-left">
                                                            <h4 class="mb-0">
                                                                <?php echo $top_datas['nb_cadeaux']; ?>
                                                            </h4>
                                                            <small class="text-muted">de ton choix</small>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>  
                                </div>
                            </div>
                        </div>

                    <?php else: ?>

                        <div class="intro">
                            <div class="card animate__animated animate__flipInX card-developer-meetup">
                                <div class="meetup-img-wrapper rounded-top text-left" style="background-image: url(<?php echo $top_infos['top_img']; ?>);">
                                    <span class="badge badge-light-primary">Créé le <?php echo $top_infos['top_date']; ?></span>
                                    <div class="voile_contenders"></div>
                                    <?php if($top_infos['top_number'] < 30): ?>
                                        <div class="avatar-group list-contenders">
                                            <?php $contenders_t = new WP_Query(array('post_type' => 'contender', 'orderby' => 'date', 'posts_per_page' => '-1',
                                                'meta_query'     => array(
                                                    array(
                                                        'key'     => 'id_tournoi_c',
                                                        'value'   => $id_top,
                                                        'compare' => '=',
                                                    )
                                                )
                                            )); ?>
                                            <?php while ($contenders_t->have_posts()) : $contenders_t->the_post(); ?>
                                                <div data-toggle="tooltip" data-popup="tooltip-custom" data-placement="top" data-original-title="<?php echo get_the_title(get_the_id()); ?>" class="avatar pull-up">
                                                    <?php $illu = get_the_post_thumbnail_url(get_the_id(), 'medium'); ?>
                                                    <img src="<?php echo $illu; ?>" alt="Avatar" height="32" width="32">
                                                </div>
                                            <?php endwhile; ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                <div class="card-body">
                                    <div class="meetup-header d-flex align-items-center justify-content-center">
                                        <div class="my-auto">
                                            <h4 class="card-title mb-25">
                                                Top <?php echo $top_infos['top_number']; ?> ⚡ <?php echo $top_infos['top_title']; ?>
                                            </h4>
                                            <p class="card-text mb-0 t-rose animate__animated animate__flash">
                                                <?php echo $top_infos['top_question']; ?>
                                            </p>
                                        </div>
                                    </div>
                                    <?php if(get_field('precision_t', $id_top)): ?>
                                        <div class="card-precision">
                                            <p class="card-text mb-1">
                                                <?php the_field('precision_t', $id_top); ?>
                                            </p>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                <div class="card-cta">
                                    <div class="choosecta">
                                        <div class="cta-begin cta-complet">
                                            <a href="#" id="begin_t" data-typetop="complet" data-top="<?php echo $id_top; ?>" data-uuiduser="<?php echo $uuiduser; ?>" class="w-100 animate__jello animate__animated animate__delay-1s btn btn-max btn-primary waves-effect waves-float waves-light laucher_t">
                                                Top Complet
                                            </a>
                                            <small class="text-muted">
                                                <?php
                                                $min = ($top_infos['top_number'] - 5) * 2 + 6;
                                                $max = $min * 2;
                                                ?>
                                                <?php if($top_infos['top_number'] < 3): ?>
                                                    Un seul vote suffira pour finir ce Top
                                                <?php else: ?>
                                                    Prévoir entre <?php echo $min; ?> et <?php echo $max; ?> votes pour finir ton Top du 1er au dernier
                                                <?php endif; ?>
                                            </small>
                                        </div>
                                        <?php if($top_infos['top_number'] > 10): ?>
                                            <div class="cta-begin cta-top3">
                                                <a href="#" id="begin_top3" data-typetop="top3" data-top="<?php echo $id_top; ?>" data-uuiduser="<?php echo $uuiduser; ?>" class="w-100 animate__jello animate__animated animate__delay-1s btn btn-max btn-primary waves-effect waves-float waves-light laucher_t">
                                                    Top 3
                                                </a>
                                                <small class="text-muted">
                                                    <?php
                                                    $max = (floor($top_infos['top_number']/2))+(3*((round($top_infos['top_number']/2))-1));
                                                    $min = (floor($top_infos['top_number']/2))+((round($top_infos['top_number']/2))-1)+3;
                                                    $moy = ($max+$min) / 2;
                                                    ?>
                                                    Prévoir environ <?php echo round($moy); ?> votes pour juste faire ton podium
                                                </small>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <div class="row meetings align-items-center">
                                        <div class="col">
                                            <div class="infos-card-t info-card-t-v d-flex align-items-center">
                                                <div class="mr-1">
                                                    <span class="ico">💎</span>
                                                </div>
                                                <div class="content-body text-left">
                                                    <h4 class="mb-0">
                                                        <?php echo $top_datas['nb_votes']; ?>
                                                    </h4>
                                                    <small class="text-muted">votes réalisés</small>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="infos-card-t d-flex align-items-center">
                                                <div class="mr-1">
                                                    <span class="ico">🏆</span>
                                                </div>
                                                <div class="content-body text-left">
                                                    <h4 class="mb-0">
                                                        <?php echo $top_datas['nb_tops']; ?>
                                                    </h4>
                                                    <small class="text-muted">Tops terminés</small>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="infos-card-t d-flex align-items-center infos-card-t-c">
                                                <div class="">
                                                    <a href="<?php the_permalink(218587); ?>?creator_id=<?php echo $creator_id; ?>" target="_blank">
                                                        <div class="avatar me-50">
                                                            <img src="<?php echo $creator_data['avatar']; ?>" alt="Avatar" width="38" height="38">
                                                        </div>
                                                    </a>
                                                </div>
                                                <div class="content-body text-left">
                                                    <small class="text-muted">Conçu par</small>
                                                    <h4 class="mb-0 link-creator">
                                                        <a href="<?php the_permalink(218587); ?>?creator_id=<?php echo $creator_id; ?>" target="_blank" class="link-to-creator">
                                                            <?php echo $creator_data['pseudo']; ?>
                                                            <span class="ico" data-toggle="tooltip" data-placement="top" title="" data-original-title="Niveau actuel">
                                                                <?php echo $creator_data['level']; ?>
                                                            </span>
                                                            <?php if($creator_data['user_role']  == "administrator"): ?>
                                                                <span class="ico" data-toggle="tooltip" data-placement="top" title="" data-original-title="TeamVKRZ">
                                                                    🦙
                                                                </span>
                                                            <?php endif; ?>
                                                            <?php if($creator_data['user_role']  == "administrator" || $creator_data['user_role'] == "author"): ?>
                                                                <span class="ico" data-toggle="tooltip" data-placement="top" title="" data-original-title="Créateur de Tops">
                                                                    🎨
                                                                </span>
                                                            <?php endif; ?>
                                                        </a>
                                                    </h4>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    <?php endif; ?>
  
                </div>

            <?php else: ?>

                <div class="intro-mobile">
                    <div class="tournament-heading text-center">
                        <h3 class="mb-0 t-titre-tournoi">Top <?php echo $top_infos['top_number']; ?> <span class="ico">⚔️</span> <?php echo $top_infos['top_title']; ?></h3>
                        <h4 class="text-center t-question">
                            <?php echo $top_infos['top_question']; ?> <br>
                        </h4>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-9 col-lg-10">

                        <?php if($top_infos['top_type'] != "top3"): ?>
                            <div class="container-fluid">
                                <div class="tournoi-infos mb-2">
                                    <div class="display_current_user_rank">
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="current_rank">
                                                    <?php
                                                    set_query_var('current_user_ranking_var', compact('id_ranking', 'id_top'));
                                                    get_template_part('templates/parts/content', 'user-ranking');
                                                    ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>

                        <div class="<?php if(get_field('c_rounded_t', $id_top)){ echo 'rounded'; } ?> <?php if(get_field('full_w_t', $id_top)){ echo 'container container-cc'; } else { echo 'container'; } ?>">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="display_battle">
                                        <?php
                                        set_query_var('battle_vars', compact('contender_1', 'contender_2', 'id_top', 'id_ranking', 'id_vainkeur'));
                                        get_template_part('templates/parts/content', 'battle');
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-lg-2 mt-2">
                        <div class="related animate__fadeInUp animate__animated animate__delay-0s">

                            <div class="card text-left">
                                <div class="card-body">
                                    <h4 class="card-title">
                                        <span class="ico">🤪</span> Fais tourner le Top
                                    </h4>
                                    <h6 class="card-subtitle text-muted mb-1">
                                        Plus on est de fou plus on .. TOP !
                                    </h6>
                                    <div class="btn-group justify-content-center share-t w-100" role="group">
                                        <a href="https://twitter.com/intent/tweet?text=J'ai fait mon TOP <?php echo $top_infos['top_number']; ?> <?php echo $top_infos['top_title']; ?> maintenant c'est à vous 🤪🤪 &via=vainkeurz&hashtags=VKRZ&url=<?php echo $top_infos['top_url']; ?>" target="_blank" title="Tweet" class="btn btn-icon btn-outline-primary">
                                            <i class="fab fa-twitter"></i>
                                        </a>
                                        <a href="whatsapp://send?text=<?php echo $top_infos['top_url']; ?>" data-action="share/whatsapp/share" class="btn btn-icon btn-outline-primary">
                                            <i class="fab fa-whatsapp"></i>
                                        </a>
                                        <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo $top_infos['top_url']; ?>" title="Partager sur Facebook" target="_blank" class="btn btn-icon btn-outline-primary">
                                            <i class="fab fa-facebook-f"></i>
                                        </a>
                                        <a href="javascript: void(0)" class="sharelinkbtn2 btn btn-icon btn-outline-primary" data-toggle="tooltip" data-placement="top" title="" data-original-title="Copier le lien du Top">
                                            <input type="text" value="<?php echo $top_infos['top_url']; ?>" class="input_to_share2">
                                            <i class="far fa-link"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>

                            <div class="card text-left">
                                <div class="card-body">
                                    <h4 class="card-title">
                                        <span class="ico">🙃</span> T'as fais une bavure ?
                                    </h4>
                                    <h6 class="card-subtitle text-muted mb-1">
                                        T'inquiète on te laisse refaire le Top
                                    </h6>
                                    <a data-phrase1="Es-tu sûr de toi ?" data-phrase2="Tous les votes de ce Top seront remis à 0" data-id_vainkeur="<?php echo $id_vainkeur; ?>" data-id_ranking="<?php echo $id_ranking; ?>" href="#" class="confirm_delete btn btn-outline-primary waves-effect">
                                        Recommencer
                                    </a>
                                </div>
                            </div>
                            
                            <div class="card text-left">
                                <div class="card-body">
                                    <h4 class="card-title">
                                        <?php
                                        date_default_timezone_set('Europe/Paris');
                                        $origin     = new DateTime(get_the_date('Y-m-d', $id_top));
                                        $target     = new DateTime(date('Y-m-d'));
                                        $interval   = $origin->diff($target);
                                        if($interval->days == 0){
                                            $info_date = "aujourd'hui";
                                        }
                                        elseif($interval->days == 1){
                                            $info_date = "hier";
                                        }
                                        else{
                                            $info_date = "depuis ".$interval->days." jours";
                                        }
                                        ?>
                                        <span class="ico">🎂</span> Créé <span class="t-violet"><?php echo $info_date; ?></span> par :
                                    </h4>
                                    <div class="employee-task d-flex justify-content-between align-items-center">
                                        <a href="<?php echo $creator_data['profil']; ?>" class="d-flex flex-row link-to-creator">
                                            <div class="avatar me-75 mr-1">
                                                <img src="<?php echo $creator_data['avatar']; ?>" class="circle" width="42" height="42" alt="Avatar">
                                            </div>
                                            <div class="my-auto">
                                                <h3 class="mb-0">
                                                    <?php echo $creator_data['pseudo']; ?> <br>
                                                    <span class="ico" data-toggle="tooltip" data-placement="top" title="" data-original-title="Niveau actuel">
                                                        <?php echo $creator_data['level']; ?>
                                                    </span>
                                                    <?php if($creator_data['user_role']  == "administrator"): ?>
                                                        <span class="ico" data-toggle="tooltip" data-placement="top" title="" data-original-title="TeamVKRZ">
                                                            🦙
                                                        </span>
                                                    <?php endif; ?>
                                                    <?php if($creator_data['user_role']  == "administrator" || $creator_data['user_role'] == "author"): ?>
                                                        <span class="ico" data-toggle="tooltip" data-placement="top" title="" data-original-title="Créateur de Tops">
                                                            🎨
                                                        </span>
                                                    <?php endif; ?>
                                                </h3>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            </div>

                            <div class="card text-left">
                                <div class="card-body">
                                    <h4 class="card-title">
                                        <span class="ico">💬</span> <?php echo $top_datas['nb_comments']; ?>
                                        <?php if($top_datas['nb_comments'] <= 1): ?>
                                            Commentaire
                                        <?php else: ?>
                                            Commentaires
                                        <?php endif; ?>
                                    </h4>
                                    <h6 class="card-subtitle text-muted mb-1">
                                        Tout ce qui te passe par la tête à propos de ce Top mérite d'être partagé avec les autres Vainkeurs.
                                    </h6>
                                    <a href="<?php echo get_the_permalink(get_page_by_path('discuz')).'?id_top='.$id_top; ?>" class="btn btn-outline-primary waves-effect">
                                        Lire & poster
                                    </a>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

                <?php
                set_query_var('steps_var', compact('current_step'));
                get_template_part('templates/parts/content', 'step-bar');
                ?>

            <?php endif; ?>
        </div>
    </div>
</div>

<?php get_footer(); ?>
