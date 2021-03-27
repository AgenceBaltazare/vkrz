<?php
/*
    Template Name: Data - List ranking
*/
?>
<?php get_header(); ?>
<?php
$id_tournament     = $_GET['id_tournoi'];
$nb_ranking_done   = get_global_data('nb-ranking-done', $id_tournament);
$nb_ranking        = get_global_data('nb-ranking', $id_tournament);
$nb_users          = get_global_data('nb-user', $id_tournament);
$nb_votes          = get_global_data('nb-vote', $id_tournament);
$users_votes       = get_vote_data('list-user-vote', $id_tournament);
?>
<!-- BEGIN: Content-->
<div class="app-content content data-page">
    <div class="content-overlay"></div>
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-md-9 col-12 mb-2">
                <div class="row breadcrumbs-top">
                    <div class="col-12">
                        <h2 class="content-header-title float-left mb-0">🍭 <?php echo get_the_title($id_tournament); ?> - <?php the_field('question_t', $id_tournament); ?></h2>
                        <p></p>
                    </div>
                </div>
            </div>
        </div>
        <div class="content-body">
            <!-- Statistics card section -->
            <section id="statistics-card">
                <div class="row match-height">
                    <div class="col-lg-12 col-12">
                        <div class="card card-statistics">
                            <div class="card-body statistics-body">
                                <div class="row">
                                    <div class="col-md-3 col-sm-6 col-12 mb-2 mb-md-0">
                                        <div class="media">
                                            <div class="avatar bg-light-primary mr-2">
                                                <div class="avatar-content">
                                                    <i class="fal fa-swords"></i>
                                                </div>
                                            </div>
                                            <div class="media-body my-auto">
                                                <h4 class="font-weight-bolder mb-0">
                                                    <?php echo get_the_date('d/m/Y'); ?>
                                                </h4>
                                                <p class="card-text font-small-3 mb-0">Créé le</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-sm-6 col-12 mb-2 mb-md-0">
                                        <div class="media">
                                            <div class="avatar bg-light-info mr-2">
                                                <div class="avatar-content">
                                                    <i class="fal fa-user-ninja"></i>
                                                </div>
                                            </div>
                                            <div class="media-body my-auto">
                                                <h4 class="font-weight-bolder mb-0">
                                                    <?php echo $nb_users; ?>
                                                </h4>
                                                <p class="card-text font-small-3 mb-0">
                                                    Ninjas
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-sm-6 col-12 mb-2 mb-sm-0">
                                        <div class="media">
                                            <div class="avatar bg-light-info mr-2">
                                                <div class="avatar-content">
                                                    <i class="far fa-fire-alt"></i>
                                                </div>
                                            </div>
                                            <div class="media-body my-auto">
                                                <h4 class="font-weight-bolder mb-0">
                                                    <?php echo $nb_votes; ?>
                                                </h4>
                                                <p class="card-text font-small-3 mb-0">
                                                    Votes
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-sm-6 col-12">
                                        <div class="media">
                                            <div class="avatar bg-light-info mr-2">
                                                <div class="avatar-content">
                                                    <i class="fal fa-trophy-alt"></i>
                                                </div>
                                            </div>
                                            <div class="media-body my-auto">
                                                <h4 class="font-weight-bolder mb-0">
                                                    <?php echo $nb_ranking; ?>
                                                </h4>
                                                <p class="card-text font-small-3 mb-0">
                                                    Classements
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-3 col-sm-6 col-12">
                        <div class="card">
                            <div class="card-header">
                                <div>
                                    <h2 class="font-weight-bolder mb-0">
                                        <?php echo $nb_ranking; ?>
                                    </h2>
                                    <p class="card-text">Classements</p>
                                </div>
                                <div class="avatar bg-light-info p-50 m-0">
                                    <div class="avatar-content">
                                        <i class="fal fa-trophy-alt"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-6 col-12">
                        <div class="card">
                            <div class="card-header">
                                <div>
                                    <h2 class="font-weight-bolder mb-0">
                                        <?php echo $nb_ranking_done; ?>
                                    </h2>
                                    <p class="card-text">
                                        Terminés
                                    </p>
                                </div>
                                <div class="avatar bg-light-success p-50 m-0">
                                    <div class="avatar-content">
                                        <i class="fal fa-check"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-6 col-12">
                        <div class="card">
                            <div class="card-header">
                                <div>
                                    <h2 class="font-weight-bolder mb-0">
                                        <?php
                                        echo $nb_ranking - $nb_ranking_done;
                                        ?>
                                    </h2>
                                    <p class="card-text">Abandonnés</p>
                                </div>
                                <div class="avatar bg-light-danger p-50 m-0">
                                    <div class="avatar-content">
                                        <i class="fal fa-ban"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-6 col-12">
                        <div class="card">
                            <div class="card-header">
                                <div>
                                    <h2 class="font-weight-bolder mb-0">
                                        <?php echo round($nb_ranking_done * 100 / $nb_ranking); ?>%
                                    </h2>
                                    <p class="card-text">Finalisation</p>
                                </div>
                                <div class="avatar bg-light-warning p-50 m-0">
                                    <div class="avatar-content">
                                        <i class="fal fa-percentage"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-3">
                        <div class="card text-center">
                            <div class="card-body">
                                <div class="avatar bg-light-info p-50 mb-1">
                                    <div class="avatar-content">
                                        <i class="far fa-fire-alt"></i>
                                    </div>
                                </div>
                                <h2 class="font-weight-bolder">
                                    <?php echo round($nb_votes / $nb_users); ?>
                                </h2>
                                <p class="card-text">Votes en moyenne</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card text-center">
                            <div class="card-body">
                                <div class="avatar bg-light-info p-50 mb-1">
                                    <div class="avatar-content">
                                        <i class="far fa-fire-alt"></i>
                                    </div>
                                </div>
                                <h2 class="font-weight-bolder">
                                    <?php echo round(get_vote_data('more-moy', $id_tournament) * 100 / $nb_users); ?>%
                                </h2>
                                <p class="card-text">+ moyenne</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card text-center">
                            <div class="card-body">
                                <div class="avatar bg-light-warning p-50 mb-1">
                                    <div class="avatar-content">
                                        <i class="fal fa-user-ninja"></i>
                                    </div>
                                </div>
                                <h2 class="font-weight-bolder">
                                    <?php echo round(get_vote_data('less-ten', $id_tournament) * 100 / $nb_users); ?>%
                                </h2>
                                <p class="card-text">< 15 votes </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card text-center">
                            <div class="card-body">
                                <div class="avatar bg-light-success p-50 mb-1">
                                    <div class="avatar-content">
                                        <i class="fas fa-user-ninja"></i>
                                    </div>
                                </div>
                                <h2 class="font-weight-bolder">
                                    <?php echo get_vote_data('best-ninja', $id_tournament); ?>
                                </h2>
                                <p class="card-text">
                                    Meilleur
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body p-0">
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                        <tr>
                                            <th>Ninja</th>
                                            <th class="text-center">Date</th>
                                            <th class="text-center">Votes</th>
                                            <th>Classement</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                        $ranking_tournament_done = new WP_Query(
                                            array(
                                                'post_type'      => 'classement',
                                                'posts_per_page' => -1,
                                                'meta_query'     => array(
                                                    'relation' => 'AND',
                                                    array(
                                                        'key'     => 'id_tournoi_r',
                                                        'value'   => $id_tournament,
                                                        'compare' => '=',
                                                    ),
                                                    array(
                                                        'key' => 'done_r',
                                                        'value' => 'done',
                                                        'compare' => '=',
                                                    ),
                                                )
                                            )
                                        );
                                        ?>
                                        <?php while ($ranking_tournament_done->have_posts()) : $ranking_tournament_done->the_post(); ?>
                                            <tr>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <div>
                                                            <div class="font-weight-bolder">
                                                                <?php the_field('uuid_user_r'); ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="text-center">
                                                    <?php the_field('done_date_r'); ?>
                                                </td>
                                                <td class="text-nowrap">
                                                    <div class="d-flex flex-column text-center">
                                                        <span class="font-weight-bolder mb-25">
                                                            <?php the_field('nb_votes_r'); ?>
                                                        </span>
                                                    </div>
                                                </td>
                                                <td class="text-center">
                                                    <div class="avatar-group">
                                                        <?php
                                                        $user_ranking = get_user_ranking(get_the_ID());
                                                        foreach($user_ranking as $c => $p) : ?>
                                                            <div data-toggle="tooltip" data-popup="tooltip-custom" data-placement="bottom" data-original-title="<?php echo get_the_title($c); ?>" class="avatar pull-up">
                                                                <?php $illu = get_the_post_thumbnail_url( $c, 'thumbnail' ); ?>
                                                                <img src="<?php echo $illu; ?>" alt="Avatar" width="33" height="33">
                                                            </div>
                                                        <?php endforeach; ?>
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php endwhile; ?>
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

