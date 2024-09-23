( function( $ ) {

	/**
	 * Kiri Slider
	 *
	 */
	var WidgetTapiSliderHandler = function( $scope, $ ) {
        const element = $scope[0].querySelector( '.swiper-container' );
        
        var mySwiper = new Swiper (element, {
            on:{
                init: function(){
                    COWIDGETS_Global.animation( $( this.slides[this.activeIndex] ), true );
                },
                transitionEnd: function(){
                    COWIDGETS_Global.animation( $( this.slides[this.activeIndex] ), true );
                }
            },
            autoplay: {
                delay: 4000,
            }
        })
    };

	$( window ).on( 'elementor/frontend/init', function () {

		elementorFrontend.hooks.addAction( 'frontend/element_ready/tapi-slider.default', WidgetTapiSliderHandler );

	});

} )( jQuery );