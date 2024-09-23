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

<div id="ce-portfolio-item-<?php the_ID(); ?>" <?php echo wp_kses_post( $this->get_render_attribute_string( 'ce-portfolio-item' ) ); ?> <?php echo wp_kses_post( $this->get_render_attribute_string( 'ce-portfolio-item-' . esc_attr(get_the_ID()) ) ); ?> >
	
	<div class="grid-holder">

        <div class="grid-holder-inner">

            <div class="entry-media">
        
                <div class="overlay">
                    <a href="<?php echo esc_url( COWIDGETS_Helpers::portfolioItemPermalink( $settings ) ) ?>" class="ce-portfolio-preview" title="<?php echo esc_attr( COWIDGETS_Helpers::portfolioItemTitle( $settings ) ) ?>"><?php echo esc_html( $settings['remake_preview_text'] ); ?><svg width="12" height="10" viewBox="0 0 12 10" fill="none" xmlns="http://www.w3.org/2000/svg">
<path d="M0.671875 5.67188H11.3281C11.5156 5.66146 11.6719 5.59375 11.7969 5.46875C11.9323 5.34375 12 5.1875 12 5C12 4.8125 11.9323 4.65625 11.7969 4.53125C11.6719 4.40625 11.5156 4.33854 11.3281 4.32812H0.671875C0.484375 4.33854 0.322917 4.40625 0.1875 4.53125C0.0625 4.65625 0 4.8125 0 5C0 5.1875 0.0625 5.34375 0.1875 5.46875C0.322917 5.59375 0.484375 5.66146 0.671875 5.67188ZM6.85938 8.53125C6.73438 8.66667 6.67188 8.82292 6.67188 9C6.67188 9.17708 6.73958 9.33333 6.875 9.46875C7.01042 9.59375 7.16146 9.65625 7.32812 9.65625C7.50521 9.65625 7.66146 9.59375 7.79688 9.46875L11.7969 5.46875C11.9323 5.33333 12 5.17708 12 5C12 4.82292 11.9323 4.66667 11.7969 4.53125L7.79688 0.53125C7.66146 0.40625 7.50521 0.34375 7.32812 0.34375C7.16146 0.34375 7.01042 0.411458 6.875 0.546875C6.73958 0.671875 6.67188 0.822917 6.67188 1C6.67188 1.17708 6.73438 1.33333 6.85938 1.46875L10.3906 5L6.85938 8.53125Z" fill="black"/>
</svg>
</a>
                </div>
                
                <div class="post-thumbnail">
                    
                    <?php COWIDGETS_Helpers::portfolioItemThumbnail( $settings, $final_image_size ); ?>
                    
                </div><!-- .post-thumbnail --> 
            </div><!-- .entry-media --> 
	
        	<div class="entry-wrapper-content">

                <div class="entry-content">

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

                    <h3 class="portfolio-title">

                        <a href="<?php echo esc_url( COWIDGETS_Helpers::portfolioItemPermalink( $settings ) ) ?>" class="cl-portfolio-title" title="<?php echo esc_attr( COWIDGETS_Helpers::portfolioItemTitle( $settings ) ) ?>"><?php echo esc_html( COWIDGETS_Helpers::portfolioItemTitle( $settings ) ) ?></a>
                        
                    </h3>

                    

                </div><!-- entry-content -->

            </div><!-- entry-wrapper-content -->

        </div><!-- .grid-holder-inner -->

    </div><!-- .grid-holder -->
    
</div><!-- #post-## -->
