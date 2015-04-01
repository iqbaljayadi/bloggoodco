function __JS_listfustion_ShowHide(curr, img, img_type, lib_path) {
	var curr = document.getElementById(curr);
	if ( img != '' ) {
		var img  = document.getElementById(img);
	}
	var elbproShowRow = 'block'
	if ( navigator.appName.indexOf('Microsoft') == -1 && curr.tagName == 'TR' ) elbproShowRow = 'table-row';
	if ( curr.style == '' || curr.style.display == 'none' ) {
		curr.style.display = elbproShowRow;
		if ( img != '' && img_type == 1 ) img.src = lib_path + 'images/minus.gif';
		if ( img != '' && img_type == 2 ) img.src = lib_path + 'images/minus-small.gif';
		if ( img != '' && img_type == 3 ) img.src = lib_path + 'images/close-form.gif';
	} else if ( curr.style != '' || curr.style.display == 'block' || curr.style.display == 'table-row' ) {
		curr.style.display = 'none';
		if ( img != '' && img_type == 1 ) img.src = lib_path + 'images/plus.gif';
		if ( img != '' && img_type == 2 ) img.src = lib_path + 'images/plus-small.gif';
		if ( img != '' && img_type == 3 ) img.src = lib_path + 'images/open-form.gif';
	}
}
function __JS_listfustion_ImgSwitchType(curr,type1) { 
	var csv_backup_type_1  = document.getElementById(type1);
	var chk_clk_btm_val = document.getElementById('chk_if_click_process_html_form_btm').value;
	var split_name_chk = document.getElementById('listfusion_split_name').checked; 
	var display_only_email = document.getElementById('listfusion_disply_only_email').checked; 
	if ( curr == 1 ) {
		csv_backup_type_1.style.display = 'none';
		document.getElementById('send_optin_to_email').style.display = 'none';
		document.getElementById('connection_type_txt1').style.fontWeight ='bold';
		document.getElementById('connection_type_txt2').style.fontWeight ='normal';
		document.getElementById('connection_type_txt3').style.fontWeight ='normal';
		document.getElementById('connection_type_txt4').style.fontWeight ='normal';
		document.getElementById('display_html_form_code').style.display = 'block';
		document.getElementById('extra_field_showup').style.display = 'block';
		document.getElementById('field_placeholder').style.display = 'block';
		document.getElementById('api_connection_css').style.display = 'block';
		
		if( chk_clk_btm_val == 1 ) {
			document.getElementById('submit_arp_form').style.display = 'block';
			document.getElementById('field_placeholder').style.display = 'block';
			document.getElementById('extra_field_showup').style.display = 'block';
		} else { 
			document.getElementById('submit_arp_form').style.display = 'none';
			document.getElementById('field_placeholder').style.display = 'none';
			document.getElementById('extra_field_showup').style.display = 'none';
		}
		
		document.getElementById('store_data_on_csv_standalone').style.display = 'none';
		if( split_name_chk == true ) {  
			document.getElementById('split_first_name').style.display = '';
			document.getElementById('split_last_name').style.display = '';
			document.getElementById('name_fld_level').style.display = 'none';
		}
		if( display_only_email == true ) {  
			document.getElementById('split_first_name').style.display = 'none';
			document.getElementById('split_last_name').style.display = 'none';
			document.getElementById('name_fld_level').style.display = 'none';
		}
	} else if ( curr == 2 ) {  
		csv_backup_type_1.style.display = 'block';
		document.getElementById('send_optin_to_email').style.display = 'none';
		document.getElementById('connection_type_txt2').style.fontWeight ='bold';
		document.getElementById('connection_type_txt1').style.fontWeight ='normal';
		document.getElementById('connection_type_txt3').style.fontWeight ='normal';
		document.getElementById('connection_type_txt4').style.fontWeight ='normal';
		document.getElementById('display_html_form_code').style.display = 'block';
		document.getElementById('extra_field_showup').style.display = 'block';
		document.getElementById('api_connection_css').style.display = 'block';
		if( chk_clk_btm_val == 1 ) {
			document.getElementById('submit_arp_form').style.display = 'block';
			document.getElementById('field_placeholder').style.display = 'block';
			document.getElementById('extra_field_showup').style.display = 'block';
		} else {
			document.getElementById('submit_arp_form').style.display = 'none';
			document.getElementById('field_placeholder').style.display = 'none';
			document.getElementById('extra_field_showup').style.display = 'none';
		}
		document.getElementById('store_data_on_csv_standalone').style.display = 'none';
		if( split_name_chk == true ) {  
			document.getElementById('split_first_name').style.display = '';
			document.getElementById('split_last_name').style.display = '';
			document.getElementById('name_fld_level').style.display = 'none';
		}
		if( display_only_email == true ) {  
			document.getElementById('split_first_name').style.display = 'none';
			document.getElementById('split_last_name').style.display = 'none';
			document.getElementById('name_fld_level').style.display = 'none';
		}
	}  else if ( curr == 3 ) { 
		csv_backup_type_1.style.display = 'block';
		document.getElementById('send_optin_to_email').style.display = 'none';
		document.getElementById('connection_type_txt3').style.fontWeight ='bold';
		document.getElementById('connection_type_txt1').style.fontWeight ='normal';
		document.getElementById('connection_type_txt2').style.fontWeight ='normal';
		document.getElementById('connection_type_txt4').style.fontWeight ='normal';
		document.getElementById('display_html_form_code').style.display = 'none';
		document.getElementById('submit_arp_form').style.display = 'block';
		document.getElementById('field_placeholder').style.display = 'block';
		document.getElementById('extra_field_showup').style.display = 'none';
		if( split_name_chk == true ) {  
			document.getElementById('split_first_name').style.display = 'none';
			document.getElementById('split_last_name').style.display = 'none';
			document.getElementById('name_fld_level').style.display = '';
		}
		if( display_only_email == true ) {
			document.getElementById('name_fld_level').style.display = '';
		}
	} else if ( curr == 4 ) { 
		csv_backup_type_1.style.display = 'block';
		document.getElementById('send_optin_to_email').style.display = 'block';
		document.getElementById('store_data_on_csv_standalone').style.display = 'none';
		document.getElementById('connection_type_txt4').style.fontWeight ='bold';
		document.getElementById('connection_type_txt3').style.fontWeight ='normal';
		document.getElementById('connection_type_txt1').style.fontWeight ='normal';
		document.getElementById('connection_type_txt2').style.fontWeight ='normal';
		document.getElementById('display_html_form_code').style.display = 'none';
		document.getElementById('submit_arp_form').style.display = 'block';
		document.getElementById('field_placeholder').style.display = 'block';
		document.getElementById('extra_field_showup').style.display = 'none';
		if( split_name_chk == true ) {  
			document.getElementById('split_first_name').style.display = 'none';
			document.getElementById('split_last_name').style.display = 'none';
			document.getElementById('name_fld_level').style.display = '';
		}
		if( display_only_email == true ) {
			document.getElementById('name_fld_level').style.display = '';
		}
	}
}
function __listfustion_SelectTab(currtab) { 
	for ( i=1; i<=11; i++ ) {
		if ( i == currtab ) {
			document.getElementById('listfustiontab-'+i).style.display = 'block';
			document.getElementById('listfustiontabhead-'+i).style.position = 'relative';
			document.getElementById('listfustiontabhead-'+i).style.top = '1px';
			document.getElementById('listfustiontabhead-'+i).style.background = "#F1F1F1";
			document.getElementById('listfustiontabhead-'+i).style.color = "#464646"; //D1700E";
		} else {
			document.getElementById('listfustiontab-'+i).style.display = 'none';
			document.getElementById('listfustiontabhead-'+i).style.position = 'relative';
			document.getElementById('listfustiontabhead-'+i).style.top = '1px';
			document.getElementById('listfustiontabhead-'+i).style.background = "#E4E4E4";
			document.getElementById('listfustiontabhead-'+i).style.color = "#464646";
		}
	}
}
function __listfustion_chkname(){
	var arp_name = document.getElementById('arp_connection_name').value; 
	if ( arp_name == '' ) {
		alert('Connection Name Required'); 
		document.getElementById('arp_connection_name').style.backgroundColor = '#FDECE9';
		document.getElementById('arp_connection_name').focus();
		return false;
	}
}
function __listfustion_api_call() { 
	var value = document.getElementById('listfusion_select_api_connections').value; 
    if( value == 1) {
        document.getElementById('mailchimp_api_input_form').style.display = 'block';
        document.getElementById('getResponse_api_input_form').style.display = 'none';
    } else if( value == 2) { 
        document.getElementById('getResponse_api_input_form').style.display = 'block';
        document.getElementById('mailchimp_api_input_form').style.display = 'none';
	} else {
        document.getElementById('mailchimp_api_input_form').style.display = 'none';
        document.getElementById('getResponse_api_input_form').style.display = 'none';
    }
}

