<?php 
	$show_image = get_term_meta( $value->term_id, 'image', true );
	$show_image_src = !empty( $show_image ) ? wp_get_attachment_image_src( $show_image, $final_image_size ) : array();
	$image_url = !empty( $show_image_src[0] ) ? $show_image_src[0] : '';
	$description = !empty( $value->description ) ? $value->description : '';
	$link 	= get_term_link( $value->term_id, 'podcast_shows' );
	$args = array(
		'post_type' => 'podcast',
        'posts_per_page' => 3,
        'tax_query' => array(
        	array(
            	'taxonomy' => 'podcast_shows',
            	'field' => 'term_id',
            	'terms' => $value->term_id
        	)
        ),
	);
?>
<div id="entry-show-<?php echo esc_attr( $value->term_id ); ?>" <?php echo wp_kses_post( $this->get_render_attribute_string( 'ce-posts-item' ) ); ?> <?php echo wp_kses_post( $this->get_render_attribute_string( 'ce-post-item-' . esc_attr( $value->term_id ) ) ); ?>>	
	<article class="entry-show ce-post-item">	
		<figure class="entry-img">
			<?php if( !empty( $image_url ) ){ ?>
				<img src="<?php echo esc_url( $image_url ); ?>" alt="image">
			<?php } ?>
		</figure>
		<div class="entry-content">
			<?php if( !empty( $description ) ){ ?>
				<p><?php echo esc_html( $description ); ?></p>
			<?php } ?>
			<?php 
			$episodes = new \WP_Query( $args );
			if ( is_object( $episodes ) && $episodes->have_posts() ){ ?>
					<div class="entry-data">
				<?php 
				while( $episodes->have_posts() ){
					$episodes->the_post();
					$episode = get_post_meta( get_the_ID(), 'ce_episode', true );
					?>
					<div class="entry-wrap">
						<div class="entry-play">
						<a class="livecast-play livecast-play-<?php echo esc_attr(get_the_ID()) ?>" data-audio-id="<?php echo esc_attr(get_the_ID()) ?>" href="<?php the_permalink(); ?>">	
							<span class="lp-icon lp-play"></span>
						</a>
					    </div>
					    <div class="entry-title">
					    	<?php if( !empty( $episode ) ){ ?>
					    		<span class="entry-count">
					    			<?php echo esc_html( $episode ); ?>
					    		</span>
					    	<?php } ?>
					    	<h3 class="entry-titles"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
					    </div>
					</div>
					<?php 
						} wp_reset_postdata(); ?>
						<div class="view-all">
							<p><a class="entry-readmore" href="<?php echo esc_url( $link ); ?>"><?php esc_html_e('Browse All >', 'livecast'); ?></a></p>
						</div>
					</div>
				<?php } ?>
		</div>
	</article>
</div>
