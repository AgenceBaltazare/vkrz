$(document).ready(function ($) {
    let contenders = $('.display_battle .link-contender');
    let ajaxRunning = false;

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

        window.dataLayer.push({
            'event': 'track_event',
            'event_name': 'vote',
            'page_categorie': $(this).find('.contender_zone').data('cat-name'),
            'top_title': $(this).find('.contender_zone').data('top-title'),
            'top_question': $(this).find('.contender_zone').data('top-question'),
            'id_top' : $(this).find('.contender_zone').data('id-tournament'),
            'id_user': $(this).find('.contender_zone').data('id-user'),
            'type_top': $(this).find('.contender_zone').data('type-top'),
            'utm': $(this).find('.contender_zone').data('utm'),
            'event_score': 1
        },
    );

        if (!ajaxRunning) {
            ajaxRunning = true;
            if ($(this).find('.contender_zone').attr('id') === "c_1") {
                $("#c_1").addClass('vainkeurz');
                $("#c_1").addClass('animate__headShake');
                $("#c_2").addClass('animate__fadeOutDown');
            } else if ($(this).find('.contender_zone').attr('id') === "c_2") {
                $("#c_2").addClass('vainkeurz');
                $("#c_2").addClass('animate__headShake');
                $("#c_1").addClass('animate__fadeOutDown');
            }
            $.ajax({
                method: "POST",
                url: vkrz_ajaxurl,
                data: {
                    action: 'vkzr_process_vote',
                    id_tournament: $(this).find('.contender_zone').data('id-tournament'),
                    id_ranking: $(this).find('.contender_zone').data('id-ranking'),
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

                    // -1 au décompte du prochain niveau
                    var current_decompte_vote = parseInt($('.decompte_vote').html());
                    $new_decompte_vote_val = current_decompte_vote - 1;
                    if($new_decompte_vote_val <= 0){
                        $new_decompte_vote_val = 0;
                    }
                    $('.decompte_vote').html($new_decompte_vote_val);

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

    $(document).on('click', '.restart', {}, function (e) {
        window.dataLayer.push({
                'event': 'track_event',
                'event_name': 'restart_top',
                'page_categorie': $(this).find('.restart').data('cat-name'),
                'top_title': $(this).find('.restart').data('top-title'),
                'top_question': $(this).find('.restart').data('top-question'),
                'id_top' : $(this).find('.restart').data('id-tournament'),
                'id_user': $(this).find('.restart').data('id-user'),
                'type_top': $(this).find('.restart').data('type-top'),
                'utm': $(this).find('.restart').data('utm'),
                'event_score': 5
            }
        );
    })
    $(document).on('click', '.starting', {}, function (e) {
        window.dataLayer.push({
                'event': 'track_event',
                'event_name': 'start_top',
                'page_categorie': $(this).find('.starting').data('cat-name'),
                'top_title': $(this).find('.starting').data('top-title'),
                'top_question': $(this).find('.starting').data('top-question'),
                'id_top': $(this).find('.starting').data('id-tournament'),
                'id_user': $(this).find('.starting').data('id-user'),
                'type_top': $(this).find('.starting').data('type-top'),
                'utm': $(this).find('.starting').data('utm'),
                'event_score': 10
            }
        );
    })
    $(document).on('.ending', {}, function (e) {
        window.dataLayer.push({
                'event': 'track_event',
                'event_name': 'end_top',
                'page_categorie': $(this).find('.ending').data('cat-name'),
                'top_title': $(this).find('.ending').data('top-title'),
                'top_question': $(this).find('.ending').data('top-question'),
                'id_top' : $(this).find('.ending').data('id-tournament'),
                'id_user': $(this).find('.ending').data('id-user'),
                'type_top': $(this).find('.ending').data('type-top'),
                'utm': $(this).find('.ending').data('utm'),
                'event_score': 20
            }

        );
    })
})
