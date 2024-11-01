<?php
$shapla_shortcodes['columns'] = array(
	'params'      => array(),
	'shortcode'   => '[shapla_row_padding]{{child_shortcode}}[/shapla_row_padding]', // as there is no wrapper shortcode
	'popup_title' => __( 'Insert Columns Shortcode', 'shaplatools' ),
	'no_preview'  => true,

	// child shortcode is clonable & sortable
	'child_shortcode' => array(
		'params' => array(
			'column' => array(
				'type'    => 'select',
				'label'   => __( 'Column Grid', 'shaplatools' ),
				'desc'    => __( 'Select the grid, ie width of the column.', 'shaplatools' ),
				'options' => array(
					'shapla_col_one' 	=> __( 'One columns', 'shaplatools' ),
					'shapla_col_two' 	=> __( 'Two columns', 'shaplatools' ),
					'shapla_col_three' 	=> __( 'Three columns', 'shaplatools' ),
					'shapla_col_four' 	=> __( 'Four columns', 'shaplatools' ),
					'shapla_col_five' 	=> __( 'Five columns', 'shaplatools' ),
					'shapla_col_six' 	=> __( 'Six columns', 'shaplatools' ),
					'shapla_col_seven' 	=> __( 'Seven columns', 'shaplatools' ),
					'shapla_col_eight' 	=> __( 'Eight columns', 'shaplatools' ),
					'shapla_col_nine' 	=> __( 'Nine columns', 'shaplatools' ),
					'shapla_col_ten' 	=> __( 'Ten columns', 'shaplatools' ),
					'shapla_col_eleven' => __( 'Eleven columns', 'shaplatools' ),
					'shapla_col_twelve' => __( 'Twelve columns', 'shaplatools' ),
				)
			),
			'content' => array(
				'std'   => '',
				'type'  => 'textarea',
				'label' => __( 'Column Content', 'shaplatools' ),
				'desc'  => __( 'Add the column content.', 'shaplatools' ),
			)
		),
		'shortcode'    => '[{{column}}]{{content}}[/{{column}}] ',
		'clone_button' => __( 'Add Column', 'shaplatools' )
	)
);

$shapla_shortcodes['button'] = array(
	'no_preview' => true,
	'params' => array(
		'url' => array(
			'std'   => '',
			'type'  => 'text',
			'label' => __( 'Button URL', 'shaplatools' ),
			'desc'  => __( 'Add the button&lsquo;s url e.g. http://example.com', 'shaplatools' )
		),
		'style' => array(
			'type'    => 'select',
			'label'   => __( 'Button Style', 'shaplatools' ),
			'desc'    => __( 'Select the button&lsquo;s style, ie the button&lsquo;s colour', 'shaplatools' ),
			'std'     => 'black',
			'options' => array(
				'grey'       => __( 'Grey', 'shaplatools' ),
				'black'      => __( 'Black', 'shaplatools' ),
				'green'      => __( 'Green', 'shaplatools' ),
				'light-blue' => __( 'Light Blue', 'shaplatools' ),
				'blue'       => __( 'Blue', 'shaplatools' ),
				'red'        => __( 'Red', 'shaplatools' ),
				'orange'     => __( 'Orange', 'shaplatools' ),
				'purple'     => __( 'Purple', 'shaplatools' ),
				'white'      => __( 'White', 'shaplatools' )
			)
		),
		'size' => array(
			'type'    => 'select',
			'label'   => __( 'Button Size', 'shaplatools' ),
			'desc'    => __( 'Select the button&lsquo;s size', 'shaplatools' ),
			'std'     => 'small',
			'options' => array(
				'small'  => __( 'Small', 'shaplatools' ),
				'medium' => __( 'Medium', 'shaplatools' ),
				'large'  => __( 'Large', 'shaplatools' )
			)
		),
		'type' => array(
			'type'    => 'select',
			'label'   => __( 'Button Type', 'shaplatools' ),
			'desc'    => __( 'Select the button&lsquo;s type', 'shaplatools' ),
			'options' => array(
				'normal' => __( 'Normal', 'shaplatools' ),
				'stroke' => __( 'Stroke', 'shaplatools' )
			)
		),
		'icon' => array(
			'std'   => '',
			'type'  => 'icons',
			'label' => __( 'Button Icon', 'shaplatools' ),
			'desc'  => __( 'Choose an icon', 'shaplatools' )
		),
		'icon_order' => array(
			'type'    => 'select',
			'label'   => __( 'Font Order', 'shaplatools' ),
			'desc'    => __( 'Select if the icon should display before text or after text.', 'shaplatools' ),
			'std'     => 'before',
			'options' => array(
				'before' => __( 'Before Text', 'shaplatools' ),
				'after'  => __( 'After Text', 'shaplatools' )
			)
		),
		'target' => array(
			'type'    => 'select',
			'label'   => __( 'Button Target', 'shaplatools' ),
			'desc'    => __( '_self = open in same window. _blank = open in new window', 'shaplatools' ),
			'std'     => '_self',
			'options' => array(
				'_self'  => __( '_self', 'shaplatools' ),
				'_blank' => __( '_blank', 'shaplatools' )
			)
		),
		'content' => array(
			'std'   => 'Button Text',
			'type'  => 'text',
			'label' => __( 'Button&lsquo;s Text', 'shaplatools' ),
			'desc'  => __( 'Add the button&lsquo;s text', 'shaplatools' ),
		)
	),
	'shortcode'   => '[shapla_button url="{{url}}" style="{{style}}" size="{{size}}" type="{{type}}" target="{{target}}" icon="{{icon}}" icon_order="{{icon_order}}"]{{content}}[/shapla_button]',
	'popup_title' => __( 'Insert Button Shortcode', 'shaplatools' )
);

