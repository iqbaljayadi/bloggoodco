function listfusion_sidebar_red(lnk,showin,functionName){ 
	listfusion_clickUnque(functionName);
	window.open(lnk,showin);
}
function listfusion_checkForValidEmail(functionName) { 
	listfusion_item_sidebar = window[functionName];
	var emailReg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
	var emailaddressVal = document.getElementById(listfusion_item_sidebar.emailFldID).value;
	var itemID = listfusion_item_sidebar.displayItemID; 
	// Eof csv records
	if( !emailReg.test( emailaddressVal.replace(/^\s+|\s+$/g,"") ) ) {
		alert('- Valid Email Required.');
		document.getElementById(listfusion_item_sidebar.emailFldID).focus();
		return false;
	} else {
		if( listfusion_item_sidebar.afterSubs_SetCookieOrNot == 'true' ) { 
			listfusion_set_global_cookie(listfusion_item_sidebar.DontShowMeAfterSub_COOKIE_Name,'1',listfusion_item_sidebar.after_subscribe_block_days);  // set cookie
		}
		if( listfusion_item_sidebar.addCSV != 2 ) {
			listfusion_set_global_cookie(listfusion_item_sidebar.clickIDName,listfusion_item_sidebar.displayItemID,'1');
		}
		if( listfusion_item_sidebar.addCSV == 1 ) { 
			// csv records
			var displayEmail = document.getElementById(listfusion_item_sidebar.emailFldID).value;
			var displayFirstName = ''; /*document.getElementById(listfusion_item_sidebar.firstNameFldID).value;*/
			var displayLastName = ''; /*document.getElementById(listfusion_item_sidebar.lastNameFldID).value;*/
			var displayName = ''; /*document.getElementById(listfusion_item_sidebar.nameFldID).value;*/
			var currentUserIP = listfusion_item_sidebar.userIP;
			var globalcsv = displayFirstName +','+ displayLastName  +','+ displayName  +','+ displayEmail +','+ currentUserIP;
			listfusion_set_global_cookie('itemcsv-'+itemID,globalcsv,'1'); 
		}
		return true;	
	}
			
}
function listfusion_clickUnque(functionName) { 
	listfusion_clickUnque_count_inc(functionName);
	return false;
}
function listfusion_clickUnque_count_inc(functionName){
	listfusion_item_sidebar = window[functionName];
	jQuery(document).ready(function(){ 
				 jQuery.ajax({
						type: "POST",
						url: listfusion_item_sidebar.global_admin_ajax,
						data: { action: 'listfusionAnalyticsCALL', 
						id: listfusion_item_sidebar.displayItemID,
						nonce: listfusion_item_sidebar.itemClickNonce
					  },
						success: function(data, textStatus, XMLHttpRequest){  
							//alert(data); //alert(1111);
						  },  
						error: function(MLHttpRequest, textStatus, errorThrown){  
							//alert(textStatus); //alert(222);  
						}
					}); //close jQuery.ajax
					//return false;								   
		})	 
}
// Set cookie
function listfusion_set_global_cookie(name,value,expires){
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
}