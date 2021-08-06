<?php
get_header();
global $champion;
global $champion_id;
$champion_info       = get_userdata($champion_id);
$champion_role       = $champion_info->roles[0];
$uuidchampion        = get_field('uuiduser_user', 'user_'.$champion_id);

if ($uuidchampion != $uuiduser) {
    $user_full_data = get_user_full_data($uuidchampion);
    $list_t_done = $user_full_data[0]['list_user_ranking_done'];
    $nb_user_votes = $user_full_data[0]['nb_user_votes'];
    $info_user_level = get_user_level($uuidchampion, $champion_id, $nb_user_votes);
}
?>
    <!-- BEGIN: Content-->
    <div class="app-content content ">
        <div class="content-wrapper">
            <div class="content-body">

                <div id="user-profile">
                    <div class="row">
                        <div class="col-12">
                            <?php get_template_part('partials/profil'); ?>
                        </div>
                    </div>

                    <section id="profile-info">
                        <div class="row">
                            <div class="col-lg-3 col-12 order-2 order-lg-1">

                                <div class="card card-transaction">
                                    <div class="card-body">
                                        <div class="info-bio">
                                            <h5 class="mb-75 t-rose">Inscription</h5>
                                            <p class="card-text">
                                                <?php if($champion_id == 1): ?>
                                                    1er champion sur VAINKEURZ
                                                <?php else: ?>
                                                    <?php echo $champion_id; ?>ème champion à avoir rejoint le concept VAINKEURZ
                                                <?php endif; ?>
                                            </p>
                                        </div>
                                        <?php if($champion_info->description): ?>
                                            <div class="info-bio mt-2">
                                                <h5 class="mb-75 t-rose">Bio</h5>
                                                <p class="card-text">
                                                    <?php echo $champion_info->description; ?>
                                                </p>
                                            </div>
                                        <?php endif; ?>

                                        <?php if($champion_info->twitch_user || $champion_info->youtube_user || $champion_info->Instagram_user || $champion_info->tiktok_user): ?>
                                            <div class="info-bio mt-2">
                                                <h5 class="mb-75 t-rose">Réseaux</h5>
                                                <div class="row">
                                                    <?php if($champion_info->twitch_user): ?>
                                                        <div class="col-md-6">
                                                            <div class="transaction-item mb-2">
                                                                <a href="<?php echo $champion_info->twitch_user; ?>" target="_blank" >
                                                                    <div class="d-flex align-items-center">
                                                                        <div class="avatar bg-light-primary rounded">
                                                                            <div class="avatar-content picto-rs">
                                                                                <i class="fab fa-twitch"></i>
                                                                            </div>
                                                                        </div>
                                                                        <div class="transaction-info">
                                                                            <h6 class="transaction-title mb-0">
                                                                                Twitch
                                                                            </h6>
                                                                        </div>
                                                                    </div>
                                                                </a>
                                                            </div>
                                                        </div>
                                                    <?php endif; ?>
                                                    <?php if($champion_info->youtube_user): ?>
                                                        <div class="col-md-6">
                                                            <div class="transaction-item mb-2">
                                                                <a href="<?php echo $champion_info->youtube_user; ?>" target="_blank" >
                                                                    <div class="d-flex align-items-center">
                                                                        <div class="avatar bg-light-primary rounded">
                                                                            <div class="avatar-content picto-rs">
                                                                                <i class="fab fa-youtube"></i>
                                                                            </div>
                                                                        </div>
                                                                        <div class="transaction-info">
                                                                            <h6 class="transaction-title mb-0">
                                                                                Youtube
                                                                            </h6>
                                                                        </div>
                                                                    </div>
                                                                </a>
                                                            </div>
                                                        </div>
                                                    <?php endif; ?>
                                                    <?php if($champion_info->Instagram_user): ?>
                                                        <div class="col-md-6">
                                                            <div class="transaction-item mb-2">
                                                                <a href="<?php echo $champion_info->Instagram_user; ?>" target="_blank" >
                                                                    <div class="d-flex align-items-center">
                                                                        <div class="avatar bg-light-primary rounded">
                                                                            <div class="avatar-content picto-rs">
                                                                                <i class="fab fa-instagram"></i>
                                                                            </div>
                                                                        </div>
                                                                        <div class="transaction-info">
                                                                            <h6 class="transaction-title mb-0">
                                                                                Instagram
                                                                            </h6>
                                                                        </div>
                                                                    </div>
                                                                </a>
                                                            </div>
                                                        </div>
                                                    <?php endif; ?>
                                                    <?php if($champion_info->tiktok_user): ?>
                                                        <div class="col-md-6">
                                                            <div class="transaction-item mb-2">
                                                                <a href="<?php echo $champion_info->tiktok_user; ?>" target="_blank" >
                                                                    <div class="d-flex align-items-center">
                                                                        <div class="avatar bg-light-primary rounded">
                                                                            <div class="avatar-content picto-rs">
                                                                                <i class="fab fa-tiktok"></i>
                                                                            </div>
                                                                        </div>
                                                                        <div class="transaction-info">
                                                                            <h6 class="transaction-title mb-0">
                                                                                TikTok
                                                                            </h6>
                                                                        </div>
                                                                    </div>
                                                                </a>
                                                            </div>
                                                        </div>
                                                    <?php endif; ?>
                                                </div>

                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>

                                <div class="card">
                                    <div class="card-header">
                                        <h4 class="card-title">
                                            <span class="ico">⏳</span> Progression
                                        </h4>
                                    </div>
                                    <div class="card-body">
                                        <div class="row avg-sessions pt-50">
                                            <?php
                                            $cat_t = get_terms( array(
                                                'taxonomy'      => 'categorie',
                                                'orderby'       => 'count',
                                                'order'         => 'DESC',
                                                'hide_empty'    => true,
                                            ));
                                            foreach($cat_t as $cat) : ?>
                                                <?php
                                                $tops_in_cat = $cat->count;
                                                $id_cat      = $cat->term_id;
                                                $count_top_done_in_cat = 0;
                                                foreach($list_t_done as $top_done){
                                                    if($id_cat == $top_done['cat_t']){
                                                        $count_top_done_in_cat++;
                                                    }
                                                }
                                                $percent_done_cat = round($count_top_done_in_cat * 100 / $tops_in_cat);
                                                if($percent_done_cat >= 100){
                                                    $classbar = "success";
                                                }
                                                elseif($percent_done_cat < 100 && $percent_done_cat >= 25){
                                                    $classbar = "primary";
                                                }
                                                else{
                                                    $classbar = "warning";
                                                }
                                                ?>
                                                <div class="col-12 mt-1 mb-1">
                                                    <p class="mb-50">
                                                    <span class="ico2">
                                                        <span class="<?php if($cat->term_id == 2){echo 'rotating';} ?>">
                                                            <?php the_field('icone_cat', 'term_'.$cat->term_id); ?>
                                                        </span>
                                                    </span>
                                                        <?php echo $cat->name; ?>
                                                        <small class="infosmall text-<?php echo $classbar; ?>"><?php echo $count_top_done_in_cat; ?> sur <?php echo $tops_in_cat; ?>
                                                        </small>
                                                    </p>
                                                    <div class="progress progress-bar-<?php echo $classbar; ?>" style="height: 6px">
                                                        <div class="progress-bar" role="progressbar" aria-valuenow="<?php echo $percent_done_cat; ?>" aria-valuemin="<?php echo $percent_done_cat; ?>" aria-valuemax="100" style="width: <?php echo $percent_done_cat; ?>%"></div>
                                                    </div>
                                                </div>
                                            <?php endforeach; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-9 col-12 order-1 order-lg-2">
                                <section class="app-user-view">
                                    <div class="row match-height">
                                        <div class="col-sm-4">
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
                                                        <?php echo $info_user_level['level_ico']; ?>
                                                    </span>
                                                    </div>
                                                    <p class="card-text legende">Niveau actuel</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-4 col-6">
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
                                        <div class="col-sm-4 col-6">
                                            <div class="card text-center">
                                                <div class="card-body">
                                                    <div class="mb-1">
                                                        <span class="ico4">🏆</span>
                                                    </div>
                                                    <h2 class="font-weight-bolder">
                                                        <?php echo count($list_t_done); ?>
                                                    </h2>
                                                    <p class="card-text legende">Tops terminés</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </section>
                                <section id="basic-tabs-components">
                                    <div class="tab-content">
                                        <div class="tab-pane active" id="tab2" aria-labelledby="profileIcon-tab" role="tabpanel">
                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="card invoice-list-wrapper">
                                                        <div class="card-datatable table-responsive">
                                                            <table class="invoice-list-table table table-4">
                                                                <thead>
                                                                <tr>
                                                                    <th class="">
                                                                        <span class="t-rose"><?php echo count($list_t_done); ?></span> Tops terminés
                                                                    </th>
                                                                    <th class="text-right">
                                                                        💎
                                                                    </th>
                                                                    <th class="">
                                                                        🥇🥈🥉
                                                                    </th>
                                                                    <th>
                                                                        👀
                                                                    </th>
                                                                </tr>
                                                                </thead>
                                                                <tbody>
                                                                <?php
                                                                foreach($list_t_done as $r_user) : ?>
                                                                    <?php if($r_user['nb_votes'] > 0): ?>
                                                                        <tr id="top-<?php echo $r_user['id_ranking']; ?>">
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
                                                                            <td class="text-right">
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
                                                                            <td>
                                                                                <div class="d-flex align-items-center col-actions">
                                                                                    <?php
                                                                                    if($r_user['typetop'] == "top3"){
                                                                                        $wording = "Voir le Top 3";
                                                                                    }
                                                                                    else{
                                                                                        $wording = "Voir le Top complet";
                                                                                    }
                                                                                    ?>
                                                                                    <a class="mr-1" href="<?php the_permalink($r_user['id_ranking']); ?>" data-toggle="tooltip" data-placement="top" title="" data-original-title="<?php echo $wording; ?>">
                                                                                        <span class="ico">
                                                                                            🏆
                                                                                        </span>
                                                                                    </a>
                                                                                    <a class="mr-1" href="<?php the_permalink(get_page_by_path('elo')); ?>?id_top=<?php echo $r_user['id_tournoi']; ?>" data-toggle="tooltip" data-placement="top" title="" data-original-title="Voir le classement mondial">
                                                                                        <span class="ico">
                                                                                            🌍
                                                                                        </span>
                                                                                    </a>
                                                                                </div>
                                                                            </td>
                                                                        </tr>
                                                                    <?php endif; ?>
                                                                <?php endforeach; ?>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </section>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </div>

<?php get_footer(); ?>