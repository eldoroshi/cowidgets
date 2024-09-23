( function( $ ) {

	/**
	 * Kiri Slider
	 *
	 */
	var WidgetBeasSliderHandler = function( $scope, $ ) {
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
                delay: 5000,
            },
            effect: 'fade',
            fadeEffect: {
                crossFade: true
            },
        });
        
        
    };

	$( window ).on( 'elementor/frontend/init', function () {

		elementorFrontend.hooks.addAction( 'frontend/element_ready/beas-slider.default', WidgetBeasSliderHandler );

	});

} )( jQuery );