<?php
global $uuiduser;
get_header();
?>
<div class="app-content content">
    <div class="content-wrapper">
        <div class="content-body">
            <section class="app-user-view">
                <?php if(!is_user_logged_in()): ?>
                    <div role="alert" aria-live="polite" aria-atomic="true" class="alert alert-account" data-v-aa799a9e="">
                        <div class="alert-body d-flex align-items-center justify-content-between">
                            <span><strong>Pour sécuriser ta progression</strong> l'idéal serait de te créer un compte.</span>
                            <div class="btns-alert text-right">
                                <a class="btn btn-outline-white waves-effect mr-1 t-white" href="<?php the_permalink(get_page_by_path('connexion')); ?>">
                                    J'ai déjà un compte
                                </a>
                                <a class="btn btn-primary waves-effect" href="<?php the_permalink(get_page_by_path('creer-mon-compte')); ?>">
                                    Excellent idée - je créer mon compte <span class="ico">🎉</span>
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
                                    <div class="d-flex justify-content-start align-items-center">
                                        <span class="avatar-picture-max" style="background-image: url(<?php bloginfo('template_directory'); ?>/assets/images/vkrz/ninja.png);"></span>
                                        <div class="d-flex flex-column ml-2">
                                            <div class="user-info mb-1">
                                                <h1 class="mb-0 text-uppercase">
                                                    <?php if(is_author()): ?>
                                                        <?php echo $current_user->display_name; ?>
                                                    <?php else: ?>
                                                        #<?php echo $uuiduser; ?>
                                                    <?php endif; ?>
                                                </h1>
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
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body p-0">
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                        <tr>
                                            <th>#</th>
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
                                                Top complet
                                            </th>
                                            <th class="text-center">
                                                🌍<br>
                                                Top mondial
                                            </th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                        $list_r_done = get_user_ranking_list('r-done', $uuiduser);
                                        foreach($list_r_done as $r_user) : ?>

                                            <tr>
                                                <td>
                                                    Top <?php echo get_numbers_of_contenders($r_user['id_tournoi']); ?>
                                                </td>
                                                <td>
                                                    <div class="media-body">
                                                        <div class="media-heading">
                                                            <h6 class="cart-item-title mb-0">
                                                                <a class="text-body" href="<?php the_permalink($r_user['id_tournoi']); ?>">
                                                                    <?php echo get_the_title($r_user['id_tournoi']); ?>
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
                                                    $user_top3 = get_user_top(false, $r_user['id_tournoi']);
                                                    $l=1;
                                                    foreach($user_top3 as $top => $p): ?>

                                                        <div data-toggle="tooltip" data-popup="tooltip-custom" data-placement="top" data-original-title="<?php echo get_the_title($top); ?>" class="avatar pull-up">
                                                            <?php $illu = get_the_post_thumbnail_url($top, 'full'); ?>
                                                            <img src="<?php echo $illu; ?>" alt="Avatar" height="32" width="32">
                                                        </div>

                                                        <?php $l++; if($l==4) break; endforeach; ?>
                                                </td>
                                                <td class="text-center">
                                                    <a href="<?php the_permalink($r_user['id_ranking']); ?>" class="scali">
                                                        <span class="ico">👀</span>
                                                    </a>
                                                </td>
                                                <td class="text-center">
                                                    <a href="<?php the_permalink(get_page_by_path('elo')); ?>?id_tournoi=<?php echo $r_user['id_tournoi']; ?>" class="scali">
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
                    </div>
                </div>
            </section>
        </div>
    </div>
</div>
<?php get_footer(); ?>