( function( $ ) {

	/**
	 * Kiri Slider
	 *
	 */
	var WidgetPaoSliderHandler = function( $scope, $ ) {
        const element = $scope[0].querySelector( '.swiper-container' );
        
        var mySwiper = new Swiper (element, {
            on:{
                init: function(){
                    COWIDGETS_Global.animation( $( this.slides[this.activeIndex] ), true );
                    var next_url = $(this.slides[this.activeIndex]).next().find('img').attr('src');
                    if( next_url != 'undefined' )
                        $('.swiper-button-next', $(element) ).find('.image').css('background-image', 'url('+next_url+')');
                },
                slideChange: function(){
                    COWIDGETS_Global.animation( $( this.slides[this.activeIndex] ), true );

                    var next_url = $(this.slides[this.activeIndex]).next().find('img').attr('src');
                    if( next_url != 'undefined' )
                        $('.swiper-button-next', $(element) ).find('.image').css('background-image', 'url('+next_url+')');

                    var prev_url = $(this.slides[this.activeIndex]).prev().find('img').attr('src');
                    if( prev_url != 'undefined' )
                        $('.swiper-button-prev', $(element) ).find('.image').css('background-image', 'url('+prev_url+')');
                }
            },
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
            effect: 'fade'
        })
    };

	$( window ).on( 'elementor/frontend/init', function () {

		elementorFrontend.hooks.addAction( 'frontend/element_ready/pao-slider.default', WidgetPaoSliderHandler );

	});

} )( jQuery );