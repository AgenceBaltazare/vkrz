<?php
/*
    Template Name: Classement
*/
global $uuid_vainkeur;
global $id_vainkeur;
if (isset($_GET['id_top']) && !empty($_GET['id_top'])) {
    $id_top  = $_GET['id_top'];
    if (get_post_status($id_top) == "draft") {
        header('Location: ' . get_bloginfo('url'));
    }
} else {
    header('Location: ' . get_bloginfo('url'));
}
global $sponso;
$sponso = "";
if (isset($_GET['sponso']) && $_GET['sponso'] != "") {
    $sponso = $_GET['sponso'];
}
get_header();
global $top_infos;
if ($id_vainkeur) {
    if (is_user_logged_in() && env() != "local") {
        if (false === ($user_tops = get_transient('user_' . $user_id . '_get_user_tops'))) {
            $user_tops = get_user_tops($id_vainkeur);
            set_transient('user_' . $user_id . '_get_user_tops', $user_tops, DAY_IN_SECONDS);
        } else {
            $user_tops = get_transient('user_' . $user_id . '_get_user_tops');
        }
    } else {
        $user_tops  = get_user_tops($id_vainkeur);
    }
    $list_user_tops         = $user_tops['list_user_tops_done_ids'];
    $list_user_tops_begin   = $user_tops['list_user_tops_begin_ids'];
} else {
    $user_tops            = array();
    $list_user_tops       = array();
    $list_user_tops_begin = array();
}
$top_datas            = get_top_data($id_top);
$contenders_ranking   = get_contenders_ranking($id_top);
?>
<div class="page-template-elo-mondial app-content content cover" style="background: url(<?php echo $top_infos['top_cover']; ?>) center center no-repeat">
    <div class="content-overlay"></div>
    <div class="content-wrapper">
        <div class="content-body mt-2">

            <div class="intro-mobile">
                <div class="tournament-heading text-center">
                    <h3 class="mb-0 t-titre-tournoi">
                        Top <?php echo $top_infos['top_number']; ?> <span class="ico text-center va va-trophy va-lg"></span> <?php echo $top_infos['top_title']; ?>
                    </h3>
                    <h4 class="mb-0">
                        <?php echo $top_infos['top_question']; ?>
                    </h4>
                </div>
            </div>

            <div class="classement">

                <div class="row">

                    <div class="col-md-10">

                        <?php if (get_field('limitation_elo_m_t', $id_top)) : ?>
                            <h2>Liste des <?php the_field('limitation_elo_m_t', $id_top); ?> premiers du classement mondial</h2>
                        <?php endif; ?>

                        <div class="list-classement">

                            <?php
                            $i = 1;
                            if (get_field('limitation_elo_m_t', $id_top)) {
                                $limit = get_field('limitation_elo_m_t', $id_top);
                            } else {
                                $limit = 1000000;
                            }
                            foreach ($contenders_ranking as $contender) :
                                if ($i <= $limit) :
                            ?>
                                    <?php
                                    if ($i >= 4) {
                                        $d = 3;
                                    } else {
                                        $d = $i - 1;
                                    }
                                    ?>
                                    <?php if ($i == 6 && $top_infos['top_number'] > 10) : ?>
                                        <div class="break"></div>
                                    <?php endif; ?>
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
                                                        <span class="ico va va-medal-1 va-lg"></span>
                                                    <?php elseif ($i == 2) : ?>
                                                        <span class="ico va va-medal-2 va-lg"></span>
                                                    <?php elseif ($i == 3) : ?>
                                                        <span class="ico va va-medal-3 va-lg"></span>
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
                                    </div>
                            <?php $i++;
                                endif;
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
                                                    <a href="<?php the_permalink(get_page_by_path('liste-des-tops')); ?>?id_top=<?php echo $id_top; ?>" data-toggle="tooltip" data-placement="top" title="" data-original-title="Voir les <?php echo $top_datas['nb_completed_top']; ?> Tops">
                                                        <span class="va va-eyes va-lg"></span>
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="ico-stats">
                                                <span class="ico4 va va-trophy va-md"></span>
                                            </div>
                                            <h2 class="font-weight-bolder">
                                                <?php echo $top_datas['nb_completed_top']; ?>
                                            </h2>
                                            <p class="card-text legende">
                                                TopList
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6 col-sm-12">
                                    <div class="card text-center">
                                        <div class="card-body">
                                            <div class="ico-stats">
                                                <span class="ico4 va-high-voltage va va-md"></span>
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
                                            <div class="ico-stats">
                                                <span class="ico4 va va-speech-balloon va-md"></span>
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
                                            <a href="<?php echo get_the_permalink(get_page_by_path('discuz')) . '?id_top=' . $id_top; ?>" class="btn btn-outline-primary waves-effect">
                                                Commenter
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6 col-sm-12">
                                    <div class="card text-center">
                                        <div class="card-body">
                                            <div class="ico-stats">
                                                <span class="ico4 va va-birthday-cake va-md"></span>
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
                                                par <a href="<?php echo $creator_data['creator_url']; ?>"><?php echo $creator_data['pseudo']; ?></a>
                                                <span class="ico" data-toggle="tooltip" data-placement="top" title="" data-original-title="Niveau">
                                                    <?php echo $creator_data['level']; ?>
                                                </span>
                                                <?php if ($creator_data['user_role']  == "administrator") : ?>
                                                    <span class="ico va va-vkrzteam va-lg" data-toggle="tooltip" data-placement="top" title="" data-original-title="TeamVKRZ">
                                                    </span>
                                                <?php endif; ?>
                                                <?php if ($creator_data['user_role']  == "administrator" || $creator_data['user_role'] == "author") : ?>
                                                    <span class="ico va va-man-singer va-lg" data-toggle="tooltip" data-placement="top" title="" data-original-title="Créateur de Tops">
                                                    </span>
                                                <?php endif; ?>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <?php if (!get_top_done_by_current_vainkeur($id_top, $id_vainkeur, $list_user_tops)) : ?>
                                    <div class="col-12">
                                        <div class="card">
                                            <div class="card-body">
                                                <h4 class="card-title">
                                                    <span class="ico va va-victory-hand va-lg"></span> A toi de jouer
                                                </h4>
                                                <h6 class="card-subtitle text-muted mb-1 text-center">
                                                    Toi aussi fais ta TopList afin de faire bouger les positions !
                                                </h6>
                                                <a href="<?php the_permalink($id_top); ?>" class="btn btn-outline-primary waves-effect">
                                                    Faire ma TopList
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                <?php endif; ?>
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