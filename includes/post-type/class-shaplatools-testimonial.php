<?php

if( !class_exists('ShaplaTools_Testimonial') ):

class ShaplaTools_Testimonial {

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
		add_action( 'init', array ($this, 'post_type') );
	}

	/**
	 * Register a testimonial post type.
	 * @package ShaplaTools
	 * @link http://codex.wordpress.org/Function_Reference/register_post_type
	 */
	public static function post_type(){

		$labels = array(
			'name'                => _x( 'Testimonials', 'Post Type General Name', 'shaplatools' ),
			'singular_name'       => _x( 'Testimonial', 'Post Type Singular Name', 'shaplatools' ),
			'menu_name'           => __( 'Testimonials', 'shaplatools' ),
			'parent_item_colon'   => __( 'Parent Testimonial:', 'shaplatools' ),
			'all_items'           => __( 'All Testimonials', 'shaplatools' ),
			'view_item'           => __( 'View Testimonial', 'shaplatools' ),
			'add_new_item'        => __( 'Add New Testimonial', 'shaplatools' ),
			'add_new'             => __( 'Add New', 'shaplatools' ),
			'edit_item'           => __( 'Edit Testimonial', 'shaplatools' ),
			'update_item'         => __( 'Update Testimonial', 'shaplatools' ),
			'search_items'        => __( 'Search Testimonial', 'shaplatools' ),
			'not_found'           => __( 'Not found', 'shaplatools' ),
			'not_found_in_trash'  => __( 'Not found in Trash', 'shaplatools' ),
		);
		$args = array(
			'label'               => __( 'testimonials', 'shaplatools' ),
			'description'         => __( 'Post Type Description', 'shaplatools' ),
			'labels'              => $labels,
			'supports'            => array( 'title', 'editor', 'thumbnail', ),
			'hierarchical'        => false,
			'public'              => false,
			'show_ui'             => true,
			'show_in_menu'        => true,
			'menu_position'       => 30,
			'menu_icon'           => 'dashicons-testimonial',
			'show_in_admin_bar'   => true,
			'show_in_nav_menus'   => false,
			'can_export'          => true,
			'has_archive'         => false,
			'exclude_from_search' => true,
			'publicly_queryable'  => true,
			'rewrite'             => array('slug' => 'testimonials',),
			'capability_type'     => 'post',
		);
		register_post_type( 'testimonial', $args );
	}
}

endif;