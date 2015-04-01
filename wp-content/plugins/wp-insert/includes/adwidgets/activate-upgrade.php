<?php
add_action('wp_insert_activate_upgrade', 'wp_insert_adwidgets_activate_upgrade');
function wp_insert_adwidgets_activate_upgrade() {
	if(!get_option('wp_insert_adwidgets_options')) {
		$values = array();
		for($i = 1; $i <= 10; $i++) {
			$values['adwidgets-'.$i] = array(
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
		$values = wp_insert_adwidgets_upgrade_from_1x($values);
		update_option('wp_insert_adwidgets_options', $values);
	}
	
	if(!get_option('wp_insert_more_adwidgets_options')) {
		$values = array();
		for($i = 11; $i <= 20; $i++) {
			$values['adwidgets-'.$i] = array(
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
		update_option('wp_insert_more_adwidgets_options', $values);
	}
}

function wp_insert_adwidgets_upgrade_from_1x($values) {
	for($i = 1; $i <= 10; $i++) {
		wp_insert_read_and_destroy_old_option('wp_insert_ad_widget_'.$i.'_title');
		$val = wp_insert_read_and_destroy_old_option('wp_insert_ad_widget_'.$i.'_enable');
		$values['adwidgets-'.$i]['status'] = ($val == null)?$values['adwidgets-'.$i]['status']:$val;
		$val = wp_insert_read_and_destroy_old_option('wp_insert_ad_widget_'.$i.'_content');
		$values['adwidgets-'.$i]['ad_code_1'] = ($val == null)?$values['adwidgets-'.$i]['ad_code_1']:$val;
		$val = wp_insert_read_and_destroy_old_option('wp_insert_ad_widget_'.$i.'_content_1');
		$values['adwidgets-'.$i]['ad_code_2'] = ($val == null)?$values['adwidgets-'.$i]['ad_code_2']:$val;
		$val = wp_insert_read_and_destroy_old_option('wp_insert_ad_widget_'.$i.'_content_2');
		$values['adwidgets-'.$i]['ad_code_3'] = ($val == null)?$values['adwidgets-'.$i]['ad_code_3']:$val;
		$val = wp_insert_read_and_destroy_old_option('wp_insert_ad_widget_'.$i.'_exclude_ids');
		$values['adwidgets-'.$i]['rules_exclude_page'] = ($val == null)?$values['adwidgets-'.$i]['rules_exclude_page']:$val;
		$values['adwidgets-'.$i]['rules_exclude_page'] = ($val == null)?$values['adwidgets-'.$i]['rules_exclude_page']:$val;
		$val = wp_insert_read_and_destroy_old_option('wp_insert_ad_widget_'.$i.'_exclude_home');
		$values['adwidgets-'.$i]['rules_exclude_home'] = ($val == null)?$values['adwidgets-'.$i]['rules_exclude_home']:$val;
		$val = wp_insert_read_and_destroy_old_option('wp_insert_ad_widget_'.$i.'_exclude_archives');
		$values['adwidgets-'.$i]['rules_exclude_archives'] = ($val == null)?$values['adwidgets-'.$i]['rules_exclude_archives']:$val;
		$val = wp_insert_read_and_destroy_old_option('wp_insert_ad_widget_'.$i.'_style');
		$values['adwidgets-'.$i]['styles'] = ($val == null)?$values['adwidgets-'.$i]['styles']:$val;
	}
	return $values;
}
?>