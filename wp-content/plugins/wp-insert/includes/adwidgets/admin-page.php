<?php
function wp_insert_adwidgets_admin_page() {
	wp_insert_admin_page('Ad Widgets', 'wp-insert-adwidgets', 'wp_insert_adwidgets_options');
}

function wp_insert_more_adwidgets_admin_page() {
	wp_insert_admin_page('Ad Widgets', 'wp-insert-more-adwidgets', 'wp_insert_more_adwidgets_options');
}

add_action('admin_init', 'wp_insert_adwidgets_admin_init');
function wp_insert_adwidgets_admin_init() {	
	register_setting('wp_insert_adwidgets_options', 'wp_insert_adwidgets_options', 'wp_insert_adwidgets_validate');
    add_settings_section('wp-insert-adwidgets', '', 'wp_insert_adwidgets_section', 'wp-insert-adwidgets');
	
	$options = get_option('wp_insert_adwidgets_options');
	add_meta_box('wp_insert_multiple_network_status', 'Multiple Ad Networks', 'wp_insert_multiple_network_status_content', 'wp-insert-adwidgets', 'advanced', 'high', array('location' => 'multiple-network', 'name' => 'wp_insert_adwidgets_options', 'data' => $options));
	for($i = 1; $i <= 10; $i++) {
		add_meta_box('wp-insert-adwidgets-'.$i, 'Ad Widget : '.$i, 'wp_insert_adwidgets_content', 'wp-insert-adwidgets', 'advanced', 'low', array('location' => 'adwidgets-'.$i, 'name' => 'wp_insert_adwidgets_options', 'data' => $options));
	}
	
	register_setting('wp_insert_more_adwidgets_options', 'wp_insert_more_adwidgets_options', 'wp_insert_adwidgets_validate');
    add_settings_section('wp-insert-more-adwidgets', '', 'wp_insert_more_adwidgets_section', 'wp-insert-more-adwidgets');
	
	$options = get_option('wp_insert_more_adwidgets_options');
	add_meta_box('wp_insert_multiple_network_status', 'Multiple Ad Networks', 'wp_insert_multiple_network_status_content', 'wp-insert-more-adwidgets', 'advanced', 'high', array('location' => 'multiple-network', 'name' => 'wp_insert_more_adwidgets_options', 'data' => $options));
	for($i = 11; $i <= 20; $i++) {
		add_meta_box('wp-insert-more-adwidgets-'.$i, 'Ad Widget : '.$i, 'wp_insert_adwidgets_content', 'wp-insert-more-adwidgets', 'advanced', 'low', array('location' => 'adwidgets-'.$i, 'name' => 'wp_insert_more_adwidgets_options', 'data' => $options));
	}
}

function wp_insert_adwidgets_section() {
	do_meta_boxes('wp-insert-adwidgets', 'advanced', null);
}

function wp_insert_more_adwidgets_section() {
	do_meta_boxes('wp-insert-more-adwidgets', 'advanced', null);
}

