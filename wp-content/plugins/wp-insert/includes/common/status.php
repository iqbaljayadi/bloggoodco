<?php
$wpInsertPostInstance;
$wpInsertAdInstance;
add_action('the_content', 'wp_insert_track_post_instance', 1);
function wp_insert_track_post_instance($content) {
	global $wpInsertPostInstance;
	if($wpInsertPostInstance == '') {
		$wpInsertPostInstance = 1;
	} else {
		$wpInsertPostInstance++;
	}
	return $content;
}

add_action('wp', 'wp_insert_track_ad_instance', 1);
function wp_insert_track_ad_instance($content) {
	global $wpInsertAdInstance;
	$networkCount = get_option('wp_insert_multiple_network_status');
	$wpInsertAdInstance = rand(1, floatval($networkCount));
}

function wp_insert_get_page_details() {
	global $post;
	$page_details = array(
		'type' => 'POST',
		'ID' => $post->ID
	);
	if(is_home() || is_front_page()) {
		$page_details['type'] = 'HOME';
	} else if(is_category()) {
		$page_details['type'] = 'CATEGORY';
		$page_details['ID'] = get_query_var('cat');
	} else if(is_archive()) {
		$page_details['type'] = 'ARCHIVE';
	} else if(is_search()) {
		$page_details['type'] = 'SEARCH';
	} else if(is_page()) {
		$page_details['type'] = 'PAGE';
	} else if(is_single()) {
		if(is_singular('post')) {
			$page_details['type'] = 'POST';
			$page_details['categories'] = wp_get_post_categories($page_details['ID']);
		} else {
			$page_details['type'] = 'CUSTOM';
			$page_details['type_name'] = $post->post_type;
		}
	}
	
	return $page_details;
}

function wp_insert_get_ad_status($rules) {
	if(!isset($rules)) { return false; }
	$rules = wp_insert_sanitize_array($rules, array('status', 'rules_exclude_home', 'rules_home_instances', 'rules_exclude_archives', 'rules_archives_instances', 'rules_exclude_categories', 'rules_categories_exceptions', 'rules_categories_instances', 'rules_exclude_search', 'rules_search_instances', 'rules_exclude_page', 'rules_page_exceptions', 'rules_exclude_post', 'rules_post_exceptions'));
	
	if(!$rules['status']) {
		return false;
	}
	global $wpInsertPostInstance;
	$page_details = wp_insert_get_page_details();
	switch($page_details['type']) {
		case 'HOME':
			if($rules['rules_exclude_home']) {
				return false;
			} else if($rules['rules_home_instances'] && (in_array($wpInsertPostInstance, split(',', $rules['rules_home_instances'])))) {
				return false;
			}
			break;
		case 'ARCHIVE':
			if($rules['rules_exclude_archives']) {
				return false;
			} else if($rules['rules_archives_instances'] && (in_array($wpInsertPostInstance, split(',', $rules['rules_archives_instances'])))) {
				return false;
			}
			break;
		case 'CATEGORY':
			if($rules['rules_exclude_categories']) {
				return false;
			} else if($rules['rules_categories_exceptions'] && (in_array($page_details['ID'], split(',', $rules['rules_categories_exceptions'])))) {
				return false;
			} else if($rules['rules_categories_instances'] && (in_array($wpInsertPostInstance, split(',', $rules['rules_categories_instances'])))) {
				return false;
			}
			break;
		case 'SEARCH':
			if($rules['rules_exclude_search']) {
				return false;
			} else if($rules['rules_search_instances'] && (in_array($wpInsertPostInstance, split(',', $rules['rules_search_instances'])))) {
				return false;
			}
			break;
		case 'PAGE':
			if($rules['rules_exclude_page']) {
				return false;
			} else if($rules['rules_page_exceptions'] && (in_array($page_details['ID'], split(',', $rules['rules_page_exceptions'])))) {
				return false;
			}
			break;
		case 'POST':
			if($rules['rules_exclude_post']) {
				return false;
			} else if($rules['rules_post_exceptions'] && (in_array($page_details['ID'], split(',', $rules['rules_post_exceptions'])))) {
				return false;
			} else if($rules['rules_categories_post_exceptions'] && is_array($page_details['categories']) && (count(array_intersect(array_unique($page_details['categories']), array_unique(split(',', $rules['rules_categories_post_exceptions'])))) > 0)) {
				return false;
			}
			break;
		case 'CUSTOM':
			if($rules['rules_exclude_cpt_'.$page_details['type_name']]) {
				return false;
			}
			break;
	}
	return true;
}
?>