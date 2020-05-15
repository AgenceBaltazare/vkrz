$(document).ready(function ($) {
    let contenders = $('.link-contender');
    let post_count = $('.display_votes h6');
    let classement = $('.classement_t');


    //Init first contenders
    contenders.find('a').addClass('entering')

    contenders.click(function (e) {
        e.preventDefault();
        let contender_a = $(this).find('a');
        contenders.find('a').addClass('leaving');
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
