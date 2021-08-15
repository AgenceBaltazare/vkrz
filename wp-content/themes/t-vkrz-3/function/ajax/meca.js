$(document).ready(function ($) {

    var confirmDelete = $('.confirm_delete');
    if (confirmDelete.length) {
        confirmDelete.on('click', function () {
            var id_ranking_to_supp   = $(this).data('id_ranking');
            var id_vainkeur          = $(this).data('id_vainkeur');
            
            console.log(id_vainkeur);
            console.log(id_ranking_to_supp);
            
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
                if (result.value) {
                    $.ajax({
                        method: "POST",
                        url: vkrz_ajaxurl,
                        data: {
                            action: 'vkzr_process_delete_ranking',
                            id_ranking: id_ranking_to_supp,
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

                        window.location.replace(data.url_top);

                    });
                }
            });
        });
    }

    var confirmDeleteReal = $('.confirmDeleteReal');
    if (confirmDeleteReal.length) {
        confirmDeleteReal.on('click', function () {
            var id_ranking_to_supp = $(this).data('id_ranking');
            var id_vainkeur        = $(this).data('id_vainkeur');

            console.log(id_vainkeur);
            console.log(id_ranking_to_supp);

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
                if (result.value) {
                    $.ajax({
                        method: "POST",
                        url: vkrz_ajaxurl,
                        data: {
                            action: 'vkzr_process_delete_real_ranking',
                            id_ranking: id_ranking_to_supp,
                            id_vainkeur: id_vainkeur
                        }
                    }).done(function (response) {

                        let data = JSON.parse(response);
                        $('#top-'+data.id_ranking).fadeOut();

                        Swal.fire({
                            icon: 'success',
                            title: 'Opération effectuée',
                            text: "Ton Top a bien été supprimé !",
                            showConfirmButton: false,
                            timer: 5000
                        })

                    });
                }
            });
        });
    }

});