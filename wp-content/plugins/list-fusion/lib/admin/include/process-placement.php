<?php
global $wpdb; 
/********** 
** POPUP PROCESS ADD/EDIT RECORDS 
***********/
	$today = date("Y/m/d");
/********** 
** SQUEEZEPG ADD/EDIT RECORDS 
***********/
	if( $this->process_squeezepg == 'Save' ) {
		// cookie
		$DntShowMeAgain_COOK1 = 'listfusion_DntShowMeAgain'.date('YmdHis');
		$DntShowAfterSubscribe_COOK1 = 'listfusion_DntShowMeAfterSubscribe'.date('YmdHis');
		$clickIDName_COOK1 = 'listfusion_clickIDName'.date('YmdHis');
		$Disable_OnClickCloseBTM_COOK1 = 'listfusion_disableOnClickCloseBtm'.date('YmdHis');
		$schedule_COOK1 = 'listfusion_DisplayOnEveryDays'.date('YmdHis');
		$schedule_COOK2 = 'listfusion_DisplayForFirstVisits'.date('YmdHis');
		$schedule_COOK3 = 'listfusion_DisplayAfterVisits'.date('YmdHis');
		$group_cookie = serialize(array('dontShowMeAgain' => ''.$DntShowMeAgain_COOK1.'', 
										'dontShowAfterSubscribe' => ''.$DntShowAfterSubscribe_COOK1.'',
										'clickIDName' => ''.$clickIDName_COOK1.'', 
										'disableOnClickCloseBtm' =>''.$Disable_OnClickCloseBTM_COOK1.'',
										'schedule' => ''.$schedule_COOK1.','.$schedule_COOK2.','.$schedule_COOK3.''
									 ));
	
		// db Process.
		foreach ( (array) $this->listfusion_Postrequest as $key => $val ) {
			if ( $key == 'displayname' ) $displayname = $val;
			else if ( $key == 'field_header' ) $field_header = $val;
			else if ( $key == 'field_main_msg' ) $field_main_msg = $val;
			else if ( $key == 'field_security_note' ) $field_security_note = $val;
			else if ( $key == 'field_button_text' ) $field_button_text = $val;
			else if ( $key == 'field_video_code' ) $video_code = $val;
			else if ( $key == 'split_id' ) $child_id = $val; // only: split test
			else if ( $key == 'selected_arp' ) $selected_arp = $val;
			else if ( $key == 'field_list_points' ) $field_list_points = $val;
			else if ( $key == 'field_optinmsg' ) $field_optinmsg = $val;
			else if ( $key != 'next_step' ) $other_options[$key] = $this->__listfusion_escape_query($val);
		}
		$option_values = serialize($other_options);
		$field_list_points = serialize($field_list_points);
		
		if( isset($_GET['id']) && $_GET['action'] == 'aesqpg') {
			$db_update_query = "UPDATE $this->listfusion_placement_table SET 
								item_name = '$displayname',
								arp_id = '$selected_arp',
								childid = '$child_id',
								title = '$field_header', 
								msg = '$field_main_msg', 
								security_note = '$field_security_note', 
								submit_txt = '$field_button_text', 
								video_code = '$video_code',
								optin_msg = '$field_optinmsg', 
								list_points = '$field_list_points',
								option_values = '$option_values'
								WHERE id='".$_GET['id']."'";
			$wpdb->query($db_update_query);
			echo '<script>window.location.href="'.$this->listfusion_page.'sts=2"</script>';
		} else {
			$db_insert_query = "INSERT INTO $this->listfusion_placement_table ( item_name, 
																		 item_type, 
																		 arp_id,
																		 childid,
																		 option_values,
																		 title, 
																		 msg,
																		 security_note,
																		 submit_txt,
																		 video_code,
																		 list_points,
																		 optin_msg,
																		 cookie,
																		 flag, 
																		 add_date ) 
								VALUES( '$displayname', 
										'squeezepg',
										'$selected_arp', 
										'$child_id',
										'$option_values', 
										'$field_header', 
										'$field_main_msg',
										'$field_security_note',
										'$field_button_text',
										'$video_code',
										'$field_list_points',
										'$field_optinmsg',
										'$group_cookie',
										'1',
										'$today' )";
			$wpdb->query($db_insert_query);
			echo '<script>window.location.href="'.$this->listfusion_page.'sts=1"</script>';
		}
	} 
	
