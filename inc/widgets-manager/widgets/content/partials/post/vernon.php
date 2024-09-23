<?php
/**
 * Template part for displaying posts
 * Vernon Style
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
             
                
                

                $categories = get_the_category();
                if ( ! empty( $categories ) ) {
                    //then i get the data from the database
                    $term_id =  $categories[0]->term_id;
                    $cat_data = get_option("category_$term_id");
                    echo '<a class="category-colored" style="background-color:#000;">' . esc_html( $categories[0]->name ) . '</a>';
                }

                ?>

            </div>
            
            <div class="entry-wrapper">

                <div class="entry-wrapper-content">
            
                        <header class="entry-header">
 

                            <?php the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' ); ?>

                        </header><!-- .entry-header -->


                    <div class="entry-footer">
                        <?php if( $settings['entry_readmore'] ): ?>
                            <a href="<?php echo esc_url( get_permalink( ) ) ?>" class="entry-readmore"><?php esc_html_e( 'Continue Reading', 'cowidgets' ); ?></a>
                        <?php endif; ?>
                    </div>


                </div><!-- .entry-wrapper-content -->

            </div><!-- .entry-wrapper -->
        </div>
    </div>
</article><!-- #post-## -->
