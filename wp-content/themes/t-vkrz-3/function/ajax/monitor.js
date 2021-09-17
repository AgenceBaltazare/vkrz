$(document).ready(function ($) {

    let ajaxRunning = false;
    let count_votes = total_vkrz_votes;
    let count_tops  = total_vkrz_tops;
    let newCountVotes = 0;
    let newCountTops  = 0;
    const $votes_number = $('#votes_number');
    const $tops_number  = $('#tops_number');

    function updateVotesCount(newCountVotes) {
        $({ 
            counter_votes: count_votes
        }).animate({ 
            counter_votes: newCountVotes
        }, {
            duration: 1000,
            easing: 'swing',
            step: function() {
                $votes_number.text(Math.ceil(this.counter_votes));
            },
            complete: function() {
                count_votes = newCountVotes;
            }
        });
    }

    function updateTopsCount(newCountTops) {

        $({ 
            counter_tops: count_tops
        }).animate({ 
            counter_tops: newCountTops
        }, {
            duration: 1000,
            easing: 'swing',
            step: function() {
                $tops_number.text(Math.ceil(this.counter_tops));
            },
            complete: function() {
                count_tops = newCountTops;
            }
        });
        if(newCountTops == 30000){
            location.reload();
        }
    }

    function getDataCount() {

        if (!ajaxRunning) {
            ajaxRunning = true;

            $.ajax({
                method: "POST",
                url: vkrz_ajaxurl,
                data: {
                    action: 'vkzr_get_monitor_data',
                }
            })
            .done(function (response) {
                let data = JSON.parse(response);
                newCountVotes = Number(data.total_vkrz_votes);
                if (count_votes !== newCountVotes) { 
                    updateVotesCount(newCountVotes);
                }
                newCountTops = Number(data.total_vkrz_tops);
                if (count_tops !== newCountTops) { 
                    updateTopsCount(newCountTops);
                }
            })
            .always(function() {
                ajaxRunning = false;
            });
        }
    }

    // Execute getPlayerCount every 2.5 seconds.
    setInterval(getDataCount, 2500);

});