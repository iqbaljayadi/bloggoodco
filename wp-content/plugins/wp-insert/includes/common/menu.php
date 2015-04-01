<?php
function wp_insert_add_main_menu() {
	add_menu_page('Wp Insert', 'Wp Insert', 'manage_options', 'wp-insert', 'wp_insert_inpostads_admin_page');
}
add_action('admin_menu', 'wp_insert_add_main_menu');
?>