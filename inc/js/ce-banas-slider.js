


( function( $ ) {

	/**
	 * Banas Slider
	 *
	 */
	var WidgetBanasSliderHandler = function( $scope, $ ) {
        const element = $scope[0].querySelector( '.swiper-container' );
        var $element = $(element);
        var mySwiper = new Swiper (element, {
            on:{
                slideChange: function(){
                    var self = this;
                    var $active = $(self.slides[self.activeIndex]);
                    $active.addClass('start-anim');
                    $(self.slides[self.activeIndex-1]).removeClass('start-anim');
                    $(self.slides[self.activeIndex+1]).removeClass('start-anim');
            
                    if( self.activeIndex + 1 == self.slides.length )
                        $element.find( '.scroll' ).css({opacity: 0});
                    else
                        $element.find( '.scroll' ).css({opacity: 1});
            
                    $element.find( '.pagination a' ).removeClass('current').removeClass('prev').removeClass('next');
                    $element.find('.pagination a').eq( self.activeIndex ).addClass('current');
                    $element.find('.pagination a').eq( self.activeIndex + 1 ).addClass('next');
                    $element.find('.pagination a').eq( self.activeIndex - 1 ).addClass('prev');
                },
                transitionStart: function(){
                    var self = this;
                    
                },
            
                init: function(){
                    var self = this;
                    var $active = $(self.slides[self.activeIndex]);
                    $active.addClass('start-anim');
            
                    $element.find('.pagination a').eq( self.activeIndex ).addClass('current');
                    $element.find('.pagination a').eq( self.activeIndex + 1 ).addClass('next');
                    $element.find('.pagination a').eq( self.activeIndex - 1 ).addClass('prev');

                    setTimeout(function(){
                        $element.find('.pagination a').on('click', function(e){
                            console.log('onii');
                            e.preventDefault();
                            var index = $(this).data( 'index' );
                            self.slideTo(index);
                        });
                    }, 1000);
                    
                },
                
            },
            
            
            effect: 'fade',
            mousewheel: true,
            initialSlide: 1,
            
            pagination:{
                el: '.pagination',
                type: 'bullets',
                bulletElement: 'a',
                renderBullet: function (index, className) {  
                    return '<a href="#" class="'+className+'" data-index="'+index+'">'+$element.find('.cl-slide').eq(index).find('h2').text().substring(0,3)+'</a>';
                },
                bulletClass: 'cl-pagination-item',
                bulletActiveClass: 'current',
                modifierClass: 'cl-pagination-'
            }
        })
    };

	$( window ).on( 'elementor/frontend/init', function () {

		elementorFrontend.hooks.addAction( 'frontend/element_ready/banas-slider.default', WidgetBanasSliderHandler );

	});

} )( jQuery );