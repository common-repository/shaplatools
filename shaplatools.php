<?php
/**
 * Plugin Name:       ShaplaTools
 * Plugin URI:        https://wordpress.org/plugins/shaplatools/
 * Description:       ShaplaTools is a powerful plugin to extend functionality to your WordPress themes. 
 * Version:           1.3.1
 * Author:            Sayful Islam
 * Author URI:        https://sayfulit.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       shaplatools
 * Domain Path:       /languages
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly


if ( ! class_exists( 'ShaplaTools' ) ):

class ShaplaTools
{
	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name
	 */
	private $plugin_name = 'shaplatools';

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version
	 */
	private $version = '1.3.1';

	/**
	 * The absolute url of current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_url
	 */
	private $plugin_url;

	/**
	 * The absolute path of current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_path
	 */
	private $plugin_path;

	/**
	 * The options of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      array    $options
	 */
	private $options;


	protected static $instance = null;

	/**
	 * Main ShaplaTools Instance
	 *
	 * Ensures only one instance of ShaplaTools is loaded or can be loaded.
	 *
	 * @since 1.2.0
	 * @static
	 * @see ShaplaTools()
	 * @return ShaplaTools - Main instance
	 */
	public static function instance() {
		if ( is_null( self::$instance ) ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	/**
	 * ShaplaTools Constructor.
	 *
	 * @access public
	 * @return void
	 */
	public function __construct()
	{
		// Include required files
		$this->init();

		add_filter( 'plugin_action_links_' . plugin_basename( __FILE__ ), array( $this, 'action_links' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'admin_scripts' ), 0 );
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ), 0 );
		add_action( 'after_setup_theme', array( $this, 'editor_styles' ) );
		add_action( 'wp_footer', array( $this, 'google_analytics_script' ) );
		add_filter( 'body_class', array( $this, 'body_class' ) );
		add_action( 'init', array( $this, 'load_textdomain' ) );

		register_activation_hook( __FILE__, array( $this, 'shaplatools_activation' ) );
		register_deactivation_hook( __FILE__, array( $this, 'shaplatools_deactivation' ) );
	}

	public function init()
	{
		$this->include_libraries();
		$this->include_settings();
		$this->includes_post_types();
		$this->include_meta_boxes();
		$this->include_widgets();
		$this->include_shortcodes();
		$this->include_tinymce_shortcodes();
		$this->include_other_files();
	}

	private function include_libraries()
	{
		include_once $this->plugin_path() . '/includes/libraries/class-shaplatools-settings-api.php';
		include_once $this->plugin_path() . '/includes/libraries/class-shaplatools-meta-box.php';
	}

	private function include_settings()
	{
		include_once $this->plugin_path() . '/includes/settings/settings.php';
	}

	private function includes_post_types()
	{
		$options = $this->shaplatools_options();

		include_once $this->plugin_path() . '/includes/post-type/class-shaplatools-slide.php';
		include_once $this->plugin_path() . '/includes/post-type/class-shaplatools-portfolio.php';
		include_once $this->plugin_path() . '/includes/post-type/class-shaplatools-feature.php';
		include_once $this->plugin_path() . '/includes/post-type/class-shaplatools-testimonial.php';
		include_once $this->plugin_path() . '/includes/post-type/class-shaplatools-team.php';

		if( $options['slide_post_type'] ) {
			new ShaplaTools_Slide( $this->plugin_name );
		}

		if( $options['portfolio_post_type'] ) {
			new ShaplaTools_Portfolio( $this->plugin_name );
		}

		if( $options['feature_post_type'] ) {
			new ShaplaTools_Feature( $this->plugin_name );
		}

		if( $options['testimonial_post_type'] ) {
			new ShaplaTools_Testimonial( $this->plugin_name );
		}

		if( $options['team_post_type'] ) {
			new ShaplaTools_Team( $this->plugin_name );
		}
	}

	public function include_meta_boxes()
	{
		$options = $this->shaplatools_options();

		include_once $this->plugin_path() . '/includes/meta-box/class-shaplatools-nivoslide-metabox.php';
		include_once $this->plugin_path() . '/includes/meta-box/class-shaplatools-portfolio-metabox.php';
		include_once $this->plugin_path() . '/includes/meta-box/class-shaplatools-feature-metabox.php';
		include_once $this->plugin_path() . '/includes/meta-box/class-shaplatools-team-metabox.php';
		include_once $this->plugin_path() . '/includes/meta-box/class-shaplatools-testimonial-metabox.php';
		include_once $this->plugin_path() . '/includes/meta-box/class-shaplatools-post-metabox.php';

		if( $options['slide_meta_box'] ) {
			new ShaplaTools_NivoSlide_Metabox( $this->plugin_name, $this->plugin_url() );
		}

		if( $options['portfolio_meta_box'] ) {
			new ShaplaTools_Portfolio_Metabox( $this->plugin_name, $this->plugin_url() );
		}

		if( $options['feature_meta_box'] ) {
			new ShaplaTools_Feature_Metabox( $this->plugin_name, $this->plugin_url() );
		}

		if( $options['team_meta_box'] ) {
			new ShaplaTools_Team_Metabox( $this->plugin_name, $this->plugin_url() );
		}

		if( $options['testimonial_meta_box'] ) {
			new ShaplaTools_Testimonial_Metabox( $this->plugin_name, $this->plugin_url() );
		}

		if( $options['post_meta_box'] ) {
			new ShaplaTools_Post_Metabox( $this->plugin_name );
		}
	}

	public function include_widgets()
	{
		include_once $this->plugin_path() . '/widgets/widget-dribbble.php';
		include_once $this->plugin_path() . '/widgets/widget-flickr.php';
		include_once $this->plugin_path() . '/widgets/widget-instagram.php';
		include_once $this->plugin_path() . '/widgets/widget-twitter.php';
		include_once $this->plugin_path() . '/widgets/widget-fb_like_box.php';
		include_once $this->plugin_path() . '/widgets/widget-contact.php';
		include_once $this->plugin_path() . '/widgets/widget-testimonials.php';
	}

	public function include_shortcodes()
	{
		include_once $this->plugin_path() . '/shortcodes/class-shaplatools-post-types-shortcode.php';
		include_once $this->plugin_path() . '/shortcodes/class-shaplatools-grid-shortcode.php';
		include_once $this->plugin_path() . '/shortcodes/class-shaplatools-components-shortcode.php';
		
		new ShaplaTools_Grid_Shortcode( $this->plugin_name, $this->plugin_path() );
		new ShaplaTools_Post_Types_Shortcode( $this->plugin_name, $this->plugin_path() );
		new Shaplatools_Components_Shortcode( $this->plugin_name, $this->plugin_path(), $this->options );
	}

	public function include_tinymce_shortcodes()
	{
		if ( is_admin() ) {
			include_once $this->plugin_path() . '/includes/tiny-mce/ShaplaTools_TinyMCE.php';
			include_once $this->plugin_path() . '/includes/tiny-mce/shapla-shortcodes.php';

			new ShaplaTools_TinyMCE( $this->plugin_name, $this->plugin_url() );
			new ShaplaShortcodes($this->plugin_url(), $this->plugin_path());
		}
	}

	public function include_other_files()
	{
		include_once $this->plugin_path() . '/includes/class-shaplatools-retina-2x.php';
		include_once $this->plugin_path() . '/includes/class-shaplatools-typeahead-search.php';

		if( $this->shaplatools_options()['retina_image'] ) {
			new ShaplaTools_Retina_2x();
		}

		new ShaplaTools_Typeahead_Search( $this->plugin_url(), $this->options );
	}

	/**
	 * Plugin path.
	 *
	 * @return string Plugin path
	 */
	private function plugin_path() {
		if ( $this->plugin_path ) return $this->plugin_path;

		return $this->plugin_path = untrailingslashit( plugin_dir_path( __FILE__ ) );
	}

	/**
	 * Plugin url.
	 *
	 * @return string Plugin url
	 */
	private function plugin_url() {
		if ( $this->plugin_url ) return $this->plugin_url;
		return $this->plugin_url = untrailingslashit( plugins_url( '/', __FILE__ ) );
	}

	private function shaplatools_options()
	{
		$options = array(
			'google_analytics_id' 	=> $this->get_option('google_analytics'),
			'google_map_api_key' 	=> $this->get_option('google_map_api_key'),
			'typeahead_search' 		=> $this->get_option('typeahead_search'),
			'retina_image' 			=> in_array('retina_image', $this->get_option('shapla_retina_graphics')),
			'retina_js' 			=> in_array('retina_js', $this->get_option('shapla_retina_graphics')),
			'slide_post_type' 		=> in_array('slide_post_type', $this->get_option('shapla_slide')),
			'slide_meta_box' 		=> in_array('slide_metabox', $this->get_option('shapla_slide')),
			'portfolio_post_type' 	=> in_array('portfolio_post_type', $this->get_option('shapla_portfolio')),
			'portfolio_meta_box' 	=> in_array('portfolio_metabox', $this->get_option('shapla_portfolio')),
			'team_post_type' 		=> in_array('team_post_type', $this->get_option('shapla_team')),
			'team_meta_box' 		=> in_array('team_metabox', $this->get_option('shapla_team')),
			'testimonial_post_type' => in_array('testimonial_post_type', $this->get_option('shapla_testimonial')),
			'testimonial_meta_box' 	=> in_array('testimonial_metabox', $this->get_option('shapla_testimonial')),
			'feature_post_type' 	=> in_array('feature_post_type', $this->get_option('shapla_feature')),
			'feature_meta_box' 		=> in_array('feature_metabox', $this->get_option('shapla_feature')),
			'post_meta_box' 		=> false,
		);
		return apply_filters('shaplatools_options', $options);
	}

	/**
	 * Get option by option name
	 * 
	 * @param  string $option_name
	 * @return string
	 */
	private function get_option( $option_name )
	{
		if (isset($this->options[$option_name]))
		{
			return $this->options[$option_name];
		}

		return '';
	}

	public function has_shortcode( $shortcode )
	{
		global $post;
		if(is_a( $post, 'WP_Post' ) && has_shortcode($post->post_content, $shortcode)) {
			return true;
	    }

	    return false;
	}

	public function enqueue_scripts()
	{
		$options = $this->shaplatools_options();

		wp_enqueue_style( 'font-awesome', $this->plugin_url . '/assets/css/font-awesome.min.css' , '', '4.7.0', 'all' );
		wp_enqueue_style( 'shaplatools', $this->plugin_url . '/assets/css/style.css' , '', $this->version, 'all' );
		wp_register_script( 'shapla-shortcode-scripts', $this->plugin_url . '/assets/js/shapla-shortcode-scripts.js', array( 'jquery', 'jquery-ui-accordion', 'jquery-ui-tabs' ), $this->version, true );

        wp_register_script( 'retinajs', $this->plugin_url . '/assets/library/retina.min.js', array(), '2.1.0', true );
		wp_register_script( 'owl-carousel', $this->plugin_url . '/assets/library/owl.carousel.min.js', array( 'jquery' ), '2.0.0', true );
		wp_register_script( 'nivo-slider', $this->plugin_url . '/assets/library/nivo-slider.min.js', array( 'jquery' ), '3.2.0', true );
		wp_register_script( 'typeahead', $this->plugin_url. '/assets/library/typeahead.min.js', array('jquery'), $this->version, true );
		wp_register_script( 'shuffle', $this->plugin_url . '/assets/library/shuffle.min.js', array( 'jquery' ), $this->version, true );

		if( $options['retina_js'] ) {
			wp_enqueue_script( 'retinajs' );
	    }

	    if ( $options['typeahead_search'] == 'default_search' || $options['typeahead_search'] == 'product_search' ) {
	    	wp_enqueue_script( 'typeahead' );
	    }

		if($this->has_shortcode('shapla_testimonial') || $this->has_shortcode('shapla_team')) {
			wp_enqueue_script( 'owl-carousel' );
	    }

		if($this->has_shortcode('shapla_slide') ) {
			wp_enqueue_script( 'nivo-slider' );
	    }
     
	    if($this->has_shortcode('shapla_portfolio') ) {
			wp_enqueue_script( 'shuffle' );
	    }
	    
		wp_localize_script( 'jquery', 'shaplatools', array(
			'ajaxurl' 	=> admin_url( 'admin-ajax.php' ),
            'nonce' 	=> wp_create_nonce( 'shaplatools_nonce' ),
		));
	}

	public function admin_scripts( $hook )
	{
		global $post;
    	wp_enqueue_style( 'wp-color-picker' );
    	wp_enqueue_script( 'wp-color-picker' );
    	wp_enqueue_script( 'jquery-ui-datepicker' );
		wp_enqueue_media();
    	
		wp_enqueue_style( 'shaplatools-admin', $this->plugin_url . '/assets/css/admin-style.css' , array(), $this->version, 'all' );
		wp_enqueue_script('shaplatools-media-gallery', $this->plugin_url() . '/assets/js/admin-media-gallery.js', array('jquery'), $this->version, true);
		wp_localize_script( 'jquery', 'shaplatools', array(
			'ajaxurl' 	=> admin_url( 'admin-ajax.php' ),
            'nonce' 	=> wp_create_nonce( 'shaplatools_nonce' ),
            'post_id' 	=> $post ? $post->ID: '',
			'image_ids' => $post ? get_post_meta( $post->ID, '_shaplatools_images_ids', true ) : '',
		));

		if ( in_array( $hook, array( 'post.php', 'post-new.php' ) ) ) {

			wp_enqueue_style( 'font-awesome', $this->plugin_url . '/assets/css/font-awesome.min.css' , '', '4.7.0', 'all' );

			wp_register_script( 'font-awesome-icons-list', $this->plugin_url . '/assets/js/icons.js', array(), false, true );
			wp_enqueue_script( 'font-awesome-icons-list' );

			wp_enqueue_script( 'jquery-ui-sortable' );
			wp_enqueue_script( 'shapla-shortcode-plugins', $this->plugin_url . '/assets/js/shortcodes_plugins.js', array( 'font-awesome-icons-list' ), $this->version, true );

			wp_localize_script( 'jquery', 'ShaplaShortcodes', array(
				'plugin_folder'           => WP_PLUGIN_URL .'/shortcodes',
				'media_frame_video_title' => __( 'Upload or Choose Your Custom Video File', 'shaplatools' ),
				'media_frame_image_title' => __( 'Upload or Choose Your Custom Image File', 'shaplatools' )
			) );
		}
	}

	public function editor_styles()
	{
		$shortcode_styles = $this->plugin_url() . '/assets/css/editor-style.css';
		add_editor_style( $shortcode_styles );
	}

	/**
	 * Add shaplatools to body class for use on frontend.
	 *
	 * @since 1.0.0
	 * @return array $classes List of classes
	 */
	public function body_class( $classes ) {
		$classes[] = 'shaplatools';
		return $classes;
	}

	/**
	 * Add custom links on plugins page.
	 *
	 * @access public
	 * @param mixed $links
	 * @return void
	 */
	public function action_links( $links ) {
		$plugin_links = array(
			'<a href="' . admin_url( 'options-general.php?page=shaplatools' ) . '">' . __( 'Settings', 'shaplatools' ) . '</a>'
		);

		return array_merge( $plugin_links, $links );
	}

	/**
	 * Setup localisation.
	 *
	 * @return void
	 */
	function load_textdomain() {
		// Set filter for plugin's languages directory
		$shaplatools_lang_dir = dirname( plugin_basename( __FILE__ ) ) . '/languages/';
		$shaplatools_lang_dir = apply_filters( 'shaplatools_languages_directory', $shaplatools_lang_dir );

		// Traditional WordPress plugin locale filter
		$locale        = apply_filters( 'plugin_locale',  get_locale(), 'shaplatools' );
		$mofile        = sprintf( '%1$s-%2$s.mo', 'shaplatools', $locale );

		// Setup paths to current locale file
		$mofile_local  = $shaplatools_lang_dir . $mofile;
		$mofile_global = WP_LANG_DIR . '/shaplatools/' . $mofile;

		if ( file_exists( $mofile_global ) ) {
			// Look in global /wp-content/languages/shaplatools folder
			load_textdomain( $this->plugin_name, $mofile_global );
		} elseif ( file_exists( $mofile_local ) ) {
			// Look in local /wp-content/plugins/shaplatools/languages/ folder
			load_textdomain( $this->plugin_name, $mofile_local );
		} else {
			// Load the default language files
			load_plugin_textdomain( $this->plugin_name, false, $shaplatools_lang_dir );
		}
	}

	/**
	 * Print google-analytics script on site footer when enabled
	 * 
	 * @return string
	 */
	public function google_analytics_script(){
		$options 			= $this->shaplatools_options();
		if( !empty( $options['google_analytics'] ) ): ?>
        <script>
            (function(b,o,i,l,e,r){b.GoogleAnalyticsObject=l;b[l]||(b[l]=
            function(){(b[l].q=b[l].q||[]).push(arguments)});b[l].l=+new Date;
            e=o.createElement(i);r=o.getElementsByTagName(i)[0];
            e.src='//www.google-analytics.com/analytics.js';
            r.parentNode.insertBefore(e,r)}(window,document,'script','ga'));
            ga('create','<?php echo esc_attr( $options['google_analytics'] ); ?>','auto');ga('send','pageview');
        </script>
        <?php endif;
	}

	/**
	 * Flush the rewrite rules on activation
	 */
	public function shaplatools_activation()
	{
		ShaplaTools_Slide::post_type();
		ShaplaTools_Portfolio::post_type();
		ShaplaTools_Portfolio::taxonomy();
		ShaplaTools_Team::post_type();
		ShaplaTools_Feature::post_type();
		ShaplaTools_Testimonial::post_type();
		flush_rewrite_rules();
	}

	/**
	 * Flush the rewrite rules on deactivation
	 */
	public function shaplatools_deactivation()
	{
		ShaplaTools_Slide::post_type();
		ShaplaTools_Portfolio::post_type();
		ShaplaTools_Portfolio::taxonomy();
		ShaplaTools_Team::post_type();
		ShaplaTools_Feature::post_type();
		ShaplaTools_Testimonial::post_type();
		
		flush_rewrite_rules();
	}
}

endif;

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function shaplatools() {
	return ShaplaTools::instance();
}
// Global for backwards compatibility.
$GLOBALS['shaplatools'] = shaplatools();