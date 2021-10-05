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
if ($id_vainkeur) {
    $current_id_vainkeur = $id_vainkeur;
}
$id_ranking    = get_user_ranking_id($id_top, $uuiduser);
if ($id_ranking) {
    extract(get_next_duel($id_ranking, $id_top, $current_id_vainkeur));
    if (!$is_next_duel) {
        wp_redirect(get_the_permalink($id_ranking));
    }
}
get_header();
$top_datas          = get_top_data($id_top);
$creator_id         = get_post_field('post_author', $id_top);
$creator_uuiduser   = get_field('uuiduser_user', 'user_' . $creator_id);
$creator_data       = get_user_infos($creator_uuiduser);
?>
<div class="app-content content cover" style="background: url(<?php echo $top_infos['top_cover']; ?>) center center no-repeat">
    <div class="content-overlay"></div>
    <div class="content-wrapper">
        <div class="content-body tournoi-content">

            <?php if (!$id_ranking) : ?>

                <div class="content-intro container intro-sponso">

                    <div class="row match-height">
                        <div class="col-md-4">
                            <div class="card animate__animated animate__flipInX card-developer-meetup">
                                <div class="card-body rules-content">
                                    <div class="d-flex justify-content-between align-items-center mb-1">
                                        <div class="title-win">
                                            <h4>
                                                Une Switch Lite à gagner
                                            </h4>
                                        </div>
                                        <div class="mr-1 ml-3">
                                            <span class="icone-cadeau">🎁</span>
                                        </div>
                                    </div>
                                    <div class="text-rules">
                                        <p>Termine ton Top pour participer au tirage au sort afin de repartir avec ta <span class="t-rose">Switch Lite préférée</span> !</p>
                                        <p>Il te suffit de finir ce Top puis de RT + Follow le compte VAINKEURZ sur <a href="https://twitter.com/Vainkeurz" target="_blank" title="Twitter">Twitter</a> pour participer au tirage au sort.</p>
                                        <p>Bonne chance à toi !</p>
                                    </div>
                                </div>
                                <div class="card-footer timer-content-sponso">
                                    <p class="fs-12px">
                                        Fin du jeu le 1er octobre
                                    </p>
                                </div>
                                <div class="card-footer share-content-sponso">
                                    <div class="text-left">
                                        <p>Ce Top est proposé par nous mêmes 😘</p>
                                    </div>
                                    <div class="d-flex align-items-center">
                                        <div class="logo-vkrz-sponso">
                                            <img src="<?php bloginfo('template_directory'); ?>/assets/images/vkrz/logo-vkrz.png" alt="VAINKEURZ logo" class="img-fluid">
                                        </div>
                                        <div class="mt-2 social-media-sponso">
                                            <div class="d-flex buttons-social-media">
                                                <a href="https://twitter.com/Vainkeurz" class="w-100 animate__jello animate__animated animate__delay-1s btn btn-max btn-outline-primary waves-effect waves-float waves-light" target="_blank">
                                                    TWITTER
                                                </a>
                                                <a href="https://www.instagram.com/wearevainkeurz/" class="w-100 animate__jello animate__animated animate__delay-1s btn btn-max btn-outline-primary waves-effect waves-float waves-light" target="_blank">
                                                    INSTAGRAM
                                                </a>
                                                <a href="https://discord.gg/E9H9e8NYp7" class="w-100 animate__jello animate__animated animate__delay-1s btn btn-max btn-outline-primary waves-effect waves-float waves-light" target="_blank">
                                                    DISCORD
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer share-top-sponsor d-flex align-items-baseline justify-content-between">
                                    <h6 class="share-text">
                                        Partage le lien du Top 👉
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
                        <div class="col-md-8 start-top">
                            <div class="intro">
                                <div class="card animate__animated animate__flipInX card-developer-meetup">
                                    <div class="meetup-img-wrapper rounded-top text-left" style="background-image: url(<?php echo $top_infos['top_img']; ?>);">
                                        <span class="badge badge-light-primary">Créé le <?php echo $top_infos['top_date']; ?></span>
                                        <span class="badge badge-light-rose ml-0">Top sponsorisé</span>
                                        <div class="voile_contenders"></div>
                                        <?php if ($top_infos['top_number'] < 30) : ?>
                                            <div class="avatar-group list-contenders">
                                                <?php $contenders_t = new WP_Query(array(
                                                    'post_type' => 'contender', 'orderby' => 'date', 'posts_per_page' => '-1',
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
                                        <?php if (get_field('precision_t', $id_top)) : ?>
                                            <div class="card-precision">
                                                <p class="card-text mb-1">
                                                    <?php the_field('precision_t', $id_top); ?>
                                                </p>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                    <div class="card-cta">
                                        <div class="choosecta">
                                            <div class="cta-begin cta-top3">
                                                <a href="#" id="begin_top3" data-typetop="top3" data-top="<?php echo $id_top; ?>" data-uuiduser="<?php echo $uuiduser; ?>" class="w-100 animate__jello animate__animated animate__delay-1s btn btn-max btn-primary waves-effect waves-float waves-light laucher_t">
                                                    Top 3
                                                </a>
                                                <small class="text-muted">
                                                    <?php
                                                    $max = (floor($top_infos['top_number'] / 2)) + (3 * ((round($top_infos['top_number'] / 2)) - 1));
                                                    $min = (floor($top_infos['top_number'] / 2)) + ((round($top_infos['top_number'] / 2)) - 1) + 3;
                                                    $moy = ($max + $min) / 2;
                                                    ?>
                                                    Prévoir environ <?php echo round($moy); ?> votes pour juste faire ton podium
                                                </small>
                                            </div>
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
                                                            Une Switch Lite
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
                </div>

            <?php else : ?>

                <div class="intro-mobile">
                    <div class="tournament-heading text-center">
                        <h3 class="mb-0 t-titre-tournoi">Top <?php echo $top_infos['top_number']; ?> <span class="ico">⚔️</span> <?php echo $top_infos['top_title']; ?></h3>
                        <h4 class="text-center t-question">
                            <?php echo $top_infos['top_question']; ?> <br>
                        </h4>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <?php if ($top_infos['top_type'] != "top3") : ?>
                            <div class="container-fluid d-none d-sm-block">
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

                        <div class="container <?php echo (get_field('c_rounded_t', $id_top)) ? 'rounded' : ''; ?>">
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