<?php
$id_tournoi                 = get_the_ID();
$uuiduser                   = $_COOKIE["vainkeurz_user_id"];
$list_contenders_tournoi    = array();
$list_contenders            = array();
$list_votes                 = array();
$v                          = $_GET['v'];
$l                          = $_GET['l'];
$deja_sup_to                = array();
$next_duel                  = array();
$current_date               = date('d/m/Y H:i:s');
$elo_v                      = false;
$elo_l                      = false;
$nb_step                    = 5;

if(isset($v)){
    if ( is_user_logged_in() ) {
        $is_logged  = "true";
    }
    else{
        $is_logged  = "false";
    }

    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        $ip_user_v = $_SERVER['HTTP_CLIENT_IP'];
    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $ip_user_v = $_SERVER['HTTP_X_FORWARDED_FOR'];
    } else {
        $ip_user_v = $_SERVER['REMOTE_ADDR'];
    }
    $new_vote = array(
        'post_type'   => 'vote',
        'post_title'  => 'U:' . $uuiduser . ' T:' . $id_tournoi . ' V:' . $v . '(' . $elo_v . ')' . ' L:' . $l . '(' . $elo_l . ')',
        'post_status' => 'publish',
    );
    $id_vote  = wp_insert_post( $new_vote );

    update_field( 'id_user_v', $uuiduser, $id_vote );
    update_field( 'ip_user_v', $ip_user_v, $id_vote );
    update_field( 'id_v_v', $v, $id_vote );
    update_field( 'elo_v_v', $elo_v, $id_vote );
    update_field( 'id_l_v', $l, $id_vote );
    update_field( 'elo_l_v', $elo_l, $id_vote );
    update_field( 'id_t_v', $id_tournoi, $id_vote );
    update_field( 'loggue_v', $is_logged, $id_vote );
}

// All user votes in the current tournoi
$all_user_votes       = new WP_Query(array(
    'post_type'      => 'vote',
    'posts_per_page' => -1,
    'meta_query'     => array(
        'relation'   => 'AND',
        array(
            'key'     => 'id_t_v',
            'value'   => $id_tournoi,
            'compare' => '=',
        ),
        array(
            'key'     => 'id_user_v',
            'value'   => $uuiduser,
            'compare' => '=',
        )
    )
));
$nb_user_votes = $all_user_votes->post_count;

// All total votes in the current tournoi
$all_votes       = new WP_Query(array(
    'post_type'      => 'vote',
    'posts_per_page' => -1,
    'meta_query'     => array(
        array(
            'key'     => 'id_t_v',
            'value'   => $id_tournoi,
            'compare' => '=',
        )
    )
));

// On vérifie si l'utilisateur en cours à un classement pour ce tournoi
// Si oui alors on récupère l'ID du classement
// Si non alors on créé le classement
$classement_perso = new WP_Query(array('post_type' => 'classement', 'orderby' => 'date', 'posts_per_page' => '1', 'meta_query' =>
    array(
        'relation'  => 'AND',
        array(
            'key'     => 'id_tournoi_r',
            'value'   => $id_tournoi,
            'compare' => '=',
        ),
        array(
            'key' => 'uuid_user_r',
            'value' => $uuiduser,
            'compare' => '=',
        )
    )
));
if($classement_perso->have_posts()){
    while ($classement_perso->have_posts()) : $classement_perso->the_post();
        $id_classement_user = get_the_ID();
    endwhile;
}
else{
    $new_classement = array(
        'post_type'   => 'classement',
        'post_title'  => 'T:' . $id_tournoi .' U:' . $uuiduser,
        'post_status' => 'publish',
    );
    $id_new_classement  = wp_insert_post( $new_classement );

    update_field( 'uuid_user_r', $uuiduser, $id_new_classement );
    update_field( 'id_tournoi_r', $id_tournoi, $id_new_classement );
}

// Si il n'y a pas de classement en cours pour l'utilisateur alors on le génère
// Si il y a un classement en cours alors on récupère la valeur du champs Ranking
if(!$id_classement_user || empty(get_field('ranking_r', $id_classement_user))) {

    // On boucle sur tous les participants du tournoi
    $contenders = new WP_Query(array(
        'post_type' => 'contender',
        'posts_per_page' => -1,
        'orderby' => 'date',
        'order' => 'ASC',
        'meta_query' => array(
            array(
                'key' => 'id_tournoi_c',
                'value' => $id_tournoi,
                'compare' => '=',
            )
        )
    ));
    $i = 0;
    while ($contenders->have_posts()) : $contenders->the_post();

        // On créé le tableau avec tous les participants
        // On initialise : place => 0 // Supérieur => vide
        array_push($list_contenders_tournoi, array(
            "id"            => $i,
            "id_global"     => get_the_ID(),
            "name"          => get_the_title().' ('.get_the_ID().')',
            "superieur_to"  => array(),
            "place"         => 0
        ));

    $i++;
    endwhile;

    // On update le champs Rankin du classement de l'utilisateur
    $list_contenders_tournoi = array_filter($list_contenders_tournoi);
    update_field( 'ranking_r', $list_contenders_tournoi, $id_new_classement );
}
else{
    $list_contenders_tournoi = get_field('ranking_r', $id_classement_user);
}

