$(document).ready(function ($) {

    var form = $('#form-coupon');

    form.submit(function (e) {

        e.preventDefault();

        $.ajax({
            method: "POST",
            url: vkrz_ajaxurl,
            data: {
                action: 'vkzr_form_newplayer',
                emailplayer: form.find('#email-player-input').val(),
                uuiduser: form.find('#uuiduser').val(),
                ranking: form.find('#ranking').val(),
            }
        })
            .done(function () {
                $('.coupon-content').hide();
                $('.coupon-finish').show();
            });
    });
});