(function($){
	var timer = false;
	
	$(document).ready(function(){ 
		// check name and email
		$('#listfusion-submit-btn').click(function() {
			var emailReg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
			var emailaddressVal = $('#'+listfusion_item_squeezepg.emailFldID).val();
			// csv records
			var displayEmail = $('#'+listfusion_item_squeezepg.emailFldID).val();
			var displayFirstName = $('#'+listfusion_item_squeezepg.firstNameFldID).val();
			var displayLastName = $('#'+listfusion_item_squeezepg.lastNameFldID).val();
			var displayName = $('#'+listfusion_item_squeezepg.nameFldID).val();
			var currentUserIP = listfusion_item_squeezepg.userIP;
			var globalcsv = displayFirstName +','+ displayLastName  +','+ displayName  +','+ displayEmail +','+ currentUserIP;
			var itemID = listfusion_item_squeezepg.displayItemID; 
			// Eof csv records
			if( !emailReg.test( emailaddressVal.replace(/^\s+|\s+$/g,"") ) ) {
				alert('- Valid Email Required.');
				$('#'+listfusion_item_squeezepg.emailFldID).focus();
				return false;
			} else {
				if( listfusion_item_squeezepg.addCSV != 2 ) {
					listfusion_set_sqpg_cookie(listfusion_item_squeezepg.clickIDName,listfusion_item_squeezepg.displayItemID,'1');
				}
				if( listfusion_item_squeezepg.addCSV == 1 ) { 
					listfusion_set_sqpg_cookie('itemcsv-'+itemID,globalcsv,'1'); 
				}
				return true;	
			}
		});
	});
	// Set cookie
	function listfusion_set_sqpg_cookie(name,value,expires){
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

})(jQuery);