jQuery(document).ready(function(){
	jQuery('#displayCustomFldClone').click(function(){
		__JS_listfustion_cloneIT();
	});
	function __JS_listfustion_cloneIT(){
		var customFlds = jQuery('#applyCustomFldClone').find('div').clone();
		customFlds.find('#customFldCloneDelete').click(function(){
			customFldCreateDel(jQuery(this).closest('div'));
		});
		jQuery('#new_withinpostcustomfld').prepend(customFlds);
	}
	function customFldCreateDel(del){ 
		del.remove();
	}
	
	// Dashboard
	jQuery('#listfusion_menu_dropdown').click(function() {  
		var type = jQuery(this).data('filter');

		if (jQuery(this).hasClass('active')) {  
			jQuery(this).removeClass('active');
			jQuery('#showHideConnections').hide(500);
			jQuery("#minusmenu_dropdown").hide();
			jQuery("#plusmenu_dropdown").show();

		} else {
			jQuery('#listfusion_menu_dropdown').removeClass('active');
			jQuery(this).addClass('active');
			jQuery("#showHideConnections").show(500);
			jQuery("#minusmenu_dropdown").show();
			jQuery("#plusmenu_dropdown").hide();
		}
	});
	
	// Dashboard : FILTER
	jQuery('#listfusion_filter_dropdown').click(function() {  
		var type = jQuery(this).data('filter');

		if (jQuery(this).hasClass('active')) {  
			jQuery(this).removeClass('active');
			jQuery('#listfusion_showhide_filter_rec').hide(500);
			jQuery("#rec_minusmenu_dropdown").hide();
			jQuery("#rec_plusmenu_dropdown").show();

		} else {
			jQuery('#listfusion_filter_dropdown').removeClass('active');
			jQuery(this).addClass('active');
			jQuery("#listfusion_showhide_filter_rec").show(500);
			jQuery("#rec_minusmenu_dropdown").show();
			jQuery("#rec_plusmenu_dropdown").hide();
		}
	});

});

function __listfusion_removeCreateFld(divNum, DisplaycustomFld) {
  var d = document.getElementById(DisplaycustomFld);
  var olddiv = document.getElementById(divNum);
  d.removeChild(olddiv);
}

jQuery(document).ready(function(){
	jQuery("#listfustion_msg").show("slow");	
	jQuery("#listfustion_msg").fadeOut(6000); //animation	
});	

function __listfusion_restore(){ 
document.getElementById('se_tmp1').style.border = 'none';
document.getElementById('se_tmp2').style.border = 'none';
document.getElementById('se_tmp3').style.border = 'none';
document.getElementById('listfusion_send_email_message').value = 'Hi %commentator_name%,\n\nThank you for visiting my blog (%blog_url%) and posting your comment.\n\nIf you love my content, I highly recommend you subscribe to our newsletter for latest content straight to your mailbox.\n\nVisit the following link to subscribe:\n{{your newsletter page link goes here...}}\n\nPlease let me know if you have any questions.\n\nTake care!\n\n\n%author_name%\n%blog_url%';	
}

function __listfusion_sendEmailText(grabtext, displaytext) {  
	document.getElementById(displaytext).value = '';
	grabHTML = document.getElementById(grabtext).value;
	document.getElementById(displaytext).value = grabHTML;
}

function isHTML(str) {
    var a = document.createElement('div');
    a.innerHTML = str;
    for (var c = a.childNodes, i = c.length; i--; ) {
        if (c[i].nodeType == 1) return true; 
    }
    return false;
}

function __listfusion_preview_sendEmail(){
	var edit_form = document.getElementById('listfusion_send_email_message').value;
	check = isHTML(edit_form);
	if( check == false ) { 
		a = "<pre>"+edit_form+"</pre>"; 
	} else {
		a = edit_form;
	}
	foowin = window.open('','1398581917383','location=no,status=no,scrollbars=yes,width=790,height=660');
	foowin.document.write(a);
	foowin.document.close()
}

function __listfusion_active_selected(id,hide1,hide2){  
	edit_form = document.getElementById(id).style.border = '1px solid red';
	edit_form = document.getElementById(hide1).style.border = 'none';
	edit_form = document.getElementById(hide2).style.border = 'none';
}

