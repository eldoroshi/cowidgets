( function( $ ) {

	var WidgetVideoPlauButton = function( $scope, $ ) {
if( jQuery('.lightbox').length > 0 ){
	COWIDGETS_Global.loadDependencies( [ ce_global.lib_js + 'jquery.fancybox.min.js' ], function() {
jQuery('.video_play_button .lightbox').fancybox({
				openEffect  : 'none',
				closeEffect : 'none',
				helpers : {
					media : {}
				}
			});
	});
}
};

	$( window ).on( 'elementor/frontend/init', function () {

		elementorFrontend.hooks.addAction( 'frontend/element_ready/ce-portfolio-carousel.default', WidgetVideoPlauButton );

	});

} )( jQuery );