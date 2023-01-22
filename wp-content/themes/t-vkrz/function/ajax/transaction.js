$(document).ready(function ($) {

    let ajaxRunning = false;

    $(document).on('click', '.ordershop', {}, function (e) {

      $('#waiter-commande').show();

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

                if (data['id_transaction']){
                    Swal.fire({
                        title: 'Commande validey 👌',
                        icon: 'success',
                        showConfirmButton: false,
                        timer: 1500,
                        buttonsStyling: false
                    });

                    var currentmoney = parseInt(data['current_money']);
                    $('.money-disponible').html(currentmoney);
                    $('.modal-shop').modal('hide');
                }

                if (data['new_badge']) {
                    toastr['success']('Tu obtiens le trophée Shopper 🛍', 'Nouveau trophée', {
                        closeButton: true,
                        tapToDismiss: false,
                        progressBar: true
                    });
                }

                $('#waiter-commande').hide();
                
            })
            .always(function () {
                ajaxRunning = false;
            });
        }
    });
});