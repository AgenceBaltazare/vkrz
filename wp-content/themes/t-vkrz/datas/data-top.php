<?php
/*
    Template Name: Data - Top
*/
if (isset($_GET['id_top']) && !empty($_GET['id_top'])) {
    $id_top = $_GET['id_top'];
}
get_header();
$top_datas              = get_top_data($id_top);
$top_infos              = get_top_infos($id_top);
$contenders_ranking     = get_contenders_ranking($id_top);
$sponso_datas           = get_players_of_top($id_top);
$id_resume              = get_resume_id($id_top);
$list_toplist           = json_decode(get_field('all_toplist_resume', $id_resume));
$contender_list         = $contenders_ranking;
$nb_contender           = count($contender_list);
$ranking_points         = array();
$ranking_position       = array();

foreach ($list_toplist as $ranking) :

    $user_ranking = get_user_ranking($ranking);
    $pt           = 0;

    foreach ($user_ranking as $c) {

        $points = $nb_contender - $pt;
        ${"contender_" . $c} = ${"contender_" . $c} + $points;

        for ($nbc = 0; $nbc <= $nb_contender; $nbc++) {
            if ($nbc == $pt) {
                ${"contender_" . $c . "_place_" . $nbc} = ${"contender_" . $c . "_place_" . $nbc} + 1;
            }
        }
        $pt++;
    }

endforeach;

foreach ($contender_list as $contender) {

    array_push($ranking_points, array(
        'contender_id'   => $contender['id'],
        'contender_name' => get_the_title($contender['id']),
        'contender_pts'  => ${"contender_" . $contender['id']},
    ));
}
?>
?>

<div class="intro-mobile">
    <div class="tournament-heading text-center">
        <h3 class="mb-0 t-titre-tournoi">
            Top <?php echo $top_infos['top_number']; ?> <span class="ico text-center"><span class="va va-trophy va-md"></span></span> <?php echo $top_infos['top_title']; ?>
        </h3>
        <h4 class="mb-0">
            <?php echo $top_infos['top_question']; ?>
        </h4>
    </div>
</div>

