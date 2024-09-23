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

                </div>
                
                <div class="post-thumbnail">
                <?php 
                    if( $settings['source_type'] == 'gallery' ){
                        $data = wp_get_attachment_image_src( get_the_ID(), $final_image_size ); 
                        $width = $data[1];
                        $height = $data[2];
                    }else{
                        $data = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), $final_image_size ); 
                        $width = $data[1];
                        $height = $data[2];
                    }

                    $ratio = round($width / $height, 3);
                    if( $ratio < 1 ){
                        $ratiox = 0.95 - 0.05 * $ratio;
                        $ratioy = 0.95;
                    }

                    else if( $ratio > 1 ){
                        $ratio = round($data[2] / $data[1], 3);
                        $ratiox = 0.95;
                        $ratioy = 0.95 - 0.05 * $ratio;
                    }

                    else{
                        $ratiox = $ratioy = 0.95;
                    }
                ?>
                    <div class="wrapper" style="--image-ratio-x: <?php echo esc_attr( $ratiox ) ?>; --image-ratio-y: <?php echo esc_attr( $ratioy ) ?>;">
                        <?php COWIDGETS_Helpers::portfolioItemThumbnail( $settings, $final_image_size ); ?>
                    </div>
                </div><!-- .post-thumbnail --> 

                <a href="<?php echo esc_url( COWIDGETS_Helpers::portfolioItemPermalink( $settings ) ) ?>" class="image-link"></a>
            </div><!-- .entry-media --> 
	
        	<div class="entry-wrapper-content">

                <div class="entry-content">

                    <h3 class="portfolio-title">

                        <a href="<?php echo esc_url( COWIDGETS_Helpers::portfolioItemPermalink( $settings ) ) ?>" class="cl-portfolio-title" title="<?php echo esc_attr( COWIDGETS_Helpers::portfolioItemTitle( $settings ) ) ?>"><?php echo esc_html( COWIDGETS_Helpers::portfolioItemTitle( $settings ) ) ?></a>
                        
                    </h3>

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

                </div><!-- entry-content -->

            </div><!-- entry-wrapper-content -->

        </div><!-- .grid-holder-inner -->

    </div><!-- .grid-holder -->
    
</div><!-- #post-## -->
