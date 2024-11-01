<?php

if( !class_exists('ShaplaTools_Team_Metabox') ):

class ShaplaTools_Team_Metabox {

	private $plugin_name;
	private $plugin_url;

	/**
	 * Hook into the appropriate actions when the class is constructed.
	 */
	public function __construct( $plugin_name, $plugin_url ) {

		$this->plugin_name = $plugin_name;
		$this->plugin_url = $plugin_url;

		add_action( 'add_meta_boxes', array( $this, 'add_meta_box' ) );
		add_action( 'add_meta_boxes', array( $this, 'team_member_image' ) );
		
		add_action( 'admin_head', array ($this, 'add_mce_button') );

		add_filter( 'manage_edit-team_columns', array ($this, 'columns_head') );
		add_action( 'manage_team_posts_custom_column', array ($this, 'columns_content') );
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
	    $plugin_array['shaplatools_team_mce_button'] = $this->plugin_url .'/assets/mce-button/mce-team.js';
	    return $plugin_array;
	}

	public function register_mce_button( $buttons ) {
	    array_push( $buttons, 'shaplatools_team_mce_button' );
	    return $buttons;
	}

	public function team_member_image(){
		remove_meta_box( 'postimagediv', 'team', 'side' );
		add_meta_box('postimagediv', __('Team Member Image', 'shaplatools'), 'post_thumbnail_meta_box', 'team', 'side', 'low'		);
	}

	/**
	 * Adds the meta box container.
	 */
	public function add_meta_box() {
		$meta_box = array(
		    'id' => 'shapla-metabox-team',
		    'title' => __('Team Member Details', 'shaplatools'),
		    'description' => __('Here you can customize your team members details.', 'shaplatools'),
		    'screen' => 'team',
		    'context' => 'advanced',
		    'priority' => 'core',
		    'fields' => array(
		        array(
		            'name' => __('Team Member Designation', 'shaplatools'),
		            'desc' => __('Enter team member designation.', 'shaplatools'),
		            'id' => '_shapla_team_designation',
		            'type' => 'text',
		            'std' => ''
		        ),
		        array(
		            'name' => __('Member Short Description', 'shaplatools'),
		            'desc' => __('Enter team member short description.', 'shaplatools'),
		            'id' => '_shapla_team_description',
		            'type' => 'wp_editor',
		            'std' => '',
		        ),
		    )
		);
		$ShaplaTools_Metaboxs = new ShaplaTools_Meta_Box();
		$ShaplaTools_Metaboxs->add($meta_box);
	}

	public function columns_head( $defaults ) {
		$defaults = array(
			'cb' 					=> '<input type="checkbox">',
			'title' 				=> __('Team Member Name', 'shaplatools'),
			'member_designation' 	=> __('Designation', 'shaplatools'),
			'member_description'	=> __('Short Description', 'shaplatools'),
			'member_image'			=> __('Member Image', 'shaplatools'),
		);

		return $defaults;
	}

	public function columns_content( $column_name ) {

		$designation 	= get_post_meta( get_the_ID(), '_shapla_team_designation', true );
		$description 	= get_post_meta( get_the_ID(), '_shapla_team_description', true );
		$member_image 	= get_the_post_thumbnail( get_the_ID(), array( 50,50 ) );

		if ( 'member_designation' == $column_name ) {

			if ( ! empty( $designation ) )
			echo $designation;
		}

		if ( 'member_description' == $column_name ) {

			if ( ! empty( $description ) )
			echo $description;
		}

		if ( 'member_image' == $column_name ) {

			echo $member_image;
		}
	}
}

endif;