<div class="data-top">

    <div class="row">

        <div class="col-md-12">

            <section class="app-user-view">
                <div class="row match-height">
                    <div class="col-sm-3 col-6">
                        <div class="card text-center">
                            <div class="card-body">
                                <div class="ico-stats mb-1">
                                    <span class="va va-birthday-cake va-2x"></span>
                                </div>
                                <h2 class="font-weight-bolder">
                                    <?php
                                    date_default_timezone_set('Europe/Paris');
                                    $origin     = new DateTime(get_the_date('Y-m-d', $id_top));
                                    $target     = new DateTime(date('Y-m-d'));
                                    $interval   = $origin->diff($target);
                                    if ($interval->days == 0) {
                                        $info_date = "Aujourd'hui";
                                    } elseif ($interval->days == 1) {
                                        $info_date = "Hier";
                                    } else {
                                        $info_date = $interval->days . " jours";
                                    }
                                    ?>
                                    <?php echo $info_date; ?>
                                </h2>
                                <p class="card-text legende">
                                    <?php echo get_the_date('d m Y', $id_top); ?>
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-3 col-6">
                        <div class="card text-center">
                            <div class="card-body">
                                <div class="ico-stats mb-1">
                                    <span class="va va-high-voltage va-2x"></span>
                                </div>
                                <h2 class="font-weight-bolder">
                                    <?php echo $top_datas['nb_votes']; ?>
                                </h2>
                                <p class="card-text legende">
                                    <?php if ($top_datas['nb_votes'] <= 1) : ?>
                                        vote
                                    <?php else : ?>
                                        Votes
                                    <?php endif; ?>
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-3 col-6">
                        <div class="card text-center">
                            <div class="card-body">
                                <div class="pricing-badge text-right">
                                    <div class="badge badge-pill badge-light-primary">
                                        <a href="<?php the_permalink(get_page_by_path('liste-des-tops')); ?>?id_top=<?php echo $id_top; ?>" data-toggle="tooltip" data-placement="top" title="" data-original-title="Voir les <?php echo $top_datas['nb_completed_top']; ?> Tops">
                                            👀
                                        </a>
                                    </div>
                                </div>
                                <div class="ico-stats mb-1">
                                    <span class="va va-trophy va-2x"></span>
                                </div>
                                <h2 class="font-weight-bolder">
                                    <?php echo $top_datas['nb_tops']; ?>
                                </h2>
                                <p class="card-text legende">
                                    <?php if ($top_datas['nb_tops'] <= 1) : ?>
                                        Top finalisé
                                    <?php else : ?>
                                        Tops finalisés
                                    <?php endif; ?>
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-3 col-6">
                        <div class="card text-center">
                            <div class="card-body">
                                <div class="pricing-badge text-right">
                                    <div class="badge badge-pill badge-light-primary">
                                        <a href="<?php echo get_the_permalink(get_page_by_path('discuz')) . '?id_top=' . $id_top; ?>" data-toggle="tooltip" data-placement="top" title="" data-original-title="Voir ou laisser un com">
                                            ✍️
                                        </a>
                                    </div>
                                </div>
                                <div class="ico-stats mb-1">
                                    <span class="va va-speech-balloon va-2x"></span>
                                </div>
                                <h2 class="font-weight-bolder">
                                    <?php echo $top_datas['nb_comments']; ?>
                                </h2>
                                <p class="card-text legende">
                                    <?php if ($top_datas['nb_comments'] <= 1) : ?>
                                        Commentaire
                                    <?php else : ?>
                                        Commentaires
                                    <?php endif; ?>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <?php if (isset($sponso_datas['nb_players_unique']) && $sponso_datas['nb_players_unique'] > 0) : ?>
                <section class="app-user-view">
                    <div class="row match-height">

                        <div class="col-sm-2 col-6">
                            <div class="card text-center">
                                <div class="card-body">
                                    <div class="ico-stats">
                                        <span class="ico4">🎁</span>
                                    </div>
                                    <h2 class="font-weight-bolder">
                                        <?php echo $sponso_datas['nb_players_unique']; ?>
                                    </h2>
                                    <p class="card-text legende">
                                        participations
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-2 col-6">
                            <div class="card text-center">
                                <div class="card-body">
                                    <div class="ico-stats">
                                        <span class="ico4">🦙</span>
                                    </div>
                                    <h2 class="font-weight-bolder">
                                        <?php echo $sponso_datas['vainkeur_logged']; ?>
                                    </h2>
                                    <p class="card-text legende">
                                        Vainkeur
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-2 col-6">
                            <div class="card text-center">
                                <div class="card-body">
                                    <div class="ico-stats">
                                        <span class="ico4">☝️</span>
                                    </div>
                                    <h2 class="font-weight-bolder">
                                        <?php
                                        $vainkeur_info = vainkeur_info_by_uuid($sponso_datas['players_list_uuid']);
                                        echo round($vainkeur_info['one_top_percent']) . "%";
                                        ?>
                                    </h2>
                                    <p class="card-text legende">
                                        un seul Top
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-2 col-6">
                            <div class="card text-center">
                                <div class="card-body">
                                    <div class="ico-stats">
                                        <span class="ico4">✅</span>
                                    </div>
                                    <h2 class="font-weight-bolder">
                                        <?php echo round($top_datas['nb_top_complet'] * 100 / $top_datas['nb_tops']); ?>%
                                    </h2>
                                    <p class="card-text legende">
                                        <?php echo $top_datas['nb_top_complet']; ?> Tops complet sur <?php echo $top_datas['nb_tops']; ?>
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-2 col-6">
                            <div class="card text-center">
                                <div class="card-body">
                                    <div class="ico-stats">
                                        <span class="ico4">3️⃣</span>
                                    </div>
                                    <h2 class="font-weight-bolder">
                                        <?php echo round($top_datas['nb_top_3'] * 100 / $top_datas['nb_tops']); ?>%
                                    </h2>
                                    <p class="card-text legende">
                                        <?php echo $top_datas['nb_top_3']; ?> Tops 3
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-2 col-6">
                            <div class="card text-center">
                                <div class="card-body">
                                    <div class="ico-stats">
                                        <span class="ico4">👌</span>
                                    </div>
                                    <h2 class="font-weight-bolder">
                                        <?php echo $top_datas['percent_finition']; ?>%
                                    </h2>
                                    <p class="card-text legende">
                                        finition du Top
                                    </p>
                                </div>
                            </div>
                        </div>

                    </div>
                </section>

            <?php endif; ?>

            <div class="card">
                <div class="card-body">
                    <h3 class="titrage-classement">Classement ELO</h3>
                    <div class="list-elo">
                        <?php
                        $i = 1;
                        foreach ($contenders_ranking as $contender) : ?>
                            <div class="contender-elo-data">
                                <div class="illu">
                                    <?php
                                    $illu = $contender["illustration"];
                                    if (get_field('visuel_cover_t', $id_top)) :
                                    ?>
                                        <div class="cov-illu" style="background: url(<?php echo $illu; ?>) center center no-repeat"></div>
                                    <?php else : ?>
                                        <?php if (get_field('visuel_instagram_contender', $contender["id"])) : ?>
                                            <img src="<?php the_field('visuel_instagram_contender', $contender["id"]); ?>" alt="" class="img-fluid">
                                        <?php else : ?>
                                            <img src="<?php echo $illu; ?>" class="img-fluid" />
                                        <?php endif; ?>
                                    <?php endif; ?>
                                </div>
                                <div class="name eh2">
                                    <h5 class="mt-2">
                                        <?php if ($i == 1) : ?>
                                            <span class="ico">🥇</span>
                                        <?php elseif ($i == 2) : ?>
                                            <span class="ico">🥈</span>
                                        <?php elseif ($i == 3) : ?>
                                            <span class="ico">🥉</span>
                                        <?php else : ?>
                                            <span><?php echo $i; ?><br></span>
                                        <?php endif; ?>
                                        <?php if (!$top_infos['top_d_titre']) : ?>
                                            <span class="ranking-title"><?php echo $contender["title"]; ?></span>
                                        <?php endif; ?>
                                        <div class="pointselo" data-points="<?php echo $contender["points"]; ?>">
                                            <?php echo $contender["points"]; ?> pts
                                        </div>
                                    </h5>
                                </div>
                            </div>
                        <?php $i++;
                        endforeach; ?>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <h3 class="titrage-classement">Classement aux points</h3>
                    <div class="list-elo">
                        <?php
                        array_sort_by_column($ranking_points, 'contender_pts');
                        $i = 1;
                        foreach ($ranking_points as $contender) : ?>
                            <div class="contender-elo-data">
                                <div class="illu">
                                    <?php
                                    $illu = get_the_post_thumbnail_url($contender['contender_id'], 'full');
                                    if (get_field('visuel_cover_t', $contender['contender_id'])) :
                                    ?>
                                        <div class="cov-illu" style="background: url(<?php echo $illu; ?>) center center no-repeat"></div>
                                    <?php else : ?>
                                        <?php if (get_field('visuel_instagram_contender', $contender["id"])) : ?>
                                            <img src="<?php the_field('visuel_instagram_contender', $contender["id"]); ?>" alt="" class="img-fluid">
                                        <?php else : ?>
                                            <img src="<?php echo $illu; ?>" class="img-fluid" />
                                        <?php endif; ?>
                                    <?php endif; ?>
                                </div>
                                <div class="name eh2">
                                    <h5 class="mt-2">
                                        <?php if ($i == 1) : ?>
                                            <span class="ico">🥇</span>
                                        <?php elseif ($i == 2) : ?>
                                            <span class="ico">🥈</span>
                                        <?php elseif ($i == 3) : ?>
                                            <span class="ico">🥉</span>
                                        <?php else : ?>
                                            <span><?php echo $i; ?><br></span>
                                        <?php endif; ?>
                                        <?php if (!$top_infos['top_d_titre']) : ?>
                                            <span class="ranking-title"><?php echo $contender["contender_name"]; ?></span>
                                        <?php endif; ?>
                                        <div class="pointselo" data-points="<?php echo $contender["points"]; ?>">
                                            <?php echo $contender["contender_pts"]; ?> pts
                                        </div>
                                    </h5>
                                </div>
                            </div>
                        <?php $i++;
                        endforeach; ?>
                    </div>
                </div>
            </div>

            <div class="card invoice-list-wrapper">
                <div class="card-datatable table-responsive">
                    <table class="invoice-list-table table table-tdone">
                        <thead>
                            <tr>
                                <th class="text-left">
                                    Positions
                                </th>
                                <?php for ($nbc = 1; $nbc <= $nb_contender; $nbc++) : ?>
                                    <th class="text-center">
                                        <?php if ($nbc == 1) : ?>
                                            🥇
                                        <?php elseif ($nbc == 2) : ?>
                                            🥈
                                        <?php elseif ($nbc == 3) : ?>
                                            🥉
                                        <?php else : ?>
                                            <?php echo $nbc; ?>
                                        <?php endif; ?>
                                    </th>
                                <?php endfor; ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($contender_list as $contender) : ?>
                                <tr>
                                    <td>
                                        <?php echo get_the_title($contender['id']); ?>
                                    </td>
                                    <?php for ($nbc = 0; $nbc < $nb_contender; $nbc++) : ?>
                                        <td class="text-center">
                                            <?php
                                            $nb_position        = ${"contender_" . $contender['id'] . "_place_" . $nbc};
                                            $percent_position   = $nb_position * 100 / count($list_toplist);
                                            echo round($percent_position, 1) . "%";
                                            ?>
                                            <br>
                                            <small class="text-muted"><?php echo $nb_position; ?></small>
                                        </td>
                                    <?php endfor; ?>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<?php get_footer(); ?>