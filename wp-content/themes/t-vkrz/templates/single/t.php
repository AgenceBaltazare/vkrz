<?php
get_header();

/* Variables */
$id_tournament   = get_the_ID();
$list_contenders = array();
$c_at_same_place = array();
$uuiduser        = $_COOKIE["vainkeurz_user_id"];
$already_sup_to     = array();
$already_inf_to     = array();
$next_duel       = array();
$sum_vote        = 0;
$key_winner     = 0;
$key_loser     = 0;
$new_place       = 0;
$is_next_duel    = true;
$timeline_1      = 0;
$timeline_2      = 0;

// Vainkeur
if(isset($_GET['v']) && $_GET['v'] != ""){
    $v              = $_GET['v'];
}

// Perdant
if(isset($_GET['l']) && $_GET['l'] != ""){
    $l              = $_GET['l'];
}

// ID ranking
if(isset($_GET['r']) && $_GET['r'] != ""){
    $id_ranking  = $_GET['r'];
}
else{
    $id_ranking = get_user_ranking($uuiduser, $id_tournament);
}

// List contenders
$list_contenders    = get_field('ranking_r', $id_ranking);



if(get_field('list_losers_r', $id_ranking)){
    $list_l_r       = get_field('list_losers_r', $id_ranking);
}
else{
    $list_l_r       = array();
}
if(get_field('list_winners_r', $id_ranking)){
    $list_w_r       = get_field('list_winners_r', $id_ranking);
}
else{
    $list_w_r       = array();
}
$nb_contenders      = count($list_contenders);
$nb_c_php           = $nb_contenders - 1;
$half               = $nb_contenders / 2;

// On boucle sur le ranking pour connaître la position dans le tableau du gagnant et du perdant
foreach($list_contenders as $key => $contender) {
    if($contender['id_global'] == $v){
        $key_winner     = $key;
    }
    if($contender['id_global'] == $l){
        $key_loser     = $key;
    }
}

// On boucle sur le ranking pour connaître tous les participants qui ont l'ID du gagnant dans le tableau de leur paramètre "superieur_to"
// On stocke dans la variable "$already_sup_to" la liste des participants(keys) qui ont battu le gagnant
foreach($list_contenders as $key => $contender) {
    if(in_array($key_winner, $contender['superieur_to'])){
        array_push($already_sup_to, $key);
    }
    if(in_array($key_loser, $contender['inferior_to'])){
        array_push($already_inf_to, $key);
    }
}

// On ajoute le gagnant dans la liste de ceux qui l'ont déjà battu
if($v){

    // On ajoute un vote au gagnant
    $list_contenders[$key_winner]['vote']++;

    // ??
    array_push($already_sup_to, $key_winner);

    // On récupère la liste des participants battu par le perdant du duel
    $list_sup_to_l = $list_contenders[$key_loser]['superieur_to'];

}
// On ajoute le perdant dans la liste de ceux qui l'ont déjà battu
if($l){

    // On ajoute un vote au perdant
    $list_contenders[$key_loser]['vote']++;

    // ??
    array_push($already_inf_to, $key_loser);

    // On récupère la liste des participants qui battent par le gagnant du duel
    $list_inf_to_v = $list_contenders[$key_winner]['inferior_to'];

}

if(in_array($list_contenders[$key_loser]['id'], $list_contenders[$key_winner]['inferior_to'])){
    $list_contenders[$key_winner]['inferior_to'] = array_diff($list_contenders[$key_winner]['inferior_to'], $list_contenders[$key_loser]['id']);
}

if(in_array($list_contenders[$key_winner]['id'], $list_contenders[$key_loser]['superieur_to'])){
    $list_contenders[$key_loser]['superieur_to'] = array_diff($list_contenders[$key_loser]['superieur_to'], $list_contenders[$key_winner]['id']);
}


// On boucle sur la liste des participant battant le perdant
// Cela inclus le gagnant du duel + tout ceux qui ont déjà battu ce gagnant
foreach (array_unique($already_sup_to) as $k){

    // On récupère la liste des participants que ce participant bat
    $to_up_sup_to = $list_contenders[$k]['superieur_to'];

    // On ajoute à cette liste, l'ID du perdant du duel
    array_push($to_up_sup_to, $key_loser);

    // Si il s'agit du gagnant du duel alors on fusionne les deux liste des participants battu par le gagnant et le perdant
    // Puis modifie la liste "superieur_to" du gagnant avec cette nouvelle liste
    // Si c'est un autre participant qui a déjà battu le vainkeurz alors on ajoute juste
    $total_sup_to = array_merge($list_sup_to_l, $to_up_sup_to);
    $list_contenders[$k]['superieur_to'] = array_unique($total_sup_to);

    // On compte le nombre de personne que le participant bat
    $count_sup_of     = count($list_contenders[$k]['superieur_to']);
    $new_place        = $count_sup_of;

    // On modifie la valeur de sa place avec cette nouvelle valeur
    $list_contenders[$k]['place']    = $new_place;

}

