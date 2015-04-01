<?php
/**
 * Holds necessary functions and variables
 * Copyright (c) 2014, WpSmartApps.com 
 *
 * By using the software, you agree to be bound by the terms of this license.
 * 1. You are not allowed to use this script library for creating any other software or plugin without expressed permission from us.
 * 2. The software is protected by the copyright laws of the U.S. and other countries, and we retain all intellectual property rights in the software. 
 *    You may NOT separately publish, sell, market, distribute, lend, lease, rent, modify, reverse engineer or sublicense the software code.
 * 3. You must NOT make any modification to the software without express permission from us. If there is a feature you want included or a bug you want fixed, 
 *    let us know.
*/

class ListFusionPluginPro {
	var $list_fusion_replaceclassname = 'form-table';
	var $listfusion_arp_table 	      = 'listfusion_arp';
	var $listfusion_options_table     = 'listfusion_options';
	var $listfusion_firstCommentator_table   = 'listfusion_first_commentator';
	var $listfusion_placement_table = 'listfusion_placement';
	var $listfusion_status_table  = 'listfusion_status';
	var $listfusion_insidecomment_table = 'listfusion_insidecomment';
	
	var $wordpress_listfusion_comments_table = 'comments';
	var $wordpress_listfusion_posts_table	 = 'posts';
	var $wordpress_listfusion_users_table	 = 'users';
	
	var $unique_itemSessionCount   = 0;
	var $uniquesessionCount   = 0;
	var $listfusion_uniquesessionCount = 0;
	
	var $listfusion_sqmeta_customFields = array('listfusion_squeezepage',
												'listfusion_szpg_seo_title' , 
												'listfusion_szpg_seo_meta_dec' , 
												'listfusion_szpg_seo_meta_key' , 
												'listfusion_szpg_seo_noindex' , 
												'listfusion_szpg_seo_nofollow' , 
												'listfusion_szpg_seo_noarchive' , 
												'listfusion_szpg_seo_footer_code' );

	
/****************************
**** HANDLE AUTORESPONDER ***/

	function __listfusion_arp_dataProcess(){
		global $wpdb;
		error_reporting(E_ALL ^ E_NOTICE);
		$this->listfusion_arpPostrequest   = $_POST['listfusion'];
		$process_arp = $this->listfusion_arpPostrequest['process_arp_save'];
		include('admin/include/process-arp.php');
		// Group Delete
		if( $_POST['global_arp_submit'] == 'Apply' && $_POST['global_action'] == 'trash' ) {
			if( (array) $_POST['arpchkall'] ) {
				$listOfId = implode(",", $_POST['arpchkall']);
				$sql = "DELETE from $this->listfusion_arp_table WHERE id IN (".$listOfId.")";
				$wpdb->query( $sql );
				$this->listfusion_global_message = 'Checked Autoresponder Connections Deleted Successfully';
			}
		}
		// Single Delete
		if( isset($_GET['did']) && $_GET['did'] != '' ) {
			$sql = "DELETE FROM $this->listfusion_arp_table WHERE id='".$_GET['did']."' ";
			$wpdb->query( $sql );
			$this->listfusion_global_message = 'Autoresponder Connections Deleted Successfully';
		}
		// Enable/Disable
		if( isset($_GET['arpid']) && $_GET['arpid'] != '' ) {
			if( $_GET['flag'] == 'disable' ) { 
				$flag = '0';
				$this->listfusion_global_message = 'Form Auto Filler Disabled Successfully';
			} else if( $_GET['flag'] == 'enable' ) {
				$flag = '1';
				$this->listfusion_global_message = 'Form Auto Filler Enable Successfully';
			} 
			$sql_aff_status = "UPDATE $this->listfusion_arp_table SET flag_aff='$flag' WHERE id=".$_GET['arpid'];
			$wpdb->query( $sql_aff_status );
		}
	}
	
	function __listfusion_arp_dropdown(  $arr_name, $fldname ) {  
		foreach( (array) $arr_name as $val ) {
			if( $fldname == $val ) $selected = "selected";
			else $selected = "";
			if ( trim($val) != '' ) {
				echo '<option value="'.$val.'" '. $selected.'>'.$val.'</option>';
			}
		}
		//return $option;
	}

	function __listfusion_arp(){
		global $wpdb;
		$this->__listfusion_arp_dataProcess();
		/** Process Edit Result **/
		if( $_GET['action'] == 'aearp' && isset($_GET['id']) ) {
		
			$edit_sql = "SELECT * FROM " .$this->listfusion_arp_table . " WHERE id='".$_GET['id']."'";
			$this->arp_edresult = $wpdb->get_row( $edit_sql, ARRAY_A );
			$arped_options = unserialize($this->arp_edresult['options']);
			// Connection type
			if( $arped_options['connection_type'] == 1 || $arped_options['connection_type'] == 2 ) {
				$connection_type_chk = 'checked';
				$hidden_process_html_form = 'block';
				$hidden_namefild_text = 'block';
				$hidden_custom_fld = 'block';
				$hidden_save_btm = 'block';
				$chk_if_click_process_html_form_btm = 1;
				if( $arped_options['connection_type'] == 2 ) { 
					$hidden_csv_html = 'block';
					$connection_type_chk2 = 'checked';
				} else {
					$connection_type_chk1 = 'checked';
				}
			} else if( $arped_options['connection_type'] == 3  ) {
					$connection_type_chk3 = 'checked';
					$connection_stand_alone = 'block';
					$api_connection_process_css = 'none';
					$hidden_display_html_form_code = 'none';
					$hidden_save_btm = 'block';
					$chk_if_click_process_html_form_btm = '';
					$hidden_process_html_form = 'none';
			} else if( $arped_options['connection_type'] == 4  ) {
					$connection_type_chk4 = 'checked';
					$connection_type_chk3 = 'checked';
					$connection_stand_alone = 'none';
					$send_optin_email = 'block';
					$api_connection_process_css = 'none';
					$hidden_display_html_form_code = 'none';
					$hidden_save_btm = 'block';
					$chk_if_click_process_html_form_btm = '';
					$hidden_process_html_form = 'none';
					
			}
			// new window submit
			if( $arped_options['submit_form_to_new_window'] == 1 ) $sftonewwindow = 'checked';
			// Display records on the dropDown box
			if( $this->arp_edresult['split_name'] == 1 && $this->arp_edresult['display_only_email'] != 1 ) {  
				$display_split_option = strpos($_SERVER['HTTP_USER_AGENT'],'MSIE') ? 'block' : 'table-row';
				$display_name_hide = 'none';
				$chk_split_name = 'checked';
				$name_color = '#CCCCCC';
				$disable_name_dropdown = 'disabled';
				$display_split_name_txt_color = 'rgb(255, 102, 51)';
				$namefldvalue = explode(',', $this->arp_edresult['optin_name_fld'] );
				$firstnamefld = $namefldvalue[0];
				$lastnamefld = $namefldvalue[1];
			} else if( $this->arp_edresult['split_name'] == 1 && $this->arp_edresult['display_only_email'] == 1 ) { 
				$display_split_option = 'none';
			} else { 
				$namefld = $this->arp_edresult['optin_name_fld'];
			}
			if( $this->arp_edresult['display_only_email'] == 1 ) {
				$block_name_fld = 'none';
				$display_name_hide = 'none';
				$chk_displayOnly_email = 'checked';
				$display_only_email_txt_color = 'rgb(255, 102, 51)';
			}
			$textfld = '/<input\s[^>]*type[\s]*=[\s]*[\'|"]?text["|\'|"]?[^>]*>/i';
			preg_match_all($textfld, $this->arp_edresult['optin_html_form_code'], $text_fld_matches);
			$arr_name = array();
			$arr_value = array();
			foreach ( (array) $text_fld_matches[0] as $val ) {
				$grabbed_txtfld_name = '/name=["|\']([^"]*)["|\']/i';
				preg_match_all( $grabbed_txtfld_name, $val, $names );
				$arr_name[] = $names[1][0];
			}
			$hiddenflds_arr = explode(',', $this->arp_edresult['optin_hidden_fields'] );
			
		} else {
			/** Display Records **/
			$sql_select_arp = "SELECT id,optin_form_name,options,flag_aff,add_date FROM " .$this->listfusion_arp_table . " ORDER BY id DESC";
			$listfusion_items_arpconnection = $wpdb->get_results( $sql_select_arp, ARRAY_A );
			$chk_arp_service = $wpdb->get_var( "SELECT COUNT(id) FROM " .$this->listfusion_arp_table . " ORDER BY id DESC" );
			
		}
		// Eof Process Edit Result
		echo '<div class="wrap">';
		if( $_GET['action'] == 'aearp' ) include('admin/arp-ae.php');
		else include('admin/arp.php');
		echo '</div>';
	}
	
	function __listfusionAPI_process(){  
		global $ListFusionPlugin;
		if( $_POST['type'] == 'html' ) {
			if( $_POST['extraprocess'] == 'getResponse' ) {
					
				require_once '/include/getresponse/jsonRPCClient.php';
				$apikey = get_option('getResponse_apikey');
				if ( isset($apikey) &&  $apikey != '' ) {
					$api = new jsonRPCClient('http://api2.getresponse.com');
					try {
						 $forms = $api->get_webforms($apikey);
						 foreach ((array) $forms as $k => $v) {
						 	if( $v['campaign'] == $_POST['grabhtml']  ) {
								$grabhtml = $v['url'];
								// Enhance for more record display.
							}
						 }
						$content = $ListFusionPlugin->__listfusion_htmlCall($grabhtml);
					} catch (Exception $e) {
						// Error
					}
				}
				if( $content == '' ) {
				echo 'NO ANY WEB FORM CREATED FOR THIS CAMPAIGN

Please Login to your getResponder Account and create Web Form for this
campaign. You can find CREATE WEB FORM LINK at the top of the page.'; 
				}
			} else {
				$content = $ListFusionPlugin->__listfusion_htmlCall($_POST['grabhtml']); 
			}
		} else {
			if( $_POST['apikey'] == '' ) { 
					$content = '<span style="color:red">Please Use Correct API KEY</span>';
			} else {
				// mailChimp
				if( $_POST['type'] == 'mailchimp' ) {
					require_once 'include/mailchimp/Mailchimp.php';
					$apikey = trim($_POST['apikey']);
					update_option('mailchimp_apikey', $apikey);
					
					$list = array();
					if ( isset($apikey) &&  $apikey != '' ) {
						$api = new Mailchimp($apikey);
					}	
					$retval = $api->lists->getList();	
					
					if (!$api->errorCode) {
						$content  = 'Select Your List: <select id="mailchimp_listOptions" name="">';
							foreach ((array) $retval['data'] as $v) {
										$content .= '<option value="'.$v['subscribe_url_long'].'">'.$v['name'].'</option>';
							 }
						$content .= '</select>
									 <input type="button" class="button" name="" onclick="listfusion_html_graber(\'mailchimp\')" value="Grab html Form">&nbsp;&nbsp;<img src="'. LIST_FUSION_LIBPATH .'images/spinner.gif" border="0" id="mailchimp_finalajxLoading" style="display:none;" />'; 
					}
					if (count($retval['total']) == 0) {  $content = '<span style="color:red">NO ANY RECORDS AVAILABLE</span>';  }
				
				// getResponse
				} else if( $_POST['type'] == 'getResponse' ) {
				
					require_once '/include/getresponse/jsonRPCClient.php';
					$apikey = trim($_POST['apikey']);
					update_option('getResponse_apikey', $apikey);
					
					if ( isset($apikey) &&  $apikey != '' ) {
						$api = new jsonRPCClient('http://api2.getresponse.com');
						try {
							$result = $api->get_campaigns($apikey);
							$content  = 'Select Your Campaign: <select id="getResponse_listOptions" name="">';
							foreach ((array) $result as $k => $v) {
								$content .= '<option value="'.$k.'">'.$v['name'].'</option>';
							}
							$content .= '</select>
										 <input type="button" class="button" name="" onclick="listfusion_html_graber(\'getResponse\')" value="Grab html Form">&nbsp;&nbsp;<img src="'. LIST_FUSION_LIBPATH .'images/spinner.gif" border="0" id="getResponse_finalajxLoading" style="display:none;" />'; 
							
						} catch (Exception $e) {
							// Error
						}
					}
					if (count($result) == 0) { $content = '<span style="color:red">NO ANY RECORDS AVAILABLE</span>'; }
				}
				// Eof API Connection
			}
		}
		echo $content.',#'.$_POST['loadingName'].',#'.$_POST['resultName'];
		die();	
	}
	
	function __listfusion_htmlCall ($url) {  
		$html_result = $this->__listfusion_CURL_call($url, '', '' );
		preg_match_all('/<form\b[^>]*>(.*?)<\/form>/is', $html_result, $form_result, PREG_PATTERN_ORDER);
		return ($form_result[0][0]);
	}
	
	function __listfusion_CURL_call ( $submit_url, $userpass, $params) {
		$curl = curl_init(); 
		curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC ) ; 
		curl_setopt($curl, CURLOPT_USERPWD, $userpass); 
		curl_setopt($curl, CURLOPT_SSLVERSION,3); 
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE); 
		curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 2); 
		curl_setopt($curl, CURLOPT_HEADER, false); 
		curl_setopt($curl, CURLOPT_POST, true); 
		curl_setopt($curl, CURLOPT_POSTFIELDS, $params ); 
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true); 
		curl_setopt($curl, CURLOPT_USERAGENT, "Mozilla/4.0 (compatible; MSIE 5.01; Windows NT 5.0)"); 
		curl_setopt($curl, CURLOPT_URL, $submit_url); 
		$result = curl_exec($curl);  
		curl_close($curl); 
		return $result;
	}
	
		
/*********************
**** HANDLE CSV ***/

	/** 
	* Process all .csv records
	*/
	function __listfusion_csv_process(){
		
		// csv page
		if( $_GET['type'] == 'csv' && isset($_GET['csvdel']) &&  $_GET['csvdel'] == 1 ) {
			if (file_exists($_GET['val'])) {
				unlink($_GET['val']);
				$this->listfusion_global_message = '.Csv Records Deleted';
			}
		} 
		// eof csv
		
	}
	/** 
	* Display all .csv records
	*/
	function __listfusion_csv(){
		$this->__listfusion_csv_process();
		echo '<div class="wrap">';
		include('admin/csv.php');
		echo '</div>';
	}
	/** 
	* Check folder permission
	*/
	function __listfustion_csv_chk($val){ 
		if( $val = 2 ) $folder = '/csv/backup/';
		else $folder = '/csv/';
		if( is_writable(LIST_FUSION_RELPATH.$folder) ) {
			$message = 'Folder permission: <span style="color: green;"><b>OK</b></span>';
		} else {
			$message = '<b>Folder permission: <span style="color: red;">Error</span>. Please check permission for storage folder.</b><br />';
		}
		return $message;
	}
	
	
/****************************
**** HANDLE DASHBOARD ***/

	function __listfusionDemo_process(){ 
		global $table_prefix, $wpdb;
	
		if (!is_numeric($_POST['recordID'])) {
			exit('Illegal operation. Exiting.');
		}
		
		if( $_POST['dataProcessType'] == 'imgpreview' ) {
			$listfusionType = $_POST['type'];
			if( $listfusionType == 'optinpopup' )  $img = 'optinpopup'.$_POST['recordID'];
			else if( $listfusionType == 'adpopup' )  $img = 'adpopup'.$_POST['recordID'];
			else if( $listfusionType == 'socialpopup' )  $img = 'socialpopup'.$_POST['recordID'];
			else if( $listfusionType == 'squeezepg' )  $img = 'squeezepg'.$_POST['recordID'];
			else if( $listfusionType == 'clickslideroptin' )  $img = 'optinclickslider'.$_POST['recordID'];
			else if( $listfusionType == 'clicksliderad' )  $img = 'adclickslider'.$_POST['recordID'];
			else if( $listfusionType == 'sidebaroptin' )  $img = 'sidebaroptin'.$_POST['recordID'];
			else if( $listfusionType == 'sidebarad' )  $img = 'sidebarad'.$_POST['recordID'];
			else if( $listfusionType == 'withinpostoptin' )  $img = 'withinpostoptin'.$_POST['recordID'];
			else if( $listfusionType == 'withinpostad' )  $img = 'withinpostad'.$_POST['recordID'];
			else if( $listfusionType == 'withinpostsocial' )  $img = 'withinpostsocial'.$_POST['recordID'];
			else if( $listfusionType == 'icboxoptin' )  $img = 'icboxoptin'.$_POST['recordID'];
			else if( $listfusionType == 'icboxad' )  $img = 'icboxad'.$_POST['recordID'];
			
			if( $listfusionType == 'icboxoptin' || $listfusionType == 'icboxad' ) {
				$img = '<img src="'.LIST_FUSION_LIBPATH.'images/icbox/'.$img.'.png">';
			} else if( $listfusionType == 'withinpostoptin' || $listfusionType == 'withinpostad' || $listfusionType == 'withinpostsocial' ) {
				$img = '<img src="'.LIST_FUSION_LIBPATH.'images/withinpost/'.$img.'.png">';
			} else if( $listfusionType == 'sidebaroptin' || $listfusionType == 'sidebarad'  ) {
				$img = '<img src="'.LIST_FUSION_LIBPATH.'images/sidebar/'.$img.'.png">';
			} else if( $listfusionType == 'clickslideroptin' || $listfusionType == 'clicksliderad'  ) {
				$img = '<img src="'.LIST_FUSION_LIBPATH.'images/clickslider/'.$img.'.png">';
			} else if( $listfusionType == 'squeezepg' ) {
				$img = '<img src="'.LIST_FUSION_LIBPATH.'images/squeezepg/'.$img.'.png">';
			} else {
				$img = '<img src="'.LIST_FUSION_LIBPATH.'images/popup/'.$img.'.png">';
			}
			echo $result = $img.','.$_POST['recordID'],','.$listfusionType;
			
		} else if( $_POST['dataProcessType'] == 'arpProcess' ) {
			$arpID = $_POST['recordID'];
			$listfusion_autoresponder_table = $table_prefix.'listfusion_arp';
			$sql = "SELECT optin_trackcode_fld FROM $listfusion_autoresponder_table WHERE id='$arpID'";
			$row = $wpdb->get_row( $sql, ARRAY_A );
			if ($row != null) {
				$result = $row['optin_trackcode_fld'];
				echo $result;
			} else {
			  echo 'noresult';
			}
		}
		die();	
	}
	

	function __listfusion_placement_dataProcess(){
		error_reporting(E_ALL ^ E_NOTICE);
		$this->listfusion_Postrequest = $_POST['listfusion'];
		$this->process_exitjspopup = $this->listfusion_Postrequest['process_exitjspopup_save'];
		$this->process_popup = $this->listfusion_Postrequest['process_popup_save'];
		$this->process_squeezepg = $this->listfusion_Postrequest['process_squeezepg_save'];
		$this->process_clickslider = $this->listfusion_Postrequest['process_clickslider_save'];
		$this->process_sidebar = $this->listfusion_Postrequest['process_sidebar_save'];
		$this->process_witinpost = $this->listfusion_Postrequest['process_witinbtmpost_save'];
		$this->process_icbox = $this->listfusion_Postrequest['process_icbox_save'];
		
		include('admin/include/process-placement.php');
		// Group Delete
		if( $_POST['global_placement_submit'] == 'Apply' && $_POST['global_action'] == 'trash' ) {
			$this->__listfusion_process_groupDelete($_POST['lfnchkall']);
		}
		// Single Delete
		if( isset($_GET['did']) && $_GET['did'] != '' ) {
			$this->__listfusion_process_singleDelete($_GET['did'],$this->listfusion_placement_table);
		}
		// Enable/Disable
		if( isset($_GET['pmtid']) && $_GET['pmtid'] != '' ) {
			$this->__listfusion_processEnableDisable($_GET['pmtid'], $_GET['flag']);
		}
	}


	function __listfusion_dashboard(){
		global $wpdb;
		
	    $this->__listfusion_placement_dataProcess();
		
		// Display - Exit JS PopUP, PopUp
		if( ( $_GET['action'] == 'aejsp' || 
			  $_GET['action'] == 'aesqpg' || 
			  $_GET['action'] == 'clkslider' || 
			  $_GET['action'] == 'sidebar' || 
			  $_GET['action'] == 'witinpost' || 
			  $_GET['action'] == 'icbox' || 
			  $_GET['action'] == 'aepopup' ) 
			  && isset($_GET['id']) 
		   ) {
		    // Single Item Process
			$this->__listfusion_processFusion("*", "id='".$_GET['id']."'");  
			
		// Display - dashboard	
		} else {
			if( $_GET['filter'] == 2 ) {
			$sql = "SELECT id,item_name,item_type,childid,flag,add_date,option_values
					FROM {$wpdb->prefix}listfusion_placement WHERE childid='0' AND ( item_type = 'optinpopup' OR 
																						   item_type = 'adpopup' OR 
																						   item_type = 'socialpopup' OR 
																						   item_type = 'custompopup' ) ORDER BY id DESC";
				   $this->addnew_fusion_now = 'aepopup';																			   
			} else if( $_GET['filter'] == 3 ) {
			$sql = "SELECT id,item_name,item_type,childid,flag,add_date,option_values
					FROM {$wpdb->prefix}listfusion_placement WHERE childid='0' AND ( item_type = 'squeezepg' ) ORDER BY id DESC";
				    $this->addnew_fusion_now = 'aesqpg';
																								   
			} else if( $_GET['filter'] == 4 ) {
			$sql = "SELECT id,item_name,item_type,childid,flag,add_date,option_values
					FROM {$wpdb->prefix}listfusion_placement WHERE childid='0' AND ( item_type = 'clickslideroptin' OR 
																						   item_type = 'clicksliderad' ) ORDER BY id DESC";
				    $this->addnew_fusion_now = 'clkslider';
					
			} else if( $_GET['filter'] == 5 ) {
			$sql = "SELECT id,item_name,item_type,childid,flag,add_date,option_values
					FROM {$wpdb->prefix}listfusion_placement WHERE childid='0' AND ( item_type = 'withinpostoptin' OR 
																						   item_type = 'withinpostad' OR 
																						   item_type = 'withinpostsocial' ) ORDER BY id DESC";
				    $this->addnew_fusion_now = 'witinpost';
					
			} else if( $_GET['filter'] == 6 ) {
			$sql = "SELECT id,item_name,item_type,childid,flag,add_date,option_values
					FROM {$wpdb->prefix}listfusion_placement WHERE childid='0' AND ( item_type = 'sidebaroptin' OR item_type = 'sidebarad' ) ORDER BY id DESC";
				    $this->addnew_fusion_now = 'sidebar';
					
			}  else if( $_GET['filter'] == 7 ) {
			$sql = "SELECT id,item_name,item_type,childid,flag,add_date,option_values
					FROM {$wpdb->prefix}listfusion_placement WHERE childid='0' AND ( item_type = 'exit_js_popup' ) ORDER BY id DESC";
				    $this->addnew_fusion_now = 'aejsp';
					
			}  else if( $_GET['filter'] == 8 ) {
			$sql = "SELECT id,item_name,item_type,childid,flag,add_date,option_values
					FROM {$wpdb->prefix}listfusion_placement WHERE childid='0' AND ( item_type = 'icboxoptin' OR item_type = 'icboxad' ) ORDER BY id DESC";
				    $this->addnew_fusion_now = 'icbox';
					
			} else {
			$sql = "SELECT id,item_name,item_type,childid,flag,add_date,option_values
					FROM {$wpdb->prefix}listfusion_placement WHERE childid='0' ORDER BY id DESC";
				    $this->addnew_fusion_now = 'aepopup';
					
			}		
			$listfusion_items = $wpdb->get_results( $sql );
			
			// Sum
			$sql_allrec = "SELECT SUM( CASE WHEN item_type = 'exit_js_popup' then 1 else 0 end ) as exitjspopup, 
			                      SUM( CASE WHEN 
						  			   item_type = 'optinpopup' OR 
									   item_type = 'adpopup' OR 
									   item_type = 'socialpopup' OR 
									   item_type = 'custompopup' then 1 else 0 end ) as popup, 
								  SUM( CASE WHEN item_type = 'squeezepg' then 1 else 0 end ) as squeezepg,   
								  SUM( CASE WHEN item_type = 'clickslideroptin' OR item_type = 'clicksliderad' then 1 else 0 end ) as clickslider,  
								  SUM( CASE WHEN item_type = 'sidebaroptin' OR item_type = 'sidebarad' then 1 else 0 end ) as sidebar,
								  SUM( CASE WHEN item_type = 'icboxoptin' OR item_type = 'icboxad' then 1 else 0 end ) as insidebox,
			                      SUM( CASE WHEN 
						  			   item_type = 'withinpostoptin' OR 
									   item_type = 'withinpostad' OR 
									   item_type = 'withinpostsocial' then 1 else 0 end ) as withinpost,
								  SUM( CASE WHEN flag = '1' OR flag = '0' then 1 else 0 end ) as total    
						   FROM {$wpdb->prefix}listfusion_placement ORDER BY id DESC";
			$filter = $wpdb->get_row( $sql_allrec ) or die("Invalid query: ".mysql_errno().': '.mysql_error());
		}
		
		// Check ARP Records 
		if( $_GET['action'] == 'aepopup' || $_GET['action'] == 'aesqpg' || $_GET['action'] == 'sidebar' || $_GET['action'] == 'clkslider' || $_GET['action'] == 'witinpost' || $_GET['action'] == 'icbox' ) {
			$count = $this->__listfusion_chk_arpRec();
			if( $count <= 0 ) $displayARPMessage = 1;
		}
	
		echo '<div class="wrap">';
		if( $_GET['action'] == 'aejsp' ) include('admin/exitjs-ae.php');
		else if( $_GET['action'] == 'aepopup' ) include('admin/popup-ae.php');
		else if( $_GET['action'] == 'aesqpg' ) include('admin/squeezepg-ae.php');
		else if( $_GET['action'] == 'clkslider' ) include('admin/clickslider-ae.php');
		else if( $_GET['action'] == 'sidebar' ) include('admin/sidebar-ae.php');
		else if( $_GET['action'] == 'stats' ) include('admin/stats.php');
		else if( $_GET['action'] == 'witinpost' ) include('admin/withinpost-ae.php');
		else if( $_GET['action'] == 'icbox' ) include('admin/icbox-ae.php');
		else include('admin/dashboard.php');
		echo '</div>';
	}
	
	
