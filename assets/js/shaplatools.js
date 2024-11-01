(function($){
    "use strict";

    $(document).ready(function(){

        /* initialize typeahead plugin */
        if( $().typeahead ){
            var shaplaToolsSearch = new Bloodhound({
                datumTokenizer: Bloodhound.tokenizers.obj.whitespace('value'),
                queryTokenizer: Bloodhound.tokenizers.whitespace,
                remote: {
                    url: shaplatools.ajaxurl + '?action=shapla_search&_wpnonce=' + shaplatools.nonce + '&terms=%QUERY',
                    wildcard: '%QUERY'
                }
            });
            shaplaToolsSearch.initialize();

            $( 'input[name="s"]' ).typeahead({
                hint: true,
                highlight: true,
                minLength: 2
            },{
                name: 's',
                display: 'value',
                source: shaplaToolsSearch.ttAdapter(),

            }).on('typeahead:selected', function(e, data) {
                if ( data.url !== null ) {
                    window.location = data.url;
                }
            });
        }
        /* close typeahead plugin */
        
        /* initialize shuffle plugin */
        if( $().shuffle ){

            var $grid = $('#grid');

            $grid.shuffle({
                itemSelector: '.item', // the selector for the items in the grid
                speed: 500,
            });

            /* reshuffle when user clicks a filter item */
            $('#filter a').click(function (e) {
                e.preventDefault();

                // set active class
                $('#filter a').removeClass('active');
                $(this).addClass('active');

                // get group name from clicked item
                var groupName = $(this).attr('data-group');

                // reshuffle grid
                $grid.shuffle('shuffle', groupName );
            });
        }
        /* close shuffle plugin */
    });
})(jQuery);