$shapla_shortcodes['toggle'] = array(
	'no_preview' => true,
	'params' => array(
		'style' => array(
			'type'    => 'select',
			'label'   => __( 'Toggle Style', 'shaplatools' ),
			'desc'    => __( 'Select the toggle&lsquo;s style', 'shaplatools' ),
			'options' => array(
				'normal' => __( 'Normal', 'shaplatools' ),
				'stroke' => __( 'Stroke', 'shaplatools' ),
			)
		),
		'title' => array(
			'type'  => 'text',
			'label' => __( 'Toggle Content Title', 'shaplatools' ),
			'desc'  => __( 'Add the title that will go above the toggle content', 'shaplatools' ),
			'std'   => 'Title',
		),
		'content' => array(
			'std'   => 'Content',
			'type'  => 'textarea',
			'label' => __( 'Toggle Content', 'shaplatools' ),
			'desc'  => __( 'Add the toggle content. Will accept HTML', 'shaplatools' ),
		),
		'state' => array(
			'type'    => 'select',
			'label'   => __( 'Toggle State', 'shaplatools' ),
			'desc'    => __( 'Select the state of the toggle on page load', 'shaplatools' ),
			'options' => array(
				'open'   => __( 'Open', 'shaplatools' ),
				'closed' => __( 'Closed', 'shaplatools' )
			)
		),
	),
	'shortcode'   => '[shapla_toggle style="{{style}}" title="{{title}}" state="{{state}}"]{{content}}[/shapla_toggle]',
	'popup_title' => __( 'Insert Toggle Content Shortcode', 'shaplatools' )
);

$shapla_shortcodes['tabs'] = array(
	'params' => array(
		'style' => array(
			'type'    => 'select',
			'label'   => __( 'Tabs Style', 'shaplatools' ),
			'desc'    => __( 'Select the tabs&lsquo;s style', 'shaplatools' ),
			'options' => array(
				'normal' => __( 'Normal', 'shaplatools' ),
				'stroke' => __( 'Stroke', 'shaplatools' ),
			)
		)
	),
	'no_preview'  => true,
	'shortcode'   => '[shapla_tabs style="{{style}}"]{{child_shortcode}} [/shapla_tabs]',
	'popup_title' => __( 'Insert Tab Shortcode', 'shaplatools' ),
	'child_shortcode' => array(
		'params' => array(
			'title' => array(
				'std'   => 'Title',
				'type'  => 'text',
				'label' => __( 'Tab Title', 'shaplatools' ),
				'desc'  => __( 'Title of the tab', 'shaplatools' ),
			),
			'content' => array(
				'std'     => 'Tab Content',
				'type'    => 'textarea',
				'label'   => __( 'Tab Content', 'shaplatools' ),
				'desc'    => __( 'Add the tabs content', 'shaplatools' )
			)
		),
		'shortcode'    => '[shapla_tab title="{{title}}"]{{content}}[/shapla_tab]',
		'clone_button' => __( 'Add Tab', 'shaplatools' )
	)
);

