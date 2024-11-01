<?php
if( ! class_exists('Shaplatools_Components_Shortcode')):

class Shaplatools_Components_Shortcode {

	private $plugin_path;
	private $plugin_name;
	private $options;

	public function __construct( $plugin_name, $plugin_path, $options )
	{
		$this->plugin_name = $plugin_name;
		$this->plugin_path = $plugin_path;
		$this->options = $options;

		add_shortcode( 'shapla_button', array( $this, 'shapla_button' ) );
		add_shortcode( 'shapla_icon', array( $this, 'shapla_icon' ) );
		add_shortcode( 'shapla_social', array( $this, 'shapla_social' ) );
		add_shortcode( 'shapla_map', array( $this, 'shapla_map' ) );
		add_shortcode( 'shapla_video', array( $this, 'shapla_video' ) );
		add_shortcode( 'shapla_image', array( $this, 'shapla_image' ) );
		add_shortcode( 'shapla_dropcap', array( $this, 'shapla_dropcap' ) );
		add_shortcode( 'shapla_toggle', array( $this, 'shapla_toggle' ) );
		add_shortcode( 'shapla_tabs', array( $this, 'shapla_tabs' ) );
		add_shortcode( 'shapla_tab', array( $this, 'shapla_tab' ) );
	}

	/**
	 * Shapla button
	 */
	public function shapla_button( $atts, $content = null )
	{
		$args = shortcode_atts( array(
			'url'        => '#',
			'target'     => '_self',
			'style'      => 'grey',
			'size'       => 'small',
			'type'       => 'round',
			'icon'       => '',
			'icon_order' => 'before',
		), $atts, 'purchase_link' );

		$button_icon = '';
		$class       = " shapla-button--{$args['size']}";
		$class       .= " shapla-button--{$args['style']}";
		$class       .= " shapla-button--{$args['type']}";

		if ( ! empty( $args['icon'] ) ) {
			if ( $args['icon_order'] == 'before' ) {
				$button_content = $this->shapla_icon( array( 'icon' => $args['icon'] ) );
				$button_content .= do_shortcode( $content );
			} else {
				$button_content = do_shortcode( $content );
				$button_content .= $this->shapla_icon( array( 'icon' => $args['icon'] ) );
			}
			$class .= " shapla-icon--{$args['icon_order']}";
		} else {
			$button_content = do_shortcode( $content );
		}

		return '<a target="'. esc_attr( $args['target'] ) .'" href="'. esc_url( $args['url'] ) .'" class="shapla-button'. esc_attr( $class ) .'">'. $button_content .'</a>';
	}

	/**
	 * FontAwesome Icon shortcode.
	 */
	public function shapla_icon( $atts, $content = null ) {
		$args = shortcode_atts( array(
			'icon'       => '',
			'url'        => '',
			'size'       => '',
			'new_window' => 'no',
		), $atts, 'shapla_icon' );

		$new_window = ( $args['new_window'] == 'no' ) ? '_self' : '_blank';

		$size = esc_attr( $args['size'] );

		$output = '';
		$attrs  = '';

		if ( ! empty( $args['url'] ) ) {
			$a_attrs = ' href="'. esc_url( $args['url'] ) .'" target="'. esc_attr( $new_window ) .'"';
		}

		if ( ! empty( $size ) ) {
			$attrs .= ' style="font-size:'. $size .';line-height:'. $size .'"';
		}

		if ( $args['url'] != '' ){
			$output .= '<a class="shapla-icon-link" '. $a_attrs .'><i class="fa fa-'. esc_attr( $args['icon'] ) .'" '. $attrs .'></i></a>';
		} else {
			$output .= '<i class="fa fa-'. esc_attr( $args['icon'] ) .'" '. $attrs .'></i>';
		}

		return $output;
	}

