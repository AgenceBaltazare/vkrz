$(document).ready(function ($) {

    let ajaxRunning = false;

    $(document).on('click', '#follow_btn', {}, function (e) {

        e.preventDefault();

        var btn_follow = $(this);
        var uuiduser = btn_follow.data('uuid');
        var notif_text = btn_follow.data('text');

        console.log(uuiduser);

        btn_follow.html('Suivi !');

        if (!ajaxRunning) {
            ajaxRunning = true;
            $.ajax({
                method: "POST",
                url: vkrz_ajaxurl,
                data: {
                    action: 'vkzr_do_notification',
                    uuiduser: uuiduser,
                    notif_text: notif_text,
                }
            })
            .done(function (response) {
                console.log(response);
            })
            .always(function () {
                ajaxRunning = false;
            });
        }
    });
});