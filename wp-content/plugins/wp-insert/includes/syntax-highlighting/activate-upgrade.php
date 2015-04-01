<?php
add_action('wp_insert_activate_upgrade', 'wp_insert_syntax_highlighting_activate_upgrade');
function wp_insert_syntax_highlighting_activate_upgrade() {
	if(!get_option('wp_insert_syntax_highlighting_options')) {
		$values = array(
			'editor' => array(
				'status' => '',
			),
			'content' => array(
				'status' => '',
			)
		);
		$values = wp_insert_syntax_highlighting_upgrade_from_1x($values);
		update_option('wp_insert_syntax_highlighting_options', $values);
	}
}

function wp_insert_syntax_highlighting_upgrade_from_1x($values) {
	$val = wp_insert_read_and_destroy_old_option('wp_insert_sh_editor_enable_button');
	$values['editor']['status'] = ($val == null)?$values['editor']['status']:$val;
	
	$val = wp_insert_read_and_destroy_old_option('wp_insert_sh_posts_enable_button');
	$values['content']['status'] = ($val == null)?$values['content']['status']:$val;
	return $values;
}
?>