// On boucle sur le ranking pour connaître la position dans le tableau du gagnant et du perdant
foreach($list_contenders_tournoi as $key => $contender) {
    if($contender['id_global'] == $v){
        $key_gagnant     = $key;
    }
    if($contender['id_global'] == $l){
        $key_perdant     = $key;
    }
}

// On boucle sur le ranking pour connaître tous les participants qui ont l'ID du gagnant dans le tableau de leur paramètre "superieur_to"
// On stocke dans la variable "$deja_sup_to" la liste des participants(keys) qui ont battu le gagnant
foreach($list_contenders_tournoi as $key => $contender) {
    if(in_array($key_gagnant, $contender['superieur_to'])){
        array_push($deja_sup_to, $key);
    }
}

// On ajoute le gagnant dans la liste de ceux qui l'ont déjà battu
if($v){
    array_push($deja_sup_to, $key_gagnant);
}

// On récupère la liste des participants battu par le perdant du duel
$list_sup_to_l = $list_contenders_tournoi[$key_perdant]['superieur_to'];

// On boucle sur la liste des participant battant le perdant
// Cela inclus le gagnant du duel + tout ceux qui ont déjà battu ce gagnant
foreach (array_unique($deja_sup_to) as $k){

    // On récupère la liste des participants que ce participant bat
    $to_up_sup_to = $list_contenders_tournoi[$k]['superieur_to'];

    // On ajoute à cette liste, l'ID du perdant du duel
    array_push($to_up_sup_to, $key_perdant);

    // Si il s'agit du gagnant du duel alors on fusionne les deux liste des participants battu par le gagnant et le perdant
    // Puis modifie la liste "superieur_to" du gagnant avec cette nouvelle liste
    // Si c'est un autre participant qui a déjà battu le vainkeurz alors on ajoute juste
    $total_sup_to = array_merge($list_sup_to_l, $to_up_sup_to);
    $list_contenders_tournoi[$k]['superieur_to'] = array_unique($total_sup_to);

    // On compte le nombre de personne que le participant bat
    $count_place     = count(array_unique($to_up_sup_to));
    $new_place       = $count_place;
    // On modifie la valeur de sa place avec cette nouvelle valeur
    $list_contenders_tournoi[$k]['place'] = $new_place;

}

// On liste les uniquement les "place" pour obtenir un tableau simple avec les index des participants et leur place
$id_contender_next = array_column($list_contenders_tournoi, 'place', 'name');

// On compte le nombre de participants
$nb_contenders     = count($list_contenders_tournoi);

// On lance des boucles jusqu'à obtenir le tableau "$next_duel" avec deux valeurs
// On lance autant de boucle que de participant-1
for($s = 0; $s <= $nb_contenders-1; $s++){

    // Si le tableau "$next_duel" est supérieur ou égal à deux valeurs alors on stop car nous pouvons faire un nouveau duel
    // Sinon on le remet à zéro
    if(count($next_duel) >= 2){
        $step_number = $s;
        break;
    }
    else{
        $next_duel = array();
    }

    // On boucle sur tous les participant et on stocke leur ID global quand leur place est égal à l'incrémentation
    foreach ($list_contenders_tournoi as $d => $val){

        if($val['place'] == $s){
            array_push($next_duel, $val['id_global']);
        }

    }

}

// On en déduits le nombre d'étapes
$stade_steps     = floor($nb_contenders / $nb_step);
if(isset($step_number)){

    for($m=1; $m <= $nb_step; $m++){

        if($step_number == 0){
            $current_step = "Début du tournoi";
            $body_class   = "debut_tournoi";
            $bar_step     = "debut_tournoi_bar";
            break;
        }
        elseif($step_number <= $stade_steps * $m){
            $current_step  = "Étape ".$m." / ".$nb_step;
            $body_class    = "step_".$m;
            $bar_step      = "step_bar_".$m;
            break;
        }
        else{
            $current_step  = "Duel final";
            $body_class    = "fin_tournoi";
            $bar_step      = "fin_tournoi_bar";
        }
    }

}
else{
    $current_step = "Début du tournoi";
}

// On enregistre la mise à jour du champs "Ranking" du classement en cours
update_field("ranking_r", $list_contenders_tournoi, $id_classement_user);

// On supprime les valeurs vide du tableau de duels
$clear_next_duel = array_filter($next_duel);
// On prend deux participant au hasard dans ce tableau
$rand_keys = array_rand($clear_next_duel, 2);

