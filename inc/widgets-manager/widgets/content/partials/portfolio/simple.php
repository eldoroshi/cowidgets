<?php
/**
 * Template part for displaying portfolio items
 * Switch styles at Theme Options (WP Customizer)
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package CoWidgets
 * @subpackage Partials
 * @since 1.0.0
 *
 */

?>

<div id="ce-portfolio-item-<?php the_ID(); ?>" <?php echo wp_kses_post( $this->get_render_attribute_string( 'ce-portfolio-item' ) ); ?> <?php echo wp_kses_post( $this->get_render_attribute_string( 'ce-portfolio-item-' . get_the_ID() ) ); ?> >
	
	<div class="grid-holder">

        <div class="grid-holder-inner">

            <div class="entry-media">
        
                <div class="overlay">

                </div>
                
                <div class="post-thumbnail">
                    
                    <?php COWIDGETS_Helpers::portfolioItemThumbnail( $settings, $final_image_size ); ?>
                    
                </div><!-- .post-thumbnail --> 
                <a href="<?php echo esc_url( COWIDGETS_Helpers::portfolioItemPermalink( $settings ) ) ?>" class="image-link"></a>
            </div><!-- .entry-media --> 
	
        	<div class="entry-wrapper-content">

                <div class="entry-content">

                    <div class="title">
                        <h4><a href="<?php echo esc_url( COWIDGETS_Helpers::portfolioItemPermalink( $settings ) ) ?>" class="cl-portfolio-title" title="<?php echo esc_attr( COWIDGETS_Helpers::portfolioItemTitle( $settings ) ) ?>"><?php echo esc_html( COWIDGETS_Helpers::portfolioItemTitle( $settings ) ) ?></a></h4>
                    </div>

                </div><!-- entry-content -->

            </div><!-- entry-wrapper-content -->

        </div><!-- .grid-holder-inner -->

    </div><!-- .grid-holder -->
    
</div><!-- #post-## -->
