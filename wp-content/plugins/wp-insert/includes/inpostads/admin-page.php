<?php
function wp_insert_inpostads_admin_page() {
	wp_insert_admin_page('In Post Ads', 'wp-insert', 'wp_insert_inpostads_options');
}

add_action('admin_init', 'wp_insert_inpostads_admin_init');
function wp_insert_inpostads_admin_init() {	
	register_setting('wp_insert_inpostads_options', 'wp_insert_inpostads_options', 'wp_insert_inpostads_validate');
    add_settings_section('wp-insert-inpostads', '', 'wp_insert_inpostads_section', 'wp-insert');
	
	$options = get_option('wp_insert_inpostads_options');
	add_meta_box('wp_insert_multiple_network_status', 'Multiple Ad Networks', 'wp_insert_multiple_network_status_content', 'wp-insert-inpostads', 'advanced', 'high', array('location' => 'multiple-network', 'name' => 'wp_insert_inpostads_options', 'data' => $options));
	add_meta_box('wp-insert-inpostads-above-content', 'Ad - Above Post Content', 'wp_insert_inpostads_content', 'wp-insert-inpostads', 'advanced', 'low', array('location' => 'above', 'name' => 'wp_insert_inpostads_options', 'data' => $options));
	add_meta_box('wp-insert-inpostads-middle-content', 'Ad - Middle of Post Content', 'wp_insert_inpostads_content', 'wp-insert-inpostads', 'advanced', 'low', array('location' => 'middle', 'name' => 'wp_insert_inpostads_options', 'data' => $options));
	add_meta_box('wp-insert-inpostads-below-content', 'Ad - Below Post Content', 'wp_insert_inpostads_content', 'wp-insert-inpostads', 'advanced', 'low', array('location' => 'below', 'name' => 'wp_insert_inpostads_options', 'data' => $options));
	add_meta_box('wp-insert-inpostads-left-content', 'Ad - Left of Post Content', 'wp_insert_inpostads_content', 'wp-insert-inpostads', 'advanced', 'low', array('location' => 'left', 'name' => 'wp_insert_inpostads_options', 'data' => $options));
	add_meta_box('wp-insert-inpostads-right-content', 'Ad - Right of Post Content', 'wp_insert_inpostads_content', 'wp-insert-inpostads', 'advanced', 'low', array('location' => 'right', 'name' => 'wp_insert_inpostads_options', 'data' => $options));
}

function wp_insert_inpostads_section() {
	do_meta_boxes('wp-insert-inpostads', 'advanced', null);
}