/*********************
**** SEND EMAIL TO FIST COMMENTATOR ***/

	function __listfusion_sendemail_dataProcess(){
		global $wpdb;
		error_reporting(E_ALL ^ E_NOTICE);
		$this->listfusion_sendEmailPostrequest   = $_POST['listfusion'];
		$process_sendEmail = $this->listfusion_sendEmailPostrequest['send_email_data_submit'];
		if( $process_sendEmail == 'Save' ) {  
			foreach ( (array) $this->listfusion_sendEmailPostrequest as $key => $val ) {
				if ( $key == 'email_from_name' ) $listfusion_from_name = $val;
				else if ( $key == 'email_from_email' ) $listfusion_from_email = $val;
				else if ( $key == 'email_subject' ) $listfusion_email_subject = $val;
				else if ( $key == 'email_content' ) $listfusion_email_content = $val;
				else if ( $key == 'send_email_active' ) $listfusion_email_send_flag = $val;
				else if ( $key == 'send_email_type' ) $listfusion_email_send_type = $val;
			}
			$chkbox_options = serialize($chkbox_options);
			$sendEmail_tempData = array(
									'listfusion_from_name' => $listfusion_from_name,
									'listfusion_from_email' => $listfusion_from_email,
									'listfusion_email_subject' => $listfusion_email_subject,
									'listfusion_email_content' => $listfusion_email_content,
									'listfusion_email_send_flag' => $listfusion_email_send_flag,
									'listfusion_email_send_type' => $listfusion_email_send_type,
									 );	
			foreach($sendEmail_tempData as $key => $val) {
				$sql = "UPDATE $this->listfusion_options_table SET option_value='$val' WHERE option_name='$key'";
				$wpdb->query( $sql );				
			}	
			$this->listfusion_global_message = 'Changes SAVED Successfully';
		}
		// Reset Stats
		if( isset($_GET['action'])  == "reset" ) {
			$sql = "UPDATE $this->listfusion_options_table SET option_value='0' WHERE option_name='listfusion_email_send_stats'";
			$wpdb->query( $sql );	
			$this->listfusion_global_message = 'Stats Has RESET Successfully';				
		}
	}	
	
	function __listfusion_send_email_to_first_commentator() {
		$this->__listfusion_sendemail_dataProcess();
		$this->__listfusion_getOptions();
		if( $this->listfusion_sentEmail_type == 1 ) $sendEmail_type1 = 'checked';
		else $sendEmail_type2 = 'checked';
		
		if( $this->listfusion_email_send_flag == 1 ) { 
			$sendemail_Enable = 'checked';
			$activeColorStats = '#33CC66';
			$activeColorStatsContent = 'Active';
		} else {
			$activeColorStats = '#D8DAD9';
			$activeColorStatsContent = 'Disable';
		}
			
		echo '<div class="wrap">';
		include('admin/include/layouts/sendemail.php');
		include('admin/send-email.php');
		echo '</div>';
	}
	
	/**
	* Getting commented blog post author details
	* @param 	int			comment id
	* @return 	array		Blog post author record
	*/
	function __listfusion_BlogAuthor($comment_id){
		global $wpdb;
		$query = "SELECT
						a.user_nicename,
						a.user_email,
						a.user_url,
						b.guid,
						a.display_name
				 FROM 
					". $this->wordpress_users_table ." a
				 INNER JOIN ". $this->wordpress_posts_table ." b ON(a.ID = b.post_author)
				 INNER JOIN ". $this->wordpress_comments_table ." c ON(b.ID = c.comment_post_ID)
				 WHERE c.comment_ID='" . $comment_id . "'";
		$rs = $wpdb->get_row( $query, ARRAY_A );
		$author_array = array();
		$author_array['user_nicename'] 	= $rs['user_nicename'];
		$author_array['user_email'] 	= $rs['user_email'];
		$author_array['user_url'] 		= $rs['user_url'];
		$author_array['display_name'] 	= $rs['display_name'];
		return $author_array;
	}
	
	/**
	* replace the template tags
	* @param 	string		email template message
	* @param 	array		author details 
	* @return 	array		repplaced message 	
	*/
	function __listfusion_emailFormat($message, $author){
		$blog_url 		= get_option('siteurl');
		$rss_feed_link	= get_option('siteurl') . '/?feed=rss2';
					
		$author_details = $this->__listfusion_BlogAuthor($author['comment_ID']);
		$l_SwapValues   = array(   "%author_name%"			=> $author_details['display_name'],
								   "%author_email%"			=> $author_details['user_email'],
								   "%commentator_name%"		=> $author['comment_author'],
								   "%commentator_email%"	=> $author['comment_author_email'],
								   "%commentator_website%"	=> $author['comment_author_url'],
								   "%blog_post_link%"		=> $author_details['user_url'],
								   "%blog_url%"				=> $blog_url,
								   "%date_short%"			=> date("n/j/Y h:i:sA"));
		// Swap out old with new
		$message = str_replace(array_keys($l_SwapValues), array_values($l_SwapValues), $message);
		return $message;		
	}	
	
	/**
	* Fetches Commentator Details row
	* 
	* @param 	int	comment id
	* @return 	array of commentator row
	*/
	function __listfusion_CommentatorDetails( $comment_id ){
		global $wpdb;
		$author_details	= array();
		$query_author = "SELECT 
								c.* 
						FROM " . $this->wordpress_comments_table . " c 
						WHERE 
							c.comment_approved = '1' 
							AND c.comment_ID=" . $comment_id . " limit 1";							
		$rs_author = $wpdb->get_row( $query_author, ARRAY_A );
		return $rs_author;		
	}
	
	/**
	* First time comment check
	*/
	function __listfusion_FirstCommentCheck( $email ) {
		global $wpdb;
		$query_check_first = "SELECT 
									COUNT(emailed_ID) 
								FROM " . 
									$this->listfusion_firstCommentator_table . " 
								WHERE 
									email='" . $email . "'";
		$count = $wpdb->get_var($query_check_first);
		return $count;
				
	}
	
	/**
	* Sends email when comment is posted is status is approved
	*
	* @param int 		comment id of posted comment
	* @param int		comment status of posted comment
	*/
	function __listfusion_SendEmail_On_StatusIsApproved( $comment_id, $comment_status ) { 
		global $wpdb;
		if ( $comment_status == 1 || $comment_status == 'approve' ){
			$mail_subject 	= $this->listfusion_sentEmail_subject;
			$from_name	  	= $this->listfusion_sentEmail_name;
			$email_content	= $this->listfusion_sentEmail_content;
			$from_email   	= $this->listfusion_sentEmail_email;
			$author_row     = $this->__listfusion_CommentatorDetails( $comment_id );
			
			$mail_headers  = "From: " . __($this->__listfusion_emailFormat($from_name, $author_row)) . " <" . $this->__listfusion_emailFormat($from_email, $author_row) . ">\n";   
			$mail_headers .= "Reply-To: ". strip_tags($this->__listfusion_emailFormat($from_email, $author_row)) . "\r\n";
			$mail_headers .= "MIME-Version: 1.0\r\n";
			$mail_headers .= 'Content-Type:text/html; charset="iso-8859-1"';
			
			$author_email   = $author_row['comment_author_email'];
			if ( $this->__listfusion_FirstCommentCheck( $author_email ) == 0 ) { 
				if (mail($author_row['comment_author_email'], $mail_subject, $this->__listfusion_emailFormat( $email_content, $author_row), $mail_headers )) { 
					$query_insert = "INSERT INTO " . $this->listfusion_firstCommentator_table . "(email) VALUE('$author_email')";
					$wpdb->query( $query_insert );
					$db_stats = "UPDATE $this->listfusion_options_table SET option_value = option_value+'1' WHERE option_name = 'listfusion_email_send_stats';";
					$wpdb->query( $db_stats );			
				}				
			}	
			
		}
	}
	
/*******
**** ADMIN HEADER ***/

	function __listfusion_admin_header() {
	?>
		<link rel="stylesheet" type="text/css" media="all" href="<?php echo LIST_FUSION_FULLPATH;?>lib/admin/css/style.css" />
		<script type="text/javascript" src="<?php echo LIST_FUSION_FULLPATH; ?>lib/js/global.js"></script>
	<?php 
	}
	
/*******
**** HANDLE NOTICE ***/

	function __listfusion_notify() { 
		global $pagenow;
		
		// update notifaction
		if ('index.php' === $pagenow ) {
		?>
		<script type="text/javascript" src="http://www.wpsmartapps.com/wsa-plugin/plugin-version/api.php?plugin=listfusion&version=<?php echo LIST_FUSION_VERSION; ?>&apgurl=<?php echo get_admin_url(); ?>"></script>		
		<?php
		}
		// eof update
		
		if( $_GET['sts'] == 1 ) { 
			$message = 'New RECORD ADDED Successfully';
		} else if( $_GET['sts'] == 2 ) { 
			$message = 'Old RECORD UPDATE Successfully';
		} else {
			$message = '';
		}
		// Autoresponder
		if( ($pagenow === 'admin.php' && $message != '') && ($_GET['page'] == 'listfusion-arp' || $_GET['page'] == 'listfusion-exit-popup') ) {  
			$this->listfusion_global_message = $message; 	
		}
	}
	
	function __listfusion_handleGLOBALmag($listfusion_global_message) { 
		if( trim($listfusion_global_message) != '' ) {  
			echo "<div id='listfustion_msg' style='display:none;background-color:#FFFFAA;  height:24px; padding:15px 20px 6px 20px; font-weight:bold; font-size:15px;'>";
			echo $listfusion_global_message;
			echo "</div>";
		}	
	}
	
	
/*******
**** INSTALL NECESSEARY DB TABLES ***/

	function __listfusion_optionData() {
		global $wpdb;
		$listfusion_optinDefaultData = array(
								// Send Email To First Commentators.
								'listfusion_from_name' => '%author_name%',
								'listfusion_from_email' => '%author_email%',
								'listfusion_email_subject' => '!!! IMPORTANT, Thank you!',
								'listfusion_email_content' => 'Hi %commentator_name%,
	
Thank you for visiting my blog (%blog_url%) and posting your comment. 

If you love my content, I highly recommend you subscribe to our 
newsletter for latest content straight to your mailbox.
 
Visit the following link to subscribe:
{{your newsletter page link goes here...}}

Please let me know if you have any questions. 
										
Take care!
										
%author_name%
%blog_url%',
								'listfusion_email_send_stats' => '0',
								'listfusion_email_send_type' => '2',
								'listfusion_email_send_flag' => '',
								
							);
		foreach( $listfusion_optinDefaultData as $key => $val ) {
			$dbInsert = "INSERT INTO {$wpdb->prefix}listfusion_options (option_name, option_value) VALUES ('$key', '$val')";	
			$wpdb->query($dbInsert);				
		}									
	}

 
	function __listfusion_arp_table() {
		global $wpdb;
		$db_table = $wpdb->get_var("SHOW TABLES LIKE '{$wpdb->prefix}listfusion_arp'");
		if ( $db_table != $wpdb->prefix.'listfusion_arp' ) {
		$create_arp_table = "CREATE TABLE {$wpdb->prefix}listfusion_arp (                                                
							 `id` int(11) NOT NULL auto_increment,                                               
							 `optin_html_form_code` text collate utf8_general_ci NOT NULL,                     
							 `optin_form_name` varchar(50) collate utf8_general_ci NOT NULL,                   
							 `optin_name_fld` varchar(50) collate utf8_general_ci NOT NULL,                    
							 `optin_email_fld` varchar(50) collate utf8_general_ci NOT NULL,                   
							 `optin_trackcode_fld` varchar(50) collate utf8_general_ci NOT NULL,               
							 `optin_form_url` text collate utf8_general_ci NOT NULL,                           
							 `optin_hidden_fields` text collate utf8_general_ci NOT NULL,   
							 `options` text collate utf8_general_ci NOT NULL, 
							 `fld_name` varchar(150) collate utf8_general_ci NOT NULL,                   
							 `fld_fname` varchar(150) collate utf8_general_ci NOT NULL,                   
							 `fld_lname` varchar(150) collate utf8_general_ci NOT NULL,    
							 `fld_email` varchar(150) collate utf8_general_ci NOT NULL,    
							 `split_name` enum('0','1') collate utf8_general_ci NOT NULL default '0',          
							 `display_only_email` enum('0','1') collate utf8_general_ci NOT NULL default '0',  
							 `flag_aff` enum('0','1') collate utf8_general_ci NOT NULL default '0',    
							 `add_date` varchar(100) collate utf8_general_ci NOT NULL,                   
							 PRIMARY KEY  (`id`)                                                          
							); 
							";
			require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );				
			dbDelta($create_arp_table);
			return true;
		}
		return false;
	}
	
	function __listfusion_options_table() {
		global $wpdb;
		$chk_exist_optintable = $wpdb->get_var("SHOW TABLES LIKE  '{$wpdb->prefix}listfusion_options'");
		if ( $chk_exist_optintable != $wpdb->prefix.'listfusion_options' ) {
			$create_options_table = "CREATE TABLE {$wpdb->prefix}listfusion_options (                                  
										   `option_name` varchar(250) collate utf8_general_ci NOT NULL,  
										   `option_value` text collate utf8_general_ci,                  
											PRIMARY KEY  (`option_name`)                                    
											);
										   ";
			require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );								   
			dbDelta($create_options_table);
			return true;
		}
		return false;
	}
	
	function __listfusion_firstCommentator_table(){
		global $wpdb;
		$rs = $wpdb->get_var("SHOW TABLES LIKE '{$wpdb->prefix}listfusion_first_commentator'");
		if ( $rs != $wpdb->prefix.'listfusion_first_commentator' ){
			$sql = "CREATE TABLE {$wpdb->prefix}listfusion_first_commentator(
						emailed_ID mediumint(9) NOT NULL AUTO_INCREMENT,
						email varchar(255) NOT NULL,
						UNIQUE KEY emailed_ID (emailed_ID),
						INDEX ( email )
					);";
			require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );				
			dbDelta($sql);
			return true;									
		}
		return false;		
	}
	
	function __listfusion_getOptions( $option_name = '' ) {
		global $wpdb;
		$sql = "SELECT option_name, option_value FROM $this->listfusion_options_table";
		if ( $option_name != '' ) $sql .= " WHERE option_name='$option_name'";
		$result = $wpdb->get_results( $sql, ARRAY_A );
		if( $result ) { 
			foreach ( $result as $row ) {
				if ( $row['option_name'] == 'listfusion_from_name' ) $this->listfusion_sentEmail_name = $row['option_value'];
				if ( $row['option_name'] == 'listfusion_from_email' ) $this->listfusion_sentEmail_email = $row['option_value'];
				if ( $row['option_name'] == 'listfusion_email_subject' ) $this->listfusion_sentEmail_subject = $row['option_value'];
				if ( $row['option_name'] == 'listfusion_email_content' ) $this->listfusion_sentEmail_content = $row['option_value'];
				if ( $row['option_name'] == 'listfusion_email_send_stats' ) $this->listfusion_sentEmail_status = $row['option_value'];
				if ( $row['option_name'] == 'listfusion_email_send_type' ) $this->listfusion_sentEmail_type = $row['option_value'];
				if ( $row['option_name'] == 'listfusion_email_send_flag' ) $this->listfusion_email_send_flag = $row['option_value'];
			}
		}	
	}
	
	function __listfusion_placement_table() {
		global $wpdb;
		$chk_placement_table = $wpdb->get_var("SHOW TABLES LIKE '{$wpdb->prefix}listfusion_placement'");
		if ( $chk_placement_table != $wpdb->prefix.'listfusion_placement' ) {
			$create_table = "CREATE TABLE {$wpdb->prefix}listfusion_placement (                                  
											   `id` int(12) NOT NULL auto_increment,                           
											   `item_name` varchar(200) collate latin1_general_ci NOT NULL,   
											   `item_type` varchar(50) collate latin1_general_ci NOT NULL,    
											   `arp_id` int(3) NOT NULL,
											   `childid` int(12) NOT NULL,
											   `option_values` text character set utf8 NOT NULL, 
											   `title` text character set utf8 NOT NULL,                  
											   `msg` text character set utf8 NOT NULL,                  
											   `custom_msg` text character set utf8 NOT NULL,                  
											   `security_note` text character set utf8 NOT NULL,   
											   `submit_txt` text character set utf8 NOT NULL,  
											   `list_points` text character set utf8 NOT NULL,                  
											   `video_code` text character set utf8 NOT NULL,                  
											   `arp_trackingcode` text character set utf8 NOT NULL, 
											   `item_close_linktext` text character set utf8 NOT NULL, 
											   `item_social_twtter_txt` text character set utf8 NOT NULL, 
											   `item_social_pinterest_txt` text character set utf8 NOT NULL, 
											   `cutelink` text character set utf8 NOT NULL, 
											   `ad_msg` text character set utf8 NOT NULL, 
											   `social_msg` text character set utf8 NOT NULL, 
											   `optin_msg` text character set utf8 NOT NULL,
											   `exit_htmljs_msg` text character set utf8 NOT NULL,
											   `custom_css_code` text character set utf8 NOT NULL,
											   `cookie` text collate latin1_general_ci NOT NULL,               
											   `checkincount` int(11) collate utf8_general_ci NOT NULL,  
											   `flag` enum('0','1') collate latin1_general_ci NOT NULL, 
											   `add_date` varchar(100) collate utf8_general_ci NOT NULL,                      
											    PRIMARY KEY  (`id`)  
											);
										   ";
			require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );				
			dbDelta($create_table);
			return true;
		}
		return false;
	}
	
	function __listfusion_stats_table(){
		global $wpdb;
		$db_table = $wpdb->get_var("SHOW TABLES LIKE '{$wpdb->prefix}listfusion_status'");
		if ( $db_table != $wpdb->prefix.'listfusion_status' ) {
		$create_stats_table = "CREATE TABLE {$wpdb->prefix}listfusion_status (                                                
										 `id` int(11) NOT NULL auto_increment,                                               
										 `listfusionID` int(11) collate utf8_general_ci NOT NULL,   
										 `impressions` varchar(50) collate utf8_general_ci NOT NULL,    
										 `click` varchar(50) collate utf8_general_ci NOT NULL,       
										 `now_date` DATE collate utf8_general_ci NOT NULL,
										 `year` YEAR collate utf8_general_ci NOT NULL,
										 PRIMARY KEY  (`id`)                                                          
										); 
										";
			require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );				
			dbDelta($create_stats_table);
			return true;
		}
		return false;
	}
	
	
	function __listfusion_insidecomment_table(){
		global $wpdb;
		$db_table = $wpdb->get_var("SHOW TABLES LIKE '{$wpdb->prefix}listfusion_insidecomment'");
		if ( $db_table != $wpdb->prefix.'listfusion_insidecomment' ) {
		$create_insidecomment_table = "CREATE TABLE {$wpdb->prefix}listfusion_insidecomment (                                  
										`id` int(11) NOT NULL AUTO_INCREMENT,
										`email` varchar(255) NOT NULL,
										`embeded` int(11) NULL,
										`original_comment` int(11) NULL,
										PRIMARY KEY(`id`)
											);
										   ";
			require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );				
			dbDelta($create_insidecomment_table);
			return true;
		}
		return false;
	}
	