// Si le tableau à deux valeur alors on peut faire un autre duel avec les IDs des deux participants
// Sinon c'est la fin du classement et on stock dans le champs "done_r" la date de fin
if(count($clear_next_duel) >= 2){
    $is_next_duel = true;
    $contender_1  = $clear_next_duel[$rand_keys[0]];
    $contender_2  = $clear_next_duel[$rand_keys[1]];
}
else{
    $is_next_duel = false;
    if(!get_field('done_r', $id_classement_user)){
        update_field( 'done_r', 'done', $id_classement_user );
        update_field( 'done_date_r', $current_date, $id_classement_user );
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
<body <?php body_class(array('cover', 'a_step', $body_class)); ?> style="background: url(<?php echo $illu_url; ?>) center center no-repeat">

<div class="main">

    <div class="vardump none">
        <?php
            echo 'Nombre de contenders : '.$nb_contenders;
            $results = get_field('ranking_r', $id_classement_user);
            echo '<pre>'; print_r($results); echo '</pre>';
            var_dump('Gagnant : '.$key_gagnant.'('.$v.')');
            echo '<br>';
            var_dump('Perdant : '.$key_perdant.'('.$l.')');
            echo '<br>';
            echo 'Liste des plus fort : <pre>'; print_r($deja_sup_to); echo '</pre>';
            echo '<br>';
            var_dump('Nouvelle place : '.$new_place);
            echo '<br>';
            echo 'Liste des places : <pre>'; print_r($id_contender_next); echo '</pre>';
            echo '<br>';
            echo 'Prochain participants possible: <pre>'; print_r($clear_next_duel); echo '</pre>';
            echo '<br>';
            echo 'Prochain duel: <pre>'; echo $contender_1.' VS '.$contender_2.'</pre>';
            echo '<br>';
            echo '<pre>'; print_r($stade_steps."/".$nb_step." ".$step_number." ".$current_step); echo '</pre>';
        ?>
    </div>


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
                        <a href="https://baltazare1.typeform.com/to/j9n8JU" target="_blank" class="cta_2">
                            ☝️ Donnez nous votre avis !
                        </a>
                        <h6>
                            <?php if ($nb_user_votes == 0) : ?>
                                Aucun vote encore
                            <?php elseif ($nb_user_votes == 1) : ?>
                                Bravo pour ton 1er vote
                            <?php else : ?>
                                Vos votes : <?php echo $nb_user_votes; ?>
                            <?php endif; ?>
                        </h6>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <div class="container">
        <div class="tournoi_infos">
            <div class="row align-items-center">
                <div class="col-12">
                    <div class="bloc-titre">
                        <h1>
                            <b>
                                <?php the_title(); ?>
                            </b>
                        </h1>
                        <h2>
                            <?php the_field('question_t'); ?>
                            <span class="toshowpopover moreinfo" data-container="body" data-toggle="popover" data-placement="top" data-content="Prendre en compte la forme la plus puissante du perso">
                                <i class="fal fa-info-circle"></i>
                            </span>
                        </h2>
                        <ul class="infos_tournoi">
                            <li class="toshowpopover" data-container="body" data-toggle="popover" data-placement="top" data-content="<?php echo $nb_contenders; ?> participants dans ce tournoi">
                                <i class="fad fa-users-crown"></i> <?php echo $nb_contenders; ?>
                            </li>
                            <li class="toshowpopover" data-container="body" data-toggle="popover" data-placement="top" data-content="Vous devez voter environ <?php echo $nb_contenders * 3; ?> fois pour finir votre classement">
                                <i class="fad fa-infinity"></i> <?php echo $nb_contenders * 3; ?>
                            </li>
                        </ul>
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
                            <div class="col-5 link-contender_2 contender_1">
                                <a href="<?php the_permalink($id_tournoi); ?>?v=<?php echo $contender_1; ?>&l=<?php echo $contender_2; ?>">
                                    <?php
                                    echo get_the_post_thumbnail($contender_1, 'full', array( 'class' => 'img-fluid'));
                                    ?>
                                    <h2 class="title-contender">
                                        <?php echo get_the_title($contender_1); ?>
                                    </h2>
                                </a>
                            </div>
                            <div class="col-2">
                                <div class="display_votes">
                                    <h6>
                                        <?php echo $all_votes->post_count; ?> votes
                                    </h6>
                                </div>
                                <h4 class="text-center versus">
                                    VS
                                </h4>
                            </div>
                            <div class="col-5 link-contender_2 contender_2">
                                <a href="<?php the_permalink($id_tournoi); ?>?v=<?php echo $contender_2; ?>&l=<?php echo $contender_1; ?>">
                                    <?php
                                    echo get_the_post_thumbnail($contender_2, 'full', array( 'class' => 'img-fluid'));
                                    ?>
                                    <h2 class="title-contender">
                                        <?php echo get_the_title($contender_2); ?>
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
                        <a href="<?php the_permalink($id_classement_user); ?>">
                            Votre classement personnel est terminé.
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