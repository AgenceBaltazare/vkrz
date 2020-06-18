$(document).ready(function ($) {
    let contenders = $('.display_battle .link-contender');
    let ajaxRunning = false;

    //Init first contenders
    contenders.find('a').addClass('entering')
    //console.log(contenders)
    $("body").keydown(function (e) {
        return
        e.preventDefault();
        if (e.keyCode === 37) { // left
            $("#c_1").trigger("click");
        } else if (e.keyCode === 39) { // right
            $("#c_2").trigger("click");
        }
    });

    $(document).on('click', '.display_battle .link-contender', {}, function (e) {
        e.preventDefault();

        if (!ajaxRunning) {
            ajaxRunning = true;
            if ($(this).find('a').attr('id') === "c_1") {
                $("#c_1").addClass('vainkeurz');
                $("#c_2").addClass('leaving');
            } else if ($(this).find('a').attr('id') === "c_2") {
                $("#c_2").addClass('vainkeurz');
                $("#c_1").addClass('leaving');
            }
            //contenders.find('a').addClass('leaving');
            $.ajax({
                method: "POST",
                url: vkrz_ajaxurl,
                data: {
                    action: 'vkzr_process_vote',
                    id_tournament: $(this).find('a').data('id-tournament'),
                    id_winner: $(this).find('a').data('id-winner'),
                    id_looser: $(this).find('a').data('id-looser')
                }
            })
                .done(function (response) {
                    let data = JSON.parse(response)
                    $('.display_battle').html(data.contenders_html);
                    contenders = $('.display_battle .link-contender');
                    contenders.find('a').addClass('entering')

                    $('.stepbar').replaceWith(data.stepbar_html)
                    $('.display_users_votes h6').replaceWith(data.uservotes_html)

                    if(!data.is_next_duel)
                        location.reload()

                }).always(function () {
                ajaxRunning = false;
            });
        }
    })
});
