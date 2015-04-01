<?php
add_action('wp_insert_activate_upgrade', 'wp_insert_multiple_network_activate_upgrade');
function wp_insert_multiple_network_activate_upgrade() {
	if(!get_option('wp_insert_multiple_network_status')) {
		$value = '1';
		$value = wp_insert_multiple_network_upgrade_from_1x($value);
		update_option('wp_insert_multiple_network_status', $value);
	}
}

function wp_insert_multiple_network_upgrade_from_1x($value) {
	$val = wp_insert_read_and_destroy_old_option('wp_insert_multiple_ad_network_type');
	if($val != null) {
		switch($val) {
			case 'Primary Ad Network Only':
				$value = '1';
				break;
			case 'Primary and Alternate Ad Network 1':
				$value = '2';
				break;
			case 'All Ad Networks':
				$value = '3';
				break;
		}
	}
	return $value;
}
?>