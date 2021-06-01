<?php
/*
    Template Name: Account
*/
?>
<?php
global $uuiduser;
global $current_user;
global $user_id;
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
                                                <div class="user-info mb-1">
                                                    <?php if(is_user_logged_in()): ?>
                                                        <h1 class="mb-0 text-uppercase">
                                                            <?php echo $current_user->display_name; ?>
                                                        </h1>
                                                        <div class="btn-account mt-1">
                                                            <a class="btn btn-outline-primary waves-effect mr-1" href="<?php the_permalink(get_page_by_path('parametres')); ?>">
                                                                Éditer mon compte
                                                            </a>
                                                            <a class="btn btn-outline-primary waves-effect" href="<?php echo get_author_posts_url($user_id); ?>">
                                                                Voir mon profil public 😎
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
                                        <?php echo get_user_data("nb-user-vote", $uuiduser); ?>
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
                                        $list_t_already_done = get_user_tournament_list('t-done', $uuiduser);
                                        echo count($list_t_already_done);
                                        ?>
                                    </h2>
                                    <p class="card-text legende">Tops terminés</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="card text-center">
                                <div class="card-body">
                                    <div class="user-level">
                                    <span class="icomax">
                                        🐣
                                    </span>
                                    </div>
                                    <p class="card-text legende">Niveau actuel</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                <!-- profile info section -->
                <section id="profile-info">
                    <div class="row">
                        <div class="col-md-5">
                            <?php
                            $list_r_begin = get_user_ranking_list('r-begin', $uuiduser);
                            ?>
                            <?php if($list_r_begin): ?>
                                <div class="card">
                                    <div class="card-body p-0">
                                        <div class="table-responsive">
                                            <table class="table">
                                                <thead>
                                                <tr>
                                                    <th class="">
                                                        ⚔️<br>
                                                        Tous les Tops à finir
                                                    </th>
                                                    <th class="text-center">
                                                        💎<br>
                                                        Votes
                                                    </th>
                                                    <th class="text-center">

                                                    </th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <?php
                                                foreach($list_r_begin as $r_user) : ?>
                                                    <tr>
                                                        <td>
                                                            <div class="media-body">
                                                                <div class="media-heading">
                                                                    <h6 class="cart-item-title mb-0">
                                                                        <a class="text-body" href="<?php the_permalink($r_user['id_tournoi']); ?>">
                                                                            Top <?php echo get_numbers_of_contenders($r_user['id_tournoi']); ?> - <?php echo get_the_title($r_user['id_tournoi']); ?>
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
                                                            <a class="btn btn-outline-primary waves-effect mr-1" href="<?php the_permalink($r_user['id_tournoi']); ?>">
                                                                Finir le Top
                                                            </a>
                                                        </td>
                                                    </tr>

                                                <?php endforeach; ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>
                        <div class="col-md-7">
                            <?php
                            $list_r_done = get_user_ranking_list('r-done', $uuiduser);
                            if($list_r_done) :
                                ?>
                                <div class="card">
                                    <div class="card-body p-0">
                                        <div class="table-responsive">
                                            <table class="table">
                                                <thead>
                                                <tr>
                                                    <th class="">
                                                        ⚔️<br>
                                                        Tous les Tops terminés
                                                    </th>
                                                    <th class="text-center">
                                                        💎<br>
                                                        Votes
                                                    </th>
                                                    <th class="">
                                                        🥇🥈🥉<br>
                                                        Podium
                                                    </th>
                                                    <th class="text-center">
                                                        🏆<br>
                                                        Complet
                                                    </th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <?php
                                                foreach($list_r_done as $r_user) : ?>
                                                    <tr>
                                                        <td>
                                                            <div class="media-body">
                                                                <div class="media-heading">
                                                                    <h6 class="cart-item-title mb-0">
                                                                        <a class="text-body" href="<?php the_permalink($r_user['id_tournoi']); ?>">
                                                                            Top <?php echo get_numbers_of_contenders($r_user['id_tournoi']); ?> - <?php echo get_the_title($r_user['id_tournoi']); ?>
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
                                                            $user_top3 = get_user_top($uuiduser, $r_user['id_tournoi']);
                                                            $l=1;
                                                            foreach($user_top3 as $top => $p): ?>

                                                                <div data-toggle="tooltip" data-popup="tooltip-custom" data-placement="bottom" data-original-title="<?php echo get_the_title($top); ?>" class="avatartop3 avatar pull-up">
                                                                    <?php $illu = get_the_post_thumbnail_url($top, 'thumbnail'); ?>
                                                                    <img src="<?php echo $illu; ?>" alt="Avatar">
                                                                </div>

                                                            <?php $l++; if($l==4) break; endforeach; ?>
                                                        </td>
                                                        <td class="text-center">
                                                            <a href="<?php the_permalink($r_user['id_ranking']); ?>" class="scali">
                                                                <span class="ico">👀</span>
                                                            </a>
                                                        </td>
                                                    </tr>

                                                <?php endforeach; ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
<?php get_footer(); ?>