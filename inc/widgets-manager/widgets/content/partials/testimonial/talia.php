<div id="cl-testimonial-item-<?php the_ID(); ?>" <?php echo wp_kses_post( $this->get_render_attribute_string( 'ce-testimonial-item' ) ); ?> <?php echo wp_kses_post( $this->get_render_attribute_string( 'ce-testimonial-item-' . get_the_ID() ) ); ?> >
            
    <div class="content">
        <div class="text">"<?php echo wp_kses_post( wp_strip_all_tags( get_the_content() ) );?>"</div>
    </div>

    <div class="data">
        <div class="title"><?php the_title() ?></div>
        <div class="position"><?php echo wp_kses_post( COWIDGETS_Helpers::testimonialItemPosition() ) ?></div> 
    </div>

    <?php if( $settings['carousel_controls'] ): ?>
    <div class="ce-testimonial-carousel-controls">
        <a href="#" class="ce-prev">
            <svg width="25" height="8" viewBox="0 0 25 8" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M0.646446 3.64644C0.451185 3.84171 0.451185 4.15829 0.646446 4.35355L3.82843 7.53553C4.02369 7.73079 4.34027 7.73079 4.53553 7.53553C4.7308 7.34027 4.7308 7.02369 4.53553 6.82843L1.70711 4L4.53553 1.17157C4.7308 0.976309 4.7308 0.659727 4.53553 0.464464C4.34027 0.269202 4.02369 0.269202 3.82843 0.464464L0.646446 3.64644ZM25 3.5L1 3.5L1 4.5L25 4.5L25 3.5Z" fill="black"/>
            </svg>
        </a>
        <a href="#" class="ce-next">
            <svg width="25" height="8" viewBox="0 0 25 8" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M24.3536 4.35355C24.5488 4.15829 24.5488 3.84171 24.3536 3.64645L21.1716 0.464466C20.9763 0.269204 20.6597 0.269204 20.4645 0.464466C20.2692 0.659728 20.2692 0.976311 20.4645 1.17157L23.2929 4L20.4645 6.82843C20.2692 7.02369 20.2692 7.34027 20.4645 7.53553C20.6597 7.7308 20.9763 7.7308 21.1716 7.53553L24.3536 4.35355ZM0 4.5H24V3.5H0V4.5Z" fill="black"/>
            </svg>
        </a>
    </div>
    <?php endif; ?>
            
   <?php if (function_exists('codeless_hook_custom_post_end')): ?>
        <?php codeless_hook_custom_post_end( 'testimonial', get_the_ID() ); ?>
    <?php endif ?>
</div>