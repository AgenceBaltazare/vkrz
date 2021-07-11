$(document).ready(function ($) {

    $('.tags-list button').on('click', function() {

        var filtre          = $(this);
        var tag_to_filtre   = filtre.data('tag');

        $('.tags-list button').each(function(){
            $(this).removeClass('active_filtre');
        });

        filtre.addClass('active_filtre');

        $('.t-filtrable').each(function(){

            var filtre_value = $(this).data('concept');

            if(filtre_value == tag_to_filtre){

                $(this).show();

            }
            else{

                $(this).hide();

            }

        });

    });

});