	/**
	 * Social shortcode.
	 * Display links to social profiles.
	 *
	 * @since 1.0.0
	 */
	public function shapla_social( $atts ) {
		$args = shortcode_atts( array(
			'id'    => 'all',
			'style' => 'normal',
		), $atts, 'shapla_social' );

		global $shapla_social_link;
		$new_link = array();

		foreach ($shapla_social_link as $link) {
			$new_link[] = $link['id'];
		}

		$social_urls         = $new_link;
		$settings            = get_option( 'shaplatools_options' );
		$output              = '<div class="shapla-social-icons '. esc_attr( $args['style'] ) .'">';

		if ( $args['id'] == '' || $args['id'] == 'all' ) {
			$social_ids = $social_urls;
		} else {
			$social_ids = explode( ',', $args['id'] );
		}

		foreach ( $social_ids as $slug ) {
			$slug = trim( $slug );
			if ( isset( $settings[$slug] ) && $settings[$slug] != '' ) {
				$class = $slug;

				if ( 'mail' == $slug ) $class = 'envelope';
				if ( 'vimeo' == $slug ) $class = 'vimeo-square';

				$output .= "<a href='". esc_url( $settings[$slug] ) ."' target='_blank'><i class='fa fa-". esc_attr( $class ) ."'></i></a>";
			}
		}
		$output .= '</div>';

		return $output;

	}

