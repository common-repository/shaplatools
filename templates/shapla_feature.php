<?php
$args = array(
	'posts_per_page' 	=> $atts['posts_per_page'],
	'orderby' 			=> $atts['orderby'],
	'post_type' 		=> 'feature',
	'no_found_rows' 	=> true
);

$query = new WP_Query( $args  );
?>

<?php if( $query->have_posts() ): ?>
	<div class="shapla-features shapla-row">
		<?php
			while ( $query->have_posts() ) : $query->the_post();
			$fa_icon = get_post_meta( get_the_ID(), '_shapla_feature_fa_icon', true );
			$fa_icon = ( empty( $fa_icon ) ) ? '' : $fa_icon;
		?>
		<div class="feature shapla-col <?php echo $atts['thumbnail']; ?>">
			<div class="icon">
                <?php
                    if ( has_post_thumbnail() ) {
                        the_post_thumbnail( 'thumbnail' );
                    } else {
                    	echo '<i class="'.$fa_icon.'"></i>';
                    }
                ?>
			</div>
			<h4 class="feature_title"><?php the_title(); ?></h4>
			<?php the_content(); ?>
		</div>
		<?php endwhile; ?>
	</div>
<?php endif; wp_reset_query(); ?>