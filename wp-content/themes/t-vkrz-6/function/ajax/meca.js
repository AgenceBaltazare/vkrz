$(document).ready(function ($) {

    var confirmDelete = $('.confirm_delete');
    if (confirmDelete.length) {
        confirmDelete.on('click', function () {
            var id_ranking           = $(this).data('id_ranking');
            var id_vainkeur          = $(this).data('id_vainkeur');
            
            Swal.fire({
                title: $(this).data('phrase1'),
                text: $(this).data('phrase2'),
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Oui oui je suis sûr',
                cancelButtonText: 'Annuler',
                customClass: {
                    confirmButton: 'btn btn-primary',
                    cancelButton: 'btn btn-outline-danger ml-1',

                },
                buttonsStyling: false
            }).then(function (result) {
                localStorage.removeItem('twitchGameMode');
                
                if (result.value) {
                    $.ajax({
                        method: "POST",
                        url: vkrz_ajaxurl,
                        data: {
                            action: 'vkzr_process_delete_ranking',
                            id_ranking: id_ranking,
                            id_vainkeur: id_vainkeur
                        }
                    }).done(function (response) {

                        let data = JSON.parse(response);

                        Swal.fire({
                            icon: 'success',
                            title: 'Opération effectuée',
                            text: "Recommencement du Top en cours...",
                            showConfirmButton: false,
                            timer: 5000
                        })

                        maj_firebase_delete_toplist(id_ranking, id_vainkeur);

                        dataLayer.push({
                            'event': 'track_event',
                            'event_name': 'restart_top',
                            'categorie': vkrz_tracking_vars_top.top_categorie_layer,
                            'top_title': vkrz_tracking_vars_top.top_title_layer,
                            'top_id': vkrz_tracking_vars_top.top_id_top_layer,
                            'top_type': vkrz_tracking_vars_top.top_type_layer,
                            'user_id': vkrz_tracking_vars_user.id_user_layer,
                            'user_uuid': vkrz_tracking_vars_user.uuiduser_layer,
                            'user_level': vkrz_tracking_vars_top.top_user_level_layer,
                            'utm': vkrz_tracking_vars_top.utm_layer,
                            'event_score': 10
                        });

                        window.location.replace(data.url_top);

                    });
                }
            });
        });
    }

});