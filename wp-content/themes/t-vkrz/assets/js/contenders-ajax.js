$(document).ready(function ($) {
    let contenders = $('.link-contender');

    contenders.click(function (e) {
        //e.preventDefault();
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
        $.ajax({
            method: "POST",
            url: vkrz_ajaxurl,
            data: {
                action: 'vkzr_do_elo_vote',
                t: contender_a.data('contender-tournament'),
                v: contender_a.data('contender-chosen'),
                l: contender_a.data('contender-notchosen'),
            }
        })
        .done(function (response) {
            console.log(response);
        });
    })
});
