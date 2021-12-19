$(document).ready(function ($) {

    let ajaxRunning = false;

    $(window).keyup(function(e){
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
                    id_top: $(this).find('.contender_zone').data('id-top'),
                    id_ranking: $(this).find('.contender_zone').data('id-ranking'),
                    id_winner: $(this).find('.contender_zone').data('id-winner'),
                    id_looser: $(this).find('.contender_zone').data('id-looser'),
                    current_id_vainkeur: id_vainkeur
                }
            })
            .done(function (response) {

                let data = JSON.parse(response);

                if(data.level_up !== undefined && data.level_up){
                    $('.dropdown-user-link .user-niveau').html(data.user_level_icon);
                    toastr['success']('Tu passes au niveau ' + data.user_level_icon, 
                        'Félicitations', {
                            closeButton: true,
                            tapToDismiss: true,
                            timeOut: 6000,
                            progressBar: true,
                            showMethod: 'slideDown',
                            hideMethod: 'slideUp'
                    });
                    window.dataLayer.push({
                        'event': 'track_event',
                        'event_name': 'level_up',
                        'categorie': vkrz_tracking_vars_top.top_categorie_layer,
                        'top_title': vkrz_tracking_vars_top.top_title_layer,
                        'top_id': vkrz_tracking_vars_top.top_id_top_layer,
                        'top_type': vkrz_tracking_vars_top.top_type_layer,
                        'user_id': vkrz_tracking_vars_user.id_user_layer,
                        'user_uuid': vkrz_tracking_vars_user.uuiduser_layer,
                        'user_level': data.user_level,
                        'utm': vkrz_tracking_vars_top.utm_layer,
                        'event_score': 50,
                    });
                }

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


                window.dataLayer.push({
                    'event': 'track_event',
                    'event_name': 'vote',
                    'categorie': vkrz_tracking_vars_top.top_categorie_layer,
                    'top_title': vkrz_tracking_vars_top.top_title_layer,
                    'top_id': vkrz_tracking_vars_top.top_id_top_layer,
                    'top_type': vkrz_tracking_vars_top.top_type_layer,
                    'user_id': vkrz_tracking_vars_user.id_user_layer,
                    'user_uuid': vkrz_tracking_vars_user.uuiduser_layer,
                    'user_level': vkrz_tracking_vars_top.top_user_level_layer,
                    'utm': vkrz_tracking_vars_top.utm_layer,
                    'event_score': 1,
                });

                if(!data.is_next_duel){
                    window.dataLayer.push({
                        'event': 'track_event',
                        'event_name': 'end_top',
                        'categorie': vkrz_tracking_vars_top.top_categorie_layer,
                        'top_title': vkrz_tracking_vars_top.top_title_layer,
                        'top_id': vkrz_tracking_vars_top.top_id_top_layer,
                        'top_type': vkrz_tracking_vars_top.top_type_layer,
                        'user_id': vkrz_tracking_vars_user.id_user_layer,
                        'user_uuid': vkrz_tracking_vars_user.uuiduser_layer,
                        'user_level': vkrz_tracking_vars_top.top_user_level_layer,
                        'utm': vkrz_tracking_vars_top.utm_layer,
                        'event_score': 20
                    });

                    $(location).attr('href', link_to_ranking);

                }
            }).always(function () {
                ajaxRunning = false;
            });
        }
    })
});
