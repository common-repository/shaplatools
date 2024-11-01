(function() {
	tinymce.PluginManager.add('shaplatools_portfolio_mce_button', function( editor, url ) {
		editor.addButton( 'shaplatools_portfolio_mce_button', {

            title : 'Add Shapla Portfolio',
			image : url + '/../img/icon-portfolio.svg',
			onclick: function() {
				editor.windowManager.open( {
					title: 'Insert Portfolio Shortcode',
					body: 
					[
						{
							type: 'listbox',
							name: 'thumbnail',
							label: 'Thumbnail per row',
								'values': [
									{text: 'Show 2 thumbnail per row', value: 'm6'},
									{text: 'Show 3 thumbnail per row', value: 'm4'},
									{text: 'Show 4 thumbnail per row', value: 'm3'}
								]
						},
						{
							type: 'textbox',
							name: 'thumbnail_size',
							label: 'Portfolio Image Size Name',
							value: 'full'
						}
					],
					onsubmit: function( e ) {
						editor.insertContent( '[shapla_portfolio thumbnail="' + e.data.thumbnail + '" thumbnail_size="' + e.data.thumbnail_size + '"]');
						}
					}
				);
			}

		});
	});
})();