/********** 
** POPUP ADD/EDIT RECORDS 
***********/
	
	if( $this->process_popup == 'Save' || 
	    $this->process_clickslider == 'Save' || 
		$this->process_sidebar == 'Save' || 
		$this->process_witinpost == 'Save' || 
		$this->process_icbox == 'Save' ) {
	
		//print_r($this->listfusion_Postrequest);
		// cookie
		$DntShowMeAgain_COOK1 = 'listfusion_DntShowMeAgain'.date('YmdHis');
		$DntShowAfterSubscribe_COOK1 = 'listfusion_DntShowMeAfterSubscribe'.date('YmdHis');
		$clickIDName_COOK1 = 'listfusion_clickIDName'.date('YmdHis');
		$Disable_OnClickCloseBTM_COOK1 = 'listfusion_disableOnClickCloseBtm'.date('YmdHis');
		$schedule_COOK1 = 'listfusion_DisplayOnEveryDays'.date('YmdHis');
		$schedule_COOK2 = 'listfusion_DisplayForFirstVisits'.date('YmdHis');
		$schedule_COOK3 = 'listfusion_DisplayAfterVisits'.date('YmdHis');
		$group_cookie = serialize(array('dontShowMeAgain' => ''.$DntShowMeAgain_COOK1.'', 
										'dontShowAfterSubscribe' => ''.$DntShowAfterSubscribe_COOK1.'',
										'clickIDName' => ''.$clickIDName_COOK1.'', 
										'disableOnClickCloseBtm' =>''.$Disable_OnClickCloseBTM_COOK1.'',
										'schedule' => ''.$schedule_COOK1.','.$schedule_COOK2.','.$schedule_COOK3.''
									 ));
		// popup type 
		$popup_type = $this->listfusion_Postrequest['fusionType'];
		// process
		foreach ( (array) $this->listfusion_Postrequest as $key => $val ) {
			if ( $key == 'displayname' ) $displayname = trim($val);
			else if ( $key == 'fusionType' ) $fusionType = $val;
			else if ( $key == 'field_header' ) $field_header = $val;
			else if ( $key == 'field_main_msg' ) $field_main_msg = $val;
			else if ( $key == 'field_security_note' ) $field_security_note = $val;
			else if ( $key == 'field_button_text' ) $field_button_text = $val;
			else if ( $key == 'arp_trackingcode' ) $arp_trackingcode = $val;
			else if ( $key == 'field_video_code' ) $videoCode = $val;
			else if ( $key == 'item_click_close_linktext' ) $item_close_linktext = $val;
			else if ( $key == 'field_list_points' ) $field_list_points =  $this->__listfusion_escape_query($val);
			else if ( $key == 'selected_arp' ) $selected_arp = $val;
			else if ( $key == 'split_id' ) $child_id = $val; // only: split test
			else if ( $key == 'displayname' ) $fusion_displayname = $val;
			else if ( $key == 'soical_twitter_msg' ) $soical_twitter_msg = $val;
			else if ( $key == 'social_pinterest_messange' ) $social_pinterest_messange = $val;
			else if ( $key == 'ad_cutelink' ) $cutelink = $val;
			else if ( $key == 'field_admsg' ) $field_admsg = $val;
			else if ( $key == 'field_socialmsg' ) $field_socialmsg = $val;
			else if ( $key == 'field_optinmsg' ) $field_optinmsg = $val;
			else if ( $key == 'field_js_htmlpopup_alert' ) $field_js_htmlpopup_alert = $val;
			else if ( $key == 'field_customcss' ) $field_customcss = $val;
			else if ( $key != 'popup_next_step' ) $option_values[$key] = $this->__listfusion_escape_query($val);
		}
		
		$option_values = serialize($option_values);
		$field_list_points = serialize($field_list_points);
		
		if( isset($_POST['custom_popup_content']) && $_POST['custom_popup_content'] != '' ) {
			$field_custom_msg_main_msg = $_POST['custom_popup_content'];
		}
		
		if( isset($_GET['id']) && ($_GET['action'] == 'aepopup' || 
								   $_GET['action'] == 'clkslider' || 
								   $_GET['action'] == 'sidebar' || 
								   $_GET['action'] == 'icbox' || 
								   $_GET['action'] == 'witinpost')  ) {
			$db_update_query = "UPDATE $this->listfusion_placement_table SET 
								item_name = '$displayname',
								item_type = '$fusionType', 
								arp_id = '$selected_arp',
								childid = '$child_id', 
								option_values = '$option_values', 
								title = '$field_header', 
								msg = '$field_main_msg', 
								custom_msg = '$field_custom_msg_main_msg', 
								security_note = '$field_security_note', 
								submit_txt = '$field_button_text', 
								list_points = '$field_list_points', 
								video_code = '$videoCode', 
								arp_trackingcode = '$arp_trackingcode', 
								item_close_linktext = '$item_close_linktext', 
								item_social_twtter_txt = '$soical_twitter_msg', 
								item_social_pinterest_txt = '$social_pinterest_messange',
								cutelink = '$cutelink',
								ad_msg = '$field_admsg',
								social_msg = '$field_socialmsg',
								optin_msg = '$field_optinmsg',
								exit_htmljs_msg = '$field_js_htmlpopup_alert',
								custom_css_code = '$field_customcss'
								WHERE id='".$_GET['id']."'";
			$wpdb->query($db_update_query);
			echo '<script>window.location.href="'.$this->listfusion_page.'sts=2"</script>';
		} else {
			$db_insert_query = "INSERT INTO $this->listfusion_placement_table ( item_name, 
																				item_type, 
																				arp_id,
																				childid, 
																				option_values,
																				title,
																				msg,
																				custom_msg,
																				security_note,
																				submit_txt,
																				list_points,
																				video_code,
																				arp_trackingcode,
																				item_close_linktext,
																				item_social_twtter_txt,
																				item_social_pinterest_txt,
																				cutelink,
																				ad_msg,
																				social_msg,
																				optin_msg,
																				exit_htmljs_msg,
																				custom_css_code,
																				cookie,
																				flag, 
																				add_date ) 
								VALUES( '$displayname', 
										'$fusionType', 
										'$selected_arp', 
										'$child_id', 
										'$option_values', 
										'$field_header',
										'$field_main_msg',
										'$field_custom_msg_main_msg',
										'$field_security_note',
										'$field_button_text',
										'$field_list_points',
										'$videoCode',
										'$arp_trackingcode',
										'$item_close_linktext',
										'$soical_twitter_msg',
										'$social_pinterest_messange',
										'$cutelink',
										'$field_admsg',
										'$field_socialmsg',
										'$field_optinmsg',
										'$field_js_htmlpopup_alert',
										'$field_customcss',
										'$group_cookie',
										'1',
										'$today' )";
			$wpdb->query($db_insert_query);
			echo '<script>window.location.href="'.$this->listfusion_page.'sts=1"</script>';
		}
		
	}

