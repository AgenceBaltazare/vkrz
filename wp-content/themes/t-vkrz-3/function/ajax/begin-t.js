$(document).ready(function ($) {

    let ajaxRunning = false;

    $(document).on('click', '.laucher_t', {}, function (e) {

        e.preventDefault();

        var laucher         = $(this);
        var id_top          = laucher.data('top');
        var uuiduser        = laucher.data('uuiduser');
        var typetop         = laucher.data('typetop');

        if(typetop == "top3"){
            $('.cta-complet').hide();
        }
        else{
            $('.cta-top3').hide();
        }
        laucher.html('Préparation du Top en cours...');

        if (!ajaxRunning) {
            ajaxRunning = true;
            $.ajax({
                method: "POST",
                url: vkrz_ajaxurl,
                data: {
                    action: 'vkzr_begin_t',
                    id_top: id_top,
                    uuiduser: uuiduser,
                    typetop: typetop,
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