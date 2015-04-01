<?php
add_action('wp_insert_activate_upgrade', 'wp_insert_templateads_activate_upgrade');
function wp_insert_templateads_activate_upgrade() {
	if(!get_option('wp_insert_templateads_options')) {
		$values = array();
		for($i = 1; $i <= 10; $i++) {
			$values['templateads-'.$i] = array(
				'status' => '',
				'ad_code_1' => '',
				'ad_code_2' => '',
				'ad_code_3' => '',
				'country_1' => '',
				'country_code_1' => '',
				'rules_exclude_home' => '',
				'rules_exclude_archives' => '',
				'rules_exclude_categories' => '',
				'rules_categories_exceptions' => '',
				'rules_exclude_search' => '',
				'rules_exclude_page' => '',
				'rules_page_exceptions' => '',
				'rules_exclude_post' => '',
				'rules_post_exceptions' => '',
				'styles' => 'margin: 5px; padding: 0px;',
			);
		}
		$values = wp_insert_templateads_upgrade_from_1x($values, 1);
		update_option('wp_insert_templateads_options', $values);
	}
	
	if(!get_option('wp_insert_more_templateads_options')) {
		$values = array();
		for($i = 11; $i <= 20; $i++) {
			$values['templateads-'.$i] = array(
				'status' => '',
				'ad_code_1' => '',
				'ad_code_2' => '',
				'ad_code_3' => '',
				'country_1' => '',
				'country_code_1' => '',
				'rules_exclude_home' => '',
				'rules_exclude_archives' => '',
				'rules_exclude_categories' => '',
				'rules_categories_exceptions' => '',
				'rules_exclude_search' => '',
				'rules_exclude_page' => '',
				'rules_page_exceptions' => '',
				'rules_exclude_post' => '',
				'rules_post_exceptions' => '',
				'styles' => 'margin: 5px; padding: 0px;',
			);
		}
		$values = wp_insert_templateads_upgrade_from_1x($values, 11);
		update_option('wp_insert_more_templateads_options', $values);
	}
}

function wp_insert_templateads_upgrade_from_1x($values, $group) {
	for($i = $group; $i < ($group + 10); $i++) {
		$val = wp_insert_read_and_destroy_old_option('wp_insert_template_ad_'.$i.'_enable');
		$values['templateads-'.$i]['status'] = ($val == null)?$values['templateads-'.$i]['status']:$val;
		$val = wp_insert_read_and_destroy_old_option('wp_insert_template_ad_'.$i.'_content');
		$values['templateads-'.$i]['ad_code_1'] = ($val == null)?$values['templateads-'.$i]['ad_code_1']:$val;
		$val = wp_insert_read_and_destroy_old_option('wp_insert_template_ad_'.$i.'_content_1');
		$values['templateads-'.$i]['ad_code_2'] = ($val == null)?$values['templateads-'.$i]['ad_code_2']:$val;
		$val = wp_insert_read_and_destroy_old_option('wp_insert_template_ad_'.$i.'_content_2');
		$values['templateads-'.$i]['ad_code_3'] = ($val == null)?$values['templateads-'.$i]['ad_code_3']:$val;
		$val = wp_insert_read_and_destroy_old_option('wp_insert_template_ad_'.$i.'_exclude_ids');
		$values['templateads-'.$i]['rules_exclude_page'] = ($val == null)?$values['templateads-'.$i]['rules_exclude_page']:$val;
		$values['templateads-'.$i]['rules_exclude_page'] = ($val == null)?$values['templateads-'.$i]['rules_exclude_page']:$val;
		$val = wp_insert_read_and_destroy_old_option('wp_insert_template_ad_'.$i.'_exclude_home');
		$values['templateads-'.$i]['rules_exclude_home'] = ($val == null)?$values['templateads-'.$i]['rules_exclude_home']:$val;
		$val = wp_insert_read_and_destroy_old_option('wp_insert_template_ad_'.$i.'_exclude_archives');
		$values['templateads-'.$i]['rules_exclude_archives'] = ($val == null)?$values['templateads-'.$i]['rules_exclude_archives']:$val;
		$val = wp_insert_read_and_destroy_old_option('wp_insert_template_ad_'.$i.'_style');
		$values['templateads-'.$i]['styles'] = ($val == null)?$values['templateads-'.$i]['styles']:$val;
	}
	return $values;
}
?>