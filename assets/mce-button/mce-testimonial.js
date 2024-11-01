(function() {
	tinymce.PluginManager.add('shaplatools_testimonial_mce_button', function( editor, url ) {
		editor.addButton( 'shaplatools_testimonial_mce_button', {

            title : 'Add Shapla Testimonial',
			image : url + '/../img/icon-testimonials.svg',
			onclick: function() {
				editor.windowManager.open( {
					title: 'Insert Testimonial Shortcode',
					body: 
					[
						{
							type: 'textbox',
							name: 'posts_per_page',
							label: 'Testimonial per page',
							value: '-1'
						},
						{
							type: 'textbox',
							name: 'items_desktop',
							label: 'Items Desktop',
							value: '4'
						},
						{
							type: 'textbox',
							name: 'items_tablet',
							label: 'Items Tablet',
							value: '3'
						},
						{
							type: 'textbox',
							name: 'items_tablet_small',
							label: 'Items Small Tablet',
							value: '2'
						},
						{
							type: 'textbox',
							name: 'items_mobile',
							label: 'Items Mobile',
							value: '1'
						}
					],
					onsubmit: function( e ) {
						editor.insertContent( '[shapla_testimonial posts_per_page="' + e.data.posts_per_page + '" items_desktop="' + e.data.items_desktop + '" items_tablet="' + e.data.items_tablet + '" items_tablet_small="' + e.data.items_tablet_small + '" items_mobile="' + e.data.items_mobile + '"]');
						}
					}
				);
			}

		});
	});
})();