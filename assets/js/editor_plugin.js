(function(){
	tinymce.create( "tinymce.plugins.shaplaShortcodes", {

		init: function ( d, e ) {
			d.addCommand("shaplaPopup", function( a, params){
				var popup = params.identifier;

				// load thickbox
				tb_show("Insert Shapla Shortcode", ajaxurl + "?action=popup&popup=" + popup + "&width=" + 670 );
			});
		},

		createControl: function( d, e ){
			var ed = tinymce.activeEditor,
				IsSCSActive = ( typeof ShaplaShortcodes !== 'undefined' && ShaplaShortcodes.is_scs_active === "1") ? true : false;

			if( d === "shaplaShortcodes" ){
				d = e.createMenuButton( "shaplaShortcodes", {
					title: ed.getLang('shapla.insert'),
					icons: false
				});

				var a = this;
				d.onRenderMenu.add( function( c, b ) {

					c = b.addMenu( { title:ed.getLang('shapla.media_elements') } );
						a.addWithPopup( c, ed.getLang('shapla.image'), "image" );
						a.addWithPopup( c, ed.getLang('shapla.video'), "video" );

					if(IsSCSActive){
						a.addWithPopup( b, ed.getLang('shapla.widget_area'), "widget_area" );
					}

					b.addSeparator();

					a.addWithPopup( b, ed.getLang('shapla.button'), "button" );
					a.addWithPopup( b, ed.getLang('shapla.columns'), "columns" );
					a.addWithPopup( b, ed.getLang('shapla.dropcap'), "dropcap" );
					a.addWithPopup( b, ed.getLang('shapla.tabs'), "tabs" );
					a.addWithPopup( b, ed.getLang('shapla.toggle'), "toggle" );
					a.addWithPopup( b, ed.getLang('shapla.icon'), "icon" );
					a.addWithPopup( b, ed.getLang('shapla.map'), "map" );

				});

				return d;

			}
			return null;
		},

		addWithPopup: function (d, e, a){
			d.add({
				title: e,
				onclick: function() {
					tinyMCE.activeEditor.execCommand( "shaplaPopup", false, {
						title: e,
						identifier: a
					})
				}
			});
		},

		addImmediate:function(d,e,a){
			d.add({
				title:e,
				onclick:function(){
					tinyMCE.activeEditor.execCommand( "mceInsertContent",false,a)
				}
			})
		}

	});

	tinymce.PluginManager.add( "shaplaShortcodes", tinymce.plugins.shaplaShortcodes);

})();
