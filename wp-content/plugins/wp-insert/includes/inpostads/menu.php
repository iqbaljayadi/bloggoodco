<?php
function wp_insert_inpostads_menu() {
	$subPageHandle = add_submenu_page('wp-insert', 'Manage In-Post Ads', 'Manage In-Post Ads', 'manage_options', 'wp-insert', 'wp_insert_inpostads_admin_page');
	add_action('admin_print_styles-'.$subPageHandle, 'wp_insert_admin_styles');
}
add_action('admin_menu', 'wp_insert_inpostads_menu');
?>