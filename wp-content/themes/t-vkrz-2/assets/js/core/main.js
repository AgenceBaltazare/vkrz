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
});

$(window).on('load', function() {
    if (feather) {
        feather.replace({
            width: 14,
            height: 14
        });
    }
})