function __listfusion_JS_chckexitpopup(rd_url,option_name) { 
	var url = document.getElementById(rd_url).value;
	var name = document.getElementById(option_name).value;
	if (  url == '' ) {
			alert('Empty Redirect URL');
			document.getElementById(rd_url).style.background = '#FDECE9';
			document.getElementById(rd_url).focus();
			return false;
	}
	if (  name == '' ) {
			alert('Record Name Empty');
			document.getElementById(option_name).style.background = '#FDECE9';
			document.getElementById(option_name).focus();
			return false;
	}
}
function __listfusion_catpage_openit(openid, closeid){
	var curr = document.getElementById(openid);
	var curr2 = document.getElementById(closeid);
	if ( curr.style.display == 'none' ) {
		curr.style.display = 'block';
	} else if ( curr.style.display == 'block' ) {
		curr.style.display = 'none';
	}
	curr2.style.display = 'none';
}
function __listfusion_catpage_closeit(openid, closeid){
	var curr = document.getElementById(openid);
	var curr2 = document.getElementById(closeid);
	if ( curr.style.display == 'block' ) {
		curr.style.display = 'none';
	}
	curr2.style.display = 'block';
}
function __listfusionSelectTab(currtab,type) { 

	if( type == 'withinpostoptin' ){
		document.getElementById('listFusionType').value = 'withinpostoptin';
		document.getElementById('autoresponderConnection').style.display = 'block';
		document.getElementById('withinpost_displayAds').style.display = 'none';
		document.getElementById('witinpost_socialShare').style.display = 'none';
		// ajax - call
		listfusion_ajax_url = document.getElementById('listfusion_ajax_url').value;
		listfusion_theme_preview_type = document.getElementById('theme_preview_type').value;
		listfusion_demo_graber('imgpreview', listfusion_theme_preview_type, listfusion_ajax_url, 'listFusionType');
		
	} else if( type == 'withinpostad' ){
		document.getElementById('listFusionType').value = 'withinpostad';
		document.getElementById('autoresponderConnection').style.display = 'none';
		document.getElementById('withinpost_displayAds').style.display = 'block';
		document.getElementById('witinpost_socialShare').style.display = 'none';
		// ajax - call
		listfusion_ajax_url = document.getElementById('listfusion_ajax_url').value;
		listfusion_theme_preview_type = document.getElementById('theme_preview_type').value;
		listfusion_demo_graber('imgpreview', listfusion_theme_preview_type, listfusion_ajax_url, 'listFusionType');
		
	} else if( type == 'withinpostsocial' ){
		document.getElementById('listFusionType').value = 'withinpostsocial';
		document.getElementById('autoresponderConnection').style.display = 'none';
		document.getElementById('withinpost_displayAds').style.display = 'none';
		document.getElementById('witinpost_socialShare').style.display = 'block';
		// ajax - call
		listfusion_ajax_url = document.getElementById('listfusion_ajax_url').value;
		listfusion_theme_preview_type = document.getElementById('theme_preview_type').value;
		listfusion_demo_graber('imgpreview', listfusion_theme_preview_type, listfusion_ajax_url, 'listFusionType');
		
	} else if( type == 'sidebaroptin' || type == 'icboxoptin' ){
		if( type == 'icboxoptin' ) document.getElementById('listFusionType').value = 'icboxoptin';
		else document.getElementById('listFusionType').value = 'sidebaroptin';
		document.getElementById('slider_displayAds').style.display = 'none';
		document.getElementById('slider_autoresponderConnection').style.display = 'block';
		// ajax - call
		listfusion_ajax_url = document.getElementById('listfusion_ajax_url').value;
		listfusion_theme_preview_type = document.getElementById('theme_preview_type').value;
		listfusion_demo_graber('imgpreview', listfusion_theme_preview_type, listfusion_ajax_url, 'listFusionType');
	
	} else if( type == 'sidebarad' || type == 'icboxad' ){
		if( type == 'icboxad' ) document.getElementById('listFusionType').value = 'icboxad';
		else document.getElementById('listFusionType').value = 'sidebarad';
		document.getElementById('slider_displayAds').style.display = 'block';
		document.getElementById('slider_autoresponderConnection').style.display = 'none';
		// ajax - call
		listfusion_ajax_url = document.getElementById('listfusion_ajax_url').value;
		listfusion_theme_preview_type = document.getElementById('theme_preview_type').value;
		listfusion_demo_graber('imgpreview', listfusion_theme_preview_type, listfusion_ajax_url, 'listFusionType');
	
	} else if( type == 'clickslideroptin' ){
		document.getElementById('listFusionType').value = 'clickslideroptin';
		document.getElementById('slider_displayAds').style.display = 'none';
		document.getElementById('slider_autoresponderConnection').style.display = 'block';
		// ajax - call
		listfusion_ajax_url = document.getElementById('listfusion_ajax_url').value;
		listfusion_theme_preview_type = document.getElementById('theme_preview_type').value;
		listfusion_demo_graber('imgpreview', listfusion_theme_preview_type, listfusion_ajax_url, 'listFusionType');
	
	} else if( type == 'clicksliderad' ){
		document.getElementById('listFusionType').value = 'clicksliderad';
		document.getElementById('slider_displayAds').style.display = 'block';
		document.getElementById('slider_autoresponderConnection').style.display = 'none';
		// ajax - call
		listfusion_ajax_url = document.getElementById('listfusion_ajax_url').value;
		listfusion_theme_preview_type = document.getElementById('theme_preview_type').value;
		listfusion_demo_graber('imgpreview', listfusion_theme_preview_type, listfusion_ajax_url, 'listFusionType');
	
	} else if( type == 'squeezepg' ){
		// ajax - call
		listfusion_ajax_url = document.getElementById('listfusion_ajax_url').value;
		listfusion_theme_preview_type = document.getElementById('theme_preview_type').value;
		listfusion_demo_graber('imgpreview', listfusion_theme_preview_type, listfusion_ajax_url, 'listFusionType');
		
	} else if( type == 'adpopup' ){
		document.getElementById('autoresponderConnection').style.display = 'none';
		document.getElementById('popup_socialShare').style.display = 'none';
		document.getElementById('popup_displayAds').style.display = 'block';
		document.getElementById('blockaftersubsORclickad').style.display = 'block';
		document.getElementById('contentfillup').style.display = 'block';
		document.getElementById('lookNfeel_normal').style.display = 'block';
		document.getElementById('designsubmitbtm').style.display = 'block';
		document.getElementById('lookNfeel_custom').style.display = 'none';
		document.getElementById('listFusionType').value = 'adpopup';
		document.getElementById('onclickactionrow').style.display = 'none';
		document.getElementById('item_cookie_settings').style.display = 'block';
		document.getElementById('autoClose_closebtm').style.display = 'block';
		document.getElementById('item_htmlexitpopup').style.display = 'block';
		document.getElementById('item_customCSS').style.display = 'block';
		
		// check onclick
		onclick_value = document.getElementById('onclickaction').checked;
		if( onclick_value == true ) {
			document.getElementById('whereToShow').style.display = 'block';
			document.getElementById('schedule_delay_autoclose').style.display = 'block';
			document.getElementById('visitors_control_settings').style.display = 'block';
		}
		
		// ajax - call
		listfusion_ajax_url = document.getElementById('listfusion_ajax_url').value;
		listfusion_theme_preview_type = document.getElementById('theme_preview_type').value;
		listfusion_demo_graber('imgpreview', listfusion_theme_preview_type, listfusion_ajax_url, 'listFusionType');

	} else if( type == 'optinpopup' ){
		document.getElementById('autoresponderConnection').style.display = 'block';
		document.getElementById('blockaftersubsORclickad').style.display = 'block';
		document.getElementById('contentfillup').style.display = 'block';
		document.getElementById('designsubmitbtm').style.display = 'block';
		document.getElementById('lookNfeel_normal').style.display = 'block';
		document.getElementById('popup_socialShare').style.display = 'none';
		document.getElementById('popup_displayAds').style.display = 'none';
		document.getElementById('lookNfeel_custom').style.display = 'none';
		document.getElementById('listFusionType').value = 'optinpopup';
		document.getElementById('onclickactionrow').style.display = 'none';
		document.getElementById('item_cookie_settings').style.display = 'block';
		document.getElementById('autoClose_closebtm').style.display = 'block';
		document.getElementById('item_htmlexitpopup').style.display = 'block';
		document.getElementById('item_customCSS').style.display = 'block';
		
		// check onclick
		onclick_value = document.getElementById('onclickaction').checked;
		if( onclick_value == true ) {
			document.getElementById('whereToShow').style.display = 'block';
			document.getElementById('schedule_delay_autoclose').style.display = 'block';
			document.getElementById('visitors_control_settings').style.display = 'block';
		}

		// ajax - call
		listfusion_ajax_url = document.getElementById('listfusion_ajax_url').value;
		listfusion_theme_preview_type = document.getElementById('theme_preview_type').value;
		listfusion_demo_graber('imgpreview', listfusion_theme_preview_type, listfusion_ajax_url, 'listFusionType');
		
	} else if( type == 'socialpopup' ){
		document.getElementById('autoresponderConnection').style.display = 'none';
		document.getElementById('popup_socialShare').style.display = 'block';
		document.getElementById('contentfillup').style.display = 'block';
		document.getElementById('lookNfeel_normal').style.display = 'block';
		document.getElementById('designsubmitbtm').style.display = 'none';
		document.getElementById('popup_displayAds').style.display = 'none';
		document.getElementById('blockaftersubsORclickad').style.display = 'none';
		document.getElementById('lookNfeel_custom').style.display = 'none';
		document.getElementById('listFusionType').value = 'socialpopup';
		document.getElementById('onclickactionrow').style.display = 'none';
		document.getElementById('item_cookie_settings').style.display = 'block';
		document.getElementById('autoClose_closebtm').style.display = 'block';
		document.getElementById('item_htmlexitpopup').style.display = 'block';
		document.getElementById('item_customCSS').style.display = 'block';
		
		// check onclick
		onclick_value = document.getElementById('onclickaction').checked;
		if( onclick_value == true ) {
			document.getElementById('whereToShow').style.display = 'block';
			document.getElementById('schedule_delay_autoclose').style.display = 'block';
			document.getElementById('visitors_control_settings').style.display = 'block';
		}
		
		// ajax - call
		listfusion_ajax_url = document.getElementById('listfusion_ajax_url').value;
		listfusion_theme_preview_type = document.getElementById('theme_preview_type').value;
		listfusion_demo_graber('imgpreview', listfusion_theme_preview_type, listfusion_ajax_url, 'listFusionType');
		
	} else if( type == 'custompopup' ){
		document.getElementById('contentfillup').style.display = 'none';
		document.getElementById('listfusion_popup_content').style.display = 'none';
		document.getElementById('popup_displayAds').style.display = 'none';
		document.getElementById('blockaftersubsORclickad').style.display = 'none';
		document.getElementById('popup_socialShare').style.display = 'none';
		document.getElementById('designsubmitbtm').style.display = 'none';
		document.getElementById('listfusion_popup_btm_design').style.display = 'none';
		document.getElementById('autoresponderConnection').style.display = 'none';
		document.getElementById('lookNfeel_normal').style.display = 'none';
		document.getElementById('lookNfeel_custom').style.display = 'block';
		document.getElementById('listFusionType').value = 'custompopup';
		document.getElementById('onclickactionrow').style.display = 'block';
		document.getElementById('item_cookie_settings').style.display = 'none';
		document.getElementById('autoClose_closebtm').style.display = 'none';
		document.getElementById('item_htmlexitpopup').style.display = 'none';
		document.getElementById('item_customCSS').style.display = 'none';
		
		// check onclick
		onclick_value = document.getElementById('onclickaction').checked;
		if( onclick_value == true ) {
			document.getElementById('whereToShow').style.display = 'none';
			document.getElementById('schedule_delay_autoclose').style.display = 'none';
			document.getElementById('visitors_control_settings').style.display = 'none';
		} else {
			document.getElementById('whereToShow').style.display = 'block';
			document.getElementById('schedule_delay_autoclose').style.display = 'block';
			document.getElementById('visitors_control_settings').style.display = 'block';
		}
	
	} else if( type == 'csvBackup' ) {
		document.getElementById('csv_backup').style.display = 'block';
		document.getElementById('csv_standalone').style.display = 'none';
		
	} else if( type == 'csvStandAlone' ) {
		document.getElementById('csv_backup').style.display = 'none';
		document.getElementById('csv_standalone').style.display = 'block';
		
	} else if( type == 'squeezepage_stng' ) { 
		document.getElementById('squeezepage_settings').style.display = 'block';
		document.getElementById('other_settings').style.display = 'none';
		
	} else if( type == 'other_stng' ) {
		document.getElementById('squeezepage_settings').style.display = 'none';
		document.getElementById('other_settings').style.display = 'block';
	}
	
	// Switch
	for ( i=1; i<=4; i++ ) {  
		if ( i == currtab ) {
			document.getElementById('listfusionHead-'+i).style.position = 'relative';
			document.getElementById('listfusionHead-'+i).style.top = '1px';
			document.getElementById('listfusionHead-'+i).style.background = "#ffffff";
			document.getElementById('listfusionHead-'+i).style.color = "#21759b"; 
		} else {
			document.getElementById('listfusionHead-'+i).style.position = 'relative';
			document.getElementById('listfusionHead-'+i).style.top = '1px';
			document.getElementById('listfusionHead-'+i).style.background = "#f1f1f1";
			document.getElementById('listfusionHead-'+i).style.color = "#797979";
		}
	}
}
function __listfusion_autofillin(fldname,value){ 
	document.getElementById(fldname).value = value;
}
function __listfusion_custom_popup(){  
		var inputs = document.getElementsByName("listfusion[htmloriframe]");
		for (var i = 0; i < inputs.length; i++) {
		  if (inputs[i].checked) { 
				if( inputs[i].value == 1 ) {
					document.getElementById('custom_html').style.display = 'block';
					document.getElementById('custom_iframe').style.display = 'none';
				} else if( inputs[i].value == 2 ) {
					document.getElementById('custom_html').style.display = 'none';
					document.getElementById('custom_iframe').style.display = 'block';
				}
		  }
		}
}
function __listfusion_showHidediv(curr,target,outer_div) { 
	
	var target = document.getElementById(target);
	var elbproShowRow = 'block'
	if ( navigator.appName.indexOf('Microsoft') == -1 && target.tagName == 'TR' ) elbproShowRow = 'table-row';
	if ( curr.checked == true ) { 
		target.style.display = elbproShowRow;
		if ( outer_div != '' ) document.getElementById(outer_div).style.display = 'none';
		if( target = 'whereToShow' ) {
			document.getElementById('schedule_delay_autoclose').style.display = 'none';
			document.getElementById('visitors_control_settings').style.display = 'none';
		}
	} else {
	    target.style.display = 'none';
		if ( outer_div != '' ) document.getElementById(outer_div).style.display = 'block';
		if( target = 'whereToShow' ) {
			document.getElementById('schedule_delay_autoclose').style.display = 'block';
			document.getElementById('visitors_control_settings').style.display = 'block';
		}
	}
}

