<?php
add_action('wp_insert_activate_upgrade', 'wp_insert_tracking_codes_activate_upgrade');
function wp_insert_tracking_codes_activate_upgrade() {
	if(!get_option('wp_insert_tracking_codes_options')) {
		$values = array(
			'analytics' => array(
				'status' => '',
				'code' => ''
			),
			'header' => array(
				'status' => '',
				'code' => ''
			),
			'footer' => array(
				'status' => '',
				'code' => ''
			)
		);
		$values = wp_insert_tracking_codes_upgrade_from_1x($values);
		update_option('wp_insert_tracking_codes_options', $values);
	}
}

function wp_insert_tracking_codes_upgrade_from_1x($values) {
	$val = wp_insert_read_and_destroy_old_option('smart_analytics_enabled');
	$values['analytics']['status'] = ($val == null)?$values['analytics']['status']:$val;
	$val = wp_insert_read_and_destroy_old_option('smart_analytics_id');
	$values['analytics']['code'] = ($val == null)?$values['analytics']['code']:$val;
	
	$val = wp_insert_read_and_destroy_old_option('smart_analytics_header_enabled');
	$values['header']['status'] = ($val == null)?$values['header']['status']:$val;
	$val = wp_insert_read_and_destroy_old_option('smart_analytics_header_code');
	$values['header']['code'] = ($val == null)?$values['header']['code']:$val;
	
	$val = wp_insert_read_and_destroy_old_option('smart_analytics_footer_enabled');
	$values['footer']['status'] = ($val == null)?$values['footer']['status']:$val;
	$val = wp_insert_read_and_destroy_old_option('smart_analytics_footer_code');
	$values['footer']['code'] = ($val == null)?$values['footer']['code']:$val;
	return $values;
}
?>