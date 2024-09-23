<!-- Portfolio Block -->
<div id="ce-portfolio-item-<?php the_ID(); ?>" <?php echo wp_kses_post( $this->get_render_attribute_string( 'ce-portfolio-item' ) ); ?> <?php echo wp_kses_post( $this->get_render_attribute_string( 'ce-portfolio-item-' . get_the_ID() ) ); ?> >
	<div class="inner-box">
		<div class="image">
            <?php COWIDGETS_Helpers::portfolioItemThumbnail( $settings, $final_image_size ); ?>
			<div class="overlay-box">
				<div class="overlay-inner">
					<h6><a href="<?php echo esc_url( COWIDGETS_Helpers::portfolioItemPermalink( $settings ) ) ?>"  title="<?php echo esc_attr( COWIDGETS_Helpers::portfolioItemTitle( $settings ) ) ?>"><?php echo esc_html( COWIDGETS_Helpers::portfolioItemTitle( $settings ) ) ?></a></h6>
					<a href="<?php echo esc_url(get_the_post_thumbnail_url(get_the_ID(),'full')); ?>" data-fancybox="gallery" data-caption="" class="plus"><?php \Elementor\Icons_Manager::render_icon( $settings['icon'], [ 'aria-hidden' => 'true' ] ); ?></a>
				</div>
			</div>
		</div>
	</div>
</div>
					