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
<script>
    const link_to_ranking = "<?= get_the_permalink($id_ranking) ?>";
</script>
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
                                                <?php the_field('titre_de_la_sponso_t_sponso', $id_top); ?>
                                            </h4>
                                        </div>
                                    </div>
                                    <div class="text-rules">
                                        <?php the_field('description_t_sponso', $id_top); ?>
                                    </div>
                                </div>
                                <div class="card-footer share-content-sponso">
                                    <div class="text-left">
                                        <p>
                                            <?php the_field('top_propose_par_t_sponso', $id_top); ?>
                                        </p>
                                    </div>
                                    <div class="d-flex align-items-center reseaux-sponso m-0">
                                        <div class="logo-vkrz-sponso">
                                            <?php
                                            if (get_field('logo_de_la_sponso_t_sponso', $id_top)) : ?>
                                                <a href="<?php the_field('lien_de_la_sponso_t_sponso', $id_top); ?>" target="_blank">
                                                    <?php echo wp_get_attachment_image(get_field('logo_de_la_sponso_t_sponso', $id_top), 'large', '', array('class' => 'img-fluid')); ?>
                                                </a>
                                            <?php endif; ?>
                                        </div>
                                        <div class="mt-2 social-media-sponso">
                                            <div class="d-flex buttons-social-media">
                                                <?php if (have_rows('liste_des_liens_t_sponso', $id_top)) : ?>
                                                    <?php while (have_rows('liste_des_liens_t_sponso', $id_top)) : the_row(); ?>
                                                        <a href="<?php the_sub_field('lien_vers_t_sponso'); ?>" class="w-100 animate__jello animate__animated animate__delay-1s btn btn-max btn-outline-primary waves-effect waves-float waves-light" target="_blank">
                                                            <?php the_sub_field('intitule_t_sponso'); ?>
                                                        </a>
                                                    <?php endwhile; ?>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer text-center p-20 m-0">
                                    <span class="t-rose">
                                        <?php the_field('fin_de_la_sponso_t_sponso', $id_top); ?>
                                    </span>
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
                                                    Faire mon Top <?php echo $top_infos['top_number']; ?> ⚡ <?php echo $top_infos['top_title']; ?>
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
                                            <div class="cta-begin cta-complet">
                                                <a href="#" id="begin_t" data-typetop="complet" data-top="<?php echo $id_top; ?>" data-uuiduser="<?php echo $uuiduser; ?>" class="w-100 animate__jello animate__animated animate__delay-1s btn btn-max btn-primary waves-effect waves-float waves-light laucher_t">
                                                    Faire mon Top <?php echo $top_infos['top_number']; ?>
                                                </a>
                                                <small class="text-muted">
                                                    <?php
                                                    $min = ($top_infos['top_number'] - 5) * 2 + 6;
                                                    $max = $min * 2;
                                                    ?>
                                                    <?php if ($top_infos['top_number'] < 3) : ?>
                                                        Un seul vote suffira pour finir ce Top
                                                    <?php else : ?>
                                                        Prévoir entre <?php echo $min; ?> et <?php echo $max; ?> votes pour finir ton Top du 1er au dernier
                                                    <?php endif; ?>
                                                </small>
                                            </div>
                                            <?php if ($top_infos['top_number'] > 10) : ?>
                                                <div class="cta-begin cta-top3">
                                                    <a href="#" id="begin_top3" data-typetop="top3" data-top="<?php echo $id_top; ?>" data-uuiduser="<?php echo $uuiduser; ?>" class="w-100 animate__jello animate__animated animate__delay-1s btn btn-max btn-primary waves-effect waves-float waves-light laucher_t">
                                                        Faire mon Top 3
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
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <div class="card-footer">
                                        <div class="row meetings align-items-center">
                                            <div class="col">
                                                <div class="infos-card-t info-card-t-v d-flex align-items-center">
                                                    <div class="mr-1">
                                                        <span class="ico va va-gem va-2x"></span>
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
                                                        <span class="ico va va-trophy va-2x"></span>
                                                    </div>
                                                    <div class="content-body text-left">
                                                        <h4 class="mb-0">
                                                            <?php echo $top_datas['nb_completed_top']; ?>
                                                        </h4>
                                                        <small class="text-muted">Tops terminés</small>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="infos-card-t d-flex align-items-center">
                                                    <div class="mr-1">
                                                        <span class="ico va va-wrapped-gift va-2x"></span>
                                                    </div>
                                                    <div class="content-body text-left">
                                                        <h4 class="mb-0">
                                                            <?php the_field('gain_champs_1_t_sponso', $id_top); ?>
                                                        </h4>
                                                        <small class="text-muted"><?php the_field('gain_champs_2_t_sponso', $id_top); ?></small>
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

