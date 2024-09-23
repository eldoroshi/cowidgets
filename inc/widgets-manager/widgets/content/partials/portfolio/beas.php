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

                    <h5 class="portfolio-title">

                        <a href="<?php echo esc_url( COWIDGETS_Helpers::portfolioItemPermalink( $settings ) ) ?>" class="cl-portfolio-title" title="<?php echo esc_attr( COWIDGETS_Helpers::portfolioItemTitle( $settings ) ) ?>"><?php echo esc_html( COWIDGETS_Helpers::portfolioItemTitle( $settings ) ) ?></a>
                        
                    </h5>

                    <h6 class="portfolio-categories">

                    <?php echo wp_kses(
                                COWIDGETS_Helpers::portfolioItemCategories( $settings, get_the_ID(), 'portfolio_entries', '', ', ', '' ),
                                array(
                                    'a' => array(
                                        'href' => array(),
                                        'title' => array(),
                                        'class' => array()
                                    ),
                                    'span' => array(
                                        'class' => array()
                                    ),
                                    'div' => array(
                                        'class' => array()
                                    ),
                                    'p' => array(
                                        'class' => array()
                                    ),
                                    // Add other HTML elements and attributes that are expected in the output
                                )
                            ); ?>

                    </h6><!-- portfolio-categories -->
                    
                    <?php if( $settings['carousel_controls'] ): ?>
                    <div class="ce-portfolio-carousel-controls">
                        <a href="#" class="ce-prev"><i class="feather feather-arrow-left"></i></a>
                        <a href="#" class="ce-next"><i class="feather feather-arrow-right"></i></a>
                    </div>

                    <?php endif; ?>

                </div><!-- entry-content -->

            </div><!-- entry-wrapper-content -->

        </div><!-- .grid-holder-inner -->

    </div><!-- .grid-holder -->
    
</div><!-- #post-## -->
