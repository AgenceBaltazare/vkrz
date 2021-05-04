<!-- BEGIN: Header-->
<nav class="header-navbar navbar navbar-expand-lg align-items-center floating-nav navbar-dark navbar-shadow">
    <div class="navbar-container d-flex content align-items-center">
        <div class="bookmark-wrapper d-flex align-items-baseline">

            <ul class="nav navbar-nav d-xl-none">
                <li class="nav-item"><a class="nav-link menu-toggle" href="javascript:void(0);"><i class="ficon" data-feather="menu"></i></a></li>
            </ul>

            <?php if(is_home()): ?>

                <h3 class="mb-0">🖖 Bienvenue</h3>
                <h4 class="mb-0">Créer & partage tes propres Tops en enchainant les votes !</h4>

            <?php elseif(is_single() && (get_post_type() == "tournoi")): ?>

                <h3 class="mb-0"><span class="ico">⚔️</span> <?php the_title(); ?></h3>
                <h4 class="mb-0"><?php the_field( 'question_t' ); ?></h4>

            <?php elseif(is_single() && (get_post_type() == "classement")): ?>

                <?php $id_tournament = get_field('id_tournoi_r'); ?>
                <h3 class="mb-0"><span class="ico">🏆</span> Top <?php echo get_numbers_of_contenders($id_tournament); ?> <?php echo get_the_title($id_tournament); ?></h3>
                <h4 class="mb-0"><?php the_field( 'question_t', $id_tournament ); ?></h4>

            <?php elseif(is_archive()): ?>

                <?php $current_cat = get_queried_object(); ?>
                <h3 class="mb-0"><span class="ico"><?php the_field('icone_cat', 'term_'.$current_cat->term_id); ?></span> <?php echo $current_cat->name; ?></h3>
                <h4 class="mb-0"><?php echo $current_cat->description; ?></h4>

            <?php endif; ?>
        </div>
        <ul class="nav navbar-nav align-items-center ml-auto">
            <li class="nav-item dropdown dropdown-user">
                <a class="nav-link dropdown-toggle dropdown-user-link" id="dropdown-user" href="javascript:void(0);" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <div class="user-nav d-sm-flex d-none">
                        <span class="user-name font-weight-bolder">John Doe</span>
                        <span class="user-status">Admin</span>
                    </div>
                    <span class="avatar">
                        <img class="round" src="<?php bloginfo('template_directory'); ?>/assets/images/portrait/small/avatar-s-11.jpg" alt="avatar" height="40" width="40">
                        <span class="avatar-status-online"></span>
                    </span>
                </a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdown-user"><a class="dropdown-item" href="page-profile.html"><i class="mr-50" data-feather="user"></i> Profile</a><a class="dropdown-item" href="app-email.html"><i class="mr-50" data-feather="mail"></i> Inbox</a><a class="dropdown-item" href="app-todo.html"><i class="mr-50" data-feather="check-square"></i> Task</a><a class="dropdown-item" href="app-chat.html"><i class="mr-50" data-feather="message-square"></i> Chats</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="page-account-settings.html">
                        <i class="mr-50" data-feather="settings"></i> Settings
                    </a>
                    <a class="dropdown-item" href="page-pricing.html">
                        <i class="mr-50" data-feather="credit-card"></i> Pricing
                    </a>
                    <a class="dropdown-item" href="page-faq.html">
                        <i class="mr-50" data-feather="help-circle"></i> FAQ
                    </a>
                    <a class="dropdown-item" href="page-auth-login-v2.html">
                        <i class="mr-50" data-feather="power"></i> Logout
                    </a>
                </div>
            </li>
        </ul>
    </div>
</nav>
<!-- END: Header-->