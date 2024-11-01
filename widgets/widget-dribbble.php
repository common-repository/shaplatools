<?php
/**
 * Display your latest Dribbble shots.
 */
class Shapla_Dribbble_Widget extends WP_Widget
{
	private $widget_id;
	private $text_domain;
	/**
	 * Register widget with WordPress.
	 */
	public function __construct() {

		$this->text_domain 	= 'shaplatools';
		$this->widget_id 	= 'shapla-dribbble';
		$widget_name 		= __( 'Shapla Dribbble Shots', 'shaplatools' );
		$widget_options = array(
			'classname' => 'widget_shapla_dribbble',
			'description' => __( 'Display your latest Dribbble shots.', 'shaplatools' ),
		);

		parent::__construct( $this->widget_id, $widget_name, $widget_options );

		add_action( 'save_post', array( $this, 'flush_widget_cache' ) );
		add_action( 'deleted_post', array( $this, 'flush_widget_cache' ) );
		add_action( 'switch_theme', array( $this, 'flush_widget_cache' ) );
	}

	function get_cached_widget( $args ) {
		$cache = wp_cache_get( $this->widget_id, 'widget' );

		if ( ! is_array( $cache ) )
			$cache = array();

		if ( isset( $cache[ $args[ 'widget_id' ] ] ) ) {
			echo $cache[ $args[ 'widget_id' ] ];
			return true;
		}

		return false;
	}

	public function cache_widget( $args, $content ) {
		$cache[ $args[ 'widget_id' ] ] = $content;

		wp_cache_set( $this->widget_id, $cache, 'widget' );
	}

	public function flush_widget_cache() {
		wp_cache_delete( $this->widget_id, 'widget' );
	}

	function widget( $args, $instance ) {

		if ( $this->get_cached_widget( $args ) ){
			return;
		}

		ob_start();

		extract( $args );

		echo $before_widget;

		$title          = apply_filters( 'widget_title', $instance['title'] );
		$dribbble_name 	= esc_html($instance['dribbble_name']);
		$count 			= absint($instance['dribbble_shots']);
		$new_window     = $instance['new_window'];

		// Includes feed function
		include_once(ABSPATH . WPINC . '/feed.php');

		$rss = fetch_feed( "https://dribbble.com/$dribbble_name/shots.rss" );

		add_filter( 'wp_feed_cache_transient_lifetime', create_function( '$a', 'return 1800;' ) );
		
		if( !is_wp_error( $rss ) ){
			$items = $rss->get_items( 0, $rss->get_item_quantity( $count ) );
		}

		?>
		<?php if ( $title ) echo $before_title . $title . $after_title; ?>
		<ul class="dribbble-list">
			<?php if( isset( $items ) ) : ?>
				<?php foreach( $items as $item ) :
					$shot_title       = $item->get_title();
					$shot_link        = $item->get_permalink();
					$shot_date        = $item->get_date('F d, Y');
					$shot_description = $item->get_description();

					preg_match("/src=\"(http.*(jpg|jpeg|gif|png))/", $shot_description, $shot_image_url);
					$shot_image = $shot_image_url[1];
				?>
				<li class="dribbble-list-item">
					<a href="<?php echo esc_url( $shot_link ); ?>" class="dribbble-link" title="<?php echo $shot_title; ?>" <?php if( $new_window == 1) echo 'target="_blank"'; ?>>
						<img src="<?php echo $shot_image; ?>" alt="<?php echo $shot_title; ?>">
					</a>
				</li>
				<?php endforeach; ?>
			<?php else: ?>
				<?php _x( 'Please check your dribbble username', 'Dribbble username error message', 'shaplatools' ); ?>
			<?php endif; ?>
		</ul>
		<?php
		echo $after_widget;

		$content = ob_get_clean();

		echo $content;

		$this->cache_widget( $args, $content );
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		
		$instance['title']          = sanitize_text_field( $new_instance['title'] );
		$instance['dribbble_name']  = sanitize_text_field( $new_instance['dribbble_name'] );
		$instance['new_window']     = sanitize_text_field($new_instance['new_window']);
		$instance['dribbble_shots'] = absint( $new_instance['dribbble_shots'] );

		$this->flush_widget_cache();
		
		return $instance;
	}

	function form( $instance ){
		$defaults = array(
			'title' 			=> __( 'Dribbble Shots', 'shaplatools' ),
			'dribbble_name' 	=> '',
			'dribbble_shots' 	=> 4,
			'new_window' 		=> ''
		);

		$instance = wp_parse_args( (array) $instance, $defaults );

		?>

		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e( 'Title:', 'shaplatools' ); ?></label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo $instance['title']; ?>">
		</p>

		<p>
			<label for="<?php echo $this->get_field_id('dribbble_name'); ?>"><?php _e( 'Username:', 'shaplatools' ); ?></label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id('dribbble_name'); ?>" name="<?php echo $this->get_field_name('dribbble_name'); ?>" value="<?php echo $instance['dribbble_name']; ?>">
		</p>

		<p>
			<label for="<?php echo $this->get_field_id('dribbble_shots'); ?>"><?php _e( 'Number of shots to show:', 'shaplatools' ); ?></label>
			<input type="number" min="1" max="10" step="1" class="small-text" id="<?php echo $this->get_field_id('dribbble_shots'); ?>" name="<?php echo $this->get_field_name('dribbble_shots'); ?>" value="<?php echo $instance['dribbble_shots']; ?>">
		</p>

		<p>
			<input type="checkbox" class="checkbox" id="<?php echo $this->get_field_id('new_window'); ?>" name="<?php echo $this->get_field_name('new_window'); ?>" value="1" <?php checked( $instance['new_window'], 1); ?>>
			<label for="<?php echo $this->get_field_id('new_window'); ?>"><?php _e( 'Open links in new window?', 'shaplatools' ); ?></label>
		</p>

		<?php
	}
}

add_action( 'widgets_init', function(){
	register_widget( "Shapla_Dribbble_Widget" );
});
