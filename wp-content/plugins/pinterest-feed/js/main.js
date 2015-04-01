jQuery(function() {
	var pfeed_container = jQuery('#pfeed');

	pfeed_container.imagesLoaded(function() {
		pfeed_container.masonry({
			itemSelector: '.pfeed-pin',
			gutterWidth: 15
		});	
	});

	//This combats Wordpress' autoformatting
	jQuery('.pfeed-description p').each(function() {
		if (jQuery(this).html().length === 0) {
			jQuery(this).remove();
		}
	});
	// jQuery('.pfeed-description p').contents().unwrap();
	// jQuery('.pfeed-description p').remove();
	// jQuery('.pfeed-dscription').contents().wrap('<p></p>');

});

