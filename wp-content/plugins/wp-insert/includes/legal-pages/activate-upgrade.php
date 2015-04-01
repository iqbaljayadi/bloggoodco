<?php
add_action('wp_insert_activate_upgrade', 'wp_insert_legal_activate_upgrade');
function wp_insert_legal_activate_upgrade() {
	if(!get_option('wp_insert_legal_options')) {
		$values = array(
			'privacy-policy' => array(
				'content' => wp_insert_legal_get_default_privacy_policy(),
				'pages' => ''
			),
			'terms-and-conditions' => array(
				'content' => wp_insert_legal_get_default_terms_and_conditions(),
				'pages' => ''
			),
			'disclaimer' => array(
				'content' => wp_insert_legal_get_default_disclaimer(),
				'pages' => ''
			),
			'copyright-notice' => array(
				'content' => wp_insert_legal_get_default_copyright_notice(),
				'pages' => ''
			)
		);
		$values = wp_insert_legal_upgrade_from_1x($values);
		update_option('wp_insert_legal_options', $values);
	}
}

function wp_insert_legal_upgrade_from_1x($values) {
	$val = wp_insert_read_and_destroy_old_option('wp_insert_privacy_policy_content');
	$values['privacy-policy']['content'] = ($val == null)?$values['privacy-policy']['content']:$val;
	$val = wp_insert_read_and_destroy_old_option('wp_insert_terms_conditions_content');
	$values['terms-and-conditions']['content'] = ($val == null)?$values['terms-and-conditions']['content']:$val;
	return $values;
}
?>