function __listfusion_Schedule(chkname,frist_visits,every_days,after_visit) {
	var schedule_box_option = document.getElementsByName(chkname);
	// Find checkbox Value
	for (var i=0; i < schedule_box_option.length; i++)
	   {
	   if (schedule_box_option[i].checked)
		  {
		  var chkbox_value = schedule_box_option[i].value;
		  }
	   }
	if( chkbox_value == 1 ) {
		document.getElementById(frist_visits).disabled = true;
		document.getElementById(every_days).disabled = true;
		document.getElementById(after_visit).disabled = true;
	} else if( chkbox_value == 2 ) { 
		document.getElementById(frist_visits).disabled = false;
		document.getElementById(every_days).disabled = true;
		document.getElementById(after_visit).disabled = true;
	} else if( chkbox_value == 3 ) {
		document.getElementById(every_days).disabled = false;
		document.getElementById(frist_visits).disabled = true;
		document.getElementById(after_visit).disabled = true;
	} else if( chkbox_value == 4 ) {
		document.getElementById(after_visit).disabled = false;
		document.getElementById(frist_visits).disabled = true;
		document.getElementById(every_days).disabled = true;
	}
}

/*window.onload = function() {
 __listfusion_Schedule('listfusion[scheduleOnDisplay]','schedule_for_frist_visits','schedult_on_every_days','schedult_after_visit');
};*/

function __listfusion_popup_chk(){
	popup_fusion_type = document.getElementById('listFusionType').value;
	var itemName = document.getElementById('popupItemName').value;
	if( popup_fusion_type == 'optinpopup' || popup_fusion_type == 'withinpostoptin' ) {
		var arpID = document.getElementById('popup_arpJs').value;
		if (  arpID == 0 ) {
			alert('Please Select Your Autoresponder Service From DropDown Box');
			document.getElementById('popup_arpJs').style.border = '1px solid #FF3333';
			document.getElementById('popup_arpJs').focus();
			return false;
		}
	} else if( popup_fusion_type == 'adpopup' || popup_fusion_type == 'withinpostad' ) {
		var chkRURL = document.getElementById('popup_redirectURL').value;
		if (  chkRURL == '' ) {
				alert(' \'Ad PopUp Redirect Link URL\' EMPTY.');
				document.getElementById('popup_redirectURL').style.border = '1px solid #FF6600';
				document.getElementById('popup_redirectURL').focus();
				return false;
		}
	} 
	if (  itemName == '' ) {
		alert('Your Popup Name Is Blank. Please Provide Suitable Name For Your Campaign');
		document.getElementById('popupItemName').style.border = '1px solid #FF6600';
		document.getElementById('popupItemName').focus();
		return false;
	}
}

