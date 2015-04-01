<?php
function wp_insert_legal_admin_page() {
	wp_insert_admin_page('Legal Pages', 'wp-insert-legal', 'wp_insert_legal_options');
}

add_action('admin_init', 'wp_insert_legal_admin_init');
function wp_insert_legal_admin_init() {	
	register_setting('wp_insert_legal_options', 'wp_insert_legal_options', 'wp_insert_legal_validate');
    add_settings_section('wp-insert-legal', '', 'wp_insert_legal_section', 'wp-insert-legal');
	
	$options = get_option('wp_insert_legal_options');
	add_meta_box('wp-insert-legal-privacy-policy', 'Privacy Policy', 'wp_insert_legal_content', 'wp-insert-legal', 'advanced', 'low', array('location' => 'privacy-policy', 'name' => 'wp_insert_legal_options', 'data' => $options));
	add_meta_box('wp-insert-legal-terms-and-conditions', 'Terms and Conditions', 'wp_insert_legal_content', 'wp-insert-legal', 'advanced', 'low', array('location' => 'terms-and-conditions', 'name' => 'wp_insert_legal_options', 'data' => $options));
	add_meta_box('wp-insert-legal-disclaimer', 'Disclaimer', 'wp_insert_legal_content', 'wp-insert-legal', 'advanced', 'low', array('location' => 'disclaimer', 'name' => 'wp_insert_legal_options', 'data' => $options));
	add_meta_box('wp-insert-copyright-notice', 'Copyright Notice', 'wp_insert_legal_content', 'wp-insert-legal', 'advanced', 'low', array('location' => 'copyright-notice', 'name' => 'wp_insert_legal_options', 'data' => $options));
}

function wp_insert_legal_section() {
	do_meta_boxes('wp-insert-legal', 'advanced', null);
}

function wp_insert_legal_content($post, $args) {
	$location = $args['args']['location'];
	$data = $args['args']['data'];
	$id = $args['id'];
	$name = $args['args']['name'].'['.$location.']';
	
	if(!isset($data[$location])) { $data[$location] = array(); }
	$data = wp_insert_sanitize_array($data[$location], array('content', 'pages'));
	
	$controls = array();
	$controls['content'] = wp_insert_get_control('nicedit', false, $name.'[content]', $id.'-content', $data['content'], '', 'Leave the field empty to reset to the default content', null);
	$controls['pages'] = wp_insert_get_control('popup', false, $name.'[pages]', $id.'-pages', $data['pages'], 'Assign Page(s):', '', array('type' => 'pages'));
	
	$tabData = array(
		array(
			'title' => 'Content',
			'content' => $controls['content']['html']
		),
		array(
			'title' => 'Assign Page(s)',
			'content' => $controls['pages']['html']
		)
	);
	$controls['vtab'] = wp_insert_get_vtabs('vtab_'.$location, $tabData);
	echo $controls['vtab']['html'];
	
	echo wp_insert_get_script_tag($controls);
}

function wp_insert_legal_validate($input) {
	if($input['privacy-policy']['content'] == '<br>') {
		$input['privacy-policy']['content'] = wp_insert_legal_get_default_privacy_policy();
	}
	if($input['terms-and-conditions']['content'] == '<br>') {
		$input['terms-and-conditions']['content'] = wp_insert_legal_get_default_terms_and_conditions();
	}
	if($input['disclaimer']['content'] == '<br>') {
		$input['disclaimer']['content'] = wp_insert_legal_get_default_disclaimer();
	}
	if($input['copyright-notice']['content'] == '<br>') {
		$input['copyright-notice']['content'] = wp_insert_legal_get_default_copyright_notice();
	}
	return $input;
}
?>