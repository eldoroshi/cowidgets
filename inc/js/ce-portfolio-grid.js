( function( $ ) {

	/**
	 * Kiri Slider
	 *
	 */
	var WidgetPortfolioGrid = function( $scope, $ ) {
        const element = $scope[0].querySelector( '.ce-portfolio-grid' );
        
        if( element.dataset.module == 'isotope' ){
            COWIDGETS_Global.loadDependencies( [ ce_global.lib_js + 'isotope.pkgd.min.js' ], function() {
                imagesLoaded( element, function(){
                    var iso = new Isotope( element, {
                        // options...
                            itemSelector: '.ce-portfolio-item',
                            percentPosition: true,
                            layoutMode: element.dataset.layout,
                            masonry: {
                            columnWidth: '.ce-portfolio-item',
                            },
                            transformsEnabled: false,
                            transitionDuration: 0,
                            stagger:30
                    });
                    $element = jQuery('.ce-portfolio-grid ');
                    $( '.ce-filters', $element.parent() ).on( 'click', 'button', function() {
                        var filterValue = jQuery(this).attr('data-filter');
                        //var filterValue = $(this).attr('data-filter');
                        if( $element.hasClass('gallery-source_type') && filterValue != '*' )
                            filterValue = '[data-caption*="' + filterValue + '"]';
                        else if( filterValue != '*' )
                            filterValue = '[data-category*="' + filterValue.substring(1) + '"]';
                        $element.find( '.ce-animation-start' ).removeClass('ce-animation-start').removeClass('ce-animation ce-animation--bottom-t-top ce-animation-manual ce-animation-start');
                        $element.isotope({ filter: filterValue, stagger:30 }); 
                        window.ce_waypoint_animation( $( element ).find( '.ce-portfolio-item' ), true );
                                        
                        jQuery(this).parent().find('button.selected').removeClass('selected');
                        jQuery(this).addClass('selected');

                    });

                    window.ce_waypoint_animation( $( element ).find( '.ce-portfolio-item' ), true );
                });
            });
        }else if( element.dataset.module == 'predefined' && parseInt( element.dataset.parallax ) && window.matchMedia( "( min-width: 992px )" ).matches ) {
            COWIDGETS_Global.loadDependencies( [ ce_global.lib_js + 'rellax.min.js' ], function() {
                imagesLoaded( element, function(){
                    element.querySelectorAll('.rellax').forEach(function(item){
                        new Rellax(item, {
                            center:true,
                            breakpoints: [768, 992, 1024]
                        });
                    });
                    

                    window.ce_waypoint_animation( $( element ).find( '.ce-portfolio-item' ), true );
                });
            });
        }

        if( parseInt( element.dataset.follow ) ){
            var body = document.body;
            var follow_fixed = document.createElement('DIV');
            follow_fixed.classList.add( 'ce-fixed-follow' );
            body.appendChild( follow_fixed ); 
            body.classList.add( 'ce-portfolio-follow-' + element.dataset.style );
            
            element.querySelectorAll('.ce-portfolio-item').forEach( function( el ){
                const thumbnail = el.querySelector('.post-thumbnail');
                thumbnail.addEventListener( 'mouseenter', function(e){
                    
                    document.querySelector( '.ce-fixed-follow' ).innerHTML = el.querySelector( '.entry-wrapper-content' ).innerHTML;
                    setTimeout(function(){
                        document.querySelector( '.ce-fixed-follow' ).classList.add('is-active');
                    }, 10);
                    
                } );
                thumbnail.addEventListener( 'mouseleave', function(){
                    document.querySelector( '.ce-fixed-follow' ).classList.remove('is-active');
                } )

                thumbnail.addEventListener( 'mousemove', function(e){
                    if( document.querySelector( '.ce-fixed-follow' ).classList.contains( 'is-active' ) ){
                        document.querySelector( '.ce-fixed-follow' ).style.left = e.clientX + 'px';
                        document.querySelector( '.ce-fixed-follow' ).style.top = e.clientY + 'px';
                    }
                } );
                    
                
            });

            
        }
    };

	$( window ).on( 'elementor/frontend/init', function () {

		elementorFrontend.hooks.addAction( 'frontend/element_ready/ce-portfolio-grid.default', WidgetPortfolioGrid );

	});

} )( jQuery );