	/**
	 * Google Map Shortcode
	 *
	 * @since 1.0.0
	 */
	public function shapla_map( $atts ) {
		$args = shortcode_atts( array(
			'lat'    => '37.42200',
			'long'   => '-122.08395',
			'width'  => '100%',
			'height' => '350px',
			'zoom'   => 15,
			'style'  => 'none',
			'type'   => 'roadmap',
		), $atts, 'shapla_map' );

		$map_styles = array(
			'none'             => '[]',
			'mixed'            => '[{"featureType":"landscape","stylers":[{"hue":"#00dd00"}]},{"featureType":"road","stylers":[{"hue":"#dd0000"}]},{"featureType":"water","stylers":[{"hue":"#000040"}]},{"featureType":"poi.park","stylers":[{"visibility":"off"}]},{"featureType":"road.arterial","stylers":[{"hue":"#ffff00"}]},{"featureType":"road.local","stylers":[{"visibility":"off"}]}]',
			'pale_dawn'        => '[{"featureType":"landscape","stylers":[{"saturation":-100},{"lightness":65},{"visibility":"on"}]},{"featureType":"poi","stylers":[{"saturation":-100},{"lightness":51},{"visibility":"simplified"}]},{"featureType":"road.highway","stylers":[{"saturation":-100},{"visibility":"simplified"}]},{"featureType":"road.arterial","stylers":[{"saturation":-100},{"lightness":30},{"visibility":"on"}]},{"featureType":"road.local","stylers":[{"saturation":-100},{"lightness":40},{"visibility":"on"}]},{"featureType":"transit","stylers":[{"saturation":-100},{"visibility":"simplified"}]},{"featureType":"administrative.province","stylers":[{"visibility":"off"}]},{"featureType":"water","elementType":"labels","stylers":[{"visibility":"on"},{"lightness":-25},{"saturation":-100}]},{"featureType":"water","elementType":"geometry","stylers":[{"hue":"#ffff00"},{"lightness":-25},{"saturation":-97}]}]',
			'greyscale'        => '[{"featureType":"all","stylers":[{"saturation":-100},{"gamma":0.5}]}]',
			'bright_bubbly'    => '[{"featureType":"water","stylers":[{"color":"#19a0d8"}]},{"featureType":"administrative","elementType":"labels.text.stroke","stylers":[{"color":"#ffffff"},{"weight":6}]},{"featureType":"administrative","elementType":"labels.text.fill","stylers":[{"color":"#e85113"}]},{"featureType":"road.highway","elementType":"geometry.stroke","stylers":[{"color":"#efe9e4"},{"lightness":-40}]},{"featureType":"road.arterial","elementType":"geometry.stroke","stylers":[{"color":"#efe9e4"},{"lightness":-20}]},{"featureType":"road","elementType":"labels.text.stroke","stylers":[{"lightness":100}]},{"featureType":"road","elementType":"labels.text.fill","stylers":[{"lightness":-100}]},{"featureType":"road.highway","elementType":"labels.icon"},{"featureType":"landscape","elementType":"labels","stylers":[{"visibility":"off"}]},{"featureType":"landscape","stylers":[{"lightness":20},{"color":"#efe9e4"}]},{"featureType":"landscape.man_made","stylers":[{"visibility":"off"}]},{"featureType":"water","elementType":"labels.text.stroke","stylers":[{"lightness":100}]},{"featureType":"water","elementType":"labels.text.fill","stylers":[{"lightness":-100}]},{"featureType":"poi","elementType":"labels.text.fill","stylers":[{"hue":"#11ff00"}]},{"featureType":"poi","elementType":"labels.text.stroke","stylers":[{"lightness":100}]},{"featureType":"poi","elementType":"labels.icon","stylers":[{"hue":"#4cff00"},{"saturation":58}]},{"featureType":"poi","elementType":"geometry","stylers":[{"visibility":"on"},{"color":"#f0e4d3"}]},{"featureType":"road.highway","elementType":"geometry.fill","stylers":[{"color":"#efe9e4"},{"lightness":-25}]},{"featureType":"road.arterial","elementType":"geometry.fill","stylers":[{"color":"#efe9e4"},{"lightness":-10}]},{"featureType":"poi","elementType":"labels","stylers":[{"visibility":"simplified"}]}]',
			'subtle_grayscale' => '[{"featureType":"landscape","stylers":[{"saturation":-100},{"lightness":65},{"visibility":"on"}]},{"featureType":"poi","stylers":[{"saturation":-100},{"lightness":51},{"visibility":"simplified"}]},{"featureType":"road.highway","stylers":[{"saturation":-100},{"visibility":"simplified"}]},{"featureType":"road.arterial","stylers":[{"saturation":-100},{"lightness":30},{"visibility":"on"}]},{"featureType":"road.local","stylers":[{"saturation":-100},{"lightness":40},{"visibility":"on"}]},{"featureType":"transit","stylers":[{"saturation":-100},{"visibility":"simplified"}]},{"featureType":"administrative.province","stylers":[{"visibility":"off"}]},{"featureType":"water","elementType":"labels","stylers":[{"visibility":"on"},{"lightness":-25},{"saturation":-100}]},{"featureType":"water","elementType":"geometry","stylers":[{"hue":"#ffff00"},{"lightness":-25},{"saturation":-97}]}]',
		);

		$map_id = 'map-'. uniqid();

		$shapla_options = get_option( 'shaplatools_options' );
		$api_key = ( isset( $shapla_options[ 'google_map_api_key' ] ) ) ? $shapla_options[ 'google_map_api_key' ] : '';

		if ( '' != $api_key ) {
			wp_enqueue_script( 'google-maps', add_query_arg( 'key', $api_key, 'https://maps.googleapis.com/maps/api/js' ), array('jquery') );
		} else {
			if ( current_user_can( 'edit_posts' ) ) :
				echo '<p class="shapla-alert shapla-red">';

					/* translators: %s is a link, do not remove/modify it. */
					echo sprintf( esc_html__( 'To be able to use Google Maps, you first need to set an %s.', 'shaplatools' ),
						sprintf( '<a href="' . admin_url( 'options-general.php?page=shaplatools' ) . '">%1$s</a>', esc_html__( 'API key', 'shaplatools' ) )
					);
				echo '</p>';
			endif;

			return;
		}

		?>

		<script type="text/javascript">
		    jQuery(window).load(function(){
		    	var Shaplatools = {};

		    	Shaplatools.Map = ( function($) {
		    		function setupMap(options) {
		    			var mapOptions, mapElement, map, marker;

		    			if ( typeof google === 'undefined' ) return;

		    			mapOptions = {
		    				zoom: parseFloat(options.zoom),
		    				center: new google.maps.LatLng(options.center.lat, options.center.long),
		    				scrollwheel: false,
		    				styles: options.styles
		    			};

		    			mapElement = document.getElementById(options.id);
		    		 	map = new google.maps.Map(mapElement, mapOptions);

		    			marker = new google.maps.Marker({
		    				position: new google.maps.LatLng(options.center.lat, options.center.long),
		    				map: map
		    			});
		    		}
		    		return {
		    			init: function(options) {
		    				setupMap(options);
		    			}
		    		}
		    	} )(jQuery);

	    	    var options = {
	    	    	id: "<?php echo esc_js( $map_id ); ?>",
	    	    	styles: <?php echo $map_styles[$args['style']]; ?>,
	    	    	zoom: <?php echo esc_js( $args['zoom'] ); ?>,
					mapTypeId: google.maps.MapTypeId.<?php echo esc_js( strtoupper( $args['type'] ) ); ?>,
	    	    	center: {
	    	    		lat: "<?php echo esc_js( $args['lat'] ); ?>",
	    	    		long: "<?php echo esc_js( $args['long'] ); ?>"
	    	    	}
	    	    };

	    	    Shaplatools.Map.init(options);
		    });
		</script>

		<?php

		return '<section id="'. esc_attr( $map_id ) .'" class="shapla-section google-map" style="width:'. esc_attr( $args['width'] ) .';height:'. esc_attr( $args['height'] ) .'"></section>';
	}

