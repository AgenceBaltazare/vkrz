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
                <h3 class="mb-0">Top <?php echo get_numbers_of_contenders($id_tournament); ?> <span class="ico text-center">🏆</span> <?php echo get_the_title($id_tournament); ?></h3>
                <h4 class="mb-0"><?php the_field( 'question_t', $id_tournament ); ?></h4>

            <?php elseif(is_page(get_page_by_path('elo'))): ?>

                <?php $id_tournament = $_GET['id_tournoi']; ?>
                <h3 class="mb-0">
                    Top <?php echo get_numbers_of_contenders($id_tournament); ?> mondial <span class="ico text-center">🏆</span> <?php echo get_the_title($id_tournament); ?>
                </h3>
                <h4 class="mb-0">
                    <?php the_field( 'question_t', $id_tournament ); ?> - <?php echo all_votes_in_tournament($id_tournament); ?> votes
                </h4>

            <?php elseif(is_archive()): ?>

                <?php $current_cat = get_queried_object(); ?>
                <h3 class="mb-0"><span class="ico"><?php the_field('icone_cat', 'term_'.$current_cat->term_id); ?></span> <?php echo $current_cat->name; ?></h3>
                <h4 class="mb-0"><?php echo $current_cat->description; ?></h4>

            <?php endif; ?>
        </div>

    </div>
</nav>
<!-- END: Header-->