function wp_insert_adwidgets_content($post, $args) {
	$location = $args['args']['location'];
	$data = $args['args']['data'];
	$id = $args['id'];
	$name = $args['args']['name'].'['.$location.']';
	
	if(!isset($data[$location])) { $data[$location] = array(); }
	$data = wp_insert_sanitize_array($data[$location], array('status', 'ad_code_1', 'ad_code_2', 'ad_code_3', 'country_1', 'country_code_1', 'rules_exclude_home', 'rules_exclude_archives', 'rules_exclude_categories', 'rules_categories_exceptions', 'rules_categories_post_exceptions', 'rules_exclude_search', 'rules_exclude_page', 'rules_page_exceptions', 'rules_exclude_post', 'rules_post_exceptions', 'styles'));
	
	$controls = array();
	$controls['status'] = wp_insert_get_control('tz-checkbox', false, $name.'[status]', $id.'-status', $data['status']);
	$controls['ad_code_1'] = wp_insert_get_control('textarea', false, $name.'[ad_code_1]', $id.'-ad_code_1', $data['ad_code_1'], 'Ad Code (Primary Network):', '', null, 'input widefat chitika');
	$controls['ad_code_2'] = wp_insert_get_control('textarea', false, $name.'[ad_code_2]', $id.'-ad_code_2', $data['ad_code_2'], 'Ad Code (Secondary Network):', '', null, 'input widefat chitika');
	$controls['ad_code_3'] = wp_insert_get_control('textarea', false, $name.'[ad_code_3]', $id.'-ad_code_3', $data['ad_code_3'], 'Ad Code (Tertiary Network):', '', null, 'input widefat chitika');

	$controls['country_1'] = wp_insert_get_control('popup', false, $name.'[country_1]', $id.'-country_1', $data['country_1'], 'Geo Targets', '', array('type' => 'countries'));
	$controls['country_code_1'] = wp_insert_get_control('textarea', false, $name.'[country_code_1]', $id.'-country_code_1', $data['country_code_1'], 'Ad Code', '', null, 'input widefat chitika');

	$controls['rules_exclude_home'] = wp_insert_get_control('ip-checkbox', false, $name.'[rules_exclude_home]', $id.'-rules_exclude_home', $data['rules_exclude_home'], '', '', null, '', false);
	$controls['rules_exclude_archives'] = wp_insert_get_control('ip-checkbox', false, $name.'[rules_exclude_archives]', $id.'-rules_exclude_archives', $data['rules_exclude_archives'], '', '', null, '', false);
	$controls['rules_exclude_categories'] = wp_insert_get_control('ip-checkbox', false, $name.'[rules_exclude_categories]', $id.'-rules_exclude_categories', $data['rules_exclude_categories'], '', '', null, '', false);
	$controls['rules_categories_exceptions'] = wp_insert_get_control('popup', false, $name.'[rules_categories_exceptions]', $id.'-rules_categories_exceptions', $data['rules_categories_exceptions'], '', '', array('type' => 'categories'), '', false);
	$controls['rules_categories_post_exceptions'] = wp_insert_get_control('popup', false, $name.'[rules_categories_post_exceptions]', $id.'-rules_categories_post_exceptions', $data['rules_categories_post_exceptions'], '', '', array('type' => 'categories'), '', false);
	$controls['rules_exclude_search'] = wp_insert_get_control('ip-checkbox', false, $name.'[rules_exclude_search]', $id.'-rules_exclude_search', $data['rules_exclude_search'], '', '', null, '', false);
	$controls['rules_exclude_page'] = wp_insert_get_control('ip-checkbox', false, $name.'[rules_exclude_page]', $id.'-rules_exclude_page', $data['rules_exclude_page'], '', '', null, '', false);
	$controls['rules_page_exceptions'] = wp_insert_get_control('popup', false, $name.'[rules_page_exceptions]', $id.'-rules_page_exceptions', $data['rules_page_exceptions'], '', '', array('type' => 'pages'), '', false);
	$controls['rules_exclude_post'] = wp_insert_get_control('ip-checkbox', false, $name.'[rules_exclude_post]', $id.'-rules_exclude_post', $data['rules_exclude_post'], '', '', null, '', false);
	$controls['rules_post_exceptions'] = wp_insert_get_control('popup', false, $name.'[rules_post_exceptions]', $id.'-rules_post_exceptions', $data['rules_post_exceptions'], '', '', array('type' => 'posts'), '', false);
	$post_types = get_post_types(array('public'   => true, '_builtin' => false), 'names'); 
	if($post_types) {
		foreach($post_types as $post_type) {
			$controls['rules_exclude_cpt_'.$post_type] = wp_insert_get_control('ip-checkbox', false, $name.'[rules_exclude_cpt_'.$post_type.']', $id.'-rules_exclude_cpt_'.$post_type, $data['rules_exclude_cpt_'.$post_type], '', '', null, '', false);
		}
	}
	
	$controls['styles'] = wp_insert_get_control('textarea', false, $name.'[styles]', $id.'-styles', $data['styles'], 'Styles:');
	
	echo $controls['status']['html'];
	
	$multiple_network_status = get_option('wp_insert_multiple_network_status');
	if($multiple_network_status == 2 || $multiple_network_status == 1) {
		$controls['ad_code_3']['html'] = '<div style="display: none;">'.$controls['ad_code_3']['html'].'</div>';
	}
	
	if($multiple_network_status == 1) {
		$controls['ad_code_2']['html'] = '<div style="display: none;">'.$controls['ad_code_2']['html'].'</div>';
	}	
	$tabData = array(
		array(
			'title' => 'Ad Code',
			'content' => $controls['ad_code_1']['html'].$controls['ad_code_2']['html'].$controls['ad_code_3']['html']
		),
		array(
			'title' => 'Rules',
			'content' => wp_insert_adwidgets_rules_content($controls)
		),
		array(
			'title' => 'Geo Targeting',
			'content' => '<p>'.$controls['country_1']['html'].$controls['country_code_1']['html'].'</p>'
		),
		array(
			'title' => 'Styles',
			'content' => $controls['styles']['html']
		)
	);
	$controls['vtab'] = wp_insert_get_vtabs('vtab_'.$location, $tabData);
	echo $controls['vtab']['html'];
	
	echo wp_insert_get_script_tag($controls);
}