function __listfusion_clickslider_chk(){ 
	slider_fusion_type = document.getElementById('listFusionType').value;
	var itemName = document.getElementById('sliderItemName').value;
	if( slider_fusion_type == 'clickslideroptin' || slider_fusion_type == 'sidebaroptin' || slider_fusion_type == 'icboxoptin' ) {
		var arpID = document.getElementById('clickslider_arpJs').value;
		if (  arpID == 0 ) {
			alert('Please Select Your Autoresponder Service From DropDown Box');
			document.getElementById('clickslider_arpJs').style.border = '1px solid #FF3333';
			document.getElementById('clickslider_arpJs').focus();
			return false;
		}
	} else if( slider_fusion_type == 'clicksliderad' || slider_fusion_type == 'sidebarad' || slider_fusion_type == 'icboxad' ) {
		var chkRURL = document.getElementById('slider_redirectURL').value;
		if (  chkRURL == '' ) {
				alert(' \'Ad Redirect Link URL\' EMPTY.');
				document.getElementById('slider_redirectURL').style.border = '1px solid #FF6600';
				document.getElementById('slider_redirectURL').focus();
				return false;
		}
	} 
	if (  itemName == '' ) {
		alert('Your Slider Name Is Blank. Please Provide Suitable Name For Your Campaign');
		document.getElementById('sliderItemName').style.border = '1px solid #FF6600';
		document.getElementById('sliderItemName').focus();
		return false;
	}
}


function __listfusion_sqpg_chk(){
	var itemName = document.getElementById('sqpgdisplayname').value;
	var arpID = document.getElementById('sqpg_arpJs').value;
	if (  arpID == 0 ) {
		alert('Please Select Your Autoresponder Service From DropDown Box');
		document.getElementById('sqpg_arpJs').style.border = '1px solid #FF3333';
		document.getElementById('sqpg_arpJs').focus();
		return false;
	}
	if (  itemName == '' ) {
		alert('Your Popup Name Is Blank. Please Provide Suitable Name For Your Campaign');
		document.getElementById('sqpgdisplayname').style.border = '1px solid #FF6600';
		document.getElementById('sqpgdisplayname').focus();
		return false;
	}
}

function listfusion_htmlpop(){ 
	var option = document.getElementById("show_exit_html_popup").value;
	if( option == 1 ){ 
		document.getElementById("jsalert_htmlexitpopup").style.display = "block";
		document.getElementById("browser_viewpoint_display").style.display = "none";
		document.getElementById("jsalert_onpagescroll").style.display = "none";
		document.getElementById("jsalert_userinactivity").style.display = "none";
    } else if( option == 2 ){ 
		document.getElementById("browser_viewpoint_display").style.display = "block";
		document.getElementById("jsalert_htmlexitpopup").style.display = "none";
		document.getElementById("jsalert_onpagescroll").style.display = "none";
		document.getElementById("jsalert_userinactivity").style.display = "none";
    } else if( option == 3 ){ 
		document.getElementById("browser_viewpoint_display").style.display = "none";
		document.getElementById("jsalert_htmlexitpopup").style.display = "none";
		document.getElementById("jsalert_onpagescroll").style.display = "block";
		document.getElementById("jsalert_userinactivity").style.display = "none";
    } else if( option == 4 ){ 
		document.getElementById("browser_viewpoint_display").style.display = "none";
		document.getElementById("jsalert_htmlexitpopup").style.display = "none";
		document.getElementById("jsalert_onpagescroll").style.display = "none";
		document.getElementById("jsalert_userinactivity").style.display = "block";
    } else { 
		document.getElementById("browser_viewpoint_display").style.display = "none";
		document.getElementById("jsalert_htmlexitpopup").style.display = "none";
		document.getElementById("jsalert_onpagescroll").style.display = "none";
		document.getElementById("jsalert_userinactivity").style.display = "none";
	}
}

