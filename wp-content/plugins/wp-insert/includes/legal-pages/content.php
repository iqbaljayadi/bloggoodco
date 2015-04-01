<?php
add_filter('the_content', 'wp_insert_legal_filter_the_content');
function wp_insert_legal_filter_the_content($content) {
	$options = get_option('wp_insert_legal_options');
	$page_details = wp_insert_get_page_details();
	if(in_array($page_details['ID'], explode(',', $options['privacy-policy']['pages']))) {
		return $options['privacy-policy']['content'];
	} else if(in_array($page_details['ID'], explode(',', $options['terms-and-conditions']['pages']))) {
		return $options['terms-and-conditions']['content'];
	} if(in_array($page_details['ID'], explode(',', $options['disclaimer']['pages']))) {
		return $options['disclaimer']['content'];
	} if(in_array($page_details['ID'], explode(',', $options['copyright-notice']['pages']))) {
		return $options['copyright-notice']['content'];
	}
	return $content;
}

add_shortcode('sitename', 'wp_insert_legal_shortcode_sitename');
function wp_insert_legal_shortcode_sitename($atts) {
	return '<i>'.get_bloginfo('name').'</i>';
}

/*Legacy Support*/
add_shortcode('Privacy', 'wp_insert_legal_shortcode_privacy');
function wp_insert_legal_shortcode_privacy($atts) {
	$options = get_option('wp_insert_legal_options');
	return do_shortcode($options['privacy-policy']['content']);
}

add_shortcode('Terms', 'wp_insert_legal_shortcode_terms');
function wp_insert_legal_shortcode_terms($atts) {
	$options = get_option('wp_insert_legal_options');
	return do_shortcode($options['terms-and-conditions']['content']);
}
?>