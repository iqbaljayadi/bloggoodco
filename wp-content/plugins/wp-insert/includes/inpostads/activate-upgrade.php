<?php
add_action('wp_insert_activate_upgrade', 'wp_insert_inpostads_activate_upgrade');
function wp_insert_inpostads_activate_upgrade() {
	if(!get_option('wp_insert_inpostads_options')) {
		$values = array(
			'above' => array(
				'status' => '',
				'ad_code_1' => '',
				'ad_code_2' => '',
				'ad_code_3' => '',
				'country_1' => '',
				'country_code_1' => '',
				'rules_exclude_home' => '',
				'rules_home_instances' => '',
				'rules_exclude_archives' => '',
				'rules_archives_instances' => '',
				'rules_exclude_categories' => '',
				'rules_categories_instances' => '',
				'rules_categories_exceptions' => '',
				'rules_exclude_search' => '',
				'rules_search_instances' => '',
				'rules_exclude_page' => '',
				'rules_page_exceptions' => '',
				'rules_exclude_post' => '',
				'rules_post_exceptions' => '',
				'styles' => 'margin: 5px; padding: 0px;',
			),
			'middle' => array(
				'status' => '',
				'ad_code_1' => '',
				'ad_code_2' => '',
				'ad_code_3' => '',
				'country_1' => '',
				'country_code_1' => '',
				'rules_exclude_home' => '',
				'rules_home_instances' => '',
				'rules_exclude_archives' => '',
				'rules_archives_instances' => '',
				'rules_exclude_categories' => '',
				'rules_categories_instances' => '',
				'rules_categories_exceptions' => '',
				'rules_exclude_search' => '',
				'rules_search_instances' => '',
				'rules_exclude_page' => '',
				'rules_page_exceptions' => '',
				'rules_exclude_post' => '',
				'rules_post_exceptions' => '',
				'styles' => 'margin: 5px; padding: 0px;',
				'minimum_character_count' => '500',
				'paragraph_buffer_count' => '',
			),
			'below' => array(
				'status' => '',
				'ad_code_1' => '',
				'ad_code_2' => '',
				'ad_code_3' => '',
				'country_1' => '',
				'country_code_1' => '',
				'rules_exclude_home' => '',
				'rules_home_instances' => '',
				'rules_exclude_archives' => '',
				'rules_archives_instances' => '',
				'rules_exclude_categories' => '',
				'rules_categories_instances' => '',
				'rules_categories_exceptions' => '',
				'rules_exclude_search' => '',
				'rules_search_instances' => '',
				'rules_exclude_page' => '',
				'rules_page_exceptions' => '',
				'rules_exclude_post' => '',
				'rules_post_exceptions' => '',
				'styles' => 'margin: 5px; padding: 0px;',
			),
			'left' => array(
				'status' => '',
				'ad_code_1' => '',
				'ad_code_2' => '',
				'ad_code_3' => '',
				'country_1' => '',
				'country_code_1' => '',
				'rules_exclude_home' => '',
				'rules_home_instances' => '',
				'rules_exclude_archives' => '',
				'rules_archives_instances' => '',
				'rules_exclude_categories' => '',
				'rules_categories_instances' => '',
				'rules_categories_exceptions' => '',
				'rules_exclude_search' => '',
				'rules_search_instances' => '',
				'rules_exclude_page' => '',
				'rules_page_exceptions' => '',
				'rules_exclude_post' => '',
				'rules_post_exceptions' => '',
				'styles' => 'margin: 5px; padding: 0px;',
			),
			'right' => array(
				'status' => '',
				'ad_code_1' => '',
				'ad_code_2' => '',
				'ad_code_3' => '',
				'country_1' => '',
				'country_code_1' => '',
				'rules_exclude_home' => '',
				'rules_home_instances' => '',
				'rules_exclude_archives' => '',
				'rules_archives_instances' => '',
				'rules_exclude_categories' => '',
				'rules_categories_instances' => '',
				'rules_categories_exceptions' => '',
				'rules_exclude_search' => '',
				'rules_search_instances' => '',
				'rules_exclude_page' => '',
				'rules_page_exceptions' => '',
				'rules_exclude_post' => '',
				'rules_post_exceptions' => '',
				'styles' => 'margin: 5px; padding: 0px;',
			),
		);
		$values = wp_insert_inpostads_upgrade_from_1x($values);
		update_option('wp_insert_inpostads_options', $values);
	}
}

