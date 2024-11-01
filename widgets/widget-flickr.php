<?php
add_action( 'widgets_init', function(){
	register_widget( "Shapla_Flickr_Widget" );
});

class Shapla_Flickr_Widget extends WP_Widget {

	private $widget_id;
	private $text_domain;

	/**
	 * Register widget with WordPress.
	 */
	public function __construct() {

		$this->text_domain 	= 'shaplatools';
		$this->widget_id 	= 'shapla-flickr';
		$widget_name 		= __( 'Shapla Flickr Photos', 'shaplatools' );
		$widget_options = array(
			'classname' => 'widget_shapla_flickr',
			'description' => __( 'Display your latest Flickr photos.', 'shaplatools' ),
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
		
		$title        = apply_filters( 'widget_title', $instance['title'] );
		$flickr_id    = esc_attr($instance['flickr_id']);
		$flickr_count = absint($instance['flickr_count']);
		
		include_once(ABSPATH . WPINC . '/feed.php');

		$rss = fetch_feed('http://api.flickr.com/services/feeds/photos_public.gne?ids='.$flickr_id.'&lang=en-us&format=rss_200');
		add_filter( 'wp_feed_cache_transient_lifetime', create_function( '$a', 'return 1800;' ) );

		if( !is_wp_error( $rss ) ){
			$items = $rss->get_items( 0, $rss->get_item_quantity( $flickr_count ) );
		}

		echo $before_widget;

		?>
	
		<div class='shapla-flickr-widget'>
			<?php if ( $title ) echo $before_title . $title . $after_title; ?>
			<div class="shapla-flickr-row">
				<?php
				if ( isset( $items ) ) {
					foreach( $items as $item ) {
						$image_group = $item->get_item_tags('http://search.yahoo.com/mrss/', 'thumbnail');
						$image_attrs = $image_group[0]['attribs'];
						foreach( $image_attrs as $image ) {
							$url = $image['url'];
							$width = $image['width'];
							$height = $image['height'];
							echo '<div class="shapla-flickr-col"><a target="_blank" href="' . $item->get_permalink() . '"><img src="'. $url .'" width="' . $width . '" height="' . $height . '" alt="'. $item->get_title() .'"></a></div>';
						}
					}
				} else {
					_e( 'Invalid flickr ID', 'shaplatools' );
				}
				?>
			</div>
		</div>
		<?php
		echo $after_widget;

		$content = ob_get_clean();

		echo $content;

		$this->cache_widget( $args, $content );
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		
		$instance['title']        = sanitize_text_field( $new_instance['title'] );
		$instance['flickr_id']    = sanitize_text_field( $new_instance['flickr_id'] );
		$instance['flickr_count'] = absint( $new_instance['flickr_count'] );

		$this->flush_widget_cache();

		return $instance;
	}

	function form( $instance ){
		$defaults = array(
			'title'        => __( 'Flickr Photos', 'shaplatools' ),
			'flickr_id'    => '',
			'flickr_count' => 4,
		);
		$instance = wp_parse_args( (array) $instance, $defaults );

		?>
		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e( 'Title:', 'shaplatools' ); ?></label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo $instance['title']; ?>">
		</p>

		<p>
			<label for="<?php echo $this->get_field_id('flickr_id'); ?>"><?php _e( 'Your Flickr User ID:', 'shaplatools' ); ?></label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id('flickr_id'); ?>" name="<?php echo $this->get_field_name('flickr_id'); ?>" value="<?php echo $instance['flickr_id']; ?>">
			<span class="description"><?php echo sprintf( __( 'Head over to %s to find your Flickr user ID.', 'shaplatools' ), '<a href="//idgettr.com" target="_blank" rel="nofollow">idgettr</a>' ); ?></span>
		</p>

		<p>
			<label for="<?php echo $this->get_field_id('flickr_count'); ?>"><?php _e( 'Number of photos to show:', 'shaplatools' ); ?></label>
			<input type="number" class="small-text" id="<?php echo $this->get_field_id('flickr_count'); ?>" name="<?php echo $this->get_field_name('flickr_count'); ?>" value="<?php echo $instance['flickr_count']; ?>">
		</p>
		<?php
	}

}
