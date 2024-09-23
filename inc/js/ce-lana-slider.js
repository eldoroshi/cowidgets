( function( $ ) {

	/**
	 * Kiri Slider
	 *
	 */
	var WidgetLanaSliderHandler = function( $scope, $ ) {
        const element = $scope[0].querySelector( '.swiper-container' );
        var opts = {

            on:{
                slideChange: function(){
                    var self = this;
                    var $active = $(self.slides[self.activeIndex]);

                    if( $active.hasClass('skin-dark') )
                        $('body').removeClass('ce-lana-slider--skin-light').removeClass('ce-lana-slider--skin-dark').addClass('ce-lana-slider--skin-dark');

                    if( $active.hasClass('skin-light') )
                        $('body').removeClass('ce-lana-slider--skin-light').removeClass('ce-lana-slider--skin-dark').addClass('ce-lana-slider--skin-light');

                    if( $('body').hasClass('ce-header--transparent') ){
                        if( $active.hasClass('skin-dark') ){
                        
                            $('body').removeClass('ce-header--force-dark').removeClass('ce-header--force-light').addClass('ce-header--force-dark');
                        }
                        
                        if( $active.hasClass('skin-light') ){
                            $('body').removeClass('ce-header--force-dark').removeClass('ce-header--force-light').addClass('ce-header--force-light');
                        }
                    }

                    if( $('body').hasClass('ce-footer--transparent') ){
                        if( $active.hasClass('skin-dark') ){
                        
                            $('body').removeClass('ce-footer--force-dark').removeClass('ce-footer--force-light').addClass('ce-footer--force-dark');
                        }
                        
                        if( $active.hasClass('skin-light') ){
                            $('body').removeClass('ce-footer--force-dark').removeClass('ce-footer--force-light').addClass('ce-footer--force-light');
                        }
                    }

                    var $actualProject = $(element).find( '.project-number .actual' );
                    $actualProject.html(self.activeIndex+1);

                    $active.addClass('start-anim');
                    $(self.slides[self.activeIndex-1]).removeClass('start-anim');
                    $(self.slides[self.activeIndex+1]).removeClass('start-anim');
                    
                },
                transitionStart: function(){
                    var self = this;
                    
                },

                init: function(){
                    var self = this;
                    var $active = $(self.slides[self.activeIndex]);
                    console.log('initue');
                    if( $active.hasClass('skin-dark') )
                        $('body').removeClass('ce-lana-slider--skin-light').removeClass('ce-lana-slider--skin-dark').addClass('ce-lana-slider--skin-dark');

                    if( $active.hasClass('skin-light') )
                        $('body').removeClass('ce-lana-slider--skin-light').removeClass('ce-lana-slider--skin-dark').addClass('ce-lana-slider--skin-light');

                        if( $('body').hasClass('ce-header--transparent') ){
                            if( $active.hasClass('skin-dark') ){
                            
                                $('body').removeClass('ce-header--force-dark').removeClass('ce-header--force-light').addClass('ce-header--force-dark');
                            }
                            
                            if( $active.hasClass('skin-light') ){
                                $('body').removeClass('ce-header--force-dark').removeClass('ce-header--force-light').addClass('ce-header--force-light');
                            }
                        }
                        
                        if( $('body').hasClass('ce-footer--transparent') ){
                            if( $active.hasClass('skin-dark') ){
                            
                                $('body').removeClass('ce-footer--force-dark').removeClass('ce-footer--force-light').addClass('ce-footer--force-dark');
                            }
                            
                            if( $active.hasClass('skin-light') ){
                                $('body').removeClass('ce-footer--force-dark').removeClass('ce-footer--force-light').addClass('ce-footer--force-light');
                            }
                        }


                    $active.addClass('start-anim');
                },
                
            },

            slidesPerView: 'auto',
            initialSlide: 0,
            spaceBetween: 0,
            centeredSlides: true,
            effect: 'fade',
            mousewheel: {
                invert:false
            },
            keyboard:{
                enabled: true
            },
            navigation:{
                nextEl: '.navigation .next',
                prevEl: '.navigation .prev'
            }
        }; 
        var mySwiper = new Swiper (element, opts);
    };

	$( window ).on( 'elementor/frontend/init', function () {
        console.log('kot');
		elementorFrontend.hooks.addAction( 'frontend/element_ready/lana-slider.default', WidgetLanaSliderHandler );

	});

} )( jQuery );