function wp_insert_inpostads_upgrade_from_1x($values) {
	$val = wp_insert_read_and_destroy_old_option('wp_insert_in_post_ad_top_1_enable');
	$values['above']['status'] = ($val == null)?$values['above']['status']:$val;
	$val = wp_insert_read_and_destroy_old_option('wp_insert_in_post_ad_top_1_content');
	$values['above']['ad_code_1'] = ($val == null)?$values['above']['ad_code_1']:$val;
	$val = wp_insert_read_and_destroy_old_option('wp_insert_in_post_ad_top_1_content_1');
	$values['above']['ad_code_2'] = ($val == null)?$values['above']['ad_code_2']:$val;
	$val = wp_insert_read_and_destroy_old_option('wp_insert_in_post_ad_top_1_content_2');
	$values['above']['ad_code_3'] = ($val == null)?$values['above']['ad_code_3']:$val;
	$val = wp_insert_read_and_destroy_old_option('wp_insert_in_post_ad_top_1_exclude_ids');
	$values['above']['rules_exclude_page'] = ($val == null)?$values['above']['rules_exclude_page']:$val;
	$values['above']['rules_exclude_page'] = ($val == null)?$values['above']['rules_exclude_page']:$val;
	$val = wp_insert_read_and_destroy_old_option('wp_insert_in_post_ad_top_1_exclude_home');
	$values['above']['rules_exclude_home'] = ($val == null)?$values['above']['rules_exclude_home']:$val;
	$val = wp_insert_read_and_destroy_old_option('wp_insert_in_post_ad_top_1_exclude_archives');
	$values['above']['rules_exclude_archives'] = ($val == null)?$values['above']['rules_exclude_archives']:$val;
	$val = wp_insert_read_and_destroy_old_option('wp_insert_in_post_ad_top_1_style');
	$values['above']['styles'] = ($val == null)?$values['above']['styles']:$val;
	
	$val = wp_insert_read_and_destroy_old_option('wp_insert_in_post_ad_middle_1_enable');
	$values['middle']['status'] = ($val == null)?$values['middle']['status']:$val;
	$val = wp_insert_read_and_destroy_old_option('wp_insert_in_post_ad_middle_1_content');
	$values['middle']['ad_code_1'] = ($val == null)?$values['middle']['ad_code_1']:$val;
	$val = wp_insert_read_and_destroy_old_option('wp_insert_in_post_ad_middle_1_content_1');
	$values['middle']['ad_code_2'] = ($val == null)?$values['middle']['ad_code_2']:$val;
	$val = wp_insert_read_and_destroy_old_option('wp_insert_in_post_ad_middle_1_content_2');
	$values['middle']['ad_code_3'] = ($val == null)?$values['middle']['ad_code_3']:$val;
	$val = wp_insert_read_and_destroy_old_option('wp_insert_in_post_ad_middle_1_exclude_ids');
	$values['middle']['rules_exclude_page'] = ($val == null)?$values['middle']['rules_exclude_page']:$val;
	$values['middle']['rules_exclude_page'] = ($val == null)?$values['middle']['rules_exclude_page']:$val;
	$val = wp_insert_read_and_destroy_old_option('wp_insert_in_post_ad_middle_1_exclude_home');
	$values['middle']['rules_exclude_home'] = ($val == null)?$values['middle']['rules_exclude_home']:$val;
	$val = wp_insert_read_and_destroy_old_option('wp_insert_in_post_ad_middle_1_exclude_archives');
	$values['middle']['rules_exclude_archives'] = ($val == null)?$values['middle']['rules_exclude_archives']:$val;
	$val = wp_insert_read_and_destroy_old_option('wp_insert_in_post_ad_middle_1_style');
	$values['middle']['styles'] = ($val == null)?$values['middle']['styles']:$val;
	
	$val = wp_insert_read_and_destroy_old_option('wp_insert_in_post_ad_bottom_1_enable');
	$values['below']['status'] = ($val == null)?$values['below']['status']:$val;
	$val = wp_insert_read_and_destroy_old_option('wp_insert_in_post_ad_bottom_1_content');
	$values['below']['ad_code_1'] = ($val == null)?$values['below']['ad_code_1']:$val;
	$val = wp_insert_read_and_destroy_old_option('wp_insert_in_post_ad_bottom_1_content_1');
	$values['below']['ad_code_2'] = ($val == null)?$values['below']['ad_code_2']:$val;
	$val = wp_insert_read_and_destroy_old_option('wp_insert_in_post_ad_bottom_1_content_2');
	$values['below']['ad_code_3'] = ($val == null)?$values['below']['ad_code_3']:$val;
	$val = wp_insert_read_and_destroy_old_option('wp_insert_in_post_ad_bottom_1_exclude_ids');
	$values['below']['rules_exclude_page'] = ($val == null)?$values['below']['rules_exclude_page']:$val;
	$values['below']['rules_exclude_page'] = ($val == null)?$values['below']['rules_exclude_page']:$val;
	$val = wp_insert_read_and_destroy_old_option('wp_insert_in_post_ad_bottom_1_exclude_home');
	$values['below']['rules_exclude_home'] = ($val == null)?$values['below']['rules_exclude_home']:$val;
	$val = wp_insert_read_and_destroy_old_option('wp_insert_in_post_ad_bottom_1_exclude_archives');
	$values['below']['rules_exclude_archives'] = ($val == null)?$values['below']['rules_exclude_archives']:$val;
	$val = wp_insert_read_and_destroy_old_option('wp_insert_in_post_ad_bottom_1_style');
	$values['below']['styles'] = ($val == null)?$values['below']['styles']:$val;
	
	$val = wp_insert_read_and_destroy_old_option('wp_insert_in_post_ad_left_1_enable');
	$values['left']['status'] = ($val == null)?$values['left']['status']:$val;
	$val = wp_insert_read_and_destroy_old_option('wp_insert_in_post_ad_left_1_content');
	$values['left']['ad_code_1'] = ($val == null)?$values['left']['ad_code_1']:$val;
	$val = wp_insert_read_and_destroy_old_option('wp_insert_in_post_ad_left_1_content_1');
	$values['left']['ad_code_2'] = ($val == null)?$values['left']['ad_code_2']:$val;
	$val = wp_insert_read_and_destroy_old_option('wp_insert_in_post_ad_left_1_content_2');
	$values['left']['ad_code_3'] = ($val == null)?$values['left']['ad_code_3']:$val;
	$val = wp_insert_read_and_destroy_old_option('wp_insert_in_post_ad_left_1_exclude_ids');
	$values['left']['rules_exclude_page'] = ($val == null)?$values['left']['rules_exclude_page']:$val;
	$values['left']['rules_exclude_page'] = ($val == null)?$values['left']['rules_exclude_page']:$val;
	$val = wp_insert_read_and_destroy_old_option('wp_insert_in_post_ad_left_1_exclude_home');
	$values['left']['rules_exclude_home'] = ($val == null)?$values['left']['rules_exclude_home']:$val;
	$val = wp_insert_read_and_destroy_old_option('wp_insert_in_post_ad_left_1_exclude_archives');
	$values['left']['rules_exclude_archives'] = ($val == null)?$values['left']['rules_exclude_archives']:$val;
	$val = wp_insert_read_and_destroy_old_option('wp_insert_in_post_ad_left_1_style');
	$values['left']['styles'] = ($val == null)?$values['left']['styles']:$val;
	
	$val = wp_insert_read_and_destroy_old_option('wp_insert_in_post_ad_right_1_enable');
	$values['right']['status'] = ($val == null)?$values['right']['status']:$val;
	$val = wp_insert_read_and_destroy_old_option('wp_insert_in_post_ad_right_1_content');
	$values['right']['ad_code_1'] = ($val == null)?$values['right']['ad_code_1']:$val;
	$val = wp_insert_read_and_destroy_old_option('wp_insert_in_post_ad_right_1_content_1');
	$values['right']['ad_code_2'] = ($val == null)?$values['right']['ad_code_2']:$val;
	$val = wp_insert_read_and_destroy_old_option('wp_insert_in_post_ad_right_1_content_2');
	$values['right']['ad_code_3'] = ($val == null)?$values['right']['ad_code_3']:$val;
	$val = wp_insert_read_and_destroy_old_option('wp_insert_in_post_ad_right_1_exclude_ids');
	$values['right']['rules_exclude_page'] = ($val == null)?$values['right']['rules_exclude_page']:$val;
	$values['right']['rules_exclude_page'] = ($val == null)?$values['right']['rules_exclude_page']:$val;
	$val = wp_insert_read_and_destroy_old_option('wp_insert_in_post_ad_right_1_exclude_home');
	$values['right']['rules_exclude_home'] = ($val == null)?$values['right']['rules_exclude_home']:$val;
	$val = wp_insert_read_and_destroy_old_option('wp_insert_in_post_ad_right_1_exclude_archives');
	$values['right']['rules_exclude_archives'] = ($val == null)?$values['right']['rules_exclude_archives']:$val;
	$val = wp_insert_read_and_destroy_old_option('wp_insert_in_post_ad_right_1_style');
	$values['right']['styles'] = ($val == null)?$values['right']['styles']:$val;
	return $values;
}
?>