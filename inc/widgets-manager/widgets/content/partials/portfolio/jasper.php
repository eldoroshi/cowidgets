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

<div id="ce-portfolio-item-<?php the_ID(); ?>" <?php echo wp_kses_post( $this->get_render_attribute_string( 'ce-portfolio-item' ) ); ?> <?php echo wp_kses_post( $this->get_render_attribute_string( 'ce-portfolio-item-' . esc_attr(get_the_ID() ) ) ); ?> >
	
	<div class="grid-holder">

        <div class="grid-holder-inner">

            <div class="entry-media">
        
                <div class="overlay">

                </div>
                
                <div class="post-thumbnail">
                    
                    <?php COWIDGETS_Helpers::portfolioItemThumbnail( $settings, $final_image_size ); ?>

                    <h5 class="portfolio-title">

                        <a href="<?php echo esc_url( COWIDGETS_Helpers::portfolioItemPermalink( $settings ) ) ?>" class="cl-portfolio-title" title="<?php echo esc_attr( COWIDGETS_Helpers::portfolioItemTitle( $settings ) ) ?>"><?php echo esc_html( COWIDGETS_Helpers::portfolioItemTitle( $settings ) ) ?></a>
                        
                    </h5>

                    <h6 class="portfolio-categories">

                        <?php echo wp_kses_post(COWIDGETS_Helpers::portfolioItemCategories( $settings, esc_attr(get_the_ID()), 'portfolio_entries', '', ', ', '' ) ) ?>

                    </h6><!-- portfolio-categories -->

                    <a href="<?php echo esc_url( COWIDGETS_Helpers::portfolioItemPermalink( $settings ) ) ?>" class="image-link"></a>
                    
                </div><!-- .post-thumbnail --> 
            </div><!-- .entry-media --> 

        </div><!-- .grid-holder-inner -->

    </div><!-- .grid-holder -->
    
</div><!-- #post-## -->
