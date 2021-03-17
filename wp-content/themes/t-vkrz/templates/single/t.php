<?php
get_header();

// WP
$id_tournament   = get_the_ID();
$list_contenders = array();
$uuiduser        = $_COOKIE["vainkeurz_user_id"];
$next_duel       = array();
$is_next_duel    = true;
$timeline_main   = 1;
$timeline_votes  = 0;
$c_at_same_place = array();
$c_at_same_ratio = array();

// GET
// Vainkeur
if(isset($_GET['v']) && $_GET['v'] != ""){
    $v = $_GET['v'];
}

// Loser
if(isset($_GET['l']) && $_GET['l'] != ""){
    $l = $_GET['l'];
}

// ID ranking
if(isset($_GET['r']) && $_GET['r'] != ""){
    $id_ranking  = $_GET['r'];
}
else{
    $id_ranking = get_user_ranking($uuiduser, $id_tournament);
}

// List losers of T
if(get_field('list_losers_r', $id_ranking)){
    $list_l_r       = get_field('list_losers_r', $id_ranking);
}
else{
    $list_l_r       = array();
}

// List Vainkeurz of T
if(get_field('list_winners_r', $id_ranking)){
    $list_w_r       = get_field('list_winners_r', $id_ranking);
}
else{
    $list_w_r       = array();
}

// Execute vote
if(isset($_GET['v']) && $_GET['v'] != "" && isset($_GET['l']) && $_GET['l'] != ""){
    do_vote($v, $l, $id_ranking);
}

// List contenders
$list_contenders    = get_field('ranking_r', $id_ranking);

// Count contenders
$nb_contenders      = count($list_contenders);
$half_contenders    = $nb_contenders / 2;

// NB votes
$timeline_votes     = get_field('nb_votes_r', $id_ranking);

if($timeline_votes == $nb_contenders-5){
    update_field('timeline_main', 2, $id_ranking);
}

$timeline_main = get_field('timeline_main', $id_ranking);

if($timeline_main == 1){

    $key_c_1 = $nb_contenders - (1 + $timeline_votes);
    $key_c_2 = $nb_contenders - (6 + $timeline_votes);

    array_push($next_duel, $list_contenders[$key_c_1]['id_wp']);
    array_push($next_duel, $list_contenders[$key_c_2]['id_wp']);

}

elseif($timeline_main == 2){

    $timeline_2      = get_field('timeline_2', $id_ranking);

    array_push($next_duel, $list_l_r[$timeline_2 - 1]);
    array_push($next_duel, $list_l_r[$timeline_2]);
}

elseif($timeline_main == 3){

    $nb_loosers      = count($list_l_r) - 1;

    array_push($next_duel, $list_l_r[$nb_loosers]);
    array_push($next_duel, $list_w_r[0]);

}

elseif($timeline_main == 4){

    $timeline_4      = get_field('timeline_4', $id_ranking);

    $nb_winners     = count($list_w_r) - 1;

    array_push($next_duel, $list_w_r[$timeline_4 - 1]);
    array_push($next_duel, $list_w_r[$timeline_4]);

}

elseif($timeline_main == 5){

    $is_same_ratio   = false;
    $is_same_place   = false;

    // On lance des boucles jusqu'à obtenir le tableau "$next_duel" avec deux valeurs
    // On lance autant de boucle que de participant-1
    for($s = 0; $s <= $nb_contenders-1; $s++){

        // Si le tableau "$next_duel" est supérieur ou égal à deux valeurs alors on stop car nous pouvons faire un nouveau duel
        // Sinon on le remet à zéro
        if(count($c_at_same_ratio) >= 2){
            $step_number = $s;
            break;
        }
        else{
            $c_at_same_ratio = array();
        }

        // On boucle sur tous les participant et on stocke leur ID global quand leur place est égal à l'incrémentation
        foreach ($list_contenders as $d => $val){

            if($val['ratio'] == $s){
                array_push($c_at_same_ratio, $val['id_wp']);
            }

        }

    }

    array_filter($c_at_same_ratio);

    if(count($c_at_same_ratio) >= 2){
        $is_same_ratio = true;
        array_push($next_duel, $c_at_same_ratio[0]);
        array_push($next_duel, $c_at_same_ratio[1]);
    }

    if(!$is_same_ratio){
        // On lance des boucles jusqu'à obtenir le tableau "$next_duel" avec deux valeurs
        // On lance autant de boucle que de participant-1
        for($s = 0; $s <= $nb_contenders-1; $s++){

            // Si le tableau "$next_duel" est supérieur ou égal à deux valeurs alors on stop car nous pouvons faire un nouveau duel
            // Sinon on le remet à zéro
            if(count($c_at_same_place) >= 2){
                $step_number = $s;
                break;
            }
            else{
                $c_at_same_place = array();
            }

            // On boucle sur tous les participant et on stocke leur ID global quand leur place est égal à l'incrémentation
            foreach ($list_contenders as $d => $val){

                if($val['place'] == $s){
                    array_push($c_at_same_place, $val['id_wp']);
                }

            }

        }

        array_filter($c_at_same_place);

        if(count($c_at_same_place) >= 2){
            $is_same_place = true;
            array_push($next_duel, $c_at_same_place[0]);
            array_push($next_duel, $c_at_same_place[1]);
        }
    }


    if(!$is_same_ratio && !$is_same_place){
        $is_next_duel = false;
        if(!get_field('done_r', $id_ranking)){
            update_field('done_r', 'done', $id_ranking);
            update_field('done_date_r', date('d/m/Y'), $id_ranking);
        }
    }

}

