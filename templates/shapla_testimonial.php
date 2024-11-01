<?php
$args = array(
	'posts_per_page' 	=> $atts['posts_per_page'],
	'orderby' 			=> $atts['orderby'],
	'post_type' 		=> 'testimonial',
	'no_found_rows' 	=> true
);

$query = new WP_Query( $args  );
?>
<?php if ( $query->have_posts() ): ?>
<div class="shapla-row">
    <div id="ID-<?php echo $atts['id']; ?>" class="owl-carousel">
    	<?php
    		while ( $query->have_posts() ) : $query->the_post();

			$client_name 	= get_post_meta( get_the_ID(), '_shapla_testimonial_client', true );
			$client_source 	= get_post_meta( get_the_ID(), '_shapla_testimonial_source', true );
			$client_link 	= get_post_meta( get_the_ID(), '_shapla_testimonial_url', true );
    	?>
    	<div class="shapla-testimonial">
			<div class="client-pic">
                <?php
                    if ( has_post_thumbnail() ) {
                        the_post_thumbnail( array(64,64));
                    }
                ?>
			</div>
			<div class="box">
				<p class="message">
					<?php echo get_the_content(); ?>
				</p>
			</div>
			<div class="client-info">
				<div class="client-name colored-text strong">
					<?php echo (!empty($client_name)) ? $client_name : ''; ?>
				</div>
				<div class="company">
					<a href="<?php echo (!empty($client_link)) ? $client_link : '#'; ?>" target="_blank">
						<?php echo (!empty($client_source)) ? $client_source : ''; ?>
					</a>
				</div>
			</div>
		</div>
    	<?php endwhile; ?>
    </div>
</div>
<script type="text/javascript">
	jQuery(document).ready(function($) {
			$('#ID-<?php echo $atts['id']; ?>').owlCarousel({
			items : <?php echo $atts['items_desktop']; ?>,
			nav : true,
			dots: false,
			loop : true,
			autoplay: true,
			autoplayHoverPause: true,
			responsiveClass:true,
		    responsive:{
		        320:{ items:<?php echo $atts['items_mobile']; ?> },
		        600:{ items:<?php echo $atts['items_tablet_small']; ?> },
		        768:{ items:<?php echo $atts['items_tablet']; ?> },
		        979:{ items:<?php echo $atts['items_desktop']; ?> }
		    }
		});
	});
</script>
<?php endif; wp_reset_query(); ?>