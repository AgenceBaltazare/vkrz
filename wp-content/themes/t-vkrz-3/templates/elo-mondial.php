<?php
/*
    Template Name: Classement
*/
global $uuiduser;
if (isset($_GET['id_top']) && !empty($_GET['id_top'])) {
    $id_top  = $_GET['id_top'];
} else {
    header('Location: ' . get_bloginfo('url'));
}
get_header();
global $top_infos;
global $user_tops;
$list_t_already_done  = $user_tops['list_user_tops_done_ids'];
$top_datas            = get_top_data($id_top);
$user_single_top_data = array_search($id_top, $list_t_already_done);

$contenders_ranking = get_contenders_ranking($id_top);
?>
<div class="page-template-elo-mondial app-content content cover" style="background: url(<?php echo $top_infos['top_cover']; ?>) center center no-repeat">
    <div class="content-overlay"></div>
    <div class="content-wrapper">
        <div class="content-body mt-2">

            <div class="intro-mobile">
                <div class="tournament-heading text-center">
                    <h3 class="mb-0 t-titre-tournoi">
                        Top <?php echo $top_infos['top_number']; ?> <span class="ico text-center">🏆</span> <?php echo $top_infos['top_title']; ?>
                    </h3>
                    <h4 class="mb-0">
                        <?php echo $top_infos['top_question']; ?>
                    </h4>
                </div>
            </div>

            <div class="classement">

                <div class="row">

                    <div class="col-md-10">

                        <div class="list-classement">

                            <?php
                            $i = 1;
                            foreach ($contenders_ranking as $contender) :
                            ?>
                                <?php
                                if ($i >= 4) {
                                    $d = 3;
                                } else {
                                    $d = $i - 1;
                                }
                                ?>
                                
                                <div class="contender-item contender-item-n<?php echo $i; ?>" id="ranking-<?php echo $i; ?>" data-id="<?php echo $contender["id"]; ?>">
                                    <?php
                                    if ($i >= 4) {
                                        $d = 3;
                                    } else {
                                        $d = $i - 1;
                                    }
                                    ?>
                                    <div class="animate__jackInTheBox animate__animated animate__delay-<?php echo $d; ?>s contenders_min mb-2 <?php echo ($top_infos['top_d_rounded']) ? 'rounded' : ''; ?>">
                                        <div class="illu">
                                            <?php
                                            $illu = $contender["illustration"];
                                            if (get_field('visuel_cover_t', $id_top)) :
                                            ?>
                                                <div class="cov-illu" style="background: url(<?php echo $illu; ?>) center center no-repeat"></div>
                                            <?php else : ?>
                                                <img src="<?php echo $illu; ?>" class="img-fluid" />
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
                                            </h5>
                                            <div class="pointselo" data-points="<?php echo $contender["points"]; ?>">
                                                <?php echo $contender["points"]; ?> pts
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php $i++;
                            endforeach; ?>
                        </div>
                    </div>

                    <div class="col-md-2">

                        <div class="related infoelo infoelomondial">

                            <div class="row match-height">

                                <div class="col-6 col-sm-12">
                                    <div class="card text-center">
                                        <div class="card-body">
                                            <div class="pricing-badge text-right">
                                                <div class="badge badge-pill badge-light-primary">
                                                    <a href="<?php the_permalink(get_page_by_path('liste-des-tops')); ?>?id_top=<?php echo $id_top; ?>" data-toggle="tooltip" data-placement="top" title="" data-original-title="Voir les <?php echo $top_datas['nb_tops']; ?> Tops">
                                                        👀
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="ico-stats">
                                                <span class="ico4">🏆</span>
                                            </div>
                                            <h2 class="font-weight-bolder">
                                                <?php echo $top_datas['nb_tops']; ?>
                                            </h2>
                                            <p class="card-text legende">
                                                <?php if ($top_datas['nb_tops'] <= 1) : ?>
                                                    Top
                                                <?php else : ?>
                                                    Tops
                                                <?php endif; ?>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6 col-sm-12">
                                    <div class="card text-center">
                                        <div class="card-body">
                                            <div class="ico-stats">
                                                <span class="ico4">💎</span>
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
                                <div class="col-6 col-sm-12">
                                    <div class="card text-center">
                                        <div class="card-body">
                                            <div class="pricing-badge text-right">
                                                <div class="badge badge-pill badge-light-primary">
                                                    <a href="<?php echo get_the_permalink(get_page_by_path('discuz')) . '?id_top=' . $id_top; ?>" data-toggle="tooltip" data-placement="top" title="" data-original-title="Voir ou laisser un com">
                                                        ✍️
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="ico-stats">
                                                <span class="ico4">💬</span>
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
                                <div class="col-6 col-sm-12">
                                    <div class="card text-center">
                                        <div class="card-body">
                                            <div class="ico-stats">
                                                <span class="ico4">🎂</span>
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
                                                <?php
                                                $creator_id         = get_post_field('post_author', $id_top);
                                                $creator_uuiduser   = get_field('uuiduser_user', 'user_' . $creator_id);
                                                $creator_data       = get_user_infos($creator_uuiduser);
                                                ?>
                                                par <?php echo $creator_data['pseudo']; ?>
                                                <span class="ico" data-toggle="tooltip" data-placement="top" title="" data-original-title="Niveau actuel">
                                                    <?php echo $creator_data['level']; ?>
                                                </span>
                                                <?php if ($creator_data['user_role']  == "administrator") : ?>
                                                    <span class="ico" data-toggle="tooltip" data-placement="top" title="" data-original-title="TeamVKRZ">
                                                        🦙
                                                    </span>
                                                <?php endif; ?>
                                                <?php if ($creator_data['user_role']  == "administrator" || $creator_data['user_role'] == "author") : ?>
                                                    <span class="ico" data-toggle="tooltip" data-placement="top" title="" data-original-title="Créateur de Tops">
                                                        🎨
                                                    </span>
                                                <?php endif; ?>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    const topId = "<?php echo $id_top; ?>";
</script>
<?php get_footer(); ?>