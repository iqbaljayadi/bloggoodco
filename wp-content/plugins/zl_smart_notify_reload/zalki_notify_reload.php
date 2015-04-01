<?php
/*
Plugin Name: Smart Notification Reload
Plugin URI: http://zalki-lab.com/smart-notify-reload
Description: Smart Notification Reload | jQuery Plugin for Wordpress
Version: 2.2.2
Author: Zalki-Lab
Author URI:
*/

/********************
* INCLUDES
********************/
require(plugin_basename('library/ZalkiNotifyReload.php'));

/********************
* INIT PLUGIN
********************/
add_action( 'init', 'zalki_notify_reload_init' );
	
function zalki_notify_reload_init () {

	
	$zalki_notify_reload_init = new ZalkiNotifyReload();
}

?>