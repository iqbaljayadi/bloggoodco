var listfusion_history_last_checked = [];
var listfusion_placement_history_last_checked = [];
jQuery(document).ready(function(){ 
								
	jQuery('#display_listfusion_in_all').change(function(){ 
				if(jQuery(this).is(':checked')){
					listfusion_placement_history_last_checked = [];
					jQuery('.listfusion_showlist :checkbox:not(#display_listfusion_in_all):checked').each(function(){
						listfusion_placement_history_last_checked.push(jQuery(this));																									
						jQuery(this).attr('checked',false);
					});
				} else {
					if(listfusion_placement_history_last_checked.length > 0){
						jQuery.each(listfusion_placement_history_last_checked,function(){
							jQuery(this).attr('checked',true);
						});
					}
				}
	});

	jQuery('.listfusion_showlist :checkbox:not(#display_listfusion_in_all)').change(function(){
		if(jQuery(this).is(':checked')){
			jQuery('#display_listfusion_in_all').attr('checked',false);
		}
	});
	
	
});
