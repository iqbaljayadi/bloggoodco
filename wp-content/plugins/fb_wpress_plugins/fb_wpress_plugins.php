<?php
/*
Plugin Name: Facebook WPress Plugins for WordPress
Plugin URI: http://yougapi.com/products/wp/facebook-plugins/
Description: Integrate Facebook Plugins, Comments and Dialogs into your WordPress posts and pages using shortcodes and/or widgets.
Version: 2.4
Author: Yougapi Technology LLC
Author URI: http://yougapi.com
*/

require_once dirname( __FILE__ ).'/include/webzone.php';
require_once dirname( __FILE__ ).'/widget_like_box.php';
require_once dirname( __FILE__ ).'/widget_facepile.php';
require_once dirname( __FILE__ ).'/widget_recommendations_box.php';
require_once dirname( __FILE__ ).'/widget_activity_feed.php';
require_once dirname( __FILE__ ).'/widget_like_button.php';
require_once dirname( __FILE__ ).'/widget_send_button.php';
require_once dirname( __FILE__ ).'/widget_share_button.php';
require_once dirname( __FILE__ ).'/widget_follow_button.php';
require_once dirname( __FILE__ ).'/widget_embedded_posts.php';
require_once dirname( __FILE__ ).'/fb_wpress_filters.php';
//if(is_admin()) require_once dirname( __FILE__ ).'/update_notifier.php';

class Fb_wpress_plugins extends Wp_framework_Fb_wpress_plugins {
	
	function Fb_wpress_plugins() {
		
		//Mandatory
		$settings['plugin_title'] = 'Facebook Plugins & Dialogs';
		$settings['menu_title'] = 'Facebook Plugins'; //used in menus in the admin
		$settings['plugin_class_name'] = 'Fb_wpress_plugins';
		$settings['plugin_version'] = '2.4';
		
		//Settings page
		$settings['settings_page_link'] = 'fb-wpress-plugins'; //leave empty to not have a settings page
		$settings['plugin_token'] = 'fb_wpress_plugins'; //used to store data - should be unique
		
		//Optional
		$settings['js_files'] = array();
		$settings['css_files'] = array();
		$settings['js_files_admin'] = array();
		$settings['css_files_admin'] = array();
		
		//Shortcodes
		add_shortcode('fb_wpress_like_button', array(__CLASS__, 'shortcode_like_button') );
		add_shortcode('fb_wpress_send_button', array(__CLASS__, 'shortcode_send_button') );
		add_shortcode('fb_wpress_follow_button', array(__CLASS__, 'shortcode_follow_button') );
		add_shortcode('fb_wpress_share_button', array(__CLASS__, 'shortcode_share_button') );
		add_shortcode('fb_wpress_embedded_post', array(__CLASS__, 'shortcode_embedded_post') );
		add_shortcode('fb_wpress_activity_feed', array(__CLASS__, 'shortcode_activity_feed') );
		add_shortcode('fb_wpress_recommendations', array(__CLASS__, 'shortcode_recommendations') );
		add_shortcode('fb_wpress_like_box', array(__CLASS__, 'shortcode_like_box') );
		add_shortcode('fb_wpress_facepile', array(__CLASS__, 'shortcode_facepile') );
		add_shortcode('fb_wpress_comments', array(__CLASS__, 'shortcode_comments') );
		//add_shortcode('fb_wpress_recommendations_bar', array(__CLASS__, 'shortcode_recommendations_bar') );
		add_shortcode('fb_wpress_status_update', array(__CLASS__, 'shortcode_status_update') );
		add_shortcode('fb_wpress_add_friend_dialog', array(__CLASS__, 'shortcode_add_friend_dialog') );
		
		//GLOBAL variables
		$options = get_option($settings['plugin_token'].'_fb_app_settings');
		$GLOBALS['fb_plugins']['app_id'] = $options['fb_app_id'];
		$GLOBALS['fb_plugins']['lang'] = $options['fb_sdk_lang'];
		$GLOBALS['fb_plugins']['sdk'] = $options['fb_sdk'];
		$GLOBALS['fb_plugins']['open_graph'] = $options['open_graph'];
		$GLOBALS['fb_plugins']['fb_user_ids'] = $options['fb_user_ids'];
		
		//Save to be used globally
		$GLOBALS['fb_wpress_plugins']['like_button'] = get_option($settings['plugin_token'].'_like_button');
		$GLOBALS['fb_wpress_plugins']['like_button_posts'] = get_option($settings['plugin_token'].'_like_button_posts');
		$GLOBALS['fb_wpress_plugins']['like_button_pages'] = get_option($settings['plugin_token'].'_like_button_pages');
		$GLOBALS['fb_wpress_plugins']['comments'] = get_option($settings['plugin_token'].'_comments');
		$GLOBALS['fb_wpress_plugins']['comments_posts'] = get_option($settings['plugin_token'].'_comments_posts');
		$GLOBALS['fb_wpress_plugins']['comments_pages'] = get_option($settings['plugin_token'].'_comments_pages');
		
		add_action('wp_head', array (__CLASS__, 'open_graph_tags'));
		
		//Facebook SDK
		$options = get_option($settings['plugin_token'].'_fb_app_settings');
		$settings['fb_app_id'] = $options['fb_app_id'];
		$settings['fb_app_secret'] = $options['fb_app_secret'];
		$settings['fb_sdk_lang'] = $options['fb_sdk_lang'];
		$settings['fb_sdk'] = $options['fb_sdk'];
		$settings['fb_connect_redirect'] = '';
		$settings['fb_logout_redirect'] = '';
		$settings['fb_scope'] = 'email,publish_stream';
		
		//System settings - Not to be customized
		$settings['plugin_dir_url'] = plugin_dir_url( __FILE__ );
		$settings['dirname'] = dirname(__FILE__);
		$settings['plugin_dir_name'] = plugin_basename(dirname(__FILE__));
		$settings['main_file_name'] = $settings['plugin_dir_name'].'.php'; //used in the admin
		$settings['full_file_path'] = __FILE__;
		
		parent::init(array('settings'=>$settings));
	}
	
