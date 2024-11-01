<?php

if( !class_exists('ShaplaTools_Slide') ):

class ShaplaTools_Slide {

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name
	 */
	private $plugin_name;

	public function __construct( $plugin_name ){

		$this->plugin_name = $plugin_name;
		
		if (is_admin()) {
			add_action( 'init', array ($this, 'post_type') );
		}
	}

	/**
	 * Register a slide post type.
	 * @package ShaplaTools
	 * @link http://codex.wordpress.org/Function_Reference/register_post_type
	 */
	public static function post_type() {

		$labels = array(
			'name'                => _x( 'Slides', 'Post Type General Name', 'shaplatools' ),
			'singular_name'       => _x( 'Slide', 'Post Type Singular Name', 'shaplatools' ),
			'menu_name'           => __( 'Slide', 'shaplatools' ),
			'name_admin_bar'      => __( 'Slide', 'shaplatools' ),
			'parent_item_colon'   => __( 'Parent Slide:', 'shaplatools' ),
			'all_items'           => __( 'All Slides', 'shaplatools' ),
			'add_new_item'        => __( 'Add New Slide', 'shaplatools' ),
			'add_new'             => __( 'Add New', 'shaplatools' ),
			'new_item'            => __( 'New Slide', 'shaplatools' ),
			'edit_item'           => __( 'Edit Slide', 'shaplatools' ),
			'update_item'         => __( 'Update Slide', 'shaplatools' ),
			'view_item'           => __( 'View Slide', 'shaplatools' ),
			'search_items'        => __( 'Search Slide', 'shaplatools' ),
			'not_found'           => __( 'Not found', 'shaplatools' ),
			'not_found_in_trash'  => __( 'Not found in Trash', 'shaplatools' ),
		);
		$args = array(
			'label'               => __( 'slide', 'shaplatools' ),
			'description'         => __( 'Create slide for your site', 'shaplatools' ),
			'labels'              => $labels,
			'supports'            => array( 'title' ),
			'hierarchical'        => false,
			'public'              => false,
			'show_ui'             => true,
			'show_in_menu'        => true,
			'menu_position'       => 35,
			'menu_icon'           => 'dashicons-images-alt2',
			'show_in_admin_bar'   => false,
			'show_in_nav_menus'   => false,
			'can_export'          => true,
			'has_archive'         => false,
			'exclude_from_search' => true,
			'publicly_queryable'  => true,
			'rewrite'             => false,
			'capability_type'     => 'post',
		);
		register_post_type( 'slide', $args );
	}
}

endif;