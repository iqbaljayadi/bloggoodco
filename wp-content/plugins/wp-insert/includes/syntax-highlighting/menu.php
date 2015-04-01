<?php
function wp_insert_syntax_highlighting_menu() {
	$subPageHandle = add_submenu_page('wp-insert', 'Syntax Highlighting', 'Syntax Highlighting', 'manage_options', 'wp-insert-syntax-highlighting', 'wp_insert_syntax_highlighting_admin_page');
	add_action('admin_print_styles-'.$subPageHandle, 'wp_insert_admin_styles');
}
add_action('admin_menu', 'wp_insert_syntax_highlighting_menu');
?>