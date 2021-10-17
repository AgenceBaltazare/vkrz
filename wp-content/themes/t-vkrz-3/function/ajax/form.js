$(document).ready(function ($) {

    var form = $('#form-coupon');

    console.log("aaa");

    form.submit(function (e) {

        console.log("fdfd");

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
        }).done(function (response) {
            $('.coupon-content').hide();
            $('.coupon-finish').show();

        }).always(function () {
            
        });
    });
});