/*************************
**** PROCESS DB RECORDS **
**************************/
	// Single ITEM DB PROCESS
	function __listfusion_processFusion($fields, $where) {
		global $wpdb;
		$sql = "SELECT $fields FROM " .$this->listfusion_placement_table . " WHERE ".$where." ";
		$singleresult =  $wpdb->get_row( $sql );
		if( $singleresult != null ) {
			$this->process_dec_options = unserialize($singleresult->option_values);
			//print_r( $this->process_dec_options );
			// Extract all values
			$this->listfusionShow_placement_name = $singleresult->item_name;  
			$this->listfusionShow_placement_item_type = $singleresult->item_type;   
			$this->listfusionShow_placement_arp_id = $singleresult->arp_id;   
			$this->listfusionShow_placement_childid = $singleresult->childid;  
			$this->listfusionShow_placement_title = $singleresult->title;  
			$this->listfusionShow_placement_msg = $singleresult->msg;  
			$this->listfusionShow_placement_custom_msg = $singleresult->custom_msg;  
			$this->listfusionShow_placement_security_note = $singleresult->security_note;   
			$this->listfusionShow_placement_submit_txt = $singleresult->submit_txt;   
			$this->listfusionShow_placement_list_points = unserialize($singleresult->list_points);
			$this->listfusionShow_placement_video_code = $singleresult->video_code;    
			$this->listfusionShow_placement_arp_trackingcode = $singleresult->arp_trackingcode;    
			$this->listfusionShow_placement_item_close_linktext = $singleresult->item_close_linktext;   
			$this->listfusionShow_placement_item_social_twtter_txt = $singleresult->item_social_twtter_txt;   
			$this->listfusionShow_placement_item_social_pinterest_txt = $singleresult->item_social_pinterest_txt;  
			$this->listfusionShow_placement_cutelink = $singleresult->cutelink;  
			$this->listfusionShow_placement_admsg = $singleresult->ad_msg;   
			$this->listfusionShow_placement_socialmsg = $singleresult->social_msg;  
			$this->listfusionShow_placement_optinmsg = $singleresult->optin_msg;  
			$this->listfusionShow_placement_exit_htmljs_msg = $singleresult->exit_htmljs_msg;  
			$this->listfusionShow_placement_custom_css_code = $singleresult->custom_css_code; 
			// Option Value - Process 
			$this->listfusionShow_placement_ejs_redirectURL = $this->process_dec_options['exitjspopup_redirectURL'];
			// Check tracking code
			$trackingARP = $this->__listfusion_fetchARPData( $this->listfusionShow_placement_arp_id );
			if( $trackingARP == 'None' || $trackingARP == ''   ) {
				$this->listfusionShow_TrackingFldSH = 'none';  
			} else {  
				$this->listfusionShow_TrackingFldSH = 'block';
			}
			// Where to add records ?
			if( $this->process_dec_options['display_in_all'] == 'all' ) $this->listfusionShow_in_all = 'checked';
			if( $this->process_dec_options['display_in_home'] == 'home' ) $this->listfusionShow_in_home = 'checked';
			if( $this->process_dec_options['display_in_front'] == 'frontpg' ) $this->listfusionShow_in_front = 'checked';
			if( $this->process_dec_options['display_in_post'] == 'post' ) $this->listfusionShow_in_post = 'checked';	
			if( $this->process_dec_options['display_in_archive'] == 'arch' ) $this->listfusionShow_in_arch = 'checked';	
			if( $this->process_dec_options['display_in_search'] == 'search' ) $this->listfusionShow_in_search = 'checked';	
			if( $this->process_dec_options['display_in_other'] == 'other' ) $this->listfusionShow_in_other = 'checked'; 
			$this->listfusionShow_showOnPostWithID = $this->process_dec_options['showOnPostWithID']; 
			$this->listfusionShow_dontShowOnPostWithID = $this->process_dec_options['dontShowOnPostWithID']; 
			$this->listfusionShow_display_in_pageid = $this->process_dec_options['display_in_pageid']; 
			$this->listfusionShow_display_catIn = $this->process_dec_options['display_catIn']; 
			$this->listfusionShow_display_in_cat = $this->process_dec_options['display_in_cat']; 
		} else {
			return 'null'; 
		}
	}
	
	function __listfusion_processEnableDisable($id, $getflag) {
		global $wpdb;
		if( $getflag == 'disable' ) { 
			$flag = '0';
			$this->listfusion_global_message = 'Record Disable Successfully';
		} else if( $getflag == 'enable' ) {
			$flag = '1';
			$this->listfusion_global_message = 'Record Enable Successfully';
		} 
		$sql_aff_status = "UPDATE $this->listfusion_placement_table SET flag='$flag' WHERE id=".$id;
		$wpdb->query( $sql_aff_status );
	}
	
	function __listfusion_process_groupDelete($post_delall){
		global $wpdb;
		if( (array) $post_delall ) {
			$listOfId = implode(",", $post_delall);
			$sql_childIds = "SELECT GROUP_CONCAT(id) as childID FROM $this->listfusion_placement_table WHERE childid IN (".$listOfId.") ";
			$ChildIDS = $wpdb->get_var($sql_childIds);
			if( isset($ChildIDS) &&  $ChildIDS != '' ) { 
				$del_child_stats_sql = "DELETE from $this->listfusion_status_table WHERE listfusionID IN (".$ChildIDS.")";
				$wpdb->query( $del_child_stats_sql );
			}
			$sql = "DELETE from $this->listfusion_placement_table WHERE id IN (".$listOfId.") OR childid IN (".$listOfId.") ";
			$wpdb->query( $sql );
			$sql_stats_del = "DELETE FROM $this->listfusion_status_table WHERE listfusionID IN (".$listOfId.")"; 
			$wpdb->query( $sql_stats_del );
			$this->listfusion_global_message = 'Checked Records Deleted Successfully';
		}
	}
	
	function __listfusion_process_singleDelete($id,$table){  
		global $wpdb;
		$sql_childIds = "SELECT GROUP_CONCAT(id) as childID FROM $table WHERE childid='".$id."' ";
		$ChildIDS = $wpdb->get_var($sql_childIds);
		if( isset($ChildIDS) &&  $ChildIDS != '' ) { 
			$del_child_stats_sql = "DELETE from $this->listfusion_status_table WHERE listfusionID IN (".$ChildIDS.")";
			$wpdb->query( $del_child_stats_sql );
		}
		$sql_stats_del = "DELETE FROM $this->listfusion_status_table WHERE listfusionID='$id'";
		$wpdb->query( $sql_stats_del );
		$root_sql = "DELETE FROM $table WHERE id='".$id."' OR childid='".$id."' ";
		$wpdb->query( $root_sql );
		$this->listfusion_global_message = 'Record Deleted Successfully';
	}
	
	function __listfusion_chk_arpRec(){
		global $wpdb;
		$sql = "SELECT COUNT(*) as count FROM $this->listfusion_arp_table GROUP BY id";
		$rs = $wpdb->get_var($sql);
		return $record = $rs;
	}
	
	/**
	 * Autoresponder Combo Box
	 */
	function __listfusion_autoresponderComboBox( $objName, $initSel=NULL, $ddwnID, $responseBkSpan, $arpSplitName, $arpOnlyName, $arpOnlyEmail, $arpTrackingCode ){
		global $wpdb;
		$db_autoresponder_name = "select id,optin_form_name from $this->listfusion_arp_table order by id DESC";
		
		$listfusion_items_combobox = $wpdb->get_results( $db_autoresponder_name, ARRAY_A );
		if( $listfusion_items_combobox ) { 
			$combo = "<select name=\"".$objName."\" onchange=\"listfusion_demo_graber('arpProcess', this.value, '".LIST_FUSION_ADMIN_URL."', '')\" id=\"".$ddwnID."\" style=\"padding:5px 0 5px 4px;width:340px; height:30px; background-color: #F1F1F1;
		border-color: #CCCCCC; border-style: solid; border-width: 1px;\"> <option value='0'>---- Select your autoresponder service ----</option>";
			foreach ( $listfusion_items_combobox as $arr ) {
					$arp[]= array( 'id'=>$arr['id'], 'optin_form_name'=>$arr['optin_form_name'] );
			}
			foreach($arp as $key => $val){
				$combo .= "<option value='".$val['id']."'".($initSel==$val['id']?' SELECTED':' '). ">".$val['optin_form_name']."</option>";
			}
			$combo .="</select>";
			echo $combo;
		} else {
			echo $combo = "<select name=\"".$objName."\" onchange=\"listfusion_demo_graber('arpProcess', this.value, '".LIST_FUSION_ADMIN_URL."', '')\" id=\"".$ddwnID."\" style=\"padding:5px 0 5px 4px;width:340px; height:30px; background-color: #F1F1F1;
		border-color: #CCCCCC; border-style: solid; border-width: 1px;\"> <option value='0'>---- Select your autoresponder service ----</option></select>";
			echo '<div style="font-size:x-small; padding-top:5px; color:#FF0000; vertical-align:top;"><b>&nbsp;&nbsp;ALERT:: No ANY Autoresponder Service ADDED Yet, <a href="'.$this->listfusion_special_red_page.'page=listfusion-arp&action=aearp" style="text-decoration:none;color:#0C26FF;">Go Add Now</a></b></div>';
			$this->no_autoCombBox = '1';
		}
	}
	
	/**
	 * Get autoresponder Split, Only Email Data
	 */
	function __listfusion_fetchARPData ( $arpID ) {
		global $wpdb;
		$sql = "SELECT optin_trackcode_fld FROM $this->listfusion_arp_table WHERE id='$arpID'";
		$row = $wpdb->get_row( $sql, ARRAY_A );
		if ($row != null) {
		    $result = $row['optin_trackcode_fld'];
			return  $result;
		} 
	}
	
	
/*************
* EXTRA FUNCTIONS 
**************/

	/**
	 * Remove Special Character
	 */
	function __listfusion_escape_query($str) {
		if( is_array($str) ) {
			
			foreach ( (array) $str as $key => $val ) {
				 $key = $this->__listfusion_escape_query($key);
				 $options[$key] = $this->__listfusion_escape_query($val);
			}
			return $options;
			
		} else {
			return strtr($str, array(
				"'"  => "&#39;",
				"\"" => "&#34;",
				"\\" => "&#92;",
				// more secure
				"<"  => "&lt;",
				">"  => "&gt;",
			));
		}	
	}
	
	function __listfusion_reverse_escape_query($str) { 
		return strtr($str, array(
			"&#92;" => "\&nbsp;",
		));
	}	
	function __listfusion_remove_space($str) {  
		return strtr($str, array(
			"&nbsp;" => "",
		));
	}	
	function __listfusion_op_option_filter($value)
	{ 
		$value = is_array($value) ?
					array_map(array($this, '__listfusion_op_option_filter'), $value) :
					stripslashes($this->__listfusion_remove_space($this->__listfusion_reverse_escape_query($value)));
		return $value;
	}
	
/*************************
**** PROCESS RESULTS **
**************************/

	function __listfusionRstStats_process(){ 
		global $wpdb;
		$id     = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_SPECIAL_CHARS);
		$nonce  = filter_input(INPUT_GET, 'nonce', FILTER_SANITIZE_SPECIAL_CHARS);
	 
		if (!is_numeric($id )) exit('Illegal operation. Exiting.');
		if ( ! wp_verify_nonce( $nonce, 'listfusion-smartdailystats' ) ) die( 'Security ALERT' ); 
		
		global $table_prefix;
		$tablename = $table_prefix.'listfusion_status';
		$checkImp = $wpdb->get_var("SELECT COUNT(id) FROM $this->listfusion_status_table WHERE listfusionID='$id' and now_date=CURDATE()");
		if( $checkImp > 0  ) {
			$wpdb->query("UPDATE $this->listfusion_status_table SET impressions=impressions+1 WHERE listfusionID='$id' and now_date=CURDATE() ");
		} else {
			$update = "INSERT INTO $this->listfusion_status_table ( listfusionID, impressions, now_date, year ) VALUES( $id, '1', CURDATE(), YEAR(NOW()) )" ; 
			$wpdb->query($update);
		}
		
		die();	
	}
	
	function __listfusion_analytics_call() {
		global $wpdb;
		$today = trim(date('Y-m-j'));
		$id     = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_SPECIAL_CHARS);
		$nonce  = filter_input(INPUT_POST, 'nonce', FILTER_SANITIZE_SPECIAL_CHARS);
		
		if (!is_numeric($id)) exit('Illegal operation. Exiting.');
		if ( ! wp_verify_nonce( $nonce, 'listfusion-click-nonce' ) ) die('Security ALERT');

		// get the submitted parameters
		global $table_prefix;
		$tablename = $table_prefix.'listfusion_status';
		$db_Update_sql = "UPDATE $tablename SET click=click+1 WHERE listfusionID='$id' and now_date=CURDATE() ";
		$wpdb->query($db_Update_sql);
		
		die();	
	}
	
