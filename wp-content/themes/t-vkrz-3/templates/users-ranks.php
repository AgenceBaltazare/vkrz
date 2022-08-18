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
                            <div class="card text-center calc-resemblance card-voile" data-idtop="<?php echo $id_top; ?>" data-topurl="<?php echo get_permalink($id_top) ?>">
                                <div class="voile-gif" style="background-image: url(<?php bloginfo('template_directory'); ?>/assets/images/gif/wait-<?php echo rand(1, 7); ?>.gif)"></div>
                                <div class="card-body">
                                    <div class="content-card">
                                        <div class="loader-block">
                                            <div class="loader loader--style1 w-100 mx-auto text-center" title="0">
                                                <svg version="1.1" id="loader-1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="40px" height="40px" viewBox="0 0 40 40" enable-background="new 0 0 40 40" xml:space="preserve">
                                                    <path opacity="0.2" fill="#000" d="M20.201,5.169c-8.254,0-14.946,6.692-14.946,14.946c0,8.255,6.692,14.946,14.946,14.946s14.946-6.691,14.946-14.946C35.146,11.861,28.455,5.169,20.201,5.169z M20.201,31.749c-6.425,0-11.634-5.208-11.634-11.634c0-6.425,5.209-11.634,11.634-11.634c6.425,0,11.633,5.209,11.633,11.634C31.834,26.541,26.626,31.749,20.201,31.749z" />
                                                    <path fill="#000" d="M26.013,10.047l1.654-2.866c-2.198-1.272-4.743-2.012-7.466-2.012h0v3.312h0C22.32,8.481,24.301,9.057,26.013,10.047z">
                                                        <animateTransform attributeType="xml" attributeName="transform" type="rotate" from="0 20 20" to="360 20 20" dur="0.5s" repeatCount="indefinite" />
                                                    </path>
                                                </svg>
                                            </div>
                                        </div>
                                        <h2 class="font-weight-bolder mb-1 mt-1">
                                            <small>Récupération des </small> <br>
                                            <span class="t-violet"><?php echo $count_toplist; ?></span> TopList
                                        </h2>
                                        <?php if (get_top_done_by_current_vainkeur($id_top, $id_vainkeur, $list_user_tops)) : ?>
                                            <h6 class="card-subtitle text-muted">
                                                Notre algo maison va comparer toutes les TopList pour afficher le % de ressemblance avec la tienne.
                                            </h6>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="bar">
                                    <span class="calc-resemblance-h1">
                                        0%
                                    </span>
                                </div>
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