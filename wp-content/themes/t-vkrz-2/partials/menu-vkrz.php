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
                            BETA
                        </span>
                    </div>
                </a>
            </li>
        </ul>
    </div>
    <div class="shadow-bottom"></div>
    <div class="main-menu-content">
        <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">
            <li class="navigation-header">
                <span data-i18n="">Catégorie de Tops</span> <i data-feather="more-horizontal"></i>
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
                <span>Vainkeurz</span> <i data-feather="more-horizontal"></i>
            </li>
            <li class="nav-item">
                <a class="d-flex align-items-center" href="https://baltazare1.typeform.com/to/j9n8JU" target="_blank">
                    <span class="ico">🙏</span> <span class="menu-title text-truncate">Donne ton avis</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="https://discord.gg/TnNDwqH3" class="d-flex align-items-center" target="_blank" >
                    <span class="ico"><img src="<?php bloginfo('template_directory'); ?>/assets/images/vkrz/discord.png" alt="" class="img-fluid"></span> Discord
                </a>
            </li>
        </ul>
    </div>
</div>
<!-- END: Main Menu-->