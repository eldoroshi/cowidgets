<?php
/**
 * Template part for displaying posts
 * Colm Style
 *
 *
 * @package CoWidgets
 * @subpackage Partials
 * @since 1.0.0
 *
 */

?>

<article id="ce-post-item-<?php the_ID(); ?>" <?php echo wp_kses_post( $this->get_render_attribute_string( 'ce-post-item' ) ); ?> <?php echo wp_kses_post( $this->get_render_attribute_string( 'ce-post-item-' . get_the_ID() ) ); ?> >
    <div class="grid-holder"> 
        <div class="grid-holder-inner">  
            <div class="media-wrapper">
            
                <?php 
                
                $post_format = get_post_format() || '';
                $post = get_post();
                /**
                 * Generate Post Thumbnail for Single Post and Blog Page
                 */ 
                ?>
                
                <div class="entry-media">
                
                    <div class="post-thumbnail">
                        
                        <?php the_post_thumbnail( $final_image_size ); ?>

                        <a href="<?php echo esc_url(get_permalink()) ?>" class="image-link"></a>
                    
                    </div><!-- .post-thumbnail --> 

                </div><!-- .entry-media --> 

                <?php do_action( 'ce_post_media_wrapper_end', $settings ); ?>

            </div>
            
            <div class="entry-wrapper">

                <div class="entry-wrapper-content">
            
                        <header class="entry-header">
 
                            <div class="entry-meta">

                                <div class="entry-meta-single entry-meta-author">
         
                                    <i class="<?php echo esc_attr( $settings['user_icon']['value'] ) ?>"></i><?php echo esc_html( get_userdata( get_the_author_meta( 'ID' ) )->display_name ); ?>
            
                                </div><!-- .entry-meta-single -->

                                <div class="entry-meta-single entry-meta-date">
                                    <i class="<?php echo esc_attr( $settings['date_icon']['value'] ) ?>"></i><?php echo get_the_date('M j, Y'); ?>
                                </div><!-- .entry-meta-single -->
                            </div><!-- .entry-meta -->

                            <?php the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' ); ?>

                        </header><!-- .entry-header -->

                        <div class="entry-content">
                            <?php 
                                if ( $settings['entry_content'] == 'excerpt' ) {
                                    the_excerpt();
                                } else if ( $settings['entry_content'] == 'content' ) {
                                    the_content();
                                }
                            ?>
                        </div>

                    <div class="entry-footer">
                        <?php if( $settings['entry_readmore'] ): ?>
                            <a href="<?php echo esc_url( get_permalink( ) ) ?>" class="entry-readmore"><?php esc_html_e( 'Continue Reading', 'cowidgets' ); ?></a>
                        <?php endif; ?>
                    </div>
                    
                    <?php do_action( 'ce_post_wrapper_content_end', $settings ) ?>

                </div><!-- .entry-wrapper-content -->

            </div><!-- .entry-wrapper -->
        </div>
    </div>
</article><!-- #post-## -->
