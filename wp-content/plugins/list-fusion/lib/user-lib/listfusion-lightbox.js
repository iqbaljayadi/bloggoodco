(function($){
	var timer = false;
	
	$(document).ready(function(){
		$(document).find('body').prepend(listfusion_item_popup.popupoutput);							   
					   
		// html
		if( listfusion_item_popup.htmlexitpopup == 1 ) {
			if( listfusion_item_popup.htmlexitbrowserviewpoint == 1 ) {
				var browser_view_point = false;
				jQuery(document).bind('mouseleave',function(e){
					if( browser_view_point == false ){
						timer = setTimeout(show_ad_plus_listbuilding_popup);
						browser_view_point = true;
					}	
				});
			} else if ( listfusion_item_popup.onpagescroll == 1 ) {
				windowheight = $( window ).height();
				var browser_display_on_page_scroll = false;		
				$(window).scroll(function(){ 
					var height = $(document).height()-$(window).height();
					var scrolltop = $(window).scrollTop();
					var p = parseInt( scrolltop/height*100 );
					if( p >= listfusion_item_popup.scrollpageheight &&  browser_display_on_page_scroll == false ){
						timer = setTimeout(show_ad_plus_listbuilding_popup);
						browser_display_on_page_scroll = true;
					}
			    })
			} else if ( listfusion_item_popup.userinactivity == 1 ) {
			 var inactivitytime = 0;
			 function display_timerIncrement() {
				inactivitytime++;
				if (inactivitytime > listfusion_item_popup.userinactivitydisplayafter) {
					window.clearTimeout(time_Interval);
					 timer = setTimeout(show_ad_plus_listbuilding_popup); 
				}
			 }
			 var time_Interval = setInterval(display_timerIncrement, 1000);
			 $(window).mousemove(function() { inactivitytime = 0; })
			 $(window).keypress(function() { inactivitytime = 0; })
			
			} else {
				$(window).on('beforeunload', function() {
					timer = setTimeout(show_ad_plus_listbuilding_popup);
					return ""+listfusion_item_popup.htmljsmsg+"";
				});
				$(function(){
					$('a, input, button').click(function(){ 
						exiturl = $(this).attr("href");								 
						if(exiturl == '#') return;
						$(window).off('beforeunload');
					});
				});
			}
		} 
		// eof html
		
		if( listfusion_item_popup.autohide_popup != 'blank' ) { 
			aplbp_autoClose(listfusion_item_popup.autohide_popup);
		}
		
		if( listfusion_item_popup.popupMethodDisplay == 1 ) {
			if( listfusion_item_popup.delay && listfusion_item_popup.delay > 0){ 
				timer = setTimeout(show_ad_plus_listbuilding_popup,( listfusion_item_popup.delay*1000 ));
			} else {
				show_ad_plus_listbuilding_popup();
			}
		}
		// center
		init_aplbp_center();
		// close
		$('#listfusion_item_close_btm').click(function(){
			close_box();
			return false;
		});
		// check name and email
		$('#listfusion-submit-btn').click(function() {
			var emailReg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
			var emailaddressVal = $('#'+listfusion_item_popup.emailFldID).val();
			// csv records
			var displayEmail = $('#'+listfusion_item_popup.emailFldID).val();
			var displayFirstName = $('#'+listfusion_item_popup.firstNameFldID).val();
			var displayLastName = $('#'+listfusion_item_popup.lastNameFldID).val();
			var displayName = $('#'+listfusion_item_popup.nameFldID).val();
			var currentUserIP = listfusion_item_popup.userIP;
			var globalcsv = displayFirstName +','+ displayLastName  +','+ displayName  +','+ displayEmail +','+ currentUserIP;
			var itemID = listfusion_item_popup.displayItemID; 
			// Eof csv records
			if( !emailReg.test( emailaddressVal.replace(/^\s+|\s+$/g,"") ) ) {
				alert('- Valid Email Required.');
				$('#'+listfusion_item_popup.emailFldID).focus();
				return false;
			} else {
				if( listfusion_item_popup.afterSubs_SetCookieOrNot == 'true' ) { 
					listfusion_set_cookie(listfusion_item_popup.DontShowMeAfterSub_COOKIE_Name,'1',listfusion_item_popup.after_subscribe_block_days);  // set cookie
				}
				if( listfusion_item_popup.addCSV != 2 ) {
					listfusion_set_cookie(listfusion_item_popup.clickIDName,listfusion_item_popup.displayItemID,'1');
				}
				if( listfusion_item_popup.addCSV == 1 ) { 
					listfusion_set_cookie('itemcsv-'+itemID,globalcsv,'1'); 
				}
				return true;	
			}
		});
		// ad pop
		$('#listfusion_count_adclick').click(function(){ 
			listfusion_count_inc();
			if( listfusion_item_popup.afterSubs_SetCookieOrNot == 'true' ) { 
				listfusion_set_cookie(listfusion_item_popup.DontShowMeAfterSub_COOKIE_Name,'1',listfusion_item_popup.after_subscribe_block_days);  // set cookie
			}
			return false;
		});
		// click Close Btm
		$('#listfusion_item_close_btm').click(function() {  
			if( listfusion_item_popup.close_btm_days != 'null' ) {
				listfusion_set_cookie(listfusion_item_popup.close_btm_cookie_Name, '1', listfusion_item_popup.close_btm_days);
				close_box();
				return true;
			} 
		});
		// Dont show me again
		$('#listfusion-item-dont-show-again').click(function() {  
			if( listfusion_item_popup.disableHideAlert == 1 ) {
				listfusion_set_cookie(listfusion_item_popup.DontShowAgain_COOKIE_Name, '1', listfusion_item_popup.DontShowAgain_block_days);
				close_box();
				return true;
			} else {									  
				var msg= "Are you sure you don't want popup to display again on your next visit ? Clicking OK will disable popup for "+listfusion_item_popup.DontShowAgain_block_days+" days on your web browser ";
				var agree = confirm( msg );
				if ( agree == true ) { 
					listfusion_set_cookie(listfusion_item_popup.DontShowAgain_COOKIE_Name, '1', listfusion_item_popup.DontShowAgain_block_days);
					close_box();
					return true;
				} else {
					return false;
				}
			}
		});
	});
	// Set cookie
	function listfusion_set_cookie(name,value,expires){
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
	// clk
	function listfusion_count_inc(){ 
		 $.ajax({
				type: "post",
				url: listfusion_item_popup.global_admin_ajax,
				data: { action: 'listfusionAnalyticsCALL', 
						id: listfusion_item_popup.displayItemID,
						nonce: listfusion_item_popup.itemClickNonce
					  },
				success: function(data, textStatus, XMLHttpRequest){  
					//alert(data); //alert(1111);
				  },  
				error: function(MLHttpRequest, textStatus, errorThrown){  
					//alert(textStatus); //alert(222);  
				}  						
		}); //close jQuery.ajax
	}
	// Center your popup box
	function init_aplbp_center(){
		center_it();
		$(window).resize(center_it);
	};
	// Display lightbox on center
	function center_it(){
		var styles = {
			position:'absolute',
			left: ($(window).width() - $('.listfusion-lightbox-start .listfusion-lightbox-main-div').outerWidth())/2,
			top: ($(window).height() - $('.listfusion-lightbox-start .listfusion-lightbox-main-div').outerHeight())/2
		};
		styles.left = styles.left < 0 ? 0 : styles.left;
		styles.top = styles.top < 0 ? 0 : styles.top;
		$('.listfusion-lightbox-start .listfusion-lightbox-main-div').css(styles);
	};
	// Show Light Box
	function show_ad_plus_listbuilding_popup(){ 
		$(document).unbind('focus',show_ad_plus_listbuilding_popup);
		aplbpop_zindex_max();
		$('#listfusion_popup_lightbox_main').fadeIn('fast');
		center_it();
	};
	// z-index CSS Mode
	function aplbpop_zindex_max(){
		var maxz = 99999999999;
		$('body *').each(function(){
			var cur = parseInt($(this).css('z-index'));
			maxz = cur > maxz ? cur : maxz;
		});
		$('#listfusion_popup_lightbox_main').css('z-index',maxz+10);
	};
	// autoclose after X time
	function aplbp_autoClose(WaitSeconds) { 
            setTimeout(
                function () { 
                    $('#listfusion_popup_lightbox_main').fadeOut('slow');
                }, WaitSeconds);
	};
	// elbpro Close
	function close_box(){ 
		$('#listfusion_popup_lightbox_main').fadeOut(1000);
	};

})(jQuery);

function listfusion_red(lnk,showin){ 
	window.open(lnk,showin);
}
