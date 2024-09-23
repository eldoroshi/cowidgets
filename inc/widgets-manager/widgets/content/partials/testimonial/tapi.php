<div id="cl-testimonial-item-<?php the_ID(); ?>" <?php echo wp_kses_post( $this->get_render_attribute_string( 'ce-testimonial-item' ) ); ?> <?php echo wp_kses_post( $this->get_render_attribute_string( 'ce-testimonial-item-' . get_the_ID() ) ); ?> >
    <div class="inner-wrapper">
        <div class="content">
            
            <div class="text">"<?php echo esc_html( wp_strip_all_tags( get_the_content() ) ); ?>"</div>


            
        </div>

        <div class="data">
            <div class="title"><?php echo esc_html(get_the_title()) ?></div>
            <div class="position"><?php echo esc_html(COWIDGETS_Helpers::testimonialItemPosition()) ?></div> 

        </div>

        <?php if( $settings['carousel_controls'] ): ?>
            <div class="ce-testimonial-carousel-controls">
                <a href="#" class="ce-prev"><i class="feather feather-arrow-left"></i></a>
                <a href="#" class="ce-next"><i class="feather feather-arrow-right"></i></a>
            </div>
            <?php endif; ?>
                
        <?php if (function_exists('codeless_hook_custom_post_end')): ?>
            <?php codeless_hook_custom_post_end( 'testimonial', get_the_ID() ); ?>
        <?php endif ?>
    </div>
</div>