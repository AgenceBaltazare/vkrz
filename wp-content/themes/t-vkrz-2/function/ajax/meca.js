$(document).ready(function ($) {

    var confirmDelete = $('#confirm_delete');

    if (confirmDelete.length) {
        confirmDelete.on('click', function () {
            Swal.fire({
                title: confirmDelete.data('phrase1'),
                text: confirmDelete.data('phrase2'),
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
                            id_ranking: confirmDelete.data('idranking')
                        }
                    }).done(function (response) {

                        let data = JSON.parse(response);

                        window.location.replace(data.url_tournament);

                    });
                    Swal.fire({
                        icon: 'success',
                        title: 'Opération effectuée',
                        text: "Recommencement du Top en cours...",
                        showConfirmButton: false,
                        timer: 5000
                    })
                }
            });
        });
    }

});