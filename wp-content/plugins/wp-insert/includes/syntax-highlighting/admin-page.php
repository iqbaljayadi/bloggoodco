<?php
function wp_insert_syntax_highlighting_admin_page() {
	wp_insert_admin_page('Tracking Codes', 'wp-insert-syntax-highlighting', 'wp_insert_syntax_highlighting_options');
}

add_action('admin_init', 'wp_insert_syntax_highlighting_admin_init');
function wp_insert_syntax_highlighting_admin_init() {	
	register_setting('wp_insert_syntax_highlighting_options', 'wp_insert_syntax_highlighting_options', 'wp_insert_syntax_highlighting_validate');
    add_settings_section('wp-insert-syntax-highlighting', '', 'wp_insert_syntax_highlighting_section', 'wp-insert-syntax-highlighting');
	
	$options = get_option('wp_insert_syntax_highlighting_options');
	add_meta_box('wp-insert-syntax-highlighting-editor', 'Theme & Plugin Editor Syntax Highlighting', 'wp_insert_syntax_highlighting_content', 'wp-insert-syntax-highlighting', 'advanced', 'low', array('location' => 'editor', 'name' => 'wp_insert_syntax_highlighting_options', 'data' => $options));
	add_meta_box('wp-insert-syntax-highlighting-content', 'Syntax Highlighting for Code in Posts & Pages', 'wp_insert_syntax_highlighting_content', 'wp-insert-syntax-highlighting', 'advanced', 'low', array('location' => 'content', 'name' => 'wp_insert_syntax_highlighting_options', 'data' => $options));
}

function wp_insert_syntax_highlighting_section() {
	do_meta_boxes('wp-insert-syntax-highlighting', 'advanced', null);
}

function wp_insert_syntax_highlighting_content($post, $args) {
	$location = $args['args']['location'];
	$data = $args['args']['data'];
	$id = $args['id'];
	$name = $args['args']['name'].'['.$location.']';
	
	if(!isset($data[$location])) { $data[$location] = array(); }
	$data = wp_insert_sanitize_array($data[$location], array('status'));
	
	$controls = array();
	$controls['status'] = wp_insert_get_control('tz-checkbox', false, $name.'[status]', $id.'-status', $data['status'], '', 'Syntax Highlighting support using Editarea 0.8.2 by <a target="_blank" href="http://www.cdolivet.com/index.php?page=editArea">Christophe Dolivet</a>');
	
	echo $controls['status']['html'];
	echo wp_insert_get_script_tag($controls);
}

function wp_insert_syntax_highlighting_validate($input) {
	return $input;
}
?>