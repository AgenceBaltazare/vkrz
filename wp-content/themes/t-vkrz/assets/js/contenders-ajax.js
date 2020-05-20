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
        console.log(id_contender);
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
