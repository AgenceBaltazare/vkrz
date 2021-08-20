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
                dataLayer.push({
                    'event': 'track_event',
                    'event_name': 'start_top',
                    'categorie': vkrz_tracking_vars_top.top_categorie_layer,
                    'top_title': vkrz_tracking_vars_top.top_title_layer,
                    'top_id': vkrz_tracking_vars_top.top_id_top_layer,
                    'top_type': vkrz_tracking_vars_top.id_top,
                    'user_id': vkrz_tracking_vars_user.id_user_layer,
                    'user_uuid': vkrz_tracking_vars_user.uuiduser_layer,
                    'user_level': vkrz_tracking_vars_top.top_user_level_layer,
                    'utm': vkrz_tracking_vars_top.utm_layer,
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