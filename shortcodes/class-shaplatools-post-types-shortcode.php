<?php
if( ! class_exists('ShaplaTools_Post_Types_Shortcode')):

class ShaplaTools_Post_Types_Shortcode
{
	private $plugin_path;
	private $plugin_name;

	public function __construct( $plugin_name, $plugin_path )
	{
		$this->plugin_name = $plugin_name;
		$this->plugin_path = $plugin_path;

		add_shortcode( 'shapla_slide', array( $this, 'shapla_slide' ) );
		add_shortcode( 'shapla_portfolio', array( $this, 'shapla_portfolio' ) );
		add_shortcode( 'shapla_feature', array( $this, 'shapla_feature' ) );
		add_shortcode( 'shapla_team', array( $this, 'shapla_team' ) );
		add_shortcode( 'shapla_testimonial', array( $this, 'shapla_testimonial' ) );

		add_shortcode( 'shapla_testimonials', array( $this, 'shapla_testimonial' ) );
		add_shortcode( 'shapla_teams', array( $this, 'shapla_team' ) );
	}

	/**
	 * A shortcode for rendering the shapla slide.
	 *
	 * @param  array   $attributes  Shortcode attributes.
	 * @param  string  $content     The text content for shortcode. Not used.
	 *
	 * @return string  The shortcode output
	 */
	public function shapla_slide( $attributes, $content = null )
	{
		$default_attributes = array(
			'id' => ''
		);
		
		$attributes = shortcode_atts( $default_attributes, $attributes );

		ob_start();
	    do_action( 'shaplatools_before_slide_shortcode' );
	    require $this->plugin_path . '/templates/shapla_slide.php';
	    do_action( 'shaplatools_after_slide_shortcode' );
	    $html = ob_get_contents();
	    ob_end_clean();
	 
	    return $html;
	}

	/**
	 * A shortcode for rendering the shapla portfolio.
	 *
	 * @param  array   $attributes  Shortcode attributes.
	 * @param  string  $content     The text content for shortcode. Not used.
	 *
	 * @return string  The shortcode output
	 */
	public function shapla_portfolio( $attributes, $content = null )
	{
		$default_attributes = array(
	        'thumbnail' =>'m4',
	        'thumbnail_size' =>'medium'
		);
		
		$attributes = shortcode_atts( $default_attributes, $attributes );

		ob_start();
	    do_action( 'shaplatools_before_portfolio_shortcode' );
	    require_once $this->plugin_path . '/templates/shapla_portfolio.php';
	    do_action( 'shaplatools_after_portfolio_shortcode' );
	    $html = ob_get_contents();
	    ob_end_clean();
	 
	    return $html;
	}

	/**
	 * A shortcode for rendering the shapla testimonial.
	 *
	 * @param  array   $attributes  Shortcode attributes.
	 * @param  string  $content     The text content for shortcode. Not used.
	 *
	 * @return string  The shortcode output
	 */
	public function shapla_testimonial( $attributes, $content = null )
	{
		$default_attributes = array(
            'id' 					=> uniqid(),
            'posts_per_page' 		=> -1,
            'orderby' 				=> 'none',
            'items_desktop' 		=> 4,
            'items_tablet' 			=> 3,
            'items_tablet_small' 	=> 2,
            'items_mobile' 			=> 1,
		);
		
		$atts = shortcode_atts( $default_attributes, $attributes );

		ob_start();
	    do_action( 'shaplatools_before_testimonial_shortcode' );
	    require_once $this->plugin_path . '/templates/shapla_testimonial.php';
	    do_action( 'shaplatools_after_testimonial_shortcode' );
	    $html = ob_get_contents();
	    ob_end_clean();
	 
	    return $html;
	}

	/**
	 * A shortcode for rendering the shapla team.
	 *
	 * @param  array   $attributes  Shortcode attributes.
	 * @param  string  $content     The text content for shortcode. Not used.
	 *
	 * @return string  The shortcode output
	 */
	public function shapla_team( $attributes, $content = null )
	{
		$default_attributes = array(
            'id' 					=> uniqid(),
            'posts_per_page' 		=> -1,
            'orderby' 				=> 'none',
            'items_desktop' 		=> 4,
            'items_tablet' 			=> 3,
            'items_tablet_small' 	=> 2,
            'items_mobile' 			=> 1,
		);
		
		$atts = shortcode_atts( $default_attributes, $attributes );

		ob_start();
	    do_action( 'shaplatools_before_team_shortcode' );
	    require_once $this->plugin_path . '/templates/shapla_team.php';
	    do_action( 'shaplatools_after_team_shortcode' );
	    $html = ob_get_contents();
	    ob_end_clean();
	 
	    return $html;
	}

	/**
	 * A shortcode for rendering the shapla feature.
	 *
	 * @param  array   $attributes  Shortcode attributes.
	 * @param  string  $content     The text content for shortcode. Not used.
	 *
	 * @return string  The shortcode output
	 */
	public function shapla_feature( $attributes, $content = null )
	{
		$default_attributes = array(
            'posts_per_page' 		=> -1,
            'orderby' 				=> 'none',
            'thumbnail' 			=> 's4',
		);
		
		$atts = shortcode_atts( $default_attributes, $attributes );

		ob_start();
	    do_action( 'shaplatools_before_feature_shortcode' );
	    require_once $this->plugin_path . '/templates/shapla_feature.php';
	    do_action( 'shaplatools_after_feature_shortcode' );
	    $html = ob_get_contents();
	    ob_end_clean();
	 
	    return $html;
	}
}
endif;