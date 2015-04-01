<?php
function wp_insert_adwidgets_menu() {
	$subPageHandle = add_submenu_page('wp-insert', 'Manage Ad Widgets<br /><small>(1 - 10)</small>', 'Manage Ad Widgets<br /><small>(1 - 10)</small>', 'manage_options', 'wp-insert-adwidgets', 'wp_insert_adwidgets_admin_page');
	add_action('admin_print_styles-'.$subPageHandle, 'wp_insert_admin_styles');
	$subPageHandle = add_submenu_page('wp-insert', 'Manage Ad Widgets<br /><small>(11 - 20)</small>', 'Manage Ad Widgets<br /><small>(11 - 20)</small>', 'manage_options', 'wp-insert-more-adwidgets', 'wp_insert_more_adwidgets_admin_page');
	add_action('admin_print_styles-'.$subPageHandle, 'wp_insert_admin_styles');
}
add_action('admin_menu', 'wp_insert_adwidgets_menu');
?>