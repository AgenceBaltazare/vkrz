$(document).ready(function() {

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