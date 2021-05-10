$(document).ready(function ($) {
    let contenders = $('.display_battle .link-contender');
    let ajaxRunning = false;

    $('.contender_1 .contender_zone').addClass('animate__slideInDown');
    $('.contender_2 .contender_zone').addClass('animate__slideInUp');

    $(window).keydown(function(e){
        if (e.keyCode === 37) {
            $("#c_1").trigger("click");
        } else if (e.keyCode === 39) {
            $("#c_2").trigger("click");
        }
    });

    $(document).on('click', '.display_battle .link-contender', {}, function (e) {

        $('.contender_zone').removeClass('animate__zoomIn');
        $('.contender_zone').removeClass('animate__slideInDown');
        $('.contender_zone').removeClass('animate__slideInUp');

        e.preventDefault();

        if (!ajaxRunning) {
            ajaxRunning = true;
            if ($(this).find('.contender_zone').attr('id') === "c_1") {
                $("#c_1").addClass('vainkeurz');
                $("#c_1").addClass('animate__headShake');
                $("#c_2").addClass('animate__zoomOutDown');
            } else if ($(this).find('.contender_zone').attr('id') === "c_2") {
                $("#c_2").addClass('vainkeurz');
                $("#c_2").addClass('animate__headShake');
                $("#c_1").addClass('animate__zoomOutDown');
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
                        $('.contender_1 .contender_zone').addClass('animate__zoomIn');
                        $('.contender_2 .contender_zone').addClass('animate__zoomIn');
                    }

                    $('.stepbar').width(data.current_step + "%");
                    $('.stepbar span').html(data.current_step + "%");

                    // +1 au compteur de votes du tournoi
                    var current_user_t_votes = parseInt($('#rank-'+data.id_ranking+' span.value-span').html());
                    $('#rank-'+data.id_ranking+' span.value-span').html(current_user_t_votes + 1);

                    // +1 au compteur de votes global
                    var current_user_total_votes = parseInt($('.user-total-vote-value').html());
                    $('.user-total-vote-value').html(current_user_total_votes + 1);

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