function wp_insert_adwidgets_rules_content($controls) {
	$rulesTable = array(
		'class' => 'rules',
		'rows' => array()
	);
	array_push(
		$rulesTable['rows'],
		array(
			'cells' => array(
				array('style' => 'text-align: left;', 'colspan' => '3', 'type' => 'th', 'content' => 'Home')
			)
		),
		array(
			'cells' => array(
				array('content' => 'Status'),
				array('content' => '&nbsp;:&nbsp;'),
				array('content' => $controls['rules_exclude_home']['html'])
			)
		)
	);
	array_push(
		$rulesTable['rows'], 
		array(
			'cells' => array(
				array('colspan' => '3', 'content' => '&nbsp;')
			)
		),
		array(
			'cells' => array(
				array('style' => 'text-align: left;', 'colspan' => '3', 'type' => 'th', 'content' => 'Archives')
			)
		),
		array(
			'cells' => array(
				array('content' => 'Status'),
				array('content' => '&nbsp;:&nbsp;'),
				array('content' => $controls['rules_exclude_archives']['html'])
			)
		)
	);
	array_push(
		$rulesTable['rows'], 
		array(
			'cells' => array(
				array('colspan' => '3', 'content' => '&nbsp;')
			)
		),
		array(
			'cells' => array(
				array('style' => 'text-align: left;', 'colspan' => '3', 'type' => 'th', 'content' => 'Categories')
			)
		),
		array(
			'cells' => array(
				array('content' => 'Status'),
				array('content' => '&nbsp;:&nbsp;'),
				array('content' => $controls['rules_exclude_categories']['html'])
			)
		),
		array(
			'cells' => array(
				array('content' => 'Exceptions'),
				array('content' => '&nbsp;:&nbsp;'),
				array('content' => $controls['rules_categories_exceptions']['html'])
			)
		),
		array(
			'cells' => array(
				array('content' => 'Post Exceptions'),
				array('content' => '&nbsp;:&nbsp;'),
				array('content' => $controls['rules_categories_post_exceptions']['html'])
			)
		)
	);
	array_push(
		$rulesTable['rows'], 
		array(
			'cells' => array(
				array('colspan' => '3', 'content' => '&nbsp;')
			)
		),
		array(
			'cells' => array(
				array('style' => 'text-align: left;', 'colspan' => '3', 'type' => 'th', 'content' => 'Search Results')
			)
		),
		array(
			'cells' => array(
				array('content' => 'Status'),
				array('content' => '&nbsp;:&nbsp;'),
				array('content' => $controls['rules_exclude_search']['html'])
			)
		)
	);
	array_push(
		$rulesTable['rows'], 
		array(
			'cells' => array(
				array('colspan' => '3', 'content' => '&nbsp;')
			)
		),
		array(
			'cells' => array(
				array('style' => 'text-align: left;', 'colspan' => '3', 'type' => 'th', 'content' => 'Single Page')
			)
		),
		array(
			'cells' => array(
				array('content' => 'Status'),
				array('content' => '&nbsp;:&nbsp;'),
				array('content' => $controls['rules_exclude_page']['html'])
			)
		),
		array(
			'cells' => array(
				array('content' => 'Exceptions'),
				array('content' => '&nbsp;:&nbsp;'),
				array('content' => $controls['rules_page_exceptions']['html'])
			)
		)
	);
	array_push(
		$rulesTable['rows'], 
		array(
			'cells' => array(
				array('colspan' => '3', 'content' => '&nbsp;')
			)
		),
		array(
			'cells' => array(
				array('style' => 'text-align: left;', 'colspan' => '3', 'type' => 'th', 'content' => 'Single Blog Post')
			)
		),
		array(
			'cells' => array(
				array('content' => 'Status'),
				array('content' => '&nbsp;:&nbsp;'),
				array('content' => $controls['rules_exclude_post']['html'])
			)
		),
		array(
			'cells' => array(
				array('content' => 'Exceptions'),
				array('content' => '&nbsp;:&nbsp;'),
				array('content' => $controls['rules_post_exceptions']['html'])
			)
		)
	);
	array_push(
		$rulesTable['rows'], 
		array(
			'cells' => array(
				array('colspan' => '3', 'content' => '&nbsp;')
			)
		),
		array(
			'cells' => array(
				array('style' => 'text-align: left;', 'colspan' => '3', 'type' => 'th', 'content' => 'Custom Post Types')
			)
		)
	);
	
	$post_types = get_post_types(array('public'   => true, '_builtin' => false), 'object'); 
	if($post_types) {
		foreach($post_types as $post_type) {
			array_push(
				$rulesTable['rows'],
				array(
					'cells' => array(
						array('content' => $post_type->labels->name),
						array('content' => '&nbsp;:&nbsp;'),
						array('content' => $controls['rules_exclude_cpt_'.$post_type->name]['html'])
					)
				)
			);
		}
	}
	
	return wp_insert_get_table($rulesTable);
}

function wp_insert_adwidgets_validate($input) {
	update_option('wp_insert_multiple_network_status', $input['multiple-network']['status']);	
	return $input;
}
?>