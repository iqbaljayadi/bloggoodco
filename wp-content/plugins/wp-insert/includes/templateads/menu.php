<?php
function wp_insert_templateads_menu() {
	$subPageHandle = add_submenu_page('wp-insert', 'Manage Ad Tags<br /><small>(1 - 10)</small>', 'Manage Ad Tags<br /><small>(1 - 10)</small>', 'manage_options', 'wp-insert-templateads', 'wp_insert_templateads_admin_page');
	add_action('admin_print_styles-'.$subPageHandle, 'wp_insert_admin_styles');
	
	$subPageHandle = add_submenu_page('wp-insert', 'Manage Ad Tags<br /><small>(11 - 20)</small>', 'Manage Ad Tags<br /><small>(11 - 20)</small>', 'manage_options', 'wp-insert-more-templateads', 'wp_insert_more_templateads_admin_page');
	add_action('admin_print_styles-'.$subPageHandle, 'wp_insert_admin_styles');
}
add_action('admin_menu', 'wp_insert_templateads_menu');
?>