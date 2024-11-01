(function(tinymce) {
	tinymce.PluginManager.add('shaplatools_mce_hr_button', function( editor, url ) {
		editor.addButton('shaplatools_mce_hr_button', {
			icon: 'hr',
			tooltip: 'Horizontal line',
			onclick: function() {
				editor.windowManager.open( {
					title: 'Insert Horizontal Line',
					body: [
						{
							type: 'listbox',
							name: 'hr',
							label: 'Style',
							values: [
								{
									text: 'Plain',
									value: 'shapla-divider--plain'
								},
								{
									text: 'Strong',
									value: 'shapla-divider--strong'
								},
								{
									text: 'Double',
									value: 'shapla-divider--double'
								},
								{
									text: 'Dashed',
									value: 'shapla-divider--dashed'
								},
								{
									text: 'Dotted',
									value: 'shapla-divider--dotted'
								}
							]
						}
					],
					onsubmit: function( e ) {
						editor.insertContent( '<hr class="shapla-divider ' + e.data.hr + '" />');
					}
				});
			}
		});
	});
})(tinymce);
