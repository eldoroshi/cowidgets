<?php

class COWIDGETS_Helpers { 

	public static function getTerms( $term = 'post', $default_choice = false, $key_type = 'slug' ){ 
		$return = array();
		if( $term == 'post' ){
			$categories = get_categories( array(
				'orderby' => 'name',
				'parent'  => 0
			) );
	 
			foreach ( $categories as $category ) {
				$return[ $category->term_id ] = $category->name;
			}
		}
		$terms = get_terms( $term );
	
		if( $default_choice )
			$return['all'] = esc_attr__( 'All Categories', 'cowidgets' );
	
		if ( ! empty( $terms ) && ! is_wp_error( $terms ) ){
			foreach ( $terms as $term ) {
				$return[ $term->{$key_type} ] = $term->name; 
			}
		}
	
		return $return;
	}
      
    public static function getPostTypes() { 
        $types = [];

		$post_types = get_post_types( array( 'public' => true ), 'object' );

		$exclusions = [ 'attachment', 'elementor_library', 'elementor-ce' ];

		foreach ( $post_types as $post_type ) {
			if ( in_array( $post_type->name, $exclusions ) ) {
				continue;
			}
			$types[ $post_type->name ] = $post_type->label;
		}

		return $types;
    }

    public static function getItems( $post_type = 'any', $default = false ) {
        $return = [];

        if( $default )
            $return['empty'] = __( 'Nothing selected', 'cowidgets' );

        $items = get_posts( array(
            'post_type' => $post_type,
            'posts_per_page' => -1,
            'orderby' 		=> 'title',
            'order' 		=> 'ASC'
         ));
     

        if($items)
            foreach ($items as $item){
                $return[ $item->ID ] = get_the_title( $item->ID );
            }

        return $return;
    }

