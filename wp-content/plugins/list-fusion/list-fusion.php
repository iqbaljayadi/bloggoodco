<?php
/* 
 * Plugin Name:   List Fusion 
 * Version:       2.0
 * Plugin URI:    http://www.wpsmartapps.com/
 * Description:   Power up your wordpress blog and grab visitor's information (name, email, etc) on a fly using, Enormous features provided by List Fusion which is capable to boost your income and list size more than 900% in just a single day.&nbsp;&nbsp;<a href="admin.php?page=listfusion">Click Here</a>
 * Author:        WpSmartApps.com
 * Author URI:    http://www.wpsmartapps.com
 *
 * License: Copyright (c) 2014 WpSmartApps.com. All rights reserved.
 *  
 */
$listfusion_path     = preg_replace('/^.*wp-content[\\\\\/]plugins[\\\\\/]/', '', __FILE__);
$listfusion_path     = str_replace('\\','/',$listfusion_path);
$listfusion_dir      = substr($listfusion_path,0,strrpos($listfusion_path,'/'));
$listfusion_siteurl  = get_bloginfo('wpurl');
$listfusion_version  = floatval(get_bloginfo('version'));
$listfusion_siteurl  = (strpos($listfusion_siteurl,'http://') === false) ? get_bloginfo('wpurl') : $listfusion_siteurl;
$listfusion_fullpath = $listfusion_siteurl.'/wp-content/plugins/'.$listfusion_dir.'/';
$listfusion_relpath  = str_replace('\\','/',dirname(__FILE__));
$listfusion_libpath  = $listfusion_fullpath.'lib/';
$listfusion_abspath  = str_replace("\\","/",ABSPATH); 
$listfusion_adminURL = admin_url('admin-ajax.php');
define('LIST_FUSION_BLOGURL', get_bloginfo('wpurl'));
define('LIST_FUSION_ABSPATH', $listfusion_abspath);
define('LIST_FUSION_PATH', $listfusion_path);
define('LIST_FUSION_FULLPATH', $listfusion_fullpath);
define('LIST_FUSION_LIBPATH', $listfusion_libpath);
define('LIST_FUSION_RELPATH', $listfusion_relpath);
define('LIST_FUSION_SITEURL', $listfusion_siteurl);
define('LIST_FUSION_ADMIN_URL', $listfusion_adminURL);
define('LIST_FUSION_WP_VERSION', $listfusion_version);
define('LIST_FUSION_NAME', 'List Fusion');
define('LIST_FUSION_VERSION', '2.0');
require_once($listfusion_relpath.'/lib/list-fusion.cls.php');

/** List Fusion Class*/
class ListFusionPlugin  extends ListFusionPluginPro {
	
	/** 
	* Call admin menus
	*/
	function listfusion_adminMenu(){
	add_menu_page(LIST_FUSION_NAME, LIST_FUSION_NAME, 'edit_pages', 'listfusion', array(&$this, '__listfusion_dashboard'), LIST_FUSION_LIBPATH . 'images/icon.png',  null);
	add_submenu_page('listfusion', LIST_FUSION_NAME .' | Autoresponder Manager', 'Autoresponder Manager', 'edit_pages', 'listfusion-arp', array(&$this, '__listfusion_arp'));
	add_submenu_page('listfusion', LIST_FUSION_NAME .' | CSV', 'Created .CSV Files', 'edit_pages', 'listfusion-csv', array(&$this, '__listfusion_csv'));
	/*eof optin*/
	add_submenu_page('listfusion', LIST_FUSION_NAME .' | Send Email to First Commentator', 'Send Email to First Commentator', 'edit_pages', 'listfusion-send-email', array(&$this, '__listfusion_send_email_to_first_commentator'));
	add_submenu_page('listfusion', LIST_FUSION_NAME .' | Settings', 'Settings', 'edit_pages', 'listfusion-settings', array(&$this, '__listfusion_settings'));
	
	// Add Custom Fields
	if ( function_exists( 'add_meta_box' ) ) {
	add_meta_box( 'listfusion-szpgcustom-fields', 'List Fusion :: Squeeze Page ', array( &$this, 'listfusion_pg_squeeze' ), 'page', 'normal', 'high' );
	}
	
	}
	/** 
	* Constructor 
	*/
	function ListFusionPlugin() {
		global $table_prefix, $wp_version;
		$this->listfusion_ajx_url = admin_url( 'admin-ajax.php' );
		$this->listfusion_page = 'admin.php?'.'page='.$_GET['page'].'&';
		$this->listfusion_special_red_page = 'admin.php?';
		// database table 
		$this->listfusion_arp_table	     = $table_prefix.$this->listfusion_arp_table;
		$this->listfusion_options_table	 = $table_prefix.$this->listfusion_options_table;
		$this->listfusion_firstCommentator_table = $table_prefix.$this->listfusion_firstCommentator_table;
		$this->listfusion_placement_table = $table_prefix.$this->listfusion_placement_table;
		$this->listfusion_status_table  = $table_prefix.$this->listfusion_status_table;
		$this->listfusion_insidecomment_table = $table_prefix.$this->listfusion_insidecomment_table;
		// wordpress default tables
		$this->wordpress_comments_table  = $table_prefix . $this->wordpress_listfusion_comments_table;
		$this->wordpress_posts_table  	 = $table_prefix . $this->wordpress_listfusion_posts_table;
		$this->wordpress_users_table  	 = $table_prefix . $this->wordpress_listfusion_users_table;
		$this->list_fusion_img = '<img src="'.LIST_FUSION_LIBPATH.'/images/list-fusion.png">';
		// Plugin activate  actions, filters.
		add_action('activate_'.LIST_FUSION_PATH, array(&$this, 'listfusion_active')); 
		add_filter('plugin_action_links', array(&$this,'listfusion_actions'), 10, 2 );
		add_filter('plugin_row_meta', array(&$this, 'listfusion_meta_links'), 10, 2);
		// Plugin admin home page actions.
		add_action('admin_notices', array(&$this, '__listfusion_notify'));  
		add_action('admin_menu', array(&$this, 'listfusion_adminMenu'));
		add_action('admin_head', array(&$this, '__listfusion_admin_header'));
		add_action('wp_print_scripts', array(&$this, 'listfusion_print_scripts'));
		add_action('wp_enqueue_scripts', array(&$this, 'listfusion_scripts_name'));
		add_action('template_redirect', array(&$this, 'listfusion_setCookie'));
		add_action('init', array(&$this, '__listfusion_custom'));
		add_filter('the_content', array(&$this, 'listfusion_postprocess'));
		add_filter('comment_text', array(&$this, 'listfusion_showOptinFrmInsideComment'));
		add_action('comment_post', array(&$this, 'listfusion_latestCommentId'));
		//- meta
		add_action('edit_post', array(&$this, 'listfusion_sqpg_metaData'));
		add_action('save_post', array(&$this, 'listfusion_sqpg_metaData'));
		add_action('publish_post', array(&$this, 'listfusion_sqpg_metaData'));
		// Otp - popup
		add_action('wp_head', array(&$this, 'listfusion_jscss_action'), 30);
		// ARP Internal call
		add_action('wp_ajax_nopriv_listfusionAPI-call', array(&$this, '__listfusionAPI_process'));
		add_action('wp_ajax_listfusionAPI-call', array(&$this, '__listfusionAPI_process'));
		//-	S.RST
		add_action('comment_post',array(&$this, 'listfusion_sendEmailTo_FirstCommentator'),10,2); // SETFBC
		add_action('wp_set_comment_status', array(&$this,'listfusion_sendEmailTo_ApproveComment'),10,2); // SETFBC	
		add_action('wp_footer', array(&$this, 'listfusion_footerAction'), 30); // EJP
		// Stats
		add_action('wp_ajax_nopriv_listfusionRstStats', array(&$this, '__listfusionRstStats_process'));
		add_action('wp_ajax_listfusionRstStats', array(&$this, '__listfusionRstStats_process'));
		add_action('wp_ajax_nopriv_listfusionAnalyticsCALL', array(&$this, '__listfusion_analytics_call'));
		add_action('wp_ajax_listfusionAnalyticsCALL', array(&$this, '__listfusion_analytics_call'));
		// Prev-Demo
		add_action('wp_ajax_nopriv_listfusionDEMOcall', array(&$this, '__listfusionDemo_process'));
		add_action('wp_ajax_listfusionDEMOcall', array(&$this, '__listfusionDemo_process'));
		// user - style
		add_action('wp_ajax_loadListfusion_itemstyle', array(&$this, 'listfusionLoadExtraClass'));
		add_action('wp_ajax_nopriv_loadListfusion_itemstyle', array(&$this, 'listfusionLoadExtraClass'));

	}
	/**
	 * Called when plugin is activated. 
	 */
	function listfusion_active(){  
		$listfusion_arpTable  = $this->__listfusion_arp_table();
		$listfusion_options = $this->__listfusion_options_table();
		$listfusion_firstCommentator = $this->__listfusion_firstCommentator_table();
		$listfusion_optinPlacement = $this->__listfusion_placement_table();
		$listfusion_status_table = $this->__listfusion_stats_table();
		$listfusion_insidecomment = $this->__listfusion_insidecomment_table();
		if ( $listfusion_options == true ) $this->__listfusion_optionData();
		return true;
	}
	/**
	 * Adds Custom settings option on Manage Plugins page.
	 */
	function listfusion_actions( $links, $file ) {
		if( $file == 'list-fusion/list-fusion.php' && function_exists( "admin_url" ) ) {
			$settings_link = '<a href="' . admin_url( 'admin.php?page=listfusion' ) . '">' .'<span style="color:#0000FF"><b>Go To Plugin Dashboard</b></span>' . '</a>';
			array_unshift( $links, $settings_link ); // before other links
		}
		return $links;
	}	
	/**
	 * Add links to plugin's description.
	 */
	function listfusion_meta_links( $links, $file ) {
		$documentation_link = '<a target="_blank" href="http://wpsmartapps.com/support/list-fusion/" title="View Plugin Documentation">Documentation</a>';
		$support_link = '<a target="_blank" href="http://wpsmartapps.com/support/forums/" title="Contact Plugin Developers">Support</a>';
		if ($file == plugin_basename(__FILE__)) {
		  $links[] = $documentation_link;
		  $links[] = $support_link;
		}
		return $links;
	}
	
/***********
* ADMIN JQUERY
**************/
	function listfusion_print_scripts() {
		if(is_admin()){
			wp_enqueue_script('listfusion',LIST_FUSION_LIBPATH.'js/admin_jq.js',array('jquery'),'1.0');
		}
	}
	
/***********
* DISPLAY WITHIN POST
**************/
	
