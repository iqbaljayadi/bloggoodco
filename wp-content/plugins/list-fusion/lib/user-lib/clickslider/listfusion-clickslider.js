(function($){
	var timer = false;
	
	$(document).ready(function(){
		$(document).find('body').prepend(listfusion_item_clickslider.slider);		
		
			// Top left Notification Slider
		    $('#top-left.scroller-wrap p a.top-left-link').click( function(e) {
				if($('.expand-wrap').hasClass("active")) {
					$('.expand-wrap').animate({
						left: "-100%",
						right: "100%"
					}, 800).removeClass("active");
					$('.top-left-icon.glyphicon-chevron-left').removeClass("top-left-icon glyphicon-chevron-left").addClass('top-left-icon glyphicon-chevron-right');
				} else {
					$('.expand-wrap' ).show();
					$('.expand-wrap').animate({
						left: "0px",
						right: "0px"
					}, 800).addClass("active").css("z-index", "99999999");
					$('.top-left-icon.glyphicon-chevron-right').removeClass("top-left-icon glyphicon-chevron-right").addClass('top-left-icon glyphicon-chevron-left');
				}	
			});	
			// Bottom left Notification Slider
			$('#bottom-left.scroller-wrap-left p a.btn-left-link').click( function(e) {
																				   
			 if($('.expand-wrap-left-btn').hasClass("active-left")) {
						$('.expand-wrap-left-btn').animate({
							left: "-105%",
							right: "105%"
						}, 800).removeClass("active-left");
						$('.bottom-left.glyphicon-chevron-left').removeClass("bottom-left glyphicon-chevron-left").addClass('bottom-left glyphicon-chevron-right');
					} else {
						$('.expand-wrap-left-btn' ).show();
						$('.expand-wrap-left-btn').animate({
							left: "0px",
							right: "0px"
						}, 800).addClass("active-left").css("z-index", "99999999");
						
						$('.bottom-left.glyphicon-chevron-right').removeClass("bottom-left glyphicon-chevron-right").addClass('bottom-left glyphicon-chevron-left');
					}	
			});	
			
			// check name and email
			$('#listfusion-submit-btn').click(function() {
				var emailReg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
				var emailaddressVal = $('#'+listfusion_item_clickslider.emailFldID).val();
				// csv records
				var displayEmail = $('#'+listfusion_item_clickslider.emailFldID).val();
				var displayFirstName = $('#'+listfusion_item_clickslider.firstNameFldID).val();
				var displayLastName = $('#'+listfusion_item_clickslider.lastNameFldID).val();
				var displayName = $('#'+listfusion_item_clickslider.nameFldID).val();
				var currentUserIP = listfusion_item_clickslider.userIP;
				var globalcsv = displayFirstName +','+ displayLastName  +','+ displayName  +','+ displayEmail +','+ currentUserIP;
				var itemID = listfusion_item_clickslider.displayItemID; 
				// Eof csv records
				if( !emailReg.test( emailaddressVal.replace(/^\s+|\s+$/g,"") ) ) {
					alert('- Valid Email Required.');
					$('#'+listfusion_item_clickslider.emailFldID).focus();
					return false;
				} else {
					if( listfusion_item_clickslider.afterSubs_SetCookieOrNot == 'true' ) { 
						listfusion_set_clkslider_cookie(listfusion_item_clickslider.DontShowMeAfterSub_COOKIE_Name,'1',listfusion_item_clickslider.after_subscribe_block_days);  // set cookie
					}
					if( listfusion_item_clickslider.addCSV != 2 ) {
						listfusion_set_clkslider_cookie(listfusion_item_clickslider.clickIDName,listfusion_item_clickslider.displayItemID,'1');
					}
					if( listfusion_item_clickslider.addCSV == 1 ) { 
						listfusion_set_clkslider_cookie('itemcsv-'+itemID,globalcsv,'1'); 
					}
					return true;	
				}
			});

			// count
			$('#listfusion_count_clickslider_adclick').click(function(){
				listfusion_clkslider_count_inc();
				if( listfusion_item_clickslider.afterSubs_SetCookieOrNot == 'true' ) { 
					listfusion_set_clkslider_cookie(listfusion_item_clickslider.DontShowMeAfterSub_COOKIE_Name,'1',listfusion_item_clickslider.after_subscribe_block_days);  // set cookie
				}
				return false;
			});

		
	});
	
	// Set cookie
	function listfusion_set_clkslider_cookie(name,value,expires){
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
	
	function listfusion_clkslider_count_inc(){
		 $.ajax({
				type: "post",
				url: listfusion_item_clickslider.global_admin_ajax,
				data: { action: 'listfusionAnalyticsCALL', 
						id: listfusion_item_clickslider.displayItemID,
						nonce: listfusion_item_clickslider.itemClickNonce
					  },
				success: function(data, textStatus, XMLHttpRequest){  
					//alert(data); //alert(1111);
				  },  
				error: function(MLHttpRequest, textStatus, errorThrown){  
					//alert(textStatus); //alert(222);  
				}  						
		}); //close jQuery.ajax
	}

})(jQuery);

function listfusion_clickslider_red(lnk,showin){ 
	window.open(lnk,showin);
}
