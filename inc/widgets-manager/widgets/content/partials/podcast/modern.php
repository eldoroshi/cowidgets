<div id="ce-post-item-<?php the_ID(); ?>" <?php echo wp_kses_post( $this->get_render_attribute_string( 'ce-post-item' ) ); ?> <?php echo wp_kses_post( $this->get_render_attribute_string( 'ce-post-item-' . get_the_ID() ) ); ?> class="entry-podcast">
	<article class="entry-podcast">
		<div class="entry-media">
			<figure class="entry-img">
				<?php the_post_thumbnail( $final_image_size ); ?>
			</figure>	    
		</div>	    
	    <div class="entry-contents">
	    	<span class="ce-latest"><?php esc_html_e('Latest Episode', 'cowidgets'); ?></span>
	    	<h3 class="entry-title">
	    		<a href="<?php the_permalink(); ?>">
	    			<?php the_title(); ?>
				</a>
			</h3>
			<div class="entry-wrap">
				<div class="entry-play">
					<a class="livecast-play livecast-play-<?php echo esc_attr(get_the_ID()) ?>" data-audio-id="<?php echo esc_attr(get_the_ID()) ?>" href="<?php the_permalink(); ?>">
						<span class="lp-icon lp-play"></span>		    			
					</a>
			    </div>
			    <div class="entry-metas">
			    	<span class="entry-count"><?php $author =   get_userdata( get_the_author_meta( 'ID' ) )->display_name;
                        echo wp_kses_post( $author ); ?></span>
			    	<span class="ce-date entry-meta-single">
					<?php echo wp_kses_post(codeless_get_entry_meta_date()); ?>&nbsp;<?php if( $episode ){ echo esc_html( $episode ); } ?></span>
			    </div>
			</div>
			<div class="entry-text entry-content">
				<?php 
					if ( $settings['entry_content'] == 'excerpt' ) {
						$size = !empty( $settings['content_limit']['size'] ) ? $settings['content_limit']['size'] : 50;
						$result = substr( get_the_excerpt(), 0, $size ); 
						echo esc_html( $result );
					} else if ( $settings['entry_content'] == 'content' ) {
						echo wp_kses_post( get_the_content() );
					}
				?>
			</div>
	  
	    </div>	
	</article>
</div>