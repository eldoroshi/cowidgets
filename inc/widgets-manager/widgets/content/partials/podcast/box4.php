<div id="ce-post-item-<?php the_ID(); ?>" <?php echo wp_kses_post( $this->get_render_attribute_string( 'ce-post-item' ) ); ?> <?php echo wp_kses_post( $this->get_render_attribute_string( 'ce-post-item-' . get_the_ID() ) ); ?> >
	<article class="entry-podcast">
		<div class="entry-media">
			<figure class="entry-img">
				<?php the_post_thumbnail( $final_image_size ); ?>
	            <a href="<?php echo esc_url(get_permalink()) ?>" class="image-link"></a>
			</figure>
			<div class="entry-meta-single entry-meta-date">
				<span><?php echo wp_kses_post(codeless_get_entry_meta_date()); ?></span>
		    </div>
		    <div class="entry-play">
				<a class="livecast-play livecast-play-<?php echo esc_attr(get_the_ID()) ?>" data-audio-id="<?php echo esc_attr(get_the_ID()) ?>" href="<?php the_permalink(); ?>">	    			
					<span class="lp-icon lp-play"></span>
				</a>
		    </div>
		</div>
	    <div class="entry-titles">
	    	<span class="entry-icon">
	    		<?php echo wp_kses_post(codeless_get_podcast_shows_colored( get_the_ID(), 'podcast_shows' ));  ?>
	    	</span>
	    	<h3 class="entry-title">
	    		<a href="<?php the_permalink(); ?>">
	    			<?php the_title(); ?>
				</a>
			</h3>
			<p class="entry-content">
			<?php echo esc_html( substr( get_the_excerpt(), 0, 80 ) ); ?>
			</p>
			<a class="ce-view entry-readmore" href="<?php the_permalink() ?>"><?php esc_html_e('View Episode >', 'cowidgets'); ?></a>
	    </div>
	</article>
</div>
