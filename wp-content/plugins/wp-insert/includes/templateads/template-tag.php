<?php
function wp_template_ad($instance) {
	global $wpInsertAdInstance;
	global $wpInsertGeoLocation;
	if($instance <= 10) {
		$options = get_option('wp_insert_templateads_options');
	} else {
		$options = get_option('wp_insert_more_templateads_options');
	}
	if(wp_insert_get_ad_status($options['templateads-'.$instance])) {
		if(($options['templateads-'.$instance]['country_1'] != '') && ($wpInsertGeoLocation != '') && (in_array($wpInsertGeoLocation, split(',', $options['templateads-'.$instance]['country_1'])))) {
			echo '<div class="wpInsert wpInsertTemplateTag"'.(($options['templateads-'.$instance]['styles'] != '')?' style="'.$options['templateads-'.$instance]['styles'].'"':'').'>'.do_shortcode($options['templateads-'.$instance]['country_code_1']).'</div>';
		} else {
			echo '<div class="wpInsert wpInsertTemplateTag"'.(($options['templateads-'.$instance]['styles'] != '')?' style="'.$options['templateads-'.$instance]['styles'].'"':'').'>'.do_shortcode($options['templateads-'.$instance]['ad_code_'.$wpInsertAdInstance]).'</div>';
		}
	}
}
?>