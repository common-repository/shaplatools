<?php

add_action( 'widgets_init', function(){
	register_widget( "Shapla_Tweet_Widget" );
});

class Shapla_Tweet_Widget extends WP_Widget{

	private $widget_id;
	private $text_domain;
	/**
	 * Register widget with WordPress.
	 */
	public function __construct() {

		$this->text_domain 	= 'shaplatools';
		$this->widget_id 	= 'shapla-latest-tweets';
		$widget_name 		= __( 'Shapla Latest Tweets', 'shaplatools' );
		$widget_options = array(
			'classname' => 'widget_shapla_tweets',
			'description' => __( 'Displays your latest tweets from Twitter.', 'shaplatools' ),
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

    /**
     * Making request to Twitter API
     */
	public function twitter_timeline( $username, $limit, $oauth_access_token, $oauth_access_token_secret, $consumer_key, $consumer_secret ) {
	    require_once 'TwitterWP.php';

	    $app = array(
		    'consumer_key'        => $consumer_key,
		    'consumer_secret'     => $consumer_secret,
		    'access_token'        => $oauth_access_token,
		    'access_token_secret' => $oauth_access_token_secret,
		);
		$TwitterWP = TwitterWP::start( $app );

		// bail here if the user doesn't exist
		if ( ! $TwitterWP->user_exists( $username ) ) {
			return;
		}
	     
	    $query = $TwitterWP->get_tweets( $username, $limit );
	     
	    // $timeline = json_decode($query);
	 
	    return $query;
	}

    /**
     * To make the tweet time more user-friendly
     */
	public function tweet_time( $time ) {
	    // Get current timestamp.
	    $now = strtotime( 'now' );
	 
	    // Get timestamp when tweet created.
	    $created = strtotime( $time );
	 
	    // Get difference.
	    $difference = $now - $created;
	 
	    // Calculate different time values.
	    $minute = 60;
	    $hour = $minute * 60;
	    $day = $hour * 24;
	    $week = $day * 7;
	 
	    if ( is_numeric( $difference ) && $difference > 0 ) {
	 
	        // If less than 3 seconds.
	        if ( $difference < 3 ) {
	            return __( 'right now', 'shaplatools' );
	        }
	 
	        // If less than minute.
	        if ( $difference < $minute ) {
	            return floor( $difference ) . ' ' . __( 'seconds ago', 'shaplatools' );;
	        }
	 
	        // If less than 2 minutes.
	        if ( $difference < $minute * 2 ) {
	            return __( 'about 1 minute ago', 'shaplatools' );
	        }
	 
	        // If less than hour.
	        if ( $difference < $hour ) {
	            return floor( $difference / $minute ) . ' ' . __( 'minutes ago', 'shaplatools' );
	        }
	 
	        // If less than 2 hours.
	        if ( $difference < $hour * 2 ) {
	            return __( 'about 1 hour ago', 'shaplatools' );
	        }
	 
	        // If less than day.
	        if ( $difference < $day ) {
	            return floor( $difference / $hour ) . ' ' . __( 'hours ago', 'shaplatools' );
	        }
	 
	        // If more than day, but less than 2 days.
	        if ( $difference > $day && $difference < $day * 2 ) {
	            return __( 'yesterday', 'shaplatools' );;
	        }
	 
	        // If less than year.
	        if ( $difference < $day * 365 ) {
	            return floor( $difference / $day ) . ' ' . __( 'days ago', 'shaplatools' );
	        }
	 
	        // Else return more than a year.
	        return __( 'over a year ago', 'shaplatools' );
	    }
	}

	/**
	 * Front-end display of widget.
	 *
	 * @see WP_Widget::widget()
	 *
	 * @param array $args     Widget arguments.
	 * @param array $instance Saved values from database.
	 */
	public function widget( $args, $instance ) {
		
		if ( $this->get_cached_widget( $args ) ){
			return;
		}

		ob_start();

	    $title                     = apply_filters( 'widget_title', $instance['title'] );
	    $username                  = $instance['twitter_username'];
	    $limit                     = (!empty($instance['update_count'])) ? $instance['update_count'] : 5;
	    $oauth_access_token        = $instance['oauth_access_token'];
	    $oauth_access_token_secret = $instance['oauth_access_token_secret'];
	    $consumer_key              = $instance['consumer_key'];
	    $consumer_secret           = $instance['consumer_secret'];
	 
	    echo $args['before_widget'];
	 
	    if ( ! empty( $title ) ) {
	        echo $args['before_title'] . $title . $args['after_title'];
	    }

	    if ( !empty($username) && !empty($oauth_access_token) && !empty($oauth_access_token_secret) && !empty($consumer_key) && !empty($consumer_secret) ) {
		    // Get the tweets.
		    $timelines = $this->twitter_timeline( $username, $limit, $oauth_access_token, $oauth_access_token_secret, $consumer_key, $consumer_secret );
		 
		    if ( $timelines ) {
		 
		        // Add links to URL and username mention in tweets.
		        $patterns = array( '@(https?://([-\w\.]+)+(:\d+)?(/([\w/_\.]*(\?\S+)?)?)?)@', '/@([A-Za-z0-9_]{1,15})/' );
		        $replace = array( '<a href="$1">$1</a>', '<a href="http://twitter.com/$1">@$1</a>' );
		 			        
		 		echo '<ul class="shapla-twitter">';
		        foreach ( $timelines as $timeline ) {
		            $result = preg_replace( $patterns, $replace, $timeline->text );
		 
		            echo '<li>';
		                echo $result;
		                echo '<span>'.$this->tweet_time( $timeline->created_at ).'</span>';
		            echo '</li>';
		        }
		        echo '</ul>';
		 
		    } else {
		        _e( 'Error fetching feeds. Please verify the Twitter settings in the widget.', 'shaplatools' );
		    }
	    }
	 
	    echo $args['after_widget'];

		$content = ob_get_clean();

		echo $content;

		$this->cache_widget( $args, $content );
	}

	/**
	 * Back-end widget form.
	 *
	 * @see WP_Widget::form()
	 *
	 * @param array $instance Previously saved values from database.
	 */
	public function form( $instance ) {
     	$title = ! empty( $instance['title'] ) ? $instance['title'] : __( 'Latest Tweets', 'shaplatools' );
     	$twitter_username = ! empty( $instance['twitter_username'] ) ? $instance['twitter_username'] : '';
     	$update_count = ! empty( $instance['update_count'] ) ? $instance['update_count'] : '';
     	$oauth_access_token = ! empty( $instance['oauth_access_token'] ) ? $instance['oauth_access_token'] : '';
     	$oauth_access_token_secret = ! empty( $instance['oauth_access_token_secret'] ) ? $instance['oauth_access_token_secret'] : '';
     	$consumer_key = ! empty( $instance['consumer_key'] ) ? $instance['consumer_key'] : '';
     	$consumer_secret = ! empty( $instance['consumer_secret'] ) ? $instance['consumer_secret'] : '';
		?>
	    <p>
	        <label for="<?php echo $this->get_field_id( 'title' ); ?>">
	            <?php _e( 'Title', 'shaplatools' ); ?>
	        </label>
	        <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php if(isset($title)){echo esc_attr( $title );} ?>" />
	    </p>
	    <p>
	        <label for="<?php echo $this->get_field_id( 'twitter_username' ); ?>">
	            <?php _e( 'Twitter Username (without @)', 'shaplatools' ); ?>
	        </label>
	        <input class="widefat" id="<?php echo $this->get_field_id( 'twitter_username' ); ?>" name="<?php echo $this->get_field_name( 'twitter_username' ); ?>" type="text" value="<?php if(isset($twitter_username)){echo esc_attr( $twitter_username );} ?>" />
	    </p>
	    <p>
	        <label for="<?php echo $this->get_field_id( 'update_count' ); ?>">
	            <?php _e( 'Number of Tweets to Display', 'shaplatools' ); ?>
	        </label>
	        <input class="widefat" id="<?php echo $this->get_field_id( 'update_count' ); ?>" name="<?php echo $this->get_field_name( 'update_count' ); ?>" type="number" value="<?php if(isset($update_count)){echo esc_attr( $update_count );} ?>" />
	    </p>
	    <p>
	        <label for="<?php echo $this->get_field_id( 'consumer_key' ); ?>">
	            <?php _e( 'Consumer Key', 'shaplatools' ); ?>
	        </label>
	        <input class="widefat" id="<?php echo $this->get_field_id( 'consumer_key' ); ?>" name="<?php echo $this->get_field_name( 'consumer_key' ); ?>" type="text" value="<?php if(isset($consumer_key)){echo esc_attr( $consumer_key );} ?>" />
	        <small><?php _e('Don\'t know your Consumer Key, Consumer Secret, Access Token and Access Token Secret? <a target="_blank" href="http://sayful1.wordpress.com/2014/06/14/how-to-generate-twitter-api-key-api-secret-access-token-access-token-secret/">Click here to get help.</a>', 'shaplatools'); ?></small>
	    </p>
	    <p>
	        <label for="<?php echo $this->get_field_id( 'consumer_secret' ); ?>">
	            <?php _e( 'Consumer Secret', 'shaplatools' ); ?>
	        </label>
	        <input class="widefat" id="<?php echo $this->get_field_id( 'consumer_secret' ); ?>" name="<?php echo $this->get_field_name( 'consumer_secret' ); ?>" type="text" value="<?php if(isset($consumer_secret)){echo esc_attr( $consumer_secret );} ?>" />
	    </p>
	    <p>
	        <label for="<?php echo $this->get_field_id( 'oauth_access_token' ); ?>">
	            <?php _e( 'Access Token', 'shaplatools' ); ?>
	        </label>
	        <input class="widefat" id="<?php echo $this->get_field_id( 'oauth_access_token' ); ?>" name="<?php echo $this->get_field_name( 'oauth_access_token' ); ?>" type="text" value="<?php if(isset($oauth_access_token)){echo esc_attr( $oauth_access_token );} ?>" />
	    </p>
	    <p>
	        <label for="<?php echo $this->get_field_id( 'oauth_access_token_secret' ); ?>">
	            <?php _e( 'Access Token Secret', 'shaplatools' ); ?>
	        </label>
	        <input class="widefat" id="<?php echo $this->get_field_id( 'oauth_access_token_secret' ); ?>" name="<?php echo $this->get_field_name( 'oauth_access_token_secret' ); ?>" type="text" value="<?php if(isset($oauth_access_token_secret)){echo esc_attr( $oauth_access_token_secret );} ?>" />
	    </p>
		<?php 
	}

	/**
	 * Sanitize widget form values as they are saved.
	 *
	 * @see WP_Widget::update()
	 *
	 * @param array $new_instance Values just sent to be saved.
	 * @param array $old_instance Previously saved values from database.
	 *
	 * @return array Updated safe values to be saved.
	 */
	public function update( $new_instance, $old_instance ) {
		$instance = array();

		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
	    $instance['twitter_username'] = ( ! empty( $new_instance['twitter_username'] ) ) ? strip_tags( $new_instance['twitter_username'] ) : '';
	    $instance['update_count'] = ( ! empty( $new_instance['update_count'] ) ) ? strip_tags( $new_instance['update_count'] ) : '';
	    $instance['oauth_access_token'] = ( ! empty( $new_instance['oauth_access_token'] ) ) ? strip_tags( $new_instance['oauth_access_token'] ) : '';
	    $instance['oauth_access_token_secret'] = ( ! empty( $new_instance['oauth_access_token_secret'] ) ) ? strip_tags( $new_instance['oauth_access_token_secret'] ) : '';
	    $instance['consumer_key'] = ( ! empty( $new_instance['consumer_key'] ) ) ? strip_tags( $new_instance['consumer_key'] ) : '';
	    $instance['consumer_secret'] = ( ! empty( $new_instance['consumer_secret'] ) ) ? strip_tags( $new_instance['consumer_secret'] ) : '';

		return $instance;
	}
}