/*************************
**** PROCESS EXIT JS POPUP ***
**************************/

	function __listfusionRst_exitJSPopup(){
		global $wpdb;
		$exitjspopup_rs = " SELECT * FROM $this->listfusion_placement_table where ( item_type='exit_js_popup' ) AND childid='0' AND flag='1' ";
		$listfusion_items_exitjspopup = $wpdb->get_results( $exitjspopup_rs, ARRAY_A );
		
		if( $listfusion_items_exitjspopup ) { 
			foreach ( $listfusion_items_exitjspopup as $exitJSPopUp_row ) {

				$new_exitJSPopUp_id = $exitJSPopUp_row['id']; 
				$new_exitJSPopUp_options = unserialize($exitJSPopUp_row['option_values']);
				$new_exitJSPopUp_bodymsg = $exitJSPopUp_row['msg'];
				$new_exitJSPopUp_bodymsg = str_replace("\n", '\n', $new_exitJSPopUp_bodymsg);
				$new_exitJSPopUp_bodymsg = str_replace("\r", "", $new_exitJSPopUp_bodymsg);
				// Filter
				$displayin_all = $new_exitJSPopUp_options['display_in_all'];
				$displayin_frontpg = $new_exitJSPopUp_options['display_in_front'];
				$displayin_home = $new_exitJSPopUp_options['display_in_home'];
				$displayin_post = $new_exitJSPopUp_options['display_in_post'];
				$displayin_archive = $new_exitJSPopUp_options['display_in_archive'];
				$displayin_search = $new_exitJSPopUp_options['display_in_search'];
				$displayin_other = $new_exitJSPopUp_options['display_in_other'];
				$displayin_showInPostId = $new_exitJSPopUp_options['showOnPostWithID'];
				$displayin_dntshowInPostId = $new_exitJSPopUp_options['dontShowOnPostWithID'];
				$displayin_pageID = $new_exitJSPopUp_options['display_in_pageid'];
				$displayin_CatIn = $new_exitJSPopUp_options['display_catIn'];
				$displayin_cat = $new_exitJSPopUp_options['display_in_cat'];
				$nonce = wp_create_nonce( 'listfusion-smartdailystats' );
				// IMP :: Check where to display exit popup
				$display_exitJSPopUp_ON = $this->listfusion_show_resultON($displayin_all, $displayin_frontpg, $displayin_home, $displayin_post, $displayin_archive, $displayin_search, $displayin_other, $displayin_showInPostId,  $displayin_dntshowInPostId, $displayin_pageID, $displayin_CatIn, $displayin_cat);
				
				if( $display_exitJSPopUp_ON == true ) {
				?>
<script>
<?php 
echo 'var popmsg = "' . trim($new_exitJSPopUp_bodymsg) . '";' . "\n";
echo 'var redirectURL = "'. htmlspecialchars_decode( $new_exitJSPopUp_options['exitjspopup_redirectURL'], $single = true ) . '";' . "\n";
?>					
function addLoadEvent(func) { var oldonload = window.onload; if (typeof window.onload != 'function') { window.onload = func; } else { window.onload = function() { if (oldonload) { oldonload(); }  func(); }}}
function addClickEvent(a,i,func) { if (typeof a[i].onclick != 'function') { a[i].onclick = func; } }
var theDiv = '<div id="PopupExitDiv"  style="display:block; width:100%; height:100%; position:absolute; background:#FFFFFF; margin-top:0px; margin-left:0px;" align="center">';
theDiv = theDiv + '<iframe src="'+redirectURL+'" width="100%" height="100%" align="middle" frameborder="0"></iframe>';
theDiv = theDiv + '<img src="<?php echo LIST_FUSION_ADMIN_URL.'?action=listfusionRstStats&id='.$new_exitJSPopUp_id.'&nonce='.$nonce.''; ?>">';
theDiv = theDiv + '</div>';
theBody = document.body; if (!theBody) {theBody = document.getElementById("body"); if (!theBody) {theBody = document.getElementsByTagName("body")[0];}}
var StopPop = false;
function ShowPopup(){ if(StopPop == false){ window.scrollTo(0,0);  StopPop=true; divtag = document.createElement("div"); divtag.setAttribute("id","PopupContainer"); divtag.style.position="absolute"; divtag.style.width="100%"; divtag.style.height="100%"; divtag.style.zIndex="99"; divtag.style.left="0px"; divtag.style.top="0px"; divtag.innerHTML=theDiv; theBody.innerHTML=""; theBody.topMargin="0px"; theBody.rightMargin="0px"; theBody.bottomMargin="0px"; theBody.leftMargin="0px"; theBody.style.overflow="hidden"; theBody.appendChild(divtag);
	if (/Firefox[\/\s](\d+\.\d+)/.test(navigator.userAgent)) {
		var ffversion=new Number(RegExp.$1);
		if (ffversion>=6) return(popmsg);
	} else {
	return popmsg;
	}
} }
var a = document.getElementsByTagName('A'); for (var i = 0; i < a.length; i++) { if(a[i].target !== '_blank') {addClickEvent(a,i, function(){ StopPop=true; });} else{addClickEvent(a,i, function(){ StopPop=false;});}}disablelinksfunc = function(){var a = document.getElementsByTagName('A'); for (var i = 0; i < a.length; i++) { if(a[i].target !== '_blank') {addClickEvent(a,i, function(){ StopPop=true; });} else{addClickEvent(a,i, function(){ StopPop=false;});}}}
addLoadEvent(disablelinksfunc);
 var f = document.getElementsByTagName('FORM'); for (var i=0;i<f.length;i++){ if (!f[i].onclick){ f[i].onclick=function(){ StopPop=true; } }else if (!f[i].onsubmit){ f[i].onsubmit=function(){ StopPop=true; }}}
disableformsfunc = function(){ var f = document.getElementsByTagName('FORM'); for (var i=0;i<f.length;i++){ if (!f[i].onclick){ f[i].onclick=function(){ StopPop=true; } }else if (!f[i].onsubmit){ f[i].onsubmit=function(){ StopPop=true; }}}}
addLoadEvent(disableformsfunc);
window.onbeforeunload = ShowPopup;
</script>
					<?php 
				}
			
					  
			}
		}			  
	}
	
	
	function __listfusion_dashboard_ext($item_type) {
			if( $item_type == "optinpopup" ) {
				$this->type = 'popup'; 
				$this->fusionColor = '#2EA2CC';
				$this->edit_action = 'aepopup';
				$this->split_display = 1;
				$this->campaign = 'Opt-in';
			} else if( $item_type == "adpopup" ) {
				$this->type = 'popup'; 
				$this->fusionColor = '#2EA2CC';
				$this->edit_action = 'aepopup';
				$this->split_display = 1;
				$this->campaign = 'Ad';
			} else if( $item_type == "socialpopup" ) {
				$this->type = 'popup'; 
				$this->fusionColor = '#2EA2CC';
				$this->edit_action = 'aepopup';
				$this->split_display = 1;
				$this->campaign = 'Social';
			} else if( $item_type == "custompopup" ) {
				$this->type = 'popup'; 
				$this->fusionColor = '#2EA2CC';
				$this->edit_action = 'aepopup';
				$this->split_display = 1;
				$this->campaign = 'Custom';
			} else if( $item_type == "exit_js_popup" ) { 
				$this->type = 'exit js popup'; 
				$this->fusionColor = '#EB9809';
				$this->edit_action = 'aejsp';
				$this->campaign = 'JS Alert';
			} else if( $item_type == "squeezepg" ) {
				$this->type = 'squeeze pg'; 
				$this->fusionColor = '#77B22A';
				$this->edit_action = 'aesqpg';
				$this->split_display = 1;
				$this->campaign = 'Opt-in';
			} else if( $item_type == "clickslideroptin" ) {
				$this->type = 'click slider'; 
				$this->fusionColor = '#20998A';
				$this->edit_action = 'clkslider';
				$this->split_display = 1;
				$this->campaign = 'Opt-in';
			} else if( $item_type == "clicksliderad" ) {
				$this->type = 'click slider'; 
				$this->fusionColor = '#20998A';
				$this->edit_action = 'clkslider';
				$this->split_display = 1;
				$this->campaign = 'Ad';
			} else if( $item_type == "sidebaroptin" ) {
				$this->type = 'sidebar'; 
				$this->fusionColor = '#C844CE';
				$this->edit_action = 'sidebar';
				$this->split_display = 1;
				$this->campaign = 'Opt-in';
			} else if( $item_type == "sidebarad" ) {
				$this->type = 'sidebar'; 
				$this->fusionColor = '#C844CE';
				$this->edit_action = 'sidebar';
				$this->split_display = 1;
				$this->campaign = 'Ad';
			} else if( $item_type == "withinpostoptin" ) {
				$this->type = 'within post'; 
				$this->fusionColor = '#B80606';
				$this->edit_action = 'witinpost';
				$this->split_display = 1;
				$this->campaign = 'Opt-in';
			} else if( $item_type == "withinpostad" ) {
				$this->type = 'within post'; 
				$this->fusionColor = '#B80606';
				$this->edit_action = 'witinpost';
				$this->split_display = 1;
				$this->campaign = 'Ad';
			} else if( $item_type == "withinpostsocial" ) {
				$this->type = 'within post'; 
				$this->fusionColor = '#B80606';
				$this->edit_action = 'witinpost';
				$this->split_display = 1;
				$this->campaign = 'Social';
			} else if( $item_type == "icboxoptin" ) {
				$this->type = 'Inside cmt'; 
				$this->fusionColor = '#302424';
				$this->edit_action = 'icbox';
				$this->split_display = 2;
				$this->campaign = 'Opt-in';
			} else if( $item_type == "icboxad" ) {
				$this->type = 'Inside cmt'; 
				$this->fusionColor = '#302424';
				$this->edit_action = 'icbox';
				$this->split_display = 2;
				$this->campaign = 'Ad';
			}
	}
	
	
/**********************
*** USER- ARP FORM PROCESS
***********************/	

	function __listfusion_arpForm( $arpID, $fldClassName = "", $fldClassEmail = "", $submitClass = "", $type, $clickCountID, $DontShowMeAfterSubCOOKIE = "", $blockDays, $setcookieInfo, $emailFldIDname ) { 
		global $wpdb;
	
		$query = "SELECT * FROM $this->listfusion_arp_table WHERE id='$arpID'";
		$row = $wpdb->get_row( $query, ARRAY_A );
		
		if( trim($row['optin_trackcode_fld']) != 'None'  ) {
			$arpTrackingCode = $row['optin_trackcode_fld'];
		}
		$splitName = $row['split_name'];
		$displayOnlyEmail  = $row['display_only_email'];
		if( $splitName == 1 ) {
			$explodeSplitName  = explode( ',', $row['optin_name_fld'] );
			$firstFieldName = trim($explodeSplitName[0]);
			$lastFieldName  = trim($explodeSplitName[1]);
		} else {
			$nameFieldName  = trim($row['optin_name_fld']);
		}
		// Get form tag
		$pattern = '/<form\s[^>]*action[\s]*=[\s]*[\'|"](.*?)[\'|"][^>]*>/i';
		preg_match($pattern, $row['optin_html_form_code'], $form_tag_matches);
		$form_action = $form_tag_matches[1];
		// Get hidden fields
		$pattern = '/<input\s[^>]*type[\s]*=[\s]*[\'|"]?hidden["|\'|"]?[^>]*>/i';
		preg_match_all($pattern, $row['optin_html_form_code'], $hidden_fld_matches);
		foreach ( (array) $hidden_fld_matches[0] as $val ) {
			if ( strpos( $val, $arpTrackingCode ) !== false ) {
				$hidden_flds .= '<input type="hidden" name="'.$arpTrackingCode.'" value="'.$this->template_TrackingCode.'">';
			} else {
				$hidden_flds .= $val;
			}
		}
		
		// submit form
		$add_arp_option = unserialize($row['options']);
		//print_r($add_arp_option);
		if( $add_arp_option['submit_form_to_new_window'] == 1 && $add_arp_option['connection_type'] != 3 ) {
			$optin_form_redirect_new_window = 'target="_blank"';
		}
		// eof submit form
		if( $this->replace_form_output == 1 ) {
			if( $setcookieInfo == 'true' ) $setCookieOrNot = 1;
			else $setCookieOrNot = 2;
			$aplbpop_optin_form .= '<form action="'.trim($form_action).'" method="post" '.$optin_form_redirect_new_window.' onsubmit="return listfusion_checkForValidEmail(\''.$this->template_data_sessionID.'\')" >';
		} else {
			$aplbpop_optin_form .= '<form action="'.trim($form_action).'" method="post" '.$optin_form_redirect_new_window.' >';
		}
		
		$aplbpop_optin_form .= $hidden_flds;
		
		if( $displayOnlyEmail == 1 ) {
			// Email Field
			$aplbpop_optin_form .= '<input type="text" class="'.$fldClassEmail.'" name="'.trim($row['optin_email_fld']).'" id="'.$emailFldIDname.'" value="'.$row['fld_email'].'" onfocus="if (this.value == \''.$row['fld_email'].'\') {this.value = \'\';}" onblur="if (this.value == \'\') {this.value = \''.$row['fld_email'].'\';}">';
		} else {
			// Split Name Field
			if( $splitName == 1 && $type == 1 ) { 
				$aplbpop_optin_form .= '<input type="text" class="'.$fldClassName.'" name="'.$firstFieldName.'" id="'.'firstNameItem'.$clickCountID.'" value="'.$row['fld_fname'].'" onfocus="if (this.value == \''.$row['fld_fname'].'\') {this.value = \'\';}" onblur="if (this.value == \'\') {this.value = \''.$row['fld_fname'].'\';}">';
				
				$aplbpop_optin_form .= '<input type="text" class="'.$fldClassName.'" name="'.$lastFieldName.'" id="'.'lastNameItem'.$clickCountID.'" value="'.$row['fld_lname'].'" onfocus="if (this.value == \''.$row['fld_lname'].'\') {this.value = \'\';}" onblur="if (this.value == \'\') {this.value = \''.$row['fld_lname'].'\';}">';
			// Name Field	
			} else if( $splitName == 1 && $type == 2 ) {
				echo '<em><p class="security" style="font-size:x-small;"><font color="#fff">Split Name does not work on this theme, So please select another
template or autoresponder service which is not commanded to split Name into First and Last </font></p></em>';
			} else if( $type == 1 || $type == 2 ) { 
				$aplbpop_optin_form .= '<input type="text" class="'.$fldClassName.'" name="'.$nameFieldName.'" id="'.'nameItem'.$clickCountID.'" value="'.$row['fld_name'].'" onfocus="if (this.value == \''.$row['fld_name'].'\') {this.value = \'\';}" onblur="if (this.value == \'\') {this.value = \''.$row['fld_name'].'\';}">';
			}
			// Email Field
			$aplbpop_optin_form .= '<input type="text" class="'.$fldClassEmail.'" name="'.trim($row['optin_email_fld']).'"  id="'.$emailFldIDname.'" value="'.$row['fld_email'].'" onfocus="if (this.value == \''.$row['fld_email'].'\') {this.value = \'\';}" onblur="if (this.value == \'\') {this.value = \''.$row['fld_email'].'\';}">';
		} // Eof only Email
		
		// store .csv
		if( $add_arp_option['connection_type'] == 3 ) {
			$aplbpop_optin_form .= '<input type="hidden" value="'.$clickCountID.'" name="item" />';
		}
		
		// send email to..
		if( $add_arp_option['connection_type'] == 4 ) {
			$aplbpop_optin_form .= '<input type="hidden" value="'.$clickCountID.'" name="listfusion_item" />';
			$aplbpop_optin_form .= '<input type="hidden" value="'.$arpID.'" name="listfusion_arp" />';
		}
		
		// Extra fields	
		if( $add_arp_option['connection_type'] != 3 ) {
			$custom_fields = unserialize($row['options']);
			foreach( (array) $custom_fields['listfusion_customfields'] as $key => $val ) {
				if( $key != '' && $val != '' ) {
				$aplbpop_optin_form .= '<input type="text" class="'.$fldClassName.'" name="'.$val.'" id="'.'extrapop'.$clickCountID.'" value="'. $this->__listfusion_op_option_filter($key).'" onfocus="if (this.value == \''. $this->__listfusion_op_option_filter($key).'\') {this.value = \'\';}" onblur="if (this.value == \'\') {this.value = \''. $this->__listfusion_op_option_filter($key).'\';}">';
				}						   
			}
		}				
		// Eof Extra fields
		
		if( $this->replace_form_output != 1 ) $submitIDNAME = "listfusion-submit-btn";			
		
		// Submit Button
		$aplbpop_optin_form .= '<input type="submit" id="'.$submitIDNAME.'" class="'.$submitClass.'" value="'.$this->template_submit_btm_txt.'" />';
		$aplbpop_optin_form .= '</form>';
		
		if( $this->template_return_formdata == 1 ) {
			return $aplbpop_optin_form;
		} else { 
			echo $aplbpop_optin_form;
		}
	}
	
/****************
**** COOKIE SET
*****************/

	function __listfusion_UpgradeCount() {
		global $wpdb;
		//error_reporting(E_ALL ^ E_NOTICE);
		$query = "SELECT id,item_name,arp_id,cookie FROM $this->listfusion_placement_table WHERE flag='1'";
		$listfusion_item_upgrade_count = $wpdb->get_results( $query, ARRAY_A );
		if( $listfusion_item_upgrade_count ) { 
			foreach ( $listfusion_item_upgrade_count as $row ) {
				$cookieName = unserialize($row['cookie']);
				$clickIDName = trim($cookieName['clickIDName']);
				if( isset($_COOKIE[$clickIDName]) ) {
					$today = trim(date('Y-m-j'));  // Day - Month - Year
					$id = $_COOKIE[$clickIDName];
					$db_Update_sql = "UPDATE $this->listfusion_status_table SET click=click+1 WHERE listfusionID='$id' and now_date=CURDATE() ";
					$wpdb->query( $db_Update_sql );
					// csv
					$csvCookieName = 'itemcsv-'.$row['id'];
					if( isset($_COOKIE[$csvCookieName]) ) {
						$filename = 'listfusion-'.$row['item_name'].'.csv';
						$csvData = $_COOKIE[$csvCookieName];
						$list = explode( ',', $csvData );
						
						$arpsql = "SELECT options, split_name, display_only_email FROM $this->listfusion_arp_table WHERE id=".$row['arp_id']."";
						$arprow = $wpdb->get_row( $arpsql, ARRAY_A );
						if( $arprow['display_only_email'] == 1 ) {
							$cvsRecord = $list[3] ."," . $list[4] ."\n"; // fname,lname,name,email,ip
						} else if( $arprow['split_name'] == 1 ) {
							$cvsRecord = $list[0] . "," . $list[1] . "," . $list[3] ."," . $list[4] ."\n"; // fname,lname,name,email,ip
						} else {
							$cvsRecord = $list[2] . "," . $list[3] ."," . $list[4] ."\n"; // fname,lname,name,email,ip
						}
						
						$csv_options = unserialize($arprow['options']);
						if( $csv_options['connection_type'] == 2 && $csv_options['arp_store_in_csv_as_backup'] == 1 ) {
							$fp = fopen(LIST_FUSION_RELPATH.'/csv/backup/'.$filename,"a") or die("can't open file"); // $fp is now the file pointer to file $filename
						} else if( $csv_options['connection_type'] == 3 ) {
							$fp = fopen(LIST_FUSION_RELPATH.'/csv/'.$filename,"a") or die("can't open file"); // $fp is now the file pointer to file $filename
						}
						
						if($fp){
							fwrite($fp,$cvsRecord); // Write information to the file
							fclose($fp); // Close the file
						}
					setcookie($csvCookieName, "", time()-3600);	
					}
					// eof csv
					setcookie($clickIDName, "", time()-3600);				
				}
			
			}
		}
	}	

	function __listfusion_SetCookie() {
		global $wpdb;
		//error_reporting(E_ALL ^ E_NOTICE);
		// Global Values
		$this->global_days_cookie_expire = time() - (3600 * 24) * 365 * 1; 
		$this->global_visits_cookie_life = time() + (3600 * 24) * 365 * 1;
		$this->global_listfusion_siteURL = parse_url(LIST_FUSION_SITEURL);
		// Schedule
		$cookie_dataProcessQry = "SELECT option_values, cookie FROM $this->listfusion_placement_table where ( item_type='optinpopup' OR item_type='adpopup' OR item_type='socialpopup' OR item_type='custompopup' OR item_type='clickslideroptin' OR item_type='clicksliderad' ) AND flag='1' ";
		$fusion_cookie_item_process = $wpdb->get_results( $cookie_dataProcessQry, ARRAY_A );
		if( $fusion_cookie_item_process ) { 
			foreach ( $fusion_cookie_item_process as $result ) {
				$option_value    = unserialize($result['option_values']);
				$schedule_COOKIE = unserialize($result['cookie']); 
				$schedule_COOKIE        = $schedule_COOKIE['schedule'];
				$schedule_COOKIE_name   = explode(',',$schedule_COOKIE);
				$displayOnEveryDays     = $schedule_COOKIE_name[0];
				$displayForFirstVisits  = $schedule_COOKIE_name[1];
				$displayAfterVisits     = $schedule_COOKIE_name[2];
				$chk_scheduleType  = $option_value['scheduleOnDisplay']; // schedule type :: Global
				$noof_visits       = $option_value['display_for_first_visits']; // schedule 2 value
				$noof_days         = $option_value['display_on_every_days']; // schedule 3 value
				$days_cookie_life  = time() + (3600 * 24) * $noof_days; 
				$show_after_visits = $option_value['display_after_visit']; // schedule 4 value
				$this->__listfusion_processCookie( $chk_scheduleType, $displayOnEveryDays, $displayForFirstVisits, $displayAfterVisits, $noof_visits, $noof_days, $days_cookie_life, $show_after_visits );
			}
		}	
	}

	function __listfusion_processCookie (  $chk_schedule, $DisplayOnEveryDaysCOOK, $DisplayForFirstVisitsCOOK, $DisplayShowAfterVisitsCOOK, $footer_noof_visits, $footer_noof_days, $footer_days_cookie_life, $footer_show_after_visits ) {
			
		// Display on every page load
		if ( $chk_schedule == 1 ) { 
			setcookie( $DisplayOnEveryDaysCOOK, '', $this->global_days_cookie_expire, $this->global_listfusion_siteURL['path'] . '/' );
			setcookie( $DisplayForFirstVisitsCOOK, '', $this->global_days_cookie_expire, $this->global_listfusion_siteURL['path'] . '/' );
			setcookie( $DisplayShowAfterVisitsCOOK, '', $this->global_days_cookie_expire, $this->global_listfusion_siteURL['path'] . '/' );
		
		// Display for first *** visits
		} else if ( $chk_schedule == 2 && !isset($_COOKIE[$DisplayForFirstVisitsCOOK]) ) { 
			setcookie( $DisplayOnEveryDaysCOOK, '', $this->global_days_cookie_expire, $this->global_listfusion_siteURL['path'] . '/' );
			setcookie( $DisplayShowAfterVisitsCOOK, '', $this->global_days_cookie_expire, $this->global_listfusion_siteURL['path'] . '/' );
			setcookie($DisplayForFirstVisitsCOOK, 1, $this->global_visits_cookie_life, $this->global_listfusion_siteURL['path'] . '/');

		} else if ( $chk_schedule == 2 && isset($_COOKIE[$DisplayForFirstVisitsCOOK]) && $_COOKIE[$DisplayForFirstVisitsCOOK]<$footer_noof_visits ) { 
			setcookie( $DisplayOnEveryDaysCOOK, '', $this->global_days_cookie_expire, $this->global_listfusion_siteURL['path'] . '/' );
			setcookie( $DisplayShowAfterVisitsCOOK, '', $this->global_days_cookie_expire, $this->global_listfusion_siteURL['path'] . '/' );
			$upto_visits = $_COOKIE[$DisplayForFirstVisitsCOOK] + 1;
			setcookie($DisplayForFirstVisitsCOOK, $upto_visits, $this->global_visits_cookie_life, $this->global_listfusion_siteURL['path'] . '/');
		
		// Display on every *** days
		} else if ( $chk_schedule == 3 && !isset($_COOKIE[$DisplayOnEveryDaysCOOK]) ) { 
			setcookie( $DisplayForFirstVisitsCOOK, '', $this->global_days_cookie_expire, $this->global_listfusion_siteURL['path'] . '/' );
			setcookie( $DisplayShowAfterVisitsCOOK, '', $this->global_days_cookie_expire, $this->global_listfusion_siteURL['path'] . '/' );
			setcookie($DisplayOnEveryDaysCOOK, $footer_noof_days, $footer_days_cookie_life, $this->global_listfusion_siteURL['path'] . '/');
		
		// Display after *** visits
		} else if ($chk_schedule == 4 && !isset($_COOKIE[$DisplayShowAfterVisitsCOOK]) ) { 
			setcookie( $DisplayOnEveryDaysCOOK, '', $this->global_days_cookie_expire, $this->global_listfusion_siteURL['path'] . '/' );
			setcookie( $DisplayForFirstVisitsCOOK, '', $this->global_days_cookie_expire, $this->global_listfusion_siteURL['path'] . '/' );
			setcookie($DisplayShowAfterVisitsCOOK, 1, $this->global_visits_cookie_life, $this->global_listfusion_siteURL['path'] . '/');

		} else if ($chk_schedule == 4 && isset($_COOKIE[$DisplayShowAfterVisitsCOOK]) && $_COOKIE[$DisplayShowAfterVisitsCOOK] < $footer_show_after_visits ) { 
			setcookie( $DisplayOnEveryDaysCOOK, '', $this->global_days_cookie_expire, $this->global_listfusion_siteURL['path'] . '/' );
			setcookie( $DisplayForFirstVisitsCOOK, '', $this->global_days_cookie_expire, $this->global_listfusion_siteURL['path'] . '/' );
			$total_visits = intval($_COOKIE[$DisplayShowAfterVisitsCOOK]) + 1;
			setcookie($DisplayShowAfterVisitsCOOK, $total_visits, $this->global_visits_cookie_life, $this->global_listfusion_siteURL['path'] . '/');
		}

	}
	
	
