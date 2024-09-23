<div <?php echo wp_kses_post( $this->get_render_attribute_string( 'ce-post-navigation' ) ); ?>>
    <div class="nav-wrapper">
    <?php if( get_previous_post( $settings['same_term'] ) ): ?>
        <div class="nav-item item-prev">
            <div class="item-label"><?php echo esc_html__( 'Previous' ) ?></div>
            <div class="item-title"><?php previous_post_link( '%link', '%title', $settings['same_term'] ) ?></div>
        </div>
    <?php endif; ?>

    <?php if( $settings['back_to'] ): ?>
        <div class="nav-item item-back_to">
            <div class="item-label"><?php echo esc_html__( 'Back To' ) ?></div>
            <div class="item-title"><a href="<?php echo esc_url( $settings['back_to_url'] ) ?>"><?php echo esc_html( $settings['back_to_text'] ) ?></a></div>
        </div>
    <?php endif; ?>
    

    <?php if( get_next_post( $settings['same_term'] ) ): ?>
        <div class="nav-item item-next">
            <div class="item-label"><?php echo esc_html__( 'Next' ) ?></div>
            <div class="item-title"><?php next_post_link( '%link', '%title', $settings['same_term'] ) ?></div>
        </div>
    <?php endif; ?>
    </div>
</div>