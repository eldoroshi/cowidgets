( function( $ ) {

	/**
	 * Kiri Slider
	 *
	 */
	var WidgetPodcastsGrid = function( $scope, $ ) {
        const element = $scope[0].querySelector( '.ce-podcasts-grid' );
        imagesLoaded( element, function(){
          var iso = new Isotope( element, {
            // options...
            itemSelector: '.ce-post-item',
            percentPosition: true,
            layout: element.dataset.layout,
            masonry: {
              columnWidth: '.ce-post-item'
            }
          });

          window.ce_waypoint_animation( $( element ).find( '.ce-post-item' ), true );
        });
    };

	$( window ).on( 'elementor/frontend/init', function () {

		elementorFrontend.hooks.addAction( 'frontend/element_ready/ce-podcasts-grid.default', WidgetPodcastsGrid );

	});

} )( jQuery );