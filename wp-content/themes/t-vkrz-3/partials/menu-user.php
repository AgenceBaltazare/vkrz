<?php
global $user_infos;
global $cat_name;
if (is_single() && get_post_type() == "tournoi") {
    global $top_infos;
    global $id_top;
    global $id_ranking;
} elseif (is_single() && get_post_type() == "classement") {
    global $top_infos;
    $id_top = get_field('id_tournoi_r');
} elseif (is_author()) {
    global $vainkeur_info;
}
?>
<nav class="header-navbar navbar navbar-expand-lg align-items-center floating-nav navbar-dark navbar-shadow menu-user">
    <div class="navbar-container d-flex content align-items-center justify-content-between">

        <div class="d-block d-sm-none">
            <a href="<?php bloginfo('url'); ?>/">
                <img src="<?php bloginfo('template_directory'); ?>/assets/images/vkrz/logo-vkrz.png" alt="VAINKEURZ logo" class="logo img-fluid">
            </a>
        </div>

        <ul class="nav navbar-nav d-xl-none">
            <li class="nav-item">
                <a class="nav-link menu-toggle" href="javascript:void(0);">
                    <i class="ficon" data-feather="menu"></i>
                </a>
            </li>
        </ul>

        <?php if (!is_home()) : ?>
            <div class="navquick d-flex align-items-center">
                <div class="content-header row">
                    <div class="content-header-left col-12">
                        <div class="row breadcrumbs-top">
                            <div class="col-12">
                                <div class="breadcrumb-wrapper">
                                    <ol class="breadcrumb">

                                        <li class="breadcrumb-item">
                                            <a href="<?php bloginfo('url'); ?>/">
                                                <span class="vap vap-house vap-lg"></span> Home
                                            </a>
                                        </li>

                                        <?php if ((is_single() && get_post_type() == "tournoi") || (is_single() && get_post_type() == "classement")) : ?>

                                            <li class="breadcrumb-item">
                                                <?php
                                                foreach (get_the_terms($id_top, 'categorie') as $cat) {
                                                    $cat_id     = $cat->term_id;
                                                    $cat_name   = $cat->name;
                                                }
                                                ?>
                                                <a href="<?php echo get_category_link($cat_id); ?>">
                                                    <span class="ico">
                                                        <?php the_field('icone_cat', 'term_' . $cat_id); ?>
                                                    </span>
                                                    <span class="menu-title text-truncate">
                                                        <?php echo $cat_name; ?>
                                                    </span>
                                                </a>
                                            </li>

                                        <?php elseif (!is_author() && is_archive()) : ?>

                                            <?php
                                            if (is_archive()) {
                                                global $current_cat;
                                                global $cat_name;
                                                global $cat_id;
                                            }
                                            ?>
                                            <li class="breadcrumb-item">
                                                <a href="<?php echo get_category_link($cat_id); ?>">
                                                    <span class="ico"><?php the_field('icone_cat', 'term_' . $cat_id); ?></span> <span class="menu-title text-truncate"><?php echo $cat_name; ?></span>
                                                </a>
                                            </li>

                                        <?php elseif (is_page(get_page_by_path('elo'))) : ?>

                                            <?php global $id_top; ?>

                                            <li class="breadcrumb-item">
                                                <?php
                                                foreach (get_the_terms($id_top, 'categorie') as $cat) {
                                                    $cat_id     = $cat->term_id;
                                                    $cat_name   = $cat->name;
                                                }
                                                ?>
                                                <a href="<?php echo get_category_link($cat_id); ?>">
                                                    <span class="ico"><?php the_field('icone_cat', 'term_' . $cat_id); ?></span> <span class="menu-title text-truncate"><?php echo $cat_name; ?></span>
                                                </a>
                                            </li>
                                            <li class="breadcrumb-item">
                                                <a href="<?php the_permalink($id_top); ?>">
                                                    <span class="menu-title text-truncate">
                                                        <?php echo get_the_title($id_top); ?>
                                                    </span>
                                                </a>
                                            </li>

                                        <?php elseif (is_page(get_page_by_path('liste-des-tops'))) : ?>

                                            <?php global $id_top; ?>

                                            <li class="breadcrumb-item">
                                                <?php
                                                if (get_the_terms($id_top, 'categorie')) {
                                                    foreach (get_the_terms($id_top, 'categorie') as $cat) {
                                                        $cat_id     = $cat->term_id;
                                                        $cat_name   = $cat->name;
                                                    }
                                                }
                                                ?>
                                                <a href="<?php echo get_category_link($cat_id); ?>">
                                                    <span class="ico"><?php the_field('icone_cat', 'term_' . $cat_id); ?></span> <span class="menu-title text-truncate"><?php echo $cat_name; ?></span>
                                                </a>
                                            </li>
                                            <li class="breadcrumb-item">
                                                <a href="<?php the_permalink($id_top); ?>">
                                                    <span class="menu-title text-truncate">
                                                        <?php echo get_the_title($id_top); ?>
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

            <?php if (is_home()) : ?>

                <h3 class="mb-0 animate__animated animate__slideInLeft"><span class="vap vap-vulcan-salute vap-1x"></span> Bienvenue</h3>
                <h4 class="mb-0 kick animate__animated animate__slideInRight" data-kick="Commence par choisir un Top qui t'intéresse et enchaîne les votes <span class='vap vap-backhand-index-pointing-down vap-1x'></span>">Tu vas pouvoir générer et revendiquer tes propres classements !</h4>

            <?php elseif (is_single() && (get_post_type() == "tournoi")) : ?>

                <?php if ($id_ranking) : ?>
                    <div class="tournament-heading text-center">
                        <h3 class="mb-0 t-titre-tournoi">Top <?php echo $top_infos['top_number']; ?> <span class="ico">⚡</span> <?php echo $top_infos['top_title']; ?></h3>
                        <h4 class="mb-0 t-rose t-max">
                            <?php echo $top_infos['top_question']; ?>
                        </h4>
                    </div>
                <?php else : ?>
                    <div class="tournament-heading text-center">
                        <h3 class="mb-0 t-titre-tournoi">Introduction</h3>
                    </div>
                <?php endif; ?>

            <?php elseif (is_single() && (get_post_type() == "classement")) : ?>

                <div class="tournament-heading text-center">
                    <h3 class="mb-0 t-titre-tournoi">
                        Top <?php echo $top_infos['top_number']; ?> <span class="ico text-center vap vap-trophy vap-lg"></span> <?php echo $top_infos['top_title']; ?>
                    </h3>
                    <h4 class="mb-0">
                        <?php echo $top_infos['top_question']; ?>
                    </h4>
                </div>

            <?php elseif (is_page(get_page_by_path('elo'))) : ?>

                <?php $id_top = $_GET['id_top']; ?>
                <div class="tournament-heading text-center">
                    <h3 class="mb-0 t-titre-tournoi">Top <?php echo get_field('count_contenders_t', $id_top); ?> mondial <span class="ico text-center vap vap-globe vap-lg"></span> <?php echo get_the_title($id_top); ?></h3>
                    <h4 class="mb-0">
                        <?php the_field('question_t', $id_top); ?>
                    </h4>
                </div>

            <?php elseif (is_page(get_page_by_path('liste-des-tops'))) : ?>

                <?php $id_top = $_GET['id_top']; ?>
                <div class="tournament-heading text-center">
                    <h3 class="mb-0 t-titre-tournoi">Liste des Tops <span class="ico text-center vap vap-trophy vap-lg"></span> <?php echo get_the_title($id_top); ?></h3>
                    <h4 class="mb-0">
                        <?php the_field('question_t', $id_top); ?>
                    </h4>
                </div>

            <?php elseif (!is_author() && is_archive()) : ?>

                <div class="tournament-heading text-center">
                    <h3 class="mb-0 t-titre-tournoi"><span class="ico"><?php the_field('icone_cat', 'term_' . $cat_id); ?></span> <?php echo $cat_name; ?></h3>
                    <h4 class="mb-0"><?php echo $current_cat->description; ?></h4>
                </div>

            <?php elseif (is_author()) : ?>

                <div class="tournament-heading text-center">
                    <h3 class="mb-0 t-titre-tournoi">
                        Profil de <?php echo $vainkeur_info['pseudo']; ?> <?php echo $vainkeur_info['level']; ?>
                    </h3>
                </div>

            <?php endif; ?>
        </div>

        <ul class="nav navbar-nav align-items-center justify-content-around">
            <li class="nav-item dropdown dropdown-cart">
                <a class="nav-link d-flex flex-column align-items-center" href="javascript:void(0);" data-toggle="dropdown">
                    <span class="ico text-center vap vap-gem vap-lg"></span>
                    <span class="value-user-stats user-total-vote-value">
                        <?php echo $user_infos['nb_vote_vkrz']; ?>
                    </span>
                </a>
                <ul class="dropdown-menu dropdown-menu-media dropdown-menu-right">
                    <li class="dropdown-menu-header">
                        <div class="dropdown-header d-flex">
                            <h4 class="notification-title mb-0 mr-auto"><span class="vap vap-gem vap-lg"></span></h4>
                            <div class="badge badge-pill badge-light-primary">
                                Enchaîne les votes pour gagner des <span class="vap vap-gem vap-z-17"></span>
                            </div>
                        </div>
                    </li>
                    <li class="dropdown-menu-footer">
                        <div class="text-center mb-2">
                            <h6 class="font-weight-bolder mb-0">
                                <?php if (is_user_logged_in()) : ?>
                                    Encore <span class="decompte_vote"><?php echo get_vote_to_next_level($user_infos['level_number'], $user_infos['nb_vote_vkrz']); ?></span> <span class="vap vap-gem vap-lg"></span> pour passer au niveau <?php echo $user_infos['next_level']; ?>
                                <?php else : ?>
                                    Il te faut un compte pour monter en niveau <span class="vap vap-rocket vap-lg"></span>
                                <?php endif; ?>
                            </h6>
                        </div>
                        <a class="btn btn-primary btn-block" href="<?php the_permalink(get_page_by_path('evolution')); ?>">
                            Découvre les niveaux <span class="vap vap-eyes vap-lg"></span>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="nav-item mr-25">
                <a class="nav-link d-flex flex-column align-items-center" href="<?php the_permalink(get_page_by_path('mon-compte')); ?>">
                    <span class="ico text-center vap vap-trophy vap-lg"></span>
                    <span class="value-user-stats">
                        <?php echo $user_infos['nb_top_vkrz']; ?>
                    </span>
                </a>
            </li>
            <li class="nav-item dropdown dropdown-user ml-25">
                <a class="nav-link dropdown-toggle dropdown-user-link" id="dropdown-user" href="javascript:void(0);" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <span class="avatar">
                        <span class="avatar-picture" style="background-image: url(<?php echo $user_infos['avatar']; ?>);"></span>
                        <span class="user-niveau">
                            <?php echo $user_infos['level']; ?>
                        </span>
                    </span>
                </a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdown-user">
                    <?php if (is_user_logged_in()) : ?>
                        <a class="dropdown-item" href="<?php the_permalink(get_page_by_path('mon-compte')); ?>">
                            <span class="ico vap vap-hatching-chick vap-lg"></span> Mon compte
                        </a>
                        <a class="dropdown-item" href="<?php the_permalink(get_page_by_path('parametres')); ?>">
                            <span class="ico vap vap-setting vap-lg"></span> Paramètres
                        </a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="<?php the_permalink(get_page_by_path('deconnexion')); ?>">
                            <span class="ico vap vap-waving-hand vap-lg"></span> Déconnexion
                        </a>
                    <?php else : ?>
                        <a class="dropdown-item" href="<?php the_permalink(get_page_by_path('mon-compte')); ?>">
                            <span class="ico vap vap-ninja vap-lg"></span> Mon compte
                        </a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="<?php the_permalink(get_page_by_path('se-connecter')); ?>">
                            <span class="ico vap vap-call-me-hand vap-lg"></span> Me connecter
                        </a>
                        <a class="dropdown-item" href="<?php the_permalink(get_page_by_path('creer-mon-compte')); ?>">
                            <span class="ico vap vap-party-pooper vap-lg">🎉</span> M'inscrire
                        </a>
                    <?php endif; ?>

                </div>
            </li>
        </ul>

    </div>
</nav>
<!-- END: Header-->