	public function shapla_video( $atts, $content = null ) {
		$args = shortcode_atts( array(
			'src' => '',
		), $atts, 'shapla_video' );

		return '<div class="shapla-section shapla-video">' . $GLOBALS['wp_embed']->run_shortcode( '[embed]'. esc_url( $args['src'] ) .'[/embed]' ) . '</div>';
	}

	public function shapla_image( $atts, $content = null ) {
		$args = shortcode_atts( array(
			'style'     => 'grayscale',
			'alignment' => 'none',
			'src'       => '',
			'url'       => '',
		), $atts, 'shapla_image' );

		$output = '<figure class="shapla-section shapla-image shapla-image--' . esc_attr( $args['style'] ) . ' shapla-image--' . esc_attr( $args['alignment'] ) . '">';

		if ( $args['url'] != '' ) {
			$output .= '<a href="' . esc_url( $args['url'] ) . '"><img src="' . esc_url( $args['src'] ) . '" alt=""></a>';
		} else {
			$output .= '<img src="' . esc_url( $args['src'] ) . '" alt="">';
		}

		$output .= '</figure>';

		return $output;
	}

	public function shapla_toggle( $atts, $content = null ) {
		$args = shortcode_atts( array(
			'title' => __( 'Title Goes Here', 'shaplatools' ),
			'state' => 'open',
			'style' => 'normal',
		), $atts, 'shapla_toggle' );

		wp_enqueue_script( 'shapla-shortcode-scripts' );

		return '<div data-id="' . esc_attr( $args['state'] ) . '" class="shapla-section shapla-toggle shapla-toggle--' . esc_attr( $args['style'] ) . '"><span class="shapla-toggle-title">' . esc_html( $args['title'] ) . '</span><div class="shapla-toggle-inner"><div class="shapla-toggle-content">' . do_shortcode( $content ) . '</div></div></div>';
	}

	public function shapla_dropcap( $atts, $content = null ) {
		$args = shortcode_atts( array(
			'style'     => 'normal',
			'font_size' => '50px',
		), $atts, 'shapla_dropcap' );

		return '<span class="shapla-dropcap shapla-dropcap--' . esc_attr( $args['style'] ) . '" style="font-size:' . esc_attr( $args['font_size'] ) . ';line-height:' . esc_attr( $args['font_size'] ) . ';width:' . esc_attr( $args['font_size'] ) . ';height:' . esc_attr( $args['font_size'] ) . ';">' . do_shortcode( $content ) . '</span>';
	}

	/**
	 * Shortcode for tabs.
	 */
	function shapla_tabs( $atts, $content = null ) {
		$args = shortcode_atts( array(
			'style' => 'normal',
		), $atts, 'shapla_tabs' );

		wp_enqueue_script( 'shapla-shortcode-scripts' );

		preg_match_all( '/tab title="([^\"]+)"/i', $content, $matches, PREG_OFFSET_CAPTURE );

		$tab_titles = array();
	    if ( isset($matches[1]) ) {
	    	$tab_titles = $matches[1];
	    }

	    $output = '';

	    if ( count( $tab_titles ) ) {
	    	$output .= '<section id="shapla-tabs-'. rand( 1, 100 ) .'" class="shapla-section shapla-tabs shapla-tabs--'. esc_attr( $args['style'] ) .'"><div class="shapla-tab-inner">';
	    	$output .= '<ul class="shapla-nav shapla-clearfix">';

	    	foreach ( $tab_titles as $tab ) {
	    		$output .= '<li><a href="#shapla-tab-'. sanitize_title( $tab[0] ) .'">' . $tab[0] . '</a></li>';
	    	}

	    	$output .= '</ul>';
	    	$output .= do_shortcode( $content );
	    	$output .= '</div></section>';
	    } else {
	    	$output .= do_shortcode( $content );
	    }
	    return $output;
	}

	function shapla_tab( $atts, $content = null ) {
		$args = shortcode_atts( array(
			'title' => __( 'Tab', 'shaplatools' )
		), $atts, 'shapla_tab' );

		return '<div id="shapla-tab-'. sanitize_title( $args['title'] ) .'" class="shapla-tab">'. do_shortcode( $content ) .'</div>';
	}
}

endif;