/********** 
** EXIT JS POPUP PROCESS ADD/EDIT RECORDS 
***********/

	if( $this->process_exitjspopup == 'Save' ) {  
		// db Process.
		foreach ( (array) $this->listfusion_Postrequest as $key => $val ) {
			if ( $key == 'exitjspopup_name' ) $exitjspopup_name = $val;
			else if ( $key == 'exitjspopup_msg' ) $exitjspopup_msg = $val;
			else if ( $key != 'next_step' ) $other_options[$key] = $this->__listfusion_escape_query($val);
		}
		$listfusion_options = serialize($other_options);
		$item_type = 'exit_js_popup';
		
		if( isset($_GET['id']) && $_GET['action'] == 'aejsp') {
			$db_update_query = "UPDATE $this->listfusion_placement_table SET 
								item_name = '$exitjspopup_name',
								item_type = '$item_type', 
								option_values = '$listfusion_options',
								msg = '$exitjspopup_msg' 
								WHERE id='".$_GET['id']."'";
			$wpdb->query($db_update_query);
			echo '<script>window.location.href="'.$this->listfusion_page.'sts=2"</script>';
		} else {
			$db_insert_query = "INSERT INTO $this->listfusion_placement_table ( item_name, 
																		 item_type, 
																		 option_values,
																		 msg, 
																		 flag, 
																		 add_date ) 
								VALUES( '$exitjspopup_name', 
										'$item_type', 
										'$listfusion_options', 
										'$exitjspopup_msg', 
										'1',
										'$today' )";
			$wpdb->query($db_insert_query);
			echo '<script>window.location.href="'.$this->listfusion_page.'sts=1"</script>';
		}
	}
?>