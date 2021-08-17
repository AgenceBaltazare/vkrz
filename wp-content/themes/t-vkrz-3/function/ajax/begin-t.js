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
                window.dataLayer.push({
                    'event': 'track_event',
                    'event_name': 'start_top',
                    'categorie': top_categorie_layer,
                    'top_title': top_title_layer,
                    'top_id': top_id_top_layer,
                    'top_type': id_top,
                    'user_id': top_id_user_layer,
                    'user_uuid': top_uuiduser_layer,
                    'user_level': top_user_level_layer,
                    'utm': utm_layer,
                    'event_score': 10
                });
                location.reload()
            })
            .always(function () {
                ajaxRunning = false;
            });
        }
    });
});