/*************************
**** USER - PROCESS RESULTS POPUP **
**************************/

	function __listfusion_curPageURL() {
		 $pageURL = 'http';
		 if ($_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
		 $pageURL .= "://";
		 if ($_SERVER["SERVER_PORT"] != "80") {
		  $pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
		 } else {
		  $pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
		 }
		 return $pageURL;
	}
	
 	function __listfusion_item_popup(){  
		global $wpdb;
		if( $this->customPopUp == 1 ) {  
			$sql = "SELECT * FROM $this->listfusion_placement_table where ( item_type = 'custompopup' ) AND childid = '0' AND flag = '1' ";															
																		
		} else { 
			$sql = "SELECT * FROM $this->listfusion_placement_table where ( item_type = 'optinpopup' OR 
																		item_type = 'adpopup' OR 
																		item_type = 'socialpopup' ) 
																		AND childid = '0' AND flag = '1' ";																
		}
		
		$listfusion_items_PopUpDisplay = $wpdb->get_results( $sql, ARRAY_A );
		if( $listfusion_items_PopUpDisplay ) { 
			foreach ( $listfusion_items_PopUpDisplay as $item_display ) {
					
				$item_ROOTID = $item_display['id']; 
				$item_display_options = $this->__listfusion_op_option_filter( unserialize($item_display['option_values']) );
				///print_r($item_display_options);
				$displayin_all             = $item_display_options['display_in_all'];
				$displayin_home            = $item_display_options['display_in_home'];
				$displayin_frontpg         = $item_display_options['display_in_front'];
				$displayin_post            = $item_display_options['display_in_post'];
				$displayin_archive         = $item_display_options['display_in_archive'];
				$displayin_search          = $item_display_options['display_in_search'];
				$displayin_other           = $item_display_options['display_in_other'];
				$displayin_showInPostId    = $item_display_options['showOnPostWithID'];
				$displayin_dntshowInPostId = $item_display_options['dontShowOnPostWithID'];
				$displayin_pageID          = $item_display_options['display_in_pageid'];
				$displayin_CatIn           = $item_display_options['display_catIn'];
				$displayin_cat             = $item_display_options['display_in_cat'];
				// IMP :: Check where to display popup box
				if( $item_display_options['popup_onClickAction_self_display'] == 1 && $item_display['item_type'] == 'custompopup' ) continue;
				
				if( $this->customPopUp == 1 &&  $item_display_options['popup_onClickAction_self_display'] == 1 ) {  
					$listfusion_item_DISPLAY = false;
				} else {  
					$listfusion_item_DISPLAY = $this->listfusion_show_resultON($displayin_all, $displayin_frontpg, $displayin_home, $displayin_post, $displayin_archive, $displayin_search, $displayin_other, $displayin_showInPostId,  $displayin_dntshowInPostId, $displayin_pageID, $displayin_CatIn, $displayin_cat);
				}
				
				    if( $listfusion_item_DISPLAY == true ) {
					
						// check schedule
						$item_schedule                       = $item_display_options['scheduleOnDisplay'];
						$item_schedule_noof_firstVisitData   = $item_display_options['display_for_first_visits']; // schedule 2 value
						$item_schedule_noof_daysData         = $item_display_options['display_on_every_days']; // schedule 3 value
						$item_schedule_show_after_visitsData = $item_display_options['display_after_visit']; // schedule 4 value
						
						$new_item_cookie = unserialize($item_display['cookie']); 
						$item_scheduleOn = $new_item_cookie['schedule'];
						$item_scheduleOn = explode(",",$item_scheduleOn);
						$item_scheduleForOnEveryDays  = $item_scheduleOn[0];
						$item_scheduleForFirstVisits  = $item_scheduleOn[1];
						$item_scheduleShowAfterVisits = $item_scheduleOn[2];

						if( ($item_schedule == 1) ||
							($item_schedule == 2 && ($_COOKIE[$item_scheduleForFirstVisits] < $item_schedule_noof_firstVisitData)) || 
							($item_schedule == 3 && !isset($_COOKIE[$item_scheduleForOnEveryDays])) || 
							($item_schedule == 4 && ($_COOKIE[$item_scheduleShowAfterVisits] >= $item_schedule_show_after_visitsData))  
						   ) { } else {
							continue;
							 }
							 
						// Child Process
						$ab_sql_count = "SELECT COUNT(id) FROM $this->listfusion_placement_table where ( childid = '$item_ROOTID' ) AND 
																							 checkincount <= '0' AND flag = '1' ORDER BY RAND() limit 1 ";
						$total_ab_count = $wpdb->get_var( $ab_sql_count );
						 if ( $total_ab_count > 0) {
							  $ab_sql = "SELECT * FROM $this->listfusion_placement_table where ( childid = '$item_ROOTID' ) AND 
																							 checkincount <= '0' AND flag = '1' ORDER BY RAND() limit 1 ";
							  $item_display = $wpdb->get_row( $ab_sql, ARRAY_A );
							  if ($item_display != null) {
								  $sql_update_chkincount1 = "UPDATE $this->listfusion_placement_table SET checkincount='1' WHERE id='".$item_display['id']."'";
								  $wpdb->query( $sql_update_chkincount1 );
							  }
							  $item_display_options = $this->__listfusion_op_option_filter( unserialize($item_display['option_values']) );
						  } else {
							  $sql_update_chkincount0 = "UPDATE $this->listfusion_placement_table SET 
														`checkincount` = '0'  
														 WHERE childid = '$item_ROOTID' order by ID ASC";
							  $wpdb->query( $sql_update_chkincount0 );							 
						  }
						// Eof child process
						
						/* - popup ID again */
						$item_ROOTID = $item_display['id']; 
						
						/* - Cookie */
						$item_cookie = unserialize($item_display['cookie']);
						$dontShowMeAfterSub_COOKIE = $item_cookie['dontShowAfterSubscribe'];
						$dontShowMeAgain_COOKIE    = $item_cookie['dontShowMeAgain'];
						$countClick_COOKIE         = $item_cookie['clickIDName'];
						$disableOnClickCloseBtm_COOKIE = $item_cookie['disableOnClickCloseBtm'];
							
						// Cookie - user disable
						if( isset($_COOKIE[$dontShowMeAgain_COOKIE]) && $_COOKIE[$dontShowMeAgain_COOKIE] == 1 ) continue;
						if( isset($_COOKIE[$disableOnClickCloseBtm_COOKIE]) && $_COOKIE[$disableOnClickCloseBtm_COOKIE] == 1 ) continue;
						if( isset($_COOKIE[$dontShowMeAfterSub_COOKIE]) && $_COOKIE[$dontShowMeAfterSub_COOKIE] == 1 ) continue;
						
						// filter - type
						if( $item_display['item_type'] == 'optinpopup' ) {
							$arpID = $item_display['arp_id'];
							$popup_style = $item_display_options['preview_type'];
							$this->template_TrackingCode   = $item_display['arp_trackingcode'];
							$template_security_note     = $item_display['security_note'];
							/* csv */
							$csv_query = "SELECT options FROM $this->listfusion_arp_table WHERE id='$arpID'";
							$csv_row = $wpdb->get_row($csv_query);
							$csv_options = unserialize($csv_row->options);
							if( $csv_options['connection_type'] == 2 && $csv_options['arp_store_in_csv_as_backup'] == 1 ) {
								$csv_active = $csv_options['arp_store_in_csv_as_backup'];
							} else if( $csv_options['connection_type'] == 3 ) {
								$csv_active = 2;
							}
							
						} else if(  $item_display['item_type'] == 'adpopup' ) {
							$popup_style = $item_display_options['preview_type'];
							
							if( (isset($item_display['cutelink']) && $item_display['cutelink'] != '') && (!$item_display['cutelink'] == 0) ) { 
								$ad_redirectURL = LIST_FUSION_SITEURL.'/'.$item_display['cutelink'];
							} else {
								$ad_redirectURL = $item_display_options['ad_redirecturl'];
							} 	
							
							if( $item_display_options['ad_linkopenin'] == 2 ) $ad_openIN = "_blank";
							else $ad_openIN = '_self';
						} else if(  $item_display['item_type'] == 'socialpopup' ) {
							$popup_style = $item_display_options['preview_type'];
							// Server Current URL
							$listfusionSocial_curPageURL = $this->__listfusion_curPageURL();
							
							if (!get_option('listfusion_disable_facebookJS') || is_admin()) {
								wp_enqueue_script('fbsdk', 'https://connect.facebook.net/en_GB/all.js#xfbml=1', array());
								wp_localize_script('fbsdk', 'fbsdku', array( 'xfbml' => 1, ));
							}
							if (!get_option('listfusion_disable_googleplusJS') || is_admin()) {
								wp_enqueue_script('plusone', 'https://apis.google.com/js/plusone.js', array());
							}
							if (!get_option('listfusion_disable_twitterJS') || is_admin()) {
								wp_enqueue_script('twitter', 'https://platform.twitter.com/widgets.js', array());
							}
							if (!get_option('listfusion_disable_linkedInJS') || is_admin()) {
								wp_enqueue_script('linkedin', 'http://platform.linkedin.com/in.js', array());
							}
							if (!get_option('listfusion_disable_pinterestJS') || is_admin()) {
								wp_enqueue_script('pinterest', 'https://assets.pinterest.com/js/pinit.js', array());
							}
							
						}
						
						// global for: optin, ad 
						$this->template_submit_btm_txt = $item_display['submit_txt'];
						$template_btmbg_from        = $item_display_options['btm_from_color'];
						$template_btmbg_to          = $item_display_options['btm_to_color'];
						$template_btm_hoverbg_from  = $item_display_options['btm_from_hover_color'];
						$template_btm_hoverbg_to    = $item_display_options['btm_to_hover_color'];
						$template_btm_txt_color     = $item_display_options['submit_btm_text'];
						$template_submit_text_size  = $item_display_options['submit_font_size'];
						
						// Disable popup for X days once user subscriber or click on ad
						if( $item_display_options['once_subscribe_disable_for'] == '' ) $chk_sub_disable = 'null';
						else  $chk_sub_disable = 'true';
						$once_subscribe_disable_for = $item_display_options['once_subscribe_disable_for'];
						
						/* - Look and feel */
							// -- Display theme style 
							$popup_style = $popup_style;
							// -- Display theme color
							if( $item_display_options['preview_color'] > 0 )  $popup_change_bg_theme = $item_display_options['preview_color'];
							else $popup_change_bg_theme = 1;
						
						/* - Schedule + delay + auto close + close button settings */ 
							
							// -- Delay
							$initialDisplay_delay = $item_display_options['display_delayShow'];
							if( $item_display_options['display_delayShow'] > 0 ) $popup_delay_hide = 'style="display:none"';
							else $popup_delay_hide = '';	
							// -- Close button
							if( $item_display_options['hide_close_btn'] == 1 ) $popupclosebtmCss = 'style="background-image:none;"';
							
						/* - Cookie settings */	
							if( $item_display_options['popup_user_click_close_btm'] != '' ) $closeBtmDays = $item_display_options['popup_user_click_close_btm'];
							else $closeBtmDays = 'null';
						
						/* - Content fill-up section */
							$item_text_title          = $item_display['title'];
							$item_text_title_fontsize = $item_display_options['field_header_size'].'px';
							$item_text_msg            = $item_display['msg'];
							$item_text_list_points    = unserialize($item_display['list_points']);
							$item_fld_img             = $item_display_options['field_img_url'];
							$item_text_video_code     = $item_display['video_code'];
							$item_text_ad_msg         = $item_display['ad_msg'];
							$item_text_social_msg     = $item_display['social_msg'];
							$item_text_optin_msg      = $item_display['optin_msg'];
							$item_text_custom_css     = $item_display['custom_css_code'];
							
						/* - htmlexit popup	*/	
						
							if( $item_display_options['show_popup_actions'] == 1 ) {
								$activate_popup_method = 2;
							} else if( $item_display_options['show_popup_actions'] == 2 || $item_display_options['show_popup_actions'] == '' ) {
								$activate_popup_method = 1;
							}
							
							if( $item_display_options['show_exit_html_popup'] == 1 ) {
								$activate_htmlexitpopup = 1;
								$item_text_js_html_msg  = $item_display['exit_htmljs_msg'];
								$item_text_js_html_msg  = str_replace("\n", ' ', $item_text_js_html_msg);
								$item_text_js_html_msg  = str_replace("\r", "", $item_text_js_html_msg);
								$popup_delay_hide = 'style="display:none"';
							} else if( $item_display_options['show_exit_html_popup'] == 2 ) {
								$activate_htmlexitpopup = 1;
								$activate_htmlexitbrowserviewpoint = 1;
								$popup_delay_hide = 'style="display:none"';
							} else if( $item_display_options['show_exit_html_popup'] == 3 ) {
								$activate_htmlexitpopup = 1;
								$display_popup_on_page_scroll = 1;
								$display_after_scroll = $item_display_options['onpagescroll_height']; 
								$popup_delay_hide = 'style="display:none"';
							} else if( $item_display_options['show_exit_html_popup'] == 4 ) {
								$activate_htmlexitpopup = 1;
								$display_popup_on_userinactivity = 1;
								$display_inactivity_after_sec = $item_display_options['curser_inactivity'];
								$popup_delay_hide = 'style="display:none"';
							} else {
								$activate_htmlexitpopup = 2;
							}
							
							
						/* - Visiotors contorl settings */	
							if($item_display_options['item_user_click_close_noconformation'] == 1) { $disableAskConfirmation = 2;
							} else {  $disableAskConfirmation = 1; }
							$user_cookie_days_on_close = $item_display_options['item_user_click_close_link'];
							if( $item_display_options['item_user_click_close_link'] != '' && $user_cookie_days_on_close > 0 && $user_cookie_days_on_close != '' ) { 
								$item_text_dntshowmeagain = '<!--Dont Show Me Again-->
												<span class="pwd"><a href="javascript:void(0)" id="listfusion-item-dont-show-again" >'.$item_display['item_close_linktext'].'</a></span>';
							}
						
						// autoclose adjustment
						if( isset($item_display_options['display_auto_close']) && $item_display_options['display_auto_close'] != '' ) $PopUpAutoCloseInXseconds = $item_display_options['display_auto_close'].'000';
						else $PopUpAutoCloseInXseconds = 'blank';
						
						
						if(  $item_display['item_type'] == 'custompopup' ) {
						
							$op_arr = array( 'listfusion_item_displayID' => $item_ROOTID, 
											 'DontShowAgain_COOKIE_Name' => $dontShowMeAgain_COOKIE, 
											 'DontShowAgain_block_days'  => $user_cookie_days_on_close,
											 'disableHideAlert'          => $disableAskConfirmation,
							 );
							 $uniqueTime =  $tag.date('YmdHis').$item_ROOTID;
							 $delayLoad  = $initialDisplay_delay * 1000;
							?>
							<script>
							var listfusion_fanchybox = <?php echo json_encode($op_arr); ?>;
							window.jQuery(document).ready(function() {
								<?php  if( $item_display_options['htmloriframe'] == '1' ) {  ?>
										// Inline
										setTimeout( function() {
										jQuery("#<?php echo $uniqueTime; ?>").fancybox({
															'titlePosition'		: 'inside',
															'transitionIn'		: 'none',
															'transitionOut'		: 'none'
														}).trigger('click');
																}, <?php echo $delayLoad; ?>);  
										 // End Inline				
								<?php } else if( $item_display_options['htmloriframe'] == '2' ) { ?>						 
										// IFRAME
										setTimeout( function() {
										jQuery("#<?php echo $uniqueTime; ?>").fancybox({
																'width'				: '<?php echo $item_display_options['popup_custom_width']; ?>%',
																'height'			: '<?php echo $item_display_options['popup_custom_height']; ?>%',
																'autoScale'			: false,
																'transitionIn'		: 'none',
																'transitionOut'		: 'none',
																'type'				: 'iframe'
															}).trigger('click'); 
																  }, <?php echo $delayLoad; ?>); 
								 <?php } ?>							
									});
							</script>
							
						<div style="display:none">
							<?php  if( $item_display_options['htmloriframe'] == '1' ) { ?>
								<a id="<?php echo $uniqueTime; ?>" href="#displayinline<?php echo $uniqueTime; ?>" >Inline</a>
							<?php } else if( $item_display_options['htmloriframe'] == '2' ) { ?>
								<a id="<?php echo $uniqueTime; ?>" href="<?php echo $item_display_options['popup_custom_source_url']; ?>">Iframe</a>
							<?php } ?>
						</div>
						
						<?php 
						if( $item_display_options['htmloriframe'] == '1' ) { 
							
							if( $item_display_options['popup_applyshortcode'] == 1 ) {  
								$new_popup_bodytxt = apply_filters( 'the_content', $item_display['custom_msg'] );
								$new_popup_bodytxt = str_replace( ']]>', ']]&gt;', $new_popup_bodytxt );
							} else {  
								$new_popup_bodytxt = $item_display['custom_msg'];
							}
						
							echo '<div style="display:none;">
									<div id="displayinline'.$uniqueTime.'" style="width:'.$item_display_options['popup_custom_html_width'].';height:'.$item_display_options['popup_custom_html_height'].';overflow:auto;">
												'.$new_popup_bodytxt.'
												 <br><br>
												'.$item_text_dntshowmeagain.'
												<span style="display:none"><img src="'.LIST_FUSION_ADMIN_URL.'?action=listfusionRstStats&id='.$item_ROOTID.'&nonce='.wp_create_nonce( 'listfusion-smartdailystats').'"></span>
											</div>
										</div>
									';
						}
						?>
							
							
						<?php
						} else {  

						ob_start();
						include('user-lib/popup/'.$popup_style.'/template.php');
						$output = ob_get_contents();
						ob_end_clean();
						
						$op_arr = array(
							// Schedule + delay + auto close + close button settings   
							'delay'                      => floatval($initialDisplay_delay), 
							// exit html js
							'htmlexitpopup'              => $activate_htmlexitpopup,
							'htmlexitbrowserviewpoint'   => $activate_htmlexitbrowserviewpoint,
							'htmljsmsg'                  => $item_text_js_html_msg,
							'onpagescroll'               => $display_popup_on_page_scroll,
							'userinactivity'             => $display_popup_on_userinactivity,
							'userinactivitydisplayafter' => $display_inactivity_after_sec,
							'scrollpageheight'           => $display_after_scroll,
							'popupMethodDisplay'         => $activate_popup_method,
							// auto hide
 							'autohide_popup'             => $PopUpAutoCloseInXseconds,
							// visitors control settings 
							'DontShowAgain_COOKIE_Name'  => $dontShowMeAgain_COOKIE, 
							'DontShowAgain_block_days'   => $user_cookie_days_on_close,
							'disableHideAlert'           => $disableAskConfirmation,
							// cookie settings	
							'close_btm_days'             => $closeBtmDays,
							'close_btm_cookie_Name'      => $disableOnClickCloseBtm_COOKIE,
							// form valid + cookie + click
							'emailFldID'                     => 'emailItem'.$item_ROOTID, 
							'nameFldID'                      => 'nameItem'.$item_ROOTID,
							'firstNameFldID'                 => 'firstNameItem'.$item_ROOTID, 
							'lastNameFldID'                  => 'lastNameItem'.$item_ROOTID, 
							'afterSubs_SetCookieOrNot'       => $chk_sub_disable,
							'DontShowMeAfterSub_COOKIE_Name' => $dontShowMeAfterSub_COOKIE,
							'after_subscribe_block_days'     => $once_subscribe_disable_for,
							'clickIDName'                    => $item_cookie['clickIDName'],
							'displayItemID'                  => $item_ROOTID,
							// output
							'popupoutput'                => $output,  
							// ajax call
							'global_admin_ajax'  => $this->listfusion_ajx_url, 
							'itemClickNonce'     => wp_create_nonce( 'listfusion-click-nonce' ), 
							'userIP'             => $_SERVER["REMOTE_ADDR"],
							'addCSV'             => $csv_active,
							
						 );
						 ?>
						 
						<script type='text/javascript' src='<?php echo LIST_FUSION_FULLPATH; ?>lib/user-lib/listfusion-lightbox.js?ver=1.3.2'></script>
						<link rel="stylesheet" type="text/css" media="all" href="<?php echo admin_url('admin-ajax.php?action=loadListfusion_itemstyle&btmFromColor='.$template_btmbg_from.'&btmToColor='.$template_btmbg_to.'&btmHoverFromColor='.$template_btm_hoverbg_from.'&btmHoverToColor='.$template_btm_hoverbg_to.'&btmTextColor='.$template_btm_txt_color.'&btmSize='.$template_submit_text_size.'&style='.$popup_style.'&popupstyle='.$popup_style); ?>" />
						<script type="text/javascript">
							var listfusion_item_popup = <?php echo json_encode($op_arr); ?>;
						</script>
						 <?php 
						} // Eof if 
					}// Eof display control
			
			}
		}	
	}
	
	function __listfusion_social_display($show_facebook, $show_twitter, $show_google, $show_pinterest, $show_linkedin, $listfusionSocial_curPageURL, $social_facebook_url, $soical_twitter_url, $social_twtter_txt , $social_google_url, $social_pinterest_url, $social_pinterest_img_url, $item_social_pinterest_txt, $social_linkedin_url ){
	
		// Facebook
		if ( $show_facebook == '1' ) {
			$social_display = '<div class="aplbpop_social"><div class="fb-like" data-href="' . ( $social_facebook_url ? $social_facebook_url : $listfusionSocial_curPageURL) . '" data-send="false" data-layout="button_count" data-width="450" data-show-faces="false"></div></div>';
		}
		// Twitter tweet
		if ( $show_twitter == '1' ) {
			$social_display .= '<div class="aplbpop_social" style="width:89px;"><a href="https://twitter.com/share" data-url="' . $soical_twitter_url . '" ' . ($social_twtter_txt ? 'data-text="' . $social_twtter_txt . '"' : '') . ' class="twitter-share-button" data-lang="en">Tweet</a></div>';
		}
		// Google+
		if ( $show_google == '1'  ) {
			$social_display .= '<div class="aplbpop_social" style="width:65px"><div class="g-plusone" data-size="medium" data-callback="snp_onshare_gp" data-href="' . ($social_google_url ? $social_google_url : $listfusionSocial_curPageURL) . '"></div></div>';
		}
		// Pinterest
		if ( $show_pinterest == '1' ) {
			$social_display .= '<div class="aplbpop_social"><a href="http://pinterest.com/pin/create/button/?url=' . urlencode($social_pinterest_url ? $social_pinterest_url : $listfusionSocial_curPageURL) . '&media=' . urlencode($social_pinterest_img_url) . '&description=' . urlencode($item_social_pinterest_txt) . '" data-pin-do="buttonPin" target="_blank" data-pin-config="beside"><img border="0" src="//assets.pinterest.com/images/pidgets/pin_it_button.png" title="Pin It" /></a></div>';
		}
		// LinkedIn
		if ( $show_linkedin == '1'  ) {
			$social_display .= '<div class="aplbpop_social"><script type="IN/Share" data-showzero="true" data-url="' . $social_linkedin_url . '" data-onsuccess="snp_onshare_li" data-counter="right"></script></div>';
		}	
		
		if( $this->template_return_formdata == 1 ) return $social_display;
		else echo $social_display; 
						
	}
	
	
