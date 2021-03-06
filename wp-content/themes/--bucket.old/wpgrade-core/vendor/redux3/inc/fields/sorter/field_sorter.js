/* global redux_change, redux_opts */
/*
 * Field Sorter jquery function
 * Based on
 * [SMOF - Slightly Modded Options Framework](http://aquagraphite.com/2011/09/slightly-modded-options-framework/)
 * Version 1.4.2
 */

jQuery(function() {
    /**	Sorter (Layout Manager) */
    jQuery('.sorter').each(function() {
        var id = jQuery(this).attr('id');
        jQuery('#' + id).find('ul').sortable({
            items: 'li',
            placeholder: "placeholder",
            connectWith: '.sortlist_' + id,
            opacity: 0.8,
			stop: function(event, ui) {
				var sorter = redux.sorter[jQuery(this).attr('data-id')];
				var id = jQuery(this).find('h3').text();
				if ( sorter && sorter[id].limits ) {
					if(jQuery(this).children('li').length >= sorter[id].limits) {
						jQuery(this).addClass('filled');
						if (jQuery(this).children('li').length > sorter[id].limits) {
							jQuery(ui.sender).sortable('cancel');	
						}
					} else {
						jQuery(this).removeClass('filled');
					}
				}
			},
            update: function(event, ui) {

				var sorter = redux.sorter[jQuery(this).attr('data-id')];
				var id = jQuery(this).find('h3').text();
				if ( sorter && sorter[id].limits ) {
					if(jQuery(this).children('li').length >= sorter[id].limits) {
						jQuery(this).addClass('filled');
						if (jQuery(this).children('li').length > sorter[id].limits) {
							jQuery(ui.sender).sortable('cancel');	
						}
					} else {
						jQuery(this).removeClass('filled');
					}
				}
                jQuery(this).find('.position').each(function() {
                    var listID = jQuery(this).parent().attr('id');
                    var parentID = jQuery(this).parent().parent().attr('data-group-id');
                    redux_change(jQuery(this));
                    var optionID = jQuery(this).parent().parent().parent().attr('id');
                    jQuery(this).prop("name", redux_opts.opt_name + '[' + optionID + '][' + parentID + '][' + listID + ']');
                });
            }
        });
    });

});