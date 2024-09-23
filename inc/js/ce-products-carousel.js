( function( $ ) {

	/**
	 * Kiri Slider
	 *
	 */
	var WidgetProductsCarousel = function( $scope, $ ) {
        const element = $scope[0].querySelector( '.ce-products-carousel' );

        const responsiveOptions = {
            768:{
                items: 2,
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
            container: element.querySelector( '.products' ),
            items: 1,
            slideBy: parseInt( element.dataset.slideBy ),
            autoplay: parseInt( element.dataset.autoplay ),
            mouseDrag: parseInt( element.dataset.mouseDrag ),
            loop: parseInt( element.dataset.loop ),
            responsive: responsiveOptions,
            gutter: parseInt( element.dataset.gutter ),
            controls: false,
            nav: false,
            onInit: function( info ){
                if( parseInt( element.dataset.center ) ){
                    info.slideItems[1].classList.add( "centered" );
                }
                if( parseInt( element.dataset.edgePaddingSide ) )
                    info.container.style.transform = 'translate3D(0,0,0)';
                setTimeout(function(){    
                    window.ce_waypoint_animation( $( info.container ).find( '.tns-slide-active' ), true );
                }, 200);
            }
        };
        

        var slider = tns( options );

        setTimeout(function(){
            slider.updateSliderHeight();
        }, 10);

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
            element.querySelectorAll( '.ce-products-carousel-controls .ce-prev' ).forEach( (el) => el.onclick = function(e){
                e.preventDefault();
                slider.goTo('prev');
            });
            element.querySelectorAll( '.ce-products-carousel-controls .ce-next' ).forEach( (el) => el.onclick = function(e){
                e.preventDefault();
                slider.goTo('next');
            });
        }
    };

	$( window ).on( 'elementor/frontend/init', function () {

		elementorFrontend.hooks.addAction( 'frontend/element_ready/ce-products-carousel.default', WidgetProductsCarousel );

	});

} )( jQuery );