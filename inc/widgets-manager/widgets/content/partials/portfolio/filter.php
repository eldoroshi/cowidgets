<?php 

	$extra_class = '';
	if( $settings['filters_layout'] == 'center' )
        $extra_class = 'centered'; 
        
    if( $settings['filters_layout'] == 'left' )
        $extra_class = 'left-align'; 
    if( $settings['filters_layout'] == 'right' )
		$extra_class = 'right-align'; 

	//if( codeless_get_mod( 'portfolio_filter_fullwidth_shadow', false ) )
		$extra_class .= ' with-shadow '; 

	//if( codeless_get_mod( 'portfolio_filter_fullwidth_sticky', false ) )
	//	$extra_class .= ' sticky '; 
	
?>
<div class="ce-filters <?php echo esc_attr( $extra_class ) ?> ">

<?php
	$categories = "";//codeless_get_from_element( 'portfolio_categories' );

?>
	<div class="inner">

		<button data-filter="*" class="selected"><?php esc_html_e( 'All', 'folie' ) ?></button>
		
		<?php if( $settings['source_type'] == 'portfolio' ): ?>

			<?php if( empty( $categories ) ):

				$categories = get_terms( 'portfolio_entries' );

			endif; ?>

			<?php foreach( $categories as $category ): ?>
		
				<?php 

					if( is_string( $category ) )
						$category = get_term_by( 'slug', $category, 'portfolio_entries' );

				?>

				<button data-filter=".<?php echo esc_attr( $category->slug ) ?>"><?php echo esc_attr( $category->name ) ?></button>

			<?php endforeach; ?>

		<?php endif; ?>

		<?php if( $settings['source_type'] == 'gallery' ): ?>

			<?php if( $gallery_filters ) foreach( $gallery_filters as $item => $name ): ?>
			<button data-filter="<?php echo esc_attr( $item ) ?>"><?php echo esc_attr( $name ) ?></button>
			<?php endforeach; ?>
			
		<?php endif; ?>
		
	</div><!-- .inner -->

</div><!-- .cl-filters -->