/***********************
** APPLY DATA PROCESSING
************************/
function listfusion_demo_graber(type,newvalue,callajaxURL, listFusionType){
	if( type == 'imgpreview' ) {
		var listfusionType = document.getElementById(listFusionType).value;
		jQuery('#loaddemo_previewimg').show();
	}
	if( type == 'arpProcess' ) {
		jQuery('#popup_dropdownResponsebk').show();
	}
	var demotype = newvalue; // Only ID
    jQuery.ajax({
			type: "post",
			url: callajaxURL,
			data: { action: 'listfusionDEMOcall', 
					type: listfusionType,
					recordID: demotype, 
					dataProcessType: type 
				  },
			success: function(data, textStatus, XMLHttpRequest){ 
					if( type == 'imgpreview' ) {
						jQuery('#loaddemo_previewimg').hide();
						var process_value = data.split(',');
						if ( navigator.appName.indexOf('Microsoft') == -1 ) display_now = 'table-row';
						
					    if( process_value[2] == 'icboxoptin' || process_value[2] == 'icboxad' ) {
							jQuery('#ajx-preview-sidebar').html(process_value[0]);
							if( process_value[1] == 1 ) {}
							
						} else if( process_value[2] == 'withinpostoptin' || process_value[2] == 'withinpostad' || process_value[2] == 'withinpostsocial' ) {
							jQuery('#ajx-preview').html(process_value[0]);
							if( process_value[1] == 1 ) {
								document.getElementById('withinpost_video_display').style.display = 'none';	
								document.getElementById('withinpost_img_display').style.display = 'none';	
								document.getElementById('withinpost_listpoint_display').style.display = 'none';	
								document.getElementById('withinpost_message_display').style.display = display_now;		
								document.getElementById('withinpost_title_display').style.display = display_now;		
							} else if( process_value[1] == 2 || process_value[1] == 3 ) {
								document.getElementById('withinpost_video_display').style.display = 'none';	
								document.getElementById('withinpost_img_display').style.display = display_now;
								document.getElementById('withinpost_listpoint_display').style.display = 'none';	
								document.getElementById('withinpost_message_display').style.display = 'none';		
								document.getElementById('withinpost_title_display').style.display = display_now;		
							} else if( process_value[1] == 4 ) {
								document.getElementById('withinpost_video_display').style.display = display_now;
								document.getElementById('withinpost_img_display').style.display = 'none';	
								document.getElementById('withinpost_listpoint_display').style.display = 'none';	
								document.getElementById('withinpost_message_display').style.display = 'none';		
								document.getElementById('withinpost_title_display').style.display = 'none';			
							} else if( process_value[1] == 5 ) {
								document.getElementById('withinpost_video_display').style.display = 'none';
								document.getElementById('withinpost_img_display').style.display =  display_now;
								document.getElementById('withinpost_listpoint_display').style.display = 'none';	
								document.getElementById('withinpost_message_display').style.display = display_now;	
								document.getElementById('withinpost_title_display').style.display =  display_now;			
							}
						} else if( process_value[2] == 'sidebaroptin' || process_value[2] == 'sidebarad' ) {
							jQuery('#ajx-preview-sidebar').html(process_value[0]);
							 if( process_value[1] == 1 ) {
								document.getElementById('sidebar_img_display').style.display = 'none';	
								document.getElementById('sidebar_video_display').style.display = 'none';	
								document.getElementById('sidebar_title_display').style.display = display_now;
								document.getElementById('title_bg_color_display').style.display = 'block';
							 } else if( process_value[1] == 2 || process_value[1] == 3 || process_value[1] == 5 ) {
								document.getElementById('sidebar_img_display').style.display = display_now;	
								document.getElementById('sidebar_video_display').style.display = 'none';	
								document.getElementById('sidebar_title_display').style.display = display_now;
								if( process_value[1] == 3 ) {
									document.getElementById('title_bg_color_display').style.display = 'none';	
								} else {
									document.getElementById('title_bg_color_display').style.display = 'block';	
								}
							 } else if( process_value[1] == 4 ) {
								document.getElementById('sidebar_img_display').style.display = 'none';	
								document.getElementById('sidebar_video_display').style.display = display_now;	
								document.getElementById('sidebar_title_display').style.display = 'none';
								document.getElementById('title_bg_color_display').style.display = 'block';
							 } else {
								document.getElementById('sidebar_img_display').style.display = display_now;	
								document.getElementById('sidebar_video_display').style.display = display_now;	
								document.getElementById('sidebar_title_display').style.display = display_now;	
								document.getElementById('title_bg_color_display').style.display = 'block';	
							 }
						
						
						} else if( process_value[2] == 'squeezepg' ) {
							 jQuery('#ajx-preview-sqpg').html(process_value[0]);
							 if( process_value[1] == 1 ) {
								document.getElementById('sqpg_auto_img').style.display = 'none';	
								document.getElementById('sqpg_auto_video').style.display = 'none';	
								// display
								document.getElementById('sqpg_auto_warning').style.display = display_now;
								document.getElementById('sqpg_auto_msg').style.display = display_now;
								document.getElementById('sqpg_auto_listpoint').style.display = display_now;
								document.getElementById('sqpg_auto_optinmsg').style.display = display_now;
								document.getElementById('sqpg_auto_title').style.display = display_now;
								// change color
								document.getElementById('span_change_text_msg_color').innerHTML = '(Default: 000000)';
								document.getElementById('change_text_msg_color').style.display = 'inline-block';
								document.getElementById('span_change_text_msg_color').style.display = 'inline-block';
								document.getElementById('change_text_bold_color').style.display = 'inline-block';
								document.getElementById('span_text_bold_color').style.display = 'inline-block';
								document.getElementById('change_text_security_color').style.display = 'inline-block';
								document.getElementById('span_text_security_color').style.display = 'inline-block';
								document.getElementById('text_listpoint_color').style.display = 'inline-block';
								document.getElementById('span_text_listpoint_color').style.display = 'inline-block';
								document.getElementById('text_bodymainmsg_color').style.display = 'inline-block';
								document.getElementById('span_text_bodymainmsg_color').style.display = 'inline-block';
								
								
							 } else if( process_value[1] == 2 ) {
								document.getElementById('sqpg_auto_warning').style.display = 'none';
								document.getElementById('sqpg_auto_img').style.display = 'none';	
								document.getElementById('sqpg_auto_video').style.display = 'none';	
								//display
								document.getElementById('sqpg_auto_msg').style.display = display_now;
								document.getElementById('sqpg_auto_listpoint').style.display = display_now;
								document.getElementById('sqpg_auto_optinmsg').style.display = display_now;
								document.getElementById('sqpg_auto_title').style.display = display_now;
								// change color
								document.getElementById('span_change_text_msg_color').innerHTML = '(Default: 007FCB)';
								document.getElementById('change_text_msg_color').style.display = 'inline-block';
								document.getElementById('span_change_text_msg_color').style.display = 'inline-block';
								document.getElementById('change_text_bold_color').style.display = 'inline-block';
								document.getElementById('span_text_bold_color').style.display = 'inline-block';
								document.getElementById('change_text_security_color').style.display = 'inline-block';
								document.getElementById('span_text_security_color').style.display = 'inline-block';
								document.getElementById('text_listpoint_color').style.display = 'inline-block';
								document.getElementById('span_text_listpoint_color').style.display = 'inline-block';
								document.getElementById('text_bodymainmsg_color').style.display = 'inline-block';
								document.getElementById('span_text_bodymainmsg_color').style.display = 'inline-block';
								
								
							 } else if( process_value[1] == 3 || process_value[1] == 4 || process_value[1] == 5 ) {
								document.getElementById('sqpg_auto_warning').style.display = 'none';
								if( process_value[1] == 5 ) { 
									document.getElementById('sqpg_auto_img').style.display = display_now;
									document.getElementById('sqpg_auto_video').style.display = 'none';
									// NEW HIDE
									document.getElementById('change_text_msg_color').style.display = 'none';
									document.getElementById('span_change_text_msg_color').style.display = 'none';
									document.getElementById('change_text_bold_color').style.display = 'none';
									document.getElementById('span_text_bold_color').style.display = 'none';
									document.getElementById('change_text_security_color').style.display = 'none';
									document.getElementById('span_text_security_color').style.display = 'none';
									document.getElementById('text_listpoint_color').style.display = 'inline-block';
									document.getElementById('span_text_listpoint_color').style.display = 'inline-block';
									document.getElementById('text_bodymainmsg_color').style.display = 'inline-block';
									document.getElementById('span_text_bodymainmsg_color').style.display = 'inline-block';
									
								} else { 
									document.getElementById('sqpg_auto_img').style.display = 'none';
									document.getElementById('sqpg_auto_video').style.display = 'block';
									// change color
									if( process_value[1] == 4 ) { 
										document.getElementById('span_change_text_msg_color').innerHTML = '(Default: 333333)';
										document.getElementById('change_text_msg_color').style.display = 'inline-block';
										document.getElementById('span_change_text_msg_color').style.display = 'inline-block';
										document.getElementById('change_text_bold_color').style.display = 'inline-block';
										document.getElementById('span_text_bold_color').style.display = 'inline-block';
										document.getElementById('change_text_security_color').style.display = 'inline-block';
										document.getElementById('span_text_security_color').style.display = 'inline-block';
										document.getElementById('text_listpoint_color').style.display = 'inline-block';
										document.getElementById('span_text_listpoint_color').style.display = 'inline-block';
										document.getElementById('text_bodymainmsg_color').style.display = 'inline-block';
										document.getElementById('span_text_bodymainmsg_color').style.display = 'inline-block';
										
									} else {
										document.getElementById('span_change_text_msg_color').innerHTML = '(Default: CC0000)';
										document.getElementById('change_text_msg_color').style.display = 'inline-block';
										document.getElementById('span_change_text_msg_color').style.display = 'inline-block';
										document.getElementById('change_text_bold_color').style.display = 'inline-block';
										document.getElementById('span_text_bold_color').style.display = 'inline-block';
										document.getElementById('change_text_security_color').style.display = 'inline-block';
										document.getElementById('span_text_security_color').style.display = 'inline-block';
										document.getElementById('text_listpoint_color').style.display = 'inline-block';
										document.getElementById('span_text_listpoint_color').style.display = 'inline-block';
										document.getElementById('text_bodymainmsg_color').style.display = 'inline-block';
										document.getElementById('span_text_bodymainmsg_color').style.display = 'inline-block';
										
										
									}
								}
								document.getElementById('sqpg_auto_msg').style.display = 'none';
								document.getElementById('sqpg_auto_listpoint').style.display = 'none';
								document.getElementById('sqpg_auto_optinmsg').style.display = display_now;
								document.getElementById('sqpg_auto_title').style.display = display_now;
							 } else if( process_value[1] == 6 ) {
								document.getElementById('sqpg_auto_warning').style.display = 'none';
								document.getElementById('sqpg_auto_img').style.display = 'none';	
								//display
								document.getElementById('sqpg_auto_video').style.display = 'block';	
								document.getElementById('sqpg_auto_msg').style.display = display_now;
								document.getElementById('sqpg_auto_listpoint').style.display = display_now;
								document.getElementById('sqpg_auto_optinmsg').style.display = display_now;
								document.getElementById('sqpg_auto_title').style.display = display_now;
								
								document.getElementById('span_change_text_msg_color').innerHTML = '(Default: 0076C9)';
								document.getElementById('change_text_msg_color').style.display = 'inline-block';
								document.getElementById('span_change_text_msg_color').style.display = 'inline-block';
								document.getElementById('change_text_bold_color').style.display = 'inline-block';
								document.getElementById('span_text_bold_color').style.display = 'inline-block';
								document.getElementById('change_text_security_color').style.display = 'inline-block';
								document.getElementById('span_text_security_color').style.display = 'inline-block';
								document.getElementById('text_listpoint_color').style.display = 'inline-block';
								document.getElementById('span_text_listpoint_color').style.display = 'inline-block';
								document.getElementById('text_bodymainmsg_color').style.display = 'inline-block';
								document.getElementById('span_text_bodymainmsg_color').style.display = 'inline-block';
								
							 } else if( process_value[1] == 7 ) {
								document.getElementById('sqpg_auto_warning').style.display = 'none';
								document.getElementById('sqpg_auto_img').style.display = 'none';	
								document.getElementById('sqpg_auto_msg').style.display = 'none';
								document.getElementById('sqpg_auto_listpoint').style.display = 'none';
								document.getElementById('sqpg_auto_optinmsg').style.display = 'none';
								document.getElementById('sqpg_auto_title').style.display = 'none';
								//display
								document.getElementById('sqpg_auto_video').style.display = 'block';	
								document.getElementById('change_text_security_color').style.display = 'none';
								document.getElementById('span_text_security_color').style.display = 'none';
								
							 } else if( process_value[1] == 8 ) {
								document.getElementById('sqpg_auto_warning').style.display = 'none';
								document.getElementById('sqpg_auto_img').style.display = 'none';
								document.getElementById('sqpg_auto_listpoint').style.display = 'none';
								document.getElementById('sqpg_auto_optinmsg').style.display = 'none';
								// display
								document.getElementById('sqpg_auto_video').style.display = 'block';
								document.getElementById('sqpg_auto_msg').style.display =  display_now;
								document.getElementById('sqpg_auto_title').style.display = display_now;
								
								document.getElementById('change_text_msg_color').style.display = 'inline-block';
								document.getElementById('span_change_text_msg_color').style.display = 'inline-block';
								document.getElementById('change_text_bold_color').style.display = 'inline-block';
								document.getElementById('span_text_bold_color').style.display = 'inline-block';
								document.getElementById('change_text_security_color').style.display = 'inline-block';
								document.getElementById('span_text_security_color').style.display = 'inline-block';
								document.getElementById('text_listpoint_color').style.display = 'inline-block';
								document.getElementById('span_text_listpoint_color').style.display = 'inline-block';
								document.getElementById('text_bodymainmsg_color').style.display = 'inline-block';
								document.getElementById('span_text_bodymainmsg_color').style.display = 'inline-block';
								
								
							 } else if( process_value[1] == 9 ) {
								document.getElementById('sqpg_auto_warning').style.display = 'none';
								document.getElementById('sqpg_auto_video').style.display = 'none';
								document.getElementById('sqpg_auto_listpoint').style.display = 'none';
								// display
								document.getElementById('sqpg_auto_optinmsg').style.display = display_now;
								document.getElementById('sqpg_auto_img').style.display = display_now;
								document.getElementById('sqpg_auto_msg').style.display =  display_now;
								document.getElementById('sqpg_auto_title').style.display = display_now;
								
								document.getElementById('span_change_text_msg_color').innerHTML = '(Default: 333333)';
								document.getElementById('change_text_msg_color').style.display = 'inline-block';
								document.getElementById('span_change_text_msg_color').style.display = 'inline-block';
								document.getElementById('change_text_bold_color').style.display = 'inline-block';
								document.getElementById('span_text_bold_color').style.display = 'inline-block';
								document.getElementById('change_text_security_color').style.display = 'inline-block';
								document.getElementById('span_text_security_color').style.display = 'inline-block';
								
								document.getElementById('text_listpoint_color').style.display = 'inline-block';
								document.getElementById('span_text_listpoint_color').style.display = 'inline-block';
								document.getElementById('text_bodymainmsg_color').style.display = 'inline-block';
								document.getElementById('span_text_bodymainmsg_color').style.display = 'inline-block';
								
							 }  else if( process_value[1] == 10 ) {
								document.getElementById('sqpg_auto_warning').style.display = 'none';
								document.getElementById('sqpg_auto_video').style.display = 'none';
								document.getElementById('sqpg_auto_img').style.display = 'none';
								// display
								document.getElementById('sqpg_auto_listpoint').style.display = display_now;
								document.getElementById('sqpg_auto_optinmsg').style.display = display_now;
								document.getElementById('sqpg_auto_msg').style.display =  display_now;
								document.getElementById('sqpg_auto_title').style.display = display_now;
								
								// NEW HIDE
								document.getElementById('span_change_text_msg_color').innerHTML = '(Default: FFFFFF)';
								document.getElementById('change_text_msg_color').style.display = 'inline-block';
								document.getElementById('span_change_text_msg_color').style.display = 'inline-block';
								document.getElementById('change_text_bold_color').style.display = 'none';
								document.getElementById('span_text_bold_color').style.display = 'none';
								document.getElementById('change_text_security_color').style.display = 'none';
								document.getElementById('span_text_security_color').style.display = 'none';
								
								document.getElementById('text_listpoint_color').style.display = 'none';
								document.getElementById('span_text_listpoint_color').style.display = 'none';
								document.getElementById('text_bodymainmsg_color').style.display = 'none';
								document.getElementById('span_text_bodymainmsg_color').style.display = 'none';
								
								
							 } else {
								document.getElementById('sqpg_auto_img').style.display = display_now;	
								document.getElementById('sqpg_auto_video').style.display = 'block';
								document.getElementById('sqpg_auto_warning').style.display = display_now;
								document.getElementById('sqpg_auto_msg').style.display = display_now;
								document.getElementById('sqpg_auto_listpoint').style.display = display_now;
								document.getElementById('sqpg_auto_optinmsg').style.display = display_now;
								document.getElementById('sqpg_auto_title').style.display = display_now;
							 }
							
						} else { 
						    jQuery('#ajx-preview').html(process_value[0]);
							if( process_value[1] == 1 || process_value[1] == 7 || process_value[1] == 8 || process_value[1] == 10 || process_value[1] == 12 ) {
								document.getElementById('preview_videoID').style.display = 'none';
								// display
								if( process_value[1] == 1 || process_value[1] == 8 ) { document.getElementById('preview_pickdesign_color').style.display = 'inline';
								} else { document.getElementById('preview_pickdesign_color').style.display = 'none'; }
								
								if( process_value[1] == 12 ) { document.getElementById('preview_uploadimg').style.display = 'none'; 
								} else { document.getElementById('preview_uploadimg').style.display = display_now; }
								
								document.getElementById('preview_optinmsg').style.display = 'block';
								document.getElementById('preview_listpoints').style.display = display_now;
								document.getElementById('preview_admsg').style.display = 'block';
								document.getElementById('preview_socialmsg').style.display = 'block';
								document.getElementById('preview_header').style.display = display_now;
								document.getElementById('preview_maintext').style.display = display_now;
							} else if( process_value[1] == 2 ) {
								document.getElementById('preview_videoID').style.display = 'none';
								document.getElementById('preview_optinmsg').style.display = 'none';
								// display
								document.getElementById('preview_pickdesign_color').style.display = 'inline';
								document.getElementById('preview_listpoints').style.display = display_now;
								document.getElementById('preview_uploadimg').style.display = display_now;
								document.getElementById('preview_admsg').style.display = 'block';
								document.getElementById('preview_socialmsg').style.display = 'block';
								document.getElementById('preview_header').style.display = display_now;
								document.getElementById('preview_maintext').style.display = display_now;
							} else if( process_value[1] == 3 ) {
								document.getElementById('preview_listpoints').style.display = 'none';
								document.getElementById('preview_videoID').style.display = 'none';
								document.getElementById('preview_uploadimg').style.display = 'none';
								document.getElementById('preview_optinmsg').style.display = 'none';
								document.getElementById('preview_pickdesign_color').style.display = 'none';
								// display
								document.getElementById('preview_admsg').style.display = 'block';
								document.getElementById('preview_socialmsg').style.display = 'block';
								document.getElementById('preview_header').style.display = display_now;
								document.getElementById('preview_maintext').style.display = display_now;
							} else if( process_value[1] == 4 ) {
								document.getElementById('preview_listpoints').style.display = 'none';
								document.getElementById('preview_uploadimg').style.display = 'none';
								document.getElementById('preview_header').style.display = 'none';
								document.getElementById('preview_maintext').style.display = 'none';
								document.getElementById('preview_pickdesign_color').style.display = 'none';
								// display
								document.getElementById('preview_videoID').style.display = display_now;
								document.getElementById('preview_admsg').style.display = 'block';
								document.getElementById('preview_optinmsg').style.display = 'block';
								document.getElementById('preview_socialmsg').style.display = 'block';
							} else if( process_value[1] == 5 ) {
								document.getElementById('preview_videoID').style.display = 'none';
								document.getElementById('preview_admsg').style.display = 'none';
								document.getElementById('preview_optinmsg').style.display = 'none';
								document.getElementById('preview_socialmsg').style.display = 'none';
								document.getElementById('preview_listpoints').style.display = 'none';
								document.getElementById('preview_uploadimg').style.display = 'none';
								document.getElementById('preview_pickdesign_color').style.display = 'none';
								// display
								document.getElementById('preview_header').style.display = display_now;
								document.getElementById('preview_maintext').style.display = display_now;
							} else if( process_value[1] == 6 ) {
								document.getElementById('preview_videoID').style.display = 'none';
								document.getElementById('preview_admsg').style.display = 'none';
								document.getElementById('preview_optinmsg').style.display = 'none';
								document.getElementById('preview_socialmsg').style.display = 'none';
								document.getElementById('preview_listpoints').style.display = 'none';
								document.getElementById('preview_uploadimg').style.display = 'none';
								document.getElementById('preview_maintext').style.display = 'none';
								document.getElementById('preview_pickdesign_color').style.display = 'none';
								// display
								document.getElementById('preview_header').style.display = display_now;
							} else if( process_value[1] == 9 ) {
								document.getElementById('preview_videoID').style.display = 'none';
								document.getElementById('preview_optinmsg').style.display = 'none';
								document.getElementById('preview_uploadimg').style.display = 'none';
								document.getElementById('preview_maintext').style.display = 'none';
								document.getElementById('preview_pickdesign_color').style.display = 'none';
								// display
								document.getElementById('preview_admsg').style.display = 'block';
								document.getElementById('preview_socialmsg').style.display = 'block';
								document.getElementById('preview_header').style.display = display_now;
								document.getElementById('preview_listpoints').style.display = display_now;
							} else if( process_value[1] == 11 ) {
								document.getElementById('preview_videoID').style.display = 'none';
								document.getElementById('preview_optinmsg').style.display = 'none';
								document.getElementById('preview_maintext').style.display = 'none';
								document.getElementById('preview_pickdesign_color').style.display = 'none';
								// display
								document.getElementById('preview_admsg').style.display = 'block';
								document.getElementById('preview_socialmsg').style.display = 'block';
								document.getElementById('preview_header').style.display = display_now;
								document.getElementById('preview_listpoints').style.display = display_now;
								document.getElementById('preview_uploadimg').style.display = display_now;
							} else if( process_value[1] == 13 ) {
								document.getElementById('preview_admsg').style.display = 'none';
								document.getElementById('preview_optinmsg').style.display = 'none';
								document.getElementById('preview_socialmsg').style.display = 'none';
								document.getElementById('preview_listpoints').style.display = 'none';
								document.getElementById('preview_uploadimg').style.display = 'none';
								document.getElementById('preview_maintext').style.display = 'none';
								document.getElementById('preview_header').style.display = 'none';
								document.getElementById('preview_pickdesign_color').style.display = 'inline';
								// display
								document.getElementById('preview_videoID').style.display = display_now;
							} else if( process_value[1] == 14 ) {
								document.getElementById('preview_admsg').style.display = 'none';
								document.getElementById('preview_optinmsg').style.display = 'none';
								document.getElementById('preview_socialmsg').style.display = 'none';
								document.getElementById('preview_maintext').style.display = 'none';
								document.getElementById('preview_videoID').style.display = 'none';
								document.getElementById('preview_pickdesign_color').style.display = 'none';
								// display
								document.getElementById('preview_header').style.display = display_now;
								document.getElementById('preview_listpoints').style.display = display_now;
								document.getElementById('preview_uploadimg').style.display = display_now;
							} else if( process_value[1] == 15 ) {
								document.getElementById('preview_maintext').style.display = 'none';
								document.getElementById('preview_videoID').style.display = 'none';
								document.getElementById('preview_header').style.display = 'none';
								document.getElementById('preview_listpoints').style.display = 'none';
								document.getElementById('preview_pickdesign_color').style.display = 'none';
								// display
								document.getElementById('preview_uploadimg').style.display = display_now;
								document.getElementById('preview_admsg').style.display = 'block';
								document.getElementById('preview_optinmsg').style.display = 'block';
								document.getElementById('preview_socialmsg').style.display = 'block';
							} else if( process_value[1] == 16 ) {
								document.getElementById('preview_videoID').style.display = 'none';
								document.getElementById('preview_listpoints').style.display = 'none';
								document.getElementById('preview_maintext').style.display = 'none';
								document.getElementById('preview_pickdesign_color').style.display = 'none';
								// display
								document.getElementById('preview_header').style.display = display_now;
								document.getElementById('preview_uploadimg').style.display = display_now;
								document.getElementById('preview_admsg').style.display = 'block';
								document.getElementById('preview_optinmsg').style.display = 'block';
								document.getElementById('preview_socialmsg').style.display = 'block';
							} else {
								document.getElementById('preview_videoID').style.display = display_now;
								document.getElementById('preview_optinmsg').style.display = 'block';
								document.getElementById('preview_listpoints').style.display = display_now;
								document.getElementById('preview_uploadimg').style.display = display_now;
								document.getElementById('preview_admsg').style.display = 'block';
								document.getElementById('preview_socialmsg').style.display = 'block';
								document.getElementById('preview_header').style.display = display_now;
								document.getElementById('preview_maintext').style.display = display_now;
								document.getElementById('preview_pickdesign_color').style.display = 'block';
							}
						}
					}
					
					if( type == 'arpProcess' ) {
						jQuery('#popup_dropdownResponsebk').hide();
						if( data == 'None' || data == 'noresult' || data == '' ) {
							jQuery('#displayARPajxResult').hide();
						} else {
							jQuery('#displayARPajxResult').show();
						}
					}
				    //alert(data); 
			  },  
			error: function(MLHttpRequest, textStatus, errorThrown){  
				//alert(textStatus); 
			}  						
	}); //close jQuery.ajax
}