function wp_insert_inpostads_content($post, $args) {
	$location = $args['args']['location'];
	$data = $args['args']['data'];
	$id = $args['id'];
	$name = $args['args']['name'].'['.$location.']';
	
	if(!isset($data[$location])) { $data[$location] = array(); }
	if($location == 'middle') {
		$data = wp_insert_sanitize_array($data[$location], array('status', 'ad_code_1', 'ad_code_2', 'ad_code_3', 'country_1', 'country_code_1', 'rules_exclude_home', 'rules_exclude_archives', 'rules_exclude_categories', 'rules_categories_exceptions', 'rules_categories_post_exceptions', 'rules_exclude_search', 'rules_exclude_page', 'rules_page_exceptions', 'rules_exclude_post', 'rules_post_exceptions', 'styles', 'minimum_character_count', 'paragraph_buffer_count'));
	} else {
		$data = wp_insert_sanitize_array($data[$location], array('status', 'ad_code_1', 'ad_code_2', 'ad_code_3', 'country_1', 'country_code_1', 'rules_exclude_home', 'rules_exclude_archives', 'rules_exclude_categories', 'rules_categories_exceptions', 'rules_categories_post_exceptions', 'rules_exclude_search', 'rules_exclude_page', 'rules_page_exceptions', 'rules_exclude_post', 'rules_post_exceptions', 'styles'));
	}
	
	$controls = array();
	$controls['status'] = wp_insert_get_control('tz-checkbox', false, $name.'[status]', $id.'-status', $data['status']);
	$controls['ad_code_1'] = wp_insert_get_control('textarea', false, $name.'[ad_code_1]', $id.'-ad_code_1', $data['ad_code_1'], 'Ad Code (Primary Network):', '', null, 'input widefat chitika');
	$controls['ad_code_2'] = wp_insert_get_control('textarea', false, $name.'[ad_code_2]', $id.'-ad_code_2', $data['ad_code_2'], 'Ad Code (Secondary Network):', '', null, 'input widefat chitika');
	$controls['ad_code_3'] = wp_insert_get_control('textarea', false, $name.'[ad_code_3]', $id.'-ad_code_3', $data['ad_code_3'], 'Ad Code (Tertiary Network):', '', null, 'input widefat chitika');

	$controls['country_1'] = wp_insert_get_control('popup', false, $name.'[country_1]', $id.'-country_1', $data['country_1'], 'Geo Targets', '', array('type' => 'countries'));
	$controls['country_code_1'] = wp_insert_get_control('textarea', false, $name.'[country_code_1]', $id.'-country_code_1', $data['country_code_1'], 'Ad Code', '', null, 'input widefat chitika');

	$controls['rules_exclude_home'] = wp_insert_get_control('ip-checkbox', false, $name.'[rules_exclude_home]', $id.'-rules_exclude_home', $data['rules_exclude_home'], '', '', null, '', false);
	$controls['rules_home_instances'] = wp_insert_get_control('popup', false, $name.'[rules_home_instances]', $id.'-rules_home_instances', $data['rules_home_instances'], '', '', array('type' => 'instances'), '', false);
	$controls['rules_exclude_archives'] = wp_insert_get_control('ip-checkbox', false, $name.'[rules_exclude_archives]', $id.'-rules_exclude_archives', $data['rules_exclude_archives'], '', '', null, '', false);
	$controls['rules_archives_instances'] = wp_insert_get_control('popup', false, $name.'[rules_archives_instances]', $id.'-rules_archives_instances', $data['rules_archives_instances'], '', '', array('type' => 'instances'), '', false);
	$controls['rules_exclude_categories'] = wp_insert_get_control('ip-checkbox', false, $name.'[rules_exclude_categories]', $id.'-rules_exclude_categories', $data['rules_exclude_categories'], '', '', null, '', false);
	$controls['rules_categories_instances'] = wp_insert_get_control('popup', false, $name.'[rules_categories_instances]', $id.'-rules_categories_instances', $data['rules_categories_instances'], '', '', array('type' => 'instances'), '', false);
	$controls['rules_categories_exceptions'] = wp_insert_get_control('popup', false, $name.'[rules_categories_exceptions]', $id.'-rules_categories_exceptions', $data['rules_categories_exceptions'], '', '', array('type' => 'categories'), '', false);
	$controls['rules_categories_post_exceptions'] = wp_insert_get_control('popup', false, $name.'[rules_categories_post_exceptions]', $id.'-rules_categories_post_exceptions', $data['rules_categories_post_exceptions'], '', '', array('type' => 'categories'), '', false);
	$controls['rules_exclude_search'] = wp_insert_get_control('ip-checkbox', false, $name.'[rules_exclude_search]', $id.'-rules_exclude_search', $data['rules_exclude_search'], '', '', null, '', false);
	$controls['rules_search_instances'] = wp_insert_get_control('popup', false, $name.'[rules_search_instances]', $id.'-rules_search_instances', $data['rules_search_instances'], '', '', array('type' => 'instances'), '', false);
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
	
	if($location == 'middle') {
		$controls['minimum_character_count'] = wp_insert_get_control('text', false, $name.'[minimum_character_count]', $id.'-minimum_character_count', $data['minimum_character_count'], 'Minimum Character Count', 'Show the ad only if the Content meets the minimum character count. If this parameter is set to 0 (or empty) minimum character count check will be deactivated.', null, 'input widefat');
		$controls['paragraph_buffer_count'] = wp_insert_get_control('text', false, $name.'[paragraph_buffer_count]', $id.'-paragraph_buffer_count', $data['paragraph_buffer_count'], 'Paragraph Buffer Count', 'Shows the ad after X number of Paragraphs.  If this parameter is set to 0 (or empty) the ad will appear in the middle of the content.', null, 'input widefat');
	}
	
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
			'content' => wp_insert_inpostads_rules_content($controls)
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
	if($location == 'middle') {
		array_push(
			$tabData,
			array(
				'title' => 'Settings',
				'content' => $controls['minimum_character_count']['html'].$controls['paragraph_buffer_count']['html']
			)
		);
	}
	$controls['vtab'] = wp_insert_get_vtabs('vtab_'.$location, $tabData);
	echo $controls['vtab']['html'];
	
	echo wp_insert_get_script_tag($controls);
}

function wp_insert_inpostads_rules_content($controls) {
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
		),
		array(
			'cells' => array(
				array('content' => 'Instances'),
				array('content' => '&nbsp;:&nbsp;'),
				array('content' => $controls['rules_home_instances']['html'])
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
		),
		array(
			'cells' => array(
				array('content' => 'Instances'),
				array('content' => '&nbsp;:&nbsp;'),
				array('content' => $controls['rules_archives_instances']['html'])
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
				array('content' => 'Instances'),
				array('content' => '&nbsp;:&nbsp;'),
				array('content' => $controls['rules_categories_instances']['html'])
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
		),
		array(
			'cells' => array(
				array('content' => 'Instances'),
				array('content' => '&nbsp;:&nbsp;'),
				array('content' => $controls['rules_search_instances']['html'])
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

function wp_insert_inpostads_validate($input) {
	update_option('wp_insert_multiple_network_status', $input['multiple-network']['status']);	
	return $input;
}
?>