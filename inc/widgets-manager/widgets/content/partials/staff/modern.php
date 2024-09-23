<div id="cl-staff-item-<?php the_ID(); ?>" <?php echo wp_kses_post( $this->get_render_attribute_string( 'ce-staff-item' ) ); ?> <?php echo wp_kses_post( $this->get_render_attribute_string( 'ce-staff-item-' . get_the_ID() ) ); ?>>	
	<div class="ce-staff">	
		<div class="team-thumbnail">			
			<?php the_post_thumbnail( $settings['image_size_size'] ); ?>
		</div><!-- .team-thumbnail -->		
		<div class="team-content">
			<h4 class="team-name">
				<a href="<?php echo esc_url( COWIDGETS_Helpers::staffItemPermalink() ) ?>"><?php the_title() ?></a>
			</h4>
			<h6 class="team-position"><?php echo esc_attr(COWIDGETS_Helpers::staffItemPosition()); ?></h6>			
		    <div class="team-socials">
	            <?php echo wp_kses_post(COWIDGETS_Helpers::staffItemSocials()) ?>
			</div>
		</div><!-- team-content -->
		<?php if (function_exists('codeless_hook_custom_post_end')): ?>
	        <?php codeless_hook_custom_post_end( 'staff', get_the_ID() ); ?>
	    <?php endif ?>
	</div>
</div>