<?php
/*
Plugin Name: Social Analytics
Plugin URI: www.powerwp.com/wpsocialstats
Description: The best social analytics plugin to track the performance of your posts and webpages at Facebook, Twitter, Google+, Pinterest, Linkedin, Stumbleupon
Author: Powerwp
Version: 2.0.6
License: GPL2
*/

// Pre-2.6 compatibility. For the future needs
if (!defined('WP_CONTENT_URL')) {
	define('WP_CONTENT_URL', get_option('siteurl' . '/wp-content'));
}
if (!defined('WP_CONTENT_DIR')) {
	define('WP_CONTENT_DIR', ABSPATH . 'wp-content');
}
if (!defined('WP_PLUGIN_URL')) {
	define('WP_PLUGIN_URL', WP_CONTENT_URL. '/plugins');
}
if (!defined('WP_PLUGIN_DIR')) {
	define('WP_PLUGIN_DIR', WP_CONTENT_DIR . '/plugins');
}

//defines
define('SOCIAL_STATISTICS_PLUGIN_FILE', __FILE__ );
define('SOCIAL_STATISTICS_PLUGIN_URL', plugins_url("",__FILE__));
define('SOCIAL_STATISTICS_PLUGIN_DIR', dirname(__FILE__));
define('SOCIAL_STATISTICS_TRACKING_URL', "http://www.wpsocialstats.com/wp-admin/admin-ajax.php");

//includes
require( SOCIAL_STATISTICS_PLUGIN_DIR . "/includes/functions.php");
require( SOCIAL_STATISTICS_PLUGIN_DIR . "/includes/widgets.php");
require(SOCIAL_STATISTICS_PLUGIN_DIR . "/classes/social_stats_table.php");
require( SOCIAL_STATISTICS_PLUGIN_DIR . "/classes/social_stats_dashboard.php");

if(is_admin()){
	$social_stats_admin_menu_instance = new WP_Social_Stats_Dashboard();
}

require( SOCIAL_STATISTICS_PLUGIN_DIR . "/includes/admin.php");

function add_thumbnails_for_cpt() {

    global $_wp_theme_features;

    if( empty($_wp_theme_features['post-thumbnails']) ){
        $_wp_theme_features['post-thumbnails'] = array( array('post','page') );
    }
    elseif( true === $_wp_theme_features['post-thumbnails'])
        return;

    elseif( is_array($_wp_theme_features['post-thumbnails'][0]) )
        $_wp_theme_features['post-thumbnails'][0][] = array( array('post','page') );
}

add_action( 'after_setup_theme', 'add_thumbnails_for_cpt');
add_action('init', 'wordpress_social_stats_init');
add_action('admin_menu', 'wordpress_social_stats_admin_menu');

/* added by GenLEE Begin */
// add_action('wp_ajax_nopriv_phynuchs-casual-loop', 'phynuchs_casual_loop');
/* added by GenLEE End */
?>