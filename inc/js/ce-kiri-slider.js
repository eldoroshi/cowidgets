( function( $ ) {

	/**
	 * Kiri Slider
	 *
	 */
	var WidgetKiriSliderHandler = function( $scope, $ ) {
		var $element = $scope.find( '.ce-kiri-slider' ),
			$slideImgsWrapper = $element.find( '.slide-img-wrapper' ),
			$slideImgs = $element.find( '.slide-img' ),
			$titleWrapper = $element.find( '.title-wrapper' ),
			$slideTitles = $element.find( '.title-wrapper .slide-title' ),
			$actualProject = $element.find( '.project-number .actual' );

		$slideImgs.find('img').each(function(){
			var srcLoad =  $(this).attr('data-src');
			$(this).attr('src', srcLoad);
		});

		var scrollHide = function(){
			var body = document.body,
				html = document.documentElement;

			var doc_height = Math.max( body.scrollHeight, body.offsetHeight, 
										html.clientHeight, html.scrollHeight, html.offsetHeight );
			console.log(doc_height);
			var slide_title_height = $element.find( '.slide-title' ).height();
			var slide_title_nr = $element.find( '.slide-title' ).length;
			console.log(slide_title_nr * slide_title_height + 100);
			if( doc_height >= slide_title_nr * slide_title_height + 100 )
				$element.find( '.cl-scroll-indicator' ).css({opacity: 0});					
		};

		scrollHide();

		$slideTitles.find('a').on('mouseenter', function(e){
			var $atitle = $(this),
				$title = $atitle.closest('.slide-title'),
				id = $title.attr( 'data-id' ),
				$toActiveImg = $slideImgs.filter(':nth-child('+id+')'),
				slider_type = $element.data('sliderType'),
				imgWidth = slider_type == 'images' ? $toActiveImg.find( 'img' )[0].clientWidth : 1170,
				imgHeight = slider_type == 'images' ? $toActiveImg.find( 'img' )[0].clientHeight : 658;

			$slideImgsWrapper.css({ width: imgWidth, height: imgHeight });

			$slideTitles.removeClass('active');

			$title.addClass('active');

			
			$slideImgs.removeClass('active');
			$toActiveImg.addClass('active');

			if( slider_type == 'videos' ){
				$toActiveImg.find( 'video' )[0].play();
			}
			
			$actualProject.html( id );
		});

		if( window.matchMedia( "( max-width: 991px )" ).matches ){
            $slideTitles.find('a').attr('onClick', 'return false');
            $slideTitles.find('a').on( 'click', function(){
				$slideTitles.find('a').attr('onClick', 'return false');
                if( $(this).parent().hasClass('active') )
					$(this).attr('onClick', '');
				else{
					$(this).attr('onClick', 'return false');
				}
            } );
        }
		
		$titleWrapper.on( 'scroll', function(e){
		
			var elem = $(e.currentTarget);

			if (elem[0].scrollHeight - elem.scrollTop() == elem.outerHeight() ) {
				$element.find( '.cl-scroll-indicator' ).css({opacity: 1});
			}else{
				$element.find( '.cl-scroll-indicator' ).css({opacity: 1});
			}

			scrollHide();

			COWIDGETS_Global.animation( $titleWrapper, true );
		} );
		
		COWIDGETS_Global.animation( $titleWrapper, true );
		
    };

	$( window ).on( 'elementor/frontend/init', function () {

		elementorFrontend.hooks.addAction( 'frontend/element_ready/kiri-slider.default', WidgetKiriSliderHandler );

	});

} )( jQuery );