	//Called by the higher class
	function add_scripts_wp_footer() {		
		if($GLOBALS['fb_plugins']['sdk']==2) {
			$fb_sdk = parent::getFbJsSDK(array('fb_app_id'=>$GLOBALS['fb_plugins']['app_id'], 'lang'=>$GLOBALS['fb_plugins']['lang']));
			echo $fb_sdk;
		}
	}
	
	function enqueue_js_sdk() {
		if($GLOBALS['fb_plugins']['sdk']==1) {
			$fb_sdk = parent::getFbJsSDK(array('fb_app_id'=>$GLOBALS['fb_plugins']['app_id'], 'lang'=>$GLOBALS['fb_plugins']['lang']));
			echo $fb_sdk;			
		}
	}
	
	function open_graph_tags() {
		if($GLOBALS['fb_plugins']['open_graph']=='true') {
			if (is_single() || is_page()) $type = 'article';
			else $type = 'website';
			
			$fb_app_id = $GLOBALS['fb_plugins']['app_id'];
			
			if(!is_home()) {
				echo "\n";
				echo '<meta property="og:title" content="'.get_the_title().'"/>'."\n";
				echo '<meta property="og:url" content="'.get_permalink().'"/>'."\n";
				echo '<meta property="og:image" content="'.self::get_fb_image().'"/>'."\n";
				echo '<meta property="og:type" content="'.$type.'"/>'."\n";
				echo '<meta property="og:site_name" content="'.get_bloginfo('name').'"/>'."\n";
				echo '<meta property="fb:app_id" content="'.$fb_app_id.'"/>'."\n";
				if($GLOBALS['fb_plugins']['fb_user_ids']!='') echo '<meta property="fb:admins" content="'.$GLOBALS['fb_plugins']['fb_user_ids'].'"/>'."\n";
			}
		}
	}
	
	function get_fb_image() {
		global $post, $posts;
		
		$method_2_flag=0;
		
		if(function_exists(get_the_post_thumbnail) && function_exists(wp_get_attachment_image_src)) {
			$src = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'thumbnail');
			if ( function_exists(has_post_thumbnail) && has_post_thumbnail($post->ID) ) {
				$image = $src[0];
			}
			else {
				$method_2_flag=1;
			}
		}
		else $method_2_flag=1;
		
