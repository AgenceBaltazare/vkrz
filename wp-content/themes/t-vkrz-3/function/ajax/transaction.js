$(document).ready(function ($) {

    let ajaxRunning = false;

    $(document).on('click', '.ordershop', {}, function (e) {

        e.preventDefault();

        var id_produit  = $(this).data('idproduit');
        var price       = $(this).data('price');
        var user_uuid   = $(this).data('uuid');
        var user_email  = $(this).data('user_email'); 
        var idvainkeur  = $(this).data('idvainkeur');

        if (!ajaxRunning) {
            ajaxRunning = true;
            $.ajax({
                method: "POST",
                url: vkrz_ajaxurl,
                data: {
                    action: 'vkzr_do_transaction',
                    id_produit: id_produit,
                    price: price,
                    user_uuid: user_uuid,
                    user_email: user_email,
                    idvainkeur: idvainkeur
                }
            })
            .done(function (response) {

                let data = JSON.parse(response);

                console.log(data);

                var currentmoney = parseInt(data);
                $('.valid-commande').show();
                $('.user-total-vote-value').html(currentmoney);
                
            })
            .always(function () {
                ajaxRunning = false;
            });
        }
    });
});