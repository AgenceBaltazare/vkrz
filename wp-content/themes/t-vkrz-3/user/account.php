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
                                            <?php echo get_user_level($uuiduser, $nb_user_votes); ?>
                                        </span>
                                    </div>
                                    <p class="card-text legende">Niveau actuel</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                <?php
                $list_r_done = $user_full_data[0]['list_user_ranking_done'];
                $list_r_begin = $user_full_data[0]['list_user_ranking_begin'];
                ?>
                <!-- profile info section -->
                <section id="profile-info">
                    <div class="row">
                        <?php
                        if($list_r_begin){
                            $classcol = 7;
                        }
                        else{
                            $classcol = 12;
                        }
                        ?>
                        <div class="col-md-<?php echo $classcol; ?>">
                            <?php
                            if($list_r_done) : ?>
                                <div class="card">
                                    <div class="card-body p-0">
                                        <div class="table-responsive">
                                            <table class="table">
                                                <thead>
                                                <tr>
                                                    <th class="">
                                                        ⚔️<br>
                                                        Les Tops terminés
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
                                                    <th class="text-center">
                                                        🌍<br>
                                                        Mondial
                                                    </th>
                                                    <th class="text-center">
                                                        🥷<br>
                                                        Identiques
                                                    </th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <?php
                                                foreach($list_r_done as $r_user) : ?>
                                                    <?php if($r_user['nb_votes'] > 0): ?>
                                                        <tr>
                                                            <td>
                                                                <div class="media-body">
                                                                    <div class="media-heading">
                                                                        <h6 class="cart-item-title mb-0">
                                                                            <a class="text-body" href="<?php the_permalink($r_user['id_tournoi']); ?>">
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
                                                            <td class="text-center">
                                                                <a href="<?php the_permalink($r_user['id_ranking']); ?>" class="scali">
                                                                    <span class="ico">👀</span>
                                                                </a>
                                                            </td>
                                                            <td class="text-center">
                                                                <a href="<?php the_permalink(get_page_by_path('elo')); ?>?id_top=<?php echo $r_user['id_tournoi']; ?>" class="scali" data-toggle="tooltip" data-placement="right" title="" data-original-title="Des Tops sont identiques au tien">
                                                                    <span class="ico">👀</span>
                                                                </a>
                                                            </td>
                                                            <td class="text-center">
                                                            <span data-toggle="tooltip" data-placement="bottom" title="" data-original-title="<?php echo get_user_percent($uuiduser, $r_user['id_tournoi']); ?>% des Tops sont identiques au tien">
                                                                <?php echo get_user_percent($uuiduser, $r_user['id_tournoi']); ?>%
                                                            </span>
                                                            </td>
                                                        </tr>
                                                    <?php endif; ?>
                                                <?php endforeach; ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>
                        <div class="col-md-5">
                            <?php
                            if($list_r_begin): ?>
                                <div class="card">
                                    <div class="card-body p-0">
                                        <div class="table-responsive">
                                            <table class="table">
                                                <thead>
                                                <tr>
                                                    <th class="">
                                                        ⚔️<br>
                                                        Les Tops à finir
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
                                                            <a class="btn btn-outline-primary waves-effect mr-1" href="<?php the_permalink($r_user['id_tournoi']); ?>">
                                                                Terminer
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