/****************************
**** CUSTOM EVENT HANDLE ***/

	function __listfusion_custom(){
		global $wpdb;
		if ( !is_admin() )  session_start();
		
		// SEND EMAIL 
		$sendemail_name  = filter_input(INPUT_POST, 'listfusion_name', FILTER_SANITIZE_SPECIAL_CHARS);
		$sendemail_email = filter_input(INPUT_POST, 'listfusion_email', FILTER_SANITIZE_SPECIAL_CHARS);
		$sendemail_itemid = filter_input(INPUT_POST, 'listfusion_item', FILTER_SANITIZE_SPECIAL_CHARS);
		$sendemail_arp = filter_input(INPUT_POST, 'listfusion_arp', FILTER_SANITIZE_SPECIAL_CHARS);
		if( $sendemail_email !='' && isset($sendemail_email) ) { 
		
			$db_Update_sql = "UPDATE $this->listfusion_status_table SET click=click+1 WHERE listfusionID='$sendemail_itemid' and now_date=CURDATE() ";
			$wpdb->query($db_Update_sql);
			
			$sql = "SELECT options FROM $this->listfusion_arp_table WHERE id='".$sendemail_arp."'";
			$row = $wpdb->get_row( $sql, ARRAY_A ); 
			$results = unserialize($row['options']);
			$Email = $results['send_optin_to_email'];
			$sendemail_redirect_url = trim($results['send_optin_to_email_thank_url']);
			
			$msg = 
			"New subscription on " . get_bloginfo() . 
			"\n".
			"\n".
			"E-mail: " . $sendemail_email . "\n".
			"Name: " . $sendemail_name . "\n".
			"\n".
			"Form: item ID number " . $sendemail_itemid . "\n".
			"Date: " . date('Y-m-d H:i') . "\n".
			"IP: " . $_SERVER['REMOTE_ADDR'] . "";
			wp_mail($Email, "New subscription on " . get_bloginfo(), $msg);
			
			if( $sendemail_redirect_url != '' ) {
				echo '<script>window.location.href="'.$sendemail_redirect_url.'"</script>';
			}
			
		}
		// EOD SEND EMAIL
	
		$this->listfusion_file_process();
		$inputName  = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_SPECIAL_CHARS);
		$inputEmail = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_SPECIAL_CHARS);
		$itemid = filter_input(INPUT_POST, 'item', FILTER_SANITIZE_SPECIAL_CHARS);
		if( isset($itemid) && isset($inputEmail) ) {
			$query = "SELECT item_name FROM $this->listfusion_placement_table WHERE id='".$itemid."'";
			$row = $wpdb->get_row( $query, ARRAY_A );
			$filename = str_replace(" ", "-", $row['item_name']).'.csv';
			
			$db_Update_sql = "UPDATE $this->listfusion_status_table SET click=click+1 WHERE listfusionID='$itemid' and now_date=CURDATE() ";
			$wpdb->query($db_Update_sql);
			
			$cvsRecord = $inputName . "," . $inputEmail . "," . $_SERVER["REMOTE_ADDR"] ."\n"; // name,email,ip
			$fp = fopen(LIST_FUSION_RELPATH.'/csv/'.$filename,"a"); // $fp is now the file pointer to file $filename
			if($fp){
				fwrite($fp,$cvsRecord); // Write information to the file
				fclose($fp); // Close the file
			}
		}
		
		$redirectUrl = filter_input(INPUT_POST, 'listfusionRedirectUrl', FILTER_SANITIZE_SPECIAL_CHARS);
		if( $redirectUrl != '' ) {
			echo '<script>window.location.href="'.$redirectUrl.'"</script>';
		}
	}

/****************************
**** AD LINK PROCESS ***/

	function __listfusion_adprocess(){
			global $wpdb;
			$request_url = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
			$link_cute   = str_replace(LIST_FUSION_BLOGURL.'/', '', $request_url);
			if ( strcmp($link_cute,$request_url) == 0 ) {
				$link_cute   = str_replace(strtolower(LIST_FUSION_BLOGURL).'/', '', $request_url);
			}
			$link_cute   = trim($link_cute,'/');
			$fetchdata_sql = "SELECT id,option_values,cutelink FROM $this->listfusion_placement_table WHERE cutelink='$link_cute'";
			$fetchdata = $wpdb->get_row( $fetchdata_sql, ARRAY_A );
			$options = unserialize($fetchdata['option_values']);
			
			if( (isset($options['ad_clocklink']) && $options['ad_clocklink'] != '') && (isset($fetchdata['cutelink']) && $fetchdata['cutelink'] != '' && (!$fetchdata['cutelink'] == 0)) ) { 
					$cloak_it = 1;
					$clocktitle = $options['ad_clocklink'];
			} else if( isset($fetchdata['cutelink']) && $fetchdata['cutelink'] != '' && (!$fetchdata['cutelink'] == 0) ) { 
					$cutelink = 1;
			}
			$deslinkurl = $options['ad_redirecturl'];
			$linkID = $fetchdata['id'];
			
			if ( $deslinkurl ) {
				if ( $cloak_it == 1 ) { 
					?>
					<script language="JavaScript">
					var clklnk = null;function Error(){return true;}function wndows1(){window.status='<?php echo $clocktitle;?>';}function wndows12(){if (clklnk != null) {clearInterval(clklnk);}}window.onerror = Error;clklnk = setInterval('wndows1()', 100);
					</script><script language="JavaScript" type="text/javascript">wndows1();</script>
					<?php
					$the_code .= '<html><head><title>'.$clocktitle.'</title></head>';
					$the_code .= '<frameset border="0" framespacing="0" rows="*" frameborder="0" marginbottom="0" marginright="0" margintop="0" marginleft="0">';
					$the_code .= '<frame border="0" src="'.$deslinkurl.'" frameborder="no" noresize="noresize" onload="wndows12()" id="frmMain" name="naff">';
					$the_code .= '<noframes><body onload=\'document.location="'.$deslinkurl.'"\'></body></noframes></frameset></html>';
					echo $this->__listfusionEncryptcall($the_code);
					exit;
				} else if( $cutelink == 1 ) { 
					header("Location: $deslinkurl");
					exit;
				}
			}
	}
	/**
	 * Encrypts Page Source
	 * @param string $txt
	 */
	function __listfusionEncryptcall($txt) { 
		for ( $i=0; $i < strlen($txt); $i++ ) { 
			$char  = substr($txt,$i,1);
			$ascii = ord($char);				
			$hex  .= '%'.dechex($ascii);
		} 
		?>
		<script type="text/javascript">var data = '<?php echo $hex;?>';document.write(unescape(data));</script>
		<?php
	} 
	
/******************
 * AUTO FORM FILLER
******************/

	function __listfusion_autoFormFiller(){
		$this->listfusion_autoFormFiller();
		if( $this->affNoOfRows > 0 ) {
		?>
			<script type="text/javascript">
			function listfusion_arrayCompare(a1, a2) {
				if (a1.length != a2.length) return false;
				var length = a2.length;
				for (var i = 0; i < length; i++) {
					if (a1[i] !== a2[i]) return false;
				}
				return true;
			}
			
			function listfusion_inArray(needle, haystack) {
				var length = haystack.length;
				for(var i = 0; i < length; i++) {
					if(typeof haystack[i] == 'object') {
						if(listfusion_arrayCompare(haystack[i], needle)) return true;
					} else {
						if(haystack[i] == needle) return true;
					}
				}
				return false;
			}			
			window.onload=__listfusion_formAutoFiller;
			function __listfusion_formAutoFiller() { 
				var allelementsForms;
				var arrchk = new Array(<?php foreach( (array) $this->listfusion_autoFillingFormValue as $row ) {
				foreach( $row as $key => $value ) {
					if( $key == '' || empty($key) ) unset($value);
					if( $key == 'optin_form_url' ) { 
						$action = trim($value);
						$action = "'". $action . "'".','; 
						echo $actionURL = $action;
					}
				}
				$this->affloop++;
			} ?>'');
				if (!document.getElementsByTagName) return false;
				allelementsForms = document.getElementsByTagName("form"); 
				for (var intCounter = 0; intCounter < allelementsForms.length; intCounter++) {
					var formAction = allelementsForms[intCounter].action.innerHTML;
					if( formAction != ''  ) {
						var formAction = allelementsForms[intCounter].action; 
					}
					if(listfusion_inArray( formAction, arrchk )) { 
					<?php	
					foreach( (array) $this->listfusion_autoFillingFormValue as $row ) {
						foreach( $row as $key => $value ) {
							if( $key == '' || empty($key) ) unset($value);
							if( $key == 'optin_name_fld' ) { 
								$name = trim($value);
								?>
								var fldname<?php echo $this->affloop2; ?> = '<?php echo $name; ?>';
								<?php 
							}
							if( $key == 'optin_email_fld' ) { 
								$email = trim($value);
							?>
							var fldemail<?php echo $this->affloop2; ?> = '<?php echo $email; ?>';
							<?php 	
							}
							if( $key == 'split_name' ) {
								$splitInfo = trim($value);
								?>
								var splitName<?php echo $this->affloop2; ?> = '<?php echo $splitInfo; ?>';
								<?php 
							} 
						}
						?>
					listfusion_validateArpForm( allelementsForms[intCounter], fldname<?php echo $this->affloop2; ?>, fldemail<?php echo $this->affloop2; ?>, splitName<?php echo $this->affloop2; ?> );
						<?php
						$this->affloop2++;
					}
					?>
					}
				} 
			}
			function listfusion_validateArpForm(currentForm, fldnamedb, fldemaildb, splitInfo) {  
				var blnvalidate = true;
				var elementsInputs;
				elementsInputs = currentForm.getElementsByTagName("input");
				for (var intCounter = 0; intCounter < elementsInputs.length; intCounter++) {
					// Name
					if( splitInfo == 1 ) {
						<?php $name = explode(" ", $this->fusion_item_autofillingForm_author ); ?>
						var splitName = fldnamedb.split(",");
						<?php if( $name[0] != '' ) { ?>
						if (elementsInputs[intCounter].name == splitName[0]) { 
							elementsInputs[intCounter].value = '<?php echo $name[0]; ?>';
						}
						<?php } 
						if( $name[1] != '' ) {
						?>
						if (elementsInputs[intCounter].name == splitName[1]) { 
							elementsInputs[intCounter].value = '<?php echo $name[1]; ?>';
						}
						<?php 
						} 
						?>
					} else {
						<?php if( $this->fusion_item_autofillingForm_author != '' ) { ?>
						if (elementsInputs[intCounter].name == fldnamedb) { 
							elementsInputs[intCounter].value = '<?php echo $this->fusion_item_autofillingForm_author; ?>';
						}
						<?php } ?>
					}
					// Email
					<?php if( $this->fusion_item_autofillingForm_author_email != '' ) { ?>
					if (elementsInputs[intCounter].name == fldemaildb) { 
						elementsInputs[intCounter].value = '<?php echo $this->fusion_item_autofillingForm_author_email; ?>';
					}
					<?php } ?>
				}
			}
			</script>
		<?php 
		}	
	}
	
/******************
 * POST PROCESS
******************/
	function __listfusion_processPostTag( $post_content ) { 
		$search_post_tag = '[LFONCLICK:popup';
		$main_search = "@(?:<p>)*\s*\[LFONCLICK:Popup\s*=\s*(\w+|^\+)\]\s*(?:</p>)*@i";
		$post_content = $this->__listfusion_processSearchTag($post_content, $search_post_tag, $main_search ); 
		$final_post_tag = '[/LFONCLICK:popup';
		$final_search = "@(?:<p>)*\s*\[/LFONCLICK:Popup]\s*(?:</p>)*@i";
		if ( stristr( $post_content, $final_post_tag ) ) { 
			if ( preg_match_all($final_search, $post_content, $matches) ) {
				if ( is_array( $matches ) ) {
						foreach ($matches[0] as $key =>$val) {
							$search  = $matches[0][$key];
							$replace = '</a>'; 
							$post_content = str_replace($search, $replace, $post_content);
						}
				}
			}	
		}
		return $post_content;
	}
	
	function __listfusion_processSearchTag( $post_content, $post_tag, $search ) {
		if ( stristr( $post_content, $post_tag ) ) { 
			if ( preg_match_all($search, $post_content, $matches) ) {
				if ( is_array( $matches ) ) {
						foreach ($matches[1] as $key =>$val) {
							$search  = $matches[0][$key];
							$replace = $this->__listfusion_item_onlick_popup($val); 
							$post_content = str_replace($search, $replace, $post_content);
						}
				}
			}	
		}
		return $post_content;
	}
	
	function __listfusion_item_onlick_popup($PopUpID){
	    global $wpdb;
		$sql = "SELECT * FROM $this->listfusion_placement_table where ( item_type = 'custompopup' ) AND id='$PopUpID' AND childid = '0' AND flag = '1' ";
		$popupBox_row = $wpdb->get_row( $sql, ARRAY_A );
		
		if ($popupBox_row != null) {
		 
			$this->sessionID = $this->listfusion_uniquesessionCount++;
				// Fetch necesseary records
				$new_popup_id = $popupBox_row['id']; 
				$new_popup_ser_values = unserialize($popupBox_row['option_values']); 
				// Fetch All Necesseary Records Now !!!
				$new_popup_bodytxt = $popupBox_row['custom_msg']; 
				$uniqueTime =  $tag.date('YmdHis').$this->sessionID;
				?>
					<script type="text/javascript">
					jQuery(document).ready(function() {
					<?php if( $new_popup_ser_values['htmloriframe'] == '1' ) { ?>
								jQuery("#<?php echo $uniqueTime; ?>").click(function(e){ 
									jQuery.fancybox({
										content:jQuery("#<?php echo 'inline'.$this->sessionID; ?>").html()
									});
									e.preventDefault();
								});
					<?php } else if( $new_popup_ser_values['htmloriframe'] == '2' ) { ?>
								// IFRAME
								jQuery("#<?php echo $uniqueTime; ?>").fancybox({
									'width'				: '<?php echo $new_popup_ser_values['popup_custom_width']; ?>%',
									'height'			: '<?php echo $new_popup_ser_values['popup_custom_height']; ?>%',
									'autoScale'			: false,
									'transitionIn'		: 'none',
									'transitionOut'		: 'none',
									'type'				: 'iframe'
								});
								
					 <?php } ?>			

					});
					</script>	
				<?php 
				
				if( $new_popup_ser_values['htmloriframe'] == '1' ) { 
				
					if( $new_popup_ser_values['popup_applyshortcode'] == 1 ) {
						$new_popup_bodytxt = apply_filters( 'the_content', $new_popup_bodytxt );
						$new_popup_bodytxt = str_replace( ']]>', ']]&gt;', $new_popup_bodytxt );
					} else {
						$new_popup_bodytxt = $new_popup_bodytxt;
					}
				
					echo '<div style="display:none;">
							<div id="inline'.$this->sessionID.'">
									<div style="width:'.$new_popup_ser_values['popup_custom_html_width'].';height:'.$new_popup_ser_values['popup_custom_html_height'].';overflow:auto;">
										'.$new_popup_bodytxt.'
										'.$item_text_dntshowmeagain.'
												<span style="display:none"><img src="'.LIST_FUSION_ADMIN_URL.'?action=listfusionRstStats&id='.$PopUpID.'&nonce='.wp_create_nonce('listfusion-smartdailystats').'"></span>
									</div>
									</div>
								</div>
							';
							
				}
				
			if( $new_popup_ser_values['htmloriframe'] == '1' ) $linkUrl = ' id="'.$uniqueTime.'" href="#inline'.$this->sessionID.'" ';
			else if( $new_popup_ser_values['htmloriframe'] == '2' ) $linkUrl = ' id="'.$uniqueTime.'" href="'.$new_popup_ser_values['popup_custom_source_url'].'" ';
				
		$tagvalue = '<a '.$linkUrl.'>';
		return $tagvalue;
	
		
		} else {
		  return '';
		}
		   
	}
	
