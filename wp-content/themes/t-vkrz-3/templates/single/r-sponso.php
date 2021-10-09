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
global $banner;

if (is_user_logged_in() && env() != "local") {
    if (false === ($user_tops = get_transient('user_' . $user_id . '_get_user_tops'))) {
        $user_tops = get_user_tops();
        set_transient('user_' . $user_id . '_get_user_tops', $user_tops, DAY_IN_SECONDS);
    } else {
        $user_tops = get_transient('user_' . $user_id . '_get_user_tops');
    }
} else {
    $user_tops  = get_user_tops();
}
$user_ranking = get_user_ranking($id_ranking);
$url_ranking  = get_the_permalink($id_ranking);
$top_datas    = get_top_data($id_top);
?>
<div class="app-content content cover" style="background: url(<?php echo $top_infos['top_cover']; ?>) center center no-repeat">
    <div class="content-overlay"></div>
    <div class="content-wrapper">
        <div class="content-body">
            <?php if (!is_user_logged_in()) : ?>
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

                        <div class="participation-content-sponso mb-4">
                            <div class="row">
                                <div class="col-md-8 ml-2 mt-1">
                                    <h1>
                                        Merci <span class="participation">pour ta participation au concours</span> <span class="vainkeurz">VAINKEURZ ! 👑</span>
                                    </h1>
                                </div>
                            </div>
                            <div class="row d-flex align-items-center pr-1 pl-1">
                                <div class="col-md-6 d-flex justify-content-around">
                                    <div class="image-recompense">
                                        <img src="<?php bloginfo('template_directory'); ?>/assets/images/concours/recompense-switch-bleu.svg" alt="" class="img-fluid">
                                    </div>
                                </div>
                                <div class="col-md-5 info-concours">
                                    <p class="info-share">
                                        Pour participer, tu dois <span class="t-rose">partager</span> ce Top en commentaire de notre post pour le concours sur Twitter et <span class="t-rose">RT</span> + <span class="t-rose">follow</span> <a href="https://twitter.com/Vainkeurz">@Vainkeurz</a>
                                    </p>
                                    <p class="info-share text-muted">
                                        Pour partager ton classement dans les commentaires du post du concours, clique juste en dessous et copie colle le lien sur Twitter !
                                    </p>
                                    <div class="d-flex align-items-center buttons-share-top">
                                        <a href="javascript: void(0)" class="sharelinkbtn2 w-100 animate__jello animate__animated animate__delay-1s btn btn-max btn-outline-primary waves-effect waves-float waves-light">
                                            <input type="text" value="<?php echo get_the_permalink($id_ranking); ?>" class="input_to_share2">
                                            Copier le lien du Top
                                        </a>
                                        <a href="https://twitter.com/Vainkeurz/status/1441764476525719555" target="_blank" class="w-100 animate__jello animate__animated animate__delay-1s btn btn-max btn-primary waves-effect waves-float waves-light">
                                            Post Twitter
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="list-classement mt-2">
                            <div class="row align-items-end justify-content-center">
                                <?php
                                $i = 1;
                                foreach ($user_ranking as $c) : ?>
                                    <?php if ($i == 1) : ?>
                                        <div class="col-12 col-md-5">
                                        <?php elseif ($i == 2) : ?>
                                            <div class="col-7 col-md-4">
                                            <?php elseif ($i == 3) : ?>
                                                <div class="col-5 col-md-3">
                                                <?php else : ?>
                                                    <div class="col-md-2 col-4">
                                                    <?php endif; ?>
                                                    <?php
                                                    if ($i >= 4) {
                                                        $d = 3;
                                                    } else {
                                                        $d = $i - 1;
                                                    }
                                                    ?>
                                                    <div class="animate__jackInTheBox animate__animated animate__delay-<?php echo $d; ?>s contenders_min <?php echo ($top_infos['top_d_rounded']) ? 'rounded' : ''; ?> mb-3">
                                                        <div class="illu">
                                                            <?php if ($top_infos['top_d_cover']) : ?>
                                                                <?php $illu = get_the_post_thumbnail_url($c, 'large'); ?>
                                                                <div class="cov-illu" style="background: url(<?php echo $illu; ?>) center center no-repeat"></div>
                                                            <?php else : ?>
                                                                <?php echo get_the_post_thumbnail($c, 'large', array('class' => 'img-fluid')); ?>
                                                            <?php endif; ?>
                                                        </div>
                                                        <div class="name eh2">
                                                            <h5 class="mt-2">
                                                                <?php if ($i == 1) : ?>
                                                                    <span class="ico">🥇</span>
                                                                <?php elseif ($i == 2) : ?>
                                                                    <span class="ico">🥈</span>
                                                                <?php elseif ($i == 3) : ?>
                                                                    <span class="ico">🥉</span>
                                                                <?php else : ?>
                                                                    <span><?php echo $i; ?><br></span>
                                                                <?php endif; ?>
                                                                <?php if (!$top_infos['top_d_titre']) : ?>
                                                                    <?php echo get_the_title($c); ?>
                                                                <?php endif; ?>
                                                            </h5>
                                                        </div>
                                                    </div>
                                                    </div>
                                                <?php $i++;
                                            endforeach; ?>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-3 offset-md-1">

                                            <div class="animate__fadeInUp animate__animated animate__delay-2s">

                                                <div class="separate mt-1 mb-2 d-block d-sm-none"></div>

                                                <div class="card">
                                                    <div class="card-body">
                                                        <h2 class="stats-mondiales mb-0">
                                                            <b>Stats mondiales :</b>
                                                            <?php echo $top_datas['nb_tops']; ?> 🏆 <?php echo $top_datas['nb_votes']; ?> 💎
                                                        </h2>
                                                        <div class="mt-1">
                                                            <a href="<?php the_permalink(get_page_by_path('elo')); ?>?id_top=<?php echo $id_top; ?>" class="w-100 btn btn-primary waves-effect">
                                                                <span class="ico">🌎</span> Voir le Top mondial
                                                            </a>
                                                        </div>
                                                        <h2 class="stats-mondiales mt-2 mb-0">
                                                            <b>Ressemblance :</b>
                                                            <?php
                                                            $similar = get_user_percent(get_field('uuid_user_r', $id_ranking), $id_top);
                                                            echo $similar['percent'] . "％";
                                                            ?>
                                                        </h2>
                                                        <div class="mt-1">
                                                            <a href="<?php the_permalink(get_page_by_path('liste-des-tops')); ?>?id_top=<?php echo $id_top; ?>" class="w-100 btn btn-outline-primary waves-effect">
                                                                <span class="ico ico-reverse">👀</span> voir les autres Tops
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>

                                                <?php
                                                $list_t_already_done = $user_tops['list_user_tops_done_ids'];

                                                $top_cat = $top_infos['top_cat'];
                                                foreach ($top_cat as $cat) {
                                                    $top_cat_id = $cat->term_id;
                                                }

                                                $list_souscat  = array();
                                                $top_souscat   = get_the_terms($id_top, 'concept');
                                                if (!empty($top_souscat)) {
                                                    foreach ($top_souscat as $souscat) {
                                                        array_push($list_souscat, $souscat->slug);
                                                    }
                                                }

                                                $tops_in_close_cat     = new WP_Query(array(
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
                                                $count_similar = $tops_in_close_cat->post_count;
                                                $count_next    = 4 - $count_similar;
                                                if ($count_similar < 4) {

                                                    $tops_in_large_cat     = new WP_Query(array(
                                                        'ignore_sticky_posts'    => true,
                                                        'update_post_meta_cache' => false,
                                                        'no_found_rows'          => true,
                                                        'post_type'              => 'tournoi',
                                                        'post__not_in'           => $list_t_already_done,
                                                        'orderby'                => 'rand',
                                                        'order'                  => 'ASC',
                                                        'posts_per_page'         => $count_next,
                                                        'tax_query' => array(
                                                            'relation' => 'AND',
                                                            array(
                                                                'taxonomy' => 'categorie',
                                                                'field'    => 'term_id',
                                                                'terms'    => array($top_cat_id)
                                                            )
                                                        )
                                                    ));
                                                }
                                                ?>

                                                <?php if ($tops_in_close_cat->have_posts() || $tops_in_large_cat->have_posts()) : ?>

                                                    <div class="separate mt-2 mb-2"></div>

                                                    <section class="list-tournois">
                                                        <div class="mt-1 pslim">
                                                            <h4 class="card-title">
                                                                <span class="ico">🥰</span> Tops similaires
                                                            </h4>
                                                            <h6 class="card-subtitle text-muted mb-1">
                                                                Voici quelques Tops qui devraient te plaire <span class="ico">👇</span>
                                                            </h6>
                                                        </div>
                                                        <div class="similar-list mt-2">
                                                            <div class="row">
                                                                <?php
                                                                while ($tops_in_close_cat->have_posts()) : $tops_in_close_cat->the_post(); ?>

                                                                    <?php get_template_part('partials/min-t'); ?>

                                                                <?php endwhile; ?>
                                                                <?php if ($count_similar < 4) : ?>
                                                                    <?php
                                                                    while ($tops_in_large_cat->have_posts()) : $tops_in_large_cat->the_post(); ?>

                                                                        <?php get_template_part('partials/min-t'); ?>

                                                                    <?php endwhile; ?>
                                                                <?php endif; ?>
                                                            </div>
                                                        </div>
                                                    </section>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <nav class="navbar fixed-bottom mobile-navbar">
            <div class="icons-navbar">
                <div class="ico-nav-mobile box-info-show">
                    <span class="ico">🪧</span> <span class="hide-spot">Infos <span class="hide-xs">du Top</span></span>
                </div>
                <div class="ico-nav-mobile share-content-show">
                    <span class="ico ico-reverse">📣</span> <span class="hide-spot">Partager</span>
                </div>
                <div class="ico-nav-mobile">
                    <a href="<?php echo get_the_permalink(get_page_by_path('discuz')) . '?id_top=' . $id_top; ?>">
                        <span class="ico">💬</span> <span class="hide-spot">Commenter</span>
                    </a>
                </div>

                <?php if (get_field('uuid_user_r', $id_ranking) == $uuiduser) : ?>
                    <div class="ico-nav-mobile">
                        <a data-phrase1="Es-tu sûr de vouloir recommencer ?" data-phrase2="Tous les votes de ce Top seront remis à 0" data-id_ranking="<?php echo $id_ranking; ?>" data-id_vainkeur="<?php echo $id_vainkeur; ?>" href="#" class="confirm_delete">
                            <span class="ico">🆕</span> <span class="hide-spot">Recommencer</span>
                        </a>
                    </div>
                <?php else : ?>
                    <div class="ico-nav-mobile">
                        <a href="<?php echo $top_infos['top_url']; ?>">
                            <span class="ico">⚡️</span> <span class="hide-spot">Faire mon Top</span>
                        </a>
                    </div>
                <?php endif; ?>
            </div>
        </nav>
        <div class="share-content">
            <div class="close-share">
                <i class="fal fa-times"></i>
            </div>
            <ul>
                <?php if (get_field('uuid_user_r', $id_ranking) == $uuiduser) : ?>
                    <li class="share-natif-classement">
                        <span class="ico-social">🏆</span> Partager mon classement
                    </li>
                <?php endif; ?>
                <li class="share-natif-top">
                    <span class="ico-social">⚡️</span> Partager le lien du Top
                </li>
            </ul>
        </div>
        <div class="share-classement-content">
            <h3>
                <span class="ico-social">⚡️</span> Partager mon classement
            </h3>
            <div class="close-share">
                <i class="fal fa-times"></i>
            </div>
            <ul>
                <li>
                    <a href="javascript: void(0)" class="sharelinkbtn" data-toggle="tooltip" data-placement="top" title="" data-original-title="Copier le lien de ton Classement">
                        <input type="text" value="<?php echo $top_infos['top_url']; ?>" class="input_to_share">
                        <i class="social-media fas fa-paperclip"></i> Copier le lien du classement
                    </a>
                </li>
                <li>
                    <a href="<?php echo $banner; ?>" download target="_blank">
                        <i class="social-media mb-12 fas fa-download"></i> Télécharger une image
                    </a>
                </li>
                <li>
                    <a href="https://twitter.com/intent/tweet?text=Voici mon TOP <?php echo $top_infos['top_number']; ?> <?php echo $top_infos['top_title']; ?>&via=vainkeurz&hashtags=VKRZ&url=<?php echo $url_ranking; ?>" target="_blank" title="Tweet">
                        <i class="social-media fab fa-twitter"></i> Twitter
                    </a>
                </li>
                <li>
                    <a href="whatsapp://send?text=<?php echo $url_ranking; ?>" data-action="share/whatsapp/share">
                        <i class="social-media fab fa-whatsapp"></i> WhatsApp
                    </a>
                </li>
                <li>
                    <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo $url_ranking; ?>" title="Partager sur Facebook" target="_blank">
                        <i class="social-media fab fa-facebook-f"></i> Facebook
                    </a>
                </li>
            </ul>
        </div>
        <div class="share-top-content">
            <h3>
                <span class="ico-social">⚡️</span> Partager le lien du Top
            </h3>
            <div class="close-share">
                <i class="fal fa-times"></i>
            </div>
            <ul>
                <li>
                    <a href="javascript: void(0)" class="sharelinkbtn2" data-toggle="tooltip" data-placement="top" title="" data-original-title="Copier le lien de ton Top">
                        <input type="text" value="<?php echo $top_infos['top_url']; ?>" class="input_to_share2">
                        <i class="social-media fas fa-paperclip"></i> Copier le lien du Top
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
                <span class="ico-social">🪧</span>
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
                            $creator_id         = get_post_field('post_author', $id_top);
                            $creator_uuiduser   = get_field('uuiduser_user', 'user_' . $creator_id);
                            $creator_data       = get_user_infos($creator_uuiduser);
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
                                                🎨
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

        <?php get_footer(); ?>