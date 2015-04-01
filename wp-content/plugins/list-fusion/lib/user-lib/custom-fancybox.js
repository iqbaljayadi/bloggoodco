window.jQuery(document).ready(function() {
		  
		jQuery('#listfusion-item-dont-show-again').click(function() {   
			if( listfusion_fanchybox.disableHideAlert == 1 ) { 
				listfusion_fancybox_set_cookie(listfusion_fanchybox.DontShowAgain_COOKIE_Name, '1', listfusion_fanchybox.DontShowAgain_block_days);
				jQuery.fancybox.close()
				return true;
			} else {												   
			var msg= "Are you sure you don't want popup to display again on your next visit ? Clicking OK will disable popup for "+listfusion_fanchybox.DontShowAgain_block_days+" days on your web browser ";
			var agree = confirm( msg );
			if ( agree == true ) { 
				listfusion_fancybox_set_cookie(listfusion_fanchybox.DontShowAgain_COOKIE_Name, '1', listfusion_fanchybox.DontShowAgain_block_days);
				jQuery.fancybox.close()
				return true;
			} else {
				return false;
			}	
			
			}
		});	
		
	// Set cookie
	function listfusion_fancybox_set_cookie(name,value,expires){
		var path = ''; var domain = ''; var secure = '';
		var today = new Date();
		today.setTime( today.getTime() );
		if ( expires ) { expires = expires * 1000 * 60 * 60 * 24; }
		var expires_date = new Date( today.getTime() + (expires) );
		document.cookie = name + "=" +escape( value ) +
		( ( expires ) ? ";expires=" + expires_date.toGMTString() : "" ) + 
		( ( path ) ? ";path=" + path : "" ) + 
		( ( domain ) ? ";domain=" + domain : "" ) +
		( ( secure ) ? ";secure" : "" );
	};
		
});