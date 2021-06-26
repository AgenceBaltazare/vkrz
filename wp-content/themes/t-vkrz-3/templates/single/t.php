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
                        <div class="card animate__animated animate__flipInX">
                            <div class="card-header">
                                <h4 class="card-title">
                                    Top <?php echo $top_number; ?> <span class="ico">⚔️</span> <?php echo $top_title; ?>
                                </h4>
                                <h5 class="card-subtitle t-rose animate__animated animate__flash">
                                    <?php echo $top_question; ?>
                                </h5>
                            </div>
                            <div class="card-body">
                                <div class="voilebg" style="background-image: url(<?php echo $illu; ?>);"></div>
                                <?php if(get_field('precision_t', $id_tournament)): ?>
                                    <p class="card-text mb-4">
                                        <?php the_field('precision_t', $id_tournament); ?>
                                    </p>
                                <?php endif; ?>
                                <div class="choosecta">
                                    <div class="cta-begin cta-complet">
                                        <a href="#" id="begin_t" data-typetop="complet" data-tournament="<?php echo $id_tournament; ?>" data-uuiduser="<?php echo $uuiduser; ?>" class="animate__jello animate__animated animate__delay-1s btn btn-max btn-primary waves-effect waves-float waves-light laucher_t">
                                            Débuter mon Top Complet
                                        </a>
                                        <small>
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
                                                Débuter mon Top 3
                                            </a>
                                            <small>
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
                        </div>
                        <p class="card-infos mt-1 animate__fadeInUp animate__animated animate__delay-2s">
                            Depuis le <?php echo $top_datas[0]['date_of_t']; ?>, <?php echo $top_datas[0]['nb_votes']; ?> votes 💎 ont générés <?php echo $top_datas[0]['nb_tops']; ?> Tops 🏆
                        </p>
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
                <?php
                set_query_var('steps_var', compact('current_step'));
                get_template_part('templates/parts/content', 'step-bar');
                ?>

                <div class="nav-tournament d-flex justify-content-center align-items-center">
                    <div class="btng">
                        <a data-phrase1="Es-tu sûr de toi ?" data-phrase2="Tous les votes de ce Top seront remis à 0" data-idranking="<?php echo $id_ranking; ?>" href="#" class="confirm_delete btn btn-outline-primary waves-effect">
                            <span class="ico text-center">🙃</span> Recommencer
                        </a>
                    </div>

                    <div class="btng mr-5 ml-5">
                    <span class="share-label">
                        Partager <span class="ico text-center">👉</span>
                    </span>
                        <div class="btn-group justify-content-center share-t" role="group">
                            <a href="https://twitter.com/intent/tweet?source=<?php echo $top_url; ?>&text=Viens faire ton TOP <?php echo $top_number; ?> <?php echo $top_title; ?> - <?php echo $top_question; ?> 👉 <?php echo $top_url; ?>" target="_blank" title="Tweet" class="btn btn-icon btn-outline-primary">
                                <i class="fab fa-twitter"></i>
                            </a>
                            <a href="whatsapp://send?text=<?php echo $top_url; ?>" data-action="share/whatsapp/share" class="btn btn-icon btn-outline-primary">
                                <i class="fab fa-whatsapp"></i>
                            </a>
                            <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo $top_url; ?>&text=Viens faire ton TOP <?php echo $top_number; ?> <?php echo $top_title; ?> - <?php echo $top_question; ?> 👉" title="Partager sur Facebook" target="_blank" class="btn btn-icon btn-outline-primary">
                                <i class="fab fa-facebook-f"></i>
                            </a>
                            <a href="javascript: void(0)" class="sharelinkbtn2 btn btn-icon btn-outline-primary" data-toggle="tooltip" data-placement="top" title="" data-original-title="Copier le lien du Top">
                                <input type="text" value="<?php echo $top_url; ?>" class="input_to_share2">
                                <i class="far fa-link"></i>
                            </a>
                        </div>
                    </div>

                    <div class="btng hide-xs">
                        <a href="<?php the_permalink(get_page_by_path('elo')); ?>?id_top=<?php echo $id_tournament; ?>" class="btn btn-outline-primary waves-effect" target="_blank" >
                            <span class="ico ico-reverse text-center">👀</span> Classement mondial
                        </a>
                    </div>
                </div>

            <?php endif; ?>

        </div>
    </div>
</div>
<!-- END: Content-->

<?php get_footer(); ?>
