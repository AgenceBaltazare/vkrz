$(document).ready(function ($) {

    let ajaxRunning = false;

    $(document).on('click', '#begin_t', {}, function (e) {

        e.preventDefault();

        var laucher         = $(this);
        var id_tournament   = laucher.data('tournament');
        var uuiduser        = laucher.data('uuiduser');

        laucher.html('Préparation du Top en cours...');

        if (!ajaxRunning) {
            ajaxRunning = true;
            $.ajax({
                method: "POST",
                url: vkrz_ajaxurl,
                data: {
                    action: 'vkzr_begin_t',
                    id_tournament: id_tournament,
                    uuiduser: uuiduser
                }
            })
                .done(function (response) {

                    location.reload()

                })
                .always(function () {
                    ajaxRunning = false;
                });
        }
    });
});