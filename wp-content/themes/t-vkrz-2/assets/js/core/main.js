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
    jQuery('.ico-master').equalHeights();
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

    if($(window).scrollTop() + $(window).height() == $(document).height()) {
        $('.nav-tournament, .stepbar').addClass('disapear');
    }
    else{
        $('.nav-tournament, .stepbar').removeClass('disapear');
    }
});

$('#wppb-register-user-sign-in #register').mouseover(function() {
    $('.gif1').hide();
    $('.gif2').show().addClass('animate__tada');
});
$('#wppb-register-user-sign-in #register').mouseout(function() {
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

$('.user-registration-LostPassword').mouseover(function() {
    $('.gif1').hide();
    $('.gif4').show().addClass('animate__tada');
});
$('.user-registration-LostPassword').mouseout(function() {
    $('.gif4').hide();
    $('.gif1').show();
});

function copyToClipboard(text) {
    var inputc = document.body.appendChild(document.createElement("input"));
    inputc.value = window.location.href;
    inputc.focus();
    inputc.select();
    document.execCommand('copy');
    inputc.parentNode.removeChild(inputc);
    alert("URL Copied.");
}