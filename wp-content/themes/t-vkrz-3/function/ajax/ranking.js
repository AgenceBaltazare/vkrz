$(document).ready(function ($) {

    setInterval(getContendersRanking, 10000, topId);
    // const t = getContendersRanking(topId);

    function getContendersRanking(topId) {
        let previousRanking = [];
        $("[data-id]").each(function() {
            previousRanking[$(this).attr('data-id')] = $(this).find('.pointselo').attr('data-points');
        });

        $.ajax({
            method: 'POST',
            url: vkrz_ajaxurl,
            data: {
                action: 'vkzr_get_contenders_ranking',
                topId: topId,
            }
        })
            .done(function(response) {
                const data = JSON.parse(response);

                for (let place = 1; place <= data.length; place++) {
                    const placeSelector = $(`#ranking-${place}`);
                    const illustrationSelector = $(`#ranking-${place} .illu img`);
                    const titleSelector = $(`#ranking-${place} .ranking-title`);
                    const pointsSelector = $(`#ranking-${place} .pointselo`);

                    const newId = data[place - 1].id;
                    const newIllustration = data[place - 1].illustration;
                    const newTitle = data[place - 1].title;
                    const newPoints = Number(data[place - 1].points);

                    if (newId === Number(placeSelector.attr('data-id'))) {
                        const previousPoints = Number(previousRanking[placeSelector.attr('data-id')]);
                        pointsSelector.attr('data-points', newPoints);

                        if (previousPoints < newPoints) {
                            pointsSelector.html(`<i class="fas fa-caret-up"></i> ${newPoints} pts`);
                        } else if (previousPoints > newPoints) {
                            pointsSelector.html(`<i class="fas fa-caret-down"></i> ${newPoints} pts`);
                        } else if (previousPoints === newPoints) {
                            pointsSelector.find('.fas').remove();
                        }
                    } else {
                        const previousPoints = Number(previousRanking[newId]);

                        placeSelector.attr('data-id', newId)
                        illustrationSelector.attr('src', newIllustration);
                        titleSelector.html(newTitle);
                        pointsSelector.attr('data-points', newPoints);

                        if (previousPoints < newPoints) {
                            pointsSelector.html(`<i class="fas fa-angle-double-up"></i> ${newPoints} pts`);
                        } else if (previousPoints > newPoints) {
                            pointsSelector.html(`<i class="fas fa-angle-double-down"></i> ${newPoints} pts`);
                        }
                    }
                }
            })
            .fail(function() {
                console.log('Ranking is not up to date');
            })
    }
});