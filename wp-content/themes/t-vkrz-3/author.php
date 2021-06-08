<?php
$champion        = get_user_by( 'slug', get_query_var( 'author_name' ) );
$champion_id     = $champion->ID;
get_header();
$uuidchampion    = get_field('uuiduser_user', 'user_'.$champion_id);
$user_full_data  = get_user_full_data($uuidchampion);
$nb_champion_votes   = $user_full_data[0]['nb_user_votes'];
$info_champion_level = get_user_level($uuidchampion, $champion_id, $nb_champion_votes);
?>
<div class="app-content content">
    <div class="content-wrapper">
        <div class="content-body">
            <section class="app-user-view">
                <div class="row match-height">
                    <div class="col-md-6">
                        <div class="card user-card">
                            <div class="card-body d-flex align-items-center">
                                <div class="user-avatar-section">
                                    <div class="d-flex justify-content-start align-items-center">
                                        <?php
                                            if(get_avatar_url($champion_id, ['size' => '80'])){
                                                $avatar_url = get_avatar_url($champion_id, ['size' => '80']);
                                            }
                                            else{
                                                $avatar_url = get_bloginfo('template_directory')."/assets/images/vkrz/ninja.png";
                                            }
                                        ?>
                                        <span class="avatar-picture-max" style="background-image: url(<?php echo $avatar_url; ?>);"></span>
                                        <div class="d-flex flex-column ml-2">
                                            <div class="user-info mb-1">
                                                <h1 class="mb-0 text-uppercase">
                                                    <?php echo $champion->display_name; ?>
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
                                    <?php echo $nb_champion_votes; ?>
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
                                        <?php echo $info_champion_level['level_ico']; ?>
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
                        <?php
                        $list_t_done = $user_full_data[0]['list_user_ranking_done'];
                        if($list_t_done) :
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
                                        foreach($list_t_done as $r_user) : ?>
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
                                                        <a href="<?php the_permalink(get_page_by_path('elo')); ?>?id_top=<?php echo $r_user['id_tournoi']; ?>" class="scali">
                                                            <span class="ico">👀</span>
                                                        </a>
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
                </div>
            </section>
        </div>
    </div>
</div>
<?php get_footer(); ?>