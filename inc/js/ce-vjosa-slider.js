( function( $ ) {

	/**
	 * Vjosa Slider
	 *
	 */
	var WidgetVjosaSliderHandler = function( $scope, $ ) {
        var $element = $scope.find( '.ce-vjosa-slider' ),
            $slideImgsWrapper = $element.find( '.slide-img-wrapper' ),
            $slideImgs = $element.find( '.slide-img' ),
            $titleWrapper = $element.find( '.title-wrapper' ),
            $slideTitles = $element.find( '.title-wrapper .slide-title' ),
            $actualProject = $element.find( '.project-number .actual' );

            // Setup isScrolling variable
            var scrollDebounce = true;
            var actualIndex = 2;
            var timeout, anim;

            function processScroll(e) {
                
                var $toActivate = $titleWrapper.find( '.slide-title:eq('+(actualIndex)+')' );
                $element.attr('data-actual-index', actualIndex);
                $toActivate.find('a').trigger( 'vjosa-active-title' );
            }

            if( window.matchMedia( "( min-width: 992px )" ).matches ){
                // Listen for scroll events
                window.addEventListener('wheel', function ( event ) {
                    if( timeout ){
                        clearTimeout(timeout);   
                        window.cancelAnimationFrame(anim);
                    }

                    timeout = setTimeout(function () {
                        
                        anim = window.requestAnimationFrame(function(){
                            actualIndex = event.deltaY < 0 ? actualIndex - 1 : actualIndex + 1;

                            if( actualIndex < 0 ) actualIndex = 0;
                            if( actualIndex > $slideTitles.length - 1 ) actualIndex = $slideTitles.length - 1;
                            
                            
                            processScroll( event );
                            $titleWrapper[0].scrollTop = (100*actualIndex)-200;
                            
                            
                        });
                        
                    }, 100);

                }, false);
      
            }

         

            /*$element.on('wheel', function(e) {
                
                var minScrollTime = 300;
                var now = new Date().getTime();
            
                
            
                if (!scrollTimer) {
                    if (now - lastScrollFireTime > (3 * minScrollTime)) {
                        //processScroll();   // fire immediately on first scroll
                        lastScrollFireTime = now;
                    }
                    scrollTimer = setTimeout(function() {
                        scrollTimer = null;
                        lastScrollFireTime = new Date().getTime();
                        processScroll();
                    }, minScrollTime);
                }
            }); */
        
        $slideImgs.find('img').each(function(){
            
            var srcLoad =  $(this).attr('data-src');
            $(this).attr('src', srcLoad);
        });
        
        $slideTitles.find('a').on('vjosa-active-title', function(e){
            var $atitle = $(this),
                $title = $atitle.closest('.slide-title'),
                id = $title.attr( 'data-id' ),
                slider_type = $element.data('sliderType'),
                $toActiveImg = $slideImgs.filter(':eq('+(id)+')');

            $slideTitles.removeClass('active');
            $title.addClass('active');
            
            $slideImgs.removeClass('active');
            $toActiveImg.addClass('active');

            if( slider_type == 'videos' ){
                $slideImgs.find('video').each(function(){
                    var video = $(this)[0];
                    video.pause();
                })
                $toActiveImg.find( 'video' )[0].play();

			}
            
            $actualProject.html( (parseInt(id)+1) );
        });



        if( window.matchMedia( "( max-width: 991px )" ).matches ){
            $slideTitles.find('a').attr('onClick', 'return false');
            $slideTitles.find('a').on( 'click', function(){
				$slideTitles.find('a').attr('onClick', 'return false');
                if( !$(this).parent().hasClass('active') ){
                    $(this).attr('onClick', '');
                    $(this).trigger('vjosa-active-title');
				}else{
					$(this).attr('onClick', 'return false');
				}
            } );
        }
    };

	$( window ).on( 'elementor/frontend/init', function () {

		elementorFrontend.hooks.addAction( 'frontend/element_ready/vjosa-slider.default', WidgetVjosaSliderHandler );

	});

} )( jQuery );
