<article class="">
	<div class="entry-featured-podcast">
		<span class="ce-featured"><?php esc_html_e('Featured Podcast', 'cowidgets'); ?></span>
		<div class="entry-content">
			<figure class="entry-img">
				<?php the_post_thumbnail( $final_image_size ); ?>
			</figure>
			<div class="entry-data">
				<?php if( !empty( $season ) || !empty( $episode ) ){ ?>
					<span class="entry-meta">
						<?php if( $season ){ echo esc_html( $season ); } ?> . <?php if( $episode ){ echo esc_html( $episode ); } ?>
					</span>	
				<?php } ?>
				<h5>
		    		<a href="<?php the_permalink(); ?>">
		    			<?php the_title(); ?>
					</a>
				</h5>		
		    </div>	 
		</div>
		<div class="clearfix"></div>
	    <div class="entry-play">
	    	<a class="ce-active livecast-play livecast-play-<?php echo esc_attr(get_the_ID()) ?>" data-audio-id="<?php echo esc_attr(get_the_ID()) ?>" href="<?php the_permalink(); ?>">
	    		<span class="lp-icon lp-play"></span>
	    		<?php esc_html_e('Listen Now', 'cowidgets'); ?>
			</a>
			<?php if( !empty( $browse_text ) && !empty( $browse_link ) ){ ?>
				<a href="<?php echo esc_url( $browse_link ); ?>">
					<?php echo esc_html( $browse_text ); ?>
				</a>
			<?php } ?>
	    </div>	    
	</div>
	<?php if( $settings['show_btns'] == 'yes' ){ ?>
		<div class="ce-subscriptions">
	    	<div class="ce-sub">
	    		<img src="<?php echo esc_url( COWIDGETS_URL . 'assets/images/icon.png' ); ?>">
	    		<h5><?php esc_html_e('Subscribe On:', 'cowidgets'); ?></h5>
				<?php 
					$apple_link  = get_post_meta( get_the_ID(), 'ce_apple_link', true );
					$spotify_link = get_post_meta( get_the_ID(), 'ce_spotify_link', true );
					$rss_link = get_post_meta( get_the_ID(), 'ce_rss_link', true );
				?>

				<?php if( !empty( $apple_link ) ): ?>
	    			<a href="<?php echo esc_url( $apple_link ) ?>"><i aria-hidden="true" class="fab fa-apple"></i> <?php esc_html_e('Apple Music', 'cowidgets');  ?></a>
	    		<?php endif; ?>
				<?php if( !empty( $spotify_link ) ): ?>
					<a href="<?php echo esc_url( $spotify_link ) ?>"><i aria-hidden="true" class="fab fa-spotify"></i> <?php esc_html_e('Spotify', 'cowidgets');  ?></a>
	    		<?php endif; ?>
				<?php if( !empty( $rss_link ) ): ?>
					<a href="<?php echo esc_url( $rss_link ) ?>"><i aria-hidden="true" class="feather feather-rss"></i> <?php esc_html_e('Rss feed', 'cowidgets');  ?></a>
				<?php endif; ?>
			</div>
	    </div>
	<?php } ?>
</article>