		if($method_2_flag) {
			$image = '';
			$output = preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i',
			$post->post_content, $matches);
			$image = $matches [1] [0];
		}
		
		if(empty($image)) {
			//$image = "http://mydomain.com/default-image.jpg";
		}
		
		return $image;
	}
	
	/*
	###############
	START shortcode
	*/
	
	function shortcode_like_button($atts, $content = null, $code) {
		extract(shortcode_atts(array(
		'url' => '',
		'share' => '',
		'layout' => '',
		'width' => '',
		'colorscheme' => '',
		'show_faces' => '',
		'action' => '',
		), $atts));
		
		add_action( 'wp_footer', array(__CLASS__, 'enqueue_js_sdk') );
		if($url=='') $url = 'http://'.$_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
		
		$criteria = array('url'=>$url, 'share_button'=>$share, 'layout'=>$layout, 'width'=>$width, 'colorscheme'=>$colorscheme, 'show_faces'=>$show_faces, 'action'=>$action);
		$f1 = new Facebook_plugins_class();
		$content = $f1->get_like_button($criteria);
		
		return $content;
	}
	
	function shortcode_send_button($atts, $content = null, $code) {
		extract(shortcode_atts(array(
		'url' => '',
		'colorscheme' => '',
		), $atts));
		
		add_action( 'wp_footer', array(__CLASS__, 'enqueue_js_sdk') );
		if($url=='') $url = 'http://'.$_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
		
		$criteria = array('url'=>$url, 'colorscheme'=>$colorscheme);
		$f1 = new Facebook_plugins_class();
		$content = $f1->get_send_button($criteria);
		
		return $content;
	}
	
	function shortcode_follow_button($atts, $content = null, $code) {
		extract(shortcode_atts(array(
		'url' => '',
		'layout' => '',
		'show_faces' => '',
		'colorscheme' => '',
		'width' => '',
		), $atts));
		
		add_action( 'wp_footer', array(__CLASS__, 'enqueue_js_sdk') );
		
		$criteria = array('url'=>$url, 'layout'=>$layout, 'show_faces'=>$show_faces, 'colorscheme'=>$colorscheme, 'width'=>$width);
		$f1 = new Facebook_plugins_class();
		$content = $f1->get_follow_button($criteria);
		
		return $content;
	}
	
	function shortcode_share_button($atts, $content = null, $code) {
		extract(shortcode_atts(array(
		'url' => '',
		'layout' => '',
		'width' => '',
		), $atts));
		
		add_action( 'wp_footer', array(__CLASS__, 'enqueue_js_sdk') );
		if($url=='') $url = 'http://'.$_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
		
		$criteria = array('url'=>$url, 'layout'=>$layout, 'width'=>$width);
		$f1 = new Facebook_plugins_class();
		$content = $f1->get_share_button($criteria);
		
		return $content;
	}
	
	function shortcode_embedded_post($atts, $content = null, $code) {
		extract(shortcode_atts(array(
		'url' => '',
		'width' => '',
		), $atts));
		
		add_action( 'wp_footer', array(__CLASS__, 'enqueue_js_sdk') );
		if($url=='') $url = 'http://'.$_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
		
		$criteria = array('url'=>$url, 'width'=>$width);
		$f1 = new Facebook_plugins_class();
		$content = $f1->get_embedded_post($criteria);
		
		return $content;
	}
	
	function shortcode_activity_feed($atts, $content = null, $code) {
		extract(shortcode_atts(array(
		'domain' => '',
		'width' => '',
		'height' => '',
		'colorscheme' => '',
		'header' => '',
		'recommendations' => '',
		'border_color' => '',
		), $atts));
		
		add_action( 'wp_footer', array(__CLASS__, 'enqueue_js_sdk') );
		if($domain=='') $domain = 'http://'.$_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
		
		$criteria = array('domain'=>$domain, 'width'=>$width, 'height'=>$height, 'colorscheme'=>$colorscheme, 'header'=>$header, 'recommendations'=>$recommendations, 'border_color'=>$border_color);
		$f1 = new Facebook_plugins_class();
		$content = $f1->get_activity_feed($criteria);
		
		return $content;
	}
	
	function shortcode_recommendations($atts, $content = null, $code) {
		extract(shortcode_atts(array(
		'domain' => '',
		'width' => '',
		'height' => '',
		'colorscheme' => '',
		'header' => '',
		'border_color' => '',
		), $atts));
		
		add_action( 'wp_footer', array(__CLASS__, 'enqueue_js_sdk') );
		if($domain=='') $domain = 'http://'.$_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
		
		$criteria = array('domain'=>$domain, 'width'=>$width, 'height'=>$height, 'colorscheme'=>$colorscheme, 'header'=>$header, 'border_color'=>$border_color);
		$f1 = new Facebook_plugins_class();
		$content = $f1->get_recommendations($criteria);
		
		return $content;
	}
	
	function shortcode_like_box($atts, $content = null, $code) {
		extract(shortcode_atts(array(
		'url' => '',
		'width' => '',
		'height' => '',
		'colorscheme' => '',
		'header' => '',
		'show_faces' => '',
		'stream' => '',
		'border_color' => '',
		), $atts));
		
		add_action( 'wp_footer', array(__CLASS__, 'enqueue_js_sdk') );
		if($url=='') $url = 'http://'.$_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
		
		$criteria = array('url'=>$url, 'width'=>$width, 'height'=>$height, 'colorscheme'=>$colorscheme, 'header'=>$header, 'show_faces'=>$show_faces, 'stream'=>$stream, 'border_color'=>$border_color);
		$f1 = new Facebook_plugins_class();
		$content = $f1->get_like_box($criteria);
		
		return $content;
	}
	
	function shortcode_facepile($atts, $content = null, $code) {
		extract(shortcode_atts(array(
		'url' => '',
		'width' => '',
		'max_rows'=>'',
		'size'=>'',
		'colorscheme'=>'',
		), $atts));
		
		add_action( 'wp_footer', array(__CLASS__, 'enqueue_js_sdk') );
		if($url=='') $url = 'http://'.$_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
		
		$criteria = array('url'=>$url, 'width'=>$width, 'max_rows'=>$max_rows, 'size'=>$size, 'colorscheme'=>$colorscheme);
		$f1 = new Facebook_plugins_class();
		$content = $f1->get_facepile($criteria);
		
		return $content;
	}
	
	function shortcode_comments($atts, $content = null, $code) {
		extract(shortcode_atts(array(
		'url'=>'',
		'width' => '',
		'num_posts' => '',
		'colorscheme'=>'',
		), $atts));
		
		add_action( 'wp_footer', array(__CLASS__, 'enqueue_js_sdk') );
		if($url=='') $url = 'http://'.$_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
		
		$criteria = array('url'=>$url, 'width'=>$width, 'num_posts'=>$num_posts, 'colorscheme'=>$colorscheme);
		$f1 = new Facebook_plugins_class();
		$content = $f1->get_comments($criteria);
		
		return $content;
	}
	
	/*
	function shortcode_recommendations_bar($atts, $content = null, $code) {
		extract(shortcode_atts(array(
		'url' => '',
		'read_time' => '',
		'action' => '',
		'side' => '',
		'domain' => '',
		), $atts));
		
		add_action( 'wp_footer', array(__CLASS__, 'enqueue_js_sdk') );
		if($url=='') $url = 'http://'.$_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
		
		$criteria = array('url'=>$url, 'read_time'=>$read_time, 'action'=>$action, 'side'=>$side, 'domain'=>$domain);
		$f1 = new Facebook_plugins_class();
		$content = $f1->get_recommendations_bar($criteria);
		
		return $content;
	}
	*/
	
	function shortcode_status_update($atts, $content = null, $code) {
		extract(shortcode_atts(array(
		'title' => '',
		'message' => '',
		'name' => '',
		'link' => '',
		'picture' => '',
		'caption' => '',
		'description' => '',
		), $atts));
		
		add_action( 'wp_footer', array(__CLASS__, 'enqueue_js_sdk') );
		
		$criteria = array('title'=>$title, 'message'=>$message, 'name'=>$name, 'link'=>$link, 'picture'=>$picture, 'caption'=>$caption, 'description'=>$description);
		$f1 = new Facebook_plugins_class();
		$content = $f1->display_status_update($criteria);
		
		return '<p>'.$content.'</p>';
	}
	
	function shortcode_add_friend_dialog($atts, $content = null, $code) {
		extract(shortcode_atts(array(
		'title' => '',
		'id' => '',
		), $atts));
		
		add_action( 'wp_footer', array(__CLASS__, 'enqueue_js_sdk') );
		
		$criteria = array('id'=>$id, 'title'=>$title);
		$f1 = new Facebook_plugins_class();
		$content = $f1->display_add_friend_dialog($criteria);
		
		return '<p>'.$content.'</p>';
	}
	
	/*
	END shortcode
	#############
	*/
	
	/*
	##############
	START Settings
	*/
	function settings_page_display() {
		
		//Standard form
		$lang_tab = array('en_US'=>'English', 'fr_FR'=>'French', 'es_LA'=>'Spanish', 'ko_KR'=>'Korean', 'ja_JP'=>'Japanese','de_DE'=>'German', 'tr_TR'=>'Turkish', 'nl_NL'=>'Dutch', 'el_GR'=>'Greek');
		$yes_no = array(''=>'Disabled', '1'=>'Load only where needed (recommended)', '2'=>'Load globally on all the site');
		$send_tab = array(''=>'Disabled', 'true'=>'Enabled');
		$colorscheme_tab = array('light'=>'Light', 'dark'=>'Dark');
		$true_false_tab = array('true'=>'True', 'false'=>'False');
		$layout_tab = array('standard'=>'Standard', 'button_count'=>'Button count', 'box_count'=>'Box count');
		$action_tab = array('like'=>'Like', 'recommend'=>'Recommend');
		
		/*
		$n1 = new Update_notifier_fb_wpress_plugins();
		$flag = $n1->checkVersion();
		if($flag) {
			$updates_content = 'Your plugin looks up to date.';
		}
		else {
			$updates_content = $n1->getNotification();
		}
		
		$sections['updates']['title'] = 'Updates';
		$sections['updates']['form'][] = array('type'=>'content', 'content'=>$updates_content);
		*/
		
		$sections['fb_app_settings']['title'] = 'Facebook app settings';
		$sections['fb_app_settings']['form'][] = array('type'=>'text', 'name'=>'fb_app_id', 'title'=>'<b>Facebook app id</b>:');
		$sections['fb_app_settings']['form'][] = array('type'=>'select', 'name'=>'fb_sdk_lang', 'title'=>'<b>Language</b>:', 'values'=>$lang_tab);
		$sections['fb_app_settings']['form'][] = array('type'=>'radio', 'name'=>'fb_sdk', 'title'=>'<b>Facebook SDK integration</b>:', 'values'=>$yes_no);
		$sections['fb_app_settings']['form'][] = array('type'=>'radio', 'name'=>'open_graph', 'title'=>'<b>Open Graph tags integration:</b> ', 'values'=>$send_tab);
		$sections['fb_app_settings']['form'][] = array('type'=>'text', 'name'=>'fb_user_ids', 'title'=>'<b>Facebook users ids</b>: (Open graph need to be enabled - used to enable the given users to moderate comments)');
		
		$display_tab = array(''=>'Not active', '1'=>'Always display except...', '2'=>'Don\'t display except...');
		$position_tab = array(''=>'Top of page', '1'=>'Bottom of page');
		
		$posts = get_posts(array('numberposts'=>0));
		for($i=0; $i<count($posts); $i++) {
			$id = $posts[$i]->ID;
			$title = $posts[$i]->post_title;
			$posts_list[$id] = $title;
		}
		
		$pages = get_pages(array('numberposts'=>0));
		for($i=0; $i<count($pages); $i++) {
			$id = $pages[$i]->ID;
			$title = $pages[$i]->post_title;
			$pages_list[$id] = $title;
		}
		
		$sections['like_button']['title'] = 'Like button customization';
		$sections['like_button']['form'][] = array('type'=>'radio', 'name'=>'send', 'title'=>'<b>Send button:</b> ', 'values'=>$send_tab);
		$sections['like_button']['form'][] = array('type'=>'radio', 'name'=>'layout', 'title'=>'<b>Layout:</b> ', 'values'=>$layout_tab);
		$sections['like_button']['form'][] = array('type'=>'text', 'name'=>'width', 'title'=>'<b>Width</b>: (ex: 450)');
		$sections['like_button']['form'][] = array('type'=>'radio', 'name'=>'colorscheme', 'title'=>'<b>Color scheme:</b> ', 'values'=>$colorscheme_tab);
		$sections['like_button']['form'][] = array('type'=>'radio', 'name'=>'show_faces', 'title'=>'<b>Show faces:</b> ', 'values'=>$true_false_tab);
		$sections['like_button']['form'][] = array('type'=>'radio', 'name'=>'action_verb', 'title'=>'<b>Action verb:</b> ', 'values'=>$action_tab);
				
		$sections['like_button_posts']['title'] = 'Like button in posts';
		$sections['like_button_posts']['form'][] = array('type'=>'select', 'name'=>'display', 'title'=>'<b>Display:</b> ', 'values'=>$display_tab);
		$sections['like_button_posts']['form'][] = array('type'=>'select', 'name'=>'position', 'title'=>'<b>Positioning:</b> ', 'values'=>$position_tab);
		$sections['like_button_posts']['form'][] = array('type'=>'checkbox', 'name'=>'exceptions', 'title'=>'<b>Exceptions:</b> ', 'values'=>$posts_list);
		
		$sections['like_button_pages']['title'] = 'Like button in pages';
		$sections['like_button_pages']['form'][] = array('type'=>'select', 'name'=>'display', 'title'=>'<b>Display:</b> ', 'values'=>$display_tab);
		$sections['like_button_pages']['form'][] = array('type'=>'select', 'name'=>'position', 'title'=>'<b>Positioning:</b> ', 'values'=>$position_tab);
		$sections['like_button_pages']['form'][] = array('type'=>'checkbox', 'name'=>'exceptions', 'title'=>'<b>Exceptions:</b> ', 'values'=>$pages_list);
		
		$sections['comments']['title'] = 'Comments customization';
		$sections['comments']['form'][] = array('type'=>'text', 'name'=>'title', 'title'=>'<b>Headline title</b>: (displayed above the comments plugin)');
		$sections['comments']['form'][] = array('type'=>'text', 'name'=>'width', 'title'=>'<b>Width</b>: (ex: 450)');
		$sections['comments']['form'][] = array('type'=>'text', 'name'=>'num_posts', 'title'=>'<b>Number of posts</b>: (ex: 10)');
		$sections['comments']['form'][] = array('type'=>'radio', 'name'=>'colorscheme', 'title'=>'<b>Color scheme:</b> ', 'values'=>$colorscheme_tab);
		$sections['comments']['form'][] = array('type'=>'radio', 'name'=>'disable_wp_comments', 'title'=>'<b>Disable WordPress comments?:</b> ', 'values'=>$true_false_tab);
		
		$sections['comments_posts']['title'] = 'Comments in posts';
		$sections['comments_posts']['form'][] = array('type'=>'select', 'name'=>'display', 'title'=>'<b>Display:</b> ', 'values'=>$display_tab);
		$sections['comments_posts']['form'][] = array('type'=>'checkbox', 'name'=>'exceptions', 'title'=>'<b>Exceptions:</b> ', 'values'=>$posts_list);
		
		$sections['comments_pages']['title'] = 'Comments in pages';
		$sections['comments_pages']['form'][] = array('type'=>'select', 'name'=>'display', 'title'=>'<b>Display:</b> ', 'values'=>$display_tab);
		$sections['comments_pages']['form'][] = array('type'=>'checkbox', 'name'=>'exceptions', 'title'=>'<b>Exceptions:</b> ', 'values'=>$pages_list);
		
		/*
		<script>
		  jQuery(function () {
			jQuery('#ygpi_tabs a').click(function (e) {
			  e.preventDefault();
			  jQuery(this).tab('show');
			})
		  })
		</script>
		
		<div class="tabbable tabs-left">
			<ul id="ygpi_tabs" class="nav nav-tabs">
			  <li><a href="#tab1" data-toggle="tab">Home</a></li>
			  <li><a href="#tab2" data-toggle="tab">Profile</a></li>
			  <li><a href="#tab3" data-toggle="tab">Messages</a></li>
			  <li><a href="#tab4" data-toggle="tab">Settings</a></li>
			</ul>
			<div class="tab-content">
				<div class="tab-pane active" id="tab1">111</div>
				<div class="tab-pane active" id="tab2">222</div>
				<div class="tab-pane active" id="tab3">333</div>
				<div class="tab-pane active" id="tab4">444</div>
			</div>
		</div>
		*/
		
		parent::settings_page_display(array('sections'=>$sections));
		
		echo '<br><div><b>Created by <a href="http://yougapi.com">Yougapi Technology</a> - <a href="http://www.facebook.com/yougapi">Facebook page</a></b></div>';
		echo 'We provide support to all our buyers ! If you have any question please contact us using the form on our <a href="http://codecanyon.net/user/yougapi?ref=yougapi">profile page here</a>';
	}
	
	/*
	END Settings
	###########
	*/
	
	
	/*
	###############################
	START Plugin Activation Functions
	*/
	
	//Executed on plugin activation
	function on_plugin_activation() {
		
	}
	
	/*
	End plugin activation functions
	###############################
	*/
	
	function ajax_listeners() {
		$method = $_POST['method'];
		
		//default function used with the "fb_connect_callback" JS function
		if($method=='fb_connect_callback') {
			//$fb_user = parent::getFbUserData();
		}
		
		exit;
	}
}

new Fb_wpress_plugins();

?>