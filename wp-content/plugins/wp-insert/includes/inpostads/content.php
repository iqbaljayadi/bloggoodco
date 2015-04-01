<?php
add_filter('the_content', 'wp_insert_inpostads_filter_the_content', 100);
function wp_insert_inpostads_filter_the_content($content) {
	global $wpInsertAdInstance;
	global $wpInsertGeoLocation;
	$options = get_option('wp_insert_inpostads_options');

	if(wp_insert_get_ad_status($options['middle'])) {
		$paragraphs = explode('/p>', $content);
		$paragraphCount = 0;
		if(is_array($paragraphs)) {
			foreach($paragraphs as $paragraph) {
				if(strlen($paragraph) > 1) {
					$paragraphCount++;
				}
			}
		}
		if($paragraphCount > 1) {
			if(($options['middle']['minimum_character_count'] == 0) || ($options['middle']['minimum_character_count'] == '')) {
				if(($options['middle']['paragraph_buffer_count'] == 0) || ($options['middle']['paragraph_buffer_count'] == '')) {
					$position = wp_insert_inpostads_get_middle_position('/p>', $content, round($paragraphCount / 2));
				} else {					
					$position = wp_insert_inpostads_get_middle_position('/p>', $content, $options['middle']['paragraph_buffer_count']);
				}
				if($position) {
					if(($options['middle']['country_1'] != '') && ($wpInsertGeoLocation != '') && (in_array($wpInsertGeoLocation, split(',', $options['middle']['country_1'])))) {
						$content = substr_replace($content, '/p>'.'<div class="wpInsert wpInsertInPostAd wpInsertMiddle"'.(($options['middle']['styles'] != '')?' style="'.$options['middle']['styles'].'"':'').'>'.do_shortcode($options['middle']['country_code_1']).'</div>', $position, 3);
					} else {
						$content = substr_replace($content, '/p>'.'<div class="wpInsert wpInsertInPostAd wpInsertMiddle"'.(($options['middle']['styles'] != '')?' style="'.$options['middle']['styles'].'"':'').'>'.do_shortcode($options['middle']['ad_code_'.$wpInsertAdInstance]).'</div>', $position, 3);
					}
				}
			} else {
				if(strlen(strip_tags($content)) > $options['middle']['minimum_character_count']) {
					if(($options['middle']['paragraph_buffer_count'] == 0) || ($options['middle']['paragraph_buffer_count'] == '')) {
						$position = wp_insert_inpostads_get_middle_position('/p>', $content, round($paragraphCount / 2));
					} else {					
						$position = wp_insert_inpostads_get_middle_position('/p>', $content, $options['middle']['paragraph_buffer_count']);
					}
					if($position) {
						if(($options['middle']['country_1'] != '') && ($wpInsertGeoLocation != '') && (in_array($wpInsertGeoLocation, split(',', $options['middle']['country_1'])))) {
							$content = substr_replace($content, '/p>'.'<div class="wpInsert wpInsertInPostAd wpInsertMiddle"'.(($options['middle']['styles'] != '')?' style="'.$options['middle']['styles'].'"':'').'>'.do_shortcode($options['middle']['country_code_1']).'</div>', $position, 3);
						} else {
							$content = substr_replace($content, '/p>'.'<div class="wpInsert wpInsertInPostAd wpInsertMiddle"'.(($options['middle']['styles'] != '')?' style="'.$options['middle']['styles'].'"':'').'>'.do_shortcode($options['middle']['ad_code_'.$wpInsertAdInstance]).'</div>', $position, 3);
						}
					}
				}
			}
		}
	}
	if(wp_insert_get_ad_status($options['left'])) {
		if(($options['left']['country_1'] != '') && ($wpInsertGeoLocation != '') && (in_array($wpInsertGeoLocation, split(',', $options['left']['country_1'])))) {
			$content = '<div class="wpInsert wpInsertInPostAd wpInsertLeft" style="float: left; '.(($options['left']['styles'] != '')?$options['left']['styles']:'').'">'.do_shortcode($options['left']['country_code_1']).'</div>'.$content;
		} else {
			$content = '<div class="wpInsert wpInsertInPostAd wpInsertLeft" style="float: left; '.(($options['left']['styles'] != '')?$options['left']['styles']:'').'">'.do_shortcode($options['left']['ad_code_'.$wpInsertAdInstance]).'</div>'.$content;
		}
	}
	if(wp_insert_get_ad_status($options['right'])) {
		if(($options['right']['country_1'] != '') && ($wpInsertGeoLocation != '') && (in_array($wpInsertGeoLocation, split(',', $options['right']['country_1'])))) {
			$content = '<div class="wpInsert wpInsertInPostAd wpInsertRight" style="float: right; '.(($options['right']['styles'] != '')?$options['right']['styles']:'').'">'.do_shortcode($options['right']['country_code_1']).'</div>'.$content;
		} else {
			$content = '<div class="wpInsert wpInsertInPostAd wpInsertRight" style="float: right; '.(($options['right']['styles'] != '')?$options['right']['styles']:'').'">'.do_shortcode($options['right']['ad_code_'.$wpInsertAdInstance]).'</div>'.$content;
		}
	}
	if(wp_insert_get_ad_status($options['above'])) {
		if(($options['above']['country_1'] != '') && ($wpInsertGeoLocation != '') && (in_array($wpInsertGeoLocation, split(',', $options['above']['country_1'])))) {
			$content = '<div class="wpInsert wpInsertInPostAd wpInsertAbove"'.(($options['above']['styles'] != '')?' style="'.$options['above']['styles'].'"':'').'>'.do_shortcode($options['above']['country_code_1']).'</div>'.$content;
		} else {
			$content = '<div class="wpInsert wpInsertInPostAd wpInsertAbove"'.(($options['above']['styles'] != '')?' style="'.$options['above']['styles'].'"':'').'>'.do_shortcode($options['above']['ad_code_'.$wpInsertAdInstance]).'</div>'.$content;
		}
	}
	if(wp_insert_get_ad_status($options['below'])) {
		if(($options['below']['country_1'] != '') && ($wpInsertGeoLocation != '') && (in_array($wpInsertGeoLocation, split(',', $options['below']['country_1'])))) {
			$content = $content.'<div class="wpInsert wpInsertInPostAd wpInsertBelow"'.(($options['below']['styles'] != '')?' style="'.$options['below']['styles'].'"':'').'>'.do_shortcode($options['below']['country_code_1']).'</div>';
		} else {
			$content = $content.'<div class="wpInsert wpInsertInPostAd wpInsertBelow"'.(($options['below']['styles'] != '')?' style="'.$options['below']['styles'].'"':'').'>'.do_shortcode($options['below']['ad_code_'.$wpInsertAdInstance]).'</div>';
		}
	}
	return $content;
}

function wp_insert_inpostads_get_middle_position($search, $string, $offset) {
    $arr = explode($search, $string);
    switch($offset) {
        case $offset == 0:
			return false;
			break;
        case $offset > max(array_keys($arr)):
			return false;
			break;
        default:
			return strlen(implode($search, array_slice($arr, 0, $offset)));
			break;
    }
}
?>