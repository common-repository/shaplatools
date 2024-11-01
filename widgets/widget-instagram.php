<?php
add_action( 'widgets_init', function(){
	register_widget( "Shapla_Instagram_Widget" );
});

class Shapla_Instagram_Widget extends WP_Widget {

	private $widget_id;
	private $text_domain;
	/**
	 * Register widget with WordPress.
	 */
	public function __construct() {

		$this->text_domain 	= 'shaplatools';
		$this->widget_id 	= 'shapla-instagram';
		$widget_name 		= __( 'Shapla Instagram Photos', 'shaplatools' );
		$widget_options = array(
			'classname' => 'widget_shapla_instagram',
			'description' => __( 'A widget that displays your Instagram feed, posts, or likes.', 'shaplatools' ),
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

		ob_start();

		extract( $args );

		echo $before_widget;

		$title     = apply_filters( 'widget_title', $instance['title'] );
		$username  = esc_html( $instance['username'] );
		$count     = absint( $instance['count'] );
		$image_res = esc_html( $instance['size'] );
		$cachetime = absint( $instance['cachetime'] );

		// Get Instagrams
		$instagram = $this->get_instagrams( array(
			'username'  => $username,
			'count'     => $count,
			'cachetime' => $cachetime,
		) );

		if ( $title ) echo $before_title . $title . $after_title;

		// And if we have Instagrams
		if ( false !== $instagram ) :

		?>

		<div class="instagram-row">
			<?php
				$displayed = 0;
				foreach ( $instagram['items'] as $key => $image ) {
					$displayed++;
					
					echo apply_filters( 'st_instagram_widget_image_html', sprintf( '<div class="instagram-col %4$s"><a href="%1$s"><img class="instagram-image" src="%2$s" alt="%3$s" title="%3$s" /></a></div>',
						$image['link'],
						str_replace( 'http:', '', $image['images'][ $image_res ]['url'] ),
						$image['caption']['text'],
						esc_attr( $image_res )
					), $image );
				}
			?>

		</div>

		<a class="instagram-follow-link" href="https://instagram.com/<?php echo esc_html( $username ); ?>"><?php printf( __( 'Follow %1$s on Instagram', 'shaplatools' ), esc_html( $username ) ); ?></a>

		<?php elseif ( ( defined( 'WP_DEBUG' ) && true === WP_DEBUG ) && ( defined( 'WP_DEBUG_DISPLAY' ) && false !== WP_DEBUG_DISPLAY ) ) : ?>
			<div id="message" class="error"><p><?php _e( 'Error: We were unable to fetch your instagram feed.', 'shaplatools' ); ?></p></div>
		<?php endif;

		echo $after_widget;

		$content = ob_get_clean();

		echo $content;

		$this->cache_widget( $args, $content );
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		$instance['title']     = esc_attr( $new_instance['title'] );
		$instance['username']  = esc_attr( $new_instance['username'] );
		$instance['size']      = esc_attr( $new_instance['size'] );
		$instance['cachetime'] = absint( $new_instance['cachetime'] );
		$instance['count']     = absint( $new_instance['count'] );

		$this->flush_widget_cache();

		return $instance;
	}

	function form( $instance ){
		$defaults = array(
			'title'     => __( 'Instagram Photos', 'shaplatools' ),
			'username'  => '',
			'cachetime' => '2',
			'size'      => 'thumbnail',
			'count'     => 9,
		);

		$instance = wp_parse_args( (array) $instance, $defaults );

		?>

		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e( 'Title:', 'shaplatools' ); ?></label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo $instance['title']; ?>">
		</p>

		<p>
			<label for="<?php echo $this->get_field_id('username'); ?>"><?php _e( 'Instagram Username:', 'shaplatools' ); ?></label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id('username'); ?>" name="<?php echo $this->get_field_name('username'); ?>" value="<?php echo $instance['username']; ?>">
		</p>

		<p>
			<label for="<?php echo $this->get_field_id('count'); ?>"><?php _e( 'Photo Count:', 'shaplatools' ); ?></label>
			<input type="number" min="1" max="20" class="widefat" id="<?php echo $this->get_field_id('count'); ?>" name="<?php echo $this->get_field_name('count'); ?>" value="<?php echo $instance['count']; ?>">
		</p>

		<p>
			<label for="<?php echo $this->get_field_id('size'); ?>"><?php _e( 'Photo Size:', 'shaplatools' ); ?></label>
			<select id="<?php echo $this->get_field_id('size'); ?>" name="<?php echo $this->get_field_name('size'); ?>" class="widefat">
				<option value="thumbnail" <?php selected('thumbnail', $instance['size']) ?>><?php _e('Thumbnail', 'shaplatools'); ?></option>
				<option value="low_resolution" <?php selected('low_resolution', $instance['size']) ?>><?php _e('Low Resolution', 'shaplatools'); ?></option>
				<option value="standard_resolution" <?php selected('standard_resolution', $instance['size']) ?>><?php _e('High Resolution', 'shaplatools'); ?></option>
			</select>
		</p>

		<p>
			<label for="<?php echo $this->get_field_id('cachetime'); ?>"><?php _e( 'Cache time (in hours):', 'shaplatools' ); ?></label>
			<input type="number" min="1" max="500" step="1" id="<?php echo $this->get_field_id('cachetime'); ?>" name="<?php echo $this->get_field_name('cachetime'); ?>" value="<?php echo $instance['cachetime']; ?>">
		</p>

		<?php
	}

	/**
	 * Get relevant data from Instagram API.
	 *
	 * @param	array $args Argument to passed to Instagram API.
	 * @return  array 		An array returning Instagram API data.
	 */
	public function get_instagrams( $args = array() ) {
		// Get args
		$username   = ( ! empty( $args['username'] ) ) ? $args['username'] : '';
		$count     = ( ! empty( $args['count'] ) ) ? $args['count'] : 9;
		$cachetime = ( ! empty( $args['cachetime'] ) ) ? $args['cachetime'] : 2;

		// If no user id, bail
		if ( empty( $username ) ) {
			return false;
		}

		$key = "stag_instagram_{$username}";

		if ( false === ( $instagrams = get_transient( $key ) ) ) {
			// Ping Instagram's API
			$api_url = "https://www.instagram.com/{$username}/media/";
			$response = wp_remote_get( $api_url );

			// Check if the API is up.
			if ( ! 200 == wp_remote_retrieve_response_code( $response ) ) {
				return false;
			}

			// Parse the API data and place into an array
			$instagrams = json_decode( wp_remote_retrieve_body( $response ), true );

			// Are the results in an array?
			if ( ! is_array( $instagrams ) ) {
				return false;
			}

			$instagrams = maybe_unserialize( $instagrams );

			// Store Instagrams in a transient, and expire every hour
			set_transient( $key, $instagrams, $cachetime * HOUR_IN_SECONDS );
		}

		return $instagrams;
	}
}
