(function($){

	"use strict";

	$(document).ready(function(){
		$(".shapla-tabs").tabs({
			hide: { effect: "fadeOut", duration: 200 },
			show: { effect: "fadeIn", duration: 200 }
		});

		$(".shapla-toggle").each( function () {
			if($(this).attr('data-id') == 'closed') {
				$(this).accordion({ header: '.shapla-toggle-title', collapsible: true, heightStyle: "content", active: false });
			} else {
				$(this).accordion({ header: '.shapla-toggle-title', collapsible: true, heightStyle: "content" });
			}
		});
	});

})(jQuery);
