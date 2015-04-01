<?php
function wp_insert_tracking_codes_menu() {
	$subPageHandle = add_submenu_page('wp-insert', 'Tracking Codes', 'Tracking Codes', 'manage_options', 'wp-insert-tracking-codes', 'wp_insert_tracking_codes_admin_page');
	add_action('admin_print_styles-'.$subPageHandle, 'wp_insert_admin_styles');
}
add_action('admin_menu', 'wp_insert_tracking_codes_menu');
?>