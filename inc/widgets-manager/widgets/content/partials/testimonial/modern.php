<!-- Testimonial Block -->
<div id="cl-testimonial-item-<?php the_ID(); ?>" <?php echo wp_kses_post( $this->get_render_attribute_string( 'ce-testimonial-item' ) ); ?> <?php echo wp_kses_post( $this->get_render_attribute_string( 'ce-testimonial-item-' . get_the_ID() ) ); ?> >
	<div class="ce-testimonial-item data">
		<div class="inner-box">
			<div class="author-image">
				<?php the_post_thumbnail('thumbnail'); ?>
			</div>
			<h4 class="title"><?php echo esc_html(get_the_title()) ?></h4>
			<div class="position"><?php echo esc_html(COWIDGETS_Helpers::testimonialItemPosition()) ?></div>		
			<p class="text">"<?php echo esc_html( wp_strip_all_tags( get_the_content() ) ); ?>"</p>

		</div>
	</div>
</div>