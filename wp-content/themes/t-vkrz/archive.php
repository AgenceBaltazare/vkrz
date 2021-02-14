<?php
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
            'value'   => $_COOKIE["vainkeurz_user_id"],
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
    'meta_query'     => array(
        array(
            'key'     => 'id_tournoi_c',
            'value'   => $id_tournoi,
            'compare' => '=',
        )
    )
));

$nums_pairs = "";
$nb_battle  = 0;
for ($i = 0; $i <= count($list_contenders); $i++) {
    for ($j = $i + 1; $j < count($list_contenders); $j++) {
        $nums_pairs .= $list_contenders[$i] . "," . $list_contenders[$j] . "<br>";
        $nb_battle++;
    }
}

// Classement
$contenders_top = new WP_Query(
    array(
        'post_type'      => 'contender',
        'posts_per_page' => 3,
        'meta_key'       => 'ELO_c',
        'orderby'        => 'meta_value',
        'order'          => 'DESC',
        'meta_query'     => array(
            array(
                'key'     => 'id_tournoi_c',
                'value'   => $id_tournoi,
                'compare' => 'LIKE',
            )
        )
    )
);

<?php if ($nb_user_votes == 0) : ?>
    Aucun vote encore
<?php elseif ($nb_user_votes == 1) : ?>
    Bravo pour ton 1er vote
<?php else : ?>
    Vos votes : <?php echo $all_user_votes->post_count; ?>
<?php endif; ?>

$(document).ready(function ($) {
    let contenders = $('.link-contender');
    let post_count = $('.display_votes h6');
    let user_votes = $('.display_users_votes h6');
    let classement = $('.classement_t');


    //Init first contenders
    contenders.find('a').addClass('entering')

    $("body").keydown(function(e) {
        e.preventDefault();
        if(e.keyCode == 37) { // left
            $("#c_1").trigger( "click" );
        }
        else if(e.keyCode == 39) { // right
            $("#c_2").trigger( "click" );
        }
    });

    contenders.click(function (e) {
        e.preventDefault();
        let contender_a = $(this).find('a');
        var id_contender = contender_a.attr('id');
        if(id_contender == "c_1"){
            $("#c_1").addClass('vainkeurz');
            $("#c_2").addClass('leaving');
        }
        else if(id_contender == "c_2"){
            $("#c_2").addClass('vainkeurz');
            $("#c_1").addClass('leaving');
        }
        //contenders.find('a').addClass('leaving');
        $.ajax({
            method: "POST",
            url: vkrz_ajaxurl,
            data: {
                action: 'vkzr_do_elo_vote',
                t: contender_a.data('contender-tournament'),
                v: contender_a.data('contender-chosen'),
                l: contenders.find('a').filter(function (index, el) {
                    return $(el).data('contender-chosen') !== contender_a.data('contender-chosen')
                }).data('contender-chosen')
            }
        })
        .done(function (response) {
            let data = JSON.parse(response)

            for (let i = 0; i < data.contenders.length; i++) {
                let contender_index = i + 1
                $(`#c_${contender_index}`).html(data.contenders[i]);
            }
            contenders.find('a').removeClass('leaving').addClass('entering');

            post_count.text(data.vote_count_string);

            user_votes.text(data.vote_user_count_string);

            let responseClassement = $.parseHTML(data.classement).filter(function (el) {
                return $(el).hasClass('contenders_min')
            });

            classement.find('.contenders_min').each(function (index, el) {
                let contender = $(el);
                let replacement = $(responseClassement[index]);
                if (contender.find('.name > *:first-child').text() !== replacement.find('.name > *:first-child').text()) {
                    contender.fadeOut('fast', function () {
                        $(this).html(replacement.html()).fadeIn()
                    });
                }
            })
        });
    })
});

---

<?php
get_header();

/* Variables */
$id_tournoi      = get_the_ID();
$list_contenders = array();
$uuiduser        = $_COOKIE["vainkeurz_user_id"];

