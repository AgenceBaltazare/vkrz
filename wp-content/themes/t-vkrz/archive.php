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