/******************
 * LIST FUSION SETTINGS
******************/

	function __listfusion_settings(){
		$this->listfusion_stg_postrequest = $_POST['listfusion'];
		$process_settings_squeezePage = $this->listfusion_stg_postrequest['installFile'];
		$process_global_settings = $this->listfusion_stg_postrequest['globalsettings'];
		
		if( $process_global_settings == 'Save' ) {
			update_option('listfusion_activate_mobile', $this->listfusion_stg_postrequest['listfusion_activate_mobile']);
			// Fancy Box JS calling
			update_option('listfusion_custompop_fancybox', $this->listfusion_stg_postrequest['listfusion_custompop_fancybox']); 
			update_option('listfusion_custompop_fancybox_mousewheel', $this->listfusion_stg_postrequest['listfusion_custompop_fancybox_mousewheel']); 
			// Social Share JS loading
			update_option('listfusion_disable_facebookJS', $this->listfusion_stg_postrequest['listfusion_disable_facebookJS']); 
			update_option('listfusion_disable_twitterJS', $this->listfusion_stg_postrequest['listfusion_disable_twitterJS']); 
			update_option('listfusion_disable_googleplusJS', $this->listfusion_stg_postrequest['listfusion_disable_googleplusJS']); 
			update_option('listfusion_disable_linkedInJS', $this->listfusion_stg_postrequest['listfusion_disable_linkedInJS']); 
			update_option('listfusion_disable_pinterestJS', $this->listfusion_stg_postrequest['listfusion_disable_pinterestJS']); 
			// Data Save Information
			$this->listfusion_global_message = '<strong>Settings saved successfully</strong>';
		}
		
		
		if( $process_settings_squeezePage == 'Install File Now' ) {
			$file_name = LIST_FUSION_ABSPATH.'wp-content/themes/'.get_template().'/template-listfusion-squeezepg.php';
			$config  = "<?php\n";
			$config .= "/*\n";
			$config .= "Template Name: List Fusion Squeeze Page\n";
			$config .= "*/\n";
			$config .= "\n";
			$config .= "\n";
			$config .= "\n";
			$config .= "\$listfusion_squeezepage           = get_post_meta(\$post->ID, 'listfusion_squeezepage');\n";
			$config .= "\$listfusion_szpg_seo_title        = get_post_meta(\$post->ID, 'listfusion_szpg_seo_title');\n";
			$config .= "\$listfusion_szpg_seo_meta_dec     = get_post_meta(\$post->ID, 'listfusion_szpg_seo_meta_dec');\n";
			$config .= "\$listfusion_szpg_seo_meta_key     = get_post_meta(\$post->ID, 'listfusion_szpg_seo_meta_key');\n";
			$config .= "\$listfusion_szpg_seo_noindex      = get_post_meta(\$post->ID, 'listfusion_szpg_seo_noindex');\n";
			$config .= "\$listfusion_szpg_seo_nofollow     = get_post_meta(\$post->ID, 'listfusion_szpg_seo_nofollow');\n";
			$config .= "\$listfusion_szpg_seo_noarchive    = get_post_meta(\$post->ID, 'listfusion_szpg_seo_noarchive');\n";
			$config .= "\$listfusion_szpg_seo_footer_code  = get_post_meta(\$post->ID, 'listfusion_szpg_seo_footer_code');\n";
			$config .= "\n";
			$config .= "\n";
			$config .= "if(function_exists('listfusion_display_sqeezePg')) listfusion_display_sqeezePg(\$listfusion_squeezepage[0],  
																	\$listfusion_szpg_seo_title[0], 
																	\$listfusion_szpg_seo_meta_dec[0],  
																	\$listfusion_szpg_seo_meta_key[0],       
																	\$listfusion_szpg_seo_noindex[0],  
																	\$listfusion_szpg_seo_nofollow[0],    
																	\$listfusion_szpg_seo_noarchive[0],     
																	\$listfusion_szpg_seo_footer_code[0]
														  );\n";
			$config .= "?>";
			
			if ( ( $fp = fopen( $file_name, "w") ) ) {
				fputs( $fp, $config, strlen( $config ) );
				fclose( $fp );
				$this->listfusion_global_message = '<strong>.php file installed successfully on your current theme</strong>';
			} else {
				$canWrite = false;
				$this->listfusion_global_message = '<strong>Installation fail, please use manual process</strong>';
			}		
		}
		echo '<div class="wrap">';
		include('admin/settings.php');
		echo '</div>';
	}
	
/******************
 * SQUEEZE PAGE PROCESS
******************/
	function __listfusion_processSqueezePG( $listfusion_squeezepage, $listfusion_szpg_seo_title, $listfusion_szpg_seo_meta_dec, $listfusion_szpg_seo_meta_key, $listfusion_szpg_seo_noindex, $listfusion_szpg_seo_nofollow, $listfusion_szpg_seo_noarchive, $listfusion_szpg_seo_footer_code ) {
		global $wpdb;
		if( $listfusion_squeezepage > 0 ) {
		
			if( $listfusion_szpg_seo_noindex == 1 ) $noindex = 'noindex';
			if( $listfusion_szpg_seo_nofollow == 1 ) $nofollow = 'nofollow';
			if( $listfusion_szpg_seo_noarchive == 1 ) $noarchive = 'noarchive';
		
			if( $listfusion_szpg_seo_noindex == 1 || $listfusion_szpg_seo_nofollow == 1 || $listfusion_szpg_seo_noarchive ) {
				$meta_robots = '<meta name="robots" content="'.$noindex.','.$nofollow.','.$noarchive.'">';
			}
		
			$sql = "SELECT * FROM $this->listfusion_placement_table where ( item_type = 'squeezepg' ) 
																		AND id='$listfusion_squeezepage'
																		AND childid = '0' AND flag = '1' ";
			$row = $wpdb->get_row( $sql, ARRAY_A );
			if ($row != null) {
			
				$item_ROOTID = $row['id'];
				// Child Process
				$ab_sql_count = "SELECT COUNT(id) FROM $this->listfusion_placement_table where ( childid = '$item_ROOTID' ) AND 
																					 checkincount <= '0' AND flag = '1' ORDER BY RAND() limit 1 ";
				$total_ab_count = $wpdb->get_var( $ab_sql_count );
				 if ( $total_ab_count > 0) {
					 $ab_sql = "SELECT * FROM $this->listfusion_placement_table where ( childid = '$item_ROOTID' ) AND 
																					 checkincount <= '0' AND flag = '1' ORDER BY RAND() limit 1 ";
					  $row = $wpdb->get_row( $ab_sql, ARRAY_A );
					  if ($row != null) {
						  $sql_update_chkincount1 = "UPDATE $this->listfusion_placement_table SET checkincount='1' WHERE id='".$row['id']."'";
						  $wpdb->query( $sql_update_chkincount1 );
					  }
				  } else {
					  $sql_update_chkincount0 = "UPDATE $this->listfusion_placement_table SET 
												`checkincount` = '0'  
												 WHERE childid = '$item_ROOTID' order by ID ASC";
					  $wpdb->query( $sql_update_chkincount0 );							 
				  }
				// Eof child process
				
				$display_squeeze_page_ID = $row['id'];
				$option_value = $this->__listfusion_op_option_filter( unserialize($row['option_values']) );
				$list_points  = unserialize($row['list_points']);
				$item_cookie = unserialize($row['cookie']);
				$arpID = $row['arp_id'];
				$this->template_submit_btm_txt = $row['submit_txt'];
				$this->template_TrackingCode = $option_value['arp_trackingcode'];
				//print_r($option_value);
				$field_header_size = $option_value['field_header_size'];
				//img
				$upload_img = $option_value['field_img_url'];
				// btm settings
				$btm_from_color = $option_value['btm_from_color'];
				$btm_to_color = $option_value['btm_to_color'];
				$btm_from_hover_color = $option_value['btm_from_hover_color'];
				$btm_to_hover_color = $option_value['btm_to_hover_color'];
				$btm_border_color = $option_value['btm_border_color'];
				$submit_btm_text_color = $option_value['submit_btm_text'];
				$submit_font_size = $option_value['submit_font_size'];
				
				/* csv */
				$csv_query = "SELECT options FROM $this->listfusion_arp_table WHERE id='$arpID'";
				$csv_row = $wpdb->get_row($csv_query);
				$csv_options = unserialize($csv_row->options);
				if( $csv_options['connection_type'] == 2 && $csv_options['arp_store_in_csv_as_backup'] == 1 ) {
					$csv_active = $csv_options['arp_store_in_csv_as_backup'];
				} else if( $csv_options['connection_type'] == 3 ) {
					$csv_active = 2;
				}
				
				// json_encode			
				$op_arr =  array( 
									'emailFldID'         => 'emailItem'.$display_squeeze_page_ID, 
									'nameFldID'          => 'nameItem'.$display_squeeze_page_ID,
									'firstNameFldID'     => 'firstNameItem'.$display_squeeze_page_ID, 
									'lastNameFldID'      => 'lastNameItem'.$display_squeeze_page_ID, 
									'displayItemID'      => $display_squeeze_page_ID,
									'clickIDName'        => $item_cookie['clickIDName'],
									// ajax call
									'global_admin_ajax'  => $this->listfusion_ajx_url, 
									'itemClickNonce'     => wp_create_nonce( 'listfusion-click-nonce' ), 
									'userIP'             => $_SERVER["REMOTE_ADDR"],
									'addCSV'             => $csv_active,
								 );
				if( $submit_font_size != '' ) $submit_font_size = $option_value['submit_font_size'];
				else $submit_font_size = '24';
				
				wp_enqueue_script( 'squeeze-pg-custom', LIST_FUSION_LIBPATH . 'user-lib/squeeze-pg/custom.js', array('jquery'), time(), true ); 
				include( LIST_FUSION_RELPATH.'/lib/user-lib/squeeze-pg/'.$option_value['preview_type'].'/template.php' );
			
			
			} else {
			echo 'Your created squeeze page is either removed or disable, Please reselect squeeze page again.';
			}
		} else {
			echo 'Created squeeze page has not yet define.';
		}
	}
	
	
/******************
 * CLICK SLIDER
******************/

function __listfusion_item_clickslider(){
		global $wpdb;
	    $sql = "SELECT * FROM $this->listfusion_placement_table where (  item_type = 'clickslideroptin' OR item_type = 'clicksliderad' ) 
				AND childid = '0' AND flag = '1' ";
		$listfusion_items_clickslider = $wpdb->get_results( $sql, ARRAY_A );
		if( $listfusion_items_clickslider ) { 
			foreach ( $listfusion_items_clickslider as $item_display ) {
			   
				$item_ROOTID = $item_display['id']; 
				$item_display_options = $this->__listfusion_op_option_filter( unserialize($item_display['option_values']) );
				$displayin_all             = $item_display_options['display_in_all'];
				$displayin_home            = $item_display_options['display_in_home'];
				$displayin_frontpg         = $item_display_options['display_in_front'];
				$displayin_post            = $item_display_options['display_in_post'];
				$displayin_archive         = $item_display_options['display_in_archive'];
				$displayin_search          = $item_display_options['display_in_search'];
				$displayin_other           = $item_display_options['display_in_other'];
				$displayin_showInPostId    = $item_display_options['showOnPostWithID'];
				$displayin_dntshowInPostId = $item_display_options['dontShowOnPostWithID'];
				$displayin_pageID          = $item_display_options['display_in_pageid'];
				$displayin_CatIn           = $item_display_options['display_catIn'];
				$displayin_cat             = $item_display_options['display_in_cat'];
				$listfusion_item_slideshow_DISPLAY = $this->listfusion_show_resultON($displayin_all, $displayin_frontpg, $displayin_home, $displayin_post, $displayin_archive, $displayin_search, $displayin_other, $displayin_showInPostId,  $displayin_dntshowInPostId, $displayin_pageID, $displayin_CatIn, $displayin_cat);
				if( $listfusion_item_slideshow_DISPLAY == true ) {
				
					// check schedule
					$item_schedule                       = $item_display_options['scheduleOnDisplay'];
					$item_schedule_noof_firstVisitData   = $item_display_options['display_for_first_visits']; // schedule 2 value
					$item_schedule_noof_daysData         = $item_display_options['display_on_every_days']; // schedule 3 value
					$item_schedule_show_after_visitsData = $item_display_options['display_after_visit']; // schedule 4 value
					
					$item_cookie = unserialize($item_display['cookie']); 
					$item_scheduleOn = $item_cookie['schedule'];
					$item_scheduleOn = explode(",",$item_scheduleOn);
					$item_scheduleForOnEveryDays  = $item_scheduleOn[0];
					$item_scheduleForFirstVisits  = $item_scheduleOn[1];
					$item_scheduleShowAfterVisits = $item_scheduleOn[2];

					if( ($item_schedule == 1) ||
						($item_schedule == 2 && ($_COOKIE[$item_scheduleForFirstVisits] < $item_schedule_noof_firstVisitData)) || 
						($item_schedule == 3 && !isset($_COOKIE[$item_scheduleForOnEveryDays])) || 
						($item_schedule == 4 && ($_COOKIE[$item_scheduleShowAfterVisits] >= $item_schedule_show_after_visitsData))  
					   ) { } else {
						continue;
						 }
						 
					// Child Process
					$ab_sql_count = "SELECT COUNT(id) FROM $this->listfusion_placement_table where ( childid = '$item_ROOTID' ) AND 
																						 checkincount <= '0' AND flag = '1' ORDER BY RAND() limit 1 ";
					$total_ab_count = $wpdb->get_var( $ab_sql_count );
					 if ( $total_ab_count > 0) {
						  $ab_sql = "SELECT * FROM $this->listfusion_placement_table where ( childid = '$item_ROOTID' ) AND 
																						 checkincount <= '0' AND flag = '1' ORDER BY RAND() limit 1 ";
						  $item_display = $wpdb->get_row( $ab_sql, ARRAY_A );
						  if ($item_display != null) {
							  $sql_update_chkincount1 = "UPDATE $this->listfusion_placement_table SET checkincount='1' WHERE id='".$item_display['id']."'";
							  $wpdb->query( $sql_update_chkincount1 );
						  }
						  $item_display_options = $this->__listfusion_op_option_filter( unserialize($item_display['option_values']) );
					  } else {
						  $sql_update_chkincount0 = "UPDATE $this->listfusion_placement_table SET 
													`checkincount` = '0'  
													 WHERE childid = '$item_ROOTID' order by ID ASC";
						  $wpdb->query( $sql_update_chkincount0 );							 
					  }
					// Eof child process
					
					
					// START NORMAL
					$item_ROOTID = $item_display['id']; 
					$arpID = $item_display['arp_id']; 
					
					/* - Cookie */
					$dontShowMeAfterSub_COOKIE = $item_cookie['dontShowAfterSubscribe'];
					if( isset($_COOKIE[$dontShowMeAfterSub_COOKIE]) && $_COOKIE[$dontShowMeAfterSub_COOKIE] == 1 ) continue;
					
					if( $item_display['item_type'] == 'clickslideroptin' ) {
						$slider_style = $item_display_options['preview_type'];
					} else if(  $item_display['item_type'] == 'clicksliderad' ) {
						$slider_style = $item_display_options['preview_type'];
					}
					
					// Disable popup for X days once user subscriber or click on ad
					if( $item_display_options['once_subscribe_disable_for'] == '' ) $chk_sub_disable = 'null';
					else  $chk_sub_disable = 'true';
					$once_subscribe_disable_for = $item_display_options['once_subscribe_disable_for'];
					
					// ad process
					if( (isset($item_display['cutelink']) && $item_display['cutelink'] != '') && (!$item_display['cutelink'] == 0) ) { 
						$ad_redirecturl = LIST_FUSION_SITEURL.'/'.$item_display['cutelink'];
					} else {
						$ad_redirecturl = $item_display_options['ad_redirecturl'];
					} 
					
					$ad_openIN_window = $item_display_options['ad_linkopenin'];
					if( $ad_openIN_window == 2 ) {
						$ad_openIN = '_blank';
					} else {
						$ad_openIN = '';
					}
					
					$this->template_submit_btm_txt = $item_display['submit_txt'];
					$item_text_custom_css  = $item_display['custom_css_code'];
					// gap margin
					$slider_gap_margin     = $item_display_options['slider_margin_gap'];
					//slider design
					$slider_from_bg_color  = $item_display_options['clkslider_from_color'];
					$slider_to_bg_color    = $item_display_options['clkslider_to_color'];
					//btm
					$btm_from_color        = $item_display_options['btm_from_color'];
					$btm_to_color          = $item_display_options['btm_to_color'];
					$btm_from_hover_color  = $item_display_options['btm_from_hover_color'];
					$btm_to_hover_color    = $item_display_options['btm_to_hover_color'];
					$submit_btm_text_color = $item_display_options['submit_btm_text'];
					$submit_font_size      = $item_display_options['submit_font_size'];
					// title remain. design
					$title_text_size       = $item_display_options['field_header_size'];
					$title_text_color      = $item_display_options['slider_text_color'];
					// Security note color
					$security_note_color      = $item_display_options['security_note_color'];
					// msg
					$msg_text_color        = $item_display_options['message_text_color'];
					// img
					$upload_img = $item_display_options['field_img_url'];
					
					/* csv */
					$csv_query = "SELECT options FROM $this->listfusion_arp_table WHERE id='$arpID'";
					$csv_row = $wpdb->get_row($csv_query);
					$csv_options = unserialize($csv_row->options);
					if( $csv_options['connection_type'] == 2 && $csv_options['arp_store_in_csv_as_backup'] == 1 ) {
						$csv_active = $csv_options['arp_store_in_csv_as_backup'];
					} else if( $csv_options['connection_type'] == 3 ) {
						$csv_active = 2;
					}
					
					ob_start();
					include('user-lib/clickslider/'.$slider_style.'/template.php');
					$output = ob_get_contents();
					ob_end_clean();
					
							$op_arr = array(
								'slider'             => $output, 
								'afterSubs_SetCookieOrNot'  => $chk_sub_disable, 
								'displayItemID'             => $item_ROOTID,
								'DontShowMeAfterSub_COOKIE_Name' => $dontShowMeAfterSub_COOKIE,
								'after_subscribe_block_days'     => $once_subscribe_disable_for,
								// form valid + cookie + click
								'emailFldID'                     => 'emailItem'.$item_ROOTID, 
								'nameFldID'                      => 'nameItem'.$item_ROOTID,
								'firstNameFldID'                 => 'firstNameItem'.$item_ROOTID, 
								'lastNameFldID'                  => 'lastNameItem'.$item_ROOTID, 
								'clickIDName'                    => $item_cookie['clickIDName'],
								// ajax call
								'global_admin_ajax'  => $this->listfusion_ajx_url, 
								'itemClickNonce'     => wp_create_nonce( 'listfusion-click-nonce' ), 
								'userIP'             => $_SERVER["REMOTE_ADDR"],
								'addCSV'             => $csv_active,
								
							 );

				?>
<script type='text/javascript' src='<?php echo LIST_FUSION_FULLPATH; ?>lib/user-lib/clickslider/listfusion-clickslider.js?ver=1.3.2'></script>
<link rel="stylesheet" type="text/css" media="all" href="<?php echo LIST_FUSION_FULLPATH; ?>lib/user-lib/clickslider/<?php echo $slider_style; ?>/style.css" />
<script type="text/javascript">
	var listfusion_item_clickslider = <?php echo json_encode($op_arr); ?>;
</script>
				<?php
			  } // eof if
			}
		}	
}

/******************
 * SIDEBAR
******************/
function __listfusion_item_sidebar( $sidebarID ){
	global $wpdb;
	$listfusion_item_display_sidebar = " SELECT * FROM $this->listfusion_placement_table where (  item_type = 'sidebaroptin' OR item_type = 'sidebarad' ) 
						                 AND childid = '0' AND flag = '1' AND id = '$sidebarID' ";
	$item_display = $wpdb->get_row( $listfusion_item_display_sidebar, ARRAY_A );
	if( $item_display ) {
		
		$item_ROOTID = $item_display['id'];
		
		// Child Process
		$ab_sql_count = "SELECT COUNT(id) FROM $this->listfusion_placement_table where ( childid = '$item_ROOTID' ) AND 
																			 checkincount <= '0' AND flag = '1' ORDER BY RAND() limit 1 ";
		$total_ab_count = $wpdb->get_var( $ab_sql_count );
		 if ( $total_ab_count > 0) {
			  $ab_sql = "SELECT * FROM $this->listfusion_placement_table where ( childid = '$item_ROOTID' ) AND 
																			 checkincount <= '0' AND flag = '1' ORDER BY RAND() limit 1 ";
			  $item_display = $wpdb->get_row( $ab_sql, ARRAY_A );
			  if ($item_display != null) {
				  $sql_update_chkincount1 = "UPDATE $this->listfusion_placement_table SET checkincount='1' WHERE id='".$item_display['id']."'";
				  $wpdb->query( $sql_update_chkincount1 );
			  }
		  } else {
			  $sql_update_chkincount0 = "UPDATE $this->listfusion_placement_table SET 
										`checkincount` = '0'  
										 WHERE childid = '$item_ROOTID' order by ID ASC";
			  $wpdb->query( $sql_update_chkincount0 );							 
		  }
		// Eof child process
		
		$slider_style = $item_display_options['preview_type'];
		$item_display_options = $this->__listfusion_op_option_filter( unserialize($item_display['option_values']) );
		
		if(  $item_display['item_type'] == 'sidebarad' ) {
			if( (isset($item_display['cutelink']) && $item_display['cutelink'] != '') && (!$item_display['cutelink'] == 0) ) { 
				$ad_redirectURL = LIST_FUSION_SITEURL.'/'.$item_display['cutelink'];
			} else {
				$ad_redirectURL = $item_display_options['ad_redirecturl'];
			} 	
			
			if( $item_display_options['ad_linkopenin'] == 2 ) $ad_openIN = "_blank";
			else $ad_openIN = '_self';
		}
		
		$item_ROOTID = $item_display['id'];
		$arpID = $item_display['arp_id'];  
		$this->template_TrackingCode = $item_display['arp_trackingcode'];  
		$this->template_submit_btm_txt = $item_display['submit_txt']; 
		$this->replace_form_output = 1;
		$this->template_return_formdata = 2;
		
		$sidebar_style = $item_display_options['preview_type'];
		
		/* csv */
		$csv_query = "SELECT options FROM $this->listfusion_arp_table WHERE id='$arpID'";
		$csv_row = $wpdb->get_row($csv_query);
		$csv_options = unserialize($csv_row->options);
		if( $csv_options['connection_type'] == 2 && $csv_options['arp_store_in_csv_as_backup'] == 1 ) {
			$csv_active = $csv_options['arp_store_in_csv_as_backup'];
		} else if( $csv_options['connection_type'] == 3 ) {
			$csv_active = 2;
		}
		
		$template_btmbg_from        = $item_display_options['btm_from_color'];
		$template_btmbg_to          = $item_display_options['btm_to_color'];
		$template_btm_hoverbg_from  = $item_display_options['btm_from_hover_color'];
		$template_btm_hoverbg_to    = $item_display_options['btm_to_hover_color'];
		$template_btm_txt_color     = $item_display_options['submit_btm_text'];
		$template_submit_text_size  = $item_display_options['submit_font_size'];
		
		/* - Cookie */
		$item_cookie = unserialize($item_display['cookie']);
		
		$op_arr = array(
			// form valid + cookie + click
			'emailFldID'                     => 'emailItem'.$item_ROOTID, 
			'nameFldID'                      => 'nameItem'.$item_ROOTID,
			'firstNameFldID'                 => 'firstNameItem'.$item_ROOTID, 
			'lastNameFldID'                  => 'lastNameItem'.$item_ROOTID, 
			'clickIDName'                    => $item_cookie['clickIDName'],
			'displayItemID'                  => $item_ROOTID,
			// ajax call
			'global_admin_ajax'  => $this->listfusion_ajx_url, 
			'itemClickNonce'     => wp_create_nonce( 'listfusion-click-nonce' ), 
			'userIP'             => $_SERVER["REMOTE_ADDR"],
			'addCSV'             => $csv_active,
			
		 );

		$sessionID = $this->uniquesessionCount++;
		$this->template_data_sessionID = 'listfusionItemSidebar_'.$sessionID;
		wp_enqueue_script('deploy-listfusion-sidbear-show', LIST_FUSION_LIBPATH . 'user-lib/sidebar/listfusion-sidebar.js', array('jquery'), '1.0' );
		wp_localize_script(
				'deploy-listfusion-sidbear-show',
				'listfusionItemSidebar_' . $sessionID,
				$op_arr
			);
		wp_enqueue_style('listfusion-sidebar',LIST_FUSION_LIBPATH.'user-lib/sidebar/style.css',array(),'1.0');
		include('user-lib/sidebar/'.$sidebar_style.'/template.php');
	
	}
																	
}