	function listfusion_postprocess( $post_content ) {
		global $post, $paged, $posts_per_page;
	    $post_content = $this->__listfusion_post_process( $post_content, '' );
		$post_content = $this->__listfusion_processPostTag( $post_content ); 
		return $post_content;
	}

	
/***********
* AUTO FILLING
**************/
	function listfusion_autoFormFiller() {
		global $wpdb;
		// Comment Users
		if ( !is_user_logged_in() && isset($_COOKIE['comment_author_email_'.COOKIEHASH]) && isset($_COOKIE['comment_author_'.COOKIEHASH]) ) {
			$this->fusion_item_autofillingForm_author = $_COOKIE['comment_author_'.COOKIEHASH];
			$this->fusion_item_autofillingForm_author_email  = $_COOKIE['comment_author_email_'.COOKIEHASH];
		// Login Users
		} else if ( is_user_logged_in() ) { 
			$current_user = wp_get_current_user();
			if( $current_user->user_firstname != '' ) $name = $current_user->user_firstname.' '.$current_user->user_lastname;
			else $name =  $current_user->user_login;
			$this->fusion_item_autofillingForm_author = $name;
			$this->fusion_item_autofillingForm_author_email = $current_user->user_email;
		// Based On Parameter
		} else if( !is_user_logged_in() && !isset($_COOKIE['comment_author_email_'.COOKIEHASH]) && !isset($_COOKIE['comment_author_'.COOKIEHASH]) && isset($_COOKIE['LISTFUSION_PAR_NAME']) && isset($_COOKIE['LISTFUSION_PAR_EMAIL'])  ) {
			$this->fusion_item_autofillingForm_author = $_COOKIE['LISTFUSION_PAR_NAME'];
			$this->fusion_item_autofillingForm_author_email = $_COOKIE['LISTFUSION_PAR_EMAIL'];
		}
		
		$autofill_sql = "SELECT optin_name_fld, optin_email_fld, optin_form_url, split_name FROM $this->listfusion_arp_table where flag_aff='1'";
		$this->affNoOfRows = $wpdb->get_var("SELECT COUNT(id) FROM $this->listfusion_arp_table where flag_aff='1'");
		$rs = $wpdb->get_results( $autofill_sql, ARRAY_A );
		if( $rs ) { 
		    $this->listfusion_autoFillingFormValue = $rs;
		}	
		$this->affloop = 1;
		$this->affloop2 = 1;
	}
	
/***********
* JS, CSS ON TEMPLATE HEAD
**************/
	
	function listfusion_scripts_name() {
		$activatemobile = get_option('listfusion_activate_mobile');
		if( $activatemobile == 1 ) {
			echo '<meta name="viewport" content="width=device-width" />';
		}
	}
	
	function listfusion_jscss_action() {
		$this->__listfusion_item_popup();
		$this->__listfusion_item_clickslider();
	}
	
