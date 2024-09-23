( function( $ ) {

	/**
	 * Hudson Slider
	 *
	 */
	var WidgetHudsonSliderHandler = function( $scope, $ ) {
        var $element = $scope.find( '.ce-hudson-slider' ),
            $slideImgsWrapper = $element.find( '.slide-img-wrapper' ),
            $slideImgs = $element.find( '.slide-img' ),
            $titleWrapper = $element.find( '.title-wrapper' ),
            $slideTitles = $element.find( '.title-wrapper .slide-title' ),
            $actualProject = $element.find( '.project-number .actual' );

        $slideImgs.find('img').each(function(){
            
            var srcLoad =  $(this).attr('data-src');
            $(this).attr('src', srcLoad);
        });
        
        $slideTitles.find('a').on('mouseenter', function(e){
            var $atitle = $(this),
                $title = $atitle.closest('.slide-title'),
                id = $title.attr( 'data-id' ),
                slider_type = $element.data('sliderType'),
                $toActiveImg = $slideImgs.filter(':nth-child('+id+')');

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
    };

	$( window ).on( 'elementor/frontend/init', function () {

		elementorFrontend.hooks.addAction( 'frontend/element_ready/hudson-slider.default', WidgetHudsonSliderHandler );

	});

} )( jQuery );
