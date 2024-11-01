<?php
/**
 * Testimonials Widget
 */
class Shapla_Testimonial extends WP_Widget {
	public function __construct() {
		parent::__construct( 
			'shapla_testimonial', 
			__( 'Shapla Testimonials', 'shaplatools' ),
			array( 'description' => __( 'Display client testimonials.', 'shaplatools' ), )
		);
	}

	public function widget( $args, $instance ) {
		extract( $args );
		$title = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );
		$posts_per_page = (int) $instance['posts_per_page'];
		$orderby = strip_tags( $instance['orderby'] );

		echo $before_widget;

		if ( ! empty( $title ) )
			echo $before_title . $title . $after_title;

		if (function_exists('shapla_testimonials_slide'))
			echo shapla_testimonials_slide( rand(1,99), $posts_per_page, 1, 1, 1, 1, $orderby);

		echo $after_widget;
	}

	public function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['posts_per_page'] = (int) $new_instance['posts_per_page'];
		$instance['orderby'] = strip_tags( $new_instance['orderby'] );

		return $instance;
	}

	public function form( $instance ) {
		$instance = wp_parse_args( (array) $instance, array( 'title' => '', 'posts_per_page' => '1', 'orderby' => 'none' ) );
		$title = strip_tags( $instance['title'] );
		$posts_per_page = (int) $instance['posts_per_page'];
		$orderby = strip_tags( $instance['orderby'] );
		?>
		<p><label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title:', 'shaplatools'); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" /></p>

		<p><label for="<?php echo $this->get_field_id( 'posts_per_page' ); ?>"><?php _e('Number of Testimonials:', 'shaplatools'); ?></label>
		<input type="number" min="1" max="6" class="widefat" id="<?php echo $this->get_field_id( 'posts_per_page' ); ?>" name="<?php echo $this->get_field_name( 'posts_per_page' ); ?>" value="<?php echo esc_attr( $posts_per_page ); ?>" />
		</p>

		<p><label for="<?php echo $this->get_field_id( 'orderby' ); ?>"><?php _e('Order By', 'shaplatools'); ?></label>
		<select id="<?php echo $this->get_field_id( 'orderby' ); ?>" name="<?php echo $this->get_field_name( 'orderby' ); ?>">
			<option value="none" <?php selected( $orderby, 'none' ); ?>><?php _e('None', 'shaplatools'); ?></option>
			<option value="ID" <?php selected( $orderby, 'ID' ); ?>><?php _e('ID', 'shaplatools'); ?></option>
			<option value="date" <?php selected( $orderby, 'date' ); ?>><?php _e('Date', 'shaplatools'); ?></option>
			<option value="modified" <?php selected( $orderby, 'modified' ); ?>><?php _e('Modified', 'shaplatools'); ?></option>
			<option value="rand" <?php selected( $orderby, 'rand' ); ?>><?php _e('Random', 'shaplatools'); ?></option>
		</select></p>
		<?php
	}
}
// Register the Widget
function shaplatools_register_widget_testimonial() {
	register_widget( 'Shapla_Testimonial' );
}