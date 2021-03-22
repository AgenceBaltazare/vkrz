$(document).ready(function ($) {
    let contenders = $('.display_battle .link-contender');
    let ajaxRunning = false;

    contenders.find('.contender_zone').addClass('entering');

    $(window).keydown(function(e){
        if (e.keyCode === 37) {
            $("#c_1").trigger("click");
        } else if (e.keyCode === 39) {
            $("#c_2").trigger("click");
        }
    });

    $(document).on('click', '.display_battle .link-contender', {}, function (e) {

        e.preventDefault();

        if (!ajaxRunning) {
            ajaxRunning = true;
            if ($(this).find('.contender_zone').attr('id') === "c_1") {
                $("#c_1").addClass('vainkeurz');
                $("#c_2").addClass('leaving');
            } else if ($(this).find('.contender_zone').attr('id') === "c_2") {
                $("#c_2").addClass('vainkeurz');
                $("#c_1").addClass('leaving');
            }
            $.ajax({
                method: "POST",
                url: vkrz_ajaxurl,
                data: {
                    action: 'vkzr_process_vote',
                    id_tournament: $(this).find('.contender_zone').data('id-tournament'),
                    id_winner: $(this).find('.contender_zone').data('id-winner'),
                    id_looser: $(this).find('.contender_zone').data('id-looser')
                }
            })
                .done(function (response) {
                    let data = JSON.parse(response);

                    if(data.is_next_duel){
                        $('.display_battle').html(data.contenders_html);
                        contenders = $('.display_battle .link-contender');
                        contenders.find('.contender_zone').addClass('entering')
                    }
                    $('.stepbar').width(data.current_step + "%");
                    $('.display_users_votes h6').replaceWith(data.uservotes_html);
                    $('.current_rank').html(data.user_ranking_html);

                    if(!data.is_next_duel){
                        location.reload()
                    }

                }).always(function () {
                ajaxRunning = false;
            });
        }
    })
});
