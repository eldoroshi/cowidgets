<div id="cl-testimonial-item-<?php the_ID(); ?>" <?php echo wp_kses_post( $this->get_render_attribute_string( 'ce-testimonial-item' ) ); ?> <?php echo wp_kses_post( $this->get_render_attribute_string( 'ce-testimonial-item-' . get_the_ID() ) ); ?> >
            
    <div class="content">
        <svg width="14" height="12" viewBox="0 0 14 12" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M4.98438 0.984375L3.01562 5.01562H6.01562V11.0156H0.015625V5.01562L1.98438 0.984375H4.98438ZM13 0.984375L10.9844 5.01562H13.9844V11.0156H7.98438V5.01562L10 0.984375H13Z" fill="white"/>
        </svg>
        
        <div class="text">"<?php echo esc_html( wp_strip_all_tags( get_the_content() ) ); ?>"</div>

    </div>

    <div class="data">
        <div class="title"><?php echo esc_html(get_the_title()) ?></div>
        <div class="position"><?php echo esc_html(COWIDGETS_Helpers::testimonialItemPosition()) ?></div> 

        <?php if( $settings['carousel_controls'] ): ?>
        <div class="ce-testimonial-carousel-controls">
            <a href="#" class="ce-prev"><i class="feather feather-arrow-left"></i></a>
            <a href="#" class="ce-next"><i class="feather feather-arrow-right"></i></a>
        </div>
        <?php endif; ?>
     </div>
            
    <?php if (function_exists('codeless_hook_custom_post_end')): ?>
        <?php codeless_hook_custom_post_end( 'testimonial', get_the_ID() ); ?>
    <?php endif ?>
    
</div>