$shapla_shortcodes['dropcap'] = array(
	'no_preview' => true,
	'params' => array(
		'style' => array(
			'type'    => 'select',
			'label'   => __( 'Dropcap Style', 'shaplatools' ),
			'desc'    => __( 'Select the dropcap&lsquo;s style', 'shaplatools' ),
			'options' => array(
				'normal' => __( 'Normal', 'shaplatools' ),
				'squared' => __( 'Squared', 'shaplatools' ),
			)
		),
		'content' => array(
			'std'   => 'D',
			'type'  => 'text',
			'label' => __( 'Dropcap Text', 'shaplatools' ),
			'desc'  => __( 'Enter the dropcap&lsquo;s text', 'shaplatools' )
		),
		'size' => array(
			'std'   => '50px',
			'type'  => 'text',
			'label' => __( 'Font Size', 'shaplatools' ),
			'desc'  => __( 'Enter the font&lsquo;s size in px, em or %', 'shaplatools' ),
		),
	),
	'shortcode'   => '[shapla_dropcap font_size="{{size}}" style="{{style}}"]{{content}}[/shapla_dropcap]',
	'popup_title' => __( 'Insert Dropcap Shortcode', 'shaplatools' )
);

$shapla_shortcodes['image'] = array(
	'no_preview' => true,
	'params' => array(
		'src' => array(
			'std'   => '',
			'type'  => 'image',
			'label' => __( 'Image', 'shaplatools' ),
			'desc'  => __( 'Choose your image', 'shaplatools' )
		),
		'style' => array(
			'type'    => 'select',
			'label'   => __( 'Image Filter', 'shaplatools' ),
			'desc'    => __( 'Select the CSS3 image filter style', 'shaplatools' ),
			'std'     => 'no-filter',
			'options' => array(
				'no-filter'  => __( 'No Filter', 'shaplatools' ),
				'grayscale'  => __( 'Grayscale', 'shaplatools' ),
				'sepia'      => __( 'Sepia', 'shaplatools' ),
				'blur'       => __( 'Blur', 'shaplatools' ),
				'hue-rotate' => __( 'Hue Rotate', 'shaplatools' ),
				'contrast'   => __( 'Contrast', 'shaplatools' ),
				'brightness' => __( 'Brightness', 'shaplatools' ),
				'invert'     => __( 'Invert', 'shaplatools' ),
			)
		),
		'alignment' => array(
			'type'    => 'select',
			'label'   => __( 'Alignment', 'shaplatools' ),
			'desc'    => __( 'Choose Image Alignment', 'shaplatools' ),
			'std'     => 'none',
			'options' => array(
				'none'   => __( 'None', 'shaplatools' ),
				'left'   => __( 'Left', 'shaplatools' ),
				'center' => __( 'Center', 'shaplatools' ),
				'right'  => __( 'Right', 'shaplatools' )
			)
		),
		'url' => array(
			'std' => '',
			'type' => 'text',
			'label' => __( 'URL', 'shaplatools' ),
			'desc' => __( 'Enter the URL where image should be linked (optional)', 'shaplatools' )
		)
	),
	'shortcode'   => '[shapla_image style="{{style}}" src="{{src}}" alignment="{{alignment}}" url="{{url}}"]',
	'popup_title' => __( 'Insert Image Shortcode', 'shaplatools' )
);


$shapla_shortcodes['video'] = array(
	'no_preview' => true,
	'params' => array(
		'src' => array(
			'std'   => '',
			'type'  => 'video',
			'label' => __( 'Choose Video', 'shaplatools' ),
			'desc'  => __( 'Either upload a new video, choose an existing video from your media library or link to a video by URL. <br><br>', 'shaplatools' ) . sprintf( __( 'A list of all shortcode video services can be found on %s.<br>', 'shaplatools' ), '<a target="_blank" href="//codex.wordpress.org/Embeds#Okay.2C_So_What_Sites_Can_I_Embed_From.3F">WordPress.org</a>.<br><br>Working examples, in case you want to use an external service:<br><strong>http://vimeo.com/18439821</strong><br/><strong>http://www.youtube.com/watch?v=G0k3kHtyoqc</strong>' )
		)
	),
	'shortcode' => '[shapla_video src="{{src}}"]',
	'popup_title' => __( 'Insert Video Shortcode', 'shaplatools' )
);

$shapla_shortcodes['icon'] = array(
	'no_preview' => true,
	'params' => array(
		'icon' => array(
			'std'   => '',
			'type'  => 'icons',
			'label' => __( 'Icon', 'shaplatools' ),
			'desc'  => __( 'Choose an icon', 'shaplatools' )
		),
		'url' => array(
			'std'   => '',
			'type'  => 'text',
			'label' => __( 'URL', 'shaplatools' ),
			'desc'  => __( 'Enter the URL where icon should be linked (optional)', 'shaplatools' )
		),
		'new_window' => array(
			'type'    => 'select',
			'label'   => __( 'Open in new window', 'shaplatools' ),
			'desc'    => __( 'Do you want to open the link in a new window?', 'shaplatools' ),
			'options' => array(
				'no'  => __( 'No', 'shaplatools' ),
				'yes' => __( 'Yes', 'shaplatools' ),
			)
		),
		'size' => array(
			'std' => '50px',
			'type' => 'text',
			'label' => __( 'Font Size', 'shaplatools' ),
			'desc' => __( 'Enter the icon&lsquo;s font size in px, em or %', 'shaplatools' ),
		)
	),
	'shortcode' => '[shapla_icon icon="{{icon}}" url="{{url}}" size="{{size}}" new_window="{{new_window}}"]',
	'popup_title' => __( 'Insert Icon Shortcode', 'shaplatools' )
);

$shapla_shortcodes['map'] = array(
	'no_preview' => true,
	'params' => array(
		'lat' => array(
			'std'   => '',
			'type'  => 'text',
			'label' => __( 'Latitude', 'shaplatools' ),
			'desc'  => __( 'Enter the place latitude coordinate. E.g.: 37.42200', 'shaplatools' )
		),
		'long' => array(
			'std'   => '',
			'type'  => 'text',
			'label' => __( 'Longitude', 'shaplatools' ),
			'desc'  => sprintf( __( 'Enter the place longitude coordinate. E.g.: -122.08395. You may find longitude and latitude <a href="%1$s" target="_blank">here</a>.', 'shaplatools' ), esc_url( 'http://labs.mondeca.com/geo/anyplace.html' ) )
		),
		'width' => array(
			'std'   => '100%',
			'type'  => 'text',
			'label' => __( 'Width', 'shaplatools' ),
			'desc'  => __( 'Enter the map width.', 'shaplatools' )
		),
		'height' => array(
			'std'   => '350px',
			'type'  => 'text',
			'label' => __( 'Height', 'shaplatools' ),
			'desc'  => __( 'Enter the map height.', 'shaplatools' )
		),
		'map-type' => array(
			'std'     => 'roadmap',
			'type'    => 'buttonset',
			'label'   => __( 'Map Type', 'shaplatools' ),
			'desc'    => __( 'Select the map type for Google Maps.', 'shaplatools' ),
			'options' => array(
				'roadmap'   => __( 'Roadmap', 'shaplatools' ),
				'satellite' => __( 'Satellite', 'shaplatools' ),
				'hybrid'    => __( 'Hybrid', 'shaplatools' ),
				'terrain'   => __( 'Terrain', 'shaplatools' ),
			)
		),
		'zoom' => array(
			'std'   => '15',
			'type'  => 'text',
			'label' => __( 'Zoom Level', 'shaplatools' ),
			'desc'  => __( 'Enter the map zoom level between 0-21. Highest value zooms in and lowest zooms out.', 'shaplatools' )
		),
		'style' => array(
			'std'     => 'none',
			'type'    => 'select',
			'label'   => __( 'Map Style', 'shaplatools' ),
			'desc'    => __( 'Select from a list of predefined map styles.', 'shaplatools' ),
			'options' => array(
				'none'             => __( 'None', 'shaplatools' ),
				'pale_dawn'        => __( 'Pale Dawn', 'shaplatools' ),
				'subtle_grayscale' => __( 'Subtle Grayscale', 'shaplatools' ),
				'bright_bubbly'    => __( 'Bright & Bubbly', 'shaplatools' ),
				'greyscale'        => __( 'Greyscale', 'shaplatools' ),
				'mixed'            => __( 'Mixed', 'shaplatools' )
			)
		),
	),
	'shortcode'   => '[shapla_map lat="{{lat}}" long="{{long}}" width="{{width}}" height="{{height}}" style="{{style}}" zoom="{{zoom}}" type="{{map-type}}"]',
	'popup_title' => __( 'Insert Google Map Shortcode', 'shaplatools' )
);
