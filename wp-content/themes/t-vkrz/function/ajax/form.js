$(document).ready(function ($) {

    var form = $('#form-coupon');

    form.submit(function (e) {

        form.find('#btn-coupon').hide();
        
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
                id_vainkeur: form.find('#id_vainkeur').val()
            }
        }).done(function (response) {
            $('.participate-init').hide();
            $('.participation-confirme').removeClass("d-none");

        }).always(function () {
            
        });
    });
});