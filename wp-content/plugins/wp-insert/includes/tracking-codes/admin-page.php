<?php
function wp_insert_tracking_codes_admin_page() {
	wp_insert_admin_page('Tracking Codes', 'wp-insert-tracking-codes', 'wp_insert_tracking_codes_options');
}

add_action('admin_init', 'wp_insert_tracking_codes_admin_init');
function wp_insert_tracking_codes_admin_init() {	
	register_setting('wp_insert_tracking_codes_options', 'wp_insert_tracking_codes_options', 'wp_insert_tracking_codes_validate');
    add_settings_section('wp-insert-tracking-codes', '', 'wp_insert_tracking_codes_section', 'wp-insert-tracking-codes');
	
	$options = get_option('wp_insert_tracking_codes_options');
	add_meta_box('wp-insert-tracking-codes-google-analytics', 'Google Analytics', 'wp_insert_tracking_codes_content', 'wp-insert-tracking-codes', 'advanced', 'low', array('location' => 'analytics', 'name' => 'wp_insert_tracking_codes_options', 'data' => $options));
	add_meta_box('wp-insert-tracking-codes-header', 'Custom code in Header', 'wp_insert_tracking_codes_content', 'wp-insert-tracking-codes', 'advanced', 'low', array('location' => 'header', 'name' => 'wp_insert_tracking_codes_options', 'data' => $options));
	add_meta_box('wp-insert-tracking-codes-footer', 'Custom code in Footer', 'wp_insert_tracking_codes_content', 'wp-insert-tracking-codes', 'advanced', 'low', array('location' => 'footer', 'name' => 'wp_insert_tracking_codes_options', 'data' => $options));
}

function wp_insert_tracking_codes_section() {
	do_meta_boxes('wp-insert-tracking-codes', 'advanced', null);
}

function wp_insert_tracking_codes_content($post, $args) {
	$location = $args['args']['location'];
	$data = $args['args']['data'];
	$id = $args['id'];
	$name = $args['args']['name'].'['.$location.']';

	if(!isset($data[$location])) { $data[$location] = array(); }
	$data = wp_insert_sanitize_array($data[$location], array('status', 'code'));
	
	$controls = array();
	$controls['status'] = wp_insert_get_control('tz-checkbox', false, $name.'[status]', $id.'-status', $data['status']);
	
	if($location == 'analytics') {
		$controls['code'] = wp_insert_get_control('text', false, $name.'[code]', $id.'-code', $data['code'], 'Google Analytics Tracker ID:', 'Your Google Analytics Tracker ID (XX-XXXXX-X)');
	} else {
		$controls['code'] = wp_insert_get_control('textarea', false, $name.'[code]', $id.'-code', $data['code'], 'Code:');
	}

	echo $controls['status']['html'];
	echo $controls['code']['html'];
	echo wp_insert_get_script_tag($controls);
}

function wp_insert_tracking_codes_validate($input) {
	return $input;
}
?>