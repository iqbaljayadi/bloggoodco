<?php
add_action('wp_head', 'wp_insert_tracking_codes_wp_head');
function wp_insert_tracking_codes_wp_head() {
	$options = get_option('wp_insert_tracking_codes_options');
	$header = wp_insert_sanitize_array($options['header'], array('status', 'code'));
	if($header['status']) {
		echo $header['code'];
	}
}

add_action('wp_footer', 'wp_insert_tracking_codes_wp_footer');
function wp_insert_tracking_codes_wp_footer() {
	$options = get_option('wp_insert_tracking_codes_options');
	$analytics = wp_insert_sanitize_array($options['analytics'], array('status', 'code'));
	if($analytics['status'] && ($analytics['code'] != '')) {
		echo '<script type="text/javascript">';
			echo 'var gaJsHost = (("https:" == document.location.protocol) ? "https://ssl." : "http://www.");';
			echo 'document.write(unescape("%3Cscript src=\'" + gaJsHost + "google-analytics.com/ga.js\' type=\'text/javascript\'%3E%3C/script%3E"));';
		echo '</script>';
		echo '<script type="text/javascript">';
			echo 'var pageTracker = _gat._getTracker("'.$analytics['code'].'");';
			echo 'pageTracker._trackPageview();';
		echo '</script>';
	}
	$footer = wp_insert_sanitize_array($options['footer'], array('status', 'code'));
	if($footer['status']) {
		echo $footer['code'];
	}
}
?>