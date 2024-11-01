<?php
$id 			= $attributes['id'];
$img_size    	= esc_attr( get_post_meta( $id, '_shapla_slide_img_size', true ) );
$theme    		= esc_attr( get_post_meta( $id, '_shapla_slide_theme', true ) );

$image_ids   	= explode(',', get_post_meta( $id, '_shapla_slide_images', true) );
?>

<?php if( $image_ids[0] !== "" ): ?>

<div class="shapla-slide">
	<div class="slider-wrapper theme-<?php echo $theme; ?>">
		<div id="ID-<?php echo $id; ?>" class="nivoSlider">
			<?php
			foreach ( $image_ids as $image )
			{
				if(!$image) continue;
				$src = wp_get_attachment_image_src( $image, $img_size );
				$thumb = wp_get_attachment_image_src( $image, array(50, 50) );
				$caption = get_post( $image )->post_excerpt ? get_post( $image )->post_excerpt : '';
				$description = get_post( $image )->post_content ? get_post( $image )->post_content : '';
				
				if (!filter_var($description, FILTER_VALIDATE_URL) === false) {

					echo sprintf('<a href="%1$s"><img src="%2$s" width="%3$s" height="%4$s" data-thumb="%5$s" title="%6$s"></a>',
						$description, $src[0], $src[1], $src[2], $thumb[0], $caption
					);

				} else {

					echo sprintf('<img src="%1$s" width="%2$s" height="%3$s" data-thumb="%4$s" title="%5$s">',
						$src[0], $src[1], $src[2], $thumb[0], $caption
					);
				}
			}
			?>
		</div><!-- .nivoSlider -->
	</div><!-- .slider-wrapper -->
</div><!-- #shapla-slide -->

<?php endif;

add_action('wp_footer', function() use ( $id ){

	$transition    	= esc_attr( get_post_meta( $id, '_shapla_slide_transition', true ) );
	$slices    		= esc_attr( get_post_meta( $id, '_shapla_slide_slices', true ) );
	$boxcols    	= esc_attr( get_post_meta( $id, '_shapla_slide_boxcols', true ) );
	$boxrows    	= esc_attr( get_post_meta( $id, '_shapla_slide_boxrows', true ) );
	$anim_speed    	= esc_attr( get_post_meta( $id, '_shapla_slide_animation_speed', true ) );
	$pause_time    	= esc_attr( get_post_meta( $id, '_shapla_slide_pause_time', true ) );
	$start    		= esc_attr( get_post_meta( $id, '_shapla_slide_start', true ) );
	$thumb_nav    	= ( get_post_meta( $id, '_shapla_slide_thumb_nav', true ) == '1' ) ? 'true' : 'false';
	$dir_nav    	= ( get_post_meta( $id, '_shapla_slide_dir_nav', true ) == '1') ? 'true' : 'false';
	$ctrl_nav    	= ( get_post_meta( $id, '_shapla_slide_ctrl_nav', true ) == '1') ? 'true' : 'false';
	$hover_pause    = ( get_post_meta( $id, '_shapla_slide_hover_pause', true ) == '1') ? 'true' : 'false';
	$transition_man = ( get_post_meta( $id, '_shapla_slide_transition_man', true ) == '1') ? 'true' : 'false';
	$start_rand    	= ( get_post_meta( $id, '_shapla_slide_start_rand', true ) == '1') ? 'true' : 'false';
	?>
	<script type="text/javascript">
		jQuery( window ).load( function( $ ) {
			jQuery("#ID-<?php echo $id; ?>").nivoSlider({
				effect: "<?php echo $transition; ?>",
				slices: <?php echo $slices; ?>,
				boxCols: <?php echo $boxcols; ?>,
				boxRows: <?php echo $boxrows; ?>,
				animSpeed: <?php echo $anim_speed; ?>,
				pauseTime: <?php echo $pause_time; ?>,
				startSlide: <?php echo $start; ?>,
				directionNav: <?php echo $dir_nav; ?>,
				controlNav: <?php echo $ctrl_nav; ?>,
				controlNavThumbs: <?php echo $thumb_nav; ?>,
				pauseOnHover: <?php echo $hover_pause; ?>,
				manualAdvance: <?php echo $transition_man; ?>,
				randomStart: <?php echo $start_rand; ?>,
			});
		});
	</script>
	<?php
}, 60);

?>