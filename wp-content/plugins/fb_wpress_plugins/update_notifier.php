<?php

include_once('../wp-admin/includes/plugin.php');

class Update_notifier_fb_wpress_plugins
{
	var $token = 'update_notifier_fb_wpress_plugins';
	var $cache_interval = '43200'; //21600 = 6h // 43200 = 12h
	var $notifier_url = 'http://yougapi.com/updates/?item=fb_wpress_plugins';
	var $plugin_folder = 'fb_wpress_plugins';
	var $plugin_name = 'fb_wpress_plugins.php';
	var $no_cache = 1; //set to 1 to disable the caching
	
	function __construct() {
		
	}
	
	function notifier_bar_menu() {
		global $wp_admin_bar;
		$wp_admin_bar->add_menu( array( 'id' => 'plugin_update_notifier', 'title' => '<span> Facebook WPress Plugins <span id="ab-updates">New Update</span></span>', 'href' => get_admin_url() . 'plugins.php?page=fb-wpress-plugins' ) );	
	}
	
	function getToken() {
		return $this->token;
	}
	
	function getNotification() {
		$cache = get_option($this->token);
		if($cache!='') {
			$cache = json_decode($cache, true);
			return $cache['notification'];
		}
	}
	
	function checkVersion() {
		$cache = get_option($this->token);
		
		if($cache!='') {
			$plugin_data = get_plugin_data(WP_PLUGIN_DIR.'/'.$this->plugin_folder.'/'.$this->plugin_name);
			$plugin_name = $plugin_data['Name'];
			$plugin_version = $plugin_data['Version'];
			$plugin_url = $plugin_data['PluginURI'];
			$cache = json_decode($cache, true);
			if($plugin_version<$cache['version']) {
				return false;
			}
			else {
				return true;
			}
		}
	}
	
	function getLatestVersion() {
		$now = time();
		
		$cache_time = get_option($this->token.'_last_update');
		$cache = get_option($this->token);
		
		$plugin_data = get_plugin_data(WP_PLUGIN_DIR.'/'.$this->plugin_folder.'/'.$this->plugin_name);
		$plugin_name = $plugin_data['Name'];
		$plugin_version = $plugin_data['Version'];
		$plugin_url = $plugin_data['PluginURI'];
		
		if($cache_time=='' || $cache_time<$now || $this->no_cache) {
			
			//Call remote URL
			if( function_exists('curl_init') ) {
				$ch = curl_init($this->notifier_url.'&s=http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
				curl_setopt($ch, CURLOPT_HEADER, 0);
				curl_setopt($ch, CURLOPT_TIMEOUT, 10);
				$cache = curl_exec($ch);
				curl_close($ch);
			}
			else {
				$cache = file_get_contents($this->notifier_url.'&s=http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
			}
			
			//Successfully got results from remote file
			if($cache) {
				//Update cache
				update_option( $this->token.'_last_update', ($now+$this->cache_interval) );
				update_option( $this->token, $cache );
			
				$cache = json_decode($cache, true);
				if($plugin_version<$cache['version']) {
					add_action('admin_bar_menu', array(__CLASS__, 'notifier_bar_menu'), 1000 );
				}
			}
		}
		else {
			if($cache!='') {
				$cache = json_decode($cache, true);
				if($plugin_version<$cache['version']) {
					add_action('admin_bar_menu', array(__CLASS__, 'notifier_bar_menu'), 1000 );
				}
			}
		}
	}
}

$u1 = new Update_notifier_fb_wpress_plugins();
$u1->getLatestVersion();

?>