/******************
 * WITH IN POST
******************/
function __listfusion_post_process( $post_content ){
		global $wpdb;
		$sql = "SELECT * FROM $this->listfusion_placement_table where (  item_type = 'withinpostoptin' OR 
																		 item_type = 'withinpostad' OR 
																		 item_type = 'withinpostsocial' ) 
																		 AND childid = '0' AND flag = '1' ";
		$listfusion_items_withinpost = $wpdb->get_results( $sql, ARRAY_A );
		if( $listfusion_items_withinpost ) { 
			foreach ( $listfusion_items_withinpost as $item_display ) {
				$item_ROOTID = $item_display['id']; 
				$item_display_options = $this->__listfusion_op_option_filter( unserialize($item_display['option_values']) );
				$displayin_all             = $item_display_options['display_in_all'];
				$displayin_home            = $item_display_options['display_in_home'];
				$displayin_frontpg         = $item_display_options['display_in_front'];
				$displayin_post            = $item_display_options['display_in_post'];
				$displayin_archive         = $item_display_options['display_in_archive'];
				$displayin_search          = $item_display_options['display_in_search'];
				$displayin_other           = $item_display_options['display_in_other'];
				$displayin_showInPostId    = $item_display_options['showOnPostWithID'];
				$displayin_dntshowInPostId = $item_display_options['dontShowOnPostWithID'];
				$displayin_pageID          = $item_display_options['display_in_pageid'];
				$displayin_CatIn           = $item_display_options['display_catIn'];
				$displayin_cat             = $item_display_options['display_in_cat'];
				$listfusion_item_DISPLAY = $this->listfusion_show_resultON($displayin_all, $displayin_frontpg, $displayin_home, $displayin_post, $displayin_archive, $displayin_search, $displayin_other, $displayin_showInPostId,  $displayin_dntshowInPostId, $displayin_pageID, $displayin_CatIn, $displayin_cat);
				if( $listfusion_item_DISPLAY == true ) {
					/* - Cookie */
					$item_cookie = unserialize($item_display['cookie']);
					$dontShowMeAfterSub_COOKIE = $item_cookie['dontShowAfterSubscribe'];
					if( isset($_COOKIE[$dontShowMeAfterSub_COOKIE]) && $_COOKIE[$dontShowMeAfterSub_COOKIE] == 1 ) continue;
					
					// Child Process
					$ab_sql_count = "SELECT COUNT(id) FROM $this->listfusion_placement_table where ( childid = '$item_ROOTID' ) AND 
																						 checkincount <= '0' AND flag = '1' ORDER BY RAND() limit 1 ";
					$total_ab_count = $wpdb->get_var( $ab_sql_count );
					 if ( $total_ab_count > 0) {
						  $ab_sql = "SELECT * FROM $this->listfusion_placement_table where ( childid = '$item_ROOTID' ) AND 
																						 checkincount <= '0' AND flag = '1' ORDER BY RAND() limit 1 ";
						  $item_display = $wpdb->get_row( $ab_sql, ARRAY_A );
						  if ($item_display != null) {
							  $sql_update_chkincount1 = "UPDATE $this->listfusion_placement_table SET checkincount='1' WHERE id='".$item_display['id']."'";
							  $wpdb->query( $sql_update_chkincount1 );
						  }
						  $item_display_options = $this->__listfusion_op_option_filter( unserialize($item_display['option_values']) );
					  } else {
						  $sql_update_chkincount0 = "UPDATE $this->listfusion_placement_table SET 
													`checkincount` = '0'  
													 WHERE childid = '$item_ROOTID' order by ID ASC";
						  $wpdb->query( $sql_update_chkincount0 );							 
					  }
					// Eof child process
					
					if(  $item_display['item_type'] == 'withinpostad' ) {
						if( (isset($item_display['cutelink']) && $item_display['cutelink'] != '') && (!$item_display['cutelink'] == 0) ) { 
							$ad_redirectURL = LIST_FUSION_SITEURL.'/'.$item_display['cutelink'];
						} else {
							$ad_redirectURL = $item_display_options['ad_redirecturl'];
						} 	
						
						if( $item_display_options['ad_linkopenin'] == 2 ) $ad_openIN = "_blank";
						else $ad_openIN = '_self';
						
					} else if(  $item_display['item_type'] == 'withinpostsocial' ) {
						$listfusionSocial_curPageURL = $this->__listfusion_curPageURL();
							if (!get_option('listfusion_disable_facebookJS') || is_admin()) {
								wp_enqueue_script('fbsdk', 'https://connect.facebook.net/en_GB/all.js#xfbml=1', array());
								wp_localize_script('fbsdk', 'fbsdku', array( 'xfbml' => 1, ));
							}
							if (!get_option('listfusion_disable_googleplusJS') || is_admin()) {
								wp_enqueue_script('plusone', 'https://apis.google.com/js/plusone.js', array());
							}
							if (!get_option('listfusion_disable_twitterJS') || is_admin()) {
								wp_enqueue_script('twitter', 'https://platform.twitter.com/widgets.js', array());
							}
							if (!get_option('listfusion_disable_linkedInJS') || is_admin()) {
								wp_enqueue_script('linkedin', 'http://platform.linkedin.com/in.js', array());
							}
							if (!get_option('listfusion_disable_pinterestJS') || is_admin()) {
								wp_enqueue_script('pinterest', 'https://assets.pinterest.com/js/pinit.js', array());
							}
					}
					
					/* - id */
					$item_ROOTID = $item_display['id']; 
					$arpID = $item_display['arp_id'];  
					$withinpost_style = $item_display_options['preview_type'];
					$this->template_TrackingCode = $item_display['arp_trackingcode'];  
					$this->template_submit_btm_txt = $item_display['submit_txt']; 
					$this->template_return_formdata = 1;
					$this->replace_form_output = 1;
					
					/* csv */
					$csv_query = "SELECT options FROM $this->listfusion_arp_table WHERE id='$arpID'";
					$csv_row = $wpdb->get_row($csv_query);
					$csv_options = unserialize($csv_row->options);
					if( $csv_options['connection_type'] == 2 && $csv_options['arp_store_in_csv_as_backup'] == 1 ) {
						$csv_active = $csv_options['arp_store_in_csv_as_backup'];
					} else if( $csv_options['connection_type'] == 3 ) {
						$csv_active = 2;
					}
					
					// Disable popup for X days once user subscriber or click on ad
					if( $item_display_options['once_subscribe_disable_for'] == '' ) $chk_sub_disable = 'null';
					else  $chk_sub_disable = 'true';
					$once_subscribe_disable_for = $item_display_options['once_subscribe_disable_for'];
					
					$op_arr = array(
						// form valid + cookie + click
						'emailFldID'                     => 'emailItem'.$item_ROOTID, 
						'nameFldID'                      => 'nameItem'.$item_ROOTID,
						'firstNameFldID'                 => 'firstNameItem'.$item_ROOTID, 
						'lastNameFldID'                  => 'lastNameItem'.$item_ROOTID, 
						'afterSubs_SetCookieOrNot'       => $chk_sub_disable,
						'DontShowMeAfterSub_COOKIE_Name' => $dontShowMeAfterSub_COOKIE,
						'after_subscribe_block_days'     => $once_subscribe_disable_for,
						'clickIDName'                    => $item_cookie['clickIDName'],
						'displayItemID'                  => $item_ROOTID,
						// ajax call
						'global_admin_ajax'  => $this->listfusion_ajx_url, 
						'itemClickNonce'     => wp_create_nonce( 'listfusion-click-nonce' ), 
						'userIP'             => $_SERVER["REMOTE_ADDR"],
						'addCSV'             => $csv_active,
					 );
					 
					$template_btmbg_from        = $item_display_options['btm_from_color'];
					$template_btmbg_to          = $item_display_options['btm_to_color'];
					$template_btm_hoverbg_from  = $item_display_options['btm_from_hover_color'];
					$template_btm_hoverbg_to    = $item_display_options['btm_to_hover_color'];
					$template_btm_txt_color     = $item_display_options['submit_btm_text'];
					$template_submit_text_size  = $item_display_options['submit_font_size'];
					$template_title_text_size   = $item_display_options['field_header_size'];
					$template_background        = $item_display_options['field_img_url'];
					
					$sessionID = $this->uniquesessionCount++;
					$this->template_data_sessionID = 'listfusionItemWithinPost_'.$sessionID;
					wp_enqueue_script('deploy-listfusion-sidbear-show', LIST_FUSION_LIBPATH . 'user-lib/sidebar/listfusion-sidebar.js', array('jquery'), '1.0' );
					wp_localize_script(
							'deploy-listfusion-sidbear-show',
							'listfusionItemWithinPost_' . $sessionID,
							$op_arr
						);
					wp_enqueue_style('deploy-listfusion-sidbear-show',LIST_FUSION_LIBPATH.'user-lib/withinpost/style.css',array(),'1.0');
					include('user-lib/withinpost/'.$withinpost_style.'/template.php');
					$post_content = $post_content.$optin_form;
				}
			}
		}			  															
		return $post_content;														
}



/***********************
** INSIDE COMMENT BOX **
***********************/

	/**
	* Check to show how many times optin form to display.
	*/
	function listfusion_checkCommenterComment($email, $position_from, $position_to) {
		global $wpdb;
		if( $email != '' ) {
			$embeded_table = $this->listfusion_insidecomment_table; 
			$to_show_value = ($position_to - $position_from) + 1;
			#check if email exists in our table
			$query_embeded = "SELECT COUNT(id) FROM ". $embeded_table ." WHERE email='" . trim($email) . "'";
			$rs_embeded = $wpdb->get_var( $query_embeded );
			#if not in our table grab from the wp_comment(for new commentator)
			if ($rs_embeded == 0) {
				$query_comment 		= "SELECT COUNT(comment_ID) FROM $this->wordpress_comments_table WHERE comment_author_email='" . trim($email) . "'";
				$total_comment = $wpdb->get_var( $query_comment );
				$original_comment	= $total_comment - 1;
				#insert in embeded table
				$query_embeded_insert = "INSERT INTO 
													". $embeded_table ."(email,embeded,original_comment)
										 VALUES('$email', '0', '$original_comment')";
				$wpdb->query( $query_embeded_insert );						 
			} 
			$query_embeded_val = "SELECT embeded FROM ". $embeded_table ." WHERE email='" . $email . "'";
			$rs_embeded_val = $wpdb->get_row( $query_embeded_val );
			#first time comment process when embeded counter=0
			if ($rs_embeded_val->embeded == 0) {
				$query_select_wp_comment = "SELECT 
													COUNT(comment_ID)
											FROM 
												$this->wordpress_comments_table 
											WHERE 
												comment_author_email='" . $email . "'";
				$total_wp_comment = $wpdb->get_var( $query_select_wp_comment );
				$query_select_embeded	= "SELECT 
												original_comment 
										   FROM 
												". $embeded_table ."
										   WHERE
												email='" . $email . "'";
				$rs_select_embeded		= $wpdb->get_row($query_select_embeded);
				$range					= $total_wp_comment - $rs_select_embeded->original_comment;
				#update embeded counter when value within range
				if ($range >=$position_from && $range <= $position_to) {
					$query_update_embeded = "UPDATE ". $embeded_table ." SET embeded=embeded+1 WHERE email='" . $email . "'";
					$wpdb->query( $query_update_embeded );
					$show_embeded		  = 1;
				}																					
			} 
			else if(($rs_embeded_val->embeded > 0) && ($rs_embeded_val->embeded < $to_show_value)) {
				#when commentator comments 2nd time and so on[also range can change]
				$query_update_embeded = "UPDATE ". $embeded_table ." SET embeded=embeded+1 WHERE email='" . $email . "'";
				$wpdb->query( $query_update_embeded );
				$show_embeded		  = 1;			
			}
			return $show_embeded;
		
		}
	}											

	function __listfusion_showOptinFormInsideComment( $comment_txt, $comment ) {
		global $wpdb;
	    error_reporting(E_ALL ^ E_NOTICE); 
		$this->auto_comment_author		 = $comment->comment_author;
		$this->auto_comment_author_email = $comment->comment_author_email;
		$sql = "SELECT * FROM $this->listfusion_placement_table where (  item_type = 'icboxoptin' OR 
																item_type = 'icboxad' ) 
																AND childid = '0' AND flag = '1' ";
		$listfusion_items_insidecmtbox = $wpdb->get_results( $sql );
		if( $listfusion_items_insidecmtbox ) { 
			foreach ( $listfusion_items_insidecmtbox as $item_display ) {
					  $item_ROOTID = $item_display->id;
					  
					  // Child Process
					  $ab_sql_count = "SELECT COUNT(id) FROM $this->listfusion_placement_table where ( childid = '$item_ROOTID' ) AND 
																						 checkincount <= '0' AND flag = '1' ORDER BY RAND() limit 1 ";
					  
					  $total_ab_count = $wpdb->get_var( $ab_sql_count );
					  if ( $total_ab_count > 0) {
						  $ab_sql = "SELECT * FROM $this->listfusion_placement_table where ( childid = '$item_ROOTID' ) AND 
																						 checkincount <= '0' AND flag = '1' ORDER BY RAND() limit 1 ";
					      $item_display = $wpdb->get_row( $ab_sql );
						  if ($item_display != null) {
							  $sql_update_chkincount1 = "UPDATE $this->listfusion_placement_table SET checkincount='1' WHERE id='".$item_display->id."'";
							  $wpdb->query( $sql_update_chkincount1 );
						  }
						  
					  } else {
						  $sql_update_chkincount0 = "UPDATE $this->listfusion_placement_table SET 
													`checkincount` = '0'  
													 WHERE childid = '$item_ROOTID' order by ID ASC";
						  $wpdb->query( $sql_update_chkincount0 );							 
					  }
					// Eof child process
					
					$item_display_options = $this->__listfusion_op_option_filter( unserialize($item_display->option_values) );
					$sidebar_style              = $item_display_options['preview_type'];
					$template_btmbg_from        = $item_display_options['btm_from_color'];
					$template_btmbg_to          = $item_display_options['btm_to_color'];
					$template_btm_hoverbg_from  = $item_display_options['btm_from_hover_color'];
					$template_btm_hoverbg_to    = $item_display_options['btm_to_hover_color'];
					$template_btm_txt_color     = $item_display_options['submit_btm_text'];
					$template_submit_text_size  = $item_display_options['submit_font_size'];
					$position_from              = $item_display_options['insideComment_displayfrom'];
					$position_to                = $item_display_options['insideComment_displayto'];
					$template_title_text_size   = $item_display_options['field_header_size'];
				
					if(  $item_display->item_type == 'icboxad' ) {
						if( (isset($item_display->cutelink) && $item_display->cutelink != '') && (!$item_display->cutelink == 0) ) { 
							$ad_redirectURL = LIST_FUSION_SITEURL.'/'.$item_display->cutelink;
						} else {
							$ad_redirectURL = $item_display_options['ad_redirecturl'];
						} 	
						
						if( $item_display_options['ad_linkopenin'] == 2 ) $ad_openIN = "_blank";
						else $ad_openIN = '_self';
					}
				
					$item_ROOTID = $item_display->id;
					$arpID = $item_display->arp_id;  
					$this->template_TrackingCode = $item_display->arp_trackingcode;  
					$this->template_submit_btm_txt = $item_display->submit_txt; 
					$this->replace_form_output = 1;
					$this->template_return_formdata = 1;
				
					/* csv */
					$csv_query = "SELECT options FROM $this->listfusion_arp_table WHERE id='$arpID'";
					$csv_row = $wpdb->get_row($csv_query);
					$csv_options = unserialize($csv_row->options);
					if( $csv_options['connection_type'] == 2 && $csv_options['arp_store_in_csv_as_backup'] == 1 ) {
						$csv_active = $csv_options['arp_store_in_csv_as_backup'];
					} else if( $csv_options['connection_type'] == 3 ) {
						$csv_active = 2;
					}
				
					/* - Cookie */
					$item_cookie = unserialize($item_display->cookie);
					$op_arr = array(
						// form valid + cookie + click
						'emailFldID'         => 'emailItem'.$item_ROOTID, 
						'nameFldID'          => 'nameItem'.$item_ROOTID,
						'firstNameFldID'     => 'firstNameItem'.$item_ROOTID, 
						'lastNameFldID'      => 'lastNameItem'.$item_ROOTID, 
						'clickIDName'        => $item_cookie['clickIDName'],
						'displayItemID'      => $item_ROOTID,
						// ajax call
						'global_admin_ajax'  => $this->listfusion_ajx_url, 
						'itemClickNonce'     => wp_create_nonce( 'listfusion-click-nonce' ), 
						'userIP'             => $_SERVER["REMOTE_ADDR"],
						'addCSV'             => $csv_active,
					 );
					
					/* - session control */
					$sessionID = $this->uniquesessionCount++;
					$this->template_data_sessionID = 'listfusionItemInsideCmtBox_'.$sessionID;
				
					if ($comment->comment_ID == $_SESSION['LISTFUSION_CURR_COMMENT_ID'] && 
						$this->listfusion_checkCommenterComment($this->auto_comment_author_email, $position_from, $position_to) == 1 
					   ) {	
						wp_enqueue_script('deploy-listfusion-sidbear-show', LIST_FUSION_LIBPATH . 'user-lib/sidebar/listfusion-sidebar.js', array('jquery'), '1.0' );
						wp_localize_script(
								'deploy-listfusion-sidbear-show',
								'listfusionItemInsideCmtBox_' . $sessionID,
								$op_arr
							);
				   		wp_enqueue_style('listfusion-insidecommentbox',LIST_FUSION_LIBPATH.'user-lib/icbox/style.css',array(),'1.0');
				   		include('user-lib/icbox/'.$sidebar_style.'/template.php');
						$comment_txt = $comment_txt.'<div style="clear:both"></div><br>'.$insideCommentBox;
						unset($_SESSION['LISTFUSION_CURR_COMMENT_ID']);
					} else { 
						$comment_txt = '<span style="font-weight:normal">'.$comment_txt.'</span>';						
					}	
					return $comment_txt;
			}// eof foreach
		} else {
			return $comment_txt;
		}
	}


} // Eof Class
$ListFusionPluginPro = new ListFusionPluginPro();

?>