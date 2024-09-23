( function( $ ) {

	/**
	 * Staff Carousel
	 *
	 */
	var WidgetStaffCarousel = function( $scope, $ ) {
        const element = $scope[0].querySelector( '.ce-staff-carousel' );
    
        const responsiveOptions = {
            768:{
                items: parseInt( element.dataset.columns ) == 1 ? 1 : 2,
            },
            1024:{
                items: parseInt( element.dataset.columns ),
                center: parseInt( element.dataset.center ),
                startIndex: parseInt( element.dataset.startIndex ),
            }
        };

        if( element.dataset.edgePadding && element.dataset.edgePadding != 0 )
            responsiveOptions[1024]['edgePadding'] = parseInt( element.dataset.edgePadding );

        const options = {
            container: element,
            items: 1,
            slideBy: parseInt( element.dataset.slideBy ),
            autoplay: parseInt( element.dataset.autoplay ),
            mouseDrag: parseInt( element.dataset.mouseDrag ),
            loop: parseInt( element.dataset.loop ),
            responsive: responsiveOptions,
            //mode: element.dataset.mode,
            gutter: parseInt( element.dataset.gutter ),
            controls: false,
            nav: false,
            onInit: function( info ){
                if( parseInt( element.dataset.center ) ){
                    info.slideItems[1].classList.add( "centered" );
                }
                if( parseInt( element.dataset.edgePaddingSide ) )
                    info.container.style.transform = 'translate3D(0,0,0)';
                    
                window.ce_waypoint_animation( $( info.container ).find( '.tns-slide-active' ), true );
            }
        };
        

        var slider = tns( options );

        slider.events.on("transitionEnd", function(info) {
            if( parseInt( element.dataset.center ) ){
                info.slideItems[info.indexCached].classList.remove(
                "centered"
                );
            
                info.slideItems[info.index].classList.add(
                "centered"
                );   
            }
            
            window.ce_waypoint_animation( $( info.container ).find( '.tns-slide-active' ), true );
        });
        
        if( parseInt( element.dataset.carouselControls ) ){
            element.closest('.elementor-widget-container').querySelectorAll( '.ce-staff-carousel-controls .ce-prev' ).forEach( (el) => el.onclick = function(e){
                e.preventDefault();
                slider.goTo('prev');
            });
            element.closest('.elementor-widget-container').querySelectorAll( '.ce-staff-carousel-controls .ce-next' ).forEach( (el) => el.onclick = function(e){
                e.preventDefault();
                slider.goTo('next');
            });
        }
    };

	$( window ).on( 'elementor/frontend/init', function () {

		elementorFrontend.hooks.addAction( 'frontend/element_ready/ce-staff-carousel.default', WidgetStaffCarousel );

	});

} )( jQuery );