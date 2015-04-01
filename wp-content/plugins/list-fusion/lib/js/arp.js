var ie = document.all;
function __JS_listfustion_PopulateDropdown(dropDown, theArray) { 
	var i;
	dropDown.length = 0;
	for (i=0; i<theArray.length; i++) {
	   dropDown.options[i] = new Option(theArray[i], theArray[i]);
	}
}
Array.prototype.in_array = function ( obj ) {
	var len = this.length;
	for ( var x = 0 ; x <= len ; x++ ) {
	   if ( this[x] == obj ) return true;
	}
	return false;
}
/*
* List Fusion - HTML process
****************************/
function __JS_listfustion_html_Process(type) {   
	var frm_action = '';
	var the_hidden_flds = '';
	var arp_detected = 1;  // Autoresponder Name
	var choices = new Array();
	var hidden_flds = new Array('None');
	var form_code = document.getElementById('listfustion_html_optin_form_code').value; // Textarea (HTML Optin Form Code)
	if ( form_code == '' ) {
		alert('HTML Optin Form Code Required'); 
		document.getElementById('listfustion_html_optin_form_code').style.backgroundColor = '#FDECE9';
		document.getElementById('listfustion_html_optin_form_code').focus();
		return false;
	}
	
	var form_code_html = document.getElementById('listfustion_form_code_html'); // Div id name with hidden tag.
	var name_fld = document.getElementById('listfusion_name_fld');
	var email_fld = document.getElementById('listfusion_email_fld');
	var form_hidden_flds = document.getElementById('listfustion_html_form_hidden_flds');
	var trackcode_fld = document.getElementById('listfusion_trackcode_fld');
	var form_url = document.getElementById('listfusion_redirect_url');
	var custom_fld = document.getElementById('listfusion_custom_fld');
	var custom_fldClone = document.getElementById('listfusion_clone_fld');

	
	if ( type == 'split' ) {
		if( document.listfustion_arp_form.listfusion_split_name.checked == true ) { // checked
			var first_name_fld = document.getElementById('listfusion_first_name_fld');
			var last_name_fld = document.getElementById('listfusion_last_name_fld');
		} else {}
	}
	
	var pattern = /action=("|')(.*?)('|")/i;
	var matches = pattern.exec(form_code);
	if ( matches != null ) {
		frm_action = matches[2];
		frm_action = frm_action.toLowerCase();
	}
	form_url.value = frm_action; // Gives Form Url.
	
	form_code_2 = form_code.replace(/<form/gi,'<SBMG_Form');
	form_code_2 = form_code_2.replace(/<\/form/gi,'</SBMG_Form');
	form_code_html.innerHTML = form_code_2;  // Sends html optin form on div.
	var text_boxes = form_code_html.getElementsByTagName("INPUT");
	for ( var i=0; i<text_boxes.length; i++ ) {
	   var textbox = text_boxes[i];
	   if ( textbox.type == 'text' || textbox.type == 'email' ) choices[choices.length] = textbox.name;
	   if ( textbox.type == 'hidden' ) { 
	   	  hidden_flds[hidden_flds.length] = textbox.name;
	      the_hidden_flds += ',' + textbox.name;
	   }
	}
	
	form_hidden_flds.value = the_hidden_flds; // Gives hidden field names in format: a,b,c
	
	// If no fields define then choose from default.
	if ( choices[0] == undefined ) {
		choices[0] = 'name';
		choices[1] = 'email';
		choices[2] = 'fname';
		choices[3] = 'lname';
	}
	
	__JS_listfustion_PopulateDropdown(name_fld, choices);
	__JS_listfustion_PopulateDropdown(email_fld, choices);
	if ( type != 'split' ) {  
		__JS_listfustion_PopulateDropdown(trackcode_fld, hidden_flds);
	}
	__JS_listfustion_PopulateDropdown(custom_fld, choices);
	__JS_listfustion_PopulateDropdown(custom_fldClone, choices);
	
	if ( type == 'split' ) {
		if( document.listfustion_arp_form.listfusion_split_name.checked == true ) { // checked
			__JS_listfustion_PopulateDropdown(first_name_fld, choices);
			__JS_listfustion_PopulateDropdown(last_name_fld, choices);
			
			// Guess First Name
			if (choices.in_array('name')) { first_name_fld.value = 'name'; }
			else if (choices.in_array('MERGE1')) { first_name_fld.value = 'MERGE1'; }
			else if (choices.in_array('FNAME')) { first_name_fld.value = 'FNAME'; }
			else { first_name_fld.value = choices[2]; }
			// Guess Last Name
			if (choices.in_array('name')) { last_name_fld.value = 'name'; }
			else if (choices.in_array('MERGE2')) { last_name_fld.value = 'MERGE2'; }
			else if (choices.in_array('LNAME')) { last_name_fld.value = 'LNAME'; }
			else { last_name_fld.value = choices[3]; }
			
		} else {}
	}
		
	// Guess Name field
	if (choices.in_array('name')) { name_fld.value = 'name'; }
	else if (choices.in_array('fname')) { name_fld.value = 'fname'; }
	else if (choices.in_array('SubscriberName')) { name_fld.value = 'SubscriberName'; }
	else if (choices.in_array('category2')) { name_fld.value = 'category2'; }
	else if (choices.in_array('SendName')) { name_fld.value = 'SendName'; }
	else if (choices.in_array('FNAME')) { name_fld.value = 'FNAME'; }
	else if (choices.in_array('MERGE1')) { name_fld.value = 'MERGE1'; }
	else { name_fld.value = choices[0]; }
	// Guess Email field
	if (choices.in_array('email')) { email_fld.value = 'email'; }
	else if (choices.in_array('email')) { email_fld.value = 'email'; }
	else if (choices.in_array('Email1')) { email_fld.value = 'Email1'; }
	else if (choices.in_array('MailFromAddress')) { email_fld.value = 'MailFromAddress'; }
	else if (choices.in_array('category3')) { email_fld.value = 'category3'; }
	else if (choices.in_array('SendEmail')) { email_fld.value = 'SendEmail'; }
	else if (choices.in_array('EMAIL')) { email_fld.value = 'EMAIL'; }
	else if (choices.in_array('MERGE0')) { email_fld.value = 'MERGE0'; }
	else { email_fld.value = choices[1]; }
	
	document.getElementById('configure_optin').style.display = 'block';
	document.getElementById('submit_arp_form').style.display = 'block';
	document.getElementById('chk_if_click_process_html_form_btm').value = '1';
	document.getElementById('field_placeholder').style.display = 'block';
	document.getElementById('extra_field_showup').style.display = 'block';
	
	
	if( type != 'split' ) {
		window.scrollTo(0,430);
	}
	
	if( type == 'split' ) {
	var target1 = document.getElementById('first_name_tbl');
	var target2 = document.getElementById('last_name_tbl');
	var field_name = document.getElementById('field_name');
	var name_field_dropdown = document.getElementById('listfusion_name_fld');
	var split_namefld = document.getElementById('split_namefld');
	var split_firstName = document.getElementById('split_first_name');
	var split_lastName = document.getElementById('split_last_name');
	var name_fld_level = document.getElementById('name_fld_level');
	
		if( document.listfustion_arp_form.listfusion_split_name.checked == true ) {
			var showRow = 'block'
			if ( navigator.appName.indexOf('Microsoft') == -1 && target1.tagName == 'TR' ) showRow = 'table-row';
			if ( navigator.appName.indexOf('Microsoft') == -1 && target2.tagName == 'TR' ) showRow = 'table-row';
			target1.style.display = showRow;
			target2.style.display = showRow;
			field_name.style.color = '#CCCCCC';
			name_field_dropdown.disabled = true;
			split_namefld.style.color = '#FF6633';
			split_firstName.style.display = showRow;
			split_lastName.style.display = showRow;
			name_fld_level.style.display = 'none';
			
		} else if( document.listfustion_arp_form.listfusion_split_name.checked == false ) {
			 target1.style.display = 'none';
			 target2.style.display = 'none';
			 field_name.style.color = '#333333';
			 field_name.style.fontWeight = 'bold';
			 name_field_dropdown.disabled = false;
			split_namefld.style.color = '#EDEFF4';
			split_firstName.style.display = 'none';
			split_lastName.style.display = 'none';
			name_fld_level.style.display = '';
		}
	
	}
}
function __ofatrim(stringToTrim) {
	return stringToTrim.replace(/^\s+|\s+$/g,"");
}
function __JS_listfustion_chk_existing_name( existing_forms_names ) { 
	var form_name = document.getElementById('arp_optin_form_name').value;
	var form_name = __ofatrim(form_name);
	if ( form_name == '' ) {
		alert('Optin Form Name Required');
		return false;
	} else if ( existing_forms_names.indexOf(','+form_name+',') !== -1 ) {
		alert('Optin Form Name "'+form_name+'" Already Exists');
		return false;
	}
}
function __JS_listfustion_displayOnlyEmail() {
	var hide_one = document.getElementById('hide_one');
	var target1 = document.getElementById('first_name_tbl');
	var target2 = document.getElementById('last_name_tbl');
	var enable_emailFld = document.getElementById('enableEmailFld');
	
	if( document.listfustion_arp_form.listfusion_disply_only_email.checked == true ) { 
		hide_one.style.display = 'none';
		target1.style.display = 'none';
		target2.style.display = 'none';
		enable_emailFld.style.color = '#CC3300';
		document.getElementById('name_fld_level').style.display = 'none';
	    document.getElementById('split_first_name').style.display = 'none';
	    document.getElementById('split_last_name').style.display = 'none';
	} else if( document.listfustion_arp_form.listfusion_disply_only_email.checked == false ) {  
		var showRow = 'block'
		if ( navigator.appName.indexOf('Microsoft') == -1 && hide_one.tagName == 'TR' ) showRow = 'table-row';
		hide_one.style.display = showRow;
		enable_emailFld.style.color = '#F1F1F1';
		document.getElementById('name_fld_level').style.display = '';
		
		if( document.listfustion_arp_form.listfusion_split_name.checked == true ) {
			document.getElementById('split_first_name').style.display = '';
			document.getElementById('split_last_name').style.display = '';
			document.getElementById('name_fld_level').style.display = 'none';
			document.getElementById('first_name_tbl').style.display = '';
			document.getElementById('last_name_tbl').style.display = '';
		} else {
			document.getElementById('split_first_name').style.display = 'none';
			document.getElementById('split_last_name').style.display = 'none';
		}
		
	}
}

