<?php
add_action('init', 'wp_insert_activate_upgrade', 0);
function wp_insert_activate_upgrade() {
	$databaseVersion = get_option('wp_insert_version');
	if($databaseVersion != WP_INSERT_VERSION) {
		do_action('wp_insert_activate_upgrade');
		update_option('wp_insert_version', WP_INSERT_VERSION);
	}
}

function wp_insert_read_and_destroy_old_option($name) {
	$val = get_option($name, false);
	delete_option($name);
	if($val) {		
		return $val;
	}
	return null;
}
?>