/***********************
** TAG
************************/
function listfusion_Overlay(curobj, subobjstr, opt_position){
	if (document.getElementById){
		var subobj=document.getElementById(subobjstr)
		subobj.style.display=(subobj.style.display!="block")? "block" : "none"
		var xpos=sbmgGetPosOffset(curobj, "left")+((typeof opt_position!="undefined" && opt_position.indexOf("right")!=-1)? -(subobj.offsetWidth-curobj.offsetWidth) : 0) 
		var ypos=sbmgGetPosOffset(curobj, "top")+((typeof opt_position!="undefined" && opt_position.indexOf("bottom")!=-1)? curobj.offsetHeight : 0)
		subobj.style.left=xpos+"px"
		subobj.style.top=ypos+"px"
		return false
	} else {
		return true
	}
}
function listfusion_OverlayClose(subobj){
	document.getElementById(subobj).style.display = "none";
}

function listfusion_GetOrdinal(number,ordinal) {
	number = parseInt(number.value);
	if ( number % 10 == 1 && number % 100 != 11 ) {
		ordinal.innerHTML = 'st';
	} else if ( number % 10 == 2 && number % 100 != 12 ) {
		ordinal.innerHTML = 'nd';
	} else if ( number % 10 == 3 && number % 100 != 13 ) {
		ordinal.innerHTML = 'rd';
	} else {
		ordinal.innerHTML = 'th';
	}
}
