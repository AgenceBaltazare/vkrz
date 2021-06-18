$(document).ready(function ($) {

    let ajaxRunning = false;

    $(".star").hover(function() {
        position = $(this).data('star');
        $('.star').each(function(){
            if($(this).data('star') <= position){
                $(this).addClass('active');
            }
            else{
                $(this).removeClass('active');
            }
        });
    });

    $('.starchoice').mouseout(function(){
        $('.star').removeClass('active');
    });

    $(document).on('click', '.star', {}, function (e) {

        e.preventDefault();

        var starchoice = $(this).data('star');

        $('.starchoice').hide();
        $('.startchoicedone').fadeIn();
        $('.startchoicedone').find('.star_number').html(starchoice);

        if (!ajaxRunning) {
            ajaxRunning = true;
            $.ajax({
                method: "POST",
                url: vkrz_ajaxurl,
                data: {
                    action: 'vkzr_process_note',
                    id_tournament: $('.starchoice').data('id-tournament'),
                    uuiduser: $('.starchoice').data('uuiduser'),
                    star: starchoice
                }
            })
            .done(function (response) {

            })
            .always(function () {
                ajaxRunning = false;
            });
        }
    });

    $(document).on('submit', '.form-note', {}, function (e) {

        e.preventDefault();

        CommentForm = $('.form-note #commentairezone');

        var commentaire_note = $('.form-note #commentairezone').val();
        $('#commentairezone').hide();
        $('.merci').fadeIn();

        if (!ajaxRunning) {
            ajaxRunning = true;
            $.ajax({
                method: "POST",
                url: vkrz_ajaxurl,
                data: {
                    action: 'vkzr_process_commentaire_note',
                    id_tournament: $(this).data('id-tournament'),
                    uuiduser: $(this).data('uuiduser'),
                    commentaire_note : commentaire_note
                }
            })
            .done(function (response) {
                $('.modal').delay(1500).modal('hide');
            })
            .always(function () {
                ajaxRunning = false;
            });
        }
    });
});