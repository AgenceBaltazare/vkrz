$(document).ready(function ($) {

    $(document).on('click', '.laucher_t', {}, function (e) {

        $(".top_started").show();
        $(".top_not_started").hide();

    });
});