wp_reset_query();
?>

<?php get_header(); ?>

<?php
if(get_field('cover_t')){
    $illu       = wp_get_attachment_image_src(get_field('cover_t'), 'full');
    $illu_url   = $illu[0];
}
?>
<body>

<pre>
    <?php
        //var_dump($id_ranking);
        //var_dump($list_contenders);
    ?>
</pre>

<div class="main">

    <header class="header">
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="col-sm-4">
                    <div class="logo">
                        <a href="<?php the_permalink(33); ?>">
                            <img src="<?php bloginfo('template_directory'); ?>/assets/img/logo-vainkeurz.png" alt="" class="img-fluid">
                        </a>
                    </div>
                </div>
                <div class="col-sm-8 text-right">
                    <div class="display_users_votes">
                        <a href="<?php the_permalink($id_ranking); ?>" target="_blank" class="cta_2">
                            Voir classement
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <div class="container">
        <div class="tournoi_infos">
            <div class="row align-items-center">
                <div class="col-12">
                    <div class="bloc-titre text-center">
                        <h1>
                            <b>
                                Votes : <?php echo $timeline_votes; ?>
                            </b>
                            <br>
                            <b>
                                Timeline : <?php echo $timeline_main; ?>
                            </b>
                        </h1>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php if($is_next_duel): ?>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="display_battle">
                        <div class="row align-items-center contenders-containers">
                            <div class="col-5 link-contender contender_1">
                                <a href="<?php the_permalink($id_tournament); ?>?r=<?php echo $id_ranking; ?>&v=<?php echo $next_duel[0]; ?>&l=<?php echo $next_duel[1]; ?>"
                                   data-contender-tournament="<?= $id_tournament ?>"
                                   data-contender-chosen="<?= $next_duel[0] ?>"
                                   data-contender-notchosen="<?= $next_duel[1] ?>"
                                   id="c_1">
                                    <?php
                                    echo get_the_post_thumbnail( $next_duel[0], 'full', array( 'class' => 'img-fluid' ) );
                                    ?>
                                    <h2 class="title-contender">
                                        <?php echo get_the_title( $next_duel[0] ); ?> - (<?php echo $next_duel[0]; ?>)
                                    </h2>
                                </a>
                            </div>
                            <div class="col-2">
                                <h4 class="text-center versus">
                                    VS
                                </h4>
                            </div>
                            <div class="col-5 link-contender contender_2">
                                <a href="<?php the_permalink($id_tournament); ?>?r=<?php echo $id_ranking; ?>&v=<?php echo $next_duel[1]; ?>&l=<?php echo $next_duel[0]; ?>"
                                   data-contender-tournament="<?= $id_tournament ?>"
                                   data-contender-chosen="<?= $next_duel[1] ?>"
                                   data-contender-notchosen="<?= $next_duel[0] ?>"
                                   id="c_1">
                                    <?php
                                    echo get_the_post_thumbnail( $next_duel[1], 'full', array( 'class' => 'img-fluid' ) );
                                    ?>
                                    <h2 class="title-contender">
                                        <?php echo get_the_title( $next_duel[1] ); ?> - (<?php echo $next_duel[1]; ?>)
                                    </h2>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php else: ?>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="text-center">
                        <a href="<?php the_permalink($id_ranking); ?>">
                            Votre classement personnel est terminé. <?php echo $id_ranking; ?>
                        </a>
                    </h2>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>

<?php get_footer(); ?>