/*Connection API*/
(function(jQuery){
	jQuery(document).ready(function(){
		// MailChimpAPI Process							
		jQuery("#process_mailchimp_api_call").click(function() { 
			 var mailchimp_api_key = jQuery("#listfustion_mailchimp_api_key").val();
			 var type = 'mailchimp';
			 var loadingID = 'mailchimp_wait_processing';
			 var resultID = 'displayMailChimpResult';
			 listfusion_api_process(mailchimp_api_key, type, loadingID, resultID);
			 jQuery('#mailchimp_wait_processing').show();
		});
		// getResponse Process
		jQuery("#process_getResponse_api_call").click(function() { 
			 var mailchimp_api_key = jQuery("#listfustion_getResponse_api_key").val();
			 var type = 'getResponse';
			 var loadingID = 'getResponse_wait_processing';
			 var resultID = 'displaygetResponseResult';
			 listfusion_api_process(mailchimp_api_key, type, loadingID, resultID);
			 jQuery('#getResponse_wait_processing').show();
		});
		// add next
	});
	function listfusion_api_process(apikey, type, loadingID, resultID){ 
		 callajaxURL = jQuery("#listfusion_ajax_url").val();
		 fetchURL = jQuery("#apicall_listOptions").val();
		 jQuery.ajax({
				type: "post",
				url: callajaxURL,
				data: { action: 'listfusionAPI-call', 
						type: type,
						apikey: apikey, 
						loadingName: loadingID,
						resultName: resultID, 
						grabhtml: fetchURL
					  },
				success: function(data, textStatus, XMLHttpRequest){  
					var parsed = data.split(',');
					var result = parsed[0];
					var closeLoading = parsed[1];
					var displayResultOn = parsed[2];
					jQuery(closeLoading).hide();
					jQuery(displayResultOn).html(result);
					//alert(1111);
				  },  
				error: function(MLHttpRequest, textStatus, errorThrown){  
					//alert(textStatus); //alert(222);  
				}  						
		}); //close jQuery.ajax
	}
})(jQuery);

