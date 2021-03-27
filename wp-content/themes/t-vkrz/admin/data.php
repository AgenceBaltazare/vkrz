<?php
/*
    Template Name: Data
*/
?>
<?php get_header(); ?>
<?php
    $nb_ranking_done = get_global_data('nb-ranking-done', false);
    $nb_ranking      = get_global_data('nb-ranking', false);
    $nb_users        = get_global_data('nb-user', false);
    $nb_votes        = get_global_data('nb-vote', false);
    $users_votes     = get_vote_data('list-user-vote', false);
?>
<!-- BEGIN: Content-->
<div class="app-content content data-page">
    <div class="content-overlay"></div>
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-md-9 col-12 mb-2">
                <div class="row breadcrumbs-top">
                    <div class="col-12">
                        <h2 class="content-header-title float-left mb-0">🍧 Overview</h2>
                    </div>
                </div>
            </div>
        </div>
        <div class="content-body">
            <!-- Statistics card section -->
            <section id="statistics-card">
                <!-- Miscellaneous Charts -->
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
                                                    <?php echo get_global_data('nb-tournoi', false); ?>
                                                </h4>
                                                <p class="card-text font-small-3 mb-0">Tournois</p>
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
                                <p class="card-text">Votes moyen</p>
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
                                    <?php echo round(get_vote_data('more-moy') * 100 / $nb_users); ?>%
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
                                    <?php echo round(get_vote_data('less-ten') * 100 / $nb_users); ?>%
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
                                    <?php echo get_vote_data('best-ninja'); ?>
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
                                            <th>Titre du tournoi</th>
                                            <th class="text-center">Contenders</th>
                                            <th class="text-center">Votes</th>
                                            <th class="text-center">Finition</th>
                                            <th class="text-center">Info vote</th>
                                            <th class="text-center">Votes</th>
                                            <th>ELO</th>
                                            <th>Classements</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php $tournois = new WP_Query(array('post_type' => 'tournoi', 'orderby' => 'date', 'posts_per_page' => '-1')); ?>
                                        <?php while ($tournois->have_posts()) : $tournois->the_post(); ?>
                                            <?php
                                                $id_tournament = get_the_ID();
                                            ?>
                                            <tr>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <div class="avatar rounded">
                                                            <div class="avatar-content mr-2">
                                                                <?php if (has_post_thumbnail()) : ?>
                                                                    <?php the_post_thumbnail('thumbnail', array('class'=>'img-fluid')); ?>
                                                                <?php endif; ?>
                                                            </div>
                                                        </div>
                                                        <div>
                                                            <div class="font-weight-bolder">
                                                                <a href="<?php the_permalink(); ?>">
                                                                    <?php the_title(); ?>
                                                                </a>
                                                            </div>
                                                            <div class="font-small-2 text-muted">
                                                                <?php the_field('question_t'); ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="text-nowrap">
                                                    <div class="d-flex flex-column text-center">
                                                        <span class="font-weight-bolder mb-25">
                                                            <?php
                                                            $nb_contenders = get_numbers_of_contenders($id_tournament);
                                                            echo $nb_contenders;
                                                            ?>
                                                        </span>
                                                    </div>
                                                </td>
                                                <td class="text-nowrap">
                                                    <div class="d-flex flex-column text-center">
                                                        <span class="font-weight-bolder mb-25">
                                                            <?php echo get_numbers_of_ranking($id_tournament); ?>
                                                        </span>
                                                    </div>
                                                </td>
                                                <td class="text-nowrap">
                                                    <div class="d-flex flex-column text-center">
                                                        <span class="font-weight-bolder mb-25">
                                                            <?php
                                                            $finalisation = round(get_numbers_of_ranking_done($id_tournament) * 100 /  get_numbers_of_ranking($id_tournament));
                                                            if($finalisation < 25){
                                                                $color = "danger";
                                                            }
                                                            elseif(25 < $finalisation && $finalisation < 75){
                                                                $color = "warning";
                                                            }
                                                            else{
                                                                $color = "success";
                                                            }
                                                            ?>
                                                            <span class="badge badge-pill  badge-light-<?php echo $color; ?>">
                                                                <?php echo $finalisation; ?>%
                                                            </span>
                                                        </span>
                                                    </div>
                                                </td>
                                                <td class="text-center">
                                                    <?php
                                                        $min_votes = round(($nb_contenders - 5) * 2 + 6);
                                                        if($min_votes <= 1){
                                                            $min_votes = 1;
                                                        }
                                                        $max_votes = round($min_votes * 2);
                                                        $moy_votes = round($min_votes * 1.5);
                                                    ?>
                                                    <?php echo $min_votes; ?> - <?php echo $max_votes; ?> - <?php echo $moy_votes; ?>
                                                </td>
                                                <td class="text-center">
                                                    <b><?php echo all_votes_in_tournament($id_tournament); ?></b>
                                                    -
                                                    <?php echo round(all_moy_votes_in_tournament($id_tournament) / get_numbers_of_ranking_done($id_tournament)); ?>
                                                </td>
                                                <td>
                                                    <a href="<?php the_permalink(get_page_by_path('elo')); ?>?id_tournoi=<?php echo $id_tournament; ?>" target="_blank">
                                                        <div class="avatar-group">
                                                            <?php $contenders_tournament = new WP_Query(array('post_type' => 'contender', 'meta_key' => 'ELO_c', 'orderby' => 'meta_value', 'posts_per_page' => '5', 'meta_query' => array(
                                                                array(
                                                                    'key'     => 'id_tournoi_c',
                                                                    'value'   => $id_tournament,
                                                                    'compare' => '=',
                                                                )
                                                            )));?>
                                                            <?php $i=1; while ($contenders_tournament->have_posts()) : $contenders_tournament->the_post();?>
                                                                <div data-toggle="tooltip" data-popup="tooltip-custom" data-placement="bottom" data-original-title="<?php the_title(); ?>" class="avatar pull-up">
                                                                    <?php $illu = get_the_post_thumbnail_url(get_the_ID(), 'thumbnail'); ?>
                                                                    <img src="<?php echo $illu; ?>" alt="Avatar" width="33" height="33">
                                                                </div>
                                                            <?php $i++; endwhile; wp_reset_query(); ?>
                                                        </div>
                                                    </a>
                                                </td>
                                                <td>
                                                    <a href="<?php the_permalink(get_page_by_path('datas/list-ranking')); ?>?id_tournoi=<?php echo $id_tournament; ?>">
                                                        <i class="fal fa-user-ninja"></i><i class="fal fa-trophy-alt"></i>
                                                    </a>
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
