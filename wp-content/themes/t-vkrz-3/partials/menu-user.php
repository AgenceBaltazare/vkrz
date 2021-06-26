<?php
global $uuiduser;
global $current_user;
global $user_id;
global $id_tournament;
global $top_question;
global $top_number;
global $top_title;
global $user_full_data;
global $nb_user_votes;
global $info_user_level;
global $list_t_done;
global $id_ranking;
$user_full_data  = get_user_full_data($uuiduser);
$list_t_done     = $user_full_data[0]['list_user_ranking_done'];
$nb_user_votes   = $user_full_data[0]['nb_user_votes'];
$info_user_level = get_user_level($uuiduser, $user_id, $nb_user_votes);
?>
<nav class="header-navbar navbar navbar-expand-lg align-items-center floating-nav navbar-dark navbar-shadow menu-user">
    <div class="navbar-container d-flex content align-items-center justify-content-between">

        <div class="d-block d-sm-none">
            <a href="<?php bloginfo('url'); ?>/">
                <img src="<?php bloginfo('template_directory'); ?>/assets/images/vkrz/logo-vkrz.png" alt="VAINKEURZ logo" class="logo img-fluid">
            </a>
        </div>

        <ul class="nav navbar-nav d-xl-none">
            <li class="nav-item"><a class="nav-link menu-toggle" href="javascript:void(0);"><i class="ficon" data-feather="menu"></i></a></li>
        </ul>

        <?php if(!is_home()): ?>
            <div class="navquick d-flex align-items-center">
                <div class="content-header row">
                    <div class="content-header-left col-12">
                        <div class="row breadcrumbs-top">
                            <div class="col-12">
                                <div class="breadcrumb-wrapper">
                                    <ol class="breadcrumb">

                                        <li class="breadcrumb-item">
                                            <a href="<?php bloginfo('url'); ?>/">
                                                🏠 Home
                                            </a>
                                        </li>

                                        <?php if((is_single() && get_post_type() == "tournoi") || (is_single() && get_post_type() == "classement")): ?>

                                            <li class="breadcrumb-item">
                                                <?php
                                                foreach(get_the_terms($id_tournament, 'categorie') as $cat ) {
                                                    $cat_id     = $cat->term_id;
                                                    $cat_name   = $cat->name;
                                                }
                                                ?>
                                                <a href="<?php echo get_category_link($cat_id); ?>">
                                                    <span class="ico"><?php the_field('icone_cat', 'term_'.$cat_id); ?></span> <span class="menu-title text-truncate"><?php echo $cat_name; ?></span>
                                                </a>
                                            </li>

                                        <?php elseif(!is_author() && is_archive()): ?>

                                            <?php
                                            if(is_archive()){
                                                global $current_cat;
                                                global $cat_name;
                                                global $cat_id;
                                            }
                                            ?>
                                            <li class="breadcrumb-item">
                                                <a href="<?php echo get_category_link($cat_id); ?>">
                                                    <span class="ico"><?php the_field('icone_cat', 'term_'.$cat_id); ?></span> <span class="menu-title text-truncate"><?php echo $cat_name; ?></span>
                                                </a>
                                            </li>

                                        <?php elseif(is_page(get_page_by_path('elo'))): ?>

                                            <li class="breadcrumb-item">
                                                <?php
                                                foreach(get_the_terms($id_tournament, 'categorie') as $cat ) {
                                                    $cat_id     = $cat->term_id;
                                                    $cat_name   = $cat->name;
                                                }
                                                ?>
                                                <a href="<?php echo get_category_link($cat_id); ?>">
                                                    <span class="ico"><?php the_field('icone_cat', 'term_'.$cat_id); ?></span> <span class="menu-title text-truncate"><?php echo $cat_name; ?></span>
                                                </a>
                                            </li>
                                            <li class="breadcrumb-item">
                                                <a href="<?php the_permalink($id_tournament); ?>">
                                                    <span class="menu-title text-truncate">
                                                        <?php echo get_the_title($id_tournament); ?>
                                                    </span>
                                                </a>
                                            </li>

                                        <?php elseif(is_page(get_page_by_path('liste-des-tops'))): ?>

                                            <li class="breadcrumb-item">
                                                <?php
                                                foreach(get_the_terms($id_tournament, 'categorie') as $cat ) {
                                                    $cat_id     = $cat->term_id;
                                                    $cat_name   = $cat->name;
                                                }
                                                ?>
                                                <a href="<?php echo get_category_link($cat_id); ?>">
                                                    <span class="ico"><?php the_field('icone_cat', 'term_'.$cat_id); ?></span> <span class="menu-title text-truncate"><?php echo $cat_name; ?></span>
                                                </a>
                                            </li>
                                            <li class="breadcrumb-item">
                                                <a href="<?php the_permalink($id_tournament); ?>">
                                                    <span class="menu-title text-truncate">
                                                        <?php echo get_the_title($id_tournament); ?>
                                                    </span>
                                                </a>
                                            </li>

                                        <?php endif; ?>
                                    </ol>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <div class="bookmark-wrapper d-flex align-items-baseline">

            <?php if(is_home()): ?>

                <h3 class="mb-0">🖖 Bienvenue</h3>
                <h4 class="mb-0">Créer & partage tes propres Tops en enchaînant les votes !</h4>

            <?php elseif(is_single() && (get_post_type() == "tournoi")): ?>

                <?php if($id_ranking): ?>
                    <div class="tournament-heading text-center">
                        <h3 class="mb-0 t-titre-tournoi">Top <?php echo $top_number; ?> <span class="ico">⚔️</span> <?php echo $top_title; ?></h3>
                        <h4 class="mb-0 t-rose t-max">
                            <?php echo $top_question; ?>
                        </h4>
                    </div>
                <?php else: ?>
                    <div class="tournament-heading text-center">
                        <h3 class="mb-0 t-titre-tournoi">Introduction</h3>
                    </div>
                <?php endif; ?>

            <?php elseif(is_single() && (get_post_type() == "classement")): ?>

                <div class="tournament-heading text-center">
                    <h3 class="mb-0 t-titre-tournoi">
                        Top <?php echo $top_number; ?> <span class="ico text-center">🏆</span> <?php echo $top_title; ?>
                    </h3>
                    <h4 class="mb-0">
                        <?php echo $top_question; ?>
                    </h4>
                </div>

            <?php elseif(is_page(get_page_by_path('elo'))): ?>

                <?php $id_tournament = $_GET['id_top']; ?>
                <div class="tournament-heading text-center">
                    <h3 class="mb-0 t-titre-tournoi">Top <?php echo get_numbers_of_contenders($id_tournament); ?> mondial <span class="ico text-center">🏆</span> <?php echo get_the_title($id_tournament); ?></h3>
                    <h4 class="mb-0">
                        <?php the_field('question_t', $id_tournament); ?>
                    </h4>
                </div>

            <?php elseif(is_page(get_page_by_path('liste-des-tops'))): ?>

                <?php $id_tournament = $_GET['id_top']; ?>
                <div class="tournament-heading text-center">
                    <h3 class="mb-0 t-titre-tournoi">Liste des Tops <span class="ico text-center">🏆</span> <?php echo get_the_title($id_tournament); ?></h3>
                    <h4 class="mb-0">
                        <?php the_field('question_t', $id_tournament); ?>
                    </h4>
                </div>

            <?php elseif(!is_author() && is_archive()): ?>

                <div class="tournament-heading text-center">
                    <h3 class="mb-0 t-titre-tournoi"><span class="ico"><?php the_field('icone_cat', 'term_'.$cat_id); ?></span> <?php echo $cat_name; ?></h3>
                    <h4 class="mb-0"><?php echo $current_cat->description; ?></h4>
                </div>

            <?php endif; ?>
        </div>

        <ul class="nav navbar-nav align-items-center">
            <li class="nav-item dropdown dropdown-cart">
                <a class="nav-link" href="javascript:void(0);" data-toggle="dropdown">
                    <span class="ico text-center">💎</span>
                    <span class="value-user-stats user-total-vote-value">
                        <?php echo $nb_user_votes; ?>
                    </span>
                </a>
                <ul class="dropdown-menu dropdown-menu-media dropdown-menu-right">
                    <li class="dropdown-menu-header">
                        <div class="dropdown-header d-flex">
                            <h4 class="notification-title mb-0 mr-auto">💎</h4>
                            <div class="badge badge-pill badge-light-primary">
                                Enchaîne les votes pour gagner des 💎
                            </div>
                        </div>
                    </li>
                    <li class="scrollable-container media-list">
                        <?php
                        $list_t_all = $user_full_data[0]['list_user_ranking_all'];
                        foreach($list_t_all as $t_user) : ?>
                            <a class="text-body" href="<?php the_permalink($t_user['id_tournoi']); ?>">
                                <div class="media align-items-center">
                                    <div class="min-t-thumb">
                                        <?php echo get_the_post_thumbnail($t_user['id_tournoi'], 'thumbnail', array('class'=>'d-block rounded mr-1 img-fluid')); ?>
                                    </div>
                                    <div class="media-body">
                                        <div class="media-heading">
                                            <h6 class="cart-item-title mb-0">
                                                <?php echo get_the_title($t_user['id_tournoi']); ?>
                                            </h6>
                                            <small class="notification-text">
                                                <?php the_field('question_t', $t_user['id_tournoi']); ?>
                                            </small>
                                            <small class="cart-item-by">
                                                <?php if($t_user['done'] == true): ?>
                                                    <div class="badge badge-success">Terminé</div>
                                                <?php else: ?>
                                                    <div class="badge badge-warning">En cours</div>
                                                <?php endif; ?>
                                            </small>
                                        </div>
                                        <h5 class="cart-item-price" id="rank-<?php echo $t_user['id_ranking']; ?>">
                                            <span class="value-span"><?php echo $t_user['nb_votes']; ?></span> <span class="ico3">💎</span>
                                        </h5>
                                    </div>
                                </div>
                            </a>
                        <?php endforeach; ?>
                    </li>
                    <li class="dropdown-menu-footer">
                        <div class="text-center mb-2">
                            <h6 class="font-weight-bolder mb-0">
                                <?php if(is_user_logged_in()): ?>
                                    Encore <span class="decompte_vote"><?php echo $info_user_level['votes_restant']; ?></span> 💎 pour passer au niveau <?php echo $info_user_level['next_level']; ?>
                                <?php else: ?>
                                    Il faut avoir un compte pour monter en niveau 🚀
                                <?php endif; ?>
                            </h6>
                        </div>
                        <a class="btn btn-primary btn-block" href="<?php the_permalink(get_page_by_path('evolution')); ?>">
                            Découvre les niveaux 👀
                        </a>
                    </li>
                </ul>
            </li>
            <li class="nav-item dropdown dropdown-notification mr-25">
                <a class="nav-link" href="javascript:void(0);" data-toggle="dropdown">
                    <span class="value-user-stats">
                        <span class="ico text-center">🏆</span>
                        <?php echo count($list_t_done); ?>
                    </span>
                </a>
                <ul class="dropdown-menu dropdown-menu-media dropdown-menu-right">
                    <li class="dropdown-menu-header">
                        <div class="dropdown-header d-flex">
                            <h4 class="notification-title mb-0 mr-auto">🏆</h4>
                            <div class="badge badge-pill badge-light-primary">
                                <?php if(count($list_t_done) >= 1): ?>
                                    Mes Tops terminés
                                <?php else: ?>
                                    Aucun Tops terminés <span class="ico">😑</span>
                                <?php endif; ?>
                            </div>
                        </div>
                    </li>
                    <?php if(count($list_t_done) >= 1): ?>
                        <li class="scrollable-container media-list">
                            <?php
                            foreach($list_t_done as $t_user) : ?>
                                <a class="d-flex" href="<?php the_permalink($t_user['id_ranking']); ?>">
                                    <div class="media d-flex align-items-start">
                                        <div class="media-body">
                                            <p class="media-heading">
                                            <span class="font-weight-bolder">
                                                Top <?php echo $t_user['nb_top']; ?> <span class="ico text-center">⚔️</span> <?php echo get_the_title($t_user['id_tournoi']); ?>
                                            </span>
                                            </p>
                                            <small class="notification-text">
                                                <?php the_field('question_t', $t_user['id_tournoi']); ?>
                                            </small>
                                        </div>
                                        <div class="user_rank">
                                            <div class="avatar-group align-items-center">
                                                <?php
                                                $user_top3 = get_user_ranking($t_user['id_ranking']);
                                                $l=1;
                                                foreach($user_top3 as $top => $p): ?>

                                                    <div data-toggle="tooltip" data-popup="tooltip-custom" data-placement="top" data-original-title="<?php echo get_the_title($top); ?>" class="avatar pull-up">
                                                        <?php $illu = get_the_post_thumbnail_url($top, 'medium'); ?>
                                                        <img src="<?php echo $illu; ?>" alt="Avatar" height="32" width="32">
                                                    </div>

                                                <?php $l++; if($l==4) break; endforeach; ?>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            <?php endforeach; ?>
                        </li>
                        <li class="dropdown-menu-footer">
                            <a class="btn btn-primary btn-block" href="<?php the_permalink(get_page_by_path('mon-compte')); ?>?uuid=<?php echo $uuiduser; ?>">
                                Voir tous mes Tops terminés
                            </a>
                        </li>
                    <?php endif; ?>
                </ul>
            </li>
            <li class="nav-item dropdown dropdown-user ml-25">
                <a class="nav-link dropdown-toggle dropdown-user-link" id="dropdown-user" href="javascript:void(0);" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <span class="avatar">
                        <?php
                        if(is_user_logged_in() && get_avatar_url($user_id, ['size' => '80'])){
                            $avatar_url = get_avatar_url($user_id, ['size' => '80']);
                        }
                        else{
                            $avatar_url = get_bloginfo('template_directory')."/assets/images/vkrz/ninja.png";
                        }
                        ?>
                        <span class="avatar-picture" style="background-image: url(<?php echo $avatar_url; ?>);"></span>
                        <span class="user-niveau">
                            <?php echo $info_user_level['level_ico']; ?>
                        </span>
                    </span>
                </a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdown-user">
                    <?php if(is_user_logged_in()): ?>
                        <a class="dropdown-item" href="<?php the_permalink(get_page_by_path('mon-compte')); ?>?uuid=<?php echo $uuiduser; ?>">
                            <span class="ico">🐣</span> Mon compte
                        </a>
                        <a class="dropdown-item" href="<?php the_permalink(get_page_by_path('parametres')); ?>">
                            <span class="ico">⚙️</span> Paramètres
                        </a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="<?php the_permalink(get_page_by_path('deconnexion')); ?>">
                            <span class="ico">👋</span> Déconnexion
                        </a>
                    <?php else: ?>
                        <a class="dropdown-item" href="<?php the_permalink(get_page_by_path('mon-compte')); ?>?uuid=<?php echo $uuiduser; ?>">
                            <span class="ico">🥷</span> Mon compte
                        </a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="<?php the_permalink(get_page_by_path('se-connecter')); ?>">
                            <span class="ico">🤙</span> Se connecter
                        </a>
                        <a class="dropdown-item" href="<?php the_permalink(get_page_by_path('creer-mon-compte')); ?>">
                            <span class="ico">🎉</span> S'inscrire
                        </a>
                    <?php endif; ?>
                    
                </div>
            </li>
        </ul>

    </div>
</nav>
<!-- END: Header-->