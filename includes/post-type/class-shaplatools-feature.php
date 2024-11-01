<?php

if( !class_exists('ShaplaTools_Feature') ):

class ShaplaTools_Feature {

	private $plugin_name;

	public function __construct( $plugin_name ){

		$this->plugin_name = $plugin_name;
		add_action( 'init', array ($this, 'post_type') );
	}

	/**
	 * Register a feature post type.
	 * @package ShaplaTools
	 * @link http://codex.wordpress.org/Function_Reference/register_post_type
	 */
	public static function post_type(){

		$labels = array(
			'name'                => _x( 'Features', 'Post Type General Name', 'shaplatools' ),
			'singular_name'       => _x( 'Feature', 'Post Type Singular Name', 'shaplatools' ),
			'menu_name'           => __( 'Features', 'shaplatools' ),
			'parent_item_colon'   => __( 'Parent Feature:', 'shaplatools' ),
			'all_items'           => __( 'All Features', 'shaplatools' ),
			'view_item'           => __( 'View Feature', 'shaplatools' ),
			'add_new_item'        => __( 'Add New Feature', 'shaplatools' ),
			'add_new'             => __( 'Add New', 'shaplatools' ),
			'edit_item'           => __( 'Edit Feature', 'shaplatools' ),
			'update_item'         => __( 'Update Feature', 'shaplatools' ),
			'search_items'        => __( 'Search Feature', 'shaplatools' ),
			'not_found'           => __( 'Not found', 'shaplatools' ),
			'not_found_in_trash'  => __( 'Not found in Trash', 'shaplatools' ),
		);
		$args = array(
			'label'               => __( 'feature', 'shaplatools' ),
			'description'         => __( 'Add features', 'shaplatools' ),
			'labels'              => $labels,
			'supports'            => array( 'title', 'editor', 'thumbnail', ),
			'hierarchical'        => false,
			'public'              => true,
			'show_ui'             => true,
			'show_in_menu'        => true,
			'show_in_nav_menus'   => true,
			'show_in_admin_bar'   => true,
			'menu_position'       => 35,
			'menu_icon'           => 'dashicons-pressthis',
			'can_export'          => true,
			'has_archive'         => true,
			'exclude_from_search' => false,
			'publicly_queryable'  => true,
			'capability_type'     => 'post',
		);
		register_post_type( 'feature', $args );
	}
}

endif;