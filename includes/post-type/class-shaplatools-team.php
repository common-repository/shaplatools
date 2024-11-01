<?php

if( !class_exists('ShaplaTools_Team') ):

class ShaplaTools_Team {

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
	 * Register a team post type.
	 * @package ShaplaTools
	 * @link http://codex.wordpress.org/Function_Reference/register_post_type
	 */
	public static function post_type(){

		$labels = array(
			'name'               => __( 'Team', 'shaplatools' ),
			'singular_name'      => __( 'Team', 'shaplatools' ),
			'add_new'            => __( 'Add New', 'shaplatools' ),
			'add_new_item'       => __( 'Add New Team Member', 'shaplatools' ),
			'edit_item'          => __( 'Edit Team Member', 'shaplatools' ),
			'new_item'           => __( 'New Team Member', 'shaplatools' ),
			'view_item'          => __( 'View Team Member', 'shaplatools' ),
			'search_items'       => __( 'Search Team Member', 'shaplatools' ),
			'not_found'          => __( 'No Team Member found', 'shaplatools' ),
			'not_found_in_trash' => __( 'No Team Member in trash', 'shaplatools' ),
			'parent_item_colon'  => ''
		);

		$args = array(
			'labels'              => $labels,
			'public'              => false,
			'exclude_from_search' => true,
			'publicly_queryable'  => false,
			'rewrite'             => array('slug' => 'team'),
			'show_ui'             => true,
			'query_var'           => true,
			'capability_type'     => 'post',
			'hierarchical'        => false,
			'menu_position'       => 34,
			'menu_icon'           => 'dashicons-groups',
			'has_archive'         => false,
			'supports'            => array( 'title', 'editor', 'thumbnail' )
		);

		register_post_type( 'team', $args );
	}
}
endif;