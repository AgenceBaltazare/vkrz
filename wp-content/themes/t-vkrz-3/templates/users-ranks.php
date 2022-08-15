<?php
/*
    Template Name: Users Ranks
*/
if (isset($_GET['id_top'])) {
    $id_top  = $_GET['id_top'];
} else {
    header('Location: ' . get_bloginfo('url'));
}
get_header();
global $id_vainkeur;
global $count_toplist;
global $vainkeur_data_selected;
$top_datas = get_top_data($id_top);
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
$id_resume            = get_resume_id($id_top);
$list_toplist         = json_decode(get_field('all_toplist_resume', $id_resume));
$list_toplist         = array_reverse($list_toplist);
$count_toplist        = count($list_toplist);
?>
<div class="app-content content">
    <div class="content-overlay"></div>
    <div class="content-wrapper">
        <div class="content-body mt-2">

            <div class="intro-mobile">
                <div class="tournament-heading text-center">
                    <h3 class="mb-0 t-titre-tournoi">
                        Liste de tous les Tops <?php echo $top_infos['top_number']; ?> <span class="ico text-center va va-trophy va-lg"></span> <?php echo $top_infos['top_title']; ?>
                    </h3>
                    <h4 class="mb-0">
                        <?php echo $top_infos['top_question']; ?>
                    </h4>
                </div>
            </div>

            <div class="classement users-ranks">
                <div class="row">
                    <div class="col-md-8">
                        <section id="profile-info">
                            <!-- CALCULATE RESEMBALNCE… -->
                            <div class="card text-center calc-resemblance" data-idtop="<?php echo $id_top; ?>">
                                <div class="card-body">
                                    <div class="mb-50">
                                        <span class="ico4 va va-duo va va-z-50"></span>
                                    </div>
                                    <h2 class="font-weight-bolder mb-1 calc-resemblance-h1">
                                        Récupération des <?php echo $count_toplist; ?> TopList…
                                    </h2>
                                    <h6 class="card-subtitle text-muted">
                                        Notre algo maison va comparer toutes les TopList pour afficher le % de ressemblance avec la tienne.
                                    </h6>
                                </div>
                                <div class="bar"></div>
                            </div>

                            <div class="card invoice-list-wrapper table-card-container d-none">
                                <div class="card-datatable table-responsive">
                                    <table class="invoice-list-table table table-listuserranks">
                                        <thead>
                                            <tr>
                                                <th>
                                                    <span class="text-muted">
                                                        Vainkeur
                                                    </span>
                                                </th>

                                                <th>
                                                    <span class="text-muted">
                                                        Podium
                                                    </span>
                                                </th>

                                                <th class="text-center shorted">
                                                    <span class="text-muted">Ressemblance <span class="va va-updown va-z-15"></span></span>
                                                </th>

                                                <th class="text-center">
                                                    <span class="text-muted">
                                                        Action
                                                    </span>
                                                </th>


                                                <th class="text-right">
                                                    <span class="text-muted">
                                                        Guetter
                                                    </span>
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </section>
                    </div>
                    <div class="col-md-4">

                        <div class="related">

                            <div class="infoelo">
                                <div class="row">
                                    <div class="col-6">
                                        <div class="card text-center">
                                            <div class="card-body">
                                                <div class="mb-1">
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
                                    <div class="col-6">
                                        <div class="card text-center">
                                            <div class="card-body">
                                                <div class="mb-1">
                                                    <span class="ico4 va-trophy va va-md"></span>
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
                                </div>
                            </div>

                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title">
                                        <span class="ico va va-speech-balloon va-lg"></span> <?php echo $top_datas['nb_comments']; ?>
                                        <?php if ($top_datas['nb_comments'] <= 1) : ?>
                                            Commentaire
                                        <?php else : ?>
                                            Commentaires
                                        <?php endif; ?>
                                    </h4>
                                    <h6 class="card-subtitle text-muted mb-1">
                                        Tout ce qui te passe par la tête à propos de ce Top mérite d'être partagé avec les autres Vainkeurs.
                                    </h6>
                                    <a href="<?php echo get_the_permalink(get_page_by_path('discuz')) . '?id_top=' . $id_top; ?>" class="btn btn-outline-primary waves-effect">
                                        Lire & poster
                                    </a>
                                </div>
                            </div>

                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title">
                                        <span class="va va-globe va-lg"></span> TopList mondiale
                                    </h4>
                                    <h6 class="card-subtitle text-muted mb-1">
                                        Découvre le classement complet généré par les <?php echo $top_datas['nb_votes']; ?> votes !
                                    </h6>
                                    <a href="<?php the_permalink(get_page_by_path('elo')); ?>?id_top=<?php echo $id_top; ?>" class="btn btn-outline-primary waves-effect">
                                        Voir la TopList mondiale
                                    </a>
                                </div>
                            </div>
                            <?php if (!get_top_done_by_current_vainkeur($id_top, $id_vainkeur, $list_user_tops)) : ?>
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="card-title">
                                            <span class="ico va va-victory-hand va-lg"></span> A toi de jouer
                                        </h4>
                                        <h6 class="card-subtitle text-muted mb-1">
                                            Toi aussi fais ta TopList afin de faire bouger les positions !
                                        </h6>
                                        <a href="<?php the_permalink($id_top); ?>" class="btn btn-outline-primary waves-effect">
                                            Faire ma TopList
                                        </a>
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
<?php get_footer(); ?>