if(isset($_GET['r']) && $_GET['r'] != ""){
    $id_ranking  = $_GET['r'];
}
else{
    $id_ranking = get_user_ranking($uuiduser, $id_tournoi);
}

if(empty(get_field('ranking_r', $id_ranking))){

    $contenders      = new WP_Query(array(
        'post_type'      => 'contender',
        'posts_per_page' => -1,
        'orderby'        => 'rand',
        'meta_query'     => array(
            array(
                'key'     => 'id_tournoi_c',
                'value'   => $id_tournoi,
                'compare' => '=',
            )
        )
    ));
    $i=0; while ($contenders->have_posts()) : $contenders->the_post();

        array_push($list_contenders, array(
            "id"                => $i,
            "id_global"         => get_the_ID(),
            "contender_name"    => get_the_title(),
            "vote"              => 0,
            "superieur_to"      => array(),
            "inferior_to"       => array(),
        ));

        $i++; endwhile;

    update_field("ranking_r", $list_contenders, $id_ranking);
}
$list_contenders = get_field('ranking_r', $id_ranking);


$zerovote = array_column($list_contenders, 'vote');
for($m=1; $m<3; $m++){
    $key[] = array_search(0, $zerovote);
}

$rand_c = array_rand($key, 2);
$id_c_1 = $list_contenders[$rand_c[0]]['id_global'];
$id_c_2 = $list_contenders[$rand_c[1]]['id_global'];

$v              = $_GET['v'];
$l              = $_GET['l'];

$deja_sup_to    = array();
$nb_contenders  = count($list_contenders);
$next_duel      = array();
$nb_c           = $nb_contenders-1;

for($s = 0; $s <= $nb_c; $s++){

    if(count($next_duel) == 2){
        break;
    }

    foreach ($list_contenders as $d => $val){

        if($val['vote'] == $s){
            array_push($next_duel, $val['id_global']);
            if(count($next_duel) == 2){
                break;
            }
        }

    }

}
wp_reset_query();
?>
    <pre class="ba-white">
    <?php
    var_dump('nb_c: '.$nb_c.'<br>');
    var_dump('C1: '.$next_duel[0].'<br>');
    var_dump('C2: '.$next_duel[1].'<br>');
    var_dump('ID Classement: '.$id_ranking.'<br>');
    print_r($next_duel);
    print_r($zerovote);
    print_r($list_contenders);
    ?>
</pre>
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
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="display_battle">
                        <div class="row align-items-center contenders-containers">
                            <div class="col-5 link-contender contender_1">
                                <a href="<?php the_permalink($id_tournoi); ?>?r=<?php echo $id_ranking; ?>&v=<?php echo $next_duel[1]; ?>&l=<?php echo $next_duel[0]; ?>"
                                   data-contender-tournament="<?= $id_tournoi ?>"
                                   data-contender-chosen="<?= $next_duel[0] ?>"
                                   data-contender-notchosen="<?= $next_duel[1] ?>"
                                   id="c_1">
                                    <?php
                                    echo get_the_post_thumbnail( $next_duel[0], 'full', array( 'class' => 'img-fluid' ) );
                                    ?>
                                    <h2 class="title-contender">
                                        <?php echo get_the_title( $next_duel[0] ); ?>
                                    </h2>
                                </a>
                            </div>
                            <div class="col-2">
                                <h4 class="text-center versus">
                                    VS
                                </h4>
                            </div>
                            <div class="col-5 link-contender contender_2">
                                <a href="<?php the_permalink($id_tournoi); ?>?r=<?php echo $id_ranking; ?>&v=<?php echo $next_duel[0]; ?>&l=<?php echo $next_duel[1]; ?>"
                                   data-contender-tournament="<?= $id_tournoi ?>"
                                   data-contender-chosen="<?= $next_duel[1] ?>"
                                   data-contender-notchosen="<?= $next_duel[0] ?>"
                                   id="c_1">
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
    </div>

<?php get_footer(); ?>

--
