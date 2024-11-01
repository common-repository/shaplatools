<?php

if( !class_exists('ShaplaTools_NivoSlide_Metabox') ):

class ShaplaTools_NivoSlide_Metabox
{
	private $plugin_name;
	private $plugin_url;
	
	/**
	 * Hook into the appropriate actions when the class is constructed.
	 */
	public function __construct( $plugin_name, $plugin_url ) {

		$this->plugin_name = $plugin_name;
		$this->plugin_url = $plugin_url;

		add_action( 'add_meta_boxes', array( $this, 'add_meta_box' ) );
		add_filter( 'manage_edit-slide_columns', array ($this, 'columns_head') );
		add_action( 'manage_slide_posts_custom_column', array ($this, 'columns_content') );
	}

	private function available_img_size(){
	    $shaplatools_img_size = get_intermediate_image_sizes();
	    array_push($shaplatools_img_size, 'full');

	    $singleArray = array();

	    foreach ($shaplatools_img_size as $key => $value){

	        $singleArray[$value] = $value;
	    }

	    return $singleArray;
	}

	/**
	 * Adds the meta box container.
	 */
	public function add_meta_box() {
		$meta_box = array(
		    'id' => 'shapla-metabox-slide',
		    'title' => __('Slide Settings', 'shaplatools'),
		    'description' => sprintf(
		    	__('To use this slider in your posts or pages use the following shortcode: %s%s%s', 'shaplatools'),
		    	'<pre><code>[shapla_slide id="',
		    	get_the_ID(),
		    	'"]</code></pre><br>'
		    ),
		    'screen' => 'slide',
		    'context' => 'normal',
		    'priority' => 'high',
		    'fields' => array(
		        array(
		            'name' => __('Slider Images', 'shaplatools'),
		            'desc' => __('Choose slider images.', 'shaplatools'),
		            'id' => '_shapla_slide_images',
		            'type' => 'images',
		            'std' => __('Upload Images', 'shaplatools')
		        ),
		        array(
		            'name' => __('Slider Image Size', 'shaplatools'),
		            'desc' => __('Select image size from available image size. Use full for original image size.', 'shaplatools'),
		            'id' => '_shapla_slide_img_size',
		            'type' => 'select',
		            'std' => 'full',
		            'options' => $this->available_img_size()
		        ),
		        array(
		            'name' => __('Slider Theme', 'shaplatools'),
		            'desc' => __('Use a pre-built theme. To use your own theme select "None".', 'shaplatools'),
		            'id' => '_shapla_slide_theme',
		            'type' => 'select',
		            'std' => 'sunny',
		            'options' => array(
		            	'none' 		=> __('None', 'shaplatools'),
		            	'default' 	=> __('Default', 'shaplatools'),
		            	'light' 	=> __('Light', 'shaplatools'),
		            	'dark' 		=> __('Dark', 'shaplatools'),
		            	'bar' 		=> __('Bar', 'shaplatools'),
		            	'smoothness'=> __('Smoothness', 'shaplatools'),
		            )
		        ),
		        array(
		            'name' => __('Transition Effect', 'shaplatools'),
		            'desc' => __('Select transition for for this slide.', 'shaplatools'),
		            'id' => '_shapla_slide_transition',
		            'type' => 'select',
		            'std' => 'random',
		            'options' => array(
		            	'random' 			=> __('random', 'shaplatools'),
		            	'sliceDown' 		=> __('sliceDown', 'shaplatools'),
		            	'sliceDownLeft' 	=> __('sliceDownLeft', 'shaplatools'),
		            	'sliceUp' 			=> __('sliceUp', 'shaplatools'),
		            	'sliceUpLeft' 		=> __('sliceUpLeft', 'shaplatools'),
		            	'sliceUpDown' 		=> __('sliceUpDown', 'shaplatools'),
		            	'sliceUpDownLeft' 	=> __('sliceUpDownLeft', 'shaplatools'),
		            	'fold' 				=> __('fold', 'shaplatools'),
		            	'fade' 				=> __('fade', 'shaplatools'),
		            	'slideInRight' 		=> __('slideInRight', 'shaplatools'),
		            	'slideInLeft' 		=> __('slideInLeft', 'shaplatools'),
		            	'boxRandom' 		=> __('boxRandom', 'shaplatools'),
		            	'boxRain' 			=> __('boxRain', 'shaplatools'),
		            	'boxRainReverse' 	=> __('boxRainReverse', 'shaplatools'),
		            	'boxRainGrow' 		=> __('boxRainGrow', 'shaplatools'),
		            	'boxRainGrowReverse'	=> __('boxRainGrowReverse', 'shaplatools')
		            )
		        ),
		        array(
		            'name' => __('Slices', 'shaplatools'),
		            'desc' => __('The number of slices to use in the "Slice" transitions (eg 15)', 'shaplatools'),
		            'id' => '_shapla_slide_slices',
		            'type' => 'text',
		            'std' => '15'
		        ),
		        array(
		            'name' => __('boxCols', 'shaplatools'),
		            'desc' => __('The number of columns to use in the "Box" transitions (eg 8)', 'shaplatools'),
		            'id' => '_shapla_slide_boxcols',
		            'type' => 'text',
		            'std' => '8'
		        ),
		        array(
		            'name' => __('boxRows', 'shaplatools'),
		            'desc' => __('The number of rows to use in the "Box" transitions (eg 4)', 'shaplatools'),
		            'id' => '_shapla_slide_boxrows',
		            'type' => 'text',
		            'std' => '4'
		        ),
		        array(
		            'name' => __('Animation Speed', 'shaplatools'),
		            'desc' => __('The speed of the transition animation in milliseconds (eg 500)', 'shaplatools'),
		            'id' => '_shapla_slide_animation_speed',
		            'type' => 'text',
		            'std' => '500'
		        ),
		        array(
		            'name' => __('Pause Time', 'shaplatools'),
		            'desc' => __('The amount of time to show each slide in milliseconds (eg 3000)', 'shaplatools'),
		            'id' => '_shapla_slide_pause_time',
		            'type' => 'text',
		            'std' => '3000'
		        ),
		        array(
		            'name' => __('Start Slide', 'shaplatools'),
		            'desc' => __('Set which slide the slider starts from (zero based index: usually 0)', 'shaplatools'),
		            'id' => '_shapla_slide_start',
		            'type' => 'text',
		            'std' => '0'
		        ),
		        array(
		            'name' => __('Enable Thumbnail Navigation', 'shaplatools'),
		            'desc' => '',
		            'id' => '_shapla_slide_thumb_nav',
		            'type' => 'checkbox',
		            'std' => ''
		        ),
		        array(
		            'name' => __('Enable Direction Navigation', 'shaplatools'),
		            'desc' => __('Prev & Next arrows', 'shaplatools'),
		            'id' => '_shapla_slide_dir_nav',
		            'type' => 'checkbox',
		            'std' => true
		        ),
		        array(
		            'name' => __('Enable Control Navigation', 'shaplatools'),
		            'desc' => __('eg 1,2,3...', 'shaplatools'),
		            'id' => '_shapla_slide_ctrl_nav',
		            'type' => 'checkbox',
		            'std' => true
		        ),
		        array(
		            'name' => __('Pause the Slider on Hover', 'shaplatools'),
		            'desc' => '',
		            'id' => '_shapla_slide_hover_pause',
		            'type' => 'checkbox',
		            'std' => true
		        ),
		        array(
		            'name' => __('Manual Transitions', 'shaplatools'),
		            'desc' => __('Slider is always paused', 'shaplatools'),
		            'id' => '_shapla_slide_transition_man',
		            'type' => 'checkbox',
		            'std' => ''
		        ),
		        array(
		            'name' => __('Random Start Slide', 'shaplatools'),
		            'desc' => __('Overrides Start Slide value', 'shaplatools'),
		            'id' => '_shapla_slide_start_rand',
		            'type' => 'checkbox',
		            'std' => ''
		        ),
		    )
		);
		$nivoSlideMeta = new ShaplaTools_Meta_Box();
		$nivoSlideMeta->add($meta_box);
	}

	public function columns_head( $defaults ) {
		unset( $defaults['date'] );

		$defaults['id'] 		= __( 'Slide ID', 'shaplatools' );
		$defaults['shortcode'] 	= __( 'Shortcode', 'shaplatools' );
		$defaults['images'] 	= __( 'Images', 'shaplatools' );

		return $defaults;
	}

	public function columns_content( $column_name ) {

		$image_ids 	= explode(',', get_post_meta( get_the_ID(), '_shapla_image_ids', true) );

		if ( 'id' == $column_name ) {
			echo get_the_ID();
		}

		if ( 'shortcode' == $column_name ) {
			echo '<pre><code>[shapla_slide id="'.get_the_ID().'"]</pre></code>';
		}

		if ( 'images' == $column_name ) {
			?>
			<ul id="slider-thumbs" class="slider-thumbs">
				<?php

				foreach ( $image_ids as $image ) {
					if(!$image) continue;
					$src = wp_get_attachment_image_src( $image, array(50,50) );
					echo "<li><img src='{$src[0]}' width='{$src[1]}' height='{$src[2]}'></li>";
				}

				?>
			</ul>
			<?php
		}
	}
}

endif;