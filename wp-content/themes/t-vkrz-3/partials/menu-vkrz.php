<!-- BEGIN: Main Menu-->
<div class="main-menu menu-fixed menu-dark menu-accordion menu-shadow" data-scroll-to-active="true">
    <div class="navbar-header">
        <ul class="nav navbar-nav flex-row">
            <li class="nav-item mr-auto">
                <a class="navbar-brand" href="<?php bloginfo('url'); ?>/">
                    <h2 class="brand-text">
                        <img src="<?php bloginfo('template_directory'); ?>/assets/images/vkrz/logo-vkrz.png" alt="VAINKEURZ logo" class="img-fluid">
                    </h2>
                    <div class="badge-beta">
                        <span class="badge">
                            <?php
                            $template_data       = wp_get_theme();
                            $template_version    = $template_data['Version'];
                            ?>
                            BETA <?php echo $template_version; ?>
                        </span>
                    </div>
                </a>
            </li>
            <li class="nav-item nav-toggle hide-lg">
                <a class="nav-link modern-nav-toggle pr-0" data-toggle="collapse">
                    <span class="ico">🙅</span>
                    fermer
                </a>
            </li>
        </ul>
    </div>
    <div class="main-menu-content">
        <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">
            <li class="nav-item">
                <div class="rs-menu mt-2">
                    <div class="w-100 btn-group justify-content-center share-t" role="group">
                        <a href="https://discord.gg/w882sUnrhE" class="btn btn-outline-primary waves-effect sociallink" target="_blank">
                            <i class="fab fa-discord"></i>
                        </a>
                        <a href="https://www.instagram.com/wearevainkeurz/" class="btn btn-outline-primary waves-effect sociallink" target="_blank">
                            <i class="fab fa-instagram"></i>
                        </a>
                        <a href="https://twitter.com/Vainkeurz" target="_blank" class="btn btn-outline-primary waves-effect sociallink">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a href="https://www.facebook.com/vainkeurz" target="_blank" class="btn btn-outline-primary waves-effect sociallink">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                    </div>
                </div>
            </li>
            <li class="navigation-header">
                <span data-i18n="">Catégories de Tops</span> <i data-feather="more-horizontal"></i>
            </li>
            <?php
            $cat_t = get_terms( array(
                'taxonomy'      => 'categorie',
                'orderby'       => 'count',
                'order'         => 'DESC',
                'hide_empty'    => true,
            ));
            foreach($cat_t as $cat) : ?>
                <li class="nav-item">
                    <a class="d-flex align-items-center" href="<?php echo get_category_link($cat->term_id); ?>">
                        <span class="ico"><?php the_field('icone_cat', 'term_'.$cat->term_id); ?></span> <span class="menu-title text-truncate"><?php echo $cat->name; ?></span>
                    </a>
                </li>
            <?php endforeach; ?>
            <li class="navigation-header">
                <span>VAINKEURZ</span> <i data-feather="more-horizontal"></i>
            </li>
            <li class="nav-item">
                <a class="d-flex align-items-center" href="<?php the_permalink(104853); ?>">
                    <span class="ico">🦙</span> <span class="menu-title text-truncate">A propos</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="d-flex align-items-center" href="<?php the_permalink(get_page_by_path('evolution')); ?>">
                    <span class="ico">🚀</span> <span class="menu-title text-truncate">Les niveaux</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="d-flex align-items-center" href="<?php the_permalink(get_page_by_path('liste-des-champions')); ?>">
                    <span class="ico">👑</span> <span class="menu-title text-truncate">Les champions</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="d-flex align-items-center" href="https://baltazare1.typeform.com/to/j9n8JU" target="_blank">
                    <span class="ico">🙏</span> <span class="menu-title text-truncate">Donne ton avis</span>
                </a>
            </li>
        </ul>
    </div>
</div>
<!-- END: Main Menu-->