	function listfusion_file_process(){
		global $wpdb;
		// custom fancybox
		wp_enqueue_script('jquery');
		$chkid = $wpdb->get_var(" SELECT COUNT(id) FROM $this->listfusion_placement_table where ( item_type = 'custompopup' ) AND flag = '1' ");
		if( $chkid > 0 ) { 
			$disable_fancybox   = get_option('listfusion_custompop_fancybox');
			$disable_mousewheel = get_option('listfusion_custompop_fancybox_mousewheel');
		 	if( $disable_fancybox  != 1 ) {
				wp_enqueue_script('fancybox', LIST_FUSION_LIBPATH . 'user-lib/popup/fancybox/jquery.fancybox-1.3.4.pack.js', array('jquery'), '1.3.4' ); 
			}
			if( $disable_mousewheel  != 1 ) {
				wp_enqueue_script('jquerymousewheel', LIST_FUSION_LIBPATH . 'user-lib/popup/fancybox/jquery.mousewheel-3.0.4.pack.js', array('jquery'), '3.0.4' );
			}
			wp_enqueue_style('jquery.fancybox-1.3.4.css',LIST_FUSION_LIBPATH.'user-lib/popup/fancybox/jquery.fancybox-1.3.4.css',array(),'1.0');
			wp_enqueue_script('listfusion_fancybox_globalJS', LIST_FUSION_LIBPATH . 'user-lib/custom-fancybox.js', array('jquery'), LIST_FUSION_VERSION ); 
		}	
	}
	

/***********
* SETCOOKIE
**************/

	function listfusion_setCookie() {
		$this->__listfusion_adprocess();
		if ( !is_admin() ) { 
			$this->__listfusion_SetCookie();
			$this->__listfusion_UpgradeCount();
		}
	}	
	
/***********
* SEND EMAIL TO FIRST COMMENTATOR
**************/
	/**
	* Sends email to the first commentator on comment post
	*/
	function listfusion_sendEmailTo_FirstCommentator( $comment_id, $status ){  
		if( $status == 1 ) {
			$this->__listfusion_getOptions();
			if ( $this->listfusion_email_send_flag == 1 && $this->listfusion_sentEmail_type == 1 ) { 
				$this->__listfusion_SendEmail_On_StatusIsApproved( $comment_id, $status );
			}
		}
	}
	/**
	* Send email to commentator after comment is approved by admin
	*/
	function listfusion_sendEmailTo_ApproveComment( $comment_id, $status ) { 
		$this->__listfusion_getOptions();
	    if ( $this->listfusion_email_send_flag == 1 && $this->listfusion_sentEmail_type == 2 ) { 
			$this->__listfusion_SendEmail_On_StatusIsApproved( $comment_id, $status );
		}
	}
	
	
/***********
* EXIT JS POPUP + 
**************/
	function listfusion_footerAction(){
		if( !is_admin() ) {
			$this->__listfusionRst_exitJSPopup();
		}
		$this->customPopUp = 1;
		$this->__listfusion_item_popup();
		$this->__listfusion_autoFormFiller();	
	}
	
/***********
* DISPLAY WORDPRESS EDITOR
**************/
	function listfusion_display_editor( $targetContentValue, $popup_content ){
		the_editor( $targetContentValue, $popup_content);
	}
	
/**************
* LOAD CLASS USING AJAX
******************/
	
	function listfusionLoadExtraClass(){
		$styleName = filter_input(INPUT_GET, 'style', FILTER_SANITIZE_SPECIAL_CHARS);
		$btm_from_color = filter_input(INPUT_GET, 'btmFromColor', FILTER_SANITIZE_SPECIAL_CHARS);
		$btm_to_color = filter_input(INPUT_GET, 'btmToColor', FILTER_SANITIZE_SPECIAL_CHARS);
		$btm_hover_from_color = filter_input(INPUT_GET, 'btmHoverFromColor', FILTER_SANITIZE_SPECIAL_CHARS);
		$btm_hover_to_color = filter_input(INPUT_GET, 'btmHoverToColor', FILTER_SANITIZE_SPECIAL_CHARS);
		$btm_text_color = filter_input(INPUT_GET, 'btmTextColor', FILTER_SANITIZE_SPECIAL_CHARS);
		$btm_size = filter_input(INPUT_GET, 'btmSize', FILTER_SANITIZE_SPECIAL_CHARS);
		$popupstyle = filter_input(INPUT_GET, 'popupstyle', FILTER_SANITIZE_SPECIAL_CHARS);
		// If no style name is set, all stylesheets will be loaded.
		if(isset($styleName) && !empty($styleName) && strlen($styleName) > 0) {
			ob_start();
			include(LIST_FUSION_RELPATH.'/lib/user-lib/popup/'.$styleName.'/style.css');
			$stylesheet .= ob_get_clean();
			// Replace the '%plugin-url%' tag with the actual URL and add a unique identifier to separate stylesheets
			$stylesheet = str_replace('%plugin-url%', LIST_FUSION_LIBPATH, $stylesheet);
			$stylesheet = str_replace('%btm-from-color%', $btm_from_color, $stylesheet);
			$stylesheet = str_replace('%btm-to-color%', $btm_to_color, $stylesheet);
			$stylesheet = str_replace('%btm-from-hover-color%', $btm_hover_from_color, $stylesheet);
			$stylesheet = str_replace('%btm-to-hover-color%', $btm_hover_to_color, $stylesheet);
			$stylesheet = str_replace('%btm-text-color%', $btm_text_color, $stylesheet);
			$stylesheet = str_replace('%btm-size%', $btm_size, $stylesheet);
			$stylesheet = str_replace('%popup-style%', $popupstyle, $stylesheet);
		} else { return; }
		// Set header to CSS. Cache for a year (as WordPress does)
		header('Content-Type: text/css; charset=UTF-8');
		header('Expires: ' . gmdate("D, d M Y H:i:s", time() + 31556926) . ' GMT');
		header('Pragma: cache');
		header("Cache-Control: public, max-age=31556926");
		echo $stylesheet;
		die;	
	}
	
	
/**************
* WHERE TO SHOW ??
******************/