    public static function slidesSelectionSection( $elementor ) {

        $elementor->start_controls_section(
			'section_title',
			[
				'label' => __( 'Slides', 'cowidgets' ),
			]
		);

		$elementor->add_control(
			'source_type',
			[
				'label' => __( 'Source Type', 'cowidgets' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'portfolio',
				'options' => [
					'portfolio'	=> __( 'Portfolio', 'cowidgets' ),
					'all_post_types'  => __( 'All Posts', 'cowidgets' ),
					'gallery' => __( 'Gallery', 'cowidgets' ),
					'videos' => __( 'Custom Videos', 'cowidgets' )
				],
			]
		);
			//if portfolio
			$elementor->add_control(
				'slides_portfolio',
				[
					'label' => __( 'Slides', 'cowidgets' ),
					'type' => \Elementor\Controls_Manager::SELECT2,
					'default' => ['empty'],
					'multiple' => true,
					'options' => \COWIDGETS_Helpers::getItems( 'portfolio', false ),
					'condition' => [
						'source_type' => 'portfolio'
					]
				]
			);
			$elementor->add_control(
				'items_orderby',
				[
					'label' => __( 'Order By', 'cowidgets' ),
					'type' => \Elementor\Controls_Manager::SELECT,
					'default' => 'date',
					'multiple' => false,
					'options' => [
						'none' => __('No order', 'cowidgets'),
						'ID' => __('Post ID', 'cowidgets'),
						'author' => __('Author', 'cowidgets'),
						'title' => __('Title', 'cowidgets'),
						'name' => __('Name (slug)', 'cowidgets'),
						'date' => __('Date', 'cowidgets'),
						'modified' => __('Modified', 'cowidgets'),
					],
					'condition' => [
						'source_type' => 'portfolio'
					]
				]
			);

			$elementor->add_control(
				'items_order',
				[
					'label' => __( 'Order', 'cowidgets' ),
					'type' => \Elementor\Controls_Manager::SELECT,
					'default' => 'desc',
					'multiple' => false,
					'options' => [
						'desc' => __('Descending', 'cowidgets'),
						'asc' => __('Ascending', 'cowidgets'),
					],
					'condition' => [
						'source_type' => 'portfolio'
					]
				]
			);
			//all
			$elementor->add_control(
				'slides_posts',
				[
					'label' => __( 'Slides', 'cowidgets' ),
					'type' => \Elementor\Controls_Manager::SELECT2,
					'default' => ['empty'],
					'multiple' => true,
					'options' => \COWIDGETS_Helpers::getItems( 'any', false ),
					'condition' => [
						'source_type' => 'all_post_types'
					]
				]
			);
			//all
			$elementor->add_control(
				'slides_gallery',
				[
					'label' => __( 'Slides', 'cowidgets' ),
					'type' => \Elementor\Controls_Manager::GALLERY,
					'condition' => [
						'source_type' => 'gallery'
					]
				]
			);

			$repeater = new \Elementor\Repeater();
			$repeater->add_control(
				'video_title',
				[
					'label' => __( 'Title', 'cowidgets' ),
					'type' => \Elementor\Controls_Manager::TEXT,
				]
			);
			$repeater->add_control(
				'video_media',
				[
					'label' => __( 'Choose File', 'elementor' ),
					'type' => \Elementor\Controls_Manager::MEDIA,
					'media_type' => 'video',
				]
			);
			$repeater->add_control(
				'video_permalink',
				[
					'label' => __( 'Permalink', 'cowidgets' ),
					'type' => \Elementor\Controls_Manager::URL,
				]
			);
			$elementor->add_control(
				'videos',
				[
					'label' => __( 'Videos', 'codeless-elements' ),
					'type' => \Elementor\Controls_Manager::REPEATER,
					'fields' => $repeater->get_controls(),
					'default' => [
						
					],
					'title_field' => '{{{ video_title }}}',
					'condition' => [
						'source_type' => 'videos'
					]
				]
			);

        $elementor->end_controls_section();
    }


    public static function getslidesSelection( $settings ){
        $return = [];
        if( $settings['source_type'] == 'gallery' ){
            if( !empty( $settings['slides_gallery'] ) ){
                foreach( $settings['slides_gallery'] as $bulk_img ){
                    $return[] = array( 
                        'caption'  => wp_get_attachment_caption( $bulk_img['id'] ),
                        'title' => get_the_title( $bulk_img['id'] ),
						'src' => $bulk_img['url'],
						'permalink' => get_post_meta( $bulk_img['id'], 'ce_permalink', true )
                    );
                }  
            }
        }
    
        if( $settings['source_type'] == 'portfolio' || $settings['source_type'] == 'all_post_types' ){
            $from_posts = $settings['source_type'] == 'portfolio' ? $settings['slides_portfolio'] : $settings['slides_posts'];
			$new_query = array(
				'posts_per_page' => -1,
				'post__in' => $from_posts,
				'orderby' => $settings['items_orderby'],
				'order' => $settings['items_order']
			);
			if( $settings['source_type'] == 'portfolio' )
				$new_query['post_type'] = 'portfolio';
			
			$the_query = new \WP_Query( $new_query );
					
			if ( is_object( $the_query ) && $the_query->have_posts() ) :

				while ( $the_query->have_posts() ) : $the_query->the_post();
					$return[] = array(
                        'id' => (int) get_the_ID(),
                        'caption'  => '',
                        'title' => get_the_title( ),
						'src' => wp_get_attachment_image_src( get_post_thumbnail_id( (int) get_the_ID() ), 'full' )[0],
						'permalink' => get_permalink( )
                    );
				endwhile;
			
			endif;
						
		}
		
		if( $settings['source_type'] == 'videos' ){
			$return = $settings['videos'];
		}
    
        return $return; 
	}



	public static function portfolioSelectionSection( $elementor ) {

        $elementor->start_controls_section(
			'section_title',
			[
				'label' => __( 'Items', 'cowidgets' ),
			]
		);

		$elementor->add_control(
			'source_type',
			[
				'label' => __( 'Source Type', 'cowidgets' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'portfolio',
				'options' => [
					'portfolio'	=> __( 'Portfolio Post Type', 'cowidgets' ),
					'all_post_types'  => __( 'All Posts', 'cowidgets' ),
					'gallery' => __( 'Gallery', 'cowidgets' ),
				],
			]
		);
			//if portfolio
			$elementor->add_control(
				'items_categories',
				[
					'label' => __( 'Categories', 'cowidgets' ),
					'type' => \Elementor\Controls_Manager::SELECT2,
					'default' => '',
					'multiple' => true,
					'options' => \COWIDGETS_Helpers::getTerms( 'portfolio_entries', false ),
					'condition' => [
						'source_type' => 'portfolio'
					]
				]
			);

			$elementor->add_control(
				'items_per_page',
				[
					'label' => __( 'Items Number (per page)', 'cowidgets' ),
					'type' => \Elementor\Controls_Manager::TEXT,
					'description' => __( 'Number of items to load on this element', 'cowidgets' ),
					'default' => 9,
					'condition' => [
						'source_type' => 'portfolio'
					]
				]
			);

			$elementor->add_control(
				'items_orderby',
				[
					'label' => __( 'Order By', 'cowidgets' ),
					'type' => \Elementor\Controls_Manager::SELECT,
					'default' => 'date',
					'multiple' => false,
					'options' => [
						'none' => __('No order', 'cowidgets'),
						'ID' => __('Post ID', 'cowidgets'),
						'author' => __('Author', 'cowidgets'),
						'title' => __('Title', 'cowidgets'),
						'name' => __('Name (slug)', 'cowidgets'),
						'date' => __('Date', 'cowidgets'),
						'modified' => __('Modified', 'cowidgets'),
					],
					'condition' => [
						'source_type' => 'portfolio'
					]
				]
			);

			$elementor->add_control(
				'items_order',
				[
					'label' => __( 'Order', 'cowidgets' ),
					'type' => \Elementor\Controls_Manager::SELECT,
					'default' => 'desc',
					'multiple' => false,
					'options' => [
						'desc' => __('Descending', 'cowidgets'),
						'asc' => __('Ascending', 'cowidgets'),
					],
					'condition' => [
						'source_type' => 'portfolio'
					]
				]
			);

			$elementor->add_control(
				'items_portfolio',
				[
					'label' => __( 'Include Items', 'cowidgets' ),
					'type' => \Elementor\Controls_Manager::SELECT2,
					'description' => __( 'This option overwrites other settings', 'cowidgets' ),
				
					'multiple' => true,
					'options' => \COWIDGETS_Helpers::getItems( 'portfolio', false ),
					'condition' => [
						'source_type' => 'portfolio'
					]
				]
			);

			$elementor->add_control(
				'items_portfolio_exclude',
				[
					'label' => __( 'Exclude Items', 'cowidgets' ),
					'type' => \Elementor\Controls_Manager::SELECT2,
					'description' => __( 'Set a list of items to be excluded from the query', 'cowidgets' ),
				
					'multiple' => true,
					'options' => \COWIDGETS_Helpers::getItems( 'portfolio', false ),
					'condition' => [
						'source_type' => 'portfolio'
					]
				]
			);

			//all
			$elementor->add_control(
				'items_posts',
				[
					'label' => __( 'Items', 'cowidgets' ),
					'type' => \Elementor\Controls_Manager::SELECT2,
					
					'multiple' => true,
					'options' => \COWIDGETS_Helpers::getItems( 'any', false ),
					'condition' => [
						'source_type' => 'all_post_types'
					]
				]
			);
			//all
			$elementor->add_control(
				'items_gallery',
				[
					'label' => __( 'Items', 'cowidgets' ),
					'type' => \Elementor\Controls_Manager::GALLERY,
					'condition' => [
						'source_type' => 'gallery'
					]
				]
			);

        $elementor->end_controls_section();
	}

	public static function testimonialSelectionSection( $elementor ) {

        $elementor->start_controls_section(
			'section_title',
			[
				'label' => __( 'Items', 'cowidgets' ),
			]
		);

		$elementor->add_control(
			'source_type',
			[
				'label' => __( 'Source Type', 'cowidgets' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'testimonial',
				'options' => [
					'testimonial'	=> __( 'Testimonial Post Type', 'cowidgets' ),
					'all_post_types'  => __( 'All Posts', 'cowidgets' )
				],
			]
		);
			//if testimonial
			$elementor->add_control(
				'items_categories',
				[
					'label' => __( 'Categories', 'cowidgets' ),
					'type' => \Elementor\Controls_Manager::SELECT2,
					'default' => '',
					'multiple' => true,
					'options' => \COWIDGETS_Helpers::getTerms( 'testimonial_entries', false ),
					'condition' => [
						'source_type' => 'testimonial'
					]
				]
			);

			$elementor->add_control(
				'items_per_page',
				[
					'label' => __( 'Items Number (per page)', 'cowidgets' ),
					'type' => \Elementor\Controls_Manager::TEXT,
					'description' => __( 'Number of items to load on this element', 'cowidgets' ),
					'default' => 9,
					'condition' => [
						'source_type' => 'testimonial'
					]
				]
			);

			$elementor->add_control(
				'items_orderby',
				[
					'label' => __( 'Order By', 'cowidgets' ),
					'type' => \Elementor\Controls_Manager::SELECT,
					'default' => 'date',
					'multiple' => false,
					'options' => [
						'none' => __('No order', 'cowidgets'),
						'ID' => __('Post ID', 'cowidgets'),
						'author' => __('Author', 'cowidgets'),
						'title' => __('Title', 'cowidgets'),
						'name' => __('Name (slug)', 'cowidgets'),
						'date' => __('Date', 'cowidgets'),
						'modified' => __('Modified', 'cowidgets'),
					],
					'condition' => [
						'source_type' => 'testimonial'
					]
				]
			);

			$elementor->add_control(
				'items_order',
				[
					'label' => __( 'Order', 'cowidgets' ),
					'type' => \Elementor\Controls_Manager::SELECT,
					'default' => 'desc',
					'multiple' => false,
					'options' => [
						'desc' => __('Descending', 'cowidgets'),
						'asc' => __('Ascending', 'cowidgets'),
					],
					'condition' => [
						'source_type' => 'testimonial'
					]
				]
			);

			$elementor->add_control(
				'items_testimonial',
				[
					'label' => __( 'Include Items', 'cowidgets' ),
					'type' => \Elementor\Controls_Manager::SELECT2,
					'description' => __( 'This option overwrites other settings', 'cowidgets' ),
				
					'multiple' => true,
					'options' => \COWIDGETS_Helpers::getItems( 'testimonial', false ),
					'condition' => [
						'source_type' => 'testimonial'
					]
				]
			);

			//all
			$elementor->add_control(
				'items_posts',
				[
					'label' => __( 'Items', 'cowidgets' ),
					'type' => \Elementor\Controls_Manager::SELECT2,
					
					'multiple' => true,
					'options' => \COWIDGETS_Helpers::getItems( 'any', false ),
					'condition' => [
						'source_type' => 'all_post_types'
					]
				]
			);

        $elementor->end_controls_section();
	}



	public static function staffSelectionSection( $elementor ) {

        $elementor->start_controls_section(
			'section_title',
			[
				'label' => __( 'Items', 'cowidgets' ),
			]
		);

		$elementor->add_control(
			'source_type',
			[
				'label' => __( 'Source Type', 'cowidgets' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'staff',
				'options' => [
					'staff'	=> __( 'Staff Post Type', 'cowidgets' ),
					'all_post_types'  => __( 'All Posts', 'cowidgets' )
				],
			]
		);
			//if Staff
			$elementor->add_control(
				'items_categories',
				[
					'label' => __( 'Categories', 'cowidgets' ),
					'type' => \Elementor\Controls_Manager::SELECT2,
					'default' => '',
					'multiple' => true,
					'options' => \COWIDGETS_Helpers::getTerms( 'staff_entries', false ),
					'condition' => [
						'source_type' => 'staff'
					]
				]
			);

			$elementor->add_control(
				'items_per_page',
				[
					'label' => __( 'Items Number (per page)', 'cowidgets' ),
					'type' => \Elementor\Controls_Manager::TEXT,
					'description' => __( 'Number of items to load on this element', 'cowidgets' ),
					'default' => 9,
					'condition' => [
						'source_type' => 'staff'
					]
				]
			);

			$elementor->add_control(
				'items_orderby',
				[
					'label' => __( 'Order By', 'cowidgets' ),
					'type' => \Elementor\Controls_Manager::SELECT,
					'default' => 'date',
					'multiple' => false,
					'options' => [
						'none' => __('No order', 'cowidgets'),
						'ID' => __('Post ID', 'cowidgets'),
						'author' => __('Author', 'cowidgets'),
						'title' => __('Title', 'cowidgets'),
						'name' => __('Name (slug)', 'cowidgets'),
						'date' => __('Date', 'cowidgets'),
						'modified' => __('Modified', 'cowidgets'),
					],
					'condition' => [
						'source_type' => 'staff'
					]
				]
			);

			$elementor->add_control(
				'items_order',
				[
					'label' => __( 'Order', 'cowidgets' ),
					'type' => \Elementor\Controls_Manager::SELECT,
					'default' => 'desc',
					'multiple' => false,
					'options' => [
						'desc' => __('Descending', 'cowidgets'),
						'asc' => __('Ascending', 'cowidgets'),
					],
					'condition' => [
						'source_type' => 'staff'
					]
				]
			);

			$elementor->add_control(
				'items_staff',
				[
					'label' => __( 'Include Items', 'cowidgets' ),
					'type' => \Elementor\Controls_Manager::SELECT2,
					'description' => __( 'This option overwrites other settings', 'cowidgets' ),
				
					'multiple' => true,
					'options' => \COWIDGETS_Helpers::getItems( 'staff', false ),
					'condition' => [
						'source_type' => 'staff'
					]
				]
			);

			//all
			$elementor->add_control(
				'items_posts',
				[
					'label' => __( 'Items', 'cowidgets' ),
					'type' => \Elementor\Controls_Manager::SELECT2,
					
					'multiple' => true,
					'options' => \COWIDGETS_Helpers::getItems( 'any', false ),
					'condition' => [
						'source_type' => 'all_post_types'
					]
				]
			);

        $elementor->end_controls_section();
	}


	public static function animationSection( $elementor ){
		$elementor->start_controls_section(
			'section_content_animation',
			[
				'label'     => __( 'Animation', 'cowidgets' ),
				'tab'       => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);
		$elementor->add_control(
			'ce_animation',
			[
				'label' => __( 'Animation', 'cowidgets' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'none',
				'options' => [
                    'none'	=> 'None',
					'top-t-bottom' =>	'Top-Bottom',
					'bottom-t-top' =>	'Bottom-Top',
					'right-t-left' => 'Right-Left',
					'left-t-right' => 'Left-Right',
					'alpha-anim' => 'Fade-In',	
					'zoom-in' => 'Zoom-In',	
					'zoom-out' => 'Zoom-Out',
					'zoom-reverse' => 'Zoom-Reverse',
					'reveal-right' => 'Reveal Right',
					'reveal-left' => 'Reveal Left',
					'reveal-top' => 'Reveal Top',
					'reveal-bottom' => 'Reveal Bottom',
					'interchange_left_right' => 'Interchange Left-Right'
                ],

                'render_type' => 'template'
			]
        );

        $elementor->add_control(
			'ce_animation_speed',
			[
				'label' => __( 'Animation Duration', 'cowidgets' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => '300',
				'options' => [
					'100' =>	'ms 100',
					'200' =>	'ms 200',
					'300' =>	'ms 300',
					'400' =>	'ms 400',
					'500' =>	'ms 500',
					'600' =>	'ms 600',
					'700' =>	'ms 700',
					'800' =>	'ms 800',
					'900' =>	'ms 900',
					'1000' =>	'ms 1000',
					'1100' =>	'ms 1100',
					'1200' =>	'ms 1200',
					'1300' =>	'ms 1300',
					'1400' =>	'ms 1400',
					'1500' =>	'ms 1500',
					'1600' =>	'ms 1600',
					'1700' =>	'ms 1700',
					'1800' =>	'ms 1800',
					'1900' =>	'ms 1900',
					'2000' =>	'ms 2000',
                ],

                'condition' => [
                    'ce_animation!' => 'none'
                ],

                'render_type' => 'template'
			]
        );

        $elementor->add_control(
			'ce_animation_delay',
			[
				'label' => __( 'Animation Delay', 'cowidgets' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => '0',
				'options' => [
                    '0'	  =>    'ms 0',
					'100' =>	'ms 100',
					'200' =>	'ms 200',
					'300' =>	'ms 300',
					'400' =>	'ms 400',
					'500' =>	'ms 500',
					'600' =>	'ms 600',
					'700' =>	'ms 700',
					'800' =>	'ms 800',
					'900' =>	'ms 900',
					'1000' =>	'ms 1000',
					'1100' =>	'ms 1100',
					'1200' =>	'ms 1200',
					'1300' =>	'ms 1300',
					'1400' =>	'ms 1400',
					'1500' =>	'ms 1500',
					'1600' =>	'ms 1600',
					'1700' =>	'ms 1700',
					'1800' =>	'ms 1800',
					'1900' =>	'ms 1900',
					'2000' =>	'ms 2000',
                ],

                'condition' => [
                    'ce_animation!' => 'none'
                ],

                'render_type' => 'template'
			]
        );

		$elementor->end_controls_section();
	}

	public static function portfolioItemTitle( $settings ){
		return get_the_title();
	}

	public static function portfolioItemDesc( $settings ){
		return get_the_excerpt();
	}

	public static function portfolioItemPermalink( $settings ){
		if( $settings['source_type'] != 'gallery' ){
			$custom_link = get_post_meta( get_the_ID(), 'ce_portfolio_custom_link', true );
			if( $custom_link )
				return $custom_link;
	
			return get_permalink();
		}else{
			return get_post_meta( get_the_ID(), 'ce_permalink', true );
		}
	}

	public static function portfolioItemThumbnail( $settings, $final_image_size ){
		if( $settings['source_type'] != 'gallery' ){
			return the_post_thumbnail( $final_image_size );
		}else{
			$image = wp_get_attachment_image_src( get_the_ID(), $final_image_size );
			$url = $image[0];
			?>
			<img src="<?php echo esc_url( $url ) ?>" alt="<?php echo esc_attr( get_post_meta( get_the_ID(), '_wp_attachment_image_alt', true ) ) ?>" />
			<?php
		}
	}
	public static function portfolioItemThumbnailURL( $settings, $final_image_size ){
		
			$image = wp_get_attachment_image_src( get_the_ID(), $final_image_size );print_r($image);
			$url = $image[0];
			 return  $url; 

		
	}

	public static function portfolioItemCategories( $settings, $id, $taxonomy, $before = '', $sep = '', $after = ''){
		if( $settings['source_type'] != 'gallery' )
			return get_the_term_list( $id, $taxonomy, $before, $sep, $after );
		else
			return get_the_excerpt();
	}

	public static function showportfolioItemCategories( $settings, $id, $taxonomy, $before = '', $sep = '', $after = ''){
		if( $settings['source_type'] != 'gallery' ):
			$terms = get_the_terms( $id ,  'portfolio_entries' );
			// init counter
			$cats = '';
			foreach ( $terms as $term ) {
			
				$cats .= $term->slug;
				//  Add comma (except after the last theme)
				
			}
			return $cats;
		else:
			return get_the_excerpt();
		endif;
	}

	public static function testimonialItemPosition(){
		$position = get_post_meta( get_the_ID(), 'ce_testimonial_position', true );

		return $position ? $position : '';
	}

	public static function staffItemPosition(){
		$position = get_post_meta( get_the_ID(), 'ce_staff_position', true );

		return $position ? $position : '';
	}

	public static function staffItemPermalink(){
		$custom_link = get_post_meta( get_the_ID(), 'ce_staff_custom_link', true );
		if( $custom_link )
			return $custom_link;
	
		return get_permalink();
		
	}

	public static function staffItemSocials(){
		$social_list = apply_filters( 'ce_staff_social_list', array(
			array( 'id' => 'twitter', 'icon' => 'cl-icon-twitter' ),
			array( 'id' => 'facebook', 'icon' => 'cl-icon-facebook' ),
			array( 'id' => 'linkedin', 'icon' => 'cl-icon-linkedin' ),
			array( 'id' => 'pinterest', 'icon' => 'cl-icon-pinterest' ),
			array( 'id' => 'instagram', 'icon' => 'cl-icon-instagram' ),
		));
			
		$output = '';
		if( empty($social_list) )
			return;
	
		foreach($social_list as $social){
			$link = get_post_meta( get_the_ID(), 'ce_staff_social_'.$social['id'], true );

			if( $link != '' ){
				$output .= '<a href="'.esc_url( $link ).'"><i class="'.esc_attr( $social['icon'] ).'"></i></a>';
			}
		}

		
		return $output;
	}

	public static function staffItemExcerpt(){
		$excerpt = get_the_excerpt( get_the_ID() );			
		$output = '';
		if( !empty( $excerpt ) ){
			$output .= '<p>'. esc_html( $excerpt ) .'</p>';
		}
		
		return $output;
	}

	public static function postsSelectionSection( $elementor ){
		$elementor->start_controls_section(
			'section_title',
			[
				'label' => __( 'Posts', 'cowidgets' ),
			]
		);


			//if portfolio
			$elementor->add_control(
				'items_categories',
				[
					'label' => __( 'Categories', 'cowidgets' ),
					'type' => \Elementor\Controls_Manager::SELECT2,
					'default' => '',
					'multiple' => true,
					'options' => \COWIDGETS_Helpers::getTerms( 'category', false ),
				]
			);

			$elementor->add_control(
				'items_per_page',
				[
					'label' => __( 'Items Number (per page)', 'cowidgets' ),
					'type' => \Elementor\Controls_Manager::TEXT,
					'description' => __( 'Number of items to load on this element', 'cowidgets' ),
					'default' => 9,
				]
			);

			$elementor->add_control(
				'items_orderby',
				[
					'label' => __( 'Order By', 'cowidgets' ),
					'type' => \Elementor\Controls_Manager::SELECT,
					'default' => 'date',
					'multiple' => false,
					'options' => [
						'none' => __('No order', 'cowidgets'),
						'ID' => __('Post ID', 'cowidgets'),
						'author' => __('Author', 'cowidgets'),
						'title' => __('Title', 'cowidgets'),
						'name' => __('Name (slug)', 'cowidgets'),
						'date' => __('Date', 'cowidgets'),
						'modified' => __('Modified', 'cowidgets'),
					],
				]
			);

			$elementor->add_control(
				'items_order',
				[
					'label' => __( 'Order', 'cowidgets' ),
					'type' => \Elementor\Controls_Manager::SELECT,
					'default' => 'desc',
					'multiple' => false,
					'options' => [
						'desc' => __('Descending', 'cowidgets'),
						'asc' => __('Ascending', 'cowidgets'),
					],
				]
			);

			$elementor->add_control(
				'posts',
				[
					'label' => __( 'Include Items', 'cowidgets' ),
					'type' => \Elementor\Controls_Manager::SELECT2,
					'description' => __( 'This option overwrites other settings', 'cowidgets' ),
				
					'multiple' => true,
					'options' => \COWIDGETS_Helpers::getItems( 'post', false ),
				]
			);

        $elementor->end_controls_section();
	}

	public static function podcastsSelectionSection( $elementor ){
		$elementor->start_controls_section(
			'section_title',
			[
				'label' => __( 'Podcasts', 'cowidgets' ),
			]
		);


			//if portfolio
			$elementor->add_control(
				'items_categories',
				[
					'label' => __( 'Podcast Shows', 'cowidgets' ),
					'type' => \Elementor\Controls_Manager::SELECT2,
					'default' => '',
					'multiple' => true,
					'options' => \COWIDGETS_Helpers::getTerms( 'podcast_shows', false ),
				]
			);

			$elementor->add_control(
				'items_per_page',
				[
					'label' => __( 'Items Number (per page)', 'cowidgets' ),
					'type' => \Elementor\Controls_Manager::TEXT,
					'description' => __( 'Number of items to load on this element', 'cowidgets' ),
					'default' => 9,
				]
			);

			$elementor->add_control(
				'items_orderby',
				[
					'label' => __( 'Order By', 'cowidgets' ),
					'type' => \Elementor\Controls_Manager::SELECT,
					'default' => 'date',
					'multiple' => false,
					'options' => [
						'none' => __('No order', 'cowidgets'),
						'ID' => __('Post ID', 'cowidgets'),
						'author' => __('Author', 'cowidgets'),
						'title' => __('Title', 'cowidgets'),
						'name' => __('Name (slug)', 'cowidgets'),
						'date' => __('Date', 'cowidgets'),
						'modified' => __('Modified', 'cowidgets'),
					],
				]
			);

			$elementor->add_control(
				'items_order',
				[
					'label' => __( 'Order', 'cowidgets' ),
					'type' => \Elementor\Controls_Manager::SELECT,
					'default' => 'desc',
					'multiple' => false,
					'options' => [
						'desc' => __('Descending', 'cowidgets'),
						'asc' => __('Ascending', 'cowidgets'),
					],
				]
			);

			$elementor->add_control(
				'posts',
				[
					'label' => __( 'Include Items', 'cowidgets' ),
					'type' => \Elementor\Controls_Manager::SELECT2,
					'description' => __( 'This option overwrites other settings', 'cowidgets' ),
				
					'multiple' => true,
					'options' => \COWIDGETS_Helpers::getItems( 'podcast', false ),
				]
			);

        $elementor->end_controls_section();
	}

	public static function showsSelectionSection( $elementor ){
		$elementor->start_controls_section(
			'section_title',
			[
				'label' => __( 'Podcasts', 'cowidgets' ),
			]
		);


			//if portfolio
			$elementor->add_control(
				'items_categories',
				[
					'label' => __( 'Podcast Shows', 'cowidgets' ),
					'type' => \Elementor\Controls_Manager::SELECT2,
					'default' => '',
					'multiple' => true,
					'options' => \COWIDGETS_Helpers::getTerms( 'podcast_shows', false ),
				]
			);

			$elementor->add_control(
				'items_per_page',
				[
					'label' => __( 'Items Number (per page)', 'cowidgets' ),
					'type' => \Elementor\Controls_Manager::TEXT,
					'description' => __( 'Number of items to load on this element', 'cowidgets' ),
					'default' => 4,
				]
			);


        $elementor->end_controls_section();
	}

	public static function getShareTools($pre = ''){
    
		$output = '<div class="ce-share-buttons">'.$pre;
		
		$url = urlencode(get_permalink());
 
		// Get current page title
		$title = str_replace( ' ', '%20', get_the_title());
			
		// Get Post Thumbnail for pinterest
		$thumbnail = wp_get_attachment_image_src( get_post_thumbnail_id(), 'full' );
		
		$shares = array();

		$share_option = apply_filters( 'ce_share_buttons_pre', array( 'twitter', 'pinterest', 'facebook' ) );
		
		if( isset( $for_element ) )
			$share_option = array( 'twitter', 'facebook', 'google', 'whatsapp', 'linkedin', 'pinterest' );
		
		// Construct sharing URL without using any script
		if( in_array( 'twitter', $share_option ) ){
			$shares['twitter']['link'] = 'https://twitter.com/intent/tweet?text='.$title.'&amp;url='.$url;
			$shares['twitter']['icon'] = 'cl-icon-twitter';
		}

		
		if( in_array( 'facebook', $share_option ) ){
			$shares['facebook']['link'] = 'https://www.facebook.com/sharer/sharer.php?u='.$url;
			$shares['facebook']['icon'] = 'cl-icon-facebook-f';
		}
		
		if( in_array( 'google', $share_option ) ){
			$shares['google']['link'] = 'https://plus.google.com/share?url='.$url;
			$shares['google']['icon'] = 'cl-icon-google';
		}
		
		if( in_array( 'whatsapp', $share_option ) ){
			$shares['whatsapp']['link'] = 'whatsapp://send?text='.$title . ' ' . $url;
			$shares['whatsapp']['icon'] = 'cl-icon-whatsapp';
		}
		
		if( in_array( 'linkedin', $share_option ) ){
			$shares['linkedin']['link'] = 'https://www.linkedin.com/shareArticle?mini=true&url='.$url.'&amp;title='.$title;
			$shares['linkedin']['icon'] = 'cl-icon-linkedin';
		}
		
		if( in_array( 'pinterest', $share_option ) ){
			$shares['pinterest']['link'] = 'https://pinterest.com/pin/create/button/?url='.$url.'&amp;media='.$thumbnail[0].'&amp;description='.$title;
			$shares['pinterest']['icon'] = 'cl-icon-pinterest';
		}
		
		
		$shares = apply_filters( 'ce_share_buttons_final', $shares, $title, $url, $thumbnail );
		
		if( !empty( $shares ) ){
			foreach( $shares as $social_id => $data ){
				$output .= '<a href="' . $data['link'] . '" title="Social Share ' . $social_id . '" target="_blank"><i class="' . $data['icon'] .'"></i></a>';
			}
		}
		$output .= '</div>';
		
		return $output;
	}

	public static function excerpt_limit($limit) {
		$excerpt = explode(' ', get_the_excerpt(), $limit);
		if (count($excerpt)>=$limit) {
		  array_pop($excerpt);
		  $excerpt = implode(" ",$excerpt).'...';
		} else {
		  $excerpt = implode(" ",$excerpt);
		}	
		$excerpt = preg_replace('`[[^]]*]`','',$excerpt);
		return $excerpt;
	  }

	  public static function productsQuerySection( $elementor ){
		$elementor->start_controls_section(
			'section_title',
			[
				'label' => __( 'Products Query', 'cowidgets' ),
			]
		);

		$elementor->add_control(
			'number',
			[
				'label' => __( 'Number per page', 'cowidgets' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'description' => __( 'Number of items to load on this element', 'cowidgets' ),
				'default' => 9,
			]
		);

		$elementor->add_control(
			'columns',
			[
				'label' => __( 'Columns', 'cowidgets' ),
				'type' => \Elementor\Controls_Manager::SELECT2,
				'description' => __( 'Number of columns of products for row', 'cowidgets' ),
				'default' => 4,
				'options' => [
					'1' 		=> __( '1 Column', 'cowidgets' ),
					'2' 		=> __( '2 Columns', 'cowidgets' ),
					'3' 		=> __( '3 Columns', 'cowidgets' ),
					'4' 		=> __( '4 Columns', 'cowidgets' ),
					'5' 		=> __( '5 Columns', 'cowidgets' )
				],
			]
		);

		$elementor->add_control(
			'query',
			[
				'label' => __( 'Query', 'cowidgets' ),
				'type' => \Elementor\Controls_Manager::SELECT2,
				'default' => 'all',
				'multiple' => false,
				'options' => [
					'all' 		=> __( 'All', 'cowidgets' ),
					'featured' 	=> __( 'Featured', 'cowidgets' ),
					'sale' 		=> __( 'On Sale', 'cowidgets' ),
					'best' 		=> __( 'Best Selling', 'cowidgets' ),
					'top' 		=> __( 'Top Rated', 'cowidgets' ),
				],
			]
		);

		

		$elementor->add_control(
			'product_cat',
			[
				'label' => __( 'Categories', 'cowidgets' ),
				'type' => \Elementor\Controls_Manager::SELECT2,
				'description' => __( 'Specific Product Categories for this query. Leave empty to show all', 'cowidgets' ),
				'multiple' => true,
				'options' => \COWIDGETS_Helpers::getTerms( 'product_cat', false ),
			]
		);

		$elementor->add_control(
			'product_tag',
			[
				'label' => __( 'Tags', 'cowidgets' ),
				'type' => \Elementor\Controls_Manager::SELECT2,
				'description' => __( 'Specific Product Tags for this query. Leave empty to show all', 'cowidgets' ),
				'multiple' => true,
				'options' => \COWIDGETS_Helpers::getTerms( 'product_tag', false ),
			]
		);

		$elementor->add_control(
			'product_ids',
			[
				'label' => __( 'Specific Products', 'cowidgets' ),
				'type' => \Elementor\Controls_Manager::SELECT2,
				'description' => __( 'Specific Product Ids to show on this query(tag/category). Leave empty to show all', 'cowidgets' ),
				'multiple' => true,
				'options' => \COWIDGETS_Helpers::getItems( 'product', false ),
			]
		);

		$elementor->add_control(
			'orderby',
			[
				'label' => __( 'Order By', 'cowidgets' ),
				'type' => \Elementor\Controls_Manager::SELECT2,
				'default' => 'date',
				'multiple' => false,
				'options' => [
					'date' 			=> __( 'Date', 'cowidgets' ),
					'id' 			=> __( 'Id', 'cowidgets' ),
					'menu_order' 	=> __( 'Menu Order', 'cowidgets' ),
					'popularity' 	=> __( 'Popularity', 'cowidgets' ),
					'rand' 			=> __( 'Random', 'cowidgets' ),
					'rating' 		=> __( 'Rating', 'cowidgets' ),
					'title' 		=> __( 'Title', 'cowidgets' ),
				],
			]
		);

		$elementor->add_control(
			'order',
			[
				'label' => __( 'Order', 'cowidgets' ),
				'type' => \Elementor\Controls_Manager::SELECT2,
				'default' => 'desc',
				'multiple' => false,
				'options' => [
					'desc' 			=> __( 'Descending', 'cowidgets' ),
					'asc' 			=> __( 'Ascending', 'cowidgets' )
				],
			]
		);

		$elementor->end_controls_section();
	  }
} 
?>