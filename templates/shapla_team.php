<?php
$args = array(
	'posts_per_page' 	=> $atts['posts_per_page'],
	'orderby' 			=> $atts['orderby'],
	'post_type' 		=> 'team',
	'no_found_rows' 	=> true
);

$query = new WP_Query( $args  );
?>
<?php if ( $query->have_posts() ): ?>

<div class="shapla-row">
    <div id="ID-<?php echo $atts['id']; ?>" class="owl-carousel">
    	<?php
			while ( $query->have_posts() ) : $query->the_post();
			$designation = get_post_meta( get_the_ID(), '_shapla_team_designation', true );
			$description = get_post_meta( get_the_ID(), '_shapla_team_description', true );
		?>
			<div class="shapla-team">
				<div class="box">
					<div class="team-pic">
	                    <?php
	                        if ( has_post_thumbnail() ) {
	                            the_post_thumbnail( 'thumbnail' );
	                        }
	                    ?>
					</div>
					<div class="team-info">
						<div class="team-name">
							<?php the_title(); ?>
						</div>
						<div class="company">
							<?php echo $designation; ?>
						</div>
					</div>
					<p class="message">
						<?php echo $description; ?>
					</p>
				</div>
			</div>
		<?php
			endwhile;
		?>
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