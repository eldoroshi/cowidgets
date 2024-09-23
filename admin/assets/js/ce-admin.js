jQuery(document).ready(function ($) {
	var ce_hide_shortcode_field = function() {
		var selected = jQuery('#ce_template_type').val() || 'none';
		jQuery( '.ce-options-table' ).removeClass().addClass( 'ce-options-table widefat ce-selected-template-type-' + selected );
	}

	jQuery(document).on( 'change', '#ce_template_type', function( e ) {
		ce_hide_shortcode_field();
	});

	ce_hide_shortcode_field();
});
