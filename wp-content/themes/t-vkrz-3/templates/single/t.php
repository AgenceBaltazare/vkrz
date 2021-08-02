<?php
global $uuiduser;
global $user_id;
global $id_tournament;
global $id_ranking;
global $is_next_duel;
global $id_tournament;
global $is_next_duel;
global $utm;
global $typetop;
global $champion_id;
$champion_info = get_userdata($champion_id);
if(is_user_logged_in()){
    $current_user   = wp_get_current_user();
    $user_id        = $current_user->ID;
    $user_name      = $current_user->display_name;
    $user_email     = $current_user->user_email;
    $user_info      = get_userdata($user_id);
    $user_role      = $user_info->roles[0];

}
global $user_name;
global $user_email;
$uuiduser      = deal_uuiduser();
$utm           = deal_utm();
$id_tournament = get_the_ID();
$id_ranking    = get_or_create_ranking_if_not_exists($id_tournament, $uuiduser);
if($id_ranking){
    extract(get_next_duel($id_ranking, $id_tournament));
    if(!$is_next_duel){
        wp_redirect(get_the_permalink($id_ranking));
    }
}
wp_reset_postdata();
get_header();
global $top_url;
global $top_title;
global $top_question;
global $top_img;
global $top_number;
$illu       = wp_get_attachment_image_src(get_field('cover_t', $id_tournament), 'full');
$illu_url   = $illu[0];
?>
<div class="app-content content cover" style="background: url(<?php echo $illu_url; ?>) center center no-repeat">
    <div class="content-overlay"></div>
    <div class="content-wrapper">
        <div class="content-body tournoi-content">

            <?php if(!$id_ranking): ?>

                <div class="content-intro">
                    <?php
                    $illu          = get_the_post_thumbnail_url($id_tournament, 'large');
                    $top_datas     = get_tournoi_data($id_tournament, $uuiduser);
                    ?>
                    <div class="intro">

                        <div class="card animate__animated animate__flipInX card-developer-meetup">
                            <div class="meetup-img-wrapper rounded-top text-left" style="background-image: url(<?php echo $illu; ?>);">
                                <span class="badge badge-light-primary">Créé le <?php echo $top_datas[0]['date_of_t']; ?></span>
                                <div class="voile_contenders"></div>
                                <?php if($top_number < 30): ?>
                                    <div class="avatar-group list-contenders">
                                        <?php $contenders_t = new WP_Query(array('post_type' => 'contender', 'orderby' => 'date', 'posts_per_page' => '-1',
                                            'meta_query'     => array(
                                                array(
                                                    'key'     => 'id_tournoi_c',
                                                    'value'   => $id_tournament,
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
                                            Top <?php echo $top_number; ?> - <?php echo $top_title; ?>
                                        </h4>
                                        <p class="card-text mb-0 t-rose animate__animated animate__flash">
                                            <?php echo $top_question; ?>
                                        </p>
                                    </div>
                                </div>
                                <?php if(get_field('precision_t', $id_tournament)): ?>
                                    <div class="card-precision">
                                        <p class="card-text mb-1">
                                            <?php the_field('precision_t', $id_tournament); ?>
                                        </p>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <div class="card-cta">
                                <div class="choosecta">
                                    <div class="cta-begin cta-complet">
                                        <a href="#" id="begin_t" data-typetop="complet" data-tournament="<?php echo $id_tournament; ?>" data-uuiduser="<?php echo $uuiduser; ?>" class="animate__jello animate__animated animate__delay-1s btn btn-max btn-primary waves-effect waves-float waves-light laucher_t">
                                            Débuter mon Top Complet
                                        </a>
                                        <small class="text-muted">
                                            <?php
                                            $min = ($top_number - 5) * 2 + 6;
                                            $max = $min * 2;
                                            ?>
                                            <?php if($top_number < 3): ?>
                                                Un seul vote suffira pour finir ce Top
                                            <?php else: ?>
                                                Prévoir entre <?php echo $min; ?> et <?php echo $max; ?> votes pour finir ce Top
                                            <?php endif; ?>
                                        </small>
                                    </div>
                                    <?php if($top_number > 10): ?>
                                        <div class="cta-begin cta-top3">
                                            <a href="#" id="begin_top3" data-typetop="top3" data-tournament="<?php echo $id_tournament; ?>" data-uuiduser="<?php echo $uuiduser; ?>" class="animate__jello animate__animated animate__delay-1s btn btn-max btn-primary waves-effect waves-float waves-light laucher_t">
                                                Faire juste mon Top 3
                                            </a>
                                            <small class="text-muted">
                                                <?php
                                                $max = (floor($top_number/2))+(3*((round($top_number/2))-1));
                                                $min = (floor($top_number/2))+((round($top_number/2))-1)+3;
                                                $moy = ($max+$min) / 2;
                                                ?>
                                                Prévoir environ <?php echo round($moy); ?> votes pour finir ce Top
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
                                                    <?php echo $top_datas[0]['nb_votes']; ?>
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
                                                    <?php echo $top_datas[0]['nb_tops']; ?>
                                                </h4>
                                                <small class="text-muted">Tops terminés</small>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <?php
                                        $creator_data = get_creator_data(false, $id_tournament);
                                        ?>
                                        <div class="infos-card-t d-flex align-items-center infos-card-t-c">
                                            <div class="">
                                                <a href="<?php echo $creator_data[0]['creator_link']; ?>" target="_blank">
                                                    <div class="avatar me-50">
                                                        <?php
                                                        if(get_avatar_url($creator_data[0]['creator_id'], ['size' => '80'])){
                                                            $avatar_url = get_avatar_url($creator_data[0]['creator_id'], ['size' => '80']);
                                                        }
                                                        else{
                                                            $avatar_url = get_bloginfo('template_directory')."/assets/images/vkrz/ninja.png";
                                                        }
                                                        ?>
                                                        <img src="<?php echo $avatar_url; ?>" alt="Avatar" width="38" height="38">
                                                    </div>
                                                </a>
                                            </div>
                                            <div class="content-body text-left">
                                                <small class="text-muted">Conçu par</small>
                                                <h4 class="mb-0 link-creator">
                                                    <a href="<?php echo $creator_data[0]['creator_link']; ?>" target="_blank" class="text-uppercase">
                                                        <?php echo $creator_data[0]['creator_name']; ?>
                                                    </a>
                                                </h4>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            <?php else: ?>

                <div class="intro-mobile">
                    <div class="tournament-heading text-center">
                        <h3 class="mb-0 t-titre-tournoi">Top <?php echo $top_number; ?> <span class="ico">⚔️</span> <?php echo $top_title; ?></h3>
                        <h4 class="text-center t-question">
                            <?php echo $top_question; ?> <br>
                        </h4>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-9 col-lg-10">

                        <?php if($typetop != "top3"): ?>
                            <div class="container-fluid">
                                <div class="tournoi-infos mb-2">
                                    <div class="display_current_user_rank">
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="current_rank">
                                                    <?php
                                                    set_query_var('current_user_ranking_var', compact('id_ranking', 'id_tournament'));
                                                    get_template_part('templates/parts/content', 'user-ranking');
                                                    ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>

                        <div class="<?php if(get_field('c_rounded_t', $id_tournament)){ echo 'rounded'; } ?> <?php if(get_field('full_w_t', $id_tournament)){ echo 'container container-cc'; } else { echo 'container'; } ?>">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="display_battle">
                                        <?php
                                        set_query_var('battle_vars', compact('contender_1', 'contender_2', 'id_tournament', 'id_ranking'));
                                        get_template_part('templates/parts/content', 'battle');
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-lg-2 mt-2">
                        <div class="related animate__fadeInUp animate__animated animate__delay-0s">
                            <?php //if($champion_info->twitch_user): ?>
                            <?php $champion_info->twitch_user= "vainkeurz"; ?>
                            <script>
                                <?php
                                echo "var channel= '$champion_info->twitch_user';";  ?>
                            </script>
                            <div class="card text-left">
                                <div class="card-body">
                                    <h4 class="card-title">
                                        <span class="ico">🎙</span> Qui veut gagner des 💎?
                                    </h4>
                                    <h6 class="card-subtitle text-muted mb-1">
                                        C'est mon dernier mot Jean Pierre
                                    </h6>
                                    <a href="#" onclick="start_count(); show_twitch();" data-toggle="modal" data-target="#exampleModalCenter" class="btn btn-icon btn-outline-primary">
                                        <i class="fab fa-twitch"></i> Laisser le public voter
                                    </a>
                                </div>
                            </div>
                            <?php //endif; ?>

                            <div class="card text-left">
                                <div class="card-body">
                                    <h4 class="card-title">
                                        <span class="ico">🙃</span> T'as fais une bavure ?
                                    </h4>
                                    <h6 class="card-subtitle text-muted mb-1">
                                        T'inquiète on te laisse refaire le Top
                                    </h6>
                                    <a data-phrase1="Es-tu sûr de toi ?" data-phrase2="Tous les votes de ce Top seront remis à 0" data-idranking="<?php echo $id_ranking; ?>" href="#" class="confirm_delete btn btn-outline-primary waves-effect">
                                        Recommencer
                                    </a>
                                </div>
                            </div>

                            <div class="card text-left">
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

                            <!--
                            <div class="card chat-widget">
                                <div class="card-header">
                                    <div class="d-flex align-items-center">
                                        <h4 class="card-title">
                                            <span class="ico">🐱</span> Un truc à dire ?
                                        </h4>
                                    </div>
                                </div>
                                <section class="chat-app-window">
                                    <div class="user-chats">
                                        <div class="chats">
                                            <div class="chat chat-left">
                                                <div class="chat-avatar">
                                                    <span class="avatar box-shadow-1 cursor-pointer">
                                                       <img src="<?php bloginfo('template_directory'); ?>/assets/images/vkrz/logo-vkrz.png" alt="avatar" height="36" width="auto" />
                                                    </span>
                                                </div>
                                                <div class="chat-body">
                                                    <div class="chat-content">
                                                        <p>Qui sera la premier à ouvrir la discussion 👀 ?</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <form class="chat-app-form" action="javascript:void(0);" onsubmit="enterChat();">
                                        <div class="input-group input-group-merge w-100 form-send-message">
                                            <input type="text" class="form-control message" placeholder="Tape ton message..." />
                                        </div>
                                        <button type="button" class="btn btn-primary send" onclick="enterChat();">
                                            <span class="d-none text-nowrap d-lg-block">
                                                <i class="fal fa-paper-plane"></i>
                                            </span>
                                        </button>
                                    </form>
                                </section>
                            </div>
                            -->
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
<!-- END: Content-->

<?php get_footer(); ?>
