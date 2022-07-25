<?php
/*
    Template Name: Tirage
*/
?>
<?php get_header(); ?>
<?php
if (isset($_GET['id_top']) && $_GET['id_top'] != "") {
    $id_top = $_GET['id_top'];
}
$user = wp_get_current_user();
$roles = (array) $user->roles;
?>
<div class="app-content content ">
    <div class="content-wrapper">
        <div class="content-body">
            <div class="blog-detail-wrapper">
                <div class="row">
                    <?php if (is_user_logged_in() && $roles[0] == "administrator") : ?>
                        <div class="col-12">

                            <h1 class="text-center mt-2">
                                Tirage au sort des gagnants 🍀
                            </h1>

                            <div class="row">
                                <div class="col-md-8 offset-md-2">
                                    <div class="card mt-2">
                                        <div class="card-body">
                                            <form action="#" method="get">
                                                <div class="row">
                                                    <div class="col-sm-6">
                                                        <input class="form-control" type="number" name="id_top" placeholder="ID du Top" value="<?php echo $id_top; ?>">
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <input type="submit" value="valider" class="btn btn-primary waves-effect waves-float waves-light">
                                                    </div>
                                                    <?php if (isset($_GET['id_top']) && $_GET['id_top'] != "") : ?>
                                                        <div class="col-sm-2">
                                                            <a href="<?php the_permalink(292414); ?>/" type="button" class="btn btn-outline-danger waves-effect">X</a>
                                                        </div>
                                                    <?php endif; ?>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <?php if ($id_top) : ?>
                                <?php
                                $list_players   = array();
                                $players_of_top = new WP_Query(array(
                                    'ignore_sticky_posts'        => true,
                                    'update_post_meta_cache'    => false,
                                    'no_found_rows'                => true,
                                    'post_type'                    => 'player',
                                    'orderby'                    => 'date',
                                    'order'                        => 'DESC',
                                    'posts_per_page'            => -1,
                                    'meta_query' => array(
                                        array(
                                            'key'       => 'id_t_p',
                                            'value'     => $id_top,
                                            'compare'   => '=',
                                        )
                                    )
                                ));
                                while ($players_of_top->have_posts()) : $players_of_top->the_post();

                                    array_push($list_players, get_the_ID());

                                endwhile;
                                $list_players_unique = array_unique($list_players);
                                $gagnant             = array_rand($list_players_unique);
                                $realgagnant         = $list_players_unique[$gagnant];
                                update_vainkeur_badge($id_vainkeur_gagnant, "Chanceux");
                                $mail_gagnant = get_field('email_player_p', $realgagnant);
                                update_field('gagnant_idplayer_t_sponso', $realgagnant, $id_top);
                                update_field('date_du_tas_t_sponso', date('Y-m-d H:i:s'), $id_top);
                                update_field('gagnant_email_t_sponso', $mail_gagnant, $id_top);
                                ?>

                                <section class="app-user-view mt-2">
                                    <div class="row match-height">
                                        <div class="col-sm-4">
                                            <div class="card">
                                                <div class="card-body text-center">
                                                    <h2>
                                                        <span class="t-rose">Top</span>
                                                        <br>
                                                        <?php echo get_the_title($id_top); ?>
                                                    </h2>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <div class="card text-center">
                                                <div class="card-body">
                                                    <div class="user-level">
                                                        <span class="icomax">
                                                            <?php echo count($list_players_unique); ?>
                                                        </span>
                                                    </div>
                                                    <p class="card-text legende">participations uniques</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="card">
                                                <div class="card-body text-center">
                                                    <h2 class="mt-1">
                                                        <span class="t-rose">Gagnant</span>
                                                        <br>
                                                        <?php echo $mail_gagnant; ?>
                                                    </h2>
                                                    <p class="card-text legende">
                                                        <?php
                                                        $user_top3 = get_user_ranking(get_field('id_r_p', $realgagnant));
                                                        $l = 1;
                                                        foreach ($user_top3 as $contender) : ?>
                                                    <div data-toggle="tooltip" data-popup="tooltip-custom" data-placement="bottom" data-original-title="<?php echo get_the_title($contender); ?>" class="avatartop3 avatar pull-up">
                                                        <?php $illu = get_the_post_thumbnail_url($contender, 'thumbnail'); ?>
                                                        <img src="<?php echo $illu; ?>" alt="Avatar">
                                                    </div>
                                                <?php $l++;
                                                            if ($l == 4) break;
                                                        endforeach; ?>
                                                </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </section>
                            <?php endif; ?>
                        </div>
                    <?php else : ?>
                        <div class="col">
                            <h2 class="text-center">
                                Tu dois faire partie de la TEAM <span class="va-llama va va-lg"></span> pour faire un tirage au sort !
                            </h2>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php get_footer(); ?>