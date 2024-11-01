<?php

if( ! class_exists('ShaplaTools_Post_Metabox')):

class ShaplaTools_Post_Metabox {

	private $plugin_name;

	public function __construct( $plugin_name ) {

		$this->plugin_name = $plugin_name;

		add_action( 'add_meta_boxes', array( $this, 'add_meta_boxes' ) );
	}

	public function add_meta_boxes()
	{
		add_meta_box(
			'shaplatools_gallery',
			__( 'Image Gallery', 'shaplatools' ),
			array( $this, 'meta_box_callback' ),
			array( 'post', 'page' ),
			'normal',
			'low'
		);
	}

	public function meta_box_callback()
	{
		global $post;
		$value = get_post_meta( $post->ID, '_shaplatools_images_ids', true );
		$btn_text 	= $value ? 'Edit Gallery' : 'Add Gallery';
        $value 		= strip_tags(rtrim($value, ','));
		$output 	= '';

	    if( $value ) {
	        $thumbs = explode(',', $value);
	        foreach( $thumbs as $thumb ) {
	            $output .= '<li class="shaplatools_gallery_list_item">' . wp_get_attachment_image( $thumb, array(75,75) ) . '</li>';
	        }
	    }

		$html  = '';
		$html .= '<div class="shaplatools_gallery_images" style="margin-top: 10px;">';
		$html .= sprintf('<input type="hidden" value="%1$s" id="shaplatools_images_ids" name="_shaplatools_images_ids">', $value );
		$html .= sprintf('<a href="#" id="shaplatools_gallery_btn" class="shaplatools_gallery_btn">%s</a>', $btn_text);
		$html .= sprintf('<ul class="shaplatools_gallery_list">%s</ul>', $output);
		$html .= '</div>';
		echo $html;
	}
}

endif;