function listfusion_html_graber(processtype){ 
	 var type = 'html';
	 var resultID = 'listfustion_html_optin_form_code';
	 if( processtype == 'mailchimp' ) {  
	 	var fetchURL = jQuery("#mailchimp_listOptions").val();
		var loadingID = 'mailchimp_finalajxLoading';
		var apiextraprocess = '';
		jQuery('#mailchimp_finalajxLoading').show();
	 } else if( processtype == 'getResponse' ) {  
	 	var fetchURL = jQuery("#getResponse_listOptions").val();
		var loadingID = 'getResponse_finalajxLoading';
		var apiextraprocess = 'getResponse';
		jQuery('#getResponse_finalajxLoading').show();
	 }
	 jQuery.ajax({
			type: "post",
			url: callajaxURL,
			data: { action: 'listfusionAPI-call', 
					type: type,
					apikey: '', 
					loadingName: loadingID,
					resultName: resultID, 
					grabhtml: fetchURL, 
					extraprocess: apiextraprocess
				  },
			success: function(data, textStatus, XMLHttpRequest){  
					var parsed = data.split(',');
					var result = parsed[0];
					var closeLoading = parsed[1];
					var displayResultOn = parsed[2];
					jQuery(closeLoading).hide();
					jQuery(displayResultOn).html(result);
				//alert(data); //alert(1111);
			  },  
			error: function(MLHttpRequest, textStatus, errorThrown){  
				//alert(textStatus); //alert(222);  
			}  						
	}); //close jQuery.ajax
}
