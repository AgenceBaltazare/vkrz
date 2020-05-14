$(document).ready(function ($) {
    let contenders = $('.link-contender');
    let post_count = $('.display_votes h6');


    contenders.click(function (e) {
        e.preventDefault();
        contenders.addClass('leaving');
        let contender_a = $(this).find('a');
        $.ajax({
            method: "POST",
            url: vkrz_ajaxurl,
            data: {
                action : 'vkzr_do_elo_vote',
                t: contender_a.data('contender-tournament'),
                v: contender_a.data('contender-chosen'),
                l: contenders.find('a').filter(function (index, el) {
                    return $(el).data('contender-chosen') !== contender_a.data('contender-chosen')
                }).data('contender-chosen')
            }
        })
            .done(function (response) {
                let data = JSON.parse(response)
                contenders.removeClass('leaving');

                for(let i=0; i < data.contenders.length; i++){
                    let contender_index = i+1
                    $(`#c_${contender_index}`).html(data.contenders[i]);

                }
                post_count.text(data.vote_count_string);
            });

    })

})
