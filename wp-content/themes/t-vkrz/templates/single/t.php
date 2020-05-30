<?php get_header(); ?>
<?php
$id_tournoi                 = get_the_ID();
$uuiduser                   = $_COOKIE["vainkeurz_user_id"];
$list_contenders_tournoi    = array();
$list_contenders            = array();
$list_votes                 = array();

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

$contenders      = new WP_Query(array(
    'post_type'      => 'contender',
    'posts_per_page' => -1,
    'orderby'        => 'date',
    'order'          => 'ASC',
    'meta_query'     => array(
        array(
            'key'     => 'id_tournoi_c',
            'value'   => $id_tournoi,
            'compare' => '=',
        )
    )
));
$i=0; while ($contenders->have_posts()) : $contenders->the_post();

    array_push($list_contenders, get_the_ID());

    if(!$id_classement_user || empty(get_field('ranking_r', $id_classement_user))) {

        array_push($list_contenders_tournoi, array(
            "id" => $i,
            "id_global" => get_the_ID(),
            "superieur_to" => array(),
            "place" => 0
        ));

    }

    $rand_c = array_rand($list_contenders, 2);
    $id_c_1 = $list_contenders[$rand_c[0]];
    $id_c_2 = $list_contenders[$rand_c[1]];

$i++; endwhile;

// Classement perso - ID
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
    update_field( 'ranking_r', $list_contenders_tournoi, $id_new_classement );
}

//update_field("ranking_r", $list_contenders_tournoi, $id_classement_user);
if(empty(get_field('ranking_r', $id_classement_user))){
    update_field("ranking_r", $list_contenders_tournoi, $id_classement_user);
}
else{
    $list_contenders_tournoi = get_field('ranking_r', $id_classement_user);
}

$v              = $_GET['v'];
$l              = $_GET['l'];
$deja_sup_to    = array();
$nb_contenders  = $contenders->post_count;

foreach($list_contenders_tournoi as $key => $contender) {
    if($contender['id_global'] == $v){
        $key_gagnant     = $key;
    }
    if($contender['id_global'] == $l){
        $key_perdant     = $key;
    }
}
foreach($list_contenders_tournoi as $key => $contender) {
    if(in_array($key_gagnant, $contender['superieur_to'])){
        array_push($deja_sup_to, $key);
    }
}
array_push($deja_sup_to, $key_gagnant);

$list_sup_to_l = $list_contenders_tournoi[$key_perdant]['superieur_to'];

echo "Déjà sup : <br>";
var_dump($deja_sup_to);
echo "<br>";echo "<br>";

foreach (array_unique($deja_sup_to) as $k){
    echo "ID :".$k."<br>";
    $to_up_sup_to = $list_contenders_tournoi[$k]['superieur_to'];
    echo "Supérieur à : <br>";
    var_dump($to_up_sup_to);
    echo "<br>";
    array_push($to_up_sup_to, $key_perdant);
    echo "MAJ du Supérieur à : <br>";
    var_dump($to_up_sup_to);
    echo "<br>";
    echo "List sup du perdant  : <br>";
    var_dump($list_sup_to_l);
    echo "<br>";echo "<br>";echo "<br>";

    if($k == $key_gagnant){
        $total_sup_to = array_merge($list_sup_to_l, $to_up_sup_to);
        $list_contenders_tournoi[$key_gagnant]['superieur_to'] = array_unique($total_sup_to);
    }
    else{
        $list_contenders_tournoi[$k]['superieur_to'] = array_unique($to_up_sup_to);
    }

    $actual_place_v  = $list_contenders_tournoi[$k]['place'];
    $count_place     = count(array_unique($to_up_sup_to));
    $new_place       = $count_place;
    $list_contenders_tournoi[$k]['place'] = $new_place;

}

$id_contender_next = array_column($list_contenders_tournoi, 'place');

$next_duel = array();
$nb_c_1    = $nb_contenders-1;


for($s = 0; $s <= $nb_c_1; $s++){

    if(count($next_duel) == 2){
        break;
    }

    //$s = 0
    foreach ($list_contenders_tournoi as $d => $val){

        if($val['place'] == $s){
            array_push($next_duel, $val['id_global']);
            if(count($next_duel) == 2){
                break;
            }
        }

    }

}

update_field("ranking_r", $list_contenders_tournoi, $id_classement_user);

$clear_next_duel = array_filter($next_duel);
if(count($clear_next_duel) >= 2){
    $is_next_duel = true;
}
else{
    $is_next_duel = false;
    update_field('done_r', date(), $id_classement_user);
}


?>
<div class="main">

    <div class="vardump">
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
            var_dump('Place actuelle : '.$actual_place_v);
            echo '<br>';
            var_dump('Nouvelle place : '.$new_place);
            echo '<br>';
            echo 'Liste des places : <pre>'; print_r($id_contender_next); echo '</pre>';
            echo '<br>';
            echo 'Prochain duel : <pre>'; print_r($next_duel); echo '</pre>';
            echo '<br>';
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
                                Vos votes : <?php echo $all_user_votes->post_count; ?>
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
                        <h1 class="title-battle">
                            <b>
                                <?php the_title(); ?>
                            </b>
                            <span>
                            <?php the_field('question_t'); ?>
                        </span>
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
                            <div class="col-5 link-contender_2 contender_1">
                                <a href="<?php the_permalink($id_tournoi); ?>?v=<?php echo $next_duel[0]; ?>&l=<?php echo $next_duel[1]; ?>">
                                    <?php
                                    echo get_the_post_thumbnail( $next_duel[0], 'full', array( 'class' => 'img-fluid' ) );
                                    ?>
                                    <h2 class="title-contender">
                                        <?php echo get_the_title( $next_duel[0] ); ?>
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
                                <a href="<?php the_permalink($id_tournoi); ?>?v=<?php echo $next_duel[1]; ?>&l=<?php echo $next_duel[0]; ?>">
                                    <?php
                                    echo get_the_post_thumbnail( $next_duel[1], 'full', array( 'class' => 'img-fluid' ) );
                                    ?>
                                    <h2 class="title-contender">
                                        <?php echo get_the_title( $next_duel[1] ); ?>
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

<?php get_footer(); ?>