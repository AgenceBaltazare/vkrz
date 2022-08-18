$(document).ready(function ($) {

    var uuiduser_similar   = $('.similarpercent').data('uuiduser');
    var idtop_similar      = $('.similarpercent').data('idtop');

    if (uuiduser_similar){
        $.ajax({
            method: 'POST',
            url: vkrz_ajaxurl,
            data: {
                action: 'vkzr_get_similar_ranking',
                uuiduser: uuiduser_similar,
                idtop: idtop_similar,
            }
        })
        .done(function (response) {
            let data = JSON.parse(response);
            
            if(data.percent > 0){
                $({
                    counter_votes: 0
                }).animate({
                    counter_votes: data.percent
                }, {
                    duration: 1000,
                    easing: 'swing',
                    step: function () {
                        $('.similarpercent').text(Math.ceil(this.counter_votes));
                    }
                });
                $('.percentword').show();
            }
            else{
                $('.similarpercent').html("0 %");
            }
            if (data.nb_similar > 0) {
                if (data.nb_similar > 1) {
                    $('.similarcount').html(data.nb_similar + " podiums identiques au tien");
                }
                else {
                    $('.similarcount').html(data.nb_similar + " podium identique au tien");
                }
            }
        })
        .fail(function () {
            console.log('Impossible de connaître les Tops similaires');
        })
    }
});