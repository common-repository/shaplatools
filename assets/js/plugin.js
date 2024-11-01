tinymce.PluginManager.add('shaplaShortcodes', function(editor, url) {

	editor.addCommand( 'shaplaPopup', function( ui, v ){
		var popup = v.identifier;

		// load thickbox
		tb_show( editor.getLang('shapla.insert'), ajaxurl + "?action=popup&popup=" + popup + "&width=" + 670 );
	});

	var menu_items = [
        { text: editor.getLang('shapla.media_elements'), menu: [
	        { text: editor.getLang('shapla.image'), onclick: function(e){ addPopup('image') } },
	        { text: editor.getLang('shapla.video'), onclick: function(e){ addPopup('video') } },
        ] },
        { onclick: function(e){ addPopup('widget_area') }, text: editor.getLang('shapla.widget_area') },
        { onclick: function(e){ addPopup('button') }, text: editor.getLang('shapla.button') },
        { onclick: function(e){ addPopup('columns') }, text: editor.getLang('shapla.columns') },
        { onclick: function(e){ addPopup('dropcap') }, text: editor.getLang('shapla.dropcap') },
        { onclick: function(e){ addPopup('tabs') }, text: editor.getLang('shapla.tabs') },
        { onclick: function(e){ addPopup('toggle') }, text: editor.getLang('shapla.toggle') },
        { onclick: function(e){ addPopup('icon') }, text: editor.getLang('shapla.icon') },
        { onclick: function(e){ addPopup('map') }, text: editor.getLang('shapla.map') }
    ];

    /**
     * Delete Widget area from object is Shapla Custom Sidebars is not active.
     *
     * @link https://wordpress.org/plugins/shapla-custom-sidebars/
     */
    var IsSCSActive = ( typeof ShaplaShortcodes !== 'undefined' && ShaplaShortcodes.is_scs_active === "1") ? true : false;

    if( !IsSCSActive ) {
    	delete menu_items[1];
    }

    editor.addButton('shaplaShortcodes', {
		icon: 'shaplatools',
		text: false,
		tooltip: editor.getLang('shapla.insert'),
		type: 'menubutton',
		menu: menu_items
	});

	function addPopup( shortcode ) {
		tinyMCE.activeEditor.execCommand( "shaplaPopup", false, {
			title: tinyMCE.activeEditor.getLang('shapla.insert'),
			identifier: shortcode
		});
	}
});
