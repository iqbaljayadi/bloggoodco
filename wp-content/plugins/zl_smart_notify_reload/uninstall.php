<?php 
// UNINSTALL PLUGIN DATA
if( !defined( 'ABSPATH') && !defined('WP_UNINSTALL_PLUGIN') )
	exit();
 
	global $wpdb;
	$zl_notify_reloaddb_name = $wpdb->prefix . "notify_reload";

	$wpdb->query("DROP TABLE $zl_notify_reloaddb_name");

	if( get_option( 'zl_notify_reload_gen' ) ) {
		delete_option( 'zl_notify_reload_gen' );
	}

?>