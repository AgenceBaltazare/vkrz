$(document).ready(function () {
    const seen_events = [];
    setInterval(function () {
        $.ajax({
            method: "POST",
            url: vkrz_ajaxurl,
            data: {
                action: 'vkzr_fetch_events',
            }
        }).done(function (response) {
                const data = JSON.parse(response);

                if(data.events && data.events.length){
                    for(const ev of data.events){
                        presentEvent(ev)
                    }
                }
            });
    }, 2000);

    function presentEvent(ev){
        if(!seen_events.includes(ev.id)){
            seen_events.push(ev.id);
            toastr[ev.type](ev.message,
                ev.title, {
                    closeButton: true,
                    tapToDismiss: true,
                    timeOut: 4000,
                    progressBar: true,
                    showMethod: 'slideDown',
                    hideMethod: 'slideUp',
                    onHidden: function (){
                        $.ajax({
                            method: "POST",
                            url: vkrz_ajaxurl,
                            data: {
                                action: 'vkzr_remove_seen_event',
                                event_id : ev.id
                            }
                        })
                    }
                })
        }
    }
});


