(function() {
	tinymce.PluginManager.add('shaplatools_team_mce_button', function( editor, url ) {
		editor.addButton( 'shaplatools_team_mce_button', {

            title : 'Add Shapla Team',
			image : url + '/../img/icon-team.svg',
			onclick: function() {
				editor.windowManager.open( {
					title: 'Insert Team Shortcode',
					body: 
					[
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
						editor.insertContent( '[shapla_team items_desktop="' + e.data.items_desktop + '" items_tablet="' + e.data.items_tablet + '" items_tablet_small="' + e.data.items_tablet_small + '" items_mobile="' + e.data.items_mobile + '"]');
						}
					}
				);
			}

		});
	});
})();