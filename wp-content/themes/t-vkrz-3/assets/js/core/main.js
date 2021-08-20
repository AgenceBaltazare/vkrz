$.fn.equalHeights = function(){
    var max_height = 0;
    $(this).each(function(){
        max_height = Math.max($(this).height(), max_height);
    });
    $(this).each(function(){
        $(this).height(max_height);
    });
};


$(document).ready(function() {

    $('.eh').equalHeights();
    $('.eh2').equalHeights();
    $('.ico-master').equalHeights();
    $('.same-h').equalHeights();

    $('.kick').on('click', function() {
        var newTXT = $(this).data('kick');
        $(this).html(newTXT);
    });

    // Show sidebar
    $('.result-toggler a').on('click', function () {
        $('.filtres-bloc').toggleClass('show');
        $('.ico-filtreshow').toggleClass('hide');
        $('.ico-filtrehide').toggleClass('show');
    });

    var buttonFilters = {};
    var buttonFilter;
    var qsRegex;


    var $grid = $('.grid-to-filtre').isotope({
        itemSelector: '.grid-item',
        layoutMode: 'fitRows',
        filter: function() {
            var $this = $(this);
            var searchResult = qsRegex ? $this.text().match( qsRegex ) : true;
            var buttonResult = buttonFilter ? $this.is( buttonFilter ) : true;
            return searchResult && buttonResult;
          },
    });

    $('.btn-to-filtre').on('click', function() {

        var $this = $(this);
        // get group key
        var $buttonGroup = $this.parents('.button-group');
        var filterGroup = $buttonGroup.attr('data-filter-group');
        // set filter for group
        buttonFilters[ filterGroup ] = $this.attr('data-filter');
        // combine filters
        buttonFilter = concatValues( buttonFilters );
        // Isotope arrange
        $grid.isotope();

    });

    // use value of search field to filter
    var $quicksearch = $('#search_form input').keyup( debounce( function() {
        qsRegex = new RegExp( $quicksearch.val(), 'gi' );
        $grid.isotope();
        if($quicksearch.val() != ""){
            $('.ico-search-result').hide();
            $('.ico-search-clear').show();
        }
        else{
            $('.ico-search-result').show();
            $('.ico-search-clear').hide();
        }
    }) );
  
    $('.ico-search-clear').on('click', function(){
        $('#search_form input').val('');
        $('.ico-search-result').show();
        $('.ico-search-clear').hide();
        qsRegex = new RegExp('', 'gi' );
        $grid.isotope();
    });

    // change is-checked class on buttons
    $('.button-group').each( function( i, buttonGroup ) {
        var $buttonGroup = $( buttonGroup );
        $buttonGroup.on( 'click', 'button', function() {
        $buttonGroup.find('.is-checked').removeClass('is-checked');
        $( this ).addClass('is-checked');
        });
    });
        
    // flatten object by concatting values
    function concatValues( obj ) {
        var value = '';
        for ( var prop in obj ) {
        value += obj[ prop ];
        }
        return value;
    }
    
    // debounce so filtering doesn't happen every millisecond
    function debounce( fn, threshold ) {
        var timeout;
        threshold = threshold || 100;
        return function debounced() {
        clearTimeout( timeout );
        var args = arguments;
        var _this = this;
        function delayed() {
            fn.apply( _this, args );
        }
        timeout = setTimeout( delayed, threshold );
        };
    }
  
});

$(window).on('load', function() {
    if (feather) {
        feather.replace({
            width: 14,
            height: 14
        });
    }
});

window.onload=function() {

    var copyBtn = document.querySelector('.sharelinkbtn');
    if(copyBtn){
        copyBtn.addEventListener('click', function (event) {
            var copyInput = copyBtn.querySelector('.input_to_share');
            copyInput.focus();
            copyInput.select();
            try {
                var successful = document.execCommand('copy');
                var msg = successful ? 'successful' : 'unsuccessful';
                copyBtn.innerHTML = "Copié !";
            } catch (err) {
                console.log('Oops, unable to copy');
            }
        });
    }

    var copyBtn2 = document.querySelector('.sharelinkbtn2');
    if(copyBtn2){
        copyBtn2.addEventListener('click', function (event) {
            var copyInput = copyBtn2.querySelector('.input_to_share2');
            copyInput.focus();
            copyInput.select();
            try {
                var successful = document.execCommand('copy');
                var msg = successful ? 'successful' : 'unsuccessful';
                copyBtn2.innerHTML = "Copié !";
            } catch (err) {
                console.log('Oops, unable to copy');
            }
        });
    }

};


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


/**
 * TRACKING
 */

jQuery(document).ready(function ($){

    window.dataLayer.push({
        'event': 'track_event',
        'event_name': 'page_view',
        'event_score': 1,
        'page_title': vkrz_tracking_vars_current_page.page_title,
        'categorie' : vkrz_tracking_vars_current_page.page_category
    })


    $('.main-menu .nav-item .rs-menu a').click(function (e){
        const rs_name = $(this).data('rs-name');
        window.dataLayer.push({
            'event': 'track_event',
            'event_name': 'click_social',
            'event_score': 1,
            'rs_name' : rs_name,
            'user_id': vkrz_tracking_vars_user.id_user_layer,
            'user_uuid': vkrz_tracking_vars_user.uuiduser_layer,
            'page_title': vkrz_tracking_vars_current_page.page_title
        })
    })

    $('.card-body .share-t a').click(function (e){
        const rs_name = $(this).attr('title');
        window.dataLayer.push({
            'event': 'track_event',
            'event_name': 'share_top',
            'event_score': 20,
            'rs_name' : rs_name,
            'user_id': vkrz_tracking_vars_user.id_user_layer,
            'user_uuid': vkrz_tracking_vars_user.uuiduser_layer,
            'page_title': vkrz_tracking_vars_current_page.page_title
        })
    })
})