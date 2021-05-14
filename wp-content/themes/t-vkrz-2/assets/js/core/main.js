jQuery.fn.equalHeights = function(){
    var max_height = 0;
    jQuery(this).each(function(){
        max_height = Math.max(jQuery(this).height(), max_height);
    });
    jQuery(this).each(function(){
        jQuery(this).height(max_height);
    });
};

jQuery(document).ready(function() {
    jQuery('.eh').equalHeights();
    jQuery('.eh2').equalHeights();
});

$(window).on('load', function() {
    if (feather) {
        feather.replace({
            width: 14,
            height: 14
        });
    }
});

$(window).scroll(function() {
    var scroll = $(window).scrollTop();
    if(scroll > 10) {
        $('.menu-user').addClass('opfull');
    } else {
        $('.menu-user').removeClass('opfull');
    }
});


$('.user-registration .ur-submit-button').mouseover(function() {
    $('.gif1').hide();
    $('.gif2').show().addClass('animate__tada');
});
$('.user-registration .ur-submit-button').mouseout(function() {
    $('.gif2').hide();
    $('.gif1').show();
});

$('.already-account').mouseover(function() {
    $('.gif1').hide();
    $('.gif3').show().addClass('animate__tada');
});
$('.already-account').mouseout(function() {
    $('.gif3').hide();
    $('.gif1').show();
});

