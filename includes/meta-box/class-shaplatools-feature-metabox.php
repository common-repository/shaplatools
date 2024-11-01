<?php

if( !class_exists('ShaplaTools_Feature_Metabox') ):

class ShaplaTools_Feature_Metabox
{
	private $plugin_name;
	private $plugin_url;

	/**
	 * Hook into the appropriate actions when the class is constructed.
	 */
	public function __construct( $plugin_name, $plugin_url ) {
		$this->plugin_name = $plugin_name;
		$this->plugin_url = $plugin_url;

		add_action( 'add_meta_boxes', array( $this, 'add_meta_box' ) );
		add_action( 'admin_head', array ($this, 'add_mce_button') );
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
		global $shaplatools;
	    $plugin_array['shaplatools_feature_mce_button'] = $this->plugin_url .'/assets/mce-button/mce-feature.js';
	    return $plugin_array;
	}

	public function register_mce_button( $buttons ) {
	    array_push( $buttons, 'shaplatools_feature_mce_button' );
	    return $buttons;
	}

	/**
	 * Adds the meta box container.
	 */
	public function add_meta_box() {
		$meta_box = array(
		    'id' => 'shapla-metabox-feature',
		    'title' => __('Extra Settings', 'shaplatools'),
		    'screen' => 'feature',
		    'context' => 'normal',
		    'priority' => 'core',
		    'fields' => array(
		        array(
		            'name' => __('Font Awesome Icon Class:', 'shaplatools'),
		            'desc' => sprintf(__('Add %s Font Awesome %s Icon Class. Example: %s', 'shaplatools'), '<a target="_blank" href="http://fortawesome.github.io/Font-Awesome/icons/">', '</a>', 'fa fa-wordpress'),
		            'id' => '_shapla_feature_fa_icon',
		            'type' => 'text',
		            'std' => ''
		        ),
		    )
		);
		$ShaplaTools_Meta_Box = new ShaplaTools_Meta_Box();
		$ShaplaTools_Meta_Box->add($meta_box);
	}
}
endif;