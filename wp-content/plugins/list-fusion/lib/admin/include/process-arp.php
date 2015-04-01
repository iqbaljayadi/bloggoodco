<?php 
global $wpdb; 
	/** AUTORESPONDER PROCESS ADD/EDIT RECORDS **/
	if( $process_arp == 'Save' ) {
	
		$today = date("Y/m/d");
		
		foreach ( (array) $this->listfusion_arpPostrequest as $key => $val ) {
		   if ( $key == 'optin_html_form_code' ) $optin_html_form_code = $val;
				else if ( $key == 'optin_form_name' ) $optin_form_name = trim($val);
				else if ( $key == 'first_name_fld' ) $first_name_fld = trim($val);
				else if ( $key == 'last_name_fld' ) $last_name_fld = trim($val);
				else if ( $key == 'optin_email_fld' ) $optin_email_fld = trim($val);
				else if ( $key == 'trackcode_fld' ) $optin_trackcode_fld = trim($val);
				else if ( $key == 'optin_form_url' ) $optin_form_url = $val;
				else if ( $key == 'optin_hidden_fields' ) $optin_hidden_fields = trim($val, ','); 
				else if ( $key == 'split_name' ) $split_name = $val;
				else if ( $key == 'field_name' ) $field_name = $val;
				else if ( $key == 'field_fname' ) $field_fname = $val;
				else if ( $key == 'field_lname' ) $field_lname = $val;
				else if ( $key == 'field_email' ) $field_email = $val;
				else if ( $key == 'display_only_email' ) $display_only_email = $val;
				else if ( $key != 'arp_next_step' ) $arp_options[$key] = $this->__listfusion_escape_query($val);
		} 
				
		$split_name  = $this->listfusion_arpPostrequest['split_name'];
		if( $split_name == 1 ) $optin_name_fld  = $first_name_fld.",".$last_name_fld; 
		else $optin_name_fld = $this->listfusion_arpPostrequest['arp_name_fld'];
		
		if ( $_POST['listfustionLabelCustomFld'] != '' && $_POST['listfustionFieldCustomFld'] != '' ) {
			$listfusion_LabelCFLD = $this->__listfusion_escape_query($_POST['listfustionLabelCustomFld']);
			$listfusion_FieldCFLD = $this->__listfusion_escape_query($_POST['listfustionFieldCustomFld']);
			$listfusion_CustomFld = array_combine($listfusion_LabelCFLD, $listfusion_FieldCFLD); 
			$listfusion_CustomFld['listfusion_customfields'] = $listfusion_CustomFld;
		} else {
			$listfusion_CustomFld['listfusion_customfields'] = '';
		}

		$arp_options = array_merge($arp_options, $listfusion_CustomFld); 
		$arp_options = serialize($arp_options);
		
		// STAND ALONE
		if( $this->listfusion_arpPostrequest['connection_type'] == 3 ) {
			if( $this->listfusion_arpPostrequest['thank_you_page_url'] == '' ) $optinRedirectURL = LIST_FUSION_SITEURL;
			else $optinRedirectURL = $this->listfusion_arpPostrequest['thank_you_page_url'];
			
			$optin_html_form_code = '<form action="'.trailingslashit(LIST_FUSION_SITEURL).'" method="post">
									<input type="hidden" name="adtracking" value="">
									<input type="hidden" name="listfusionRedirectUrl" value="'.$optinRedirectURL.'">
									Your Name<input type="text" name="name" value="Your name...">
									Email<input type="text" name="email" value="Your e-mail...">
									<input type="submit" value="Subscribe">
									</form>';
			$optin_name_fld       = 'name';	
			$optin_email_fld      = 'email';					
			$optin_trackcode_fld  = 'adtracking';
			$optin_form_url       = trailingslashit(LIST_FUSION_SITEURL);
			$optin_hidden_fields  = 'adtracking';
			$split_name           = 0;
			$display_only_email   = 0;					
		 }
		// EOF STAND ALONE
		
		
		// SEND EMAIL
		if( $this->listfusion_arpPostrequest['connection_type'] == 4 ) {
			if( $this->listfusion_arpPostrequest['thank_you_page_url'] == '' ) $optinRedirectURL = LIST_FUSION_SITEURL;
			else $optinRedirectURL = $this->listfusion_arpPostrequest['thank_you_page_url'];
			
			$optin_html_form_code = '<form action="'.trailingslashit(LIST_FUSION_SITEURL).'" method="post">
									<input type="hidden" name="adtracking" value="">
									<input type="hidden" name="listfusionRedirectUrl" value="'.$optinRedirectURL.'">
									Your Name<input type="text" name="listfusion_name" value="Your name...">
									Email<input type="text" name="listfusion_email" value="Your e-mail...">
									<input type="submit" value="Subscribe">
									</form>';
			$optin_name_fld       = 'listfusion_name';	
			$optin_email_fld      = 'listfusion_email';					
			$optin_trackcode_fld  = 'adtracking';
			$optin_form_url       = trailingslashit(LIST_FUSION_SITEURL);
			$optin_hidden_fields  = 'adtracking';
			$split_name           = 0;
			$display_only_email   = 0;					
		 }
		// EOF SEND EMAIL
		
		if( isset($_GET['id']) && $_GET['action'] == 'aearp') {
		
			$db_update_query = "UPDATE $this->listfusion_arp_table SET optin_html_form_code='$optin_html_form_code', optin_form_name='$optin_form_name', optin_name_fld='$optin_name_fld', optin_email_fld='$optin_email_fld', optin_trackcode_fld='$optin_trackcode_fld', optin_form_url='$optin_form_url',  optin_hidden_fields='$optin_hidden_fields' , options='$arp_options', fld_name='$field_name', fld_fname='$field_fname', fld_lname='$field_lname', fld_email='$field_email',  split_name='$split_name' ,  display_only_email='$display_only_email' 
										WHERE id='".$_GET['id']."'";
			$wpdb->query($db_update_query);							
			echo '<script>window.location.href="'.$this->listfusion_page.'sts=2"</script>';
		
		} else {
		
			$db_insert_query = "INSERT INTO $this->listfusion_arp_table ( optin_html_form_code, optin_form_name, optin_name_fld, optin_email_fld, optin_trackcode_fld, optin_form_url, optin_hidden_fields, options, fld_name, fld_fname, fld_lname, fld_email, split_name, display_only_email, flag_aff, add_date ) 
										VALUES( '$optin_html_form_code', '$optin_form_name', '$optin_name_fld', '$optin_email_fld', '$optin_trackcode_fld', '$optin_form_url', '$optin_hidden_fields', '$arp_options', '$field_name', '$field_fname', '$field_lname', '$field_email', '$split_name', '$display_only_email', '1', '$today' )";
			$wpdb->query($db_insert_query);		
			echo '<script>window.location.href="'.$this->listfusion_page.'sts=1"</script>';
		}
		
	}
	
?>