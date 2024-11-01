<?php
$args = array(
    'post_type'         => 'portfolio',
    'posts_per_page'    => -1,
);
$loop = new WP_Query( $args );
?>
<div id="shaplatools-portfolio" class="shapla-portfolio">
    <?php if ( $loop->have_posts() ) : ?>
    	<div id="filter" class="filter shapla-row shapla-portfolio-terms">
    		<?php
                $terms = get_terms("skill");
                if ( $terms && ! is_wp_error( $terms ) ){
                    echo '<ul>';
                        echo sprintf( '<li><a class="active" href="#" data-group="all">%s</a></li>', __('All', 'shaplatools'));
                        foreach ( $terms as $term ) {
                            echo sprintf('<li><a href="#" data-group="%s">%s</a></li>', $term->slug, $term->name);
                        }
                    echo "</ul>";
                }
            ?>
    	</div>

    	<div id="grid" class="shapla-row shapla-portfolio-items">
            <?php while ( $loop->have_posts() ) : $loop->the_post(); ?>
                     
            <?php
                $terms = get_the_terms( get_the_ID(), 'skill' );

                if ( $terms && ! is_wp_error( $terms ) ) :
                    $links = array();
                    foreach ( $terms as $term ) {
                        $links[] = $term->slug;
                    }
                    $tax = join( " ", $links );
                    $tax = json_encode(explode(' ', $tax));
                else :
                    $tax = '';
                endif;
            ?>
    		<div id="ID-<?php the_ID(); ?>" class="item shapla-col <?php echo $attributes['thumbnail']; ?>" data-groups='<?php echo $tax; ?>'>
    			<div class="single-portfolio-item">
    				<div class="portfolio-f-image">
    					<?php the_post_thumbnail( $attributes['thumbnail_size'] ); ?>
    					<div class="portfolio-hover">
    			        	<a href="#" class="portfolio-title-link"><?php the_title(); ?></a>
    			            <a href="<?php the_permalink(); ?>" class="view-details-link">See details</a>
    					</div>
    				</div>
    			</div>
    		</div>
                         
            <?php endwhile; ?>
    	</div><!-- #grid -->
    <?php endif; wp_reset_query(); ?>
</div><!-- #shaplatools-portfolio -->