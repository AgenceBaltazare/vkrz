$(document).ready(function ($) {

    let ajaxRunning = false;

    $(".star").hover(function() {
        position    = $(this).data('star');
        parentStar  = $(this).parent('.starchoice');
        parentStar.find($('.star')).each(function(){
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

        var starchoice   = $(this).data('star');

        parentStar       = $(this).parent('.starchoice');

        var id_t         = parentStar.data('id-top');

        parentStar.hide();

        $('.toshow-'+id_t).fadeIn();
        $('.toshow-'+id_t).find('.star_number').html(starchoice);

        if (!ajaxRunning) {
            ajaxRunning = true;
            $.ajax({
                method: "POST",
                url: vkrz_ajaxurl,
                data: {
                    action: 'vkzr_process_note',
                    id_top: parentStar.data('id-top'),
                    uuiduser: parentStar.data('uuiduser'),
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

        CommentForm    = $(this);
        CommentFormVal = $(this).find('.commentairezone').val();

        CommentForm.find('.commentairezone').hide();
        CommentForm.find('.tohidecta').hide();
        CommentForm.find('.merci').fadeIn();

        console.log($(this).data('id-top'));
        console.log($(this).data('uuiduser'));

        if (!ajaxRunning) {
            ajaxRunning = true;
            $.ajax({
                method: "POST",
                url: vkrz_ajaxurl,
                data: {
                    action: 'vkzr_process_commentaire_note',
                    id_top: $(this).data('id-top'),
                    uuiduser: $(this).data('uuiduser'),
                    commentaire_note : CommentFormVal
                }
            })
            .done(function (response) {
                $('.modal').delay(2500).modal('hide');
            })
            .always(function () {
                ajaxRunning = false;
            });
        }
    });
});