<?php if ($id_ranking) : ?>
    <nav class="navbar mobile-navbar">
        <div class="icons-navbar">
            <div class="ico-nav-mobile box-info-show">
                <span class="ico va va-placard va-lg"></span> <span class="hide-spot">Infos <span class="hide-xs">du Top</span></span>
            </div>
            <div class="ico-nav-mobile share-natif-top">
                <span class="ico ico-reverse va va-megaphone va-lg">📣</span> <span class="hide-spot">Partager</span>
            </div>
            <div class="ico-nav-mobile">
                <a href="<?php echo get_the_permalink(get_page_by_path('discuz')) . '?id_top=' . $id_top; ?>">
                    <span class="ico va va-speech-balloon va-lg"></span> <span class="hide-spot">Commenter</span>
                </a>
            </div>
            <?php if (get_post_status($id_top) != "draft") : ?>
                <div class="ico-nav-mobile">
                    <a data-phrase1="Es-tu sûr de vouloir recommencer ?" data-phrase2="Tous les votes de ce Top seront remis à 0" data-id_ranking="<?php echo $id_ranking; ?>" data-id_vainkeur="<?php echo $id_vainkeur; ?>" href="#" class="confirm_delete">
                        <span class="ico">🆕</span> <span class="hide-spot">Recommencer</span>
                    </a>
                </div>
            <?php endif; ?>
        </div>
    </nav>
    <div class="share-top-content">
        <h3><span class="ico-social">⚡️</span> Partager le lien du Top</h3>
        <div class="close-share">
            <i class="fal fa-times"></i>
        </div>
        <ul>
            <li>
                <a href="javascript: void(0)" class="sharelinkbtn2">
                    <input type="text" value="<?php echo $top_infos['top_url']; ?>" class="input_to_share2">
                    <i class="social-media fas fa-paperclip"></i> <span>Copier le lien du Top</span>
                </a>
            </li>
            <li>
                <a href="https://twitter.com/intent/tweet?text=Go faire le TOP <?php echo $top_infos['top_number']; ?> <?php echo $top_infos['top_title']; ?>&via=vainkeurz&hashtags=VKRZ&url=<?php echo $url_ranking; ?>" target="_blank" title="Tweet">
                    <i class="social-media fab fa-twitter"></i> Dans un Tweet
                </a>
            </li>
            <li>
                <a href="whatsapp://send?text=<?php echo $url_ranking; ?>" data-action="share/whatsapp/share">
                    <i class="social-media mb-12 fab fa-whatsapp"></i> Sur WhatsApp
                </a>
            </li>
            <li>
                <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo $url_ranking; ?>" title="Partager sur Facebook" target="_blank">
                    <i class="social-media fab fa-facebook-f"></i> Sur Facebook
                </a>
            </li>
        </ul>
    </div>
    <div class="box-info-content">
        <h3>
            <span class="ico va va-placard va-lg"></span>
            Tous les infos du Top
        </h3>
        <div class="close-share">
            <i class="fal fa-times"></i>
        </div>
        <div class="box-info-list">
            <div class="card text-left">
                <div class="card-body">
                    <h4 class="card-title">
                        <?php
                        date_default_timezone_set('Europe/Paris');
                        $origin     = new DateTime(get_the_date('Y-m-d', $id_top));
                        $target     = new DateTime(date('Y-m-d'));
                        $interval   = $origin->diff($target);
                        if ($interval->days == 0) {
                            $info_date = "aujourd'hui";
                        } elseif ($interval->days == 1) {
                            $info_date = "hier";
                        } else {
                            $info_date = "depuis " . $interval->days . " jours";
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
                                <h4 class="mb-0">
                                    <?php echo $creator_data['pseudo']; ?> <br>
                                    <span class="ico" data-toggle="tooltip" data-placement="top" title="" data-original-title="Niveau actuel">
                                        <?php echo $creator_data['level']; ?>
                                    </span>
                                    <?php if ($creator_data['user_role']  == "administrator") : ?>
                                        <span class="ico" data-toggle="tooltip" data-placement="top" title="" data-original-title="TeamVKRZ">
                                            🦙
                                        </span>
                                    <?php endif; ?>
                                    <?php if ($creator_data['user_role']  == "administrator" || $creator_data['user_role'] == "author") : ?>
                                        <span class="ico" data-toggle="tooltip" data-placement="top" title="" data-original-title="Créateur de Tops">
                                            👨‍🎤
                                        </span>
                                    <?php endif; ?>
                                </h4>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>

<?php get_footer(); ?>