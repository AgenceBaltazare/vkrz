$(document).ready(function ($) {

    var form = $('#form-coupon');

    form.submit(function (e) {

        form.find('#btn-coupon').html('Go')

        e.preventDefault();

        $.ajax({
            method: "POST",
            url: vkrz_ajaxurl,
            data: {
                action: 'vkzr_form_newplayer',
                emailplayer: form.find('#email-player-input').val(),
                uuiduser: form.find('#uuiduser').val(),
                ranking: form.find('#ranking').val(),
                top: form.find('#top').val(),
            }
        }).done(function (response) {
            form.hide();
            $('.bravo').show();

        }).always(function () {
            
        });
    });
});