<?php

if( !class_exists('ShaplaTools_Testimonial_Metabox') ):

class ShaplaTools_Testimonial_Metabox {

	private $plugin_name;
	private $plugin_url;

	/**
	 * Hook into the appropriate actions when the class is constructed.
	 */
	public function __construct( $plugin_name, $plugin_url ) {

		$this->plugin_name = $plugin_name;
		$this->plugin_url = $plugin_url;

		add_action( 'add_meta_boxes', array( $this, 'add_meta_box' ) );
		add_action( 'add_meta_boxes', array( $this, 'client_avatar' ) );
		
		add_action( 'admin_head', array ($this, 'add_mce_button') );

		add_filter( 'manage_edit-testimonial_columns', array ($this, 'columns_head') );
		add_action( 'manage_testimonial_posts_custom_column', array ($this, 'columns_content'));
	}

	public function add_mce_button() {
	    // check user permissions
	    if ( !current_user_can( 'edit_posts' ) && !current_user_can( 'edit_pages' ) ) {
	        return;
	    }
	    // check if WYSIWYG is enabled
	    if ( 'true' == get_user_option( 'rich_editing' ) ) {
			add_filter( 'mce_external_plugins', array ($this, 'add_tinymce_plugin') );
			add_filter( 'mce_buttons', array ($this, 'register_mce_button') );
	    }
	}
	public function add_tinymce_plugin( $plugin_array ) {
	    $plugin_array['shaplatools_testimonial_mce_button'] = $this->plugin_url .'/assets/mce-button/mce-testimonial.js';
	    return $plugin_array;
	}

	public function register_mce_button( $buttons ) {
	    array_push( $buttons, 'shaplatools_testimonial_mce_button' );
	    return $buttons;
	}

	public function client_avatar(){
		remove_meta_box( 'postimagediv', 'testimonial', 'side' );
		add_meta_box('postimagediv', __('Client\'s Avatar', 'shaplatools'), 'post_thumbnail_meta_box', 'testimonial', 'side', 'low'		);
	}

	/**
	 * Adds the meta box container.
	 */
	public function add_meta_box() {
		$meta_box = array(
		    'id' => 'shapla-metabox-testimonial',
		    'title' => __('Testimonial Details', 'shaplatools'),
		    'description' => __('Here you can customize your testimonial details.', 'shaplatools'),
		    'screen' => 'testimonial',
		    'context' => 'normal',
		    'priority' => 'high',
		    'fields' => array(
		        array(
		            'name' => __('Client Name', 'shaplatools'),
		            'desc' => __('Enter the client name', 'shaplatools'),
		            'id' => '_shapla_testimonial_client',
		            'type' => 'text',
		            'std' => ''
		        ),
		        array(
		            'name' => __('Business/Site Name (optional)', 'shaplatools'),
		            'desc' => __('Enter the client business/site name', 'shaplatools'),
		            'id' => '_shapla_testimonial_source',
		            'type' => 'text',
		            'std' => '',
		        ),
		        array(
		            'name' => __('Business/Site Link (optional)', 'shaplatools'),
		            'desc' => __('Enter the project URL', 'shaplatools'),
		            'id' => '_shapla_testimonial_url',
		            'type' => 'text',
		            'std' => ''
		        ),
		    )
		);
		$ShaplaTools_Metaboxs = new ShaplaTools_Meta_Box();
		$ShaplaTools_Metaboxs->add($meta_box);
	}

	public function columns_head( $columns ) {
		$columns = array(
			'cb' => '<input type="checkbox">',
			'title' => __('Title', 'shaplatools'),
			'testimonial' => __('Testimonial', 'shaplatools'),
			'testimonial-client-name' => __('Client\'s Name', 'shaplatools'),
			'testimonial-source' => __('Business/Site', 'shaplatools'),
			'testimonial-link' => __('Link', 'shaplatools'),
			'testimonial-avatar' => __('Client\'s Avatar', 'shaplatools')
		);

		return $columns;
	}

	public function columns_content( $column ) {

		$client = get_post_meta( get_the_ID(), '_shapla_testimonial_client', true );
		$source = get_post_meta( get_the_ID(), '_shapla_testimonial_source', true );
		$url = get_post_meta( get_the_ID(), '_shapla_testimonial_url', true );

		switch ( $column ) {
			case 'testimonial':
				the_excerpt();
				break;
			case 'testimonial-client-name':
				if ( ! empty( $client ) )
					echo $client;
				break;
			case 'testimonial-source':
				if ( ! empty( $source ) )
					echo $source;
				break;
			case 'testimonial-link':
				if ( ! empty( $url ) )
					echo $url;
				break;
			case 'testimonial-avatar':
				echo get_the_post_thumbnail( get_the_ID(), array(64,64));
				break;
		}
	}
}
endif;