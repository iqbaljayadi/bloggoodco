<?php
function wp_insert_legal_menu() {
	$subPageHandle = add_submenu_page('wp-insert', 'Setup Legal Pages', 'Setup Legal Pages', 'manage_options', 'wp-insert-legal', 'wp_insert_legal_admin_page');
	add_action('admin_print_styles-'.$subPageHandle, 'wp_insert_admin_styles');
}
add_action('admin_menu', 'wp_insert_legal_menu');
?>