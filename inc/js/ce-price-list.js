//Tabs Box
if(jQuery('.tabs-box').length){
    jQuery('.tabs-box .tab-buttons .tab-btn').on('click', function(e) {
        e.preventDefault();
        var target = jQuery(jQuery(this).attr('data-tab'));
        
        if (jQuery(target).is(':visible')){
            return false;
        }else{
            target.parents('.tabs-box').find('.tab-buttons').find('.tab-btn').removeClass('active-btn');
            jQuery(this).addClass('active-btn');
            target.parents('.tabs-box').find('.tabs-content').find('.tab').fadeOut(0);
            target.parents('.tabs-box').find('.tabs-content').find('.tab').removeClass('active-tab');
            jQuery(target).fadeIn(300);
            jQuery(target).addClass('active-tab');
        }
    });
    //Dropdown Button
		jQuery('.pricing-tabs .tab-buttons .yearly').on('click', function() {
			jQuery('.round').addClass('boll-right');
		});
		
		//Dropdown Button
		jQuery('.pricing-tabs .tab-buttons .monthly').on('click', function() {
			jQuery('.round').removeClass('boll-right');
        });
        jQuery('.pricing-tabs .tab-buttons .boll').on('click',function(){
            var currentclass = jQuery('.round').attr("class");
            if(currentclass == 'round'){
                jQuery('.monthly ').removeClass('active-btn');
                jQuery('.yearly').addClass('active-btn');
                jQuery('#prod-monthly').fadeOut(0);
                jQuery('#prod-monthly').removeClass('active-tab');
                jQuery('#prod-yearly').fadeIn(300);
                jQuery('#prod-yearly').addClass('active-tab');
            }else{
                jQuery('.yearly').removeClass('active-btn');
                jQuery('.monthly').addClass('active-btn');
                jQuery('#prod-yearly').fadeOut(0);
                jQuery('#prod-yearly').removeClass('active-tab');
                jQuery('#prod-monthly').fadeIn(300);
                jQuery('#prod-monthly').addClass('active-tab');
            }
            
            jQuery('.round').toggleClass('boll-right');
        })
}