// On boucle sur la liste des participant perdant contre le perdant
// Cela inclus le perdant du duel + tout ceux qui battent déjà ce perdant
foreach (array_unique($already_inf_to) as $k){

    // On récupère la liste des participants qui le battent
    $to_up_inf_to = $list_contenders[$k]['inferior_to'];

    // On ajoute à cette liste, l'ID du gagnant du duel
    array_push($to_up_inf_to, $key_winner);

    // Si il s'agit du perdant du duel alors on fusionne les deux liste des participants qui battent par le gagnant et le perdant
    // Puis modifie la liste "inferior_to" du perdant avec cette nouvelle liste
    $total_inf_to = array_merge($list_inf_to_v, $to_up_inf_to);
    $list_contenders[$k]['inferior_to'] = array_unique($total_inf_to);

}

foreach($list_contenders as $item){

    $sum_vote         = $sum_vote + $item['vote'];

}
$timeline             = $sum_vote / 2;

// On enregistre la mise à jour du champs "Ranking" du classement en cours
update_field("ranking_r", $list_contenders, $id_ranking);

if($timeline < $half + 1){
    if($v){
        // On l'ajoute à la liste des gagnants
        array_push($list_w_r, $v);
        update_field('list_winners_r', $list_w_r, $id_ranking);
    }

    if($l){
        // On l'ajoute à la liste des perdants
        array_push($list_l_r, $l);
        update_field('list_losers_r', $list_l_r, $id_ranking);
    }
}

if($timeline < $half){

    $etape = 1;


    if($timeline == 0){
        $key_c_1 = $nb_c_php;
        $key_c_2 = $half - 1;
    }
    else{
        $key_c_1 = $nb_contenders - $timeline - 1;
        $key_c_2 = $nb_contenders - $half - $timeline - 1;
    }
    array_push($next_duel, $list_contenders[$key_c_1]['id_global']);
    array_push($next_duel, $list_contenders[$key_c_2]['id_global']);

}
elseif($timeline < ($nb_contenders - 1)){

    $etape = 2;

    $nb_loosers     = count($list_l_r) - 1;
    $inverse_looser = array_reverse($list_l_r);

    $key_c_1 = $nb_loosers - ($timeline - $half);
    $key_c_2 = $nb_loosers - ($timeline - $half) - 1;

    array_push($next_duel, $inverse_looser[$key_c_1]);
    array_push($next_duel, $inverse_looser[$key_c_2]);

}
elseif ($timeline < $nb_contenders){

    $etape = 3;

    $nb_loosers      = count($list_l_r) - 1;

    $nb_winners      = count($list_w_r) - 1;
    $inverse_winners = array_reverse($list_w_r);

    array_push($next_duel, $list_l_r[$nb_loosers]);
    array_push($next_duel, $inverse_winners[$nb_winners]);
}
elseif ($timeline < ($nb_contenders - 1 + $half)){

    $etape = 4;

    $nb_winners     = count($list_w_r) - 1;

    $key_c_1 = $timeline - $nb_contenders;
    $key_c_2 = $timeline - $nb_contenders + 1;

    array_push($next_duel, $list_w_r[$key_c_1]);
    array_push($next_duel, $list_w_r[$key_c_2]);
}
else{

    $etape = 5;

    $list_contenders_reverse = array_reverse($list_contenders);

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
        foreach ($list_contenders_reverse as $d => $val){

            if($val['place'] == $s){
                array_push($c_at_same_place, $val['id_global']);
            }

        }

    }

    $clear_c_at_same_place = array_filter($c_at_same_place);

    if(count($clear_c_at_same_place) >= 2){
        $is_next_duel = true;
        array_push($next_duel, $clear_c_at_same_place[0]);
        array_push($next_duel, $clear_c_at_same_place[1]);
    }
    else{
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

<div class="main">

    <header class="header">
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="col-sm-4">
                    <div class="logo">
                        <a href="<?php bloginfo('url'); ?>/">
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
                                Etape : <?php echo $etape; ?>
                            </b>
                            <br>
                            <b>
                                Timeline : <?php echo $timeline; ?>
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

<div class="stepbar <?php echo $bar_step; ?>">
    <h5>
        <?php
        if($bar_step == "step_bar_1"){
            $step_name = "On prend son mal en patience le temps d'évacuer les plus faibles !";
        }
        elseif($bar_step == "step_bar_2"){
            $step_name = "Bon il y a encore du monde à évacuer mais ça chauffe de plus en plus";
        }
        elseif($bar_step == "step_bar_3"){
            $step_name = "Ça commence à être du sérieux.";
        }
        elseif($bar_step == "step_bar_4"){
            $step_name = "Là ça devient chaud non ?";
        }
        elseif($bar_step == "step_bar_5"){
            $step_name = "Que des chocs de titans !!!";
        }
        elseif($bar_step == "fin_tournoi_bar"){
            $step_name = "Aie Aie Aie - nous y sommes - c'est le duel final !!!";
        }
        ?>
        <?php echo $current_step; ?> - <span><?php echo $step_name; ?></span>
    </h5>
</div>

<?php get_footer(); ?>
