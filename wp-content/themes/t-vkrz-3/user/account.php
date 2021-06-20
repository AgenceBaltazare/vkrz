<?php
/*
    Template Name: Account
*/
global $uuiduser;
global $current_user;
global $user_id;
global $nb_user_votes;
get_header();
?>
    <div class="app-content content">
        <div class="content-wrapper">
            <div class="content-body">
                <section class="app-user-view">
                    <?php if(!is_user_logged_in()): ?>
                        <div role="alert" aria-live="polite" aria-atomic="true" class="alert alert-account" data-v-aa799a9e="">
                            <div class="alert-body d-flex align-items-center justify-content-between">
                                <span><strong><span class="ico">💾</span>Pour sauvegarder ta progression</strong> l'idéal serait de te créer un compte.</span>
                                <div class="btns-alert text-right">
                                    <a class="btn btn-outline-white waves-effect mr-1 t-white" href="<?php the_permalink(get_page_by_path('se-connecter')); ?>">
                                        J'ai déjà un compte
                                    </a>
                                    <a class="btn btn-primary waves-effect" href="<?php the_permalink(get_page_by_path('creer-mon-compte')); ?>">
                                        Excellente idée - je créé mon compte <span class="ico">🎉</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                    <div class="row match-height">
                        <div class="col-md-6">
                            <div class="card user-card">
                                <div class="card-body d-flex align-items-center">
                                    <div class="user-avatar-section">
                                        <div class="d-flex justify-content-start align-items-center content-avatar-name">
                                            <?php
                                            if(is_user_logged_in() && get_avatar_url($user_id, ['size' => '80'])){
                                                $avatar_url = get_avatar_url($user_id, ['size' => '80']);
                                            }
                                            else{
                                                $avatar_url = get_bloginfo('template_directory')."/assets/images/vkrz/ninja.png";
                                            }
                                            ?>
                                            <span class="avatar-picture-max" style="background-image: url(<?php echo $avatar_url; ?>);"></span>
                                            <div class="d-flex flex-column ml-2">
                                                <div class="user-info">
                                                    <?php if(is_user_logged_in()): ?>
                                                        <h1 class="mb-0 text-uppercase">
                                                            <?php echo $current_user->display_name; ?>
                                                        </h1>
                                                        <div class="btn-account mt-1">
                                                            <a class="btn btn-outline-primary waves-effect mr-1" href="<?php the_permalink(get_page_by_path('parametres')); ?>">
                                                                Éditer
                                                            </a>
                                                            <a class="btn btn-outline-primary waves-effect" href="<?php echo get_author_posts_url($user_id); ?>">
                                                                Profil public
                                                            </a>
                                                        </div>
                                                    <?php else: ?>
                                                        <h1 class="mb-0 text-uppercase">
                                                            #FuturChampion
                                                        </h1>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="card text-center">
                                <div class="card-body">
                                    <div class="mb-1">
                                        <span class="ico4">💎</span>
                                    </div>
                                    <h2 class="font-weight-bolder">
                                        <?php echo $nb_user_votes; ?>
                                    </h2>
                                    <p class="card-text legende">Votes</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="card text-center">
                                <div class="card-body">
                                    <div class="mb-1">
                                        <span class="ico4">🏆</span>
                                    </div>
                                    <h2 class="font-weight-bolder">
                                        <?php
                                        $list_t_done = $user_full_data[0]['list_user_ranking_done'];
                                        echo count($list_t_done);
                                        ?>
                                    </h2>
                                    <p class="card-text legende">Tops terminés</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="card text-center">
                                <div class="card-body">
                                    <div class="pricing-badge text-right">
                                        <div class="badge badge-pill badge-light-primary">
                                            <a href="<?php the_permalink(get_page_by_path('evolution')); ?>">
                                                ?
                                            </a>
                                        </div>
                                    </div>
                                    <div class="user-level">
                                        <span class="icomax">
                                            <?php echo $info_user_level['level_ico']; ?>
                                        </span>
                                    </div>
                                    <p class="card-text legende">Niveau actuel</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                <!--
                <section class="stats_user">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row avg-sessions pt-50">
                                        <?php
                                        $cat_t = get_terms( array(
                                            'taxonomy'      => 'categorie',
                                            'orderby'       => 'count',
                                            'order'         => 'DESC',
                                            'hide_empty'    => true,
                                        ));
                                        foreach($cat_t as $cat) : ?>
                                            <div class="col-3 mt-1 mb-1">
                                                <p class="mb-50">
                                                    <span class="ico2 ">
                                                        <span class="<?php if($cat->term_id == 2){echo 'rotating';} ?>">
                                                            <?php the_field('icone_cat', 'term_'.$cat->term_id); ?>
                                                        </span>
                                                    </span> <?php echo $cat->name; ?>
                                                </p>
                                                <div class="progress progress-bar-primary" style="height: 6px">
                                                    <div class="progress-bar" role="progressbar" aria-valuenow="50" aria-valuemin="50" aria-valuemax="100" style="width: 50%"></div>
                                                </div>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                -->

                <?php
                $list_r_done = $user_full_data[0]['list_user_ranking_done'];
                $list_r_begin = $user_full_data[0]['list_user_ranking_begin'];
                ?>
                <section id="basic-tabs-components">
                    <ul class="nav nav-tabs" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="homeIcon-tab" data-toggle="tab" href="#tab1" aria-controls="home" role="tab" aria-selected="true">
                                Les Tops à terminer
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="profileIcon-tab" data-toggle="tab" href="#tab2" aria-controls="profile" role="tab" aria-selected="false">
                                Les Tops terminés
                            </a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="tab1" aria-labelledby="homeIcon-tab" role="tabpanel">
                            <div class="row">
                                <div class="col-12">
                                    <div class="card invoice-list-wrapper">
                                        <div class="card-datatable table-responsive">
                                            <table class="invoice-list-table table">
                                                <thead>
                                                <tr>
                                                    <th class="">
                                                        <span class="t-rose"><?php echo count($list_r_begin); ?></span> Tops à terminer
                                                    </th>
                                                    <th class="text-center">
                                                        💎
                                                    </th>
                                                    <th class="">
                                                        🥇🥈🥉
                                                    </th>
                                                    <th>
                                                        👀
                                                    </th>
                                                    <th>

                                                    </th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <?php
                                                foreach($list_r_begin as $r_user) : ?>
                                                    <?php if($r_user['nb_votes'] > 0): ?>
                                                        <tr id="top-<?php echo $r_user['id_ranking']; ?>">
                                                            <td>
                                                                <div class="media-body">
                                                                    <div class="media-heading">
                                                                        <h6 class="cart-item-title mb-0">
                                                                            <a class="text-body" href="<?php the_permalink($r_user['id_tournoi']); ?>" data-toggle="tooltip" data-placement="top" title="<?php the_field('question_t', $r_user['id_tournoi']); ?>" data-original-title="<?php the_field('question_t', $r_user['id_tournoi']); ?>">
                                                                                Top <?php echo $r_user['nb_top']; ?> - <?php echo get_the_title($r_user['id_tournoi']); ?>
                                                                            </a>
                                                                        </h6>
                                                                        <small class="cart-item-by legende">
                                                                            <?php the_field('question_t', $r_user['id_tournoi']); ?>
                                                                        </small>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                            <td class="text-center">
                                                                <?php echo $r_user['nb_votes']; ?> <span class="ico3">💎</span>
                                                            </td>
                                                            <td>
                                                                <?php
                                                                $user_top3 = get_user_ranking($r_user['id_ranking']);
                                                                $l=1;
                                                                foreach($user_top3 as $top => $p): ?>

                                                                    <div data-toggle="tooltip" data-popup="tooltip-custom" data-placement="bottom" data-original-title="<?php echo get_the_title($top); ?>" class="avatartop3 avatar pull-up">
                                                                        <?php $illu = get_the_post_thumbnail_url($top, 'thumbnail'); ?>
                                                                        <img src="<?php echo $illu; ?>" alt="Avatar">
                                                                    </div>

                                                                <?php $l++; if($l==4) break; endforeach; ?>
                                                            </td>
                                                            <td>
                                                                <a class="mr-1" href="<?php the_permalink(get_page_by_path('elo')); ?>?id_top=<?php echo $r_user['id_tournoi']; ?>" data-toggle="tooltip" data-placement="top" title="" data-original-title="Voir le classement mondial">
                                                                    <span class="ico">
                                                                        🌍
                                                                    </span>
                                                                </a>
                                                            </td>
                                                            <td class="text-center">
                                                                <div class="d-flex align-items-center col-actions">
                                                                    <a href="<?php the_permalink($r_user['id_tournoi']); ?>" data-toggle="tooltip" data-placement="top" title="" data-original-title="Continuer le Top">
                                                                        <span class="ico">▶️</span>
                                                                    </a>
                                                                    <a data-phrase1="Es-tu sûr de toi ?" data-phrase2="Tous les votes de ce Top seront remis à 0" data-idranking="<?php echo $r_user['id_ranking']; ?>" class="confirm_delete" href="#" data-toggle="tooltip" data-placement="top" title="" data-original-title="Recommencer le Top">
                                                                        <span class="ico">🆕</span>
                                                                    </a>
                                                                    <a data-phrase1="Es-tu sûr de toi ?" data-phrase2="Le Top sera supprimé définitivement 😱" data-idranking="<?php echo $r_user['id_ranking']; ?>" class="confirmDeleteReal" href="#" data-toggle="tooltip" data-placement="top" title="" data-original-title="Abandonner le Top">
                                                                        <span class="ico">🚮</span>
                                                                    </a>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    <?php endif; ?>
                                                <?php endforeach; ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane" id="tab2" aria-labelledby="profileIcon-tab" role="tabpanel">
                            <div class="row">
                                <div class="col-12">
                                    <div class="card invoice-list-wrapper">
                                        <div class="card-datatable table-responsive">
                                            <table class="invoice-list-table table">
                                                <thead>
                                                <tr>
                                                    <th class="">
                                                        <span class="t-rose"><?php echo count($list_r_done); ?></span> Tops terminés
                                                    </th>
                                                    <th class="text-center">
                                                        💎
                                                    </th>
                                                    <th class="">
                                                        🥇🥈🥉
                                                    </th>
                                                    <th>
                                                        👀
                                                    </th>
                                                    <th>

                                                    </th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <?php
                                                foreach($list_r_done as $r_user) : ?>
                                                    <?php if($r_user['nb_votes'] > 0): ?>
                                                        <tr id="top-<?php echo $r_user['id_ranking']; ?>">
                                                            <td>
                                                                <div class="media-body">
                                                                    <div class="media-heading">
                                                                        <h6 class="cart-item-title mb-0">
                                                                            <a class="text-body" href="<?php the_permalink($r_user['id_tournoi']); ?>" data-toggle="tooltip" data-placement="top" title="<?php the_field('question_t', $r_user['id_tournoi']); ?>" data-original-title="<?php the_field('question_t', $r_user['id_tournoi']); ?>">
                                                                                Top <?php echo $r_user['nb_top']; ?> - <?php echo get_the_title($r_user['id_tournoi']); ?>
                                                                            </a>
                                                                        </h6>
                                                                        <small class="cart-item-by legende">
                                                                            <?php the_field('question_t', $r_user['id_tournoi']); ?>
                                                                        </small>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                            <td class="text-center">
                                                                <?php echo $r_user['nb_votes']; ?> <span class="ico3">💎</span>
                                                            </td>
                                                            <td>
                                                                <?php
                                                                $user_top3 = get_user_ranking($r_user['id_ranking']);
                                                                $l=1;
                                                                foreach($user_top3 as $top => $p): ?>

                                                                    <div data-toggle="tooltip" data-popup="tooltip-custom" data-placement="bottom" data-original-title="<?php echo get_the_title($top); ?>" class="avatartop3 avatar pull-up">
                                                                        <?php $illu = get_the_post_thumbnail_url($top, 'thumbnail'); ?>
                                                                        <img src="<?php echo $illu; ?>" alt="Avatar">
                                                                    </div>

                                                                    <?php $l++; if($l==4) break; endforeach; ?>
                                                            </td>
                                                            <td>
                                                                <div class="d-flex align-items-center col-actions">
                                                                    <a class="mr-1" href="<?php the_permalink($r_user['id_ranking']); ?>" data-toggle="tooltip" data-placement="top" title="" data-original-title="Voir le Top complet">
                                                                        <span class="ico">
                                                                            🏆
                                                                        </span>
                                                                    </a>
                                                                    <a class="mr-1" href="<?php the_permalink(get_page_by_path('elo')); ?>?id_top=<?php echo $r_user['id_tournoi']; ?>" data-toggle="tooltip" data-placement="top" title="" data-original-title="Voir le classement mondial">
                                                                        <span class="ico">
                                                                            🌍
                                                                        </span>
                                                                    </a>
                                                                </div>
                                                            </td>
                                                            <td class="text-center">
                                                                <div class="dropdown">
                                                                    <a class="btn btn-sm btn-icon px-0" data-toggle="dropdown">
                                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-more-vertical font-medium-2">
                                                                            <circle cx="12" cy="12" r="1"></circle>
                                                                            <circle cx="12" cy="5" r="1"></circle>
                                                                            <circle cx="12" cy="19" r="1"></circle>
                                                                        </svg>
                                                                    </a>
                                                                    <div class="dropdown-menu dropdown-menu-right">
                                                                        <a data-phrase1="Es-tu sûr de toi ?" data-phrase2="Tous les votes de ce Top seront remis à 0" data-idranking="<?php echo $r_user['id_ranking']; ?>" class="confirm_delete dropdown-item" href="#">
                                                                            <span class="ico">🆕</span> Recommencer
                                                                        </a>
                                                                        <a data-phrase1="Es-tu sûr de toi ?" data-phrase2="Le Top sera supprimé définitivement 😱" data-idranking="<?php echo $r_user['id_ranking']; ?>" class="confirmDeleteReal dropdown-item" href="#">
                                                                            <span class="ico">🚮</span> Supprimer
                                                                        </a>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    <?php endif; ?>
                                                <?php endforeach; ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
<?php get_footer(); ?>