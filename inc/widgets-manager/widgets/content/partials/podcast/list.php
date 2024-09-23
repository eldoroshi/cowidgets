<div id="ce-post-item-<?php the_ID(); ?>" <?php echo wp_kses_post( $this->get_render_attribute_string( 'ce-post-item' ) ); ?> <?php echo wp_kses_post( $this->get_render_attribute_string( 'ce-post-item-' . get_the_ID() ) ); ?> class="entry-podcast ce-post-item">
	<article class="entry-podcast entry-list">
		<div class="entry-media">						
		    <div class="entry-play">
				<a class="livecast-play livecast-play-<?php echo esc_attr(get_the_ID()) ?>" data-audio-id="<?php echo esc_attr(get_the_ID()) ?>" href="<?php the_permalink(); ?>">	    			
					<span class="lp-icon lp-play"></span>
				</a>
		    </div>
		    <div class="entry-titles">
			    <h3 class="entry-title">
		    		<a href="<?php the_permalink(); ?>">
		    			<?php the_title(); ?>
					</a>
				</h3>
			</div>
		</div>
		<div class="entry-meta-single entry-meta-date">
			<span><?php echo wp_kses_post(codeless_get_entry_meta_date()); ?></span>
	    </div>
	    <div class="entry-cat">
	    	<span class="entry-icon">
	    		<?php echo wp_kses_post( codeless_get_podcast_shows_colored( get_the_ID(), 'podcast_shows' ) );  ?>
	    	</span>
	    </div>
	    <div class="entry-view">	
    		<a class="entry-readmore" href="<?php the_permalink(); ?>">
    			<?php esc_html_e('View More >', 'cowidgets'); ?>
			</a>
	    </div>
	</article>
	
</div>