	function listfusion_page_list_recursive($parentid=0,$exclude='',$selected=array(),$show_in_page, $page_name){  
		$pages = get_pages('parent='.$parentid.'&child_of='.$parentid.'&exclude='.$exclude);
		if(count($pages) > 0){
			$str = '
		<ul style="padding:10px 0px 0px 20px;">';
		$page_count =1;
		$total_page = count($pages);
			foreach($pages as $p){
				$sel = false;
				if(isset($selected) && in_array($p->ID,$selected))
					$sel = true;
			if( $page_count > 4 ) { 
				if( $page_count == 5 ) {
					$str .='<a style="cursor:pointer; color:#0033CC" onclick="__listfusion_catpage_openit(\''.$page_name.$p->ID.'_openit\',\''.$page_name.$p->ID.'_closeit\')" id="'.$page_name.$p->ID.'_closeit"><strong>More[+]</strong></a>';
					$str .='<span id="'.$page_name.$p->ID.'_openit" style="display:none;">';
					$closePgID = $page_name.$p->ID;
				} 
				$str .= '
			<li><input type="checkbox" name="listfusion['.$show_in_page.'][]" value="'.$p->ID.'" id="pageid_'.$p->ID.'"'.(($sel)?' checked="checked"':'').' /> <label for="pageid_'.$p->ID.'">'.wp_specialchars($p->post_title).'</label>'.$this->listfusion_page_list_recursive($p->ID,$exclude,$selected,$show_in_page,$page_name).'</li>';
			
				if( $total_page == $page_count ) {
					$str .='<a style="cursor:pointer; color:#0033CC" onclick="__listfusion_catpage_closeit(\''.$closePgID.'_openit\',\''.$closePgID.'_closeit\')" ><strong>Close</strong></a></span>';
				}
			} else if( $page_count <= 4 ) { 
				$str .= '
			<li><input type="checkbox" name="listfusion['.$show_in_page.'][]" value="'.$p->ID.'" id="pageid_'.$p->ID.'"'.(($sel)?' checked="checked"':'').' /> <label for="pageid_'.$p->ID.'">'.wp_specialchars($p->post_title).'</label>'.$this->listfusion_page_list_recursive($p->ID,$exclude,$selected,$show_in_page,$page_name).'</li>';
			
			}
			$page_count++;
			}
			$str .= '
		</ul>';
			return $str;
		}
	}


	function listfusion_cat_list_recursive($parentid=0,$selected=array(),$display_in_cat,$cat_page_name){
		$cats = get_categories('hide_empty=0&child_of='.$parentid.'&parent='.$parentid);
		if(count($cats) > 0){
			$str = '
				<ul style="padding:10px 0px 0px 20px;">';
			$cat_count = 1;	
			$total_categ = count($cats);
			foreach($cats as $c){
				$sel = false;
				if(isset($selected) && in_array($c->cat_ID,$selected))
					$sel = true;
				if( $cat_count > 4 ) { 
				if( $cat_count == 5 ) {
					$str .='<a style="cursor:pointer; color:#0033CC" onclick="__listfusion_catpage_openit(\''.$cat_page_name.$c->cat_ID.'_openit\',\''.$cat_page_name.$c->cat_ID.'_closeit\')" id="'.$cat_page_name.$c->cat_ID.'_closeit"><strong>More[+]</strong></a>';
					$str .='<span id="'.$cat_page_name.$c->cat_ID.'_openit" style="display:none;">';
					$closeItID = $cat_page_name.$c->cat_ID;
				} 
				$str .= '
			<li><input type="checkbox" name="listfusion['.$display_in_cat.'][]" value="'.$c->cat_ID.'" id="catid_'.$c->cat_ID.'"'.(($sel)?' checked="checked"':'').' /> <label for="catid_'.$c->cat_ID.'">'.wp_specialchars($c->cat_name).'</label>'.$this->listfusion_cat_list_recursive($c->cat_ID,$selected,$display_in_cat,$cat_page_name).'</li>';
			
				if( $total_categ == $cat_count ) {
					$str .='<a style="cursor:pointer; color:#0033CC" onclick="__listfusion_catpage_closeit(\''.$closeItID.'_openit\',\''.$closeItID.'_closeit\')" ><strong>Close</strong></a></span>';
				}
			} else if( $cat_count <= 4 ) {	
				$str .= '
					<li><input type="checkbox" name="listfusion['.$display_in_cat.'][]" value="'.$c->cat_ID.'" id="catid_'.$c->cat_ID.'"'.(($sel)?' checked="checked"':'').' /> <label for="catid_'.$c->cat_ID.'">'.wp_specialchars($c->cat_name).'</label>'.$this->listfusion_cat_list_recursive($c->cat_ID,$selected,$display_in_cat,$cat_page_name).'</li>';
			}	
			$cat_count++;	
				}
			$str .= '</ul>';
			return $str;
		}
		return '';
	}


	function listfusion_page_list($display_in_all,$display_in_front_page,$display_in_home,$display_in_post,$display_in_archive,$display_in_search,$display_in_other,$showOnPostWithID,$dontShowOnPostWithID,$display_optin_in_cat,$display_in_cat,$display_in_page,$elbpro_class_showlist,$display_everywhere,$chk_in_all,$chk_in_home,$chk_in_front,$chk_in_post,$chk_in_arch,$chk_in_search,$chk_in_other, $showOnPostWithIDValue, $dontShowOnPostWithIDValue, $selected_pageid ,$selected_display_catIN,$selected_in_cat,$display_selected){
		$ex_pages = '';
		$catstr = ''; $selectedcat = isset($selected_display_catIN) ? $selected_display_catIN : 0;
		$opts = array('Both','Category page','Post page within the categories');
		foreach($opts as $a => $b){
			$catstr .= '
					<option value="'.$a.'"'.(($a==$selectedcat)?' selected="selected"':'').'>'.$b.'</option>';
		}
		
		$recursive_cat_name = $display_in_post.'65';
		$cats = $this->listfusion_cat_list_recursive(0,$selected_in_cat,$display_in_cat,$recursive_cat_name);
		
		$str = '<ul class="'.$elbpro_class_showlist.'">
			    <li>';
		if( $display_selected == 1 ) {
			$str .= '	<div class="innerhide" style="background-color:#F9F8F3; padding:10px 10px 10px 10px; -moz-border-radius: 8px; -khtml-border-radius: 8px; -webkit-border-radius: 8px;">
					<table  class="'.$this->list_fusion_replaceclassname.'" >
					<tbody><tr><td valign="top">
					<table  class="'.$this->list_fusion_replaceclassname.'">
						<tr>
						  <td><input type="checkbox" name="listfusion['.$display_in_post.']" '.$chk_in_post.' value="post" />
	  Single Posts &nbsp;</td>
						</tr>
				   </table> 
					</td></tr>
					</tbody></table>
				</div> 
			';
		} else {	
			$str .= '<div style="background-color:#F9F8F3; padding:0px 10px; -moz-border-radius: 8px; -khtml-border-radius: 8px; -webkit-border-radius: 8px;">
					<table width="100%" style="padding:10px 0px; font-size:14px;">
					<tr>
						<td width="10%">
							<input type="checkbox" name="listfusion['.$display_in_all.']" id= "'.$display_everywhere.'" '.$chk_in_all.' value="all"  /> 
							<label for="display_new_footerbar_in_all">All</label>  
					  </td>
					  <td width="15%"><input type="checkbox" name="listfusion['.$display_in_home.']" '.$chk_in_home.' value="home"  /> Home &nbsp;</td>
					  <td width="21%"><input type="checkbox" name="listfusion['.$display_in_front_page.']" '.$chk_in_front.' value="frontpg"  /> Front Page &nbsp;</td>
					  <td width="21%"><input type="checkbox" name="listfusion['.$display_in_post.']" '.$chk_in_post.' value="post" />Single Posts &nbsp;</td>
					  <td width="17%"><input type="checkbox" name="listfusion['.$display_in_archive.']" '.$chk_in_arch.' value="arch" /> Archive &nbsp;</td>
					  <td width="16%"><input type="checkbox" name="listfusion['.$display_in_search.']" '.$chk_in_search.' value="search" /> Search &nbsp;</td>
					</tr>
				   </table>
				</div>';
		}	
		$str .= '</li>
			<li>
				<table class="'.$this->list_fusion_replaceclassname.'" >
				<tbody><tr>
					<th valign="top">Show on these Posts only:</th> 
					<td>
						<input name="listfusion['.$showOnPostWithID.']" type="text" class="regular-text" value="'.$showOnPostWithIDValue.'" /><br>
						<small style="color:#999999; font-size:small;">(Enter the post ID&prime;s separated by commas)</small>
					</td>
				</tr>
				<tr>
					<th>Do not show on these Posts:</th> 
					<td>
						<input name="listfusion['.$dontShowOnPostWithID.']" type="text" class="regular-text" value="'.$dontShowOnPostWithIDValue.'" /><br>
						<small style="color:#999999; font-size:small;">(Enter the post ID&prime;s separated by commas)</small>
					</td> 
				</tr></tbody></table>
			</li>';
			
		$recursive_page_name = $display_in_post.'12';
		$str .= '<li style="background-color:#F9F8F3; padding:10px 10px 10px 10px; -moz-border-radius: 8px; -khtml-border-radius: 8px; -webkit-border-radius: 8px; font-size:14px;"><strong>Pages</strong>:'.$this->listfusion_page_list_recursive(0,$ex_pages,$selected_pageid,$display_in_page,$recursive_page_name).'</li>';
		
		if( !empty($cats) && $display_selected != 1 ){
			$str .= '
				<li style="font-size:14px; padding-top:10px;><label><strong><br>Categories</strong>:&nbsp;</label>
					<label for="listfusion_show_caton">Show on:</label>&nbsp;
					<select name="listfusion['.$display_optin_in_cat.']" >'.$catstr.'
					</select>
					'.$cats.'
				</li>';
		}
		$str .= '</ul>';
		echo $str;
	}
		

	function listfusion_show_resultON( $displayin_all, $displayin_frontpg, $displayin_home, $displayin_post, $displayin_archive, $displayin_search, $displayin_other, $displayin_showInPostId,  $displayin_dntshowInPostId, $displayin_pageID, $displayin_CatIn, $displayin_cat ) {  
		global $wp_query;
		$this->displayin_all = $displayin_all;
		$this->displayin_front = $displayin_frontpg;
		$this->displayin_home = $displayin_home;
		$this->displayin_post = $displayin_post;
		$this->displayin_archive = $displayin_archive;
		$this->displayin_search = $displayin_search;
		$this->displayin_other = $displayin_other;
		$this->displayin_showInPostId = $displayin_showInPostId;
		$this->displayin_dntshowInPostId = $displayin_dntshowInPostId;
		$this->displayin_pageID = $displayin_pageID;
		$this->displayin_CatIn = $displayin_CatIn;
		$this->displayin_cat = $displayin_cat;

		if( $this->displayin_all == 'all' ) return true;
		if( $this->displayin_front == 'frontpg' && is_front_page() ) return true;
		if( $this->displayin_home == 'home' && is_home() ) return true;
		if( $this->displayin_archive == 'arch' && is_archive() ) return true;
		if( $this->displayin_search == 'search' && is_search() ) return true;
		/**
		 is_single( array( 17, 19, 1, 11 ) )
		 Returns true when the single post being displayed is either post ID 17, post ID 19, post ID 1, or post ID 11.
		 is_page( array( 42, 'about-me', 'About Me' ) ) 
		 Returns true when the Pages displayed is either post ID 42, or post_name "about-me", or post_title "About Me"
		**/
		$displayOnpageIDs = explode(',', $this->displayin_showInPostId );
		$blockOnpageIDs = explode(',', $this->displayin_dntshowInPostId );
		// Single Post
		if( is_single( $displayOnpageIDs ) == true ) return true;
		if( ( is_single( $blockOnpageIDs ) ) && ( is_single() )  ) {
			return false;
		} else { 
			if( $this->displayin_post == 'post' && is_single() ) return true;
		}
		// Display On Pages
		if( isset($this->displayin_pageID) && is_page() && in_array( $wp_query->post->ID, $this->displayin_pageID ) ) return true;
		// Display on category
		if(isset($this->displayin_CatIn) && isset($this->displayin_cat) && is_array($this->displayin_cat)){
			$checkcat = $checkpost = false;
			switch($this->displayin_CatIn){
				case 0: $checkcat = $checkpost = true; break;
				case 1: $checkcat = true; break;
				case 2: $checkpost = true; break;
			}
			if($checkcat){
				foreach($this->displayin_cat as $c){
					if(is_category($c)){
						return true;
					}
				}
			}
			if($checkpost && is_single() && ($cats = get_the_category())){
				foreach($cats as $c){
					if(in_array($c->cat_ID,$this->displayin_cat)){
						return true;
					}
				}
			}
		}
	}
	
/********************
**** SQUEEZE PAGE META
*********************/

	function listfusion_sqpg_metaData() {
		error_reporting(E_ALL ^ E_NOTICE); 
		global $wpdb;
		if ( !isset($id) ) {
			$id = $_REQUEST['post_ID'];
		}
		if( !current_user_can('edit_post', $id) ) {
			return $id;
		}
		foreach ( $this->listfusion_sqmeta_customFields as $customField ) {
				if ( isset( $_POST[ $customField ] ) && trim( $_POST[ $customField ] ) != '' ) {
					update_post_meta( $id, $customField , $_POST[$customField] );
				} else {
					delete_post_meta( $id, $customField );
				}
		}
	}

	function listfusion_pg_squeeze(){
		global $wp_version, $wpdb;
		$filename = LIST_FUSION_ABSPATH.'wp-content/themes/'.get_template().'/template-listfusion-squeezepg.php';
		if ( !file_exists( $filename ) ) { 
			echo '<div style="border-left:4px solid #7ad03a; padding-left:20px;"><div style="font-size:14px; padding:0px 15px 22px 15px;font-family: Open Sans,sans-serif;"><br>
			<span style="color:red"><strong>Squeeze page has NOT ACTIVATE yet</strong></span>, Please <a style="color:#0066FF;" href="'.LIST_FUSION_SITEURL.'/wp-admin/admin.php?page=listfusion-settings">CLICK HERE</a> to activate. <br><br> 

			<i style="color:#B3B1B1;"><strong>NOTE:</strong> Sometimes it is possible you are not able to see fields over here even after following all steps its beacuse, the file that you just installed via automatic process or manual process has safe mode restrictions, You need to change your file "<strong>template-listfusion-squeezepg.php</strong>" CHMOD to 777, to make it redable.  You can find file under location: <strong>'.LIST_FUSION_ABSPATH.'wp-content/themes/'.get_template().'/template-listfusion-squeezepg.php </strong></i>
					</div></div>';
			return;
		}
		
		if ( isset($_REQUEST['post']) ) {
			$listfusion_squeezepage             = get_post_meta($_REQUEST['post'], 'listfusion_squeezepage');
			$listfusion_szpg_seo_title          = get_post_meta($_REQUEST['post'], 'listfusion_szpg_seo_title');
			$listfusion_szpg_seo_meta_dec       = get_post_meta($_REQUEST['post'], 'listfusion_szpg_seo_meta_dec');
			$listfusion_szpg_seo_meta_key       = get_post_meta($_REQUEST['post'], 'listfusion_szpg_seo_meta_key');
			$listfusion_szpg_seo_noindex        = get_post_meta($_REQUEST['post'], 'listfusion_szpg_seo_noindex');
			$listfusion_szpg_seo_nofollow       = get_post_meta($_REQUEST['post'], 'listfusion_szpg_seo_nofollow');
			$listfusion_szpg_seo_noarchive      = get_post_meta($_REQUEST['post'], 'listfusion_szpg_seo_noarchive');
			$listfusion_szpg_seo_footer_code    = get_post_meta($_REQUEST['post'], 'listfusion_szpg_seo_footer_code');
		}
		?>
<br>
<div style="border-left:4px solid #7ad03a; padding-left:20px;">		
<h3 id="squeezepg_submitbtm_design" class="listfusion_heading" style="padding-bottom:10px;padding-left: 0px;"><span class="listfusion_stepIndicator listfusion_stepActive">1</span>&nbsp;&nbsp;Choose Squeeze Page&nbsp;&nbsp;&nbsp;<img src="<?php echo LIST_FUSION_LIBPATH ?>images/point-left.gif" border="0" align="absmiddle"><img src="<?php echo LIST_FUSION_LIBPATH ?>images/point-left.gif" border="0" align="absmiddle"> <span style="color:#FF0000; font-weight:normal; font-size:14px;">Required</span></h3><br>
<div id="listfusion_sqpg_select" style="padding:10px 4px 10px 25px;background-color:#F8F8F8; margin-bottom:20px; -moz-border-radius: 8px; -khtml-border-radius: 8px; -webkit-border-radius: 8px;">
    <div style="padding:8px 4px 4px 4px;">
	<?php 
	$fusion_squeeepage_rs = " SELECT id,item_name FROM {$wpdb->prefix}listfusion_placement where (  item_type = 'squeezepg' ) 
																AND childid = '0' AND flag = '1' ";
	$fusion_item_squeeepage = $wpdb->get_results( $fusion_squeeepage_rs, ARRAY_A );
	
	if( $fusion_item_squeeepage ) { 
		echo '<select name="listfusion_squeezepage"  id="listfusion_squeezepage" style="width:auto;">';
		echo '<option value="">----- Choose Created Squeeze Page -----</option>';	
		foreach ( $fusion_item_squeeepage as $row ) {
			if( trim($row['id']) == trim($listfusion_squeezepage[0]) ) $squeezepage_selected = 'selected';
			else $squeezepage_selected = '';
			echo '<option '.$squeezepage_selected.' value="'.$row['id'].'">'.$row['item_name'].'</option>';	
		}
		echo '</select>';
	} else {
		echo 'No any records related to squeeze page <a style="color:#0066FF;" href="'.LIST_FUSION_SITEURL.'/wp-admin/admin.php?page=listfusion&action=aesqpg">Add New Squeeze Page Now</a> ';
	}	
	?>
	</div>
</div>	

<h3 id="squeezepg_submitbtm_design" class="listfusion_heading" style="padding-bottom:10px;padding-left: 0px;"><span class="listfusion_stepIndicator listfusion_stepActive">2</span>&nbsp;&nbsp;Squeeze Page SEO&nbsp;&nbsp;&nbsp;<img src="<?php echo LIST_FUSION_LIBPATH ?>images/point-left.gif" border="0" align="absmiddle"><img src="<?php echo LIST_FUSION_LIBPATH ?>images/point-left.gif" border="0" align="absmiddle"> <span style="color:#FF0000; font-weight:normal; font-size:14px;">Important</span></h3><br>
<div id="listfusion_sqpg_seo" style="padding:10px 4px 10px 25px;background-color:#F8F8F8; margin-bottom:20px; -moz-border-radius: 8px; -khtml-border-radius: 8px; -webkit-border-radius: 8px;">
    <div style="padding:8px 4px 4px 4px;">
      <table>
        <tr>
          <td width="117" valign="middle"><strong>Title Text</strong></td>
          <td colspan="2"><input name="listfusion_szpg_seo_title" id="listfusion_szpg_seo_title" type="text"  style="width:480px;" value="<?php echo $listfusion_szpg_seo_title[0]?$listfusion_szpg_seo_title[0]:''; ?>" />
          </td>
        </tr>
        <tr>
          <td valign="middle">&nbsp;</td>
          <td width="31">&nbsp;</td>
          <td width="467"><span style="font-size:11px; color:#999999; font-family:Arial, Helvetica, sans-serif">Appears inside title tag &lt;title&gt;Your title text...&lt;/title&gt;</span></td>
        </tr>
      </table>
    </div>
    <div style="padding:8px 4px 4px 4px;">
      <table>
        <tr>
          <td width="117" valign="middle"><strong>Meta Description:</strong></td>
          <td colspan="2"><textarea name="listfusion_szpg_seo_meta_dec" id="listfusion_szpg_seo_meta_dec" cols="57" rows="4"><?php echo $listfusion_szpg_seo_meta_dec[0]?$listfusion_szpg_seo_meta_dec[0]:''; ?></textarea>
          </td>
        </tr>
        <tr>
          <td valign="middle">&nbsp;</td>
          <td width="31">&nbsp;</td>
          <td width="467"><span style="font-size:11px; color:#999999; font-family:Arial, Helvetica, sans-serif">Description that will be seen in the search engines for your page</span></td>
        </tr>
      </table>
    </div>
    <div style="padding:8px 4px 4px 4px;">
      <table>
        <tr>
          <td width="117" valign="middle"><strong>Meta Keywords</strong></td>
          <td colspan="2"><input name="listfusion_szpg_seo_meta_key"  id="listfusion_szpg_seo_meta_key" type="text"  style="width:480px;" value="<?php echo $listfusion_szpg_seo_meta_key[0]?$listfusion_szpg_seo_meta_key[0]:''; ?>" />
          </td>
        </tr>
        <tr>
          <td valign="middle">&nbsp;</td>
          <td width="31">&nbsp;</td>
          <td width="467"><span style="font-size:11px; color:#999999; font-family:Arial, Helvetica, sans-serif">Keywords separated by commas</span></td>
        </tr>
      </table>
    </div>
    <div style="padding:8px 4px 4px 4px;">
      <input name="listfusion_szpg_seo_noindex"  id="listfusion_szpg_seo_noindex" type="checkbox" value="1" <?php echo $listfusion_szpg_seo_noindex[0]?'checked':''; ?> />
      <strong>add a noindex robot meta tag </strong></div>
    <div style="padding:8px 4px 4px 4px;">
      <input name="listfusion_szpg_seo_nofollow" id="listfusion_szpg_seo_nofollow" type="checkbox" value="1" <?php echo $listfusion_szpg_seo_nofollow[0]?'checked':''; ?>  />
      <strong>add a nofollow robot meta tag</strong> </div>
    <div style="padding:8px 4px 4px 4px;">
      <input name="listfusion_szpg_seo_noarchive" id="listfusion_szpg_seo_noarchive" type="checkbox" value="1" <?php echo $listfusion_szpg_seo_noarchive[0]?'checked':''; ?>  />
      <strong>add a noarchive robot meta tag</strong> </div>
    <div style="padding:8px 4px 4px 4px;">
      <table>
        <tr>
          <td width="117" valign="middle"><strong>Footer Codes</strong></td>
          <td colspan="2"><textarea name="listfusion_szpg_seo_footer_code" id="listfusion_szpg_seo_footer_code" cols="57" rows="4"><?php echo $listfusion_szpg_seo_footer_code[0]?trim($listfusion_szpg_seo_footer_code[0]):''; ?> </textarea>
          </td>
        </tr>
        <tr>
          <td valign="middle">&nbsp;</td>
          <td width="31">&nbsp;</td>
          <td width="467"><span style="font-size:11px; color:#999999; font-family:Arial, Helvetica, sans-serif">Enter any tracking codes or javascript code you want to activate for this specific page</span></td>
        </tr>
      </table>
    </div>
</div>


<h3 id="squeezepg_submitbtm_design" class="listfusion_heading" style="padding-bottom:10px;padding-left: 0px;"><span class="listfusion_stepIndicator listfusion_stepActive">3</span>&nbsp;&nbsp;Activate Squeeze Page&nbsp;&nbsp;&nbsp;<img src="<?php echo LIST_FUSION_LIBPATH ?>images/point-left.gif" border="0" align="absmiddle"><img src="<?php echo LIST_FUSION_LIBPATH ?>images/point-left.gif" border="0" align="absmiddle"> <span style="color:#FF0000; font-weight:normal; font-size:14px;">Instruction</span></h3><br>
<div id="listfusion_sqpg_seo" style="padding:10px 4px 10px 25px;background-color:#F8F8F8; margin-bottom:20px; -moz-border-radius: 8px; -khtml-border-radius: 8px; -webkit-border-radius: 8px;">
    <div style="padding:8px 4px 4px 4px;">
	Choose the template "<strong>List Fusion Squeeze Page</strong>" under <strong>Page Attributes</strong> at right hand side and hit <strong>Publish</strong>.
	</div>
</div>
	

</div>
		<?php
	}
	
/********************
**** INSIDE COMMENT BOX
*********************/
	function listfusion_latestCommentId($comment_id) {
		error_reporting(E_ALL ^ E_NOTICE); 
		$_SESSION['LISTFUSION_CURR_COMMENT_ID'] = $comment_id;
		return $comment_id;
	}
		
	function listfusion_showOptinFrmInsideComment( $comment_txt ){
		error_reporting(E_ALL ^ E_NOTICE); 
		global $comment;
		if( !is_admin() && isset($_SESSION['LISTFUSION_CURR_COMMENT_ID']) ) { 
			$comment_txt = $this->__listfusion_showOptinFormInsideComment( $comment_txt, $comment);
		}
		return $comment_txt;
	}

	
} // Eof Class	
$ListFusionPlugin = new ListFusionPlugin();	

/********************
**** LIST FUSION : TEMPLATE TAG
*********************/
function listfusion_getTemplateTag( $templateTag ){
	global $ListFusionPlugin;
	echo $ListFusionPlugin->__listfusion_processPostTag( $templateTag );
}


/********************
**** SQUEEZE PAGE
*********************/
function listfusion_display_sqeezePg( $listfusion_squeezepage, $listfusion_szpg_seo_title, $listfusion_szpg_seo_meta_dec, $listfusion_szpg_seo_meta_key, $listfusion_szpg_seo_noindex, $listfusion_szpg_seo_nofollow, $listfusion_szpg_seo_noarchive, $listfusion_szpg_seo_footer_code ) {
	global $ListFusionPlugin;
	$ListFusionPlugin->__listfusion_processSqueezePG( $listfusion_squeezepage, $listfusion_szpg_seo_title, $listfusion_szpg_seo_meta_dec, $listfusion_szpg_seo_meta_key, $listfusion_szpg_seo_noindex, $listfusion_szpg_seo_nofollow, $listfusion_szpg_seo_noarchive, $listfusion_szpg_seo_footer_code );
}

/********************
**** LIST FUSION : WIDGET ONCLICK POP
*********************/
function listfusion_onClickPopUpSidebar( $sidebar_width, $title='', $before_widget='', $after_widget='', $before_title='', $after_title='', $replaceTag, $sidebar_desc ) {
	global $ListFusionPlugin;
	if ( !is_admin() ) {  
		echo $before_widget;
		if ( trim( $title ) != '' ) echo $before_title.$title.$after_title;
		$widgetTag  = '[LFONCLICK:Popup='.$replaceTag.']';
		$widgetTag .= $sidebar_desc;
		$widgetTag .= '[/LFONCLICK:Popup]';
		echo $ListFusionPlugin->__listfusion_processPostTag( $widgetTag );
		echo $after_widget;
	}
}
function listfusion_adoptin_Sidebar( $title='', $before_widget='', $after_widget='', $before_title='', $after_title='', $sidebarID ) {
	global $ListFusionPlugin;
	if ( !is_admin() ) {  
		echo $before_widget;
		if ( trim( $title ) != '' ) echo $before_title.$title.$after_title;
		$ListFusionPlugin->__listfusion_item_sidebar( $sidebarID );
		echo $after_widget;
	}
}
if ( $wp_version >= 2.8 ) {
	class ListFusionPluginWidget extends WP_Widget {
		function ListFusionPluginWidget() {
			$widget_ops = array(
				'classname' => 'widget_listfusionPopupOnclick', 
				'description' => 'List Fusion: PopUp OnClick Tags' 
				);
			$control_ops = array (
				/*'width' => '380', 
				'height' => '400'*/
				);
			$this->WP_Widget('lfpopupOnclickAction', 'List Fusion: OnClick PopUp', $widget_ops, $control_ops);
		}
		function widget( $args, $instance ) {		
			global $ListFusionPlugin;
			extract( $args );
			$sidebar_title = $instance['listfusion_popup_onclick_title'];
			$sidebar_desc = $instance['listfusion_onclickdesc_widget'];
			$replaceTag = $instance['widget_listfusionOnclickPopUpID'];
			if( $instance['listfusion_onclicktag_widget'] == 1 ) {
			listfusion_onClickPopUpSidebar( $sidebar_width, $sidebar_title, $before_widget, $after_widget, $before_title, $after_title, $replaceTag, $sidebar_desc );
			}
		}
		function update( $new_instance, $old_instance ) {				
			global $ListFusionPlugin, $wp_version;
			return $new_instance;
		}
		function form( $instance ) {
			error_reporting(E_ALL ^ E_NOTICE); 
			global $ListFusionPlugin, $wp_version, $wpdb;
			?>
			<div>
			
	  			<div style="padding:10px 2px;">
				Title: <input type="text" class="widefat" name="<?php echo $this->get_field_name("listfusion_popup_onclick_title"); ?>" id="<?php echo $this->get_field_id('listfusion_popup_onclick_title'); ?>" value="<?php echo $instance['listfusion_popup_onclick_title']; ?>" style="width:200px;" />
				</div >
				<hr style="border: 0;border-top: 5px solid #ddd;border-bottom: 1px solid #fafafa;">
				
				<div style="padding:10px 2px;">	
				<strong>AvailableTag</strong>:&nbsp; 
				<?php 
				$fusion_onclickpopup_rs = " SELECT id,item_name,item_type,option_values FROM {$wpdb->prefix}listfusion_placement where 
				                       ( item_type = 'custompopup' )  AND childid = '0' AND flag = '1' order by id DESC ";
									   
				$fusion_onclick_sidebar = $wpdb->get_results( $fusion_onclickpopup_rs, ARRAY_A );
				
				if( $fusion_onclick_sidebar ) { 
					?>
					<select name="<?php echo $this->get_field_name("widget_listfusionOnclickPopUpID"); ?>" id="id="<?php echo $this->get_field_id('widget_listfusionOnclickPopUpID'); ?>"" >
					<?php 
					foreach ( $fusion_onclick_sidebar as $rs ) {
					    $chkIfOnclickActive = unserialize($rs['option_values']);
						if( $chkIfOnclickActive['popup_onClickAction_self_display'] == 1 ){
					?>
				<option value="<?php echo $rs['id'];  ?>"  <?php if( $instance['widget_listfusionOnclickPopUpID'] == $rs['id'] ) { ?> selected="selected" <?php } ?> >
					<?php echo $rs['item_name']; ?>
				</option>						
					<?php 
						} else {
						echo '<option>----- No Any Records ------</option>';
						}
					}
					echo '</select>';
					echo '<br><i style="font-size:x-small">We will automatically insert widget tag for you :)</i>';
					?>
					</select>
					<?php 
				} else {
					echo '<small><i style="color:red;">NO ANY RECORDS</i></small>';
				}	
				?>
				
				<br><br>
				<hr style="border: 0;border-top: 5px solid #ddd;border-bottom: 1px solid #fafafa;">
				<div><strong>Enter your text below</strong></div><br>
				<textarea id=" <?php echo $this->get_field_id('listfusion_onclickdesc_widget'); ?> " name="<?php echo $this->get_field_name('listfusion_onclickdesc_widget'); ?>" cols="27" rows="5"><?php echo ($instance['listfusion_onclickdesc_widget']?$instance['listfusion_onclickdesc_widget']:'Grand Offer Click Here..');  ?></textarea>
				<br><i style="font-size:x-small">Support HTML Tag</i>
				</div>
			</div>	
				<input type="hidden" id="<?php echo $this->get_field_id('listfusion_onclicktag_widget'); ?>" name="<?php echo $this->get_field_name('listfusion_onclicktag_widget'); ?>" value="1" />	
			<?php
		}
	}
	add_action('widgets_init', create_function('', 'return register_widget("ListFusionPluginWidget");'));
	
/********************
**** LIST FUSION : SIDEBAR
*********************/
	
	class ListFusionPluginWidgetSidebar extends WP_Widget {
		function ListFusionPluginWidgetSidebar() {
			$widget_ops = array(
				'classname' => 'widget_listfusionsidebar', 
				'description' => 'List Fusion: Sidebar' 
				);
			$control_ops = array (
				/*'width' => '380', 
				'height' => '400'*/
				);
			$this->WP_Widget('lfsidebarOptinAd', 'List Fusion: Sidebar', $widget_ops, $control_ops);
		}
		function widget( $args, $instance ) {		
			global $ListFusionPlugin;
			extract( $args );
			$sidebar_title = $instance['listfusion_sidebar_title'];
			$sidebarID = $instance['listfusion_sidebarID'];
			if( $instance['listfusion_sidebar_widget'] == 1 ) {
				listfusion_adoptin_Sidebar( $sidebar_title, $before_widget, $after_widget, $before_title, $after_title, $sidebarID);
			}
		}
		function update( $new_instance, $old_instance ) {				
			global $ListFusionPlugin, $wp_version;
			return $new_instance;
		}
		function form( $instance ) {
			error_reporting(E_ALL ^ E_NOTICE); 
			global $ListFusionPlugin, $wp_version, $wpdb;
			?>
				<div style="padding:10px 2px;">
				Title: <input type="text" class="widefat" name="<?php echo $this->get_field_name("listfusion_sidebar_title"); ?>" id="<?php echo $this->get_field_id('listfusion_sidebar_title'); ?>" value="<?php echo $instance['listfusion_sidebar_title']; ?>" style="width:200px;" />
				</div >
				<div style="padding:10px 2px;">	
				<strong>Available Records</strong>:&nbsp; 
				<?php 
				$fusion_sidebar_rs = " SELECT id,item_name FROM {$wpdb->prefix}listfusion_placement where ( item_type = 'sidebaroptin' || item_type = 'sidebarad' ) 
																							   AND childid = '0' AND flag = '1' order by id DESC ";
				$fusion_item_sidebar = $wpdb->get_results( $fusion_sidebar_rs, ARRAY_A );
				
				if( $fusion_item_sidebar ) { 
					?>
					<select name="<?php echo $this->get_field_name("listfusion_sidebarID"); ?>" id="<?php echo $this->get_field_id('listfusion_sidebarID'); ?>" >
					<?php 
					foreach ( $fusion_item_sidebar as $rs ) {
					?>
						<option value="<?php echo $rs['id'];  ?>"  <?php if( $instance['listfusion_sidebarID'] == $rs['id'] ) { ?> selected="selected" <?php } ?> >
						<?php echo $rs['item_name']; ?>
						</option>	
					<?php 
					}
					?>
					</select>
					<?php 
				} else {
					echo '<small><i style="color:red;">NO ANY RECORDS</i></small>';
				}	
				?>
				</div>				
				<input type="hidden" id="<?php echo $this->get_field_id('listfusion_sidebar_widget'); ?>" name="<?php echo $this->get_field_name('listfusion_sidebar_widget'); ?>" value="1" />	
			<?php
		}
	}
	add_action('widgets_init', create_function('', 'return register_widget("